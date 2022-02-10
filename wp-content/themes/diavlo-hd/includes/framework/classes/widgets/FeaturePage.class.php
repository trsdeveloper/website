<?php

/***********************************/
/**        Featured Post  BOX        **/
/***********************************/
class Luckymarble_Widget_FeaturePage extends WP_Widget {
	function __construct() {
	//function Luckymarble_Widget_FeaturePage() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'Displays a box with an image and page title/description.', "i3d-framework") );
		parent::__construct('lm_infobox', __('*LM*Feature Page', "i3d-framework"), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );
		global $lmImageDefaults, $lmWidgetWrapConfig;
		$pageID = $instance['page'];
		$title = get_post_meta($pageID, 'luckymarble_page_title', true);
		$title_text = strip_tags($instance['title_text']);
		$description_text = strip_tags($instance['description_text']);
		$more_link_text = strip_tags($instance['more_link_text']);
		$selected_image = strip_tags($instance['page_image']);
		if (!array_key_exists("feature-page-box", $lmWidgetWrapConfig)) {
			$lmWidgetWrapConfig['feature-page-box']['format']  = '<a href="[imghref]">[img]</a><h3><a class="title-link" href="[titlehref]">[title]</a></h3><p>[description]</p>';
		}
		$widgetHTML = $lmWidgetWrapConfig['feature-page-box']['format'];
		echo $before_widget;
		//$pageData = get_page($pageID);
		echo "<div class='feature-page-box'>";
		
		// if ( get_post_meta($pageID, '_thumbnail_id', true) || strstr($title, "Feature Item")) { 
		      if ($selected_image == "") {
				  
			    $large_image_url = wp_get_attachment_image_src( get_post_meta($pageID, '_thumbnail_id', true));

				if ($large_image_url == "" && strstr($title, "Feature Item")) {
					$large_image_url[0] = get_option("siteurl")."/wp-content/themes/".get_template()."/Site/themed_images/portfolio-large-".str_replace("Feature Item ", "", $title).".jpg";
				} else if ($large_image_url == "" &&  strstr($title_text,"Example Title")) {
					$large_image_url[0] = get_option("siteurl")."/wp-content/themes/".get_template()."/Site/themed_images/portfolio-large-1.jpg";					
				}
				if ($large_image_url != "") {
				  if (strstr($large_image_url[0], "wp.com")) {
					 $url_data = parse_url($large_image_url[0]);
					 
					 $large_image_url[0] = str_replace($url_data['query'], "resize=".$lmImageDefaults["featured-page-thumbnail"]['width']."%2C".$lmImageDefaults["featured-page-thumbnail"]['height'], $large_image_url[0]); // for sites hosted on wp.com
					 $image = $large_image_url[0];
				  } else {
					  $large_image_url[0] = str_replace("/", "|", $large_image_url[0]);
				      $large_image_url[0] = str_replace("?resize=150%2C150", "", $large_image_url[0]); // for sites hosted on wp.com
					  
					  $image = get_option("siteurl")."/wp-content/themes/".get_option("template")."/includes/user_view/thumb.php?src=".urlencode(str_replace("-".$large_image_url[1]."x".$large_image_url[2], "", $large_image_url[0]))."&amp;w=".$lmImageDefaults["featured-page-thumbnail"]['width']."&amp;h=".$lmImageDefaults["featured-page-thumbnail"]['height']."&amp;zc=1&amp;q=90&amp;v=1";
				  }				
				}
			 } else {
				  $image = get_option("siteurl")."/wp-content/themes/".get_template()."/Site/themed_images/".$selected_image.".jpg";
			  }
			 $widgetHTML = str_replace("[imghref]",get_page_link($pageID), $widgetHTML);
			 $widgetHTML = str_replace("[titlehref]",get_page_link($pageID), $widgetHTML);
			 $img = "";
			  if ($image != "") {
				$img = '<img width="'.$lmImageDefaults["featured-page-thumbnail"]['width'].'" height="'.$lmImageDefaults["featured-page-thumbnail"]['height'].'" alt="" src="'.$image.'">';
			    
			  }
			 $widgetHTML = str_replace("[img]", $img, $widgetHTML);
	   
		if (!empty($title_text)) { 
		  $widgetHTML = str_replace("[title]", $title_text, $widgetHTML);
		  
		} else if ( !empty( $title ) ) { 
		  $widgetHTML = str_replace("[title]", $title, $widgetHTML);

		 }
  		  $widgetHTML = str_replace("[title]", "", $widgetHTML);
       
			 
			if (!empty($description_text)) {
				$description = $description_text;
			} else {
				$description = get_post_meta($pageID, 'luckymarble_page_description', true)."&nbsp;";

			
			}
			
		

							$more_link_text = $instance['more_link_text'];
		if ($more_link_text != "") {
			$description .= '<a class="more-link" href="'.get_page_link($pageID).'" title="'.$title.'">'.$more_link_text.'</a>';
		}
					  		$widgetHTML = str_replace("[description]", $description, $widgetHTML);
		echo $widgetHTML;
			?>
      </div>
		<?php


		
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['page'] = $new_instance['page'];
		$instance['title_text'] = $new_instance['title_text'];
		$instance['description_text'] = $new_instance['description_text'];
		$instance['more_link_text'] = $new_instance['more_link_text'];
		$instance['page_image'] = $new_instance['page_image'];
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'page' => '' ) );
		$pageID = strip_tags($instance['page']);
		$title_text = strip_tags($instance['title_text']);
		$description_text = strip_tags($instance['description_text']);
		$more_link_text = strip_tags($instance['more_link_text']);
		$selected_image = strip_tags($instance['page_image']);
		$random = rand();
?>
	<script type="text/javascript">
	jQuery(function(){
		jQuery('#featured-page-widget-<?php echo $random; ?>').tabs();
	});
	</script>
    <style>
div.featured-page-widget-container h2 { margin-top: 0px !important; padding-top: 0px !important; }
div.featured-page-widget-container th { padding: 4px 15px !important;  width: 100px; }
div.featured-page-widget-container td { padding: 3px 4px !important; }
div.featured-page-widget-container h3 { margin-top: 0px !important; padding-top: 0px !important; margin-bottom: 0px !important; padding-bottom: 0px !important; }

.ui-helper-hidden { display: none; }
.ui-helper-hidden-accessible { position: absolute; left: -99999999px; }
.ui-helper-reset { margin: 0; padding: 0; border: 0; outline: 0; line-height: 1.3; text-decoration: none; font-size: 100%; list-style: none; }
.ui-helper-clearfix:after { content: "."; display: block; height: 0; clear: both; visibility: hidden; }
.ui-helper-clearfix { display: inline-block; }
/* required comment for clearfix to work in Opera \*/
* html .ui-helper-clearfix { height:1%; }
.ui-helper-clearfix { display:block; }
/* end clearfix */

.ui-widget-content { border: 0px solid #ccc; background: ; color: #333333; }
.ui-widget-content h3 { font-size: 12pt; }
.ui-widget-content a { color: #333333; }
.ui-widget-header { border: 0px; border-bottom: 1px solid #cccccc; background: repeat-x; color: #ffffff; font-weight: bold; }
.ui-widget-header a { color: #ffffff; }


.ui-state-default, .ui-widget-content .ui-state-default,  .ui-widget-header .ui-state-default {
	border: 1px solid #cccccc; 
	background: #ddd; 
	font-weight: bold; 
	color: #666666; 
    background-repeat: repeat-x;
}

.rounded-box {
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
}


.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited { color: #666666; text-decoration: none; }
.ui-state-hover, .ui-widget-content .ui-state-hover, .ui-widget-header .ui-state-hover, .ui-state-focus, .ui-widget-content .ui-state-focus, .ui-widget-header .ui-state-focus { border: 1px solid #cccccc; background: #eeeeee; font-weight: bold; color: #3473D1; }
.ui-state-hover a, .ui-state-hover a:hover { color: #666666; text-decoration: none; }
.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active
{ border: 1px solid #333;
  font-weight: bold; color: #000000; 
  background-color: #666 !important;
}
.ui-state-active a, .ui-state-active a:link, .ui-state-active a:visited { color: #fff; text-decoration: none; }

.ui-state-active, .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default {
	-webkit-border-top-left-radius: 3px;
  -webkit-border-top-right-radius: 3px;
  -moz-border-radius-topleft:3px;
  -moz-border-radius-topright: 3px;
  border-top-left-radius: 3px;
  border-top-right-radius: 3px;
}

.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited { color: #666666; text-decoration: none; }
.ui-state-hover, .ui-widget-content .ui-state-hover, .ui-widget-header .ui-state-hover, .ui-state-focus, .ui-widget-content .ui-state-focus, .ui-widget-header .ui-state-focus { border: 1px solid #cccccc; background: #eeeeee; font-weight: bold; color: #3473D1; }
.ui-state-hover a, .ui-state-hover a:hover { color: #666666; text-decoration: none; }
.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active
{ border: 1px solid #333333;
font-weight: bold; color: #000000; }
.ui-state-active a, .ui-state-active a:link, .ui-state-active a:visited { color: #ffffff; text-decoration: none; }
 div.featured-page-widget-container .ui-state-active, div.featured-page-widget-container .ui-state-default, div.featured-page-widget-container .ui-widget-content .ui-state-default, div.featured-page-widget-container .ui-widget-header .ui-state-default {
	-webkit-border-top-left-radius: 3px;
  -webkit-border-top-right-radius: 3px;
  -moz-border-radius-topleft:3px;
  -moz-border-radius-topright: 3px;
  border-top-left-radius: 3px;
  border-top-right-radius: 3px;
}

.ui-widget :active { outline: none; }

.ui-tabs { position: relative; padding: .2em; zoom: 1; } /* position: relative prevents IE scroll bug (element with position: relative inside container with overflow: auto appear as "fixed") */
.ui-tabs .ui-tabs-nav { margin: 0; padding: .2em .2em 0; }

.ui-tabs .ui-tabs-nav li { list-style: none; float: left; position: relative; top: 1px; margin: 0 .2em 1px 0; border-bottom: 0 !important; padding: 0; white-space: nowrap; }
.ui-tabs .ui-tabs-nav li.instruction-tabs { list-style: none; float: left; position: relative; top: 0px; margin: 0 0em 0px 0; border-bottom: 0 !important; padding: 0; white-space: nowrap; }
.ui-tabs .ui-tabs-nav li.instruction-wp-tabs { list-style: none; float: left; position: relative; top: 0px; margin: 0 0em 0px 0; border-bottom: 0 !important; padding: 0; white-space: nowrap; }
.ui-tabs .ui-tabs-nav li a { float: left; padding: .3em .8em; text-decoration: none; }
.ui-tabs .ui-tabs-nav li a.instruction-tabs { padding: .5em 2em .5em !important; font-size: 8pt !important;}
.ui-tabs .ui-tabs-nav li a.instruction-wp-tabs { padding: .5em 2em .5em !important;  font-size: 8pt !important;}

.ui-tabs .ui-tabs-nav li.ui-tabs-selected { margin-bottom: 0; padding-bottom: 0px; background-color: #333333;}
.ui-tabs .ui-tabs-nav li.ui-tabs-selected a, .ui-tabs .ui-tabs-nav li.ui-state-disabled a, .ui-tabs .ui-tabs-nav li.ui-state-processing a { cursor: pointer; }
.ui-tabs .ui-tabs-nav li a, .ui-tabs.ui-tabs-collapsible .ui-tabs-nav li.ui-tabs-selected a { cursor: pointer; } /* first selector in group seems obsolete, but required to overcome bug in Opera applying cursor: text overall if defined elsewhere... */
.ui-tabs .ui-tabs-panel { display: block; border-width: 0; padding: 0em 0em; background: none; }
.ui-tabs .ui-tabs-hide { display: none !important; }
div.featured-page-widget-container div {
	margin-top: 10px;
}
.featured-page-widget-image-placeholder { width: 200px; margin: auto; border: 1px solid #cccccc; background-color: #ffffff; padding: 10px; padding-bottom: 7px;}
.featured-page-widget-image-placeholder img { width: 100%; }
</style>	

	
    <div class='featured-page-widget-container' id="featured-page-widget-<?php echo $random; ?>">
      <ul>
        <li><a href="#featured-page-widget-<?php echo $random; ?>-linkage">Linkage</a></li>
        <li><a href="#featured-page-widget-<?php echo $random; ?>-text">Text</a></li>
        <li><a href="#featured-page-widget-<?php echo $random;?>-image">Image</a></li>
      </ul>
      <div id="featured-page-widget-<?php echo $random; ?>-linkage">
		<p><label style='font-weight: bold' for="<?php echo $this->get_field_id('page'); ?>"><?php _e('Page:',"i3d-framework"); ?></label>
    
		<select onchange='setPlaceholderImage<?php echo $random; ?>(this.form["<?php echo $this->get_field_name('page_image'); ?>"], "featured-page-widget-<?php echo $random; ?>-image-placeholder")' class="widefat" id="<?php echo $this->get_field_id('page'); ?>" name="<?php echo $this->get_field_name('page'); ?>">
    <?php
		$pages = get_pages();
		$selectedImages = array();
foreach ($pages as $pagg) {
  	$option = '<option ';
		if ($pagg->ID == $pageID) { 
		  $option .= 'selected ';
		}
		$featuredImageURL = wp_get_attachment_image_src( get_post_meta($pagg->ID, '_thumbnail_id', true), 'medium');
		$selectedImages["{$pagg->ID}"] = $featuredImageURL;
		$option .= 'value="'.$pagg->ID.'">';
	$option .= $pagg->post_title;
	$option .= '</option>';
	echo $option;
  }
 ?>
    </select></p>      
      
      </div>
      <div id="featured-page-widget-<?php echo $random; ?>-text">
    <p><label style='font-weight: bold' for="<?php echo $this->get_field_id('title_text'); ?>"><?php _e('Title Text',"i3d-framework"); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title_text'); ?>" name="<?php echo $this->get_field_name('title_text'); ?>" type="text" value="<?php echo $title_text; ?>" /></p>

    <p><label style='font-weight: bold' for="<?php echo $this->get_field_id('description_text'); ?>"><?php _e('Description Text:',"i3d-framework"); ?></label>
		<textarea class="widefat" id="<?php echo $this->get_field_id('description_text'); ?>" name="<?php echo $this->get_field_name('description_text'); ?>"><?php echo $description_text; ?></textarea></p>
    
        
    <p><label style='font-weight: bold' for="<?php echo $this->get_field_id('more_link_text'); ?>"><?php _e('"Read More" link text:',"i3d-framework"); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('more_link_text'); ?>" name="<?php echo $this->get_field_name('more_link_text'); ?>" type="text" value="<?php echo $more_link_text; ?>" /></p>
      
      </div>
      <div id="featured-page-widget-<?php echo $random; ?>-image">
 <p>
    
		<select onchange='setPlaceholderImage<?php echo $random; ?>(this, "featured-page-widget-<?php echo $random; ?>-image-placeholder")' class="widefat" id="<?php echo $this->get_field_id('page_image'); ?>" name="<?php echo $this->get_field_name('page_image'); ?>">
          <option value="">-- Use Page's Featured Image --</option>
          <option <?php if ($selected_image == "info_left") { print "selected"; } ?> value="info_left">Themed Image 1</option>
          <option <?php if ($selected_image == "info_center") { print "selected"; } ?> value="info_center">Themed Image 2</option>
          <option <?php if ($selected_image == "info_right") { print "selected"; } ?> value="info_right">Themed Image 3</option>
        </select>
<div class='featured-page-widget-image-placeholder' id="featured-page-widget-<?php echo $random; ?>-image-placeholder"><?php if ($selected_image == "") { 
if ($selectedImages["{$pageID}"][0] == "") {
?>No featured image is yet set up for this page.<br/>To set an image, please:<ol><li>Go to Pages</li><li>Edit 'your page'</li><li>Click on the 'set featured image' on the right configuration bar</li><li>Select/Uplaod your image</li><li>Click 'use as featured image' near bottom of dialog box</li><li>Click the 'Update' button to save your page</il></ul><?php } else {
?><img src='<?php print $selectedImages["{$pageID}"][0]; ?>' /><?php 
}
} else {
?><img src='<?php get_template_directory_uri(); ?>/Site/themed_images/<?php echo $selected_image; ?>.jpg' /><?php } ?></div>
</p>  
        <script>
		</script>
         
      </div>
    </div>
    


<script type="text/javascript">
function setPlaceholderImage<?php echo $random; ?>(selectBox, targetBlock) {
  var selectedImage = selectBox.options[selectBox.selectedIndex].value;
 // alert(selectedImage);
 
  
  if (selectedImage == "") {
    var selectedPage = selectBox.form['<?php echo $this->get_field_name('page'); ?>'].options[selectBox.form['<?php echo $this->get_field_name('page'); ?>'].selectedIndex].value;
	var featuredPageURL = '';
	<?php foreach ($selectedImages as $pageID => $featuredURL) { ?>
	if (selectedPage == <?php echo $pageID; ?>) {
		var featuredPageURL = '<?php echo $featuredURL[0]; ?>'; 
	}
	<?php } ?>
	if (featuredPageURL == "") {
		var html = "No featured image is yet set up for this page.<br/>To set an image, please:<ol><li>Go to Pages</li><li>Edit 'your page'</li><li>Click on the 'set featured image' on the right configuration bar</li><li>Select/Uplaod your image</li><li>Click 'use as featured image' near bottom of dialog box</li><li>Click the 'Update' button to save your page</il></ul>";
	} else {
		var html = "<img src='" + featuredPageURL + "' />";
	}
	
	

  } else {
	var html = "<img src='<?php get_template_directory_uri(); ?>/Site/themed_images/" + selectedImage + ".jpg' />"; 
  }
  jQuery("#" + targetBlock).html(html);	
}



</script>
<?php
	}
}
?>