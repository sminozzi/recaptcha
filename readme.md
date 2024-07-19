=== WordPress Add reCAPTCHA For All Pages, to Block Spam and Hackers Attack, Block Visitors from China -  Plugin ===

Plugin Name: reCAPTCHA For All
Plugin URI: https://BillMinozzi.com/support/
Description: Protect ALL pages of your site against Spam and Hackers bots with reCAPTCHA Version 3.
Tags: recaptcha for all, all pages, recaptcha spam, google recaptcha, block visitors from china
Author: Bill Minozzi
Author URI: https://BillMinozzi.com/
Contributors: sminozzi
Requires at least: 5.4
Tested up to: 5.7
Stable tag: 1.04
Version: 1.03
Requires PHP: 5.6.20
License URI: http://www.gnu.org/licenses/gpl-2.0.html
License: GPL v2 or later

Protect ALL pages of your site against Spam and Hackers bots with reCAPTCHA Version 3.

== Description ==
★★★★★<br>

>The reCAPTCHA For All Plugin Protect ALL Pages of your site against bots (spam, hackers, fake users and other types of automated abuse) 
with invisible reCaptcha V3 (Google). You can also block visitors from China. 

**How the plugin works:**

The first time the user visit your site (just once), will show up one box with a message and one button. 
Only for not logged in users.
You can manage the design and the text of both. 
Usually this happens with cookies policy yet. Then, maybe you can replace your current cookie notice. 
Or add any kind of initial message. For example:

<li>Cookie info...</li>
<li> Are You Human? Just click Yes ...</li>
<li> Click Yes if you have more than X years old ... </li>
<li> Click Ok to check if your browser is compatible ...</li>


After the user click the button, the plugin will send a request to google check that visitor reputation and google sends a immediate response with an score.
Then, the plugin will allow the user with required score (the score filter rate is up to you) load the page otherwise will block with a forbidden error. 

The user browser needs accept cookies and be with javascript enabled. WordPress system also request that, then, it is not a big deal.

**This can avoid the bots from stealing your content, consume your bandwidth and overload your server.**

**The plugin doesn't block: Google, Bing (Microsoft), Facebook, Slurp (Yahoo) and Tweeter bots.
You can add others on Whitelist Table, as site uptime, paypal, stripe...**

Note: This plugin requires google site key and google secret key to work. Look the FAQ how to get that.

== Block visitors from China ==
If you are getting a lot of spam and malicious traffic from China, with our plugin 
you can block it without worry about install (and mantain) huge databases of IP address.
Just let our plugin take care that.  


== TAGS ==
Prevent automated content scraper


== Screenshots ==
1. Initial Page box
2. Dashboard

== FAQ ==

= Where Can I get My Site Key and Secret Key? = 
Visit Google:
https://www.google.com/recaptcha/admin

= Can I configurate the design of the initial page? =
Yes, you can go to Design tab on our dashboard.
You can also edit the file template.php on plugin root:
/wp-content/plugins/recaptcha-for-all/

= How to remove the plugin if I'm blocked? =
Just erase the plugin from:
/wp-content/plugins/recaptcha-for-all/

= Where Can I see the number of requests and score distribution? =
You can see that on google site.
https://www.google.com/recaptcha/admin/

= Is reCAPTHA Google free? =
It is free up to 1000 calls per second or 1000000 calls per month.
Anyway, check with google for details and updates about that before to begin to use the service.
https://developers.google.com/recaptcha/docs/faq


= What is score? =
For each interaction, google return a IP score.
1.0 is very likely a good interaction, 0.0 is very likely a bot. 

= Where can I find more information about Google reCAPTHA? =
Visit Google site:
https://www.google.com/recaptcha/about/

= How can I see my initial page after activate the plugin? =
To see your initial page, try to access your site from other device (different IP) and where you never logged in.
<br>
Or try to take a screenshot from this site:
https://www.url2png.com/#testdrive

= Troubleshooting =
After install, check your initial page and if some preload image it is not stuck.
Look the previous FAQ.
For more about troubleshooting, visit:
https://siterightaway.net/troubleshooting/

== Legal Advise about Cookies ==
We can't give legal advise about Cookies (neither other things). We suggest you contact a lawyer regards that.


== Installation ==

1) Install via wordpress.org
o
2) Activate the plugin through the 'Plugins' menu in WordPress

or

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.


== Changelog ==
= 1.04 =  2021-06-27 - Minor Bug Fixed
= 1.03 =  2021-06-19 - Minor Bug Fixed
= 1.02 =  2021-06-18 - Added Block China Visitors (optional)
= 1.01 =  2021-06-10 - Minor Improvements
= 1.00 =  2021-06-08 - Initial release.
