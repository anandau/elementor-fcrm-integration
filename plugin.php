<?php


/*
Plugin Name: Elementor Fluent CRM Integration
Plugin URI: https://wpvibes.com
Description: Send Elementor Pro form data to Fluent CRM Webhook
Author: WPVibes
Version: 0.0.1
Author URI: https://wpvibes.com/
Text Domain: wpv-efi
License: GPLv2
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class WPV_Fluent_Integration {

	function __construct() {
		// Do nothing.

	}

	function initialize() {
		define( 'WPV_EFI_VERSION', '0.0.1' );
		define( 'WPV_EFI_PATH', plugin_dir_path( __FILE__ ) );
	}
}


function wpv_efi() {

	// Instantiate only once.
	if( !isset($fv) ) {
		$wpv_efi = new WPV_Fluent_Integration();
		$wpv_efi->initialize();
	}
	return $wpv_efi;
}

// Instantiate.
wpv_efi();
require_once WPV_EFI_PATH.'/inc/bootstrap.php';