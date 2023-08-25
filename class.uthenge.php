<?php

class UthengePluginShortcodes {

  public static function uthenge_deliveries($att=[],$content=null) {
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
  }

  public static function delivery_request($att=[],$content=null) {
    $delivery = get_post();
    $content .= "<div class='card'>";
    $content .= "<div class='card-body'>";
    $content .= "<h5 class='card-title'>".$delivery->post_title." | Request quotation.</h5>";
    $content .= "<form id='quotation-form' method='post'>";
    $content .= "<div class='input-group mb-3'>";
    $content .= "<input type='tel' name='phone' class='form-control' placeholder='(+260)' aria-label='Phone'>";
    $content .= "</div>";
    $content .= "<div class='input-group mb-3'>";
    $content .= "<input type='text' name='name' class='form-control' placeholder='John Smith' aria-label='Name'>";
    $content .= "</div>";
    $content .= "</form>";
    $content .= "</div>";
    $content .= "<ul id='quotation-items' class='list-group list-group-flush'>";
    $content .= "</ul>";
    $content .= "<div class='card-footer'>";
    $content .= "<div class='input-group mb-3'>";
    $content .= "<input type='text' id='item' class='form-control' placeholder='Item' aria-label='Item' aria-describedby='add-item-btn'>";
    $content .= "<button onclick=\"uthengeQuotation.add(document.querySelector('#item').value);\" class='btn btn-outline-primary' type='button' id='add-item-btn'>Add</button>";
    $content .= "</div>";
    $content .= "<button onclick='uthengeQuotation.submit();' class='form-control btn btn-outline-primary' >Submit</button>";
    $content .= "</div>";
    $content .= "</div>";
    
    return $content;
  }
}

class UthengePlugin {

  public static function initialize() {
    self::styles_and_scripts();
    self::register_post_types();
    self::add_shortcodes();
  }

  public static function activate() {
    self::initialize();
    flush_rewrite_rules();
  }

  public static function deactivate() {
    self::styles_and_scripts(false);
    self::register_post_types(false);
    self::add_shortcodes(false);
    flush_rewrite_rules();
  }

  private static function register_post_types($do=true) {
    if ($do) {
      register_post_type( "delivery", array(
        "labels" => array(
          "name" => __("Deliveries","uthenge"),
          "singular_name" => __("Delivery","uthenge")
        ),
        "public" => true,
        "has_archive" => true,
        "rewrite" => array("slug"=>"Deliveries")
      ));
    } else {
      unregister_post_type( "delivery" );
    }
  }

  private static function add_shortcodes($do=true) {
    if($do){
      add_shortcode("uthenge_deliveries", function($att=[],$content=null){
        return UthengePluginShortcodes::uthenge_deliveries($att,$content);
      });
      add_shortcode("delivery_request", function($att=[],$content=null){
        return UthengePluginShortcodes::delivery_request($att,$content);
      });
    } else {
      remove_shortcode( "uthenge_deliveries" );
      remove_shortcode( "delivery_request" );
    }
  }

  private static function styles_and_scripts($do=TRUE) {
    if($do){
      wp_register_style( "bootstrap", plugins_url("public/css/bootstrap.min.css",UTHENGE_ROOT_DIR."/uthenge-delivery.php" ));
      wp_register_script( "uthengejs", plugins_url("public/uthenge.js",UTHENGE_ROOT_DIR."/uthenge-delivery.php" ));
      wp_enqueue_style( "bootstrap");
      wp_enqueue_script("uthengejs");
    } else {
      wp_deregister_style( "bootstrap" );
      wp_deregister_script( "uthengejs" );
    }
  }
}