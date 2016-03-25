<!DOCTYPE html>
<html <?php language_attributes();?>>
<head>
	<?php wp_head();?>
</head>
<body <?php body_class( 'container' );?>>
	<header style="background-image: url(<?php header_image(); ?>); min-height: <?php echo get_custom_header()->height; ?>px; max-width: <?php echo get_custom_header()->width; ?>px;color:<?php echo get_custom_header()->header_textcolor; ?>">
		<h3><?php bloginfo( 'name' ); ?></h3>
	</header>