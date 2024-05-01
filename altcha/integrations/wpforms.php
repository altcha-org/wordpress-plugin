<?php

if (altcha_plugin_active('wpforms')) {
  add_filter(
    'wpforms_display_submit_before',
    function () {
      $plugin = AltchaPlugin::$instance;
      $mode = $plugin->get_integration_wpforms();
      if ($mode === "captcha" || $mode === "captcha_spamfilter") {
        altcha_enqueue_scripts();
        altcha_enqueue_styles();
        echo $plugin->render_widget($mode, true);
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
          wpforms()->process->errors[$form_data['id']]['header'] = esc_html__(AltchaPlugin::$message_cannot_submit, 'altcha');
        }
      } else if ($mode === "captcha" || $mode === "captcha_spamfilter") {
        if ($plugin->verify($_POST['altcha']) === false) {
          wpforms()->process->errors[$form_data['id']]['header'] = esc_html__(AltchaPlugin::$message_cannot_submit, 'altcha');
        }
      }
    },
    10,
    3
  );
}