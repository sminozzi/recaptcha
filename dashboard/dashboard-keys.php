<?php
/**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2021-03-02 17:19:27
 */
if (!defined('ABSPATH')) {
    die('We\'re sorry, but you can not directly access this file.');
}
if (isset($_GET['page']) && $_GET['page'] == 'recaptcha_for_all_admin_page') {
    if (isset($_POST['process']) && $_POST['process'] == 'recaptcha_for_all_admin_page_keys') {
        //get limit
        $recaptcha_for_all_updated = false;

        if (isset($_POST['sitekey'])) {
            $recaptcha_for_all_sitekey = sanitize_text_field($_POST['sitekey']);
            if (!empty($recaptcha_for_all_sitekey)) {
                update_option('recaptcha_for_all_sitekey', $recaptcha_for_all_sitekey);
                $recaptcha_for_all_updated = true;
            }



            if (isset($_POST['secretkey'])) {
                $recaptcha_for_all_secretkey = sanitize_text_field($_POST['secretkey']);
                if (!empty($recaptcha_for_all_secretkey)) {
                    update_option('recaptcha_for_all_secretkey', $recaptcha_for_all_secretkey);
                    $recaptcha_for_all_updated = true;
                }
            }
            if ($recaptcha_for_all_updated)
                recaptcha_for_all_updated_message();
        }
    }
}
$recaptcha_for_all_sitekey = trim(sanitize_text_field(get_option('recaptcha_for_all_sitekey', '')));
$recaptcha_for_all_secretkey = trim(sanitize_text_field(get_option('recaptcha_for_all_secretkey', '')));

echo '<div class="wrap-recaptcha ">' . "\n";
echo '<h2 class="title">Manage your Google Keys</h2>' . "\n";
echo '<p class="description">To get your required reCAPTCHA keys 3 from google, visit:
<br><a href="https://www.google.com/recaptcha/admin">https://www.google.com/recaptcha/admin</a>
<br><br> </p>';
?>
<form class="recaptcha_for_all-form" method="post" action="admin.php?page=recaptcha_for_all_admin_page&tab=keys">
    <input type="hidden" name="process" value="recaptcha_for_all_admin_page_keys" />
    <label for="sitekey">Site Key:</label>
    <input type="text" id="sitekey" name="sitekey" size="45" value="<?php echo esc_html($recaptcha_for_all_sitekey); ?>"><br><br>
    <label for="secretkey">Secret Key:</label>
    <input type="text" id="secretkey" name="secretkey" size="45" value="<?php echo esc_html($recaptcha_for_all_secretkey); ?>"><br><br>
    <?php
    echo '<br />';
    echo '<br />';
    echo '<input class="recaptcha_for_all-submit button-primary" type="submit" value="Update" />';
    echo '</form>' . "\n";
    echo '</div>';
    function recaptcha_for_all_updated_message()
    {
        echo '<div class="notice notice-success is-dismissible">';
        echo '<br /><b>';
        echo __('Database Updated!', 'recaptcha_for_all');
        echo '<br /><br /></div>';
    }