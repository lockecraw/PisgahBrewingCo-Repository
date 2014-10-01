<?php
/*
This script will check to see if there is a "Vinyl Night" event in the current event schedule and if not it will update the post to occur on the next tuesday. This should only be included inside another page and preferably one that is related to upcoming events.
*/


// See if the vinyl night post is still in the future
/*
$cut_date=date("Y-m-d H:i:s",strtotime("-24 hours"));
$args = array( 'post_type' => 'shows', 'posts_per_page'=>-1, 'orderby'=>'meta_value','order'=>'asc', 'meta_key'=>'Start Time and Date', 'meta_query' => array(
		array(
			'key' => 'Start Time and Date',
			'value' => $cut_date,
			'compare' => '>'
		)
	));

	$vinyl = new WP_Query( $args );
	while ( $vinyl->have_posts() ) : $vinyl->the_post();
		if(stripos(get_the_title(),"vinyl night")!==FALSE){
			$vinylFound=TRUE;
		} 
	endwhile;

	if($vinylFound!==TRUE){
		// No vinyl night will appear on the event lists, find the old one and update the event date to the upcoming tuesday
		$query=new WP_query(array('post_type'=>'shows', 'posts_per_page'=>-1));
		while($query->have_posts()) : $query->the_post();
			if(stripos(get_the_title(),"vinyl night")!==FALSE){
				$post_id=get_the_id();
				$tuesday=date("Y-m-d H:i:s",strtotime("next Tuesday 6:00PM")); // PHP <3
				update_post_meta($post_id,'Start Time and Date',$tuesday);
			} 
		endwhile;
	} 
*/		
?>
