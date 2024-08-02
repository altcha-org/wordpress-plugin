<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if (altcha_plugin_active('elementor')){
  function altcha_register_form_field( $form_fields_registrar ) {
    require_once(__DIR__ . '/elementor/field.php');

    $form_fields_registrar->register(new \Elementor_Form_Altcha_Field());
  }
  $plugin = AltchaPlugin::$instance;
  $mode = $plugin->get_integration_elementor();
  if ($mode === 'captcha' || $mode === 'captcha_spamfilter') {
    add_action('elementor_pro/forms/fields/register', 'altcha_register_form_field');
  }
}