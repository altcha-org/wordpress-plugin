<?php

class GFForms_Altcha_Field extends GF_Field
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
				. '<div><span>' . __("ALTCHA placeholder", "altcha") . '</span></div>'
				. '</div>';
		} else {
			altcha_enqueue_scripts();
      altcha_enqueue_styles();
			$widget_html = $plugin->render_widget($mode);
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
		if ($mode === "captcha" || $mode === "captcha_spamfilter") {
			if ($plugin->verify($_POST['altcha']) === false) {
				$this->failed_validation  = true;
				$this->validation_message = __(AltchaPlugin::$message_cannot_submit, "altcha");
			}
		}
	}
}

GF_Fields::register(new GFForms_Altcha_Field());
