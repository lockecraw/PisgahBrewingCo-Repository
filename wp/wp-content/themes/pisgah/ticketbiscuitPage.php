<?php
/*
Template Name: Full Page
*/
get_header(); ?>
<div id='main_stage'>
	<div id='full_internal_bg'>
		<div id='full_internal_copy'>
			<?php if (have_posts()) : while (have_posts()) : the_post();?>
				<?php the_content() ?>
			<?php endwhile; else: ?>
				<?php _e('Sorry, no posts matched your criteria.'); ?>
			<?php endif; ?>
		</div>
	
	<div id='full_internal_top'></div>
  <div id='full_internal_bottom'></div>
  </div>
</div>
<?php get_footer(); ?>
