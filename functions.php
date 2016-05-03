<?php

/**
 * functions.php file for my presentation at WordCamp Sunshine Coast #WordCampSC
 * 
 * @author Cameron Jones
 * @copyright 2016 Cameron Jones
 * @license GPLv2 http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

//Actions
add_action( 'wp_enqueue_scripts', 'wordcampsc_enqueue_resources' );
add_action( 'after_setup_theme', 'wordcampsc_theme_support' );
add_action( 'widgets_init', 'wordcampsc_widgets_init' );
add_action( 'init', 'wordcampsc_menus' );
//Register our settings, controls and selective refresh functions for the Customizer
add_action( 'customize_register', 'wordcampsc_customize_register' );
//Hook the output of Customizer styles to the <head>
add_action( 'wp_head', 'wordcampsc_customize_styles' );

function wordcampsc_enqueue_resources() {
	
	wp_enqueue_style( 'bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.min.css' );
	wp_enqueue_style( 'wordcampsc', get_stylesheet_directory_uri() . '/css/style.css' );
	
}

function wordcampsc_theme_support() {
	
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-header', array(
		'width' => 1170,
		'height' => 150,
		'default-image' => get_stylesheet_directory_uri() . '/images/Wordcamp_Sunshine_Coast_Hero_Background_7.jpg',
		'header-text' => false
	) );
	add_theme_support( 'custom-background' );
	add_theme_support( 'title-tag' );
	//Add support for widget selective refresh
	add_theme_support( 'customize-selective-refresh-widgets' );
	
}

function wordcampsc_widgets_init() {

	register_sidebar( array(
		'name'          => __( 'Right Sidebar', 'wordcampsc' ),
		'id'            => 'right',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );

}

function wordcampsc_menus() {
	
	register_nav_menus(
		array(
			'left-menu' => __( 'Left Sidebar Menu', 'wordcampsc' )
		)
	);
	
}

/**
 * Output the styles set by Customizer settings in the <head>
 * 
 * @return void
 */

function wordcampsc_customize_styles() {
	
	echo '<style id="wordcampsc_customize_styles">';
		wordcampsc_customize_style_output();
	echo '</style>';
	
}

/**
 * Register the setting field, add setting colour picker control and selective refresh.
 * 
 * @param WP_Customize_Manager $wp_customize 
 * @return void
 */

function wordcampsc_customize_register( WP_Customize_Manager $wp_customize ) {
	
	/**
	 * @var $setting Define the handle for our setting so we don't repeat ourselves.
	 */ 

	$setting = 'wordcampsc_link_colour';

	/** 
	 * Add a setting that changes the colour of links
	 * 
	 * Example: $wp_customize->add_setting( $setting, $args );
	 * 			$setting:  setting id handle/slug
	 * 			$args = array(
	 *				'default' => $default, // A default value for the setting if none is defined.
	 * 				'type' => $type, // Optional. Specifies the TYPE of setting this is. Options are 'option' (best for plugins) or 'theme_mod' (best for themes) (defaults to 'theme_mod')
	 *				'capability' => $capability, // Optional. You can define a capability a user must have to modify this setting. Default if not specified: edit_theme_options
	 * 				'theme_supports' => $theme_supports, // Optional. This can be used to hide a setting if the theme lacks support for a specific feature (using add_theme_support).
	 *				'transport' => $transport, // Optional. This can be either 'refresh' (default) or 'postMessage'. Set to 'postMessage' for settings that will update in the live preview such as colours
	 *				'sanitize_callback' => $sanitize_callback, // Optional. A function name to call for sanitizing the input value for this setting. The function should be of the form of a standard filter function, where it accepts the input data and returns the sanitized data.
	 * 				sanitize_js_callback => $sanitize_js_callback // Optional. A function name to call for sanitizing the value for this setting for the purposes of outputting to javascript code. The function should be of the form of a standard filter function, where it accepts the input data and returns the sanitized data. This is only necessary if the data to be sent to the customizer window has a special form.
	 * 			);
	 * 					
	 */
	$wp_customize->add_setting( $setting, array(
		'type' => 'theme_mod',
		'default' => '#337ab7', 
		'transport' => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	/**
	 * Add a colour picker control to manage the setting.
	 * 
	 * Basic Example: $wp_customize->add_control( $setting, $args );
	 * With this implementation WordPress will instatiate a new WP_Customize_Control, which limits the type of settings to basic form inputs such as text, dropdown, checkbox. For colours and images, use the advanced implementation
	 * 
	 * Advanced Example (recommended): $wp_customize->add_control( new $class( $wp_customize, $setting, $args ) );
	 * 
	 */
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $setting, array(
		'label'        => __( 'Link Colour', 'wordcampsc' ),
		'section'    => 'colors',
	) ) );

	/**
	 *Add a partial to update the preview
	 */
	$wp_customize->selective_refresh->add_partial( $setting, array(
        'selector' => '#wordcampsc_customize_styles',
        'render_callback' => function() {
            wordcampsc_customize_style_output();
        },
    ) );
	
}

/**
 * Outputs styles managed by #WordCampSC controls to be used by partial refresh and front end display
 * 
 * @return void
 */

function wordcampsc_customize_style_output() {
	echo 'a{color:' . get_theme_mod( $setting, '' ) . '};'; 
}