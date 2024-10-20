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
      AltchaPlugin::$option_language
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
      AltchaPlugin::$option_integration_forminator
    );

    register_setting(
      'altcha_options',
      AltchaPlugin::$option_integration_gravityforms
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
        "hint" => "Select the API region.",
        "options" => array(
          "selfhosted" => "Self-hosted",
          "eu" => "EU (eu.altcha.org)",
          "us" => "USA (us.altcha.org)"
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
        "hint" => "Configure your API Key. Only for API modes. Leave this field empty in self-hosted.",
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
        "hint" => "Configure your API Key secret or HMAC signing secret.",
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
        "hint" => "Select the PoW complexity for the widget.",
        "options" => array(
          "low" => "Low",
          "medium" => "Medium",
          "high" => "High"
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
        "hint" => "Select the life-span of the challenge.",
        "options" => array(
          "3600" => "1 hour",
          "14400" => "4 hours",
          "0" => "None",
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
        "description" => "Yes",
        "hint" => "Don't allow form submissions if the Spam Filter detects potential spam.",
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
        "description" => "Yes",
        "hint" => "Whether to send the user's IP address for classification.",
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
      'altcha_settings_language_field',
      __('Language', 'altcha-spam-protection'),
      'altcha_settings_select_callback',
      'altcha_admin',
      'altcha_widget_settings_section',
      array(
        "name" => AltchaPlugin::$option_language,
        "hint" => "Select the language of the verification widget.",
        "options" => ALTCHA_LANGUAGES
      )
    );

    add_settings_field(
      'altcha_settings_auto_field',
      __('Auto verification', 'altcha-spam-protection'),
      'altcha_settings_select_callback',
      'altcha_admin',
      'altcha_widget_settings_section',
      array(
        "name" => AltchaPlugin::$option_auto,
        "hint" => "Select auto-verification behaviour.",
        "options" => array(
          "" => "Disabled",
          "onload" => "On page load",
          "onfocus" => "On form focus",
          "onsubmit" => "On form submit",
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
        "description" => "Yes",
        "hint" => "Enable Floating UI.",
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
        "description" => "Yes",
        "hint" => "Add a delay of 1.5 seconds to verification.",
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
        "description" => "Yes",
        "hint" => "Not available with Free API Keys.",
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
        "description" => "Yes",
        "hint" => "Hide Powered by ALTCHA. Not available with Free API Keys.",
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
        'Contact Form 7',
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
              "" => "Disable",
              "captcha" => "Captcha",
              "captcha_spamfilter" => "Captcha + Spam Filter",
              "shortcode" => "Shortcode",
            ),
        )
    );

    add_settings_field(
        'altcha_settings_elementor_integration_field',
        'Elementor Pro Forms',
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
              "" => "Disable",
              "captcha" => "Captcha",
              "captcha_spamfilter" => "Captcha + Spam Filter",
            ),
        )
    );

    add_settings_field(
        'altcha_settings_forminator_integration_field',
        'Forminator',
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
              "" => "Disable",
              "captcha" => "Captcha",
              "captcha_spamfilter" => "Captcha + Spam Filter",
            ),
        )
    );

    add_settings_field(
        'altcha_settings_gravityforms_integration_field',
        'Gravity Forms',
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
              "" => "Disable",
              "captcha" => "Captcha",
              "captcha_spamfilter" => "Captcha + Spam Filter",
            ),
        )
    );

    add_settings_field(
        'altcha_settings_html_forms_integration_field',
        'HTML Forms',
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
              "" => "Disable",
              "captcha" => "Captcha",
              "captcha_spamfilter" => "Captcha + Spam Filter",
              "shortcode" => "Shortcode",
            ),
        )
    );

    add_settings_field(
        'altcha_settings_wpdiscuz_integration_field',
        'WPDiscuz',
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
              "" => "Disable",
              "captcha" => "Captcha",
              "captcha_spamfilter" => "Captcha + Spam Filter",
            ),
        )
    );

    add_settings_field(
        'altcha_settings_wpforms_integration_field',
        'WP Forms',
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
              "" => "Disable",
              "captcha" => "Captcha",
              "captcha_spamfilter" => "Captcha + Spam Filter",
            ),
        )
    );

    add_settings_field(
        'altcha_settings_custom_integration_field',
        'Custom HTML',
        'altcha_settings_select_callback',
        'altcha_admin',
        'altcha_integrations_settings_section',
        array(
            "name" => AltchaPlugin::$option_integration_custom,
            "hint" => "Use [altcha] shortcode anywhere in your HTML.",
            "spamfilter_options" => array(
              "spamfilter",
              "captcha_spamfilter",
            ),
            "options" => array(
              "" => "Disable",
              "captcha" => "Captcha",
              "captcha_spamfilter" => "Captcha + Spam Filter",
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
        'Register page',
        'altcha_settings_select_callback',
        'altcha_admin',
        'altcha_wordpress_settings_section',
        array(
            "name" => AltchaPlugin::$option_integration_wordpress_register,
            "spamfilter_options" => array(
              "captcha_spamfilter",
            ),
            "options" => array(
              "" => "Disable",
              "captcha" => "Captcha",
              "captcha_spamfilter" => "Captcha + Spam Filter",
            ),
        )
    );

    add_settings_field(
        'altcha_settings_wordpress_reset_password_integration_field',
        'Reset password page',
        'altcha_settings_select_callback',
        'altcha_admin',
        'altcha_wordpress_settings_section',
        array(
            "name" => AltchaPlugin::$option_integration_wordpress_reset_password,
            "spamfilter_options" => array(
              "captcha_spamfilter",
            ),
            "options" => array(
              "" => "Disable",
              "captcha" => "Captcha",
              "captcha_spamfilter" => "Captcha + Spam Filter",
            ),
        )
    );

    add_settings_field(
        'altcha_settings_wordpress_login_integration_field',
        'Login page',
        'altcha_settings_select_callback',
        'altcha_admin',
        'altcha_wordpress_settings_section',
        array(
            "name" => AltchaPlugin::$option_integration_wordpress_login,
            "spamfilter_options" => array(
              "captcha_spamfilter",
            ),
            "options" => array(
              "" => "Disable",
              "captcha" => "Captcha",
              "captcha_spamfilter" => "Captcha + Spam Filter",
            ),
        )
    );

    add_settings_field(
        'altcha_settings_wordpress_comments_integration_field',
        'Comments',
        'altcha_settings_select_callback',
        'altcha_admin',
        'altcha_wordpress_settings_section',
        array(
            "name" => AltchaPlugin::$option_integration_wordpress_comments,
            "spamfilter_options" => array(
              "captcha_spamfilter",
            ),
            "options" => array(
              "" => "Disable",
              "captcha" => "Captcha",
              "captcha_spamfilter" => "Captcha + Spam Filter",
            ),
        )
    );
  }
}
