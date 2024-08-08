<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if (altcha_plugin_active('html-forms')) {
  add_filter(
    'hf_form_html',
    function ($html) {
      $plugin = AltchaPlugin::$instance;
      $mode = $plugin->get_integration_html_forms();
      if (!empty($mode)) {
        $html = str_replace('</form>', wp_nonce_field('altcha_verification', '_altchanonce') . '</form>', $html);
      }
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
      if (!empty($mode) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_altchanonce'])), 'altcha_verification') !== false) {
        if ($mode === "captcha" || $mode === "captcha_spamfilter") {
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
      return __('Cannot submit your message.', 'altcha-spam-protection');
    }
  );

  add_filter(
    'hf_form_message_altcha_spam',
    function ($message) {
      return __('Cannot submit your message.', 'altcha-spam-protection');
    }
  );
}
