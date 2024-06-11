<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if (altcha_plugin_active('wpforms')) {
  add_filter(
    'wpforms_display_submit_before',
    function () {
      $plugin = AltchaPlugin::$instance;
      $mode = $plugin->get_integration_wpforms();
      if ($mode === "captcha" || $mode === "captcha_spamfilter") {
        altcha_enqueue_scripts();
        altcha_enqueue_styles();
        echo AltchaPlugin::$instance->render_widget($mode, true);
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
      if ($mode === "spamfilter") {
        if ($plugin->spam_filter_check($_POST) === false) {
          wpforms()->process->errors[$form_data['id']]['header'] = esc_html__('Cannot submit your message.', 'altcha-spam-protection');
        }
      } else if ($mode === "captcha" || $mode === "captcha_spamfilter") {
        if ($plugin->verify(altcha_get_sanitized_solution_from_post()) === false) {
          wpforms()->process->errors[$form_data['id']]['header'] = esc_html__('Cannot submit your message.', 'altcha-spam-protection');
        }
      }
    },
    10,
    3
  );
}