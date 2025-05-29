<?php

if ( ! defined( 'ABSPATH' ) ) exit;

add_action(
  'wpdiscuz_button_actions',
  function () {
    $plugin = AltchaPlugin::$instance;
    $mode = $plugin->get_integration_wpdiscuz();
    if (!empty($mode)) {
      $plugin = AltchaPlugin::$instance;
      $output = "<div class=\"altcha-widget-wrap-wpdiscuz\">";
      $output .= $plugin->render_widget($mode, false);
      $output .= "</div>";
      echo wp_kses($output, AltchaPlugin::$html_espace_allowed_tags);
    }
  },
  10,
  0
);
