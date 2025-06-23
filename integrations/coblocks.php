<?php

if (! defined('ABSPATH')) exit;

// https://github.com/hCaptcha/hcaptcha-wordpress-plugin/blob/master/src/php/CoBlocks/Form.php

if (altcha_plugin_active('coblocks')) {
  add_filter('render_block', array('AltchaPlugin_Coblocks', 'render_block'), 10, 3);
  add_filter('render_block_data', array('AltchaPlugin_Coblocks', 'render_block_data'), 10, 3);

  class AltchaPlugin_Coblocks
  {
    private const RECAPTCHA_DUMMY_TOKEN = 'altcha_dummy_token';

    public static function render_block($block_content, array $block, WP_Block $instance): string
    {
      $block_content = (string) $block_content;
      if ('coblocks/form' !== $block['blockName']) {
        return $block_content;
      }

      $plugin = AltchaPlugin::$instance;
      $mode = $plugin->get_integration_coblocks();
      if ($mode === "captcha") {
        return str_replace('<button type="submit"', wp_kses($plugin->render_widget($mode, true), AltchaPlugin::$html_espace_allowed_tags) . '<button type="submit"', $block_content);
      }

      return $block_content;
    }

    public static function render_block_data($parsed_block, array $source_block): array
    {
      static $filters_added;

      if ($filters_added) {
        return $parsed_block;
      }

      $parsed_block = (array) $parsed_block;
      $block_name   = $parsed_block['blockName'] ?? '';

      if ('coblocks/form' !== $block_name) {
        return $parsed_block;
      }

      // Nonce is checked by CoBlocks.
      // phpcs:ignore WordPress.Security.NonceVerification.Missing
      $form_submission = isset($_POST['action']) ? sanitize_text_field(wp_unslash($_POST['action'])) : '';

      if ('coblocks-form-submit' !== $form_submission) {
        return $parsed_block;
      }

      // We cannot add filters right here.
      // In this case, the calculation of form hash in the coblocks_render_coblocks_form_block() will fail.
      add_action('coblocks_before_form_submit', ['AltchaPlugin_Coblocks', 'before_form_submit'], 10, 2);

      $filters_added = true;

      return $parsed_block;
    }

    public static function before_form_submit(array $post, array $atts): void
    {
      add_filter('pre_option_coblocks_google_recaptcha_site_key', '__return_true');
      add_filter('pre_option_coblocks_google_recaptcha_secret_key', '__return_true');

      $_POST['g-recaptcha-token'] = self::RECAPTCHA_DUMMY_TOKEN;

      add_filter('pre_http_request', ['AltchaPlugin_Coblocks', 'verify'], 10, 3);
    }

    public static function verify($response, array $parsed_args, string $url)
    {
      if (
        CoBlocks_Form::GCAPTCHA_VERIFY_URL !== $url ||
        self::RECAPTCHA_DUMMY_TOKEN !== $parsed_args['body']['response']
      ) {
        return $response;
      }

      remove_filter('pre_http_request', ['AltchaPlugin_Coblocks', 'verify']);

      $plugin = AltchaPlugin::$instance;
      $mode = $plugin->get_integration_coblocks();
      if (!empty($mode)) {
        if ($mode === "captcha" || $mode === "captcha_spamfilter") {
          $altcha = isset($_POST['altcha']) ? trim(sanitize_text_field($_POST['altcha'])) : '';
          if ($plugin->verify($altcha) === false) {
            return [
              'body'     => '{"success":false}',
              'response' =>
              [
                'code'    => 200,
                'message' => 'OK',
              ],
            ];
          }
        }
      }
      return [
        'body'     => '{"success":true}',
        'response' =>
        [
          'code'    => 200,
          'message' => 'OK',
        ],
      ];
    }
  }
}
