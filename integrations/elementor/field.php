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
    echo wp_kses("<div style=\"flex-basis:100%\">" . $plugin->render_widget($mode, false) . "</div>", AltchaPlugin::$html_espace_allowed_tags);
    // shadow element for error reporting
		echo wp_kses('<input type="hidden" ' . $form->get_render_attribute_string('input' . $item_index) . '>', AltchaPlugin::$html_espace_allowed_tags);
  }

  public function update_controls($widget)
	{
		$elementor = \ElementorPro\Plugin::elementor();
		$control_data = $elementor->controls_manager->get_control_from_stack($widget->get_unique_name(), 'form_fields');
		if (is_wp_error($control_data)) {
			return;
		}
		$control_data = $this->remove_control_form_field_type('required', $control_data);
		$widget->update_control('form_fields', $control_data);
	}

  private function remove_control_form_field_type($control_name, $control_data)
	{
		foreach ($control_data['fields'] as $index => $field) {
			if ($control_name !== $field['name']) {
				continue;
			}
			foreach ($field['conditions']['terms'] as $condition_index => $terms) {
				if (!isset($terms['name']) || 'field_type' !== $terms['name'] || !isset($terms['operator']) || '!in' !== $terms['operator']) {
					continue;
				}
				$control_data['fields'][$index]['conditions']['terms'][$condition_index]['value'][] = $this->get_type();
				break;
			}
			break;
		}
		return $control_data;
	}

  public function validation($field, $record, $ajax_handler)
  {
    $plugin = AltchaPlugin::$instance;
    $mode = $plugin->get_integration_elementor();
    if (!empty($mode)) {
      if ($mode === "captcha" || $mode === "captcha_spamfilter") {
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

if (AltchaPlugin::$instance->get_integration_elementor()) {
  // Since Elementor Pro 3.31.2, script enqueuing does not seem to work properly when the widget is rendered.
  // Always enqueue scripts when the integration is active.
  altcha_enqueue_scripts();
  altcha_enqueue_styles();
}
