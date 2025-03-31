<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists("insertBeforeKey") ) {

  function insertBeforeKey( $array, $key, $newKey, $newValue )
  {
    $newArray = [];

    foreach ( $array as $k => $v ) {
      // Insert the new key-value pair before the specific key
      if ( $k === $key ) {
        $newArray[$newKey] = $newValue;
      }
      // Add the original key-value pair
      $newArray[$k] = $v;
    }

    return $newArray;
  }
}

if ( ! function_exists('altcha_enfold_theme_add_captcha_field') ) {
  function altcha_enfold_theme_add_captcha_field($elements)
  {
    $plugin = AltchaPlugin::$instance;
    $mode = $plugin->get_integration_enfold_theme();
    if ($mode !== 'captcha' && $mode !== 'captcha_spamfilter') {
      return $elements;
    }

    altcha_enqueue_scripts();
    altcha_enqueue_styles();
    $captcha = [
      "id"        => "captcha",
      "type"      => "html",
      "content"   =>  wp_kses($plugin->render_widget($mode, true), AltchaPlugin::$html_espace_allowed_tags)
    ];

    $new = insertBeforeKey($elements, 'av-button', 'captcha', $captcha);
    return $new;
  }
}

add_filter( 'ava_mailchimp_contact_form_elements', 'altcha_enfold_theme_add_captcha_field' );

add_filter( 'avia_contact_form_elements', 'altcha_enfold_theme_add_captcha_field' );

add_filter( 'avf_form_send', function ($proceed, $new_post, $form_params, $that)
{
  /** @var avia_form $that */
  $plugin = AltchaPlugin::$instance;
  $mode = $plugin->get_integration_enfold_theme();
  error_log($mode);
  if (!empty($mode)) {
    $altcha = isset($_POST['altcha']) ? trim(sanitize_text_field(urldecode($_POST['altcha']))) : '';
    if ($plugin->verify($altcha) === false) {
      $that->submit_error = __('Verification failed. Try again later.', 'altcha-spam-protection');
      error_log("altcha: verification failed");
      return null;
    }
  }
  return $proceed;
}, 10, 4);

add_filter( 'avf_mailchimp_subscriber_data', function ($data, $that)
{
  /** @var avia_sc_mailchimp $that */
  $plugin = AltchaPlugin::$instance;
  $mode = $plugin->get_integration_enfold_theme();
  if ( ! empty($mode) ) {
    $altcha = isset($_POST['altcha']) ? trim(sanitize_text_field(urldecode($_POST['altcha']))) : '';
    if ($plugin->verify($altcha) === false) {
      /* Only changing the email_address promts the user to enter a valid email address, which would confuse them. */
      $data['email_address'] = 'captcha failed';
      $data['status'] = 'THIS STATUS DOES NOT EXIST';
    }
  }
  return $data;
}, 10, 2);
