=== ALTCHA Spam Protection ===
Tags: altcha, captcha, spam, anti-spam, anti-bot, antispam, recaptcha, hcaptcha, gdpr
Author: Altcha.org
Author URI: https://altcha.org
Version: 0.1.6
Stable tag: 0.1.6
Requires at least: 5.0
Requires PHP: 7.3
Tested up to: 6.5
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html  

ALTCHA offers a free, open-source Captcha alternative, ensuring robust spam protection while respecting user privacy and GDPR compliance.

== Description ==
 
ALTCHA provides a free, open-source Captcha alternative utilizing a proof-of-work mechanism to safeguard your website against spam and unwanted content.

Unlike other solutions, ALTCHA is free, open-source, and self-hosted. It operates independently without external services, avoids the use of cookies and fingerprinting, refrains from user tracking, and maintains full compliance with GDPR regulations.

Enjoying ALTCHA? Show your support by starring us on GitHub: https://github.com/altcha-org/altcha

== Spam Filter ==

ALTCHA’s [Spam Filter](https://altcha.org/anti-spam) introduces a distinctive spam-detection feature enabling efficient classification of text and other information, empowering you to distinguish spam from legitimate messages.

As a GDPR-compliant alternative to Akismet, this feature seamlessly integrates with the plugin for effortless activation.

== Privacy ==

= No cookies, no tracking =

ALTCHA prioritizes user privacy by avoiding the use of cookies and fingerprinting techniques.

= No external service =

Operating in Self-hosted mode (the default setting), this plugin remains fully contained within your WordPress installation, eliminating any reliance on external services. You can opt-in for our SaaS version to utilize the Spam Filter API. For more information visit https://altcha.org.

== Modes of Operation ==

This plugin operates in two modes, you can select which mode you want in the settings (see API Region):

* Self-hosted - fully self-contained without external services.
* 3rd-party external service - ALTCHA’s SaaS requiring an [API Key](https://altcha.org/docs/api/api_keys/), allows you to choose EU or US region.

Note: The Spam Filter requires ALTCHA’s SaaS. [Create an API Key](https://altcha.org/docs/api/api_keys/) to access it.
 
== Installation ==
 
1. Upload `altcha` folder to the `/wp-content/plugins/` directory  
2. Activate the plugin through the 'Plugins' menu in WordPress  
3. Review the settings and enable the your integrations

== Supported Integrations ==

* Contact Form 7
* Forminator
* GravityForms
* HTML Forms
* WPForms
* WordPress Login, Register, Password reset
* WordPress Comments
* Custom HTML (with a short code `[altcha]`)

== Source Code ==

All source code for the plugin, and the ALTCHA widget is available on GitHub. In the repository, you'll also find versions of non-minified JavaScript and CSS assets:

* Plugin: https://github.com/altcha-org/wordpress-plugin
* ALTCHA Widget: https://github.com/altcha-org/altcha

== Terms of Service And Privacy Policy for SaaS ==

* Privacy Policy: https://altcha.org/privacy-policy
* Terms of Service: https://altcha.org/terms-of-service

== Screenshots ==

1. Friction-less Captcha without puzzles

== Changelog ==

= 0.1.6 =
* Widget updated to 0.5.1

= 0.1.5 =
* Fixes requested by Plugin Directory review

= 0.1.4 =
* GravityForms - added label and description options
* Altcha widget updated to 0.4.3

= 0.1.3 =
* Fixed "lost password" verification bug
* Altcha widget updated to 0.4.1

= 0.1.2 =
* Fixed widgets footer link and log warnings

= 0.1.1 =
* Widget v0.4.0
* Challenge expiration

= 0.1.0 =
* First version
