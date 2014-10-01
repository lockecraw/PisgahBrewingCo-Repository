<?php
/**
 * @package WordPress
 * @subpackage Pisgah_Theme
 */

get_header(); ?>
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
			<div class='internal_copy add_shadow'>
				<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
					<div class='internal_copy_title'>
						<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'kubrick'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
					</div>
					<div class='internal_copy_text'>
						<small><?php the_time(__('F jS, Y', 'kubrick')) ?> <!-- by <?php the_author() ?> --></small>
						<div class="entry">
							<?php the_content(__('Read the rest of this entry &raquo;', 'kubrick')); ?>
						</div>
						<p class="postmetadata"><?php the_tags(__('Tags:', 'kubrick') . ' ', ', ', '<br />'); ?> <?php printf(__('Posted in %s', 'kubrick'), get_the_category_list(', ')); ?> | <?php edit_post_link(__('Edit', 'kubrick'), '', ' | '); ?>  <?php comments_popup_link(__('No Comments &#187;', 'kubrick'), __('1 Comment &#187;', 'kubrick'), __('% Comments &#187;', 'kubrick'), '', __('Comments Closed', 'kubrick') ); ?></p>
					</div>
			</div>
			<div class='internal_top'></div>
			<div class='internal_bottom'></div>
		</div>
		<?php endwhile; endif; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link(__('&laquo; Older Entries', 'kubrick')) ?></div>
			<div class="alignright"><?php previous_posts_link(__('Newer Entries &raquo;', 'kubrick')) ?></div>
		</div>
			
	</div>
			
</div>
<div id="content" class="narrowcolumn" role="main">
	<div class="navigation">
		<div class="alignleft"><?php next_posts_link(__('&laquo; Older Entries', 'kubrick')) ?></div>
		<div class="alignright"><?php previous_posts_link(__('Newer Entries &raquo;', 'kubrick')) ?></div>
	</div>
	<?php if($post->post_parent){ // we aren't on the top level
		$parent=wp_get_single_post($post->post_parent); 
			if($top_level=wp_get_single_post($parent->post_parent)){
				if($parent->post_title=="The Brewery"){ ?>
					<div id='internal_sidebar_right'>
						<ul class='right_sidebar_nav'>	
							<?php echo $children = wp_list_pages("title_li=&depth=3&sort_column=menu_order&child_of=".$parent->ID."&echo=0"); ?>
						</ul>
					</div>	
	<?php
				}
			}
		}
	?>
</div>
<?php get_footer(); ?>