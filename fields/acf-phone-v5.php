<?php
// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;
// check if class already exists
if( !class_exists('acf_field_phone') ) :
class acf_field_phone extends acf_field {


	/*
	*  __construct
	*
	*  This function will setup the field type data
	*
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/

	function __construct( $settings ) {

		/*
		*  name (string) Single word, no spaces. Underscores allowed
		*/

		$this->name = 'phone';


		/*
		*  label (string) Multiple words, can include spaces, visible when selecting a field type
		*/

		$this->label = __('Phone Number', 'acf-phone');


		/*
		*  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
		*/

		$this->category = 'basic';


		/*
		*  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
		*  var message = acf._e('FIELD_NAME', 'error');
		*/

		$this->l10n = array(
			'error'	=> __('Error! Please enter a valid phone number.', 'acf-phone'),
		);

		$this->defaults = array(
			'default_value'	=> '',
			'placeholder'	=> '',
			'prepend'		=> '',
			'append'		=> ''
		);


		/*
		*  settings (array) Store plugin settings (url, path, version) as a reference for later use with assets
		*/

		$this->settings = $settings;


		// do not delete!
    	parent::__construct();

	}

	/*
	*  render_field_settings()
	*
	*  Create extra options for your field. This is rendered when editing a field.
	*  The value of $field['name'] can be used (like bellow) to save extra data to the $field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field	- an array holding all the field's data
	*/

	function render_field_settings( $field ) {

		// default_value
		acf_render_field_setting( $field, array(
			'label'			=> __('Default Value','acf-phone'),
			'instructions'	=> __('Appears when creating a new post','acf-phone'),
			'type'			=> 'text',
			'name'			=> 'default_value',
		));


		// placeholder
		acf_render_field_setting( $field, array(
			'label'			=> __('Placeholder Text','acf-phone'),
			'instructions'	=> __('Appears within the input','acf-phone'),
			'type'			=> 'text',
			'name'			=> 'placeholder',
		));


		// prepend
		acf_render_field_setting( $field, array(
			'label'			=> __('Prepend','acf-phone'),
			'instructions'	=> __('Appears before the input','acf-phone'),
			'type'			=> 'text',
			'name'			=> 'prepend',
		));


		// append
		acf_render_field_setting( $field, array(
			'label'			=> __('Append','acf-phone'),
			'instructions'	=> __('Appears after the input','acf-phone'),
			'type'			=> 'text',
			'name'			=> 'append',
		));

	}


	/*
	*  render_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field (array) the $field being rendered
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/

	function render_field( $field ) {

		/*
		*  Create a simple text input.
		*/

		// vars
		$atts = array();
		$o = array( 'type', 'id', 'class', 'name', 'value', 'placeholder' );
		$s = array( 'readonly', 'disabled' );
		$e = '';
		$field[ 'type' ] = 'text';

		// prepend
		if( $field['prepend'] !== "" ) {

			$field['class'] .= ' acf-is-prepended';
			$e .= '<div class="acf-input-prepend">' . $field['prepend'] . '</div>';

		}

		// append
		if( $field['append'] !== "" ) {

			$field['class'] .= ' acf-is-appended';
			$e .= '<div class="acf-input-append">' . $field['append'] . '</div>';

		}

		// append atts
		foreach( $o as $k ) {

			$atts[ $k ] = $field[ $k ];

		}

		// append special atts
		foreach( $s as $k ) {

			if( !empty($field[ $k ]) ) $atts[ $k ] = $k;

		}

		// render
		$e .= '<div class="acf-input-wrap">';
		$e .= '<input ' . acf_esc_attr( $atts ) . ' />';
		$e .= '</div>';

		// return
		echo $e;

	}


	/*
	*  input_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
	*  Use this action to add CSS + JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_enqueue_scripts)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	function input_admin_enqueue_scripts() {

		// vars
		$url = $this->settings['url'];
		$version = $this->settings['version'];

		// register & include JS
		wp_register_script( 'acf-masked-input', "{$url}assets/js/jquery.maskedinput.min.js", array(), $version );
		wp_enqueue_script('acf-masked-input');

		// register & include JS
		wp_register_script( 'acf-input-phone', "{$url}assets/js/input.js", array('acf-input'), $version );
		wp_enqueue_script('acf-input-phone');

	}

	/*
	*  load_value()
	*
	*  This filter is applied to the $value after it is loaded from the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/

	function load_value( $value, $post_id, $field ) {

		return $value;

	}




	/*
	*  update_value()
	*
	*  This filter is applied to the $value before it is saved in the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/

	function update_value( $value, $post_id, $field ) {

		return $value;

	}




	/*
	*  format_value()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is returned to the template
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value which was loaded from the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*
	*  @return	$value (mixed) the modified value
	*/

	function format_value( $value, $post_id, $field ) {

		// bail early if no value
		if( empty($value) ) {

			return $value;

		}

		// return
		return $value;
	}




	/*
	*  validate_value()
	*
	*  This filter is used to perform validation on the value prior to saving.
	*  All values are validated regardless of the field's required setting. This allows you to validate and return
	*  messages to the user if the value is not correct
	*
	*  @type	filter
	*  @date	11/02/2014
	*  @since	5.0.0
	*
	*  @param	$valid (boolean) validation status based on the value and the field's required setting
	*  @param	$value (mixed) the $_POST value
	*  @param	$field (array) the field array holding all the field options
	*  @param	$input (string) the corresponding input name for $_POST value
	*  @return	$valid
	*/

	function validate_value( $valid, $value, $field, $input )
	{

		if ( empty( $value ) ) {
			return $valid;
		}

		if( ! preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $value) )
		{
			if ( ! preg_match("/(\(\d{3}+\)+ \d{3}+\-\d{4}+)/", $value) )
			{
				$valid = __('Please enter valid phone number!','acf-phone');
			}
		}

		// return
		return $valid;

	}




	/*
	*  load_field()
	*
	*  This filter is applied to the $field after it is loaded from the database
	*
	*  @type	filter
	*  @date	23/01/2013
	*  @since	3.6.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	$field
	*/

	function load_field( $field ) {

		return $field;

	}




	/*
	*  update_field()
	*
	*  This filter is applied to the $field before it is saved to the database
	*
	*  @type	filter
	*  @date	23/01/2013
	*  @since	3.6.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	$field
	*/

	function update_field( $field ) {

		return $field;

	}




}
// initialize
new acf_field_phone( $this->settings );
// class_exists check
endif;
?>
