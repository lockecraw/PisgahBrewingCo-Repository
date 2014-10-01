<?php
/**
 * @package WordPress
 * @subpackage Pisgah
 */
?>
<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); // load comment js for singular entries.
$theme_uri=get_stylesheet_directory_uri();
 ?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />


<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />


<meta property="og:image" content="<?php echo $theme_uri; ?>/images/pisgah_logo50-trans.png"/> 
<meta property="fb:admins" content="pisgahbrewing"/>
<meta property="og:title" content="<?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?>"/>
<meta property="og:type" content="website"/>
<meta property="og:url" content="http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>"/>
<meta property="og:locale" content="en_US"/>

<link href="<?php echo $theme_uri; ?>/css/league.css" rel='stylesheet' type='text/css'>

<script type="text/javascript" src="<?php echo $theme_uri; ?>/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?php echo $theme_uri; ?>/js/jquery.boxshadow.js"></script>
<script type="text/javascript" src="<?php echo $theme_uri; ?>/js/jquery.pisgahslides.js"></script>
<script type="text/javascript" src="<?php echo $theme_uri; ?>/js/overscroll/jquery.overscroll.js"></script> 
<!--[if lt IE 9]>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		if ($.browser.msie) {
			$(".add_shadow").boxShadow( 4, 5, 5, "#000");			
		} 		
	});
</script>
<![endif]-->
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id='master_container'>

	<div id='top_banner' class='add_shadow'>
		<div id='logo_nav'>
<?php if($_GET['overlay']===""){echo"<img src='$theme_uri/images/show_page.jpg' id='theOverlay' style='position: absolute; top:0px; left: -121px; z-index:20;'><script type='text/javascript' src='$theme_uri/js/1pixel.js'></script>";}?>
		
			<a href="<?php echo get_option('home'); ?>" id='logo'><img src="<?php echo get_stylesheet_directory_uri() ?>/images/pisgah_logo-trans.png" title="<?php bloginfo('name'); ?>"></a>
			<img id='treat_yourself' src="<?php echo get_stylesheet_directory_uri() ?>/images/WeAllDrink.png" title="<?php bloginfo('description'); ?>">

		
<?php wp_nav_menu( array( 'sort_column' => 'menu_order', 'container_class' => 'nav' ) ); ?>

		</div>
	</div>

