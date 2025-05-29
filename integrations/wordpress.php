<?php

if ( ! defined( 'ABSPATH' ) ) exit;

add_action(
  'register_form',
  function () {
    $plugin = AltchaPlugin::$instance;
    $mode = $plugin->get_integration_wordpress_register();
    if (!empty($mode)) {
      altcha_wordpress_comments_render_widget($mode, 'altcha_register');
    }
  },
  10,
  0
);

add_action(
  'register_post',
  function ($user_login, $user_email, $errors) {
    $plugin = AltchaPlugin::$instance;
    $mode = $plugin->get_integration_wordpress_register();
    if (!empty($mode)) {
      $altcha = isset($_POST['altcha_register']) ? trim(sanitize_text_field($_POST['altcha_register'])) : '';
      if ($plugin->verify($altcha) === false) {
        return $errors->add(
          'altcha_error_message',
          '<strong>' . esc_html__('Error', 'altcha-spam-protection') . '</strong> : ' . esc_html__('Could not verify you are not a robot.', 'altcha-spam-protection')
        );
      }
    }
    return $errors;
  },
  10,
  3
);

add_action(
  'login_form',
  function () {
    $plugin = AltchaPlugin::$instance;
    $mode = $plugin->get_integration_wordpress_login();
    if (!empty($mode)) {
      altcha_wordpress_comments_render_widget($mode);
    }
  },
  10,
  0
);

add_filter(
  'authenticate',
  function ($user, $username, $password) {
    if ($user instanceof WP_Error) {
      return $user;
    }
    if(defined('XMLRPC_REQUEST') && XMLRPC_REQUEST) {
      return $user; // Skip XMLRPC
    }
    if(defined('REST_REQUEST') && REST_REQUEST) {
      return $user; // Skip REST API
    }
    if(altcha_plugin_active('woocommerce') && isset($_POST['woocommerce-login-nonce'])) {
      return $user; // WooCommerce form submissions are handled separately
    }
    $plugin = AltchaPlugin::$instance;
    $mode = $plugin->get_integration_wordpress_login();
    if (!empty($mode)) {
      $altcha = isset($_POST['altcha']) ? trim(sanitize_text_field($_POST['altcha'])) : '';
      if ($plugin->verify($altcha) === false) {
        return new WP_Error("altcha-error", '<strong>' . esc_html__('Error', 'altcha-spam-protection') . '</strong> : ' . esc_html__('Could not verify you are not a robot.', 'altcha-spam-protection'));
      }
    }
    return $user;
  },
  20,
  3
);

add_action(
  'lostpassword_form',
  function () {
    $plugin = AltchaPlugin::$instance;
    $mode = $plugin->get_integration_wordpress_reset_password();
    if (!empty($mode)) {
      altcha_wordpress_comments_render_widget($mode);
    }
  },
  10,
  0
);

add_filter(
  'lostpassword_post',
  function ($errors) {
    if (is_user_logged_in()) {
      return $errors;
    }
    if(altcha_plugin_active('woocommerce') && isset($_POST['woocommerce-lost-password-nonce'])) {
      return $errors; // WooCommerce form submissions are handled separately
    }
    $plugin = AltchaPlugin::$instance;
    $mode = $plugin->get_integration_wordpress_reset_password();
    if (!empty($mode)) {
      $altcha = isset($_POST['altcha']) ? trim(sanitize_text_field($_POST['altcha'])) : '';
      if ($plugin->verify($altcha) === false) {
        $errors->add(
          'altcha_error_message',
          '<strong>' . esc_html__('Error', 'altcha-spam-protection') . '</strong> : ' . esc_html__('Could not verify you are not a robot.', 'altcha-spam-protection')
        );
      }
    }
    return $errors;
  },
  10,
  1
);

add_action(
  'comment_form_after_fields',
  function () {
    $plugin = AltchaPlugin::$instance;
    $mode = $plugin->get_integration_wordpress_comments();
    if (!empty($mode)) {
      altcha_wordpress_comments_render_widget($mode);
    }
  },
  10,
  0
);

add_action(
  'comment_form_logged_in_after',
  function () {
    $plugin = AltchaPlugin::$instance;
    $mode = $plugin->get_integration_wordpress_comments();
    if (!empty($mode)) {
      altcha_wordpress_comments_render_widget($mode);
    }
  },
  10,
  0
);

add_filter(
  'preprocess_comment',
  function ($comment) {
    // trackback or pingback
    if ($comment['comment_type'] != '' && $comment['comment_type'] != 'comment') {
      return $comment;
    }
    // admin replies
    if (is_user_logged_in() && current_user_can('manage_options')) {
      return $comment;
    }
    $plugin = AltchaPlugin::$instance;
    $mode = (altcha_plugin_active('wpdiscuz') && $plugin->get_integration_wpdiscuz()) || $plugin->get_integration_wordpress_comments();
    if (!empty($mode)) {
      $altcha = isset($_POST['altcha']) ? trim(sanitize_text_field($_POST['altcha'])) : '';
      if ($plugin->verify($altcha) === false) {
        wp_die('<strong>' . esc_html__('Error', 'altcha-spam-protection') . '</strong> : ' . esc_html__('Could not verify you are not a robot.', 'altcha-spam-protection'));
      }
    }
    return $comment;
  },
  10,
  1
);

function altcha_wordpress_comments_render_widget($mode, $name = null)
{
  $plugin = AltchaPlugin::$instance;
  echo wp_kses($plugin->render_widget($mode, true, null, $name), AltchaPlugin::$html_espace_allowed_tags);
}