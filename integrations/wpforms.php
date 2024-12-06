<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if (altcha_plugin_active('wpforms')) {
  add_filter(
    'wpforms_display_submit_before',
    function () {
      $plugin = AltchaPlugin::$instance;
      $mode = $plugin->get_integration_wpforms();
      if ($mode === "captcha" || $mode === "captcha_spamfilter") {
        echo wp_kses($plugin->render_widget($mode, true), AltchaPlugin::$html_espace_allowed_tags);
      }
    },
    10,
    1
  );

  add_action(
    'wpforms_process',
    function ($fields, $entry, $form_data) {
      $plugin = AltchaPlugin::$instance;
      $mode = $plugin->get_integration_wpforms();
      if (!empty($mode)) {
        if ($mode === "captcha" || $mode === "captcha_spamfilter") {
          $altcha = isset($_POST['altcha']) ? trim(sanitize_text_field($_POST['altcha'])) : '';
          if ($plugin->verify($altcha) === false) {
            wpforms()->process->errors[$form_data['id']]['header'] = esc_html__('Could not verify you are not a robot.', 'altcha-spam-protection');
          }
        }
      }
    },
    10,
    3
  );
}