<?php
/*
Template Name: Individual Beer
*/
get_header(); ?>
<script type='text/javascript'>
$(document).ready(function(){
	$("#menu-item-50").addClass("current_page_item");
});
</script>
<div id='main_stage'>
	

	<div id='internal_bg'>
	<?php while (have_posts()) : the_post(); ?>
	<?php 
	$thumbnail=wp_get_attachment_url( get_post_meta(get_the_ID(), "Thumbnail", true));
	$fullsize=wp_get_attachment_url( get_post_meta(get_the_ID(), "Full Size Image", true));
	$logo=wp_get_attachment_url( get_post_meta(get_the_ID(), "Custom Logo", true));
	?>
	<div id='beer_detail' class='add_shadow'>
		
			<a href='' id='beer_detail_image'><img src="<?php echo $fullsize;?>"></a>
		
		<div id='beer_detail_title'>
			<?php echo get_the_title();?>
		</div>
		<div id='beer_detail_right'>
			<div id='beer_detail_description'>
				<?php the_content();?>
			</div>
			<div id='beer_detail_data'>
				<ul>
				<?php

				function showData($data_key,$title,$single=true, $append="")
				{
					$data=get_post_meta(get_the_ID(), $title, $array);

			
					if(!$single){
						$data=implode($data,", ");
					}

					echo ($data=='' ? '' : "<li><strong>$title:</strong> $data$append</li>");
			
				}

				showData("Beer Style","Beer Style",false);
				showData("Availability","Availability",false);
				showData("Alcohol Content","Alcohol Content",false,"%");
				//showData("Original Gravity","Original Gravity",false,"° Plato");
				//showData("Final Gravity","Final Gravity",false,"° Plato");
				//showData("Bitterness Units","Bitterness Units",false," IBU");
				showData("Yeast","Yeast",false);
				showData("Bittering Hops","Bittering Hops",false);
				showData("Malts","Malts",false);		
				?>
				</ul>
			</div>
		</div> <!-- end beer detail right -->
		<?php $logo=($logo=="" ? get_stylesheet_directory_uri()."/images/basic_brew_logo.jpg" : $logo); ?>
		<a href='' id='beer_detail_logo'><img src="<?php echo $logo;?>"></a>
		<div id='internal_top'></div>
		<div id='internal_bottom'></div>
	</div>
	<?php endwhile;?>
		<div id='sidebar' class='add_shadow'>
				<div id='sidebar_title'>BEER</div>
				<div id='sidebar_content'>
					<ul class='sidebar_nav'>
					<?php 
					$id=27;//($post->post_parent ? wp_get_single_post($post->post_parent)->ID : get_the_ID()); // keep the parent ID if were in subnav

					echo $children = wp_list_pages("title_li=&depth=3&sort_column=menu_order&child_of=$id&echo=0"); 
					?>
					</ul>
				</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>

