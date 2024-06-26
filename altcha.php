<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/*
 * Plugin Name: ALTCHA Spam Protection
 * Description: ALTCHA is a free, open-source CAPTCHA alternative that offers robust protection without using cookies, ensuring full GDPR compliance by design. It also provides invisible anti-spam and anti-bot protection through ALTCHA's API.
 * Author: Altcha.org
 * Author URI: https://altcha.org
 * Version: 0.2.1
 * Stable tag: 0.2.1
 * Requires at least: 5.0
 * Requires PHP: 7.3
 * Tested up to: 6.5
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html  
 */

define('ALTCHA_VERSION', '0.2.1');
define('ALTCHA_WEBSITE', 'https://altcha.org/');
define('ALTCHA_WIDGET_VERSION', '0.6.0');
define('ALTCHA_LANGUAGES', [
  "bg" => "Bulgarian",
  "ca" => "Catalan",
  "cs" => "Czech",
  "da" => "Danish",
  "de" => "German",
  "el" => "Greek",
  "en" => "English",
  "es" => "Spanish",
  "et" => "Estonian",
  "fi" => "Finnish",
  "fr" => "French",
  "hr" => "Croatian",
  "hu" => "Hungarian",
  "it" => "Italian",
  "ja" => "Japanese",
  "ja" => "Japanese",
  "lt" => "Lithuanian",
  "lv" => "Latvian",
  "nl" => "Dutch",
  "no" => "Norwegian",
  "pl" => "Polish",
  "pt" => "Portuguese",
  "ro" => "Romanian",
  "ru" => "Russian",
  "sk" => "Slovak",
  "sr" =>	"Serbian",
  "sv" => "Swedish",
  "tr" => "Turkish",
  "uk" => "Ukrainian",
  "zh-CN" => "Chinese (simplified)",
  ]);

  
// required for is_plugin_active
require_once ABSPATH . 'wp-admin/includes/plugin.php';

require plugin_dir_path(__FILE__) . 'includes/helpers.php';
require plugin_dir_path(__FILE__) . 'includes/core.php';
require plugin_dir_path(__FILE__) . 'includes/translations.php';
require plugin_dir_path( __FILE__ ) . './public/widget.php';

require plugin_dir_path( __FILE__ ) . './integrations/contact-form-7.php';
require plugin_dir_path( __FILE__ ) . './integrations/custom.php';
require plugin_dir_path( __FILE__ ) . './integrations/forminator.php';
require plugin_dir_path( __FILE__ ) . './integrations/html-forms.php';
require plugin_dir_path( __FILE__ ) . './integrations/gravityforms.php';
require plugin_dir_path( __FILE__ ) . './integrations/wpforms.php';
require plugin_dir_path( __FILE__ ) . './integrations/wordpress.php';

AltchaPlugin::$widget_script_src = plugin_dir_url(__FILE__) . "public/altcha.min.js";
AltchaPlugin::$widget_style_src = plugin_dir_url(__FILE__) . "public/altcha.css";
AltchaPlugin::$wp_script_src = plugin_dir_url(__FILE__) . "public/script.js";
AltchaPlugin::$admin_script_src = plugin_dir_url(__FILE__) . "public/admin.js";
AltchaPlugin::$admin_css_src = plugin_dir_url(__FILE__) . "public/admin.css";
AltchaPlugin::$custom_script_src = plugin_dir_url(__FILE__) . "public/custom.js";

register_activation_hook(__FILE__, 'altcha_activate');
register_deactivation_hook(__FILE__, 'altcha_deactivate');

add_shortcode(
  'altcha',
  function ($attrs) {
    $default = array(
      'mode' => 'captcha',
    );
    $a = shortcode_atts($default, $attrs);
    $plugin = AltchaPlugin::$instance;
    return wp_kses($plugin->render_widget($a['mode']), AltchaPlugin::$html_espace_allowed_tags);
  }
);

function altcha_activate()
{
  update_option(AltchaPlugin::$option_api, 'selfhosted');
  update_option(AltchaPlugin::$option_api_key, '');
  update_option(AltchaPlugin::$option_expires, '3600');
  update_option(AltchaPlugin::$option_secret, AltchaPlugin::$instance->random_secret());
  update_option(AltchaPlugin::$option_language, 'en');
  update_option(AltchaPlugin::$option_hidefooter, true);
  update_option(AltchaPlugin::$option_send_ip, true);
}

function altcha_deactivate()
{
}
