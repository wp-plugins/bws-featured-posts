=== Featured Posts by BestWebSoft ===
Contributors: bestwebsoft
Donate link: https://www.2checkout.com/checkout/purchase?sid=1430388&quantity=1&product_id=94
Tags: plugin, wordpress, featured, random posts, featured posts, add featured posts, display featured posts, manage featured posts, featured posts plugin, mark post as featured, mark page as featured, featured posts block, fetured post, faetured post, featyred post, feachured post, featured psot, featured post with theme, feetured posts, featered post. 
Requires at least: 3.5
Tested up to: 4.1
Stable tag: 0.2
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Displays featured posts randomly on any website page.

== Description ==

Note: This is a public beta version, which contains basic product options. You are welcome to suggest new features and usability improvements.
<a href="http://support.bestwebsoft.com/hc/en-us/requests/new">I would like to submit a new feature.</a>

Featured Posts by BestWebSoft plugin allows you to add and manage featured posts on your website. With this timesaver plugin, marking posts as featured posts, as well as displaying them on your blog pages will be a lot easier. 

<a href="http://wordpress.org/plugins/bws-featured-posts/faq/" target="_blank">FAQ</a>
<a href="http://support.bestwebsoft.com" target="_blank">Support</a>

= Features =

* Actions: An option to mark any post or page as a Featured Post. 
* Display: An option to adjust Featured Posts display to any theme. 
* Display: An option to display the block before or after the post, as well as through the shortcode. 
* Actions: An unlimited number of posts or pages to be displayed in Featured Posts block.
* Actions: Changing a post/page displayed in Featured Posts block each time the page is reloaded.

= Recommended Plugins =

The author of Featured Posts plugin also recommends the following plugins:

* <a href="http://wordpress.org/plugins/updater/">Updater</a> - This plugin updates WordPress core and the plugins to the recent versions. You can also use the auto mode or manual mode for updating and set email notifications.
There is also a premium version of the plugin <a href="http://bestwebsoft.com/products/updater/">Updater Pro</a> with more useful features available. It can make backup of all your files and database before updating. Also it can forbid some plugins or WordPress Core update.

= Translation =

* Russian (ru_RU)
* Ukrainian (uk)

If you would like to create your own language pack or update the existing one, you can send <a href="http://codex.wordpress.org/Translating_WordPress" target="_blank">the text of PO and MO files</a> to <a href="http://support.bestwebsoft.com" target="_blank">BestWebSoft</a>, and we'll add it to the plugin. You can download the latest version of the program for working with PO and MO files  <a href="http://www.poedit.net/download.php" target="_blank">Poedit</a>.

= Technical support =

Dear users, our plugins are available for free download. If you have any questions or recommendations regarding the functionality of our plugins (existing options, new options, current issues), please feel free to contact us. Please note that we accept requests in English only. All messages in another languages won't be accepted.

If you notice any bugs in the plugin's work, you can notify us about them and we'll investigate and fix the issue then. Your request should contain website URL, issues description and WordPress admin panel credentials.
Moreover, we can customize the plugin to match your requirements. It's a paid service (as a rule it costs $40, but the price can vary depending on the amount of the necessary changes and their complexity). Please note that we could also include this or that feature (developed for you) in the next release and share with the other users then.
We can fix some things for free for the users who provide a translation of our plugin into their native language (this should be a new translation of a certain plugin, you can check available translations on the official plugin page).

== Installation == 

1. Upload the `bws-featured-posts` folder to `/wp-content/plugins/` directory.
2. Activate the plugin using the 'Plugins' menu in your WordPress admin panel.
3. You can adjust the necessary settings using your WordPress admin panel in "BWS Plugins" > "Featured Posts".

== Frequently Asked Questions ==

= How can I add a Featured Post to my website? =

1. If you would like to add Featured Posts to your page or post, select the posts to be displayed (on the page/post editing page, in Featured Post block, please mark 'Display this post in the Featured Post block?').
2. There are several ways to add the block: 
1) You can enable block display Before the Post and/or After the Post on the plugin settings page. 
2) You can copy and paste this shortcode into your post or page: [bws_featured_post]
3) You can copy and paste this code to the necessary place in your theme 
&lt;?php if( has_action( 'rndmftrdpsts_featured_posts' ) ) {
	do_action( 'rndmftrdpsts_featured_posts' );
} ?&gt;

= I have installed the plugin and went through the abovementioned steps to add a block, yet the block is not displayed =

Please select the necessary posts to be displayed (on the page/post editing page, in Featured Post block, please mark 'Display this post in the Featured Post block?').

= How can I change block display? =

On the plugin settings page, you can change block color, text block color, title color, text color and 'Learn more' link color. 
Also, you can select the width of the entire block and the text block. 

= I have some problems with the plugin's work. What Information should I provide to receive proper support? =

Please make sure that the problem hasn't been discussed on our forum yet (<a href="http://support.bestwebsoft.com" target="_blank">http://support.bestwebsoft.com</a>). If not, please provide the following data along with your problem's description:
1. the link to the page, on which the problem occurs
2. the plugin’s name and version. If you are using a pro version - your order number.
3. the version of your WordPress installation
4. copy and paste your system status report into the message . Please read more here: <a href="https://docs.google.com/document/d/1Wi2X8RdRGXk9kMszQy1xItJrpN0ncXgioH935MaBKtc/edit" target="_blank">Instuction on System Status</a>

== Screenshots ==

1. Default Featured Posts settings.
2. Custom Featured Posts settings.
3. Featured Posts block display with Custom plugin settings (BWS theme).
3. Featured Posts block display with Custom plugin settings (default theme).

== Changelog == 

= V0.2 - 09.02.2015 = 
* Bugfix : Content display was fixed.

= V0.1 - 26.01.2015 = 
* Bugfix : The code refactoring was performed.
* NEW : Css-style was added.

== Upgrade Notice ==

= V0.2 = 
Content display was fixed.

= V0.1 =
The code refactoring. Css-style was added.
