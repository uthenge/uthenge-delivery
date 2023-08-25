<?php
/**
 * @package Uthenge
 */
/*
Plugin Name: Uthenge Delivery
Plugin URI: https://github.com/fshangala
Description: Uthenge plugin for product deliveries
Version: 1.0
Requires at least: 5.0
Requires PHP: 8.1
Author: Funduluka Shangala
Author URI: https://linkedin.com/in/fshangala
License: GPLv2 or later
Text Domain: uthenge
*/

//constants
define("UTHENGE_ROOT_DIR",dirname(__FILE__));

require_once 'class.uthenge.php';

//post types
function uthenge_init(){
  UthengePlugin::initialize();
}
add_action( "init", "uthenge_init" );

//activation
function uthenge_activate(){
  UthengePlugin::activate();
}
register_activation_hook( __FILE__, 'uthenge_activate' );

//deactivation
function uthenge_deactivate(){
  UthengePlugin::deactivate();
}
register_activation_hook( __FILE__, 'uthenge_deactivate' );