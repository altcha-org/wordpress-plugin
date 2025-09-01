<?php

function altcha_load_formidable_field() {
	spl_autoload_register( 'altcha_forms_autoloader' );
}
add_action( 'plugins_loaded', 'altcha_load_formidable_field' );

function altcha_forms_autoloader( $class_name ) {
	if ( ! preg_match( '/^Altcha.+$/', $class_name ) ) {
		return;
	}

	$filepath = dirname( __FILE__ );
	$filepath .= '/formidable/' . $class_name . '.php';

	if ( file_exists( $filepath ) ) {
		require( $filepath );
	}
}

function altcha_get_field_type_class( $class, $field_type ) {
	if ( $field_type === 'altcha' ) {
		$class = 'AltchaFieldType';
	}
	return $class;
}
add_filter( 'frm_get_field_type_class', 'altcha_get_field_type_class', 10, 2 );

function altcha_add_new_field( $fields ) {
	$fields['altcha'] = array(
		'name' => 'ALTCHA',
		'icon' => 'frm_icon_font frm_shield_check_icon',
	);
	return $fields;
}
add_filter( 'frm_available_fields', 'altcha_add_new_field' );