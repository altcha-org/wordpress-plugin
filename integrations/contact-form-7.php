<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if (altcha_plugin_active('contact-form-7')) {
  add_filter('wpcf7_form_elements', 'do_shortcode');

  add_filter(
    'wpcf7_form_elements',
    function ($elements) {
      $plugin = AltchaPlugin::$instance;
      $mode = $plugin->get_integration_contact_form_7();
      if (!empty($mode)) {
        $elements .= wp_nonce_field('altcha_verification', '_altchanonce', true, false);
      }
      if ($mode === "captcha" || $mode === "captcha_spamfilter") {
        $button = '<input class="wpcf7-form-control wpcf7-submit ';
        $widget = wp_kses($plugin->render_widget($mode, true), AltchaPlugin::$html_espace_allowed_tags);
        if (str_contains($elements, $button)) {
          $elements = str_replace($button, $widget . $button, $elements);
        } else {
          $elements .= $widget;
        }
      }
      return $elements;
    },
    100,
    1
  );

  add_filter(
    'wpcf7_spam',
    function ($spam) {
      if ($spam) {
        return $spam;
      }
      $nonceok = true;
      $plugin = AltchaPlugin::$instance;
      $mode = $plugin->get_integration_contact_form_7();
      if (!empty($mode) && (wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_altchanonce'])), 'altcha_verification') !== false || $nonceok)) {
        if ($mode === "captcha" || $mode === "captcha_spamfilter" || $mode === "shortcode") {
          $altcha = isset($_POST['altcha']) ? trim(sanitize_text_field($_POST['altcha'])) : '';
          return $plugin->verify($altcha) === false;
        }
      }
      return $spam;
    },
    9,
    1
  );
}
