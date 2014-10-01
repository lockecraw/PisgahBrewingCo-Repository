<?php
/*
Template Name: Individual Event
*/
get_header(); ?>
<script type='text/javascript'>
$(document).ready(function(){
	$("#menu-item-49").addClass("current_page_item");
});
</script>
<script type='text/javascript'>
$(document).ready(function(){
	$('.event_summary_genre').each(function(){
		if($(this).height()<=15){
			$(this).css('margin-top','7px');
		}
	});
});
</script>
<div id='main_stage'>
	

	<div id='internal_bg'>
	<?php while (have_posts()) : the_post(); ?>
	<?php 	$date=get_post_meta(get_the_ID(), "Start Time and Date", true);
					$open=get_post_meta(get_the_ID(), "Gate Open Time and Date", true);
					$tix=get_post_meta(get_the_ID(), "Ticket Link", true);
					$subtitle=get_post_meta(get_the_ID(), "Subtitle", true);
					$genre=get_post_meta(get_the_ID(), "Genre", true);
					$thumbnail=wp_get_attachment_url( get_post_meta(get_the_ID(), "Thumbnail", true));
					$vendor=get_post_meta(get_the_ID(), "Vendor", true);
					$stage=strtoupper(get_post_meta(get_the_ID(), "Stage", true));					

					if($stage=="OUTDOOR"){
						$band_default=get_stylesheet_directory_uri()."/images/band_default_outdoor.jpg";
					} else {
						$band_default=get_stylesheet_directory_uri()."/images/band_default.jpg";
					}
					if($thumbnail==''){
						$thumbnail=$band_default;
					}
					
					$gate=date("g:i a",strtotime($open));
					
					$show=date("g:i a",strtotime($date));
					$early=get_post_meta(get_the_ID(), "Early Cover", true);
					$late=get_post_meta(get_the_ID(), "Late Cover", true);
					$hopster=get_post_meta(get_the_ID(), "Hopster Cover", true);
					$brewmaster=get_post_meta(get_the_ID(), "Brewmaster Cover", true);
					$hta=get_post_meta(get_the_ID(), "Hard Tickets", true);
					$ticketSale=get_post_meta(get_the_ID(), "Tickets Available Date", true);
					$ticketSaleDate=strtotime($ticketSale);					
					$now=strtotime('now');
					$ticketsOnSale=($now>$ticketSaleDate ? true: false);
				$showOrEvent=get_post_meta(get_the_ID(), "Show or Event", true);
					if($showOrEvent==''){
						$showOrEvent=($stage=='OFFSITE' ? "Event" : "Show");
					}
					$location=($stage=='OUTDOOR' ? 'Outdoor '.($showOrEvent=="Event" ? "" : "Stage") : ($stage=='OFFSITE' ? 'Off-site' : 'Inside the Taproom'));

					$gateOrDoor=($stage=='OUTDOOR' ? 'Gate' : 'Door');
				
					if($stage=='OUTDOOR'){
						echo '<div class="event_page_outdoor add_shadow">';
					} else {
						echo '<div class="event_page add_shadow">';
					}
					echo "<div class='event_thumbnail'><a href='".get_permalink()."'><img src='$thumbnail'></a></div>";
					echo '<div class="event_summary_calendar">
						<img src="'.get_stylesheet_directory_uri().'/images/date_background-trans.png" class="date_background">
						<div class="event_month">'.date("M",strtotime($date)).'</div>
						<div class="event_date">'.date("j",strtotime($date)).'</div>
						<div class="event_day">'.date("D",strtotime($date)).'</div>
					      </div>';
					echo '<a href="'.get_permalink().'" class="event_summary_title">'.get_the_title().'</a>';
					echo '<a href="'.get_permalink().'" class="event_summary_subtitle">'.$subtitle.'</a>';
					echo '<a href="'.get_permalink().'" class="event_summary_times">';

					if($gate==$show || $open==''){ // No pre-sales
						echo "$location<br/>$showOrEvent:$show";
					} else { // Pre-sales
						echo "$location<br/>$gateOrDoor:$gate / $showOrEvent: $show";
					}

					echo ($vendor!="" ? "<br/>Food Vendor: ".$vendor : "");
					echo "</a>";
//if($stage!='OFFSITE'){
					if($early==0 && $late==0){
						if(stripos(get_the_title(),"taproom closed")===FALSE){
						echo '<div class="event_summary_prices"><b>Free Show</b></div>';
						}
					} else{
				
if($tix!="" && $ticketsOnSale){
					echo '<div class="event_summary_tix"><a href="'.$tix.'" target="_blank"><img src="'.get_stylesheet_directory_uri().'/images/but_tickets.png" alt="Buy Tickets"></a></div>';}

					echo "<div class='event_summary_prices'>".
					
						($early!=0 ? "\$$early in Advance" : "").(($early!=0 && $late!=0) ? "," : "").
						($late!=0 ? " \$$late Day of $showOrEvent" : "").
						"<a href='".get_bloginfo('url') ."/events/vip-event-packages' class='special_link'>".($hopster!=0 ? "<br/> \$$hopster Hopster VIP" : "")."</a>".
						"<a href='".get_bloginfo('url') ."/events/vip-event-packages' class='special_link'>".($brewmaster!=0 ? "<br/> \$$brewmaster Brewmaster VIP" : "")."</a>".
						($hta!="" ? " <a href='/events/ticket-information'  class='special_link'>(HTA)</a>" : "").
					"</div>";}
						//}

		echo '<div class="event_page_bottom"><a href="'.get_permalink().'" class="event_summary_genre"><strong>Treat yourself to:</strong> '.$genre.'</a>';
		echo "<div class='event_summary_fb'>
<div id='fb-root'></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = '//connect.facebook.net/en_US/all.js#xfbml=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class='fb-like' data-href='".get_permalink()."' data-send='true' data-layout='button_count' data-width='450' data-show-faces='true'></div>
</div></div>";
		if($tix!="" && $ticketsOnSale){
		echo '<div class="event_summary_tix"><a href="'.$tix.'" target="_blank"><img src="'.get_stylesheet_directory_uri().'/images/but_tickets.png" alt="Buy Tickets"></a></div>';}
					echo "<div class='event_page_detail_title'>DETAILS</div>";
					echo "<div class='event_page_detail'>";
					the_content();
					echo "</div>";
		echo '</div>';	
	?>
		<?php endwhile;?>
		<div id='sidebar' class='add_shadow'>
				<div id='sidebar_title'>EVENTS</div>
				<div id='sidebar_content'>
					<ul class='sidebar_nav'>
					<?php 
					$id=30;//($post->post_parent ? wp_get_single_post($post->post_parent)->ID : get_the_ID()); // keep the parent ID if were in subnav

					echo $children = wp_list_pages("title_li=&depth=3&sort_column=menu_order&child_of=$id&echo=0"); 
					?>
					</ul>
				</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>

