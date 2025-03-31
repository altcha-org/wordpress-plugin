<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if (is_admin()) {
  add_action('admin_init', 'altcha_settings_init');

  function altcha_settings_init()
  {
    register_setting(
      'altcha_options',
      AltchaPlugin::$option_api
    );

    register_setting(
      'altcha_options',
      AltchaPlugin::$option_api_key
    );

    register_setting(
      'altcha_options',
      AltchaPlugin::$option_secret
    );

    register_setting(
      'altcha_options',
      AltchaPlugin::$option_complexity
    );

    register_setting(
      'altcha_options',
      AltchaPlugin::$option_expires
    );

    register_setting(
      'altcha_options',
      AltchaPlugin::$option_hidefooter
    );

    register_setting(
      'altcha_options',
      AltchaPlugin::$option_hidelogo
    );

    register_setting(
      'altcha_options',
      AltchaPlugin::$option_blockspam
    );

    register_setting(
      'altcha_options',
      AltchaPlugin::$option_send_ip
    );

    register_setting(
      'altcha_options',
      AltchaPlugin::$option_auto
    );

    register_setting(
      'altcha_options',
      AltchaPlugin::$option_floating
    );

    register_setting(
      'altcha_options',
      AltchaPlugin::$option_delay
    );

    register_setting(
      'altcha_options',
      AltchaPlugin::$option_integration_contact_form_7
    );

    register_setting(
      'altcha_options',
      AltchaPlugin::$option_integration_custom
    );

    register_setting(
      'altcha_options',
      AltchaPlugin::$option_integration_elementor
    );

    register_setting(
      'altcha_options',
      AltchaPlugin::$option_integration_enfold_theme
    );

    register_setting(
      'altcha_options',
      AltchaPlugin::$option_integration_forminator
    );

    register_setting(
      'altcha_options',
      AltchaPlugin::$option_integration_gravityforms
    );

    register_setting(
      'altcha_options',
      AltchaPlugin::$option_integration_woocommerce_login
    );

    register_setting(
      'altcha_options',
      AltchaPlugin::$option_integration_woocommerce_register
    );

    register_setting(
      'altcha_options',
      AltchaPlugin::$option_integration_woocommerce_reset_password
    );

    register_setting(
      'altcha_options',
      AltchaPlugin::$option_integration_html_forms
    );

    register_setting(
      'altcha_options',
      AltchaPlugin::$option_integration_wordpress_comments
    );

    register_setting(
      'altcha_options',
      AltchaPlugin::$option_integration_wordpress_login
    );

    register_setting(
      'altcha_options',
      AltchaPlugin::$option_integration_wordpress_register
    );

    register_setting(
      'altcha_options',
      AltchaPlugin::$option_integration_wordpress_reset_password
    );

    register_setting(
      'altcha_options',
      AltchaPlugin::$option_integration_wpdiscuz
    );

    register_setting(
      'altcha_options',
      AltchaPlugin::$option_integration_wpforms
    );

    // Section
    add_settings_section(
      'altcha_general_settings_section',
      __('General', 'altcha-spam-protection'),
      'altcha_general_section_callback',
      'altcha_admin'
    );

    add_settings_field(
      'altcha_settings_api_field',
      __('API Region', 'altcha-spam-protection'),
      'altcha_settings_select_callback',
      'altcha_admin',
      'altcha_general_settings_section',
      array(
        "name" => AltchaPlugin::$option_api,
        "hint" => __('Select the API region.', 'altcha-spam-protection'),
        "options" => array(
          "selfhosted" => __('Self-hosted', 'altcha-spam-protection'),
          "eu" => __('EU (eu.altcha.org)', 'altcha-spam-protection'),
          "us" => __('USA (us.altcha.org)', 'altcha-spam-protection'),
        )
      )
    );

    add_settings_field(
      'altcha_settings_api_key_field',
      __('API Key', 'altcha-spam-protection'),
      'altcha_settings_field_callback',
      'altcha_admin',
      'altcha_general_settings_section',
      array(
        "spamfilter" => true,
        "name" => AltchaPlugin::$option_api_key,
        "hint" => __('Configure your API Key. Only for API modes. Leave this field empty in self-hosted.', 'altcha-spam-protection'),
        "type" => "text"
      )
    );

    add_settings_field(
      'altcha_settings_secret_field',
      __('Secret Key', 'altcha-spam-protection'),
      'altcha_settings_field_callback',
      'altcha_admin',
      'altcha_general_settings_section',
      array(
        "name" => AltchaPlugin::$option_secret,
        "hint" => __('Configure your API Key secret or HMAC signing secret.', 'altcha-spam-protection'),
        "type" => "text"
      )
    );

    add_settings_field(
      'altcha_settings_complexity_field',
      __('Complexity', 'altcha-spam-protection'),
      'altcha_settings_select_callback',
      'altcha_admin',
      'altcha_general_settings_section',
      array(
        "name" => AltchaPlugin::$option_complexity,
        "hint" => __('Select the PoW complexity for the widget.', 'altcha-spam-protection'),
        "options" => array(
          "low" => __('Low', 'altcha-spam-protection'),
          "medium" => __('Medium', 'altcha-spam-protection'),
          "high" => __('High', 'altcha-spam-protection'),
        )
      )
    );

    add_settings_field(
      'altcha_settings_expires_field',
      __('Expiration', 'altcha-spam-protection'),
      'altcha_settings_select_callback',
      'altcha_admin',
      'altcha_general_settings_section',
      array(
        "name" => AltchaPlugin::$option_expires,
        "hint" => __('Select the life-span of the challenge.', 'altcha-spam-protection'),
        "options" => array(
          "3600" => __('1 hour', 'altcha-spam-protection'),
          "14400" => __('4 hours', 'altcha-spam-protection'),
          "0" => __('None', 'altcha-spam-protection'),
        )
      )
    );

    // Section
    add_settings_section(
      'altcha_spamfilter_settings_section',
      __('Spam Filter', 'altcha-spam-protection'),
      'altcha_spam_filter_section_callback',
      'altcha_admin'
    );

    add_settings_field(
      'altcha_settings_blockspam_field',
      __('Block Spam Submissions', 'altcha-spam-protection'),
      'altcha_settings_field_callback',
      'altcha_admin',
      'altcha_spamfilter_settings_section',
      array(
        "spamfilter" => true,
        "name" => AltchaPlugin::$option_blockspam,
        "description" => __('Yes', 'altcha-spam-protection'),
        "hint" => __('Don\'t allow form submissions if the Spam Filter detects potential spam.', 'altcha-spam-protection'),
        "type" => "checkbox"
      )
    );

    add_settings_field(
      'altcha_settings_send_ip_field',
      __('Classify IP address', 'altcha-spam-protection'),
      'altcha_settings_field_callback',
      'altcha_admin',
      'altcha_spamfilter_settings_section',
      array(
        "spamfilter" => true,
        "name" => AltchaPlugin::$option_send_ip,
        "description" => __('Yes', 'altcha-spam-protection'),
        "hint" => __('Whether to send the user\'s IP address for classification.', 'altcha-spam-protection'),
        "type" => "checkbox"
      )
    );

    // Section
    add_settings_section(
      'altcha_widget_settings_section',
      __('Widget Customization', 'altcha-spam-protection'),
      'altcha_widget_section_callback',
      'altcha_admin'
    );

    add_settings_field(
      'altcha_settings_auto_field',
      __('Auto verification', 'altcha-spam-protection'),
      'altcha_settings_select_callback',
      'altcha_admin',
      'altcha_widget_settings_section',
      array(
        "name" => AltchaPlugin::$option_auto,
        "hint" => __('Select auto-verification behaviour.', 'altcha-spam-protection'),
        "options" => array(
          "" => __('Disabled', 'altcha-spam-protection'),
          "onload" => __('On page load', 'altcha-spam-protection'),
          "onfocus" => __('On form focus', 'altcha-spam-protection'),
          "onsubmit" => __('On form submit', 'altcha-spam-protection'),
        )
      )
    );

    add_settings_field(
      'altcha_settings_floating_field',
      __('Floating UI', 'altcha-spam-protection'),
      'altcha_settings_field_callback',
      'altcha_admin',
      'altcha_widget_settings_section',
      array(
        "name" => AltchaPlugin::$option_floating,
        "description" => __('Yes', 'altcha-spam-protection'),
        "hint" => __('Enable Floating UI.', 'altcha-spam-protection'),
        "type" => "checkbox"
      )
    );

    add_settings_field(
      'altcha_settings_delay_field',
      __('Delay', 'altcha-spam-protection'),
      'altcha_settings_field_callback',
      'altcha_admin',
      'altcha_widget_settings_section',
      array(
        "name" => AltchaPlugin::$option_delay,
        "description" => __('Yes', 'altcha-spam-protection'),
        "hint" => __('Add a delay of 1.5 seconds to verification.', 'altcha-spam-protection'),
        "type" => "checkbox"
      )
    );

    add_settings_field(
      'altcha_settings_hidelogo_field',
      __('Hide logo', 'altcha-spam-protection'),
      'altcha_settings_field_callback',
      'altcha_admin',
      'altcha_widget_settings_section',
      array(
        "name" => AltchaPlugin::$option_hidelogo,
        "description" => __('Yes', 'altcha-spam-protection'),
        "hint" => __('Not available with Free API Keys.', 'altcha-spam-protection'),
        "type" => "checkbox"
      )
    );

    add_settings_field(
      'altcha_settings_hidefooter_field',
      __('Hide footer', 'altcha-spam-protection'),
      'altcha_settings_field_callback',
      'altcha_admin',
      'altcha_widget_settings_section',
      array(
        "name" => AltchaPlugin::$option_hidefooter,
        "description" => __('Yes', 'altcha-spam-protection'),
        "hint" => __('Hide Powered by ALTCHA. Not available with Free API Keys.', 'altcha-spam-protection'),
        "type" => "checkbox"
      )
    );

    // Section
    add_settings_section(
      'altcha_integrations_settings_section',
      __('Integrations', 'altcha-spam-protection'),
      'altcha_integrations_section_callback',
      'altcha_admin'
    );

    add_settings_field(
        'altcha_settings_contact_form_7_integration_field',
        __('Contact Form 7', 'altcha-spam-protection'),
        'altcha_settings_select_callback',
        'altcha_admin',
        'altcha_integrations_settings_section',
        array(
            "name" => AltchaPlugin::$option_integration_contact_form_7,
            "disabled" => !altcha_plugin_active('contact-form-7'),
            "spamfilter_options" => array(
              "spamfilter",
              "captcha_spamfilter",
            ),
            "options" => array(
              "" => __('Disable', 'altcha-spam-protection'),
              "captcha" => __('Captcha', 'altcha-spam-protection'),
              "captcha_spamfilter" => __('Captcha + Spam Filter', 'altcha-spam-protection'),
              "shortcode" => __('Shortcode', 'altcha-spam-protection'),
            ),
        )
    );

    add_settings_field(
        'altcha_settings_elementor_integration_field',
        __('Elementor Pro Forms', 'altcha-spam-protection'),
        'altcha_settings_select_callback',
        'altcha_admin',
        'altcha_integrations_settings_section',
        array(
            "name" => AltchaPlugin::$option_integration_elementor,
            "disabled" => !altcha_plugin_active('elementor'),
            "spamfilter_options" => array(
              "spamfilter",
              "captcha_spamfilter",
            ),
            "options" => array(
              "" => __('Disable', 'altcha-spam-protection'),
              "captcha" => __('Captcha', 'altcha-spam-protection'),
              "captcha_spamfilter" => __('Captcha + Spam Filter', 'altcha-spam-protection'),
            ),
        )
    );

    add_settings_field(
      'altcha_settings_enfold_theme_integration_field',
      __('Enfold Theme', 'altcha-spam-protection'),
      'altcha_settings_select_callback',
      'altcha_admin',
      'altcha_integrations_settings_section',
      array(
        "name" => AltchaPlugin::$option_integration_enfold_theme,
        "disabled" => empty(array_filter(wp_get_themes(), function($theme) { 
          return stripos($theme, 'enfold') !== false;
          })),
        "spamfilter_options" => array(
          "spamfilter",
          "captcha_spamfilter",
        ),
        "options" => array(
          "" => __('Disable', 'altcha-spam-protection'),
          "captcha" => __('Captcha', 'altcha-spam-protection'),
          "captcha_spamfilter" => __('Captcha + Spam Filter', 'altcha-spam-protection'),
        ),
      )
    );

    add_settings_field(
        'altcha_settings_forminator_integration_field',
        __('Forminator', 'altcha-spam-protection'),
        'altcha_settings_select_callback',
        'altcha_admin',
        'altcha_integrations_settings_section',
        array(
            "name" => AltchaPlugin::$option_integration_forminator,
            "disabled" => !altcha_plugin_active('forminator'),
            "spamfilter_options" => array(
              "spamfilter",
              "captcha_spamfilter",
            ),
            "options" => array(
              "" => __('Disable', 'altcha-spam-protection'),
              "captcha" => __('Captcha', 'altcha-spam-protection'),
              "captcha_spamfilter" => __('Captcha + Spam Filter', 'altcha-spam-protection'),
            ),
        )
    );

    add_settings_field(
        'altcha_settings_gravityforms_integration_field',
        __('Gravity Forms', 'altcha-spam-protection'),
        'altcha_settings_select_callback',
        'altcha_admin',
        'altcha_integrations_settings_section',
        array(
            "name" => AltchaPlugin::$option_integration_gravityforms,
            "disabled" => !altcha_plugin_active('gravityforms'),
            "spamfilter_options" => array(
              "spamfilter",
              "captcha_spamfilter",
            ),
            "options" => array(
              "" => __('Disable', 'altcha-spam-protection'),
              "captcha" => __('Captcha', 'altcha-spam-protection'),
              "captcha_spamfilter" => __('Captcha + Spam Filter', 'altcha-spam-protection'),
            ),
        )
    );

    add_settings_field(
        'altcha_settings_html_forms_integration_field',
        __('HTML Forms', 'altcha-spam-protection'),
        'altcha_settings_select_callback',
        'altcha_admin',
        'altcha_integrations_settings_section',
        array(
            "name" => AltchaPlugin::$option_integration_html_forms,
            "disabled" => !altcha_plugin_active('html-forms'),
            "spamfilter_options" => array(
              "spamfilter",
              "captcha_spamfilter",
            ),
            "options" => array(
              "" => __('Disable', 'altcha-spam-protection'),
              "captcha" => __('Captcha', 'altcha-spam-protection'),
              "captcha_spamfilter" => __('Captcha + Spam Filter', 'altcha-spam-protection'),
              "shortcode" => __('Shortcode', 'altcha-spam-protection'),
            ),
        )
    );

    add_settings_field(
        'altcha_settings_wpdiscuz_integration_field',
        __('WPDiscuz', 'altcha-spam-protection'),
        'altcha_settings_select_callback',
        'altcha_admin',
        'altcha_integrations_settings_section',
        array(
            "name" => AltchaPlugin::$option_integration_wpdiscuz,
            "disabled" => !altcha_plugin_active('wpdiscuz'),
            "spamfilter_options" => array(
              "spamfilter",
              "captcha_spamfilter",
            ),
            "options" => array(
              "" => __('Disable', 'altcha-spam-protection'),
              "captcha" => __('Captcha', 'altcha-spam-protection'),
              "captcha_spamfilter" => __('Captcha + Spam Filter', 'altcha-spam-protection'),
            ),
        )
    );

    add_settings_field(
        'altcha_settings_wpforms_integration_field',
        __('WP Forms', 'altcha-spam-protection'),
        'altcha_settings_select_callback',
        'altcha_admin',
        'altcha_integrations_settings_section',
        array(
            "name" => AltchaPlugin::$option_integration_wpforms,
            "disabled" => !altcha_plugin_active('wpforms'),
            "spamfilter_options" => array(
              "spamfilter",
              "captcha_spamfilter",
            ),
            "options" => array(
              "" => __('Disable', 'altcha-spam-protection'),
              "captcha" => __('Captcha', 'altcha-spam-protection'),
              "captcha_spamfilter" => __('Captcha + Spam Filter', 'altcha-spam-protection'),
            ),
        )
    );

    add_settings_field(
        'altcha_settings_woocommerce_register_integration_field',
        __('WooCommerce register page', 'altcha-spam-protection'),
        'altcha_settings_select_callback',
        'altcha_admin',
        'altcha_integrations_settings_section',
        array(
            "name" => AltchaPlugin::$option_integration_woocommerce_register,
            "disabled" => !altcha_plugin_active('woocommerce'),
            "spamfilter_options" => array(
              "captcha_spamfilter",
            ),
            "options" => array(
              "" => __('Disable', 'altcha-spam-protection'),
              "captcha" => __('Captcha', 'altcha-spam-protection'),
              "captcha_spamfilter" => __('Captcha + Spam Filter', 'altcha-spam-protection'),
            ),
        )
    );

    add_settings_field(
        'altcha_settings_woocommerce_reset_password_integration_field',
        __('WooCommerce reset password page', 'altcha-spam-protection'),
        'altcha_settings_select_callback',
        'altcha_admin',
        'altcha_integrations_settings_section',
        array(
            "name" => AltchaPlugin::$option_integration_woocommerce_reset_password,
            "disabled" => !altcha_plugin_active('woocommerce'),
            "spamfilter_options" => array(
              "captcha_spamfilter",
            ),
            "options" => array(
              "" => __('Disable', 'altcha-spam-protection'),
              "captcha" => __('Captcha', 'altcha-spam-protection'),
              "captcha_spamfilter" => __('Captcha + Spam Filter', 'altcha-spam-protection'),
            ),
        )
    );

    add_settings_field(
        'altcha_settings_woocommerce_login_integration_field',
        __('WooCommerce login page', 'altcha-spam-protection'),
        'altcha_settings_select_callback',
        'altcha_admin',
        'altcha_integrations_settings_section',
        array(
            "name" => AltchaPlugin::$option_integration_woocommerce_login,
            "disabled" => !altcha_plugin_active('woocommerce'),
            "spamfilter_options" => array(
              "captcha_spamfilter",
            ),
            "options" => array(
              "" => __('Disable', 'altcha-spam-protection'),
              "captcha" => __('Captcha', 'altcha-spam-protection'),
              "captcha_spamfilter" => __('Captcha + Spam Filter', 'altcha-spam-protection'),
            ),
        )
    );

    add_settings_field(
        'altcha_settings_custom_integration_field',
        __('Custom HTML', 'altcha-spam-protection'),
        'altcha_settings_select_callback',
        'altcha_admin',
        'altcha_integrations_settings_section',
        array(
            "name" => AltchaPlugin::$option_integration_custom,
            "hint" => sprintf(
              /* translators: the placeholder will be replaced with the shortcode */
              __('Use %s shortcode anywhere in your HTML.', 'altcha-spam-protection'), '[altcha]',
            ),
            "spamfilter_options" => array(
              "spamfilter",
              "captcha_spamfilter",
            ),
            "options" => array(
              "" => __('Disable', 'altcha-spam-protection'),
              "captcha" => __('Captcha', 'altcha-spam-protection'),
              "captcha_spamfilter" => __('Captcha + Spam Filter', 'altcha-spam-protection'),
            ),
        )
    );

    // Section
    add_settings_section(
      'altcha_wordpress_settings_section',
      __('Wordpress', 'altcha-spam-protection'),
      'altcha_wordpress_section_callback',
      'altcha_admin'
    );

    add_settings_field(
        'altcha_settings_wordpress_register_integration_field',
        __('Register page', 'altcha-spam-protection'),
        'altcha_settings_select_callback',
        'altcha_admin',
        'altcha_wordpress_settings_section',
        array(
            "name" => AltchaPlugin::$option_integration_wordpress_register,
            "spamfilter_options" => array(
              "captcha_spamfilter",
            ),
            "options" => array(
              "" => __('Disable', 'altcha-spam-protection'),
              "captcha" => __('Captcha', 'altcha-spam-protection'),
              "captcha_spamfilter" => __('Captcha + Spam Filter', 'altcha-spam-protection'),
            ),
        )
    );

    add_settings_field(
        'altcha_settings_wordpress_reset_password_integration_field',
        __('Reset password page', 'altcha-spam-protection'),
        'altcha_settings_select_callback',
        'altcha_admin',
        'altcha_wordpress_settings_section',
        array(
            "name" => AltchaPlugin::$option_integration_wordpress_reset_password,
            "spamfilter_options" => array(
              "captcha_spamfilter",
            ),
            "options" => array(
              "" => __('Disable', 'altcha-spam-protection'),
              "captcha" => __('Captcha', 'altcha-spam-protection'),
              "captcha_spamfilter" => __('Captcha + Spam Filter', 'altcha-spam-protection'),
            ),
        )
    );

    add_settings_field(
        'altcha_settings_wordpress_login_integration_field',
        __('Login page', 'altcha-spam-protection'),
        'altcha_settings_select_callback',
        'altcha_admin',
        'altcha_wordpress_settings_section',
        array(
            "name" => AltchaPlugin::$option_integration_wordpress_login,
            "spamfilter_options" => array(
              "captcha_spamfilter",
            ),
            "options" => array(
              "" => __('Disable', 'altcha-spam-protection'),
              "captcha" => __('Captcha', 'altcha-spam-protection'),
              "captcha_spamfilter" => __('Captcha + Spam Filter', 'altcha-spam-protection'),
            ),
        )
    );

    add_settings_field(
        'altcha_settings_wordpress_comments_integration_field',
        __('Comments', 'altcha-spam-protection'),
        'altcha_settings_select_callback',
        'altcha_admin',
        'altcha_wordpress_settings_section',
        array(
            "name" => AltchaPlugin::$option_integration_wordpress_comments,
            "spamfilter_options" => array(
              "captcha_spamfilter",
            ),
            "options" => array(
              "" => __('Disable', 'altcha-spam-protection'),
              "captcha" => __('Captcha', 'altcha-spam-protection'),
              "captcha_spamfilter" => __('Captcha + Spam Filter', 'altcha-spam-protection'),
            ),
        )
    );
  }
}
