<?php
/**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2021-03-02 17:19:27
 */
if (!defined('ABSPATH')) {
    die('We\'re sorry, but you can not directly access this file.');
}
$recaptcha_for_all_default_message = "We use cookies and javascript to improve the user experience and personalise content and ads, to provide social media 
    features and to analyse our traffic. 
    We also share information about your use of our site with our social media, 
    advertising and analytics partners who may combine it with other information 
    that you’ve provided to them or that they’ve collected from your use of their services.
    <br>
    If you disagree, please, press BACK on your browser.";
if (isset($_GET['page']) && $_GET['page'] == 'recaptcha_for_all_admin_page') {
    if (isset($_POST['process']) && $_POST['process'] == 'recaptcha_for_all_admin_message') {
        $recaptcha_for_all_updated = false;
        if (isset($_POST['message'])) {
            $recaptcha_for_all_message = sanitize_text_field($_POST['message']);
            if (!empty($recaptcha_for_all_message)) {
                update_option('recaptcha_for_all_message', $recaptcha_for_all_message);
                $recaptcha_for_all_updated = true;
            } else {
                update_option('recaptcha_for_all_message', sanitize_text_field($recaptcha_for_all_default_message));
                $recaptcha_for_all_updated = true;
            }
            if (isset($_POST['button'])) {
                $recaptcha_for_all_button = sanitize_text_field($_POST['button']);
                if (!empty($recaptcha_for_all_button)) {
                    update_option('recaptcha_for_all_button', $recaptcha_for_all_button);
                    $recaptcha_for_all_updated = true;
                } else {
                    update_option('recaptcha_for_all_button', 'I Agree');
                    $recaptcha_for_all_updated = true;
                }
            }
            if ($recaptcha_for_all_updated)
                recaptcha_for_all_updated_message();
        }
    }
}
// Escaped below...
$recaptcha_for_all_message = trim(sanitize_text_field(get_option('recaptcha_for_all_message', '')));
$recaptcha_for_all_text_button = trim(sanitize_text_field(get_option('recaptcha_for_all_button', '')));
if (empty($recaptcha_for_all_text_button))
    $recaptcha_for_all_text_button = 'I Agree';
if (empty($recaptcha_for_all_message)) {
    $recaptcha_for_all_message = $recaptcha_for_all_default_message;
}
echo '<div class="wrap-recaptcha ">' . "\n";
echo '<h2 class="title">Manage Message and Button</h2>' . "\n";
?>
<p class="description"> You can create and edit the message and the button will show up when the user 
visit your site for the first time, change device or cookie expire (60 days).
<br>
<b> Don\'t use HTML, only plain text.</b>
<br> Leave the field empty to show up the default value.

<br>
You can also use this kind of message: "Are You Human?" with the button "Yes".
<br>
It is up to you.
<br><br>
<form class="recaptcha_for_all-form" method="post" action="admin.php?page=recaptcha_for_all_admin_page&tab=message">
    <input type="hidden" name="process" value="recaptcha_for_all_admin_message" />
    <label for="message">Message:</label>
    <textarea id="message" name="message" rows="6" cols="50"><?php echo esc_html($recaptcha_for_all_message); ?></textarea>
    <br><br>
    <label for="sitekey">Text Button:</label>
    <input type="text" id="button" name="button" size="15" value="<?php echo esc_html($recaptcha_for_all_text_button); ?>"><br><br>
    <?php
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