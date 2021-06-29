<?php
/**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2021-03-02 12:38:04
 */
  Global $recaptcha_checkversion;
 if (!defined('ABSPATH')) {
    die('We\'re sorry, but you can not directly access this file.');
  } 
if( isset( $_GET[ 'tab' ] ) ) 
    $active_tab = sanitize_text_field($_GET[ 'tab' ]);
else
   $active_tab = 'dashboard';
?>
<h2 class="nav-tab-wrapper">
    <a href="tools.php?page=recaptcha_for_all_admin_page&tab=dashboard" class="nav-tab">Dashboard</a>
    <a href="tools.php?page=recaptcha_for_all_admin_page&tab=settings" class="nav-tab">General Settings</a>
    <a href="tools.php?page=recaptcha_for_all_admin_page&tab=keys" class="nav-tab">Manage Keys</a>
    <a href="tools.php?page=recaptcha_for_all_admin_page&tab=message" class="nav-tab">Manage Message</a>
    <a href="tools.php?page=recaptcha_for_all_admin_page&tab=whitelist" class="nav-tab">Manage Whitelist</a>
    <a href="tools.php?page=recaptcha_for_all_admin_page&tab=design" class="nav-tab">Design</a>

   </h2>
<?php  
if($active_tab == 'keys') {     
    require_once (RECAPTCHA_FOR_ALLPATH. 'dashboard/dashboard-keys.php');
 } 
 elseif($active_tab == 'settings') {     
   require_once (RECAPTCHA_FOR_ALLPATH. 'dashboard/dashboard-settings.php');
} 
 elseif($active_tab == 'message') {     
    require_once (RECAPTCHA_FOR_ALLPATH. 'dashboard/dashboard-message.php');
 } 
 elseif($active_tab == 'whitelist') {     
   require_once (RECAPTCHA_FOR_ALLPATH. 'dashboard/dashboard-whitelist.php');
} 
elseif($active_tab == 'design') {     
   require_once (RECAPTCHA_FOR_ALLPATH. 'dashboard/dashboard-design.php');
} 
 else
 { 
    require_once (RECAPTCHA_FOR_ALLPATH. 'dashboard/dashboard.php');
 }
?>