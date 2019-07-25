<?php 
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Master Node
 *
 * @wordpress-plugin
 * Plugin Name:       Equity Calculator
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Kunal malviya
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       equity-calculator
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Enqueuing the js and css files on frontend
 */
function equity_calculator_enqueue_script() {
    wp_enqueue_script( 'equity_calculator_modal', plugin_dir_url( __FILE__ ) . 'js/model.js', array('jquery'), '1.0' );
    wp_enqueue_script( 'jspdf', plugin_dir_url( __FILE__ ) . 'js/jspdf.min.js', array('jquery'), '1.0' );
    wp_enqueue_script( 'jspdf_autotable', plugin_dir_url( __FILE__ ) . 'js/jspdf.plugin.autotable.min.js', array('jquery'), '1.0' );
    wp_enqueue_style( 'equity_calculator_front_css', plugin_dir_url( __FILE__ ) . 'css/front.css');
    wp_localize_script( 'jspdf_autotable', 'equity_calculator_js_var', array( 'ajax_url' => admin_url('admin-ajax.php') ) );
}
add_action('wp_enqueue_scripts', 'equity_calculator_enqueue_script');

/**
 * Enqueuing the js and css files on frontend
 */
function admin_equity_calculator_enqueue_script() {
    wp_enqueue_script( 'equity_calculator_modal', plugin_dir_url( __FILE__ ) . 'js/model.js', array('jquery'), '1.0' );
    wp_enqueue_script( 'jspdf', plugin_dir_url( __FILE__ ) . 'js/jspdf.min.js', array('jquery'), '1.0' );
    wp_enqueue_script( 'jspdf_autotable', plugin_dir_url( __FILE__ ) . 'js/jspdf.plugin.autotable.min.js', array('jquery'), '1.0' );
    wp_localize_script( 'jspdf_autotable', 'equity_calculator_js_var', array( 'ajax_url' => admin_url('admin-ajax.php') ) );
}
add_action('admin_enqueue_scripts', 'admin_equity_calculator_enqueue_script');


/**
* Adding shortcode for this plugin
**/
add_shortcode( 'equity_calculator', 'equity_calculator_shortcode_callback' );
function equity_calculator_shortcode_callback( $atts ) {
	// Get shortcodes attributes
	$a = shortcode_atts( array(
		"id" => "",
	), $atts );	

	ob_start();
    include __DIR__ . '/templates/frontend.php';
    return ob_get_clean();	
}

/**
* Adding Saving the user data in db
**/
add_action( 'wp_ajax_save_equity_result', 'save_equity_result_callback' );
add_action( 'wp_ajax_nopriv_save_equity_result', 'save_equity_result_callback' );
function save_equity_result_callback() {
    if( !empty($_POST['dataToSend']) ) {        
        if( $_POST['userEmail'] ) {
            $optionKey = "!@!".$_POST['userEmail'];
            // $oldOption = get_option($optionKey, null);
            // if( $oldOption ) {
            //     $array   = json_decode($oldOption, ARRAY_A);
            //     $array[] = $_POST;
            // }
            // else {
            //     $array = $_POST;
            // }
            update_option($optionKey, json_encode($_POST));
        }
        // $data = json_encode($_POST['dataToSend']);
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        // get_option()
        // $currentUserId = get_current_user_id();
        // echo $currentUserId;
        // update_user_meta($currentUserId, '_equity_result' ,$data);
    }
    // exit;
}


add_action( 'admin_menu', 'my_plugin_users_data_menu' );
function my_plugin_users_data_menu() {
    add_options_page( 
        'Users of Equity result',
        'Users of Equity result',
        'manage_options',
        'my-plugin.php',
        'my_plugin_users_data_page'
    );
}

function my_plugin_users_data_page() {
    global $wpdb;
    $table  = $wpdb->prefix."options";
    $sql    = "SELECT * FROM $table WHERE option_name LIKE '!@!%'";
    $results = $wpdb->get_results($sql, ARRAY_A);
    include __DIR__ . '/templates/userslist.php';   
}