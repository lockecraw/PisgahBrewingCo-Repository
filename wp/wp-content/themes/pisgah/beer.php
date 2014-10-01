<?php
/*
Template Name: Landing Page
*/
get_header(); ?>
<div id='main_stage'>
	<div id='internal_bg'>
	<div class='landing_image add_shadow'>
	<?php while (have_posts()) : the_post(); 
	the_content(); 
	endwhile; ?>
	</div>
	<!--<img src="<?php echo get_stylesheet_directory_uri();?>/images/beer_landing.jpg">-->
	<?php get_sidebar();?>
	</div>
</div>
<?php get_footer(); ?>

