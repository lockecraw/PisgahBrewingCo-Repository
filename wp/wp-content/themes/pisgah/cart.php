<?php
/*
Template Name: Cart Page
*/
get_header(); ?>
<div id='main_stage'>
	<div id='internal_bg'>
	<div id='internal_copy' class='add_shadow'>
	<?php while (have_posts()) : the_post(); ?>
	<div id='internal_copy_title'><h2><?php the_title(); ?></h2></div>
	<div id='internal_copy_text'><?php the_content(); ?></div>
	<?php endwhile; ?>
	</div>
	<?php echo pisghaShopSidebar ();?>
	</div>
</div>
<?php get_footer(); ?>

