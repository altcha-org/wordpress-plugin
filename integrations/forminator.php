<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if (altcha_plugin_active('forminator')) {
  add_action(
    'forminator_render_button_markup',
    function ($html) {
      return altcha_forminator_render_widget($html);
    },
    10,
    2
  );

  add_action(
    'forminator_render_fields_markup',
    function ($html) {
      return altcha_forminator_render_widget($html);
    },
    10,
    2
  );

  add_filter(
    'forminator_cform_form_is_submittable',
    function ($can_show, $id, $form_settings) {
      $plugin = AltchaPlugin::$instance;
      $mode = $plugin->get_integration_forminator();
      if (!empty($mode) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['forminator_nonce'])), 'forminator_submit_form') !== false) {
        if ($mode === "spamfilter") {
          $ignore_fields = array(
            'referer_url' => true,
            'forminator_nonce' => true,
            'form_id' => true,
            'page_id' => true,
            'form_type' => true,
            'current_url' => true,
            'render_id' => true,
            'action' => true,
          );
          if ($plugin->spam_filter_check($plugin->sanitize_data($_POST), null, $ignore_fields) === false) {
            return [
              'can_submit' => false,
              'error' => __('Cannot submit your message.', 'altcha-spam-protection'),
            ];
          }
        } else if ($mode === "captcha" || $mode === "captcha_spamfilter") {
          $altcha = isset($_POST['altcha']) ? trim(sanitize_text_field($_POST['altcha'])) : '';
          if ($plugin->verify($altcha) === false) {
            return [
              'can_submit' => false,
              'error' => __('Cannot submit your message.', 'altcha-spam-protection'),
            ];
          }
        }
      }
      return $can_show;
    },
    10,
    3
  );
}

function altcha_forminator_render_widget($html)
{
  $plugin = AltchaPlugin::$instance;
  $mode = $plugin->get_integration_forminator();
  if ($mode === "captcha" || $mode === "captcha_spamfilter") {
    altcha_enqueue_scripts();
    altcha_enqueue_styles();
    $elements = wp_kses($plugin->render_widget($mode, true), AltchaPlugin::$html_espace_allowed_tags);
    return str_replace('<button ', $elements . '<button ', $html);
  }
  return $html;
}