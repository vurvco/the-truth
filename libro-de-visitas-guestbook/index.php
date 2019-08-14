<?php
/*
Plugin Name: libro de visitas - guest book
Plugin URI: http://www.jarimos.dk/websjarim/libro-de-visitas/
Description: LIBRO DE VISITAS- GUESTBOOK is the WordPress  guestbook you've just been looking for. Beautiful, responsive,easy and multi-language.
Author: Jarim
Version: 1.4
Author URI: http://www.jarimos.dk
License: GPLv2
*/

//PATHS
//DIR
if ( !defined('MY_PLUGIN_DIR_LDV_JARIM') )
define( 'MY_PLUGIN_DIR_LDV_JARIM',  plugin_dir_path( __FILE__ ) ); 
if ( !defined('MY_PLUGIN_FILE_JARIM_LDV_JARIM') )
define( 'MY_PLUGIN_FILE_JARIM_LDV_JARIM', __FILE__  ); 
//URL
if ( !defined('MY_PLUGIN_URL_LDV_JARIM') )
define( 'MY_PLUGIN_URL_LDV_JARIM',plugin_dir_url(__FILE__) ); 


//LOAD TEMPLATE
if ( !defined('TEMPLATE_NAME_LDV_JARIM') )
define( 'TEMPLATE_NAME_LDV_JARIM', "libro-de-visitas-jarim1.php"  ); 
if ( !defined('TEMPLATE_DIR_LDV_JARIM') )
define( 'TEMPLATE_DIR_LDV_JARIM', get_stylesheet_directory()."/".TEMPLATE_NAME_LDV_JARIM  );

//PAGE(POST TYPE PAGE)
if ( !defined('POST_NAME_LDV_JARIM') )
define( 'POST_NAME_LDV_JARIM', "libro-de-visitas-jarim1"  ); 
if ( !defined('POST_TITLE_LDV_JARIM') )
define( 'POST_TITLE_LDV_JARIM', "LIBRO DE VISITAS"  );




//LOAD SCRIPTS-CSS IF TEMPLATE MATCH
function load_js_css_ldvjarim() { // load external file  
    
    if ( is_page_template( 'libro-de-visitas-jarim1.php' ) ) 
    {
        // Default WordPress jQuery  
        wp_enqueue_script( 'jquery' ); 
        // OUR SCRIPTS
        wp_register_script('Class_Guest_Book_LdvJarim_jq', MY_PLUGIN_URL_LDV_JARIM."js-php-phpguestbook/Class_Guest_Book_LdvJarim.js", array('jquery') );
        wp_enqueue_script('Class_Guest_Book_LdvJarim_jq');
        // AJAX OBJECT  ajax_object.ajax_url AND ajax_object.we_value
	wp_localize_script( 'Class_Guest_Book_LdvJarim_jq', 'ajax_object',array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234 ) );
        // MY CSS
        wp_enqueue_style('style_ldvjarim', MY_PLUGIN_URL_LDV_JARIM."css/style_ldvjarim.css" ); 

    }  
   
}  

//LOAD SCRIPTS-CSS AT HEADER
add_action('get_header', 'load_js_css_ldvjarim');



//CREATE LITTLE MENU INSIDE PLUGINS, UNDER THE PLUGIN NAME, BESIDE ACTIVATE,DEACTIVATE
if (function_exists('add_plugin_settings_link_ldvjarim')) 
{
    add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'add_plugin_settings_link_ldvjarim'); 
} else 
{
    function add_plugin_settings_link_ldvjarim( $links ) 
    {
        $links[] = '<a href="' .
        admin_url( 'options-general.php?page=libro_de_visitas_list_options' ) .
        '">' . __('Settings') . '</a>';
        return $links;
    }
  
    add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'add_plugin_settings_link_ldvjarim'); 
}


//CALL CLASSES
//
//BASE CLASS TO EXTEND
require MY_PLUGIN_DIR_LDV_JARIM . 'Class_Base_Abstract_Guest_Book_LdvJarim.php';
new Class_Base_Abstract_Guest_Book_LdvJarim();

//INSTALL CLASS
require MY_PLUGIN_DIR_LDV_JARIM . 'Class_Install_LdvJarim.php';
new Class_Install_LdvJarim();

//TEMPLATES - ADD ALL PLUGIN TEMPLATES CLASS
require MY_PLUGIN_DIR_LDV_JARIM . 'Class_Page_Add_Templates_LdvJarim.php';
//NOTE - 
//IN THE NEXT LINE, THIS CLASS FUNCTION get_instance INITIALIZE THE CLASS USING new Class_Page_Add_Templates_LdvJarim();
//THEN RETURN THE NEW CLASS INSTANCE TO THE ACTION plugins_loaded.
add_action( 'plugins_loaded', array( 'Class_Page_Add_Templates_LdvJarim', 'get_instance' ) );

//HANDLING CLASSES - GUEST-BOOK INSERT AND SHOW
require MY_PLUGIN_DIR_LDV_JARIM . 'js-php-phpguestbook/Class_Guest_Book_LdvJarim.php';
new Class_Guest_Book_LdvJarim();