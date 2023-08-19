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

//post types
function uthenge_setup_post_type(){
  register_post_type( "delivery", array(
    "labels" => array(
      "name" => __("Deliveries","uthenge"),
      "singular_name" => __("Delivery","uthenge")
    ),
    "public" => true,
    "has_archive" => true,
    "rewrite" => array("slug"=>"Deliveries")
  ) );
}
add_action( "init", "uthenge_setup_post_type" );

//short codes
function uthenge_setup_short_codes(){
  add_shortcode( "uthenge_deliveries", function($att=[],$content=null){
    $deliveries = get_posts( array("post_type"=>"delivery") );
    $content ="<div class='row row-cols-1 row-cols-md-2 g-4'>";
    foreach($deliveries as $delivery){
      $content .= "<div class='col'>";
      $content .= "<div class='card'>";
      $content .= "<div class='card-body'>";
      $content .= "<h5 class=''>".$delivery->post_title."</h5>";
      $content .= "</div>";
      $content .= "<div class='card-footer'>";
      $content .= "<a class='btn btn-primary' href='".get_post_permalink( $delivery )."'>Open</a>";
      $content .= "</div>";
      $content .= "</div>";
      $content .= "</div>";
    }
    $content .="</div>";
    return $content;
  } );
}
add_action( "init", "uthenge_setup_short_codes" );

function uthenge_remove_short_codes(){
  remove_shortcode( "uthenge_deliveries" );
}

//styles and scripts
function uthenge_styles_and_scripts(){
  wp_register_style( "bootstrap", plugins_url("public/css/bootstrap.min.css",__FILE__ ));
}
add_action( "init", function(){
  uthenge_styles_and_scripts();
  wp_enqueue_style( "bootstrap");
});

function uthenge_remove_styles_and_scripts(){
  wp_deregister_style( "bootstrap" );
}

//activation
function uthenge_activate(){
  uthenge_setup_post_type();
  uthenge_setup_short_codes();
  flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'uthenge_activate' );

//deactivation
function uthenge_deactivate(){
  unregister_post_type( "delivery" );
  uthenge_remove_short_codes();
  uthenge_remove_styles_and_scripts();
  flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'uthenge_deactivate' );