<?php

if (!defined('ABSPATH')) exit;

class AltchaFieldType extends FrmFieldType
{
	protected $type = 'altcha';

	protected $has_input = true;

	protected function field_settings_for_type()
	{
		$settings            = parent::field_settings_for_type();
		$settings['default'] = true;

		return $settings;
	}

	protected function extra_field_opts()
	{
		return array();
	}

	protected function include_form_builder_file()
	{
		return dirname(__FILE__) . '/builder-field.php';
	}

	public function displayed_field_type($field)
	{
		return array(
			$this->type => true,
		);
	}

	public function show_extra_field_choices($args)
	{
		include(dirname(__FILE__) . '/builder-settings.php');
	}

	protected function html5_input_type()
	{
		return 'text';
	}

	public function validate($args)
	{
    $plugin = AltchaPlugin::$instance;
    $mode = $plugin->get_integration_formidable();
		$errors = array();
    if (!empty($mode)) {
      if ($mode === 'captcha' || $mode === 'captcha_spamfilter') {
        $altcha = isset($_POST['altcha']) ? trim(sanitize_text_field($_POST['altcha'])) : '';
        if ($plugin->verify($altcha) === false) {
					$errors['field' . $args['id']] = esc_html__('Verification failed.', 'altcha-spam-protection');
        }
      }
    }

		return $errors;
	}

	public function front_field_input($args, $shortcode_atts)
	{
		$plugin = AltchaPlugin::$instance;
		$mode = $plugin->get_integration_formidable();
		if (!empty($mode) && $mode === 'captcha') {
			return wp_kses("<div style=\"flex-basis:100%\">" . $plugin->render_widget($mode, false) . "</div>", AltchaPlugin::$html_espace_allowed_tags);
		}
		return '';
	}
}