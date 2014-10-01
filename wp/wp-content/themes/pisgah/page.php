<?php
/**}
 * @package WordPress
 * @subpackage Pisgah_Theme
 */

get_header(); ?>
<div id='main_stage'>
<?php if(is_front_page()){ ?>
<div id='index_bg'>

		<div id='pod_slides' class='add_shadow'>

<?php 	$args = array( 'post_type' => 'slides','posts_per_page' => -1, 'orderby'=>'meta_value_num','order'=>'asc', 'meta_key'=>'Slide Order',
'meta_query' => array(
		array(
			'key' => 'Activate',
			'value' => 'on',
			'compare' => 'LIKE'
		)
	));
/**/
				$loop = new WP_Query( $args );
				$count=1;
				$total=$loop->post_count;
			while ( $loop->have_posts() ) : $loop->the_post();

				$link=get_post_meta(get_the_ID(), "Link", true);
				$image=wp_get_attachment_url( get_post_meta(get_the_ID(), "Image", true));
				//$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
				echo "<div id='slide_$count' class='slide_frame".($count==$total ? " shown" : ($count==$total-1 ? " " : " gone"))."' style='z-index:$count;' >";
				echo "<a href='$link'><img src='$image' class='slide_image'></a>";
				echo "<div class='slide_banner'></div>";
				echo "<div class='slide_title'><a href='$link'>".get_the_title()."</a></div>
				     </div>";
				$count++;
				
			endwhile; ?>

		</div>
		<div id='sidebar' class='add_shadow' >
			<script type='text/javascript'>
			$(document).ready(function(){
				$(".overscroll").overscroll({
		              hoverThumbs: true,
									showThumbs: true,
		              persistThumbs: false,
									direction: "vertical",
				})
			});
		  </script>
			<div id='sidebar_title'><a href='http://www.pisgahbrewing.com/events/'>Upcoming Events</a></div>
			<div id='home_sidebar_content' class='overscroll'>
			<?php // Note to be placed on the home page ?>
			<div class="event_listing">
				<div class="event_title event_note"><a href='http://pisgahbrewing.com/events/general-show-policy'>FOR TICKETED EVENTS THE TAPROOM IS OPEN TO THE PUBLIC UNTIL 1 HOUR BEFORE SHOWTIME </a></div>
			</div><!-- .event_listing -->


			<?php 
		
		$cut_date=date("Y-m-d H:i:s",strtotime("-6 hours"));  // Adjust for time zones
		echo "<div style='display:none;'>".$cut_date."</div>";
		$args = array( 'post_type' => 'shows', 'posts_per_page' => -1, 'orderby'=>'meta_value','order'=>'asc', 'meta_key'=>'Start Time and Date', 'meta_query' => array(
		array(
			'key' => 'Start Time and Date',
			'value' => $cut_date,
			'compare' => '>'
		)
	));
				$loop = new WP_Query( $args );
				$count=0;
				while ( $loop->have_posts() ) : $loop->the_post();
					//$realcut=date("Y-m-d H:i:s",strtotime("-16 hours"));
					$date=get_post_meta(get_the_ID(), "Start Time and Date", true);
					if(strtotime($date)<=$realcut){continue;}
					$tix=get_post_meta(get_the_ID(), "Ticket Link", true);
					$soldOut=get_post_meta(get_the_ID(), "Sold Out", true);
					$ticketSale=get_post_meta(get_the_ID(), "Tickets Available Date", true);

					$earlyTickets=get_post_meta(get_the_ID(), "Early Cover", true);
					$lateTickets=get_post_meta(get_the_ID(), "Late Cover", true);
					$hopsterTickets=get_post_meta(get_the_ID(), "Hopster Cover", true);
					$brewmasterTickets=get_post_meta(get_the_ID(), "Brewmaster Cover", true);

					if($earlyTickets!='' || $lateTickets!='' || $hopsterTickets!='' || $brewmasterTickets!=''){
						// There are some tickets for sale
						$freeShow=false;
					} else { $freeShow=true;}

					$ticketSaleDate=strtotime($ticketSale);					
					$now=strtotime('now');
					$ticketsOnSale=($now>$ticketSaleDate ? true: false);
				
					echo '<div class="event_listing">';
					echo '<div class="event_calendar">
						<img src="'.get_stylesheet_directory_uri().'/images/date_background-trans.png" class="date_background">
						<div class="event_month">'.date("M",strtotime($date)).'</div>
						<div class="event_date">'.date("j",strtotime($date)).'</div>
						<div class="event_day">'.date("D",strtotime($date)).'</div>
					      </div>';
					echo '<div class="event_title"><a href="'.get_permalink().'">'.get_the_title().'</a></div>';
					echo '<div class="event_time">'.date("g:i a",strtotime($date)).'</div>';
					if($tix!="" && $ticketsOnSale){ // we have a link and it's live: let them buy tickets
							echo '<div class="event_tix"><a href="'.$tix.'" target="_blank"><img src="'.get_stylesheet_directory_uri().'/images/buy_tix.jpg" alt="Buy Tickets"></a></div>';
					} else if($freeShow)  { // It's a free show
							if(stripos(get_the_title(),"taproom closed")===FALSE){
							echo '<div class="event_tix"><a href="'.get_permalink().'"><img src="'.get_stylesheet_directory_uri().'/images/free.jpg" alt="Free Show"></a></div>';
							}
					} else if($soldOut){ // no more tickets

					} else { // It's door tickets only
							echo '<div class="event_tix"><a href="'.get_permalink().'"><img src="'.get_stylesheet_directory_uri().'/images/door.jpg" alt="Free Show"></a></div>';
					}
					
					echo '</div>';
				$count++;
				endwhile;
				while($count<7){
				echo '<div class="event_listing"></div>'; $count++;
				} 
			?>
			
			</div><!-- end sidebar_content -->
			<a class="downloadButton" href="https://drive.google.com/folderview?id=0B4mxspsReqnabHRrOHEwVEFhdVk&usp=sharing" target="_blank">Download Past Shows</a>
		</div>
		<div class='pod_rect add_shadow'>
						<?php 	
			$args = array( 'post_type' => 'promos', 'posts_per_page' => 7, 'orderby'=>'post_date','order'=>'desc', 'meta_key'=>'Activate', 'meta_query' => array(
				array(
					'key' => 'Activate',
					'value' => 'on',
					'compare' => '='
				)
			));
				$loop = new WP_Query( $args );
				$count=0;
				while ( $loop->have_posts() ) : $loop->the_post();
					$link=get_post_meta(get_the_ID(), "Link", true);
					$image=wp_get_attachment_url( get_post_meta(get_the_ID(), "Image", true));
					echo "<a href='$link'><img src='$image'></a>";
				$count++;
				endwhile;
			?>
		</div>
		<div class='pod_square add_shadow'><img src="<?php echo get_stylesheet_directory_uri() ?>/images/noribbonlogo-web.jpg"></div>
	</div>
<?php } else { ?>
		<div id='internal_bg'>
			<?php get_sidebar();?>
			<div id='internal_copy' class='add_shadow'>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div id='internal_copy_title'><h2><?php the_title(); ?></h2></div>
			<div id='internal_copy_text'><?php the_content(); ?></div>
		<?php endwhile; endif; ?>
			<div id='internal_top'></div>
			<div id='internal_bottom'></div>
			</div>
			
			<?php if($post->post_parent){ // we aren't on the top level
	$parent=wp_get_single_post($post->post_parent); 
			if($top_level=wp_get_single_post($parent->post_parent)){
			if($parent->post_title=="The Brewery"){ ?>
			<div id='internal_sidebar_right'>
				<ul class='right_sidebar_nav'>	
				<?php echo $children = wp_list_pages("title_li=&depth=3&sort_column=menu_order&child_of=".$parent->ID."&echo=0"); ?>

				</ul>
			

			<?php } } } ?>

			</div>
		</div>
	</div>
<?php } // end if ! front page ?>
	

<?php get_footer(); ?>