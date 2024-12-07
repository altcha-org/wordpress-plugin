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

* Contact Form 7
* Elementor Pro Forms
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

The plugin supports the [Floating UI](https://altcha.org/docs/floating-ui/) but with known limitations:

Currently the Floating UI does not work with:

- Forminator with multi-step forms

## Installation

In your WordPress installation, search for "altcha" in the plugin directory and click Install. Alternatively, install the plugin manually:

1. Download the `.zip` from the [Releases](https://github.com/altcha-org/wordpress-plugin/releases).
2. Upload `altcha` folder to the `/wp-content/plugins/` directory  
3. Activate the plugin through the 'Plugins' menu in WordPress  
4. Review the settings and enable the your integrations

### REST API

This plugin requires the WordPress REST API. If you are using any "Disable REST API" plugins, ensure that the endpoint `/altcha/v1/challenge` is allowed.

## License

GPLv2