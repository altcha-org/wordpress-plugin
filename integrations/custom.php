<?php

if ( ! defined( 'ABSPATH' ) ) exit;

add_action(
  'wp_enqueue_scripts',
  function () {
    $plugin = AltchaPlugin::$instance;
    $mode = $plugin->get_integration_custom();
    if ($mode === 'captcha' || $mode === 'captcha_spamfilter') {
      wp_enqueue_script(
        'altcha-widget-custom',
        AltchaPlugin::$custom_script_src,
        array('altcha-widget'),
        ALTCHA_VERSION,
        true
      );
      $attrs = wp_json_encode($plugin->get_widget_attrs($mode));
      wp_register_script(
        'altcha-widget-custom-options',
        '',
        array(),
        ALTCHA_VERSION,
        false,
      );
      wp_enqueue_script('altcha-widget-custom-options');
      wp_add_inline_script(
        'altcha-widget-custom-options',
        "(() => { window.ALTCHA_WIDGET_ATTRS = $attrs; })();",
      );
    }
  },
  10,
  0
);
