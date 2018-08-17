<?php
/*
Plugin Name: GV Quick Call Button
Plugin URI:
Description: Quick Call Button For Wordpress
Version: 0.1.0
Author: Giao Vu
Author URI: https://www.facebook.com/giao1510
Text Domain: qcgiaovu
Domain Path: /languages
*/
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}
define('GIAOVU_URL', plugin_dir_url(__FILE__));
define('GIAOVU_DIR', plugin_dir_path(__FILE__));
define('WP_MIN_VERSION', '4.0.0');
define('GIAOVU_CALLBUTTON' , '0.1.0');
define('GIAOVU_LANGUAGES',dirname(plugin_basename(__FILE__).'/languages'));
add_action('plugins_loaded', function (){
    load_plugin_textdomain('qcgiaovu', false, GIAOVU_LANGUAGES);
});
require_once(GIAOVU_DIR . 'includes/class.quickcall-setting.php');
require_once(GIAOVU_DIR . 'includes/class.quickcall.php');
giaovu_quickcall::run();
register_activation_hook(__FILE__,array('giaovu_quickcall', 'plugin_activation'));
register_deactivation_hook( __FILE__,array('giaovu_quickcall','plugin_deactivation'));