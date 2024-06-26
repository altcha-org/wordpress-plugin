<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if (altcha_plugin_active('wpforms')) {
  add_filter(
    'wpforms_display_submit_before',
    function () {
      $plugin = AltchaPlugin::$instance;
      $mode = $plugin->get_integration_wpforms();
      if (!empty($mode)) {
        echo wp_kses(wp_nonce_field('altcha_verification', '_altchanonce'), AltchaPlugin::$html_espace_allowed_tags);
      }
      if ($mode === "captcha" || $mode === "captcha_spamfilter") {
        altcha_enqueue_scripts();
        altcha_enqueue_styles();
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
      if (!empty($mode) && wp_verify_nonce($_POST['_altchanonce'], 'altcha_verification') !== false) {
        if ($mode === "spamfilter") {
          $ignore_fields = array(
            'wpforms[id]' => true,
            'wpforms[nonce]' => true,
            'wpforms[post_id]' => true,
            'wpforms[submit]' => true,
            'wpforms[token]' => true,
            'action' => true,
            'page_title' => true,
            'page_url' => true,
            'page_id' => true,
            'start_timestamp' => true,
            'end_timestamp' => true,
          );
          if ($plugin->spam_filter_check($plugin->sanitize_data($_POST), null, $ignore_fields) === false) {
            wpforms()->process->errors[$form_data['id']]['header'] = esc_html__('Cannot submit your message.', 'altcha-spam-protection');
          }
        } else if ($mode === "captcha" || $mode === "captcha_spamfilter") {
          $altcha = isset($_POST['altcha']) ? trim(sanitize_text_field($_POST['altcha'])) : '';
          if ($plugin->verify($altcha) === false) {
            wpforms()->process->errors[$form_data['id']]['header'] = esc_html__('Cannot submit your message.', 'altcha-spam-protection');
          }
        }
      }
    },
    10,
    3
  );
}