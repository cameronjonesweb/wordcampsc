<?php

//Actions
add_action( 'wp_enqueue_scripts', 'wordcampsc_enqueue_resources' );
add_action( 'after_setup_theme', 'wordcampsc_theme_support' );
add_action( 'widgets_init', 'wordcampsc_widgets_init' );
add_action( 'init', 'wordcampsc_menus' );
add_action( 'customize_register', 'wordcampsc_customize_register' );
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


function wordcampsc_customize_styles() {
	
	echo '<style id="wordcampsc_customize_styles">';
		echo 'a:link{color:' . get_theme_mod( 'wordcampsc_link_colour', '' ) . ';}';
	echo '</style>';
	
}

function wordcampsc_customize_register( WP_Customize_Manager $wp_customize ) {
	
	//Add a setting that changes the colour of links
	$wp_customize->add_setting( 'wordcampsc_link_colour', array(
		'type' => 'theme_mod', // or 'option'
		'capability' => 'edit_theme_options',
		//'theme_supports' => '', // Rarely needed.
		'default' => '#337ab7', //Bootstrap link colour
		'transport' => 'postMessage', // or postMessage
		'sanitize_callback' => 'sanitize_hex_color',
		//'sanitize_js_callback' => '', // Basically to_json.
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wordcampsc_link_colour', array(
		'label'        => __( 'Link Colour', 'wordcampsc' ),
		'section'    => 'colors',
		//'settings'   => 'wordcampsc_link_colour',
	) ) );

	$wp_customize->selective_refresh->add_partial( 'wordcampsc_link_colour', array(
        'selector' => '#wordcampsc_customize_styles',
        'render_callback' => function() {
            echo 'a:link{color:' . get_theme_mod( 'wordcampsc_link_colour', '' ) . '};';
        },
    ) );
	
}