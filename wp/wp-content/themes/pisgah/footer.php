<?php
/**
 * @package WordPress
 * @subpackage Pisgah_Theme
 */

 wp_footer()
?>
</div><!-- end main stage -->
<div id='bottom_banner'>
	<div id='footer'>

	<div id='contact_links'><a href='mailto:info@pisgahbrewing.com' ><img class='buttons'  src="<?php echo get_stylesheet_directory_uri(); ?>/images/email_icon-trans.png" alt='Email'></a><a href='http://www.youtube.com/results?search_query=pisgah+brewing' target='_blank'><img class='buttons' src="<?php echo get_stylesheet_directory_uri(); ?>/images/youtube_icon-trans.png" alt='YouTube'></a><a href='http://www.facebook.com/PisgahBrewingCo' target='_blank'><img class='buttons' src="<?php echo get_stylesheet_directory_uri(); ?>/images/facebook_icon-trans.png" alt='Facebook'></a><a href='http://twitter.com/PisgahBrewing' target='_blank'><img class='buttons' src="<?php echo get_stylesheet_directory_uri(); ?>/images/twitter_icon-trans.png" alt='Twitter'></a>
		<div id='news_link'><a href='http://pisgahbrewing.com/media/in-the-news'><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/latest_news.jpg" alt='Latest News'></a></div>
</div>

	<?php wp_nav_menu( array( 'sort_column' => 'menu_order', 'menu'=>'Footer','container_class' => 'footer_nav' ) ); ?>



<span class='bold'>150 Eastside Drive, Black Mountain, NC 28711 | Phone 828.669.0190 | </span><a href='/info/hours-of-operation' class='white'>Hours</a> | <a href='/info/map' class='white'>Get Directions</a><br/>
&copy;<?php echo date("Y");?> Pisgah Brewing Company. All rights Reserved. | <a href=''>Terms of Service</a>
</div>
</div><!-- end master container -->
</body>
</html>
