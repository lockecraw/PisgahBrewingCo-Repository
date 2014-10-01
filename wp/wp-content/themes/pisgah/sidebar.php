<?php
/**
 * @package WordPress
 * @subpackage Pisah_Theme
 */
?>
	<div id='sidebar' class='add_shadow'>
				<?php
if($post->post_parent==443){$post=wp_get_single_post($post->post_parent);}// exception for photo gallery plugin
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
