<?php

class giaovu_quickcall
{
    protected static $instance;
    protected static $option;

    public function __construct()
    {
    }

    public function __clone()
    {
    }

    public static function get_instance()
    {
        if (self::$instance === null) {
            self::$instance = new giaovu_quickcall();
        }
        return self::$instance;
    }

    public static function run()
    {
        $instance = self::get_instance();
        self::quickcall_frontend();
        giaovu_setting::run();
        return $instance;
    }
    public static function quickcall_frontend()
    {
        add_action('wp_footer', function () {
            self::$option = get_option('quickcall_name');
            $phone = self::$option['phone'];
            $color = self::$option['color'];
            $show_in = self::$option['show_in'];
            $position = self::$option['position'];
            $custom_css = self::$option['custom_css'];
            require(GIAOVU_DIR . "views/quickcall_frontend.php");
        });
    }

    public static function plugin_activation()
    {
        if (version_compare($GLOBALS['wp_version'], WP_MIN_VERSION, '<')) {
            die('Error version WP !!');
        }
        $version = get_option('quickcall_version');
        if (!$version) {
            add_option('quickcall_version', GIAOVU_CALLBUTTON);
        } else {
            update_option('quickcall_version', GIAOVU_CALLBUTTON);
        }
    }

    public static function plugin_deactivation()
    {
        delete_option('quickcall_version');
    }
}