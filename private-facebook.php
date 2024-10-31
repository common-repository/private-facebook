<?php
/*
Plugin Name: Private Facebook
Plugin URI: http://www.lifesgreat.fr/
Description: Protect your blog via Facebook Connect. Select who can access your blog, using an access list.
Version: 1.0.6
Author: Benjamin Netter
Author URI: http://www.twitter.com/benjaminnetter
*/

$plugin_directory = 'private-facebook';
$facebook_app = false;
$facebook = null;
register_activation_hook(__FILE__, 'pf_install');
add_action('admin_menu', 'load_pf');
add_action('init', 'load_pf_libraries');
add_action('wp_head', 'pf_check_session');
add_action('wp_ajax_change_status', 'pf_change_status');

function pf_install() {
	global $wpdb;

	$first_install = get_option("pf_db_version", false);
	if ($first_istall == false) {
		$table_name = $wpdb->prefix . "pf";

		$sql = "CREATE TABLE $table_name (
	  			`id` BIGINT NOT NULL AUTO_INCREMENT,
	  			`facebook_id` VARCHAR( 100 ) NOT NULL,
	  			`mail` VARCHAR( 255 ) NOT NULL ,
	  			`name` VARCHAR( 255 ) NOT NULL ,
	  			`status` ENUM(  'allow',  'deny' ) NOT NULL DEFAULT 'deny',
	  			PRIMARY KEY (  `id` ) ,
	  			UNIQUE (`facebook_id`)
		);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		add_option("pf_db_table", $table_name);
		add_option("pf_db_version", '1.0');
		add_option("pf_facebook_app_id", null);
		add_option("pf_facebook_secret_id", null);
	}
}

function load_pf() {
	global $plugin_directory;

	$icon_path = plugins_url("$plugin_directory/images/icon.png");
	add_menu_page('Facebook access', 'Facebook access', 'add_users', 'private-facebook-settings', 'pf_settings', $icon_path);
}

function pf_check_session() {
	global $facebook, $wpdb;

	$user = $facebook->getUser();
	$theme_path = get_theme_root() . '/' . get_template() . '/';
	$table_name = get_option('pf_db_table', null);

	if (!$user) {
		if (file_exists($theme_path . 'pf-not-authorized.php'))
			include($theme_path . 'pf-not-authorized.php');
		else
			include('html/not-authorized.php');
	} else {
		$access = $wpdb->get_row("SELECT * FROM $table_name WHERE facebook_id = $user");
		if (!$access) {
			$me = $facebook->api('/me');
			$wpdb->insert($table_name, 
				array('facebook_id' => $user, 'mail' => $me["email"], 'name' => $me["name"]), 
				array('%s', '%s', '%s')
			);
		}
		if (!$access || $access->status == 'deny') {
			if (file_exists($theme_path . 'pf-waiting-approval.php'))
				include($theme_path . 'pf-waiting-approval.php');
			else
				include('html/waiting-approval.php');
		}
	}
}

function pf_settings() {
	global $facebook, $wpdb;

	if (isset($_POST['facebook_app_id']) || isset($_POST['facebook_secret_id'])) {
		update_option("pf_facebook_app_id", $_POST['facebook_app_id']);
		update_option("pf_facebook_secret_id", $_POST['facebook_secret_id']);
	}
	load_pf_header();
	$table_name = get_option('pf_db_table', null);
	$users = array();
	if ($table_name) {
		$users = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC");
	}
	include("html/listing.php");
}

function pf_change_status() {
	global $wpdb;

	if (!current_user_can('add_users'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	} else {
		if (isset($_POST['facebook_id']) && isset($_POST['status'])) {
			$table_name = get_option('pf_db_table', null);

			if ($table_name) {
				$wpdb->update($table_name, array('status' => $_POST['status']), array('facebook_id' => $_POST['facebook_id']), array('%s'), array('%s'));
				echo "ok";
			}
		}
	}
}

function load_pf_header() {
	global $facebook;

	include('html/header.php');
}

function load_pf_libraries() {
	global $plugin_directory, $facebook;

	require_once("library/facebook.php");

	if (get_option("pf_facebook_app_id", null) != null && get_option("pf_facebook_secret_id", null) != null)
		$facebook = new Facebook(array('appId'  => get_option("pf_facebook_app_id", null),'secret' => get_option("pf_facebook_secret_id", null)));
	// Path
	$style_path = plugins_url("$plugin_directory/style.css");

	// Loading the CSS stylesheet
	wp_register_style('css-stylesheet', $style_path);
    wp_enqueue_style('css-stylesheet');
}