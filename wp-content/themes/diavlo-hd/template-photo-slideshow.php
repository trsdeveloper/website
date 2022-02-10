<?php
/*
Template Name: Photo Slideshow
*/
I3D_Framework::template_header();

if (I3D_Framework::use_global_layout()) {
	I3D_Framework::render_page_in_layout($page_id);
	return;
} 

global $myPageID;
?>




<div>
<div class="container-wrapper header-top">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
            	 <?php the_widget( 'I3D_Widget_Logo', I3D_Widget_Logo::getPageInstance($page_id));  ?>
            
            </div>
			<div class="col-md-6">
				<div class="menu-top">
<nav class="navbar navbar-default cl-effect-4" role="navigation">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="menu-toggle">Main Menu</span>
      <span class="fa fa-th-list"></span>
    </button>

  </div>
<div class='collapse navbar-collapse navbar-ex1-collapse'>
                     <?php the_widget( 'I3D_Widget_Menu', array("no_wrapper" => true, "theme_location" => I3D_Framework::getDropDownsMenuID($page_id), "menu_type" => "primary-horizontal"));  ?>

</div>
</nav>

				</div>
			</div>
			<div class="col-md-2 hidden-sm visible-xs">
            	 <?php the_widget( 'I3D_Widget_SearchForm', I3D_Widget_SearchForm::getPageInstance($page_id, array('justification' => 'right', 'use_icon' => true)));  ?>
            
            </div>				

		</div>
	</div>
</div>

        
<style type="text/css">
body { background-image: none !important; background-color: none !important; background: none !important; } 

.header-top { opacity: 0.5; 
transition-property: opacity;
transition-duration: 1s;
-webkit-transition-property: opacity;
-webkit-transition-duration: 1s;
background-color: rgba(255,255,255,0.5);
}
.header-top:hover, .header-top:focus { 

opacity: 1.0; 
}

ul#demo-block{ margin:0 15px 15px 15px; }
ul#demo-block li{ margin:0 0 10px 0; padding:10px; display:inline; float:left; clear:both; color:#aaa; background:url('<?php echo get_stylesheet_directory_uri(); ?>/Library/sliders/supersized-slideshow/img/bg-black.png'); font:11px Helvetica, Arial, sans-serif; }
ul#demo-block li a{ color:#eee; font-weight:bold; }
</style>
    
    
<div class="container"></div>
		<script type="text/javascript">
			<?php $slideShowData = get_post_meta($myPageID, "slideshow", true); ?>

			jQuery(function(jQuery){
				$.supersized.themeVars['image_path'] = '<?php echo get_stylesheet_directory_uri(); ?>/Library/sliders/supersized-slideshow/img/';

				var ss = jQuery.supersized({
				
					// Functionality
					slideshow               :   1,			// Slideshow on/off
					autoplay				:	<?php echo $slideShowData['autoplay']; ?>,			// Slideshow starts playing automatically
					start_slide             :   1,			// Start slide (0 is random)
					stop_loop				:	0,			// Pauses slideshow on last slide
					random					: 	0,			// Randomize slide order (Ignores start slide)
					slide_interval          :   <?php echo $slideShowData['slide_interval'] * 1000; ?>,		// Length between transitions
					transition              :   <?php echo $slideShowData['transition']; ?>, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
					transition_speed		:	<?php echo $slideShowData['transition_speed'] * 1000; ?>,		// Speed of transition
					new_window				:	1,			// Image links open in new window/tab
					pause_hover             :   0,			// Pause slideshow on hover
					keyboard_nav            :   1,			// Keyboard navigation on/off
					performance				:	1,			// 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
					image_protect			:	1,			// Disables image dragging and right click with Javascript
															   
					// Size & Position						   
					min_width		        :   0,			// Min width allowed (in pixels)
					min_height		        :   0,			// Min height allowed (in pixels)
					vertical_center         :   1,			// Vertically center background
					horizontal_center       :   1,			// Horizontally center background
					fit_always				:	0,			// Image will never exceed browser width or height (Ignores min. dimensions)
					fit_portrait         	:   1,			// Portrait images will not exceed browser height
					fit_landscape			:   0,			// Landscape images will not exceed browser width
															   
					// Components							
					slide_links				:	'blank',	// Individual links for each slide (Options: false, 'num', 'name', 'blank')
					thumb_links				:	1,			// Individual thumb links for each slide
					thumbnail_navigation    :   0,			// Thumbnail navigation
					slides 					:  	[			// Slideshow Images
					<?php
					$pageData = get_post($page_id);
					$content = $pageData->post_content;
			        $pattern = '/\[gallery(([\s]?(columns)="(.*?)")|([\s]?(link)="(.*?)")|([\s]?(ids)="(.*?)")|([\s]?(orderby)="(.*?)"))*\]/';
					$matches = array();
				    $columns = 0;
					$orderby = "";
					$ids     = "";
					$link    = "";
					
					preg_match($pattern, $content, $matches);
					foreach ($matches as $position => $match) {
						$nextPosition = $position + 1;
						if ($match == "columns") {
							$columns = $matches["{$nextPosition}"];
						} else if ($match == "ids") {
							$ids = $matches["{$nextPosition}"];
						} else if ($match == "link") {
							$link = $matches["{$nextPosition}"];
							
						} else if ($match == "orderby") {
							$orderby = $matches["{$nextPosition}"];
							
						}
					}
					$galleryIDs = explode(",", $ids);
					
					if ($orderby == "rand") {

						shuffle($galleryIDs);
					}
					
					foreach ($galleryIDs as $attachmentID) {
						$largeImageUrl = wp_get_attachment_image_src( $attachmentID, 'full' );
						$attachmentMetadata = wp_get_attachment_metadata($attachmentID);
						$postData = get_post($attachmentID);
						$caption = $postData->post_excerpt;
	
						$imageURL = $largeImageUrl[0];
		
						$imageURL = str_replace("-".$largeImageUrl[1]."x".$largeImageUrl[2], "", $imageURL);
					
					?>
					
					
					
					{image : '<?php echo $imageURL;?>', title : '<?php echo $caption; ?>', thumb : '<?php echo $imageURL;?>', url : '<?php echo ($link == "none" ? "" : $imageURL);?>'},
<?php } ?>
],
												
					// Theme Options			   
					progress_bar			:	1,			// Timer for each slide							
					mouse_scrub				:	0

					
				});
		    });
		    
		</script>    
<!-- supersized slideshow
================================================== -->

	<!--Thumbnail Navigation-->
	<div id="prevthumb"></div>
	<div id="nextthumb"></div>
	
	<!--Arrow Navigation-->
	<a id="prevslide" class="load-item"></a>
	<a id="nextslide" class="load-item"></a>
	
	<div id="thumb-tray" class="load-item">
		<div id="thumb-back"></div>
		<div id="thumb-forward"></div>
	</div>
	
	<!--Time Bar-->
	<div id="progress-back" class="load-item">
		<div id="progress-bar"></div>
	</div>
	
	<!--Control Bar-->
	<div id="controls-wrapper" class="load-item">
		<div id="controls">
			
			<a id="play-button"><img id="pauseplay" src="<?php echo get_stylesheet_directory_uri(); ?>/Library/sliders/supersized-slideshow/img/pause.png"/></a>
		
			<!--Slide counter-->
			<div id="slidecounter">
				<span class="slidenumber"></span> / <span class="totalslides"></span>
			</div>
			
			<!--Slide captions displayed here-->
			<div id="slidecaption"></div>
			
			<!--Thumb Tray button-->
			<a id="tray-button"><img id="tray-arrow" src="<?php echo get_stylesheet_directory_uri(); ?>/Library/sliders/supersized-slideshow/img/button-tray-up.png"/></a>
			
			<!--Navigation-->
			<ul id="slide-list"></ul>
			
		</div>
	</div>

<?php get_footer(); ?>