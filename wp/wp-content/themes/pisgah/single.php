<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

get_header();
?>
<div id='main_stage'>
		<div id='internal_bg'>

		<?php // Force Sidebar to Media Page ?>
		<div id='sidebar' class='add_shadow'>
				<?php 
				$post=wp_get_single_post(32);
				 $title = !empty($post->post_parent) ? wp_get_single_post($post->post_parent)->post_title : get_the_title(); ?>
				<div id='sidebar_title'><?php echo $title;?></div>
				<div id='sidebar_content'>
					<ul class='sidebar_nav'>
					<?php 
					$id=($post->post_parent ? wp_get_single_post($post->post_parent)->ID : get_the_ID()); // keep the parent ID if were in subnav

					echo $children = wp_list_pages("title_li=&depth=3&sort_column=menu_order&child_of=$id&echo=0"); 
					?>
					</ul>
				</div>
		</div>



	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	
	
		<div id='internal_copy' class='add_shadow'>
		<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				<div class='internal_copy_title'><h2><?php the_title(); ?></h2></div>
				<div class='internal_copy_text'>
					<div class="entry">
					<?php the_content('<p class="serif">' . __('Read the rest of this entry &raquo;', 'kubrick') . '</p>'); ?>

					<?php wp_link_pages(array('before' => '<p><strong>' . __('Pages:', 'kubrick') . '</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					<?php the_tags( '<p>' . __('Tags:', 'kubrick') . ' ', ', ', '</p>'); ?>

					<?php comments_template(); ?>
					<div class="navigation">
						<div class="alignleft"><?php previous_post_link( '%link', '&laquo; %title' ) ?></div>
						<div class="alignright"><?php next_post_link( '%link', '%title &raquo;' ) ?></div>
					</div>
					</div>
				</div>
			</div>
		</div>

	

	<?php endwhile; else: ?>

		<p><?php _e('Sorry, no posts matched your criteria.', 'kubrick'); ?></p>

<?php endif; ?>

	</div>
</div>

<?php get_footer(); ?>
