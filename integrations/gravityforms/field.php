<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class ALTCHA_GFForms_Field extends GF_Field
{

	public $type = 'altcha';

	public function get_form_editor_field_title()
	{
		return 'ALTCHA';
	}

	public function get_form_editor_button()
	{
		return array(
			'group' => 'advanced_fields',
			'text'  => $this->get_form_editor_field_title(),
		);
	}

	function get_form_editor_field_settings()
	{
		return array(
			'label_setting',
			'description_setting',
			'label_placement_setting',
			'error_message_setting'
		);
	}

	public function get_form_editor_field_icon()
	{
		return 'dashicons-superhero';
	}

	public function is_conditional_logic_supported()
	{
		return true;
	}

	public function get_field_input($form, $value = '', $entry = null)
	{
		$plugin = AltchaPlugin::$instance;
		$mode = $plugin->get_integration_gravityforms();
		if (empty($mode) || $mode === 'spamfilter') {
			return '';
		}
		if ($this->is_form_editor()) {
			$widget_html = '<div style="display:flex;gap:1rem;border: 1px solid lightgray;max-width:260px;padding: 1em;border-radius:4px;font-size:80%">'
				. '<div><span class="dashicons-before dashicons-superhero"></span></div>'
				. '<div><span>' . __("ALTCHA placeholder", 'altcha-spam-protection') . '</span></div>'
				. '</div>';
		} else {
			$widget_html = wp_kses($plugin->render_widget($mode), AltchaPlugin::$html_espace_allowed_tags);
		}
		return sprintf("<div class='ginput_container ginput_container_%s gfield--type-html'>%s</div>", $this->type, $widget_html);
	}

	private function is_on_last_page($form)
	{
		$pages = GFAPI::get_fields_by_type($form, array('page'));
		return count($pages) + 1 === (int) $this->pageNumber;
	}

	public function validate($value, $form)
	{
		if (GFFormDisplay::is_last_page($form) && !$this->is_on_last_page($form)) {
			return;
		}
		$plugin = AltchaPlugin::$instance;
		$mode = $plugin->get_integration_gravityforms();
    if (!empty($mode)) {
			if ($mode === "captcha" || $mode === "captcha_spamfilter") {
        $altcha = isset($_POST['altcha']) ? trim(sanitize_text_field($_POST['altcha'])) : '';
				if ($plugin->verify($altcha) === false) {
					$this->failed_validation  = true;
					$this->validation_message = __('Could not verify you are not a robot.', 'altcha-spam-protection');
				}
			}
		}
	}
}

GF_Fields::register(new ALTCHA_GFForms_Field());
