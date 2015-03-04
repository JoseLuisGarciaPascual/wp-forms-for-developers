<?php

/**
 * @package BeRepublic
 */
/*
Plugin Name: Forms for developers
Plugin URI: http://www.berepublic.es
Description: Save custom forms to BBDD without an establised frontend
Version: 0.1
Author: Jose Luis
Author URI: http://www.berepublic.es
License: Private
*/
require_once("/lib/bbdd.php");
require_once("ffd-admin.php");
require_once("create_form.php");
require_once("view_submits.php");
require_once("edit_form.php");
/**
 * Install
 */

register_activation_hook( __FILE__, 'ffd_database_install' );

/**
 * Menu Loading
 */

add_action( 'admin_menu', 'ffd_admin_menu' );
add_action( 'admin_init', 'ffd_admin_init' );

function ffd_admin_init() {
        /* Register our script. */
        wp_register_script( 'ffd-init-script', plugins_url( '/js/main.js', __FILE__ ) );
        wp_enqueue_script( 'ffd-init-script' );
    }

function ffd_admin_menu() {

	add_menu_page( 'Forms For Developers', 'Formularios', 'manage_options', 'forms-for-developers', 'ffd_admin', '', 6 );

}

add_action('admin_menu', 'create_form_submenu_page');
add_action('admin_menu', 'view_submits_submenu_page');
add_action('admin_menu', 'edit_form_submenu_page');

function ffd_submit ( $form_id ) {
    return plugins_url( "/submit.php?id=$form_id", __FILE__ );
}