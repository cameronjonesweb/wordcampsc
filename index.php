<?php get_header();?>
<?php 
$cols = 12;
$cols -= has_nav_menu( 'left-menu' ) ? 3 : 0;
$cols -= is_active_sidebar( 'right' ) ? 3 : 0;
?>
<div class="row" id="content">
	<?php if ( has_nav_menu( 'left-menu' ) ) {?>
		<div class="col-xs-12 col-md-3 sidebar">
			<?php wp_nav_menu( array(
				'theme_location' => 'left-menu'
			) );?>
		</div>
	<?php } ?>
	<div class="col-xs-12 col-md-<?php echo $cols;?>">
	<?php if( have_posts() ) { ?>
		<?php while( have_posts() ) { ?>
			<?php the_post();?>
			<h1><?php the_title();?></h1>
			<?php the_content();?>
		<?php } ?>
	<?php } ?>
	</div>
	<?php if ( is_active_sidebar( 'right' ) ) {?>
		<div class="col-xs-12 col-md-3 sidebar">
			<?php dynamic_sidebar( 'right' ); ?>
		</div>
	<?php } ?>
</div>

<?php get_footer();?>