=== ALTCHA Spam Protection ===
Tags: altcha, captcha, spam, anti-spam, anti-bot, antispam, recaptcha, hcaptcha, gdpr
Author: Altcha.org
Author URI: https://altcha.org
Version: 1.11.1
Stable tag: 1.11.1
Requires at least: 5.0
Requires PHP: 7.3
Tested up to: 6.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html  

ALTCHA offers a free, open-source Captcha alternative, ensuring robust spam protection while respecting user privacy and GDPR compliance.

== Description ==
 
[ALTCHA](https://altcha.org) provides a free, open-source Captcha alternative utilizing a proof-of-work mechanism to safeguard your website against spam and unwanted content. Our anti-spam solution ensures robust spam protection without compromising user privacy.

Unlike other solutions, ALTCHA is free, open-source, and self-hosted. It operates independently without external services, avoids the use of cookies and fingerprinting, refrains from user tracking, and maintains full compliance with GDPR regulations.

== Spam Filter ==

ALTCHA’s [Spam Filter](https://altcha.org/anti-spam) introduces a distinctive spam-detection feature enabling efficient classification of text and other information, empowering you to distinguish spam from legitimate messages. This anti-spam Captcha feature provides enhanced spam protection for your site.

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

Download, install and activate `ALTCHA Spam Protection`.

To use the Spam Filter, [create an API Key](https://altcha.org/docs/api/api_keys/) and configure it in the Settings.
 
Alternatively, install the plugin manually:

1. Download the `.zip` from the [Releases](https://github.com/altcha-org/wordpress-plugin/releases).
2. Upload `altcha` folder to the `/wp-content/plugins/` directory  
3. Activate the plugin through the 'Plugins' menu in WordPress  
4. Review the settings and enable the your integrations

== REST API ==

This plugin requires the WordPress REST API. If you are using any "Disable REST API" plugins, ensure that the endpoint `/altcha/v1/challenge` is allowed.

== Supported Integrations ==

* Contact Form 7
* Elementor Pro Forms
* Forminator
* GravityForms
* HTML Forms
* WPDiscuz
* WPForms
* WP-Members
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
2. Configuration
3. Protection on the login page
4. Protection with WPForms
5. Floating UI Captcha

== Changelog ==

= 1.11.1 =
* Fix Forminator compatibility issue

= 1.11.0 =
* Added support for WP-Members

= 1.10.0 =
* Added support for WPDiscuz

= 1.9.3 =
* Fix REST API Cache-Control header

= 1.9.2 =
* Enable Custom HTML (shortcode) integration by default when activated

= 1.9.1 =
* PHP 7 support (replace str_contains by strpos) [#19]

= 1.9.0 =
* Widget updated to version 1.0.0
* CF7 - fix widget placement
* Fix page caching

= 1.8.0 =
* Shortcode (custom integration) - fix mode (SpamFilter) 

= 1.7.0 =
* HTML Forms - add Shortcode option

= 1.6.1 =
* Fix WordPress login integration

= 1.6.0 =
* Fix Elementor Pro Forms widget rendering
* Fix Contact Form 7 widget position and shortcode support

= 1.5.0 =
* Fix REST base URL (+ REST prefix removed from settings) [#13]

= 1.4.0 =
* Support for Elementor Pro Forms
* Widget updated to 0.6.7

= 1.3.1 =
* Fix site_url parsing issue [#11]

= 1.3.0 =
* Added support for custom REST API prefixes

= 1.2.0 =
* Forminator - fix widget rendering with file input
* Widget updated to 0.6.4

= 1.1.0 =
* Shortcode - support for `language` attribute

= 1.0.0 =
* Widget updated to 0.6.3

= 0.3.0 =
* Added nonce sanitization
* Removed server-side spam filter (required for Plugin Directory)

= 0.2.1 =
* Fixes requested by Plugin Directory review
* Fixed various Spam Filter issues

= 0.2.0 =
* Widget updated to 0.6.0
* Added support for Floating UI

= 0.1.7 =
* Fix Forminator multi-step forms

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
