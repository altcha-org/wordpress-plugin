<?php

if (!defined('ABSPATH')) exit;

if (!class_exists('\ElementorPro\Modules\Forms\Fields\Field_Base')) {
  die();
}

class Elementor_Form_Altcha_Field extends \ElementorPro\Modules\Forms\Fields\Field_Base
{
  public function get_type()
  {
    return 'altcha';
  }

  public function get_name()
  {
    return esc_html__('ALTCHA', 'altcha-spam-protection');
  }

  public function render($item, $item_index, $form)
  {
    $plugin = AltchaPlugin::$instance;
    $mode = $plugin->get_integration_elementor();
    if (empty($mode) || $mode === 'spamfilter') {
      return '';
    }
    echo wp_kses(wp_nonce_field('altcha_verification', '_altchanonce', true, false), AltchaPlugin::$html_espace_allowed_tags);
    echo wp_kses("<div style=\"flex-basis:100%\">" . $plugin->render_widget($mode, false) . "</div>", AltchaPlugin::$html_espace_allowed_tags);
    // shadow element for error reporting
		echo wp_kses('<input type="hidden" ' . $form->get_render_attribute_string('input' . $item_index) . '>', AltchaPlugin::$html_espace_allowed_tags);
  }

  public function validation($field, $record, $ajax_handler)
  {
    $plugin = AltchaPlugin::$instance;
    $mode = $plugin->get_integration_elementor();
    if (!empty($mode)) {
      if ($mode === "captcha" || $mode === "captcha_spamfilter") {
        if (wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_altchanonce'])), 'altcha_verification') === false) {
          $ajax_handler->add_error(
            $field['id'],
            esc_html__('Nonce verification failed.', 'altcha-spam-protection')
          );
        } else {
          $altcha = isset($_POST['altcha']) ? trim(sanitize_text_field($_POST['altcha'])) : '';
          if ($plugin->verify($altcha) === false) {
            $ajax_handler->add_error(
              $field['id'],
              esc_html__('Verification failed.', 'altcha-spam-protection')
            );
          }
        }
      }
    }
  }
}
