<?php
function i3d_render_slider($sliderID, $styledBG = true) {
  $sliders = get_option("i3d_sliders");
  $slider = @$sliders["{$sliderID}"];
  
	if ($slider['slider_type'] == "nivo-slider") {
		i3d_show_nivo_slider($sliderID, $styledBG);
	} else if ($slider['slider_type'] == "fullscreen-carousel") {
		i3d_show_fullscreen_carousel($sliderID);
	} else if ($slider['slider_type'] == "jumbotron-carousel") {
		i3d_show_jumbotron_carousel($sliderID);
	} else if ($slider['slider_type'] == "parallax-slider") {
		i3d_show_parallax_slider($sliderID);
	} else if ($slider['slider_type'] == "product-carousel") {
		i3d_show_fullscreen_carousel($sliderID);
	} else if ($slider['slider_type'] == "amazing-slider") {
		i3d_show_amazing_slider($sliderID, $styledBG);
	} else if ($slider['slider_type'] == "video-slider") {
		i3d_show_video_slider($sliderID, $styledBG);
	} else if ($slider['slider_type'] == "blur-slider") {
		i3d_show_blur_slider($sliderID);
	} else if ($slider['slider_type'] == "fullscreen-slider") {
		i3d_show_fullscreen_slider($sliderID);
	} else if ($slider['slider_type'] == "carousel-slider") {
		i3d_show_carousel_slider($sliderID);
	} else if ($slider['slider_type'] == "welcome-slider") {
	  i3d_show_welcome_slider($sliderID);	  
	} else if ($slider['slider_type'] == "bootstrap-slider") {
	  i3d_show_bootstrap_slider($sliderID);	  
	} else {
	  ?><!-- no slider --><?php 
	}
}
?>