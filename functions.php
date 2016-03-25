<?php

//Actions
add_action( 'wp_enqueue_scripts', 'wordcampsc_enqueue_resources' );
add_action( 'after_setup_theme', 'wordcampsc_theme_support' );
add_action( 'widgets_init', 'wordcampsc_widgets_init' );
add_action( 'init', 'wordcampsc_menus' );

function wordcampsc_enqueue_resources() {
	wp_enqueue_style( 'bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.min.css' );
	wp_enqueue_style( 'wordcampsc', get_stylesheet_directory_uri() . '/css/style.css' );
}

function wordcampsc_theme_support() {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-header', array(
		'width' => 1170,
		'height' => 150,
		'default-image' => get_stylesheet_directory_uri() . '/images/Wordcamp_Sunshine_Coast_Hero_Background_7.jpg'
	) );
	add_theme_support( 'custom-background' );
	add_theme_support( 'title-tag' );
}

function wordcampsc_widgets_init() {

	register_sidebar( array(
		'name'          => 'Right Sidebar',
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