<?php
/*
Template Name: Brews Index

*/
get_header(); ?>
<div id='main_stage'>
	<div id='internal_bg'>


<?php $args = array( 'post_type' => 'beers','orderby'=>'title','order'=>'asc');
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
