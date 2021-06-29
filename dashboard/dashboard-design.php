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

    if (isset($_POST['process']) && $_POST['process'] == 'recaptcha_for_all_admin_page_background') {
        //get limit
        $recaptcha_for_all_updated = false;

        if (isset($_POST['background'])) {
            $recaptcha_for_all_background = sanitize_text_field($_POST['background']);
            if (!empty($recaptcha_for_all_background)) {
                update_option('recaptcha_for_all_background', $recaptcha_for_all_background);
                $recaptcha_for_all_updated = true;
            }

            if ($recaptcha_for_all_updated)
                recaptcha_for_all_updated_message();
        }
    }
}
$recaptcha_for_all_background = trim(sanitize_text_field(get_option('recaptcha_for_all_background', '')));
echo '<div class="wrap-recaptcha ">' . "\n";
echo '<h2 class="title">Design</h2>' . "\n";
echo '<p class="description">Options to match your site design. More options are coming.<br> </p>';
?>
<big>
    <b>Info about template:</b>
    <br>
    You can edit the file template.php on plugin root: <br>
    /wp-content/plugins/recaptcha-for-all/
    <br><br>
    You can replace the background image: <br>
    /wp-content/plugins/recaptcha-for-all/images/background.jpg
    <br><br>
    <?php
    if ($recaptcha_for_all_background == 'yes')
        $radio_active = true;
    else
        $radio_active = false;
    ?>
    <form class="recaptcha_for_all-form" method="post" action="admin.php?page=recaptcha_for_all_admin_page&tab=design">
        <input type="hidden" name="process" value="recaptcha_for_all_admin_page_background" />

        Add the background image?<br>

        <img src="/wp-content/plugins/recaptcha-for-all/images/background.jpg"  width="200"> 

        <br>



        <label for="radio_yes">Yes</label>
        <input type="radio" id="radio_yes" name="background" value="yes" <?php if ($radio_active) echo 'checked'; ?>>
        <label for="radio_no">No</label>
        <input type="radio" id="radio_no" name="background" value="no" <?php if (!$radio_active) echo 'checked'; ?>>
        <br><br>
        <?php
        echo '<br />';
        echo '<br />';
        echo '<input class="recaptcha_for_all-submit button-primary" type="submit" value="Update" />';
        echo '</form>' . "\n";
        echo '</big></div>';
        function recaptcha_for_all_updated_message()
        {
            echo '<div class="notice notice-success is-dismissible">';
            echo '<br /><b>';
            echo __('Database Updated!', 'recaptcha_for_all');
            echo '<br /><br /></div>';
        }