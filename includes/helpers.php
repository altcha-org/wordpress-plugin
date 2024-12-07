<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function altcha_plugin_active($name) {
  switch ($name) {
    case 'elementor':
      return is_plugin_active('elementor/elementor.php');
    case 'forminator':
      return is_plugin_active('forminator/forminator.php');
    case 'gravityforms':
      return is_plugin_active('gravityforms/gravityforms.php');
    case 'html-forms':
      return is_plugin_active('html-forms/html-forms.php');
    case 'contact-form-7':
      return is_plugin_active('contact-form-7/wp-contact-form-7.php');
    case 'woocommerce':
      return is_plugin_active('woocommerce/woocommerce.php');
    case 'wpdiscuz':
      return is_plugin_active('wpdiscuz/class.WpdiscuzCore.php');
    case 'wpmembers':
      return is_plugin_active('wp-members/wp-members.php');
    case 'wpforms':
      return is_plugin_active('wpforms/wpforms.php') || is_plugin_active('wpforms-lite/wpforms.php');
    default:
      return false;
  }
}

function altcha_enqueue_styles() {
  wp_enqueue_style(
    'altcha-widget-styles',
    AltchaPlugin::$widget_style_src,
    array(),
    ALTCHA_VERSION,
    'all'
  );
}

function altcha_enqueue_scripts() {
  wp_enqueue_script(
    'altcha-widget',
    AltchaPlugin::$widget_script_src,
    array(),
    ALTCHA_VERSION,
    true
  );
  wp_enqueue_script(
    'altcha-widget-wp',
    AltchaPlugin::$wp_script_src,
    array('altcha-widget'),
    ALTCHA_VERSION,
    true
  );
}
