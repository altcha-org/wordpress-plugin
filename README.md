# ALTCHA for WordPress

This repository contains the offical ALTCHA plugin for WordPress.

ALTCHA offers a free, open-source Captcha alternative, ensuring robust spam protection while respecting user privacy and GDPR compliance.

Read more about ALTCHA: https://github.com/altcha-org/altcha

Website: https://altcha.org

WordPress Plugin Directory: https://wordpress.org/plugins/altcha-spam-protection/

> [!TIP]
> ALTCHA is now available in the WordPress Plugin Directory. You can easily install it directly from your WordPress installation.

Having troubles? Please report in [Issues](https://github.com/altcha-org/wordpress-plugin/issues).

## Supported Integrations

* CoBlocks
* Contact Form 7
* Elementor Pro Forms
* Enfold Theme
* Forminator
* GravityForms
* HTML Forms
* WPDiscuz
* WPForms
* WP-Members
* WordPress Login, Register, Password reset
* WordPress Comments
* WooCommerce
* Custom HTML (with a short code `[altcha]`)

## Floating UI

The plugin supports the [Floating UI](https://altcha.org/docs/v2/floating-ui/) but with known limitations:

Currently the Floating UI does not work with:

- Forminator with multi-step forms

## Installation

In your WordPress installation, search for "altcha" in the plugin directory and click Install. Alternatively, install the plugin manually:

1. Download the `.zip` from the [Releases](https://github.com/altcha-org/wordpress-plugin/releases).
2. Upload `altcha` folder to the `/wp-content/plugins/` directory  
3. Activate the plugin through the 'Plugins' menu in WordPress  
4. Review the settings and enable your integrations

### Free Mode

The free self-hosted mode is enabled by default after installation. No additional setup is required, except enabling the integrations you need in the plugin settings.

### REST API

This plugin requires the WordPress REST API. If you are using any "Disable REST API" plugins, ensure that the endpoint `/altcha/v1/challenge` is allowed.

### Hooks

The plugin provides several hooks to customize or extend its functionality.

#### Filters

* `apply_filters('altcha_challenge_url', $challenge_url)`  
  Override the challenge URL.  
  **Returns:** `string`

* `apply_filters('altcha_integrations', $integrations)`  
  Modify the list of available integrations. Supported values: `captcha`, `captcha_spamfilter`, `shortcode`.  
  **Returns:** `array<string>`

* `apply_filters('altcha_plugin_active', false, $name)`  
  Check if an integration by `$name` is active.  
  **Returns:** `bool`

* `apply_filters('altcha_widget_attrs', $attrs, $mode, $language, $name)`  
  Override widget attributes.  
  **Returns:** `array<string, mixed>`

* `apply_filters('altcha_widget_html', $html, $mode, $language, $name)`  
  Override the entire widget HTML.  
  **Returns:** `string`

* `apply_filters('altcha_translations', $translations, $language)`  
  Override translation strings.  
  **Returns:** `array<string, string>`

#### Actions

* `do_action('altcha_verify_result', $result)`  
  Triggered after payload verification.

  * `$result`: `bool` verification result.  
  * Full server verification payload is available via:

    ```php
    AltchaPlugin::$instance->spamfilter_result

## License

GPLv2