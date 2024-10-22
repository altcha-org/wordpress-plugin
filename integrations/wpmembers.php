<?php

if ( ! defined( 'ABSPATH' ) ) exit;

add_action(
  'wpmem_pre_register_data',
  function () {
    $plugin = AltchaPlugin::$instance;
    // WP-members uses native wordpress integration and does not have an activation select
    // If this hook is being called and wordpress register is enabled, validate altcha
    $mode = $plugin->get_integration_wordpress_register();
    if (!empty($mode)) {
      $altcha = isset($_POST['altcha_register']) ? trim(sanitize_text_field($_POST['altcha_register'])) : '';
      if ($plugin->verify($altcha) === false) {
        global $wpmem_themsg;
        $wpmem_themsg = esc_html__('Registration failed. Please try again later.', 'altcha-spam-protection');
      }
    }
  },
  10,
  0
);