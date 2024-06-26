<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if (altcha_plugin_active('gravityforms')) {
  add_action(
    'gform_loaded',
    function () {
      $plugin = AltchaPlugin::$instance;
      $mode = $plugin->get_integration_gravityforms();
      if ($mode === 'captcha' || $mode === 'captcha_spamfilter') {
        require_once('gravityforms/addon.php');
        GFAddOn::register('ALTCHA_GFFormsAddOn');
      }
    },
    5
  );

  add_action('gform_submit_button', function ($button) {
    return wp_nonce_field('altcha_verification', '_altchanonce') . $button;
  }, 10, 6);

  add_filter(
    'gform_entry_is_spam',
    function ($is_spam, $form, $entry) {
      if ($is_spam) {
        return $is_spam;
      }
      $plugin = AltchaPlugin::$instance;
      $mode = $plugin->get_integration_gravityforms();
      if (!empty($mode) && wp_verify_nonce($_POST['_altchanonce'], 'altcha_verification') !== false) {
        if ($mode === 'spamfilter') {
          $ip = rgars($form, 'personalData/preventIP') ? GFFormsModel::get_ip() : rgar($entry, 'ip');
          $ignore_fields = array(
            'is_submit_1' => true,
            'gform_submit' => true,
            'gform_unique_id' => true,
            'state_1' => true,
            'gform_target_page_number_1' => true,
            'gform_source_page_number_1' => true,
            'gform_field_values' => true,
            'version_hash' => true,
          );
          if ($plugin->spam_filter_check($plugin->sanitize_data($_POST), $ip, $ignore_fields) === false) {
            $is_spam = true;
          }
        } else if ($mode === 'captcha_spamfilter') {
          if ($plugin->spamfilter_result && $plugin->spamfilter_result['classification'] === 'BAD') {
            $is_spam = true;
          }
        }
      }
      if ($is_spam && method_exists('GFCommon', 'set_spam_filter')) {
        $reason = "";
        if ($plugin->spamfilter_result) {
          $score =  $plugin->spamfilter_result['score'];
          $reason = "score: $score, " . implode(', ', $plugin->spamfilter_result['reasons']);
        }
        GFCommon::set_spam_filter(rgar($form, 'id'), 'ALTCHA Spam Filter', $reason);
      }
      return $is_spam;
    },
    10,
    3
  );
}
