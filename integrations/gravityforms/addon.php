<?php

if ( ! defined( 'ABSPATH' ) ) exit;

GFForms::include_addon_framework();

class ALTCHA_GFFormsAddOn extends GFAddOn
{

    protected $_version = ALTCHA_VERSION;
    protected $_min_gravityforms_version = '2.5';
    protected $_slug = 'altcha';
    protected $_full_path = __FILE__;
    protected $_short_title = 'ALTCHA';

    private static $_instance = null;

    public static function get_instance()
    {
        if (self::$_instance == null) {
            self::$_instance = new ALTCHA_GFFormsAddOn();
        }

        return self::$_instance;
    }

    public function get_menu_icon()
    {
        return 'dashicons-superhero';
    }

    public function pre_init()
    {
        parent::pre_init();

        if ($this->is_gravityforms_supported() && class_exists('GF_Field')) {
            require_once('field.php');
        }
    }

    public function init_admin()
    {
        parent::init_admin();
    }
}
