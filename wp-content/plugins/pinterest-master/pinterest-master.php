<?php
/**
Plugin Name: Pinterest Master
Plugin URI: http://wordpress.techgasp.com/pinterest-master/
Version: 4.3.6
Author: TechGasp
Author URI: http://wordpress.techgasp.com
Text Domain: pinterest-master
Description: Pinterest Master adds the follow me on pinterest, pin it button, show pinterest profile and show pinterest board to your wordpress website.
License: GPL2 or later
*/
/*
Copyright 2013 TechGasp  (email : info@techgasp.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
if(!class_exists('pinterest_master')) :
///////DEFINE ID//////
define('PINTEREST_MASTER_ID', 'pinterest-master');
///////DEFINE VERSION///////
define( 'pinterest_master_VERSION', '4.3.6' );
global $pinterest_master_version, $pinterest_master_name;
$pinterest_master_version = "4.3.6"; //for other pages
$pinterest_master_name = "Pinterest Master"; //pretty name
if( is_multisite() ) {
update_site_option( 'pinterest_master_installed_version', $pinterest_master_version );
update_site_option( 'pinterest_master_name', $pinterest_master_name );
}
else{
update_option( 'pinterest_master_installed_version', $pinterest_master_version );
update_option( 'pinterest_master_name', $pinterest_master_name );
}
// HOOK ADMIN
require_once( dirname( __FILE__ ) . '/includes/pinterest-master-admin.php');
// HOOK ADMIN SETTINGS PAGE
require_once( dirname( __FILE__ ) . '/includes/pinterest-master-admin-settings-wide.php');
// HOOK FRONT SETTINGS WIDE
require_once( dirname( __FILE__ ) . '/includes/pinterest-master-settings-wide.php');
// HOOK ADMIN IN & UN SHORTCODE
require_once( dirname( __FILE__ ) . '/includes/pinterest-master-admin-shortcodes.php');
// HOOK ADMIN WIDGETS
require_once( dirname( __FILE__ ) . '/includes/pinterest-master-admin-widgets.php');
// HOOK ADMIN ADDONS
require_once( dirname( __FILE__ ) . '/includes/pinterest-master-admin-addons.php');
// HOOK ADMIN UPDATER
require_once( dirname( __FILE__ ) . '/includes/pinterest-master-admin-updater.php');
// HOOK WIDGET PINTEREST BUTTONS
require_once( dirname( __FILE__ ) . '/includes/pinterest-master-widget-buttons.php');


class pinterest_master{
//REGISTER PLUGIN
public static function pinterest_master_register(){
register_setting(PINTEREST_MASTER_ID, 'tsm_quote');
}
public static function content_with_quote($content){
$quote = '<p>' . get_option('tsm_quote') . '</p>';
	return $content . $quote;
}
//SETTINGS LINK IN PLUGIN MANAGER
public static function pinterest_master_links( $links, $file ) {
	if ( $file == plugin_basename( dirname(__FILE__).'/pinterest-master.php' ) ) {
		$links[] = '<a href="' . admin_url( 'admin.php?page=pinterest-master' ) . '">'.__( 'Settings' ).'</a>';
	}

	return $links;
}

public static function pinterest_master_updater_version_check(){
global $pinterest_master_version;
//CHECK NEW VERSION
$pinterest_master_slug = basename(dirname(__FILE__));
$current = get_site_transient( 'update_plugins' );
$pinterest_plugin_slug = $pinterest_master_slug.'/'.$pinterest_master_slug.'.php';
@$r = $current->response[ $pinterest_plugin_slug ];
if (empty($r)){
$r = false;
$pinterest_plugin_slug = false;
if( is_multisite() ) {
update_site_option( 'pinterest_master_newest_version', $pinterest_master_version );
}
else{
update_option( 'pinterest_master_newest_version', $pinterest_master_version );
}
}
if (!empty($r)){
$pinterest_plugin_slug = $pinterest_master_slug.'/'.$pinterest_master_slug.'.php';
@$r = $current->response[ $pinterest_plugin_slug ];
if( is_multisite() ) {
update_site_option( 'pinterest_master_newest_version', $r->new_version );
}
else{
update_option( 'pinterest_master_newest_version', $r->new_version );
}
}
}
		// Advanced Updater

//END CLASS
}
if ( is_admin() ){
	add_action('admin_init', array('pinterest_master', 'pinterest_master_register'));
	add_action('init', array('pinterest_master', 'pinterest_master_updater_version_check'));
}
add_filter('the_content', array('pinterest_master', 'content_with_quote'));
add_filter( 'plugin_action_links', array('pinterest_master', 'pinterest_master_links'), 10, 2 );
endif;