<?php

/*
Plugin Name: Digiflow DDS Tools
Plugin URI: https://github.com/younesben99/dds-tools
Description: Tools for DDS website.
Version: 0.1
Author: Younes Benkheil
Author URI: https://digiflow.be/
License: GPL2
GitHub Plugin URI: https://github.com/younesben99/dds-tools
*/


function slideshowfunction( $atts ) {
   $siteurl = get_site_url();
	$a = shortcode_atts( array(
		'id' => get_the_ID()
	), $atts );
    $ssoutput .= '
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css">
<link rel="stylesheet" href="https://kenwheeler.github.io/slick/slick/slick-theme.css">
<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
';

$imageurl = get_field('_car_syncimages_key',$id);

foreach($imageurl as $iurl){
				    $firstrun .= '<div><a href="javascript:void(0);" class="clk"><img src="'.$iurl . '" alt=""></a></div>';
				    $secondrun .= '<div><img src="'.$iurl.'" alt=""></div>';
}
$ssoutput .= '<div class="wrapper">

    <div class="text-center">
   </div>
    <div class="main-slder" id="page" >
		<div class="sldrarea">
			<div class="close"></div>
			<div class="slider slider-single">
				
				
			'.$firstrun.'
				
				

			</div>
			<div class="slider slider-nav">
			   '.$secondrun.'
				
			</div>
		</div>
	
</div>
		
		
  </div>';



$ssoutput .= '
<script src="https://server.carvenge.com/bny2/wp-content/plugins/cvslideshow/assets/js/custom.js?ver='.uniqid().'"></script> ';
	return $ssoutput;
}
add_shortcode( 'cvslideshow', 'slideshowfunction' );



 ?>