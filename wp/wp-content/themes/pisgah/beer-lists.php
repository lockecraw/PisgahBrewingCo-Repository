<?php
/*
Template Name: Beer List
*/
get_header(); ?>
<div id='main_stage'>
	<div id='internal_bg'>

		<div id='sidebar' class='add_shadow'>
			<?php $title=($post->post_parent ? wp_get_single_post($post->post_parent)->post_title : get_the_title()); // keep the parent title ?>
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

<?php
$avail_key=array('whats-on-tap'=>'on tap','special-brews'=>'special','whats-new'=>'new','seasonal'=>'seasonal','year-round'=>'year-round');

$args = array( 'post_type' => 'beers','orderby'=>'meta_value_num title','order'=>'ASC', 'meta_key'=>'Display Priority', 'posts_per_page'=>-1, 'meta_query' => array(
		array(
			'key' => 'Availability',
			'value' => $avail_key[$post->post_name],
			'compare' => '='
		)
	));

if($post->post_name=='seasonal' || $post->post_name=='year-round'){
	$args = array( 'post_type' => 'beers','orderby'=>'meta_value_num title','order'=>'ASC', 'meta_key'=>'Display Priority','posts_per_page'=>-1,'meta_query' => array(
		array(
			'key' => 'Brew Schedule',
			'value' => $avail_key[$post->post_name],
			'compare' => '='
		)
	));  
}


$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post();
	$link=get_post_meta(get_the_ID(), "Link", true);
	$image=wp_get_attachment_url( get_post_meta(get_the_ID(), "Thumbnail", true));
	echo "<div class='beer_post add_shadow'>";
	echo "<a href='".get_permalink()."' class='beer_thumb'><img src='$image'></a>";
	echo "<a href='".get_permalink()."' class='beer_name'>".get_the_title()."</a>";
	echo "<a href='".get_permalink()."' class='beer_excerpt'>".get_the_excerpt()."</a>
	<a href='".get_permalink()."' class='beer_link'>read more</a>
	</div>";	
endwhile;?>



	</div>
</div>
<?php get_footer(); ?>
