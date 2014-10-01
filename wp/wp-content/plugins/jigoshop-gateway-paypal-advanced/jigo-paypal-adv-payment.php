<?php
/*
Plugin Name: Jigoshop PayPal Payments Advanced Gateway
Plugin URI: http://jigoshop.com/
Description: A payment gateway for PayPal Payments Advanced (https://www.paypal.com/webapps/mpp/paypal-payments-advanced). A PayPal Advanced account is required for this gateway to function. Paypal Adavnced currently only supports USD.
Version: 1.2
Author: Kiran Polapragada
Author URI: http://www.limecuda.com
Text Domain: jigo_paypaladv

Paypal Payments Advanced Docs: https://cms.paypal.com
*/

add_action( 'init', 'jigo_paypaladv_init', 0 ) ;


/**
 * Add the gateway to Jigoshop
 **/
function add_paypal_adv_gateway( $methods ) {
	$methods[] = 'jigoshop_paypal_advanced'; return $methods;
}

add_filter('jigoshop_payment_gateways', 'add_paypal_adv_gateway' );

function jigo_paypaladv_init() {

	if ( ! class_exists( 'jigoshop_payment_gateway' ) ) return;

	 //Localisation
	load_plugin_textdomain( 'jigo_paypaladv', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	
	// include required files based on admin or site
	require_once( plugin_dir_path( __FILE__ ) . "class-jigo-paypal-advanced.php" ); //core class

}