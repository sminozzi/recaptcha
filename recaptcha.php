<?php /*
Plugin Name: reCAPTCHA For All
Description: Description: Protect ALL pages of your site against Spam and Hackers bots with reCAPTCHA Version 3.
Version: 1.04
Author: Bill Minozzi
Author URI: http://billminozzi.com
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
// Make sure the file is not directly accessible.
if (!defined('ABSPATH')) {
    die('We\'re sorry, but you can not directly access this file.');
}
// ob_start();
$recaptcha_for_all_plugin_data = get_file_data(__FILE__, array('Version' => 'Version'), false);
$recaptcha_for_all_plugin_version = $recaptcha_for_all_plugin_data['Version'];
$recaptcha_for_all_sitekey = trim(sanitize_text_field(get_option('recaptcha_for_all_sitekey', '')));
$recaptcha_for_all_secretkey = trim(sanitize_text_field(get_option('recaptcha_for_all_secretkey', '')));
// active?
$recaptcha_for_all_settings = trim(sanitize_text_field(get_option('recaptcha_for_all_settings', '')));
$recaptcha_for_all_recaptcha_score = trim(sanitize_text_field(get_option('recaptcha_for_all_recaptcha_score', '')));
define('RECAPTCHA_FOR_ALLVERSION', $recaptcha_for_all_plugin_version);
define('RECAPTCHA_FOR_ALLPATH', plugin_dir_path(__file__));
define('RECAPTCHA_FOR_ALLURL', plugin_dir_url(__file__));
$recaptcha_for_all_plugin = plugin_basename(__FILE__);

$recaptcha_for_all_visitor_ip = recaptcha_for_all_findip();
$recaptcha_for_all_visitor_ua = trim(recaptcha_for_all_get_ua());
$recaptcha_for_all_string_whitelist = implode(PHP_EOL, array_map('sanitize_textarea_field', explode(PHP_EOL, get_site_option('recaptcha_for_all_string_whitelist', ''))));
$arecaptcha_for_all_string_whitelist = explode(PHP_EOL, $recaptcha_for_all_string_whitelist);
$recaptcha_for_all_ip_whitelist = trim(get_site_option('recaptcha_for_all_ip_whitelist', ''));


$arecaptcha_for_all_ip_whitelist = explode(PHP_EOL, $recaptcha_for_all_ip_whitelist);


//$recaptcha_for_all_ip_whitelist = explode(PHP_EOL, $recaptcha_for_all_ip_whitelist);
for ($i = 0; $i < count($arecaptcha_for_all_ip_whitelist); $i++) {
    $arecaptcha_for_all_ip_whitelist[$i] = trim(sanitize_text_field($arecaptcha_for_all_ip_whitelist[$i]));
    if (!filter_var($arecaptcha_for_all_ip_whitelist[$i], FILTER_VALIDATE_IP))
        $arecaptcha_for_all_ip_whitelist[$i] = '';
}
$recaptcha_for_all_ip_whitelist = implode(PHP_EOL, $arecaptcha_for_all_ip_whitelist);

$recaptcha_for_all_background = trim(sanitize_text_field(get_option('recaptcha_for_all_background', 'yes')));


if (
    !isset($_COOKIE['recaptcha_cookie'])
    and !is_user_logged_in()
    and !recaptcha_for_all_maybe_search_engine()
    and !recaptcha_for_all_isourserver()
    and !recaptcha_for_all_is_ip_whitelisted($recaptcha_for_all_visitor_ip, $arecaptcha_for_all_ip_whitelist)
    and !recaptcha_for_all_is_string_whitelisted($recaptcha_for_all_visitor_ua, $arecaptcha_for_all_string_whitelist)
) {



    if (isset($_POST['token'])) {
        $token = sanitize_text_field($_POST['token']);
        $action = sanitize_text_field($_POST['action']);
        $response = (array)wp_remote_get(sprintf('https://www.recaptcha.net/recaptcha/api/siteverify?secret=%s&response=%s', $recaptcha_for_all_secretkey, $token));
        $recaptchaResponse = isset($response['body']) ? json_decode($response['body'], 1) : ['success' => false, 'error-codes' => ['general-fail']];
        //  (1.0 is very likely a good interaction, 0.0 is very likely a bot). 
        if (!$recaptchaResponse["success"]) {
            return;
        }
        $recaptcha_for_all_recaptcha_score = $recaptcha_for_all_recaptcha_score / 10;
        if ($recaptchaResponse["score"] < $recaptcha_for_all_recaptcha_score) {
            header('HTTP/1.1 403 Forbidden');
            header('Status: 403 Forbidden');
            header('Connection: Close');
            http_response_code(403);
            wp_die("Forbidden");
        }
        add_action('wp_enqueue_scripts', 'recaptcha_for_all_register_cookie', 1000);
        return;
    }

    add_action('wp_enqueue_scripts', 'recaptcha_for_all_add_scripts', 1000);
    add_action('wp_enqueue_scripts', 'recaptcha_for_all_enqueueScripts', 1000);
    
    if ($recaptcha_for_all_settings == 'yes') {
        if (!empty($recaptcha_for_all_sitekey) and !empty($recaptcha_for_all_secretkey))
            add_filter('template_include', 'recaptcha_for_all_page_template');
    }
}


if(!is_user_logged_in()) {
    $recaptcha_for_all_settings_china = trim(sanitize_text_field(get_option('recaptcha_for_all_settings_china', '')));
    if($recaptcha_for_all_settings_china == 'yes') {
        if(isset($_COOKIE['recaptcha_cookie'])) {
            $recaptcha_fingerprint = sanitize_text_field($_COOKIE['recaptcha_cookie']);
            if( !empty($recaptcha_fingerprint ))
            {
                if(strpos($recaptcha_fingerprint, 'Asia/Shanghai'  ) !== false
                or strpos($recaptcha_fingerprint, 'Asia/Hong_Kong') !== false
                or strpos($recaptcha_fingerprint, 'Asia/Macau') !== false )
                {
                    header('HTTP/1.1 403 Forbidden');
                    header('Status: 403 Forbidden');
                    header('Connection: Close');
                    http_response_code(403);
                    wp_die("Forbidden");
                }
            }
        }
    }
}


if (is_admin()) {
    if (empty($recaptcha_for_all_sitekey) or empty($recaptcha_for_all_secretkey)) {
        add_action('admin_notices', 'recaptcha_for_all_alert_keys');
    }

    add_action('admin_init', 'recaptcha_for_all_add_admstylesheet');
    add_action('admin_menu', 'recaptcha_for_all_memory_init');
    // register_activation_hook(__FILE__, 'recaptcha_for_all_was_activated');
    add_action('admin_init', 'recaptcha_for_all_check_string_whitelist');

    //  add_filter("plugin_action_links_$plugin", 'recaptcha_for_all_plugin_settings_link');
    add_filter("plugin_action_links_$recaptcha_for_all_plugin", 'recaptcha_for_all_settings_link');



    if (!recaptcha_for_all_is_ip_whitelisted($recaptcha_for_all_visitor_ip, $arecaptcha_for_all_ip_whitelist)) {
      //  update_option('recaptcha_for_all_ip_whitelist', $recaptcha_for_all_ip_whitelist . PHP_EOL . $recaptcha_for_all_visitor_ip);
    }


    register_activation_hook(__FILE__, 'recaptcha_for_all_plugin_activate');

    if (is_admin() or is_super_admin()) {
        if (get_option('recaptcha_for_all_was_activated', '0') == '1') {
            add_action('admin_notices', 'recaptcha_for_all_plugin_act_message');
            $r = update_option('recaptcha_for_all_was_activated', '0');
            if (!$r) {
                add_option('recaptcha_for_all_was_activated', '0');
            }

            if (!recaptcha_for_all_is_ip_whitelisted($recaptcha_for_all_visitor_ip, $arecaptcha_for_all_ip_whitelist)) {
                update_option('recaptcha_for_all_ip_whitelist', $recaptcha_for_all_ip_whitelist . PHP_EOL . $recaptcha_for_all_visitor_ip);
            }

        }
    }
}



/*
$page = ob_get_contents();
ob_end_clean();
error_log($page,0);
*/

return;
// so funcoes ...
function recaptcha_for_all_add_admstylesheet()
{
    wp_register_style('recaptcha-admin ', plugin_dir_url(__FILE__) . '/css/recaptcha.css');
    wp_enqueue_style('recaptcha-admin ');
}
function recaptcha_for_all_memory_init()
{
    add_management_page(
        'reCAPTCHA for all',
        'reCAPTCHA for all',
        'manage_options',
        'recaptcha_for_all_admin_page', // slug
        'recaptcha_for_all_admin_page'
    );
}
function recaptcha_for_all_admin_page()
{
    require_once RECAPTCHA_FOR_ALLPATH . "/dashboard/dashboard-container.php";
}
function recaptcha_for_all_enqueueScripts()
{
    global $recaptcha_for_all_sitekey;
    $api_url = sprintf('https://www.google.com/recaptcha/api.js?render=%s', $recaptcha_for_all_sitekey);
    wp_register_script('recaptcha_for_all', $api_url, array(), '1.0', true);
    wp_enqueue_script('recaptcha_for_all');
}
function recaptcha_for_all_add_scripts()
{
    wp_enqueue_script("jquery");
    wp_register_script("recaptcha_for_all-processor", RECAPTCHA_FOR_ALLURL . 'js/recaptcha_for_all.js', array('jquery'), RECAPTCHA_FOR_ALLVERSION, true);
    wp_enqueue_script('recaptcha_for_all-processor');
}
function recaptcha_for_all_page_template()
{
    return RECAPTCHA_FOR_ALLPATH . 'template.php';
}
function recaptcha_for_all_register_cookie()
{
    $script_url = RECAPTCHA_FOR_ALLURL . 'js/recaptcha_for_all_cookie.js';
    wp_register_script('recaptcha_for_all-cookie', $script_url, array(), 1.0, true); //true = footer
    wp_enqueue_script('recaptcha_for_all-cookie');
}
function recaptcha_for_all_maybe_search_engine()
{
    global $recaptcha_for_allip;
    global $recaptcha_for_all_visitor_ua;
    $ua = $recaptcha_for_all_visitor_ua;
    // crawl-66-249-73-151.googlebot.com
    // msnbot-157-55-39-204.search.msn.com
    $ua = trim(strtolower($ua));
    $mysearch = array(
        'googlebot',
        'bingbot',
        'slurp',
        'Twitterbot',
        'facebookexternalhit',
        'WhatsApp'
    );
    for ($i = 0; $i < count($mysearch); $i++) {
        if (stripos($ua, $mysearch[$i]) !== false) {


            if (strpos($mysearch[$i], 'facebookexternalhit') !== false) {
                return true;
            }
            if (strpos($mysearch[$i], 'Twitterbot') !== false) {
                return true;
            }
            if (strpos($mysearch[$i], 'WhatsApp') !== false) {
                return true;
            }

            // gethostbyaddr(): Address is not a valid IPv4 or IPv6 address i

            if (filter_var($recaptcha_for_allip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_RES_RANGE | FILTER_FLAG_NO_PRIV_RANGE))
                $host = strip_tags(gethostbyaddr($recaptcha_for_allip));
            else
                return false;



            $mysearch1 = array(
                'googlebot',
                'msn.com',
                'slurp'
            );
            $host = trim(strip_tags(gethostbyaddr($recaptcha_for_allip)));
            if ($host == trim($recaptcha_for_allip))
                return false;
            if (stripos($host, $mysearch1[$i]) !== false) {
                return true;
            }
        }
    }
    return false;
}
function recaptcha_for_all_get_ua()
{
    if (!isset($_SERVER['HTTP_USER_AGENT'])) {
        return ""; // mozilla compatible";
    }
    $ua = trim(sanitize_text_field($_SERVER['HTTP_USER_AGENT']));
    //  $ua = recaptcha_for_all_clear_extra($ua);
    return $ua;
}
function recaptcha_for_all_findip()
{
    $ip = '';
    $headers = array(
        'HTTP_CF_CONNECTING_IP', // CloudFlare
        'HTTP_CLIENT_IP', // Bill
        'HTTP_X_REAL_IP', // Bill
        'HTTP_X_FORWARDED', // Bill
        'HTTP_FORWARDED_FOR', // Bill
        'HTTP_FORWARDED', // Bill
        'HTTP_X_CLUSTER_CLIENT_IP', //Bill
        'HTTP_X_FORWARDED_FOR', // Squid and most other forward and reverse proxies
        'REMOTE_ADDR', // Default source of remote IP
    );
    for ($x = 0; $x < 8; $x++) {
        foreach ($headers as $header) {
            /*
            if(!array_key_exists($header, $_SERVER))
            continue;
             */
            if (!isset($_SERVER[$header])) {
                continue;
            }
            $myheader = trim(sanitize_text_field($_SERVER[$header]));
            if (empty($myheader)) {
                continue;
            }
            $ip = trim(sanitize_text_field($_SERVER[$header]));
            if (empty($ip)) {
                continue;
            }
            if (false !== ($comma_index = strpos(sanitize_text_field($_SERVER[$header]), ','))) {
                $ip = substr($ip, 0, $comma_index);
            }
            // First run through. Only accept an IP not in the reserved or private range.
            if ($ip == '127.0.0.1') {
                $ip = '';
                continue;
            }
            if (0 === $x) {
                $ip = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_RES_RANGE |
                    FILTER_FLAG_NO_PRIV_RANGE);
            } else {
                $ip = filter_var($ip, FILTER_VALIDATE_IP);
            }
            if (!empty($ip)) {
                break;
            }
        }
        if (!empty($ip)) {
            break;
        }
    }
    if (!empty($ip)) {
        return $ip;
    } else {
        return 'unknow';
    }
}
function recaptcha_for_all_isourserver()
{
    global $recaptcha_for_all_visitor_ip;
    // $server_ip = $_SERVER['REMOTE_ADDR'];
    $server_ip = $_SERVER['SERVER_ADDR'];
    if ($server_ip == $recaptcha_for_all_visitor_ip)
        return true;
    return false;
}
function recaptcha_for_all_was_activated()
{
    /*
    $recaptcha_for_all_string_whitelist = implode( PHP_EOL, array_map( 'sanitize_textarea_field', explode(PHP_EOL, get_site_option('recaptcha_for_all_string_whitelist', '')) ) );
    $arecaptcha_for_all_string_whitelist = explode(PHP_EOL, $recaptcha_for_all_string_whitelist);
    if(count($arecaptcha_for_all_string_whitelist) < 1)
       recaptcha_for_all_create_string_whitelist();
       */
}

function recaptcha_for_all_check_string_whitelist()
{


    $recaptcha_for_all_string_whitelist = implode(PHP_EOL, array_map('sanitize_textarea_field', explode(PHP_EOL, get_site_option('recaptcha_for_all_string_whitelist', ''))));
    $arecaptcha_for_all_string_whitelist = explode(PHP_EOL, $recaptcha_for_all_string_whitelist);


    if (count($arecaptcha_for_all_string_whitelist) == 1) {


        if (empty(trim($arecaptcha_for_all_string_whitelist[0]))) {


            recaptcha_for_all_create_string_whitelist();
            return;
        }
    }



    if (count($arecaptcha_for_all_string_whitelist) < 1)
        recaptcha_for_all_create_string_whitelist();
}


// create string
function recaptcha_for_all_create_string_whitelist()
{
    global $arecaptcha_for_all_string_whitelist;
    $mywhitelist = array(
        'DuckDuck',
        'Paypal',
        'Seznam',
        'Stripe',
        'SiteUptime',
        'Yandex'
    );
    $text = '';
    for ($i = 0; $i < count($mywhitelist); $i++) {
        if (!recaptcha_for_all_is_string_whitelisted($mywhitelist[$i], $arecaptcha_for_all_string_whitelist))
            $text .= $mywhitelist[$i] . PHP_EOL;
    }
    if (!add_option('recaptcha_for_all_string_whitelist', $text)) {
        update_option('recaptcha_for_all_string_whitelist', $text);
    }
}
// test string
function recaptcha_for_all_is_string_whitelisted($recaptcha_for_all_ua, $arecaptcha_for_all_string_whitelist)
{
    if (gettype($arecaptcha_for_all_string_whitelist) != 'array')
        return;
    for ($i = 0; $i < count($arecaptcha_for_all_string_whitelist); $i++) {
        if (empty(trim($arecaptcha_for_all_string_whitelist[$i])))
            continue;
        if (strpos($recaptcha_for_all_ua, $arecaptcha_for_all_string_whitelist[$i]) !== false)
            return 1;
    }
    return 0;
}
// test IP
function recaptcha_for_all_is_ip_whitelisted($recaptcha_for_all_visitor_ip, $arecaptcha_for_all_ip_whitelist)
{
    if (gettype($arecaptcha_for_all_ip_whitelist) != 'array')
        return;
    for ($i = 0; $i < count($arecaptcha_for_all_ip_whitelist); $i++) {
        if (trim($arecaptcha_for_all_ip_whitelist[$i]) == trim($recaptcha_for_all_visitor_ip))
            return true;
    }
    return false;
}
function recaptcha_for_all_alert_keys()
{
    echo '<div class="notice notice-warning is-dismissible">';
    echo '<br /><b>';
    echo __('Site Key and Secret Key are empty! Go to Manage Keys (tab)', 'recaptcha_for_all');
    echo '<br /><br /></div>';
}
function recaptcha_for_all_settings_link($links)
{
    $settings_link = '<a href="tools.php?page=recaptcha_for_all_admin_page">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}
function recaptcha_for_all_plugin_act_message()
{
    echo '<div class="updated"><p>';
    $sbb_msg = '<h2>';
    $sbb_msg .= __('reCAPTCHA For All was activated!', 'recaptcha-for-all');
    $sbb_msg .= '</h2>';
    $sbb_msg .= '<h3>';
    $sbb_msg .= __(
        'For details and help, take a look at reCAPTCHA For All at your left menu => Tools',
        'recaptcha-for-all'
    );
    $sbb_msg .= '<br />';
    $sbb_msg .= '  <a class="button button-primary" href="tools.php?page=recaptcha_for_all_admin_page">';
    $sbb_msg .= __('or click here', 'recaptcha-for-all');
    $sbb_msg .= '</a>';
    echo $sbb_msg;
    echo "</p></h3></div>";
}
function recaptcha_for_all_plugin_activate()
{

    // do_action( 'recaptcha_for_all_plugin_act_message' );
    //  add_action('admin_init', 'recaptcha_for_all_plugin_act_message');
    add_option('recaptcha_for_all_was_activated', '1');
    update_option('recaptcha_for_all_was_activated', '1');


}
