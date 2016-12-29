<?php
/*
Plugin Name: Phone Number Field for Advanced Custom Fields
Plugin URI: http://ideaboxcreations.com/
Description: Adds a Phone Number field with validation for Advanced Custom Fields plugin.
Version: 1.0.0
Author: IdeaBox Creations
Author URI: http://ideaboxcreations.com/
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;
// check if class already exists
if( !class_exists('acf_plugin_phone') ) :
class acf_plugin_phone {

	/*
	*  __construct
	*
	*  This function will setup the class functionality
	*
	*  @since	1.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/

	function __construct() {

		// vars
		$this->settings = array(
			'version'	=> '1.0.0',
			'url'		=> plugin_dir_url( __FILE__ ),
			'path'		=> plugin_dir_path( __FILE__ )
		);


		// set text domain
		// https://codex.wordpress.org/Function_Reference/load_plugin_textdomain
		// load_plugin_textdomain( 'acf-phone', false, plugin_basename( dirname( __FILE__ ) ) . '/lang' );


		// include field
		add_action('acf/include_field_types', 	array($this, 'include_field_types')); // v5
		add_action('acf/register_fields', 		array($this, 'include_field_types')); // v4

	}


	/*
	*  include_field_types
	*
	*  This function will include the field type class
	*
	*  @since	1.0.0
	*
	*  @param	$version (int) major ACF version. Defaults to false
	*  @return	n/a
	*/

	function include_field_types( $version = false ) {

		// support empty $version
		if( !$version ) $version = 5;


		// include
		include_once('fields/acf-phone-v' . $version . '.php');

	}

}
// initialize
new acf_plugin_phone();
// class_exists check
endif;

?>
