<?php

class giaovu_setting
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
            self::$instance = new giaovu_setting();
        }
        return self::$instance;
    }

    public static function run()
    {
        $instance = self::get_instance();
        self::$option = get_option('quickcall_name');
        add_action('admin_menu', function () use ($instance) {
            add_menu_page(
                __('Quick Call Button', 'qcgiaovu'),
                __('Quick Call Seting', 'qcgiaovu'),
                'manage_options',
                'quick-call',
                array($instance, 'createPage'),
                'dashicons-phone'
            );
        });
        add_action('admin_init', array($instance, 'setupSetting'));
        add_action('admin_enqueue_scripts', function () {
            wp_enqueue_style('admin-styles', GIAOVU_URL . 'asset/quickcall-button.css');
        });
        return $instance;
    }


    public static function createPage()
    {
        require(GIAOVU_DIR . 'views/setting_form.php');
    }

    public static function setupSetting()
    {
        add_settings_section(
            'quickcall_section',
            __('Quick Call Button'),
            function () {
                echo __('Config Quick Call Button For Front End', 'qcgiaovu');
            },
            'quickcall_page'
        );
        add_settings_field(
            'phone',
            __('Phone', 'qcgiaovu'),
            function () {
                printf('<input type="number" name="quickcall_name[phone]" class="regular-text" value="' . self::$option['phone'] . '" />');
                printf('<p class="description">%s</p>',__('Enter your phone here','qcgiaovuc'));
            },
            'quickcall_page',
            'quickcall_section'
        );
        add_settings_field(
            'color',
            __('Color','qcgiaovu'),
            function () {
                $color = isset(self::$option["color"]) ? self::$option["color"] : '';
                printf('<input type="color" id="qccolor" name="quickcall_name[color]"
               value="%s" />', $color);
                printf('<p class="description">%s</p>',__('Select color for background button','qcgiaovuc'));
            },
            'quickcall_page',
            'quickcall_section'
        );
        add_settings_field(
            'show_in',
            __('Show in', 'qcgiaovu'),
            function () {
                echo "<select name='quickcall_name[show_in]'>";
                printf("<option value='1' %s>All Device</option>", (self::$option['show_in'] == 1) ? "selected" : "");
                printf("<option value='2' %s> Table And Mobile </option >", (self::$option['show_in'] == 2) ? "selected" : "");
                printf("<option value='3' %s> Mobile</option >", (self::$option['show_in'] == 3) ? "selected" : "");
                echo "</select>";
                printf('<p class="description">%s</p>',__('Show button call for device','qcgiaovuc'));
            },
            'quickcall_page',
            'quickcall_section'
        );
        add_settings_field(
            'position',
            __('Position', 'qcgiaovu'),
            function () {
                echo "<select name='quickcall_name[position]'>";
                printf("<option value='1' %s>".__('Button Left','qcgiaovu')."</option>", (self::$option['position'] == 1) ? "selected" : "");
                printf("<option value='2' %s>".__('Button Right', 'qcgiaovu')."</option >", (self::$option['position'] == 2) ? "selected" : "");
                echo "</select>";
                printf('<p class="description">%s</p>',__('Select Left or Right for call button','qcgiaovuc'));

            },
            'quickcall_page',
            'quickcall_section'
        );
        add_settings_field(
            'custom_css',
            __('Custom CSS', 'qcgiaovu'),
            function () {
                echo "
               <textarea name='quickcall_name[custom_css]' rows='10' cols='50' class='large-text code' placeholder='Code CSS here..'>".self::$option['custom_css']."</textarea>
               ";
                printf('<p class="description">%s</p>',__('Custom CSS for button call if you know code','qcgiaovuc'));
            },
            'quickcall_page',
            'quickcall_section'
        );
        register_setting('quickcall_group', 'quickcall_name', array(self::$instance, 'saveData'));
    }

    public static function saveData($input)
    {
        return $input;
    }
}