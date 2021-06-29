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
    if (isset($_POST['process']) && $_POST['process'] == 'recaptcha_for_all_admin_page_settings') {
        //get limit
        $recaptcha_for_all_updated = false;

        if (isset($_POST['settings'])) {

            $recaptcha_for_all_settings = sanitize_text_field($_POST['settings']);
            $recaptcha_for_all_settings_china = sanitize_text_field($_POST['settings_china']);

            if (!empty($recaptcha_for_all_settings)) {
                update_option('recaptcha_for_all_settings', $recaptcha_for_all_settings);
                $recaptcha_for_all_updated = true;
            }

            if (!empty($recaptcha_for_all_settings_china)) {
                update_option('recaptcha_for_all_settings_china', $recaptcha_for_all_settings_china);
                $recaptcha_for_all_updated = true;
            }
            



            if (isset($_POST['recaptcha_score'])) {
                $recaptcha_for_all_recaptcha_score = sanitize_text_field($_POST['recaptcha_score']);
                if (!empty($recaptcha_for_all_recaptcha_score)) {
                    update_option('recaptcha_for_all_recaptcha_score', $recaptcha_for_all_recaptcha_score);
                    $recaptcha_for_all_updated = true;
                }
            }


            if ($recaptcha_for_all_updated)
                recaptcha_for_all_updated_message();
        }
    }
}
$recaptcha_for_all_settings = trim(sanitize_text_field(get_option('recaptcha_for_all_settings', '')));
$recaptcha_for_all_settings_china = trim(sanitize_text_field(get_option('recaptcha_for_all_settings_china', '')));

$recaptcha_for_all_recaptcha_score = trim(sanitize_text_field(get_option('recaptcha_for_all_recaptcha_score', '')));

echo '<div class="wrap-recaptcha ">' . "\n";
echo '<h2 class="title">General Settings</h2>' . "\n";
echo '<p class="description">Activate or Deactivate the plugin, set the minimum IP score and block visits from China.
<br> </p>';
?>
<big>
    <b>Info about score:</b>
    <br>
    For each interaction, google return a IP score.
    <br>
    1.0 is very likely a good interaction, 0.0 is very likely a bot. We suggest you begin with 0.7
    <br>
    You can see details and your history chart at your Google.com site dashboard.
    <br><br>
    <?php

    if ($recaptcha_for_all_settings == 'yes')
        $radio_active = true;
    else
        $radio_active = false;


    if ($recaptcha_for_all_settings_china == 'yes')
      $radio_active_china = true;
    else
      $radio_active_china = false;

    $recaptcha_score = trim($recaptcha_for_all_recaptcha_score);


    ?>
    <form class="recaptcha_for_all-form" method="post"
        action="admin.php?page=recaptcha_for_all_admin_page&tab=settings">
        <input type="hidden" name="process" value="recaptcha_for_all_admin_page_settings" />

        Just mark Yes to activate the plugin. <br>
        <label for="radio_yes">Yes</label>
        <input type="radio" id="radio_yes" name="settings" value="yes" <?php if ($radio_active) echo 'checked'; ?>>
        <label for="radio_no">No</label>
        <input type="radio" id="radio_no" name="settings" value="no" <?php if (!$radio_active) echo 'checked'; ?>>
 
        <br><br>
        <label for="recaptcha_for_alllimit">Select the score minimum of the visitor to access your site:</label>
        <select name="recaptcha_score" id="recaptcha_score">
            <option value="1" <?php echo ($recaptcha_score == '1') ? ' selected="selected"' : ''; ?>>0.1</option>
            <option value="2" <?php echo ($recaptcha_score == '2') ? ' selected="selected"' : ''; ?>>0.2</option>
            <option value="3" <?php echo ($recaptcha_score == '3') ? ' selected="selected"' : ''; ?>>0.3</option>
            <option value="4" <?php echo ($recaptcha_score == '4') ? ' selected="selected"' : ''; ?>>0.4</option>
            <option value="5" <?php echo ($recaptcha_score == '5') ? ' selected="selected"' : ''; ?>>0.5</option>
            <option value="6" <?php echo ($recaptcha_score == '6') ? ' selected="selected"' : ''; ?>>0.6</option>
            <option value="7" <?php echo ($recaptcha_score == '7') ? ' selected="selected"' : ''; ?>>0.7</option>
            <option value="8" <?php echo ($recaptcha_score == '8') ? ' selected="selected"' : ''; ?>>0.8</option>
            <option value="9" <?php echo ($recaptcha_score == '9') ? ' selected="selected"' : ''; ?>>0.9</option>
        </select>
        
        <br />
        <br />

        Just mark Yes to Block Visits from China. <br>
        <label for="radio_yes">Yes</label>
        <input type="radio" id="radio_yes_china" name="settings_china" value="yes" <?php if ($radio_active_china) echo 'checked'; ?>>
        <label for="radio_no">No</label>
        <input type="radio" id="radio_no_china" name="settings_china" value="no" <?php if (!$radio_active_china) echo 'checked'; ?>>

        <br />
        <br />

        <input class="recaptcha_for_all-submit button-primary" type="submit" value="Update" />

    </form>

</big>
</div>



        <?php
        function recaptcha_for_all_updated_message()
        {
            echo '<div class="notice notice-success is-dismissible">';
            echo '<br /><b>';
            echo __('Database Updated!', 'recaptcha_for_all');
            echo '<br /><br /></div>';
        }