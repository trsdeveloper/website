<?php

/***********************************/
/**        HTML WIDGET BOX        **/
/***********************************/
class I3D_Widget_Flickr extends WP_Widget {
	function __construct() {
	//function I3D_Widget_Flickr() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'Render Flickr Feed.', "i3d-framework") );
		$control_ops = array('width' => "400px");
		parent::__construct('i3d_flickr', __('i3d:Flickr Gallery', "i3d-framework"), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );
		$rand = rand();
		$instance = wp_parse_args( (array) $instance, array( 'title' => '','box_style' => '', 'text' => '', 'vector_icon' => '', 'justification' => '', 'api_key' => '', 'target' => '', 'flickr_id' => '', 'thumnbail_mask' => '' ) );
		
			$before_widget = str_replace("i3d-opt-box-style", $instance['box_style'], $before_widget);
	    if ($instance['thumnbail_mask'] != "") {
			wp_enqueue_script( 'aquila-mask-js',    get_stylesheet_directory_uri()."/Site/javascript/mask.js", array('jquery'), '1.0', true );
	
		}
		//$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
		$title = I3D_Framework::conditionFontAwesomeIcon($instance['title']);
		$api_key = $instance['api_key'];
		$flickr_id = $instance['flickr_id'];
		$justification = $instance['justification'];
		$target = $instance['target'];
		echo $before_widget;
		  echo "<div class='i3d-widget-htmlbox";
		  if ($justification == "right") {
			  echo " pull-right text-right";
		  } else if ($justification == "center") {
			  echo " text-center";
		  } else {
			  echo " text-left";
		  }
		  echo "'";
		  echo ">";
		if ( !empty( $title ) ) { echo $before_title;
		  if ($instance['vector_icon'] != "") {
			  echo "<i class='";
			  if (strstr($instance['vector_icon'], "fa-")) {
				  echo "fa ";
			  }
			  echo $instance['vector_icon'];
			  echo "'></i> ";
		  }
		echo $title . $after_title; } 
		if (I3D_Framework::$bootstrapVersion >= 3) {
		  switch($instance['columns']) {
			  case 12: $widthClass = "col-sm-1";
			      break;
			  case 6: $widthClass = "col-sm-2";
			      break;
			 case 4: $widthClass = "col-sm-3";
			      break;
			 case 3: $widthClass = "col-sm-4";
			      break;
			 case 2: $widthClass = "col-sm-6";
			      break;
			  case 1: $widthClass = "col-sm-12";
			      break;
			  default: $widthClass = "col-sm-4";
		 
		  }
		} else {
		  switch($instance['columns']) {
			 case 12: $widthClass = "span1";
			      break;
			case  6: $widthClass = "span2";
			      break;
			 case 4: $widthClass = "span3";
			      break;
			case  3: $widthClass = "span4";
			      break;
			case  2: $widthClass = "sapn6";
			      break;
			case  1: $widthClass = "span12";
			      break;
			  default: $widthClass = "span4";
		 
		  }
			
		}
		
		$maskData = "";
		$maskURL = "";
		$mask = "";
		$maskType = "";
		if ($instance['thumbnail_mask'] != "") {
			$mask = $instance['thumbnail_mask'];
			$maskData = "data-mask='".get_stylesheet_directory_uri()."/Site/graphics/masks/{$mask}.png' class='special-mask'";
		    $maskURL = get_stylesheet_directory_uri()."/includes/user_view/flickr.php?f=";
			$maskType = $instance['thumbnail_mask_aspect'];
		}
		// flickr code start
		?>
<style>
#flickr-gallery-<?php echo $rand; ?> div.outer { 
background-color: <?php echo $instance['thumbnail_background_color']; ?>;
padding: <?php echo $instance['thumbnail_background_padding']; ?> !important; 

	border-radius: <?php echo $instance['thumbnail_border_radius']; ?>;
	-moz-border-radius: <?php echo $instance['thumbnail_border_radius']; ?>;
	-webkit-border-radius: <?php echo $instance['thumbnail_border_radius']; ?>;
<?php if ($mask == "") { ?>	border: 1px solid transparent; <?php } ?>

}

#flickr-gallery-<?php echo $rand; ?> img { 
	border-radius: <?php echo $instance['thumbnail_border_radius']; ?>;
	-moz-border-radius: <?php echo $instance['thumbnail_border_radius']; ?>;
	-webkit-border-radius: <?php echo $instance['thumbnail_border_radius']; ?>;
	<?php if ($mask == "" && false) { ?> border: 1px solid <?php echo $instance['thumbnail_border_color']; ?>;<?php } ?>
}

#flickr-gallery-<?php echo $rand; ?> i {

	-moz-transition: all <?php echo $instance['thumbnail_hover_transition_time']; ?>s ease-in-out !important;
	-webkit-transition: all <?php echo $instance['thumbnail_hover_transition_time']; ?>s ease-in-out !important;
	-o-transition: all <?php echo $instance['thumbnail_hover_transition_time']; ?>s ease-in-out !important;
	-ms-transition: all <?php echo $instance['thumbnail_hover_transition_time']; ?>s ease-in-out !important;
	transition: all <?php echo $instance['thumbnail_hover_transition_time']; ?>s ease-in-out !important;
}

#flickr-gallery-<?php echo $rand; ?>  a:hover i {
	<?php if ($instance['thumbnail_icon_effect'] == "") { ?>
	-moz-transform: rotate(0deg) !important;
-webkit-transform:  rotate(0deg) !important;
-o-transform:  rotate(0deg) !important;
-ms-transform:  rotate(0deg) !important;
transform:  rotate(0deg) !important;
	<?php } else if ($instance['thumbnail_icon_effect'] == "spin") { ?>
-moz-transform: rotate(1440deg);
-webkit-transform: rotate(1440deg);
-o-transform: rotate(1440deg);
-ms-transform: rotate(1440deg);
transform: rotate(1440deg);
  <?php } ?>
}

#flickr-gallery-<?php echo $rand; ?> a {
	border-radius: <?php echo $instance['thumbnail_border_radius']; ?>;
	-moz-border-radius: <?php echo $instance['thumbnail_border_radius']; ?>;
	-webkit-border-radius: <?php echo $instance['thumbnail_border_radius']; ?>;
	background-color: rgba(<?php echo I3D_Framework::hex2RGB($instance['thumbnail_hover_color'], true) ?>);
	background-color: rgba(<?php echo I3D_Framework::hex2RGB($instance['thumbnail_hover_color'], true) ?>, <?php echo $instance['thumbnail_hover_color_alpha']; ?>);
	
	-moz-transition: all <?php echo $instance['thumbnail_hover_transition_time']; ?>s ease-in-out !important;
	-webkit-transition: all <?php echo $instance['thumbnail_hover_transition_time']; ?>s ease-in-out !important;
	-o-transition: all <?php echo $instance['thumbnail_hover_transition_time']; ?>s ease-in-out !important;
	-ms-transition: all <?php echo $instance['thumbnail_hover_transition_time']; ?>s ease-in-out !important;
	transition: all <?php echo $instance['thumbnail_hover_transition_time']; ?>s ease-in-ou !importantt;
}

</style>
<script>

function jsonFlickrApi(rsp) {

	//detect retina
	var retina = window.devicePixelRatio > 1 ? true : false;
	
	//makes sure everything's ok
	if (rsp.stat != "ok"){
		return;
	}
		
	//count number of responses
	<?php if ($instance['gallery_type'] == "photostream") { ?>
	var num = rsp.photos.photo.length;
	<?php } else { ?>
	var num = rsp.photoset.photo.length;
	<?php } ?>
		
	//variables "r" + "s" contain 
	//markup generated by below loop
	//r=retina, s=standard
	var r = "";
	var s = "";
	
	//this loop runs through every item and creates HTML that will display nicely on your page
	for (var i=0; i < num; i++) {
		<?php if ($instance['gallery_type'] == "photostream") { ?>
	photo = rsp.photos.photo[i];
		<?php } else { ?>
	photo = rsp.photoset.photo[i];
		<?php } ?>
	
	//create url for retina (o=original, bt=big thumb) and standard (st=standard thumb,
	//so= flickr "large")
	o_url = "http://farm"+ photo.farm +".staticflickr.com/"+ photo.server +"/"+ 
	photo.id +"_"+ photo.originalsecret +"_o.jpg";
		
	bt_url = "http://farm"+ photo.farm +".static.flickr.com/"+ photo.server +"/"+ 
	photo.id +"_"+ photo.secret +"_q.jpg";
		
	st_url = "http://farm"+ photo.farm +".static.flickr.com/"+ photo.server +"/"+ 
	photo.id +"_"+ photo.secret +"_s.jpg";
		
	so_url = "http://farm"+ photo.farm +".static.flickr.com/"+ photo.server +"/"+ 
	photo.id +"_"+ photo.secret +"_b.jpg";
	<?php if ($instance['thumbnail_type'] == "original-image") { ?>	
	r += "<li id='flickr_img_" + i + "'  class='<?php echo $widthClass; if ($mask != ""){ echo " special-mask-container"; } ?>'><div class='outer'><div class='inner'><img <?php echo $maskData; ?> alt='"+ photo.title +"' src='<?php echo $maskURL; ?>"+ o_url 
		+"' title='Click to view "+ photo.title +" full size'/><a rel='prettyPhoto[gallery_<?php echo $rand;  ?>]' <?php if ($target != "") { ?>target='<?php echo $target; ?>'<?php } ?> href='"+ o_url +"'><i class='fa <?php echo $instance['thumbnail_hover_icon']; ?>'></i></a></div></div></li>";
	s += "<li id='flickr_img_" + i + "'  class='<?php echo $widthClass; if ($mask != ""){ echo " special-mask-container"; } ?>'><div class='outer'><div class='inner'><img <?php echo $maskData; ?> alt='"+ photo.title +"' src='<?php echo $maskURL; ?>"+ so_url 
		+"' title='Click to view "+ photo.title +" full size'/><a rel='prettyPhoto[gallery_<?php echo $rand;  ?>]' <?php if ($target != "") { ?>target='<?php echo $target; ?>'<?php } ?> href='"+ so_url +"'><i class='fa <?php echo $instance['thumbnail_hover_icon']; ?>'></i></a></div></div></li>";

	<?php } else { ?>
	r += "<li id='flickr_img_" + i + "' class='<?php echo $widthClass; if ($mask != "") {echo "s pecial-mask-container"; } ?>'><div class='outer'><div class='inner'><img <?php echo $maskData; ?> alt='"+ photo.title +"' src='<?php echo $maskURL; ?>"+ bt_url 
		+"' title='Click to view "+ photo.title +" full size'/><a rel='prettyPhoto[gallery_<?php echo $rand;  ?>]' <?php if ($target != "") { ?>target='<?php echo $target; ?>'<?php } ?> href='"+ o_url +"'><i class='fa <?php echo $instance['thumbnail_hover_icon']; ?>'></i></a></div></div></li>";
	s += "<li id='flickr_img_" + i + "'  class='<?php echo $widthClass; if ($mask != "") {echo " special-mask-container"; } ?>'><div class='outer'><div class='inner'><img <?php echo $maskData; ?> alt='"+ photo.title +"' src='<?php echo $maskURL; ?>"+ st_url 
		+"' title='Click to view "+ photo.title +" full size'/><a rel='prettyPhoto[gallery_<?php echo $rand;  ?>]' <?php if ($target != "") { ?>target='<?php echo $target; ?>'<?php } ?> href='"+ so_url +"'><i class='fa <?php echo $instance['thumbnail_hover_icon']; ?>'></i></a></div></div></li>";

	<?php } ?>
		}
	//should be self explanatory
	if (retina){
		q = '<div id="flickr-gallery-<?php echo $rand; ?>" class="flickr_gallery_wrapper <?php echo $maskType; ?>"><ul class="gallery">'+ r +' </ul></div>'
	}
	else{
		q = '<div id="flickr-gallery-<?php echo $rand; ?>" class="flickr_gallery_wrapper <?php echo $maskType; ?>"><ul class="gallery">'+ s +' </ul></div>'
	}
	
	//this tells the JavaScript to write everything in variable q onto the page
	document.writeln(q); 

	function adjustFlickrGalleryIconSize() {

    jQuery(".flickr_gallery_wrapper img").each(function() {
		var imgWidth = jQuery(this).width();
		//alert(imgWidth);
		if (imgWidth < 100) {
			jQuery(this).parent().find("i").addClass("smaller");
		} else {
			jQuery(this).parent().find("i").removeClass("smaller");
		}
														});
	}
	jQuery(window).bind('load', function() { adjustFlickrGalleryIconSize(); });
	jQuery(window).bind("resize", function() { adjustFlickrGalleryIconSize(); });
	jQuery(window).bind('load', function(){
    jQuery("a[rel^='prettyPhoto']").prettyPhoto({social_tools: ''});
	

  });
}
</script>
<?php if ($instance['gallery_type'] == "photostream") { ?>
<script type="text/javascript" src="https://api.flickr.com/services/rest/?format=json&amp;method=flickr.photos.search&amp;user_id=<?php echo $flickr_id; ?>&amp;api_key=<?php echo $api_key; ?>&amp;media=photos&amp;per_page=<?php echo $instance['max_images']; ?>&amp;privacy_filter=1"></script>
<?php } else { ?>
<script type="text/javascript" src="https://api.flickr.com/services/rest/?method=flickr.photosets.getPhotos&api_key=<?php echo $api_key; ?>&photoset_id=<?php echo $instance['photoset_id']; ?>&format=json&extras=original_format"></script>
<?php }
		// flickr code end
		echo "</div>";
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['box_style'] 		= $new_instance['box_style'];
		$instance['title'] 			= stripslashes( wp_filter_post_kses( addslashes($new_instance['title'])));
		$instance['flickr_id'] 		= $new_instance['flickr_id']; 
		$instance['photoset_id'] 		= $new_instance['photoset_id']; 
		$instance['api_key'] 		= $new_instance['api_key']; 
		$instance['justification'] 	= $new_instance['justification']; 
		$instance['vector_icon']   	= $new_instance['vector_icon']; 
		$instance['max_images']   	= $new_instance['max_images']; 
		$instance['columns']   		= $new_instance['columns']; 
		$instance['target']   		= $new_instance['target']; 
		$instance['gallery_type']   		= $new_instance['gallery_type']; 
		$instance['thumbnail_type'] = $new_instance['thumbnail_type']; 
		$instance['thumbnail_mask'] 	= $new_instance['thumbnail_mask']; 
		$instance['thumbnail_mask_aspect'] 	= $new_instance['thumbnail_mask_aspect']; 
		$instance['thumbnail_background_color'] 	= $new_instance['thumbnail_background_color']; 
		$instance['thumbnail_background_padding'] 	= $new_instance['thumbnail_background_padding']; 
		$instance['thumbnail_border_radius'] 	= $new_instance['thumbnail_border_radius']; 
		$instance['thumbnail_border_color'] 	= $new_instance['thumbnail_border_color']; 
		$instance['thumbnail_hover_color'] 	= $new_instance['thumbnail_hover_color']; 
		$instance['thumbnail_hover_color_alpha'] 	= $new_instance['thumbnail_hover_color_alpha']; 
		$instance['thumbnail_hover_icon'] 	= $new_instance['thumbnail_hover_icon']; 
		$instance['thumbnail_icon_effect'] 	= $new_instance['thumbnail_icon_effect']; 
		
		$instance['thumbnail_hover_transition_time'] 	= $new_instance['thumbnail_hover_transition_time']; 
		return $instance;
	}

	function form( $instance ) {
		$instance 	= wp_parse_args( (array) $instance, array( 'thumbnail_border_color' => "#cccccc",
															   'thumbnail_background_color' => "#ffffff",
															   'thumbnail_hover_color' => "#336699",
															   'thumbnail_hover_color_alpha' => 0.5,
															   'thumbnail_hover_transition_time' => 0.5,
															   'thumbnail_icon_effect' => "spin",
															   'thumbnail_mask' => '',
															   'thumbnail_mask_aspect' => '',
															   'thumbnail_hover_icon' => '',
															   'flickr_id' => '',
															   'photoset_id' => '',
															   'vector_icon' => '',
															   'box_style' => '',
															   'target' => '',
															   'title' => 'Flickr Gallery', 'gallery_type' => 'photostream', 'thumbnail_type' => 'default', 'columns' => 3, 
															   'api_key' => '104a29a20b80a6cb865d78e9ce181d2b', 'max_images' => 10 ) );
		$title 		= format_to_edit($instance['title']);
		$api_key 	= $instance['api_key'];
		$flickr_id 	= $instance['flickr_id'];
		$photoset_id 	= $instance['photoset_id'];
		$rand = rand();
		
		$borderRadii   	= array("1px", "2px", "3px", "4px", "5px", "10px", "15px", "1%", "2%", "3%", "4%", "5%", "10%", "15%");
		$padding	 	= array("1px", "2px", "3px", "4px", "5px", "10px", "15px", "1%", "2%", "3%", "4%", "5%", "10%", "15%");
		//$justification = $instance['justification'];
?>
<div class='i3d-widget-container'>
    <div class='i3d-help-region'>
    <div class='i3d-help-region-closed'><div class='i3d-help-title-bar'><a target="_blank" href="http://www.youtube.com/watch?v=PbIcN7UeQ4s"><i class='icon-youtube-play'></i> Watch Help Video &nbsp;  <i  class='icon-external-link'></i></a></div></div>
    </div>
    <script>
	function setAlbumType<?php echo $rand; ?>(selectBox) {
	  if (selectBox.options[selectBox.selectedIndex].value == "photostream") {
		jQuery("#flickr_id_container_<?php echo $rand; ?>").css("display", "inline-block");  
		jQuery("#photoset_id_container_<?php echo $rand; ?>").css("display", "none");  
	  } else {
		jQuery("#flickr_id_container_<?php echo $rand; ?>").css("display", "none");  
		jQuery("#photoset_id_container_<?php echo $rand; ?>").css("display", "inline-block");  
		  
	  }
	}
	
	function setMaskOptions<?php echo $rand; ?>(selectBox) {
	  if (selectBox.options[selectBox.selectedIndex].value == "") {
		jQuery("#flickr-mask-options-<?php echo $rand; ?>").css("display", "none");  
	  } else {
		jQuery("#flickr-mask-options-<?php echo $rand; ?>").css("display", "inline-block");  
		  
	  }
	}	
	</script>
    <style>
	
	.flickr-widget<?php echo $rand; ?> .tooltip-inner {
		width: 420px;
		max-width: 420px;
	}
	
	.flickr-widget<?php echo $rand; ?> .tooltip-inner2 {
		width: 150px;
		max-width: 150px;

	}
	.flickr-widget-editor label { font-weight: bold; }
	.flickr-widget-editor .gallery-block-chooser { margin-top: 0px; display: inline-block;  vertical-align: top }
	.flickr-widget-editor .flickr-id-container,
	.flickr-widget-editor .photostream-id-container { margin-top: 0px; display: inline-block; width: 250px;}
	.flickr-widget-editor .flickr-editor-33 { display: inline-block; width: 31%; vertical-align: top; } 
	.flickr-widget-editor .flickr-editor-50 { display: inline-block; width: 48%; vertical-align: top; } 
	.flickr-widget-editor h3 { background-color: #eeeeee; line-height: 40px; padding-left: 10px; margin-bottom: 0px; }
	.colorpicker input { width: auto !important; } 
	</style>
<div class='i3d-widget-main-large flickr-widget<?php echo $rand; ?> flickr-widget-editor'>
  <h3>Basics</h3>
		<label  style='padding-top: 10px;' for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title',"i3d-framework"); ?></label><br/>
        <?php I3D_Framework::renderFontAwesomeSelect($this->get_field_name('vector_icon'), $instance['vector_icon']); ?>
        
		<input class="" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />

        <?php if (sizeof(I3D_Framework::$boxStyles) > 0) { ?>
        <label  class='label-100' for="<?php echo $this->get_field_id('box_style'); ?>"><?php _e('Box Style',"i3d-framework"); ?></label><br/>
		<select id="<?php echo $this->get_field_id('box_style'); ?>" name="<?php echo $this->get_field_name('box_style'); ?>">
        <?php foreach (I3D_Framework::$boxStyles as $className => $boxStyle) { ?>
          <option <?php if ($instance['box_style'] == $className) { print "selected"; } ?> value="<?php echo $className; ?>"><?php echo $boxStyle; ?></option>
        <?php } ?>
                </select> 
                
				<br/>
				<?php }  ?>
                


  	    <h3>Gallery</h3>
 		<label style='padding-top: 10px;' for="<?php echo $this->get_field_id('api_key'); ?>"><?php _e('Flickr API Key',"i3d-framework"); ?></label>      <br />  
		<input class="" id="<?php echo $this->get_field_id('api_key'); ?>" name="<?php echo $this->get_field_name('api_key'); ?>" type="text" value="<?php echo $api_key; ?>" />
        <a href='https://www.flickr.com/services/apps/create/apply' target='_blank'><i class='fa fa-flickr tt2' title='Get an API Key'></i></a>
        <br/>
        
         <div class='gallery-block-chooser'>
 		<label  for="<?php echo $this->get_field_id('gallery_type'); ?>"><?php _e('Gallery Type',"i3d-framework"); ?></label><br/>      
		<select  style='width: 135px;' onchange='setAlbumType<?php echo $rand; ?>(this)' id="<?php echo $this->get_field_id('gallery_type'); ?>" name="<?php echo $this->get_field_name('gallery_type'); ?>">
          <option <?php if ($instance['gallery_type'] == 'photostream') { print "selected"; } ?> value="photostream">Photostream</option>
          <option <?php if ($instance['gallery_type'] == 'photoset') { print "selected"; } ?> value="photoset">Album</option>
        </select>         
        </div>

  		<div class='flickr-id-container' id="flickr_id_container_<?php echo $rand; ?>" <?php if ($instance['gallery_type'] != "photostream") { print "style='display: none;'"; } ?>>
        <label for="<?php echo $this->get_field_id('flickr_id'); ?>"><?php _e('Flickr ID',"i3d-framework"); ?></label> <br/>       
		<input class="" id="<?php echo $this->get_field_id('flickr_id'); ?>" name="<?php echo $this->get_field_name('flickr_id'); ?>" type="text" value="<?php echo $flickr_id; ?>" />
        <a href='http://idgettr.com' target='_blank'><i class='fa fa-flickr tt2' title='Get your Flickr ID'></i></a></div>

  		<div class='photostream-id-container' id="photoset_id_container_<?php echo $rand; ?>" <?php if ($instance['gallery_type'] != "photoset") { print "style='display: none;'"; } ?>>
        <label for="<?php echo $this->get_field_id('photoset_id'); ?>"><?php _e('Album ID',"i3d-framework"); ?></label><br/>        
		<input class="" id="<?php echo $this->get_field_id('photoset_id'); ?>" name="<?php echo $this->get_field_name('photoset_id'); ?>" type="text" value="<?php echo $photoset_id; ?>" />
        <i class='fa fa-info-circle tt' title='This is usually the large number between the last two slashes in your album url.
        &lt;br/&gt; &lt;br/&gt;
        Example&lt;br/&gt; https://www.flickr.com/photos/126058266@N08/sets/&lt;b style="color: #66B7E3"&gt;72157645514185154&lt;/b&gt;/
        &lt;br/&gt;&lt;br/&gt;
        In this example, the album id would be: &lt;b style="color: #66B7E3"&gt;72157645514185154&lt;/b&gt;' ></i>
        </div>
        
        
        <h3>Images</h3>

 		<label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_type'); ?>"><?php _e('Thumbnail Type',"i3d-framework"); ?></label><br/>        
		<select id="<?php echo $this->get_field_id('thumbnail_type'); ?>" name="<?php echo $this->get_field_name('thumbnail_type'); ?>">
          <option <?php if ($instance['thumbnail_type'] == 'default') { print "selected"; } ?> value="default">Default (75x75)</option>
          <option <?php if ($instance['thumbnail_type'] == 'original-image') { print "selected"; } ?> value="original-image">Original</option>
        </select>         
        <br/>

 		<div class='flickr-editor-33'>
        <label for="<?php echo $this->get_field_id('max_images'); ?>"><?php _e('Max Images:',"i3d-framework"); ?></label>   <br/>     
		<input style='width: 100px;' id="<?php echo $this->get_field_id('max_images'); ?>" name="<?php echo $this->get_field_name('max_images'); ?>" type="number" value="<?php echo $instance['max_images']; ?>" />
        </div>
 		<div class='flickr-editor-33'><label for="<?php echo $this->get_field_id('columns'); ?>"><?php _e('Columns',"i3d-framework"); ?></label>  <br/>             
		<select style='width: 120px; padding: 4px; line-height: 30px; height: 30px;' id="<?php echo $this->get_field_id('columns'); ?>" name="<?php echo $this->get_field_name('columns'); ?>">
          <option <?php if ($instance['columns'] == 1) { print "selected"; } ?> value="1">1</option>
          <option <?php if ($instance['columns'] == 2) { print "selected"; } ?> value="2">2</option>
          <option <?php if ($instance['columns'] == 3) { print "selected"; } ?> value="3">3</option>
          <option <?php if ($instance['columns'] == 4) { print "selected"; } ?> value="4">4</option>
          <option <?php if ($instance['columns'] == 6) { print "selected"; } ?> value="6">6</option>
          <option <?php if ($instance['columns'] == 12) { print "selected"; } ?> value="12">12</option>
        </select>         
        </div>
        <div class='flickr-editor-33'><label for="<?php echo $this->get_field_id('target'); ?>"><?php _e('Open In',"i3d-framework"); ?></label>  <br/>      
		<select style='width: 120px; padding: 4px; line-height: 30px; height: 30px;' id="<?php echo $this->get_field_id('target'); ?>" name="<?php echo $this->get_field_name('target'); ?>">
          <option <?php if ($instance['target'] == '_blank') { print "selected"; } ?> value="_blank">New Window</option>
          <option <?php if ($instance['target'] == '_self') { print "selected"; } ?> value="_self">Same Window</option>
          <option <?php if ($instance['target'] == '') { print "selected"; } ?> value="">LightBox Viewer</option>
        </select>         
        </div>
        
        <h3>Image Display</h3>
        <div class='flickr-editor-50'>
 		<label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_mask'); ?>"><?php _e('Mask',"i3d-framework"); ?></label><br/>        
		<select onchange='setMaskOptions<?php echo $rand; ?>(this)' style='width: 98%' id="<?php echo $this->get_field_id('thumbnail_mask'); ?>" name="<?php echo $this->get_field_name('thumbnail_mask'); ?>">
          <option value="">None</option>
          <?php foreach (I3D_Framework::get_image_masks() as $mask_id => $mask) { ?>
          <option <?php if ($instance['thumbnail_mask'] == $mask_id) { print "selected"; } ?> value="<?php echo $mask_id; ?>"><?php echo $mask['name']; ?></option>
          <?php } ?>
        </select>         
        </div>
        <div class='flickr-editor-50' id='flickr-mask-options-<?php echo $rand; ?>' <?php if ($instance['thumbnail_mask'] == "") { echo "style='display: none;'"; }?>>
  		<label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_mask_aspect'); ?>"><?php _e('Aspect Ratio',"i3d-framework"); ?></label><br/>        
		<select  style='width: 98%' id="<?php echo $this->get_field_id('thumbnail_mask_aspect'); ?>" name="<?php echo $this->get_field_name('thumbnail_mask_aspect'); ?>">
          <option  <?php if ($instance['thumbnail_mask_aspect'] == "crop") { print "selected"; } ?> value="crop">Mask A/R  (Crop Image)</option>
          <option  <?php if ($instance['thumbnail_mask_aspect'] == "stretch") { print "selected"; } ?> value="stretch">Image A/R (Stretch Mask)</option>
          <option  <?php if ($instance['thumbnail_mask_aspect'] == "crop-shrink") { print "selected"; } ?> value="crop-shrink">Mask A/R Using Smallest Image (Crop/Shrink Image)</option>
        </select>         
       
        </div> 
  		<br/>
        <div class='flickr-editor-33'>
        <label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_background_color'); ?>"><?php _e('BG Color',"i3d-framework"); ?></label><br/>        
		<input style='width: 60px;' type='color' id="<?php echo $this->get_field_id('thumbnail_background_color'); ?>" name="<?php echo $this->get_field_name('thumbnail_background_color'); ?>" value="<?php echo $instance['thumbnail_background_color']; ?>">
  		</div>
                <div class='flickr-editor-33'>

         <label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_background_padding'); ?>"><?php _e('BG Padding',"i3d-framework"); ?></label><br/>
		<select style='width: 75px;' id="<?php echo $this->get_field_id('thumbnail_background_padding'); ?>" name="<?php echo $this->get_field_name('thumbnail_background_padding'); ?>">
          <option value="">None</option>
          <?php foreach ($padding as $pad) { ?>
          <option <?php if ($instance['thumbnail_background_padding'] == $pad) { print "selected"; } ?> value="<?php echo $pad; ?>"><?php echo $pad; ?></option>
          <?php } ?>
        </select>    
   		</div>
        
   		<div class='flickr-editor-33' style='display: none'>
        <label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_border_color'); ?>"><?php _e('Border Color',"i3d-framework"); ?></label><br/>        
		<input style='width: 60px;' type='color' id="<?php echo $this->get_field_id('thumbnail_border_color'); ?>" name="<?php echo $this->get_field_name('thumbnail_border_color'); ?>" value="<?php echo $instance['thumbnail_border_color']; ?>">
        </div>       
        
        <div class='flickr-editor-33'>
        <label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_border_radius'); ?>"><?php _e('Border Radius',"i3d-framework"); ?></label><br/>
		<select style='width: 75px;' id="<?php echo $this->get_field_id('thumbnail_border_radius'); ?>" name="<?php echo $this->get_field_name('thumbnail_border_radius'); ?>">
          <option value="">None</option>
          <?php foreach ($borderRadii as $radius) { ?>
          <option <?php if ($instance['thumbnail_border_radius'] == $radius) { print "selected"; } ?> value="<?php echo $radius; ?>"><?php echo $radius; ?></option>
          <?php } ?>
        </select>         
        </div>

        <br/>
        <div class='flickr-editor-33'>
        <label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_hover_color'); ?>"><?php _e('Hover Color',"i3d-framework"); ?></label><br/>        
		<input style='width: 60px;' type='color' id="<?php echo $this->get_field_id('thumbnail_hover_color'); ?>" name="<?php echo $this->get_field_name('thumbnail_hover_color'); ?>" value="<?php echo $instance['thumbnail_hover_color']; ?>">
  		</div>
        
        <div class='flickr-editor-33'>
        <label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_hover_color_alpha'); ?>"><?php _e('Hover Alpha',"i3d-framework"); ?></label><br/>
		<select style='width: 75px;' id="<?php echo $this->get_field_id('thumbnail_hover_color_alpha'); ?>" name="<?php echo $this->get_field_name('thumbnail_hover_color_alpha'); ?>">
          <option value="0">0%</option>
          <option <?php if ($instance['thumbnail_hover_color_alpha'] == ".10") { print "selected"; } ?> value=".10">10%</option>
          <option <?php if ($instance['thumbnail_hover_color_alpha'] == ".25") { print "selected"; } ?> value=".25">25%</option>
          <option <?php if ($instance['thumbnail_hover_color_alpha'] == ".50") { print "selected"; } ?> value=".5">50%</option>
          <option <?php if ($instance['thumbnail_hover_color_alpha'] == ".75") { print "selected"; } ?> value=".75">75%</option>
          <option <?php if ($instance['thumbnail_hover_color_alpha'] == ".90") { print "selected"; } ?> value=".90">90%</option>
          <option <?php if ($instance['thumbnail_hover_color_alpha'] == "1.0") { print "selected"; } ?> value="1.0">100%</option>
        </select>         
  		</div>
        <div class='flickr-editor-33'>
        <label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_hover_transition_time'); ?>"><?php _e('Effect Time',"i3d-framework"); ?></label><br/>
		<select style='width: 75px;' id="<?php echo $this->get_field_id('thumbnail_hover_transition_time'); ?>" name="<?php echo $this->get_field_name('thumbnail_hover_transition_time'); ?>">
          <option value=".25">.25 second</option>
          <option <?php if ($instance['thumbnail_hover_transition_time'] == ".5") { print "selected"; } ?> value=".5">.5s</option>
          <option <?php if ($instance['thumbnail_hover_transition_time'] == ".75") { print "selected"; } ?> value=".75">.75s</option>
          <option <?php if ($instance['thumbnail_hover_transition_time'] == "1") { print "selected"; } ?> value="1">1 second</option>
          <option <?php if ($instance['thumbnail_hover_transition_time'] == "1.25") { print "selected"; } ?> value="1.25">1.25s</option>
          <option <?php if ($instance['thumbnail_hover_transition_time'] == "1.5") { print "selected"; } ?> value="1.5">1.5s</option>
          <option <?php if ($instance['thumbnail_hover_transition_time'] == "1.75") { print "selected"; } ?> value="1.75">1.75s</option>
          <option <?php if ($instance['thumbnail_hover_transition_time'] == "2.0") { print "selected"; } ?> value="2">2s</option>
        </select>         
  		</div>

        <div class='flickr-editor-33'>
              <label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_hover_icon'); ?>"><?php _e('Hover Icon',"i3d-framework"); ?></label><br/>        
        <?php I3D_Framework::renderFontAwesomeSelect($this->get_field_name('thumbnail_hover_icon'), $instance['thumbnail_hover_icon'], false, '-- None --', '-- None -- '); ?>
  		</div>
        
        <div class='flickr-editor-33'>
        <label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_icon_effect'); ?>"><?php _e('Icon Effect',"i3d-framework"); ?></label><br/>
		<select style='width: 75px;' id="<?php echo $this->get_field_id('thumbnail_icon_effect'); ?>" name="<?php echo $this->get_field_name('thumbnail_icon_effect'); ?>">
          <option value="">None</option>
          <option <?php if ($instance['thumbnail_icon_effect'] == "spin") { print "selected"; } ?> value="spin">Spin</option>
        </select>         
  		</div>
  		<br/>


        
        </div>
        </div>
        <script>
		jQuery(document).ready(function() {
		jQuery(".flickr-widget<?php echo $rand; ?> .tt").tooltip({html: true});
		jQuery(".flickr-widget<?php echo $rand; ?> .tt2").tooltip({template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner tooltip-inner2"></div></div>'});
										});
		</script>
<?php
	}
}


?>