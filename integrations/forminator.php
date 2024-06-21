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
      if ($mode === "spamfilter") {
        if ($plugin->spam_filter_check($_POST) === false) {
          return [
            'can_submit' => false,
            'error' => __('Cannot submit your message.', "altcha"),
          ];
        }
      } else if ($mode === "captcha" || $mode === "captcha_spamfilter") {
        if ($plugin->verify(altcha_get_sanitized_solution_from_post()) === false) {
          return [
            'can_submit' => false,
            'error' => __('Cannot submit your message.', "altcha"),
          ];
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
    $elements = $plugin->render_widget($mode, true);
    return str_replace('<button ', $elements . '<button ', $html);
  }
  return $html;
}