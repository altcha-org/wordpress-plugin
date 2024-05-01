<?php

if (altcha_plugin_active('contact-form-7')) {
  add_filter(
    'wpcf7_form_elements',
    function ($elements) {
      $plugin = AltchaPlugin::$instance;
      $mode = $plugin->get_integration_contact_form_7();
      if ($mode === "captcha" || $mode === "captcha_spamfilter") {
        altcha_enqueue_scripts();
        altcha_enqueue_styles();
        $elements .= $plugin->render_widget($mode);
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
      $plugin = AltchaPlugin::$instance;
      $mode = $plugin->get_integration_contact_form_7();
      if ($mode === "spamfilter") {
        return $plugin->spam_filter_check($_POST) === false;
      } else if ($mode === "captcha" || $mode === "captcha_spamfilter") {
        return $plugin->verify($_POST['altcha']) === false;
      }
      return $spam;
    },
    9,
    1
  );
}
