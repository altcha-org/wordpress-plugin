<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if (altcha_plugin_active('html-forms')) {
  add_filter(
    'hf_form_html',
    function ($html) {
      $plugin = AltchaPlugin::$instance;
      $mode = $plugin->get_integration_html_forms();
      if ($mode === "captcha" || $mode === "captcha_spamfilter") {
        altcha_enqueue_scripts();
        altcha_enqueue_styles();
        return str_replace('</form>', $plugin->render_widget($mode) . '</form>', $html);
      }
      return $html;
    }
  );

  add_filter(
    'hf_validate_form',
    function ($error_code, $form, $data) {
      $plugin = AltchaPlugin::$instance;
      $mode = $plugin->get_integration_html_forms();
      if ($mode === "spamfilter") {
        if ($plugin->spam_filter_check($_POST) === false) {
          return "altcha_spam";
        }
      } else if ($mode === "captcha" || $mode === "captcha_spamfilter") {
        if ($plugin->verify(altcha_get_sanitized_solution_from_post()) === false) {
          return "altcha_invalid";
        }
      }
      return $error_code;
    },
    10,
    3
  );

  add_filter(
    'hf_form_message_altcha_invalid',
    function ($message) {
      return __('Cannot submit your message.', "altcha");
    }
  );

  add_filter(
    'hf_form_message_altcha_spam',
    function ($message) {
      return __('Cannot submit your message.', "altcha");
    }
  );
}
