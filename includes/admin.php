<?php

if ( ! defined( 'ABSPATH' ) ) exit;

require plugin_dir_path(__FILE__) . '../admin/options.php';

if (is_admin()) {

    add_action('admin_menu', 'altcha_options_page');

    // Add link to settings page in the navbar
    function altcha_options_page()
    {
        add_options_page(
            __('ALTCHA Spam Protection', 'altcha-spam-protection'),
            __('ALTCHA Anti-spam', 'altcha-spam-protection'),
            'manage_options',
            'altcha_admin',
            'altcha_options_page_html',
            30
        );
    }

    // Add link to settings in the plugin list
    add_filter('plugin_action_links_altcha/altcha.php', 'altcha_settings_link');
    add_filter('plugin_action_links_altcha-spam-protection/altcha.php', 'altcha_settings_link');

    function altcha_settings_link($links)
    {
        $url = esc_url(add_query_arg(
            'page',
            'altcha_admin',
            get_admin_url() . 'options-general.php'
        ));
        $settings_link = "<a href='$url'>" . __('Settings') . '</a>';

        array_unshift(
            $links,
            $settings_link
        );
        return $links;
    }
}
