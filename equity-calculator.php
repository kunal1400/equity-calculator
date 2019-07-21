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
    // wp_localize_script( 'simple_jobs_js', 'simple_jobs_js_var', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234 ) );
    wp_enqueue_style( 'equity_calculator_front_css', plugin_dir_url( __FILE__ ) . 'css/front.css');
}
add_action('wp_enqueue_scripts', 'equity_calculator_enqueue_script');
// add_action('admin_enqueue_scripts', 'equity_calculator_enqueue_script');


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
