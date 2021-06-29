<?php
/**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2021-03-03 09:07:38
 */
if (!defined('ABSPATH')) {
    die('We\'re sorry, but you can not directly access this file.');
}
    //display form
    echo '<div class="wrap-recaptcha ">' . "\n";
    echo '<h2 class="title">reCAPTCHA quick start guide</h2>' . "\n";
    echo '<p class="description">';
    ?>
    
    This plugin can protect All Pages of your site against bots with invisible reCaptcha V3 (Google).
    <br>    <br> 
    Note: This plugin requires google site key and google secret key to work.

    To get your required reCAPTCHA keys 3 from google, visit:
<br>
<a href="https://www.google.com/recaptcha/admin">https://www.google.com/recaptcha/admin</a>
<br>   <br> 


<b>
How the plugin works:
</b>
<br /><br />
The first time the user visit your site, will show up one box with a message and one  button.   
<br> 
<b>After the user click on the button </b>, the plugin will send a request to google check that IP and google will send 
immediatly one response with a IP score.
<br> 
Then, the plugin will allow the user with good score (the score filter is up to you) load the page or will block with a forbidden error.

The user browser needs accept cookies and keep javascript enabled.
<br>  <br> 
The plugin doesn't block this bots:

Google, Bing (Microsoft), Facebook, Slurp (Yahoo) and Tweeter

<br> You can add more on Whitelist Table.

<br>  <br> 


To Begin, click the tab Manage Keys and add your Keys.
<br>  <br> 
After that, click the tab Manage Messages to edit your message and the button text if necessary.
<br>  <br> 
Click also the tab General Settings, mark YES to begin and choose the minimum IP score to accept visits.
<br> 
Don't forget to manage Whitelist and fill out yours IPs and User Agents to be white listed (Manage Whitelist tab).
<br>  <br> 

That is all! 
<br>  <br> 
To see your initial page, try to access your site from other device (different IP) and where you never logged in.
<br>
Or try to take a screenshot from this site:
https://www.url2png.com/#testdrive
<br><br>
If you have questions, visit our FAQ section or Support Forum on the plugin page at WordPress:
<br> 
https://WordPress.org/plugins/recaptcha-for-all/

</div>