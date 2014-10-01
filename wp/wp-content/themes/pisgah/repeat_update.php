<?php
/*
This script will check to see if there is a repeat event in the current event schedule and if not it will update the post to occur on the next week. This should only be included inside another page and preferably one that is related to upcoming events.
*/


// See if the posts are still in the future

$cut_date=date("Y-m-d H:i:s",strtotime("-24 hours")); //Cut date used in event lists
$args = array( 'post_type' => 'shows', 'posts_per_page'=>-1, 'orderby'=>'meta_value','order'=>'asc', 'meta_key'=>'Start Time and Date', 'meta_query' => array(
		array(
			'key' => 'Start Time and Date',
			'value' => $cut_date,
			'compare' => '<'
		)
	));

	$future = new WP_Query( $args );
	$vinylID=0;
	$throwbackID=0;
	$pintsID=0;
	$growlersID=0;

	while ( $future->have_posts() ) : $future->the_post();
		/* Removed in late Oct 2012 
		if(stripos(get_the_title(),"vinyl night")!==FALSE){
			$vinylID=get_the_id();
			d("Vinyl ".$vintylID);
		} */

		if(stripos(get_the_title(),"throwback thursday")!==FALSE){
			$throwbackID=get_the_id();
			d("Throwback ".$throwbackID);
		}
		if(stripos(get_the_title(),"1 off pisgah pints")!==FALSE){
			$pintsID=get_the_id();
			d("Pints ".$pintsID);
		}  
		if(stripos(get_the_title(),"1 off pisgah growlers")!==FALSE){
			$growlersID=get_the_id();
			d("Growlers ".$growlersID);
		}  
	endwhile;


				
	// update($vinylID,"Tuesday","6:00 PM"); // Removed Oct 2012
	update($throwbackID,"Thursday","6:30 PM");
	update($pintsID,"Monday","4:00 PM");
	update($growlersID,"Tuesday","4:00 PM");
	

function update($eventPost,$day,$time){
	if($eventPost!=0){
		$date=date("Y-m-d H:i:s",strtotime("next ".$day." ".$time)); // PHP <3
		update_post_meta($eventPost,'Start Time and Date',$date);
		d("Updated $eventPost to  $date");
	}
}

function d($value){
	if($_GET['d']==1){
		echo "<!--";
		pre($value);
		echo "-->";
	}
}

function pre($array){
	if(is_array($array)){
		echo "<pre>";
		print_r($array);
		echo "</pre>";
	} elseif (is_object($array)) {
		echo "<pre>";
		var_dump($array);
		echo "</pre>";
	} else {
		echo $array;
	}
}
?>
