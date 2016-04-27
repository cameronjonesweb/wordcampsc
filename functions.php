<?php

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
	
	//Add a setting that changes the colour of links
	$wp_customize->add_setting( 'wordcampsc_link_colour', array(
		'type' => 'theme_mod',
		'capability' => 'edit_theme_options',
		'default' => '#337ab7', 
		'transport' => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	//Add a colour picker control to manage the setting.
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wordcampsc_link_colour', array(
		'label'        => __( 'Link Colour', 'wordcampsc' ),
		'section'    => 'colors',
	) ) );

	//Add a partial to update the preview
	$wp_customize->selective_refresh->add_partial( 'wordcampsc_link_colour', array(
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
	echo 'a{color:' . get_theme_mod( 'wordcampsc_link_colour', '' ) . '};'; 
}