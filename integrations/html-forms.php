<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if (altcha_plugin_active('html-forms')) {
  add_filter(
    'hf_form_html',
    'do_shortcode'
  );

  add_filter(
    'hf_form_html',
    function ($html) {
      $plugin = AltchaPlugin::$instance;
      $mode = $plugin->get_integration_html_forms();
      if ($mode === "captcha" || $mode === "captcha_spamfilter") {
        return str_replace('</form>', wp_kses($plugin->render_widget($mode), AltchaPlugin::$html_espace_allowed_tags) . '</form>', $html);
      }
      return $html;
    }
  );

  add_filter(
    'hf_validate_form',
    function ($error_code, $form, $data) {
      $plugin = AltchaPlugin::$instance;
      $mode = $plugin->get_integration_html_forms();
      if (!empty($mode)) {
        if ($mode === "shortcode" && strpos($form, "<altcha-widget ") === false) {
          // if the altcha widget is not found in the form markup in shortcode mode, skip verification
          return $error_code;
        }
        if ($mode === "captcha" || $mode === "captcha_spamfilter" || $mode === "shortcode") {
          $altcha = isset($_POST['altcha']) ? trim(sanitize_text_field($_POST['altcha'])) : '';
          if ($plugin->verify($altcha ) === false) {
            return "altcha_invalid";
          }
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
      return __('Could not verify you are not a robot.', 'altcha-spam-protection');
    }
  );

  add_filter(
    'hf_form_message_altcha_spam',
    function ($message) {
      return __('Could not verify you are not a robot.', 'altcha-spam-protection');
    }
  );
}
