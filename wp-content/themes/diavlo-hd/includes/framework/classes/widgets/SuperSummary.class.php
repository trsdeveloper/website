<?php

/***********************************/
/**        RecentPosts       **/
/***********************************/
class I3D_Widget_SuperSummary extends WP_Widget {
	var $widget_options;
	
	function __construct($id = "") {
	//function I3D_Widget_SuperSummary($id = "") {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'A component that a provides a choice of different summary components', "i3d-framework") );
		$this->widget_options = $widget_ops;
		
			$id = "i3d_recent_posts";
				$control_ops = array('width' => "400px");

		parent::__construct($id, __('i3d:Blog Super Summary', "i3d-framework"), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		global $lmImageDefaults, $more, $pageColumns;
		global $lmPortfolioConfig;
		$more = false;
		$canDoLarge = false;
		$cache = wp_cache_get('widget_lm_super_summary', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( isset($cache[$args['widget_id']]) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract($args);
		$before_widget = str_replace("i3d-opt-box-style", @$instance['box_style'], $before_widget);

    $section_style = $instance['section_style'];
    $selected_category = $instance['category'];
		
		$title = apply_filters('widget_title', empty($instance['title']) ? __('', "i3d-framework") : $instance['title'], $instance, $this->id_base);
		
		if ( !$number = (int) $instance['number'] ) {
			$number = 10;
	  } else if ( $number < 1 ) {
			$number = 1;
	  } else if ( $number > 15 ) {
			$number = 15;
	  }
		
		$elipse_style = $instance['elipse_style'];
		$image_align = $instance['image_align'];
		
		$more_link_text = $instance['more_link_text'];
		$thumbnail_size = $instance['thumbnail_size'];
		$thumbnail_padding = $instance['thumbnail_padding'];

		
		if ( !$wordwrap = (int) $instance['wordwrap'] ) {
			if ($wordwrap == "0") {
			} else {
			$wordwrap = 225;
			}
		}
		$args = array('showposts' => $number, 'nopaging' => 0, 'post_status' => 'publish', 'ignore_sticky_posts' => 1);
		if ($selected_category != "") {
			$args['cat'] = $selected_category;
		}
		$r = new WP_Query($args);
		if ($r->have_posts()) :
			$postCount = 0;
		  if ($r->post_count % 2 == 1 && $number % 2 == 1 && $section_style == "news") {
				$canDoLarge = true;
			}
			
			$exampleCount = 1;

?>
		<?php echo $before_widget; ?>
        <?php //print "[".$title."]"; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<div class='lm-super-summary lm-super-summary__<?php print $section_style; ?>'>
		<?php  while ($r->have_posts()) : $r->the_post(); 
						$more_link_text = $instance['more_link_text'];

		if ($more_link_text != "") {
		  $more_link_text = '<a class="more-link" href="'.get_permalink().'" title="'.esc_attr(get_the_title() ? get_the_title() : get_the_ID()).'">'.$more_link_text.'</a>';
		}

		?>
		<div class='lm-super-summary-item<?php if (@$canDoLarge && $postCount == 0) { print "-large"; } ?>'>
    <?php 
		  $isExamplePost = (stristr(get_the_title(), "Hello world") || stristr( get_the_title(), "Example Post") || stristr( get_the_title(), "Example Feature Post")) && $exampleCount <= 8;
		  if (has_post_thumbnail() || $isExamplePost) { 
			  $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id());
				if ($large_image_url == "") {
					$large_image_url[0] = get_option("siteurl")."/wp-content/themes/".get_template()."/Site/themed-images/placeholders/".$lmImageDefaults['placeholder']['width']."x".$lmImageDefaults['placeholder']['height']."/holder".($exampleCount++)."-".$lmImageDefaults['placeholder']['width']."x".$lmImageDefaults['placeholder']['height'].".jpg";
				}
				$large_image_url[0] = str_replace("/", "|", $large_image_url[0]);
				$large_image_url[0] = str_replace("?resize=150%2C150", "", $large_image_url[0]);
				
				if ($large_image_url[1] != "") {
					
				  $originalImageDimensions = "-".$large_image_url[1]."x".$large_image_url[2];
				}

				//print $originalImageDimensions;
				//print $large_image_url[0];
				if ($canDoLarge && $postCount == 0) { 
				  $imgWidth = $lmImageDefaults['news-featured-'.$pageColumns]['width']; 
				  $imgHeight = $lmImageDefaults['news-featured-'.$pageColumns]['height']; 
				  $thumbnailInlineStyling = "margin-right: 0;";
				  
				} else { 
				  $imgWidth = $lmImageDefaults["{$section_style}-{$thumbnail_size}"]['width']; 
				  $imgHeight = $lmImageDefaults["{$section_style}-{$thumbnail_size}"]['height']; 
				  $thumbnailInlineStyling = "float: {$image_align};";
				}				
 				$thumbnailInlineStyling .= " padding: {$thumbnail_padding}px;";
				?> 


				<img style="<?php echo $thumbnailInlineStyling; ?>" width="<?php echo $imgWidth; ?>" 
                   height="<?php echo $imgHeight; ?>" 
                   alt="" 
                   src="<?php echo get_template_directory_uri(); ?>/includes/user_view/thumb.php?src=<?php echo urlencode(str_replace($originalImageDimensions, "", $large_image_url[0]));?>&amp;w=<?php echo $imgWidth; ?>&amp;h=<?php echo $imgHeight; ?>&amp;zc=1&amp;q=90&amp;v=1">
		<?php } else if (has_post_format("image")) {
										
					$matches = array();
					$imageURL = "";
					$theContent = get_the_content();
					preg_match('/(<img(.*?)\/>)/', $theContent, $matches);
					if (sizeof($matches) > 0) {
						preg_match('/src=[\'"](.*?)[\'"]/', $matches[1], $srcMatches);
						$imageURL = $srcMatches[1];
					}
					if ($imageURL != "") {
							  $attachmentID = i3d_get_attachment_id_from_url($imageURL);
							  
					if ($canDoLarge && $postCount == 0) { 
				  $imgWidth = $lmImageDefaults['news-featured-'.$pageColumns]['width']; 
				  $imgHeight = $lmImageDefaults['news-featured-'.$pageColumns]['height']; 
				  $thumbnailInlineStyling = "margin-right: 0;";
				  $thumbnailInlineStyling .= "width: {$imgWidth}; height: {$imgHeight};";
				  
				} else { 
				  $imgWidth = $lmImageDefaults["{$section_style}-{$thumbnail_size}"]['width']; 
				  $imgHeight = $lmImageDefaults["{$section_style}-{$thumbnail_size}"]['height']; 
				  $thumbnailInlineStyling = "float: {$image_align};";
				  $thumbnailInlineStyling .= "width: {$imgWidth}px !important; height: {$imgHeight}px !important;";
				}				
 				$thumbnailInlineStyling .= " padding: {$thumbnail_padding}px;";
				
				echo wp_get_attachment_image( $attachmentID, "full", "", array('style' => $thumbnailInlineStyling) );

				
					}
		}  else if (has_post_format("gallery")) {
										
		$matches = array();
		$theContent = get_the_content();
		//print $theContent;
		$pattern = '/\[gallery(([\s]?(columns)="(.*?)")|([\s]?(link)="(.*?)")|([\s]?(ids)="(.*?)")|([\s]?(orderby)="(.*?)"))*\]/';
		preg_match($pattern, $theContent, $matches);
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
		$attachmentID = $galleryIDs[0];
							  
					if ($canDoLarge && $postCount == 0) { 
				  $imgWidth = $lmImageDefaults['news-featured-'.$pageColumns]['width']; 
				  $imgHeight = $lmImageDefaults['news-featured-'.$pageColumns]['height']; 
				  $thumbnailInlineStyling = "margin-right: 0;";
				  $thumbnailInlineStyling .= "width: {$imgWidth}; height: {$imgHeight};";
				  
				} else { 
				  $imgWidth = $lmImageDefaults["{$section_style}-{$thumbnail_size}"]['width']; 
				  $imgHeight = $lmImageDefaults["{$section_style}-{$thumbnail_size}"]['height']; 
				  $thumbnailInlineStyling = "float: {$image_align};";
				  $thumbnailInlineStyling .= "width: {$imgWidth}px !important; height: {$imgHeight}px !important;";
				}				
 				$thumbnailInlineStyling .= " padding: {$thumbnail_padding}px;";
				
				echo wp_get_attachment_image( $attachmentID, "full", "", array('style' => $thumbnailInlineStyling) );

				
					}
		
										 
										 ?>
    <h4><a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a></h4>
		<div class="post-meta"><span class='date-time'><?php the_time(get_option('date_format')); ?></span><span class='author'> <?php _e("by","i3d-framework"); ?> <?php the_author() ?></span><span class='categories'> <?php _e("in","i3d-framework"); ?> <?php the_category(', '); ?></span></div>
	  <?php 
		$content = strip_tags(apply_filters('the_content', get_the_content(''))); 
		//print "[start]".$content."[finish]";
		$newContent = explode("\n", wordwrap($content, $wordwrap));
		//print preg_replace($pattern, $replace, $content);
		//print $wordwrap;
		if ($wordwrap == 0) {
			
		} else if (strlen($content) <= $wordwrap) {
			print $content;
		} else {
		  print balanceTags($newContent[0]." ".$elipse_style." ".$more_link_text, true);
		}

		?>
    </div>
    <?php //if (($canDoLarge && $postCount > 1 && $postCount % 2 == 0) || ($section_Style == "news" && $postCount % 2 == 1)) { print "<br style='clear: both;' />"; } ?>
		<?php 
		  $postCount++;
		endwhile; ?>
		</div>
		<?php echo $after_widget; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;
		//$cache[$args['widget_id']] = ob_get_flush();
		//wp_cache_set('widget_lm_super_summary', $cache, 'widget');	
	}


	function _flush_widget_cache() {
		wp_cache_delete('widget_lm_super_summary', 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title']          = strip_tags($new_instance['title']);
		$instance['number']         = (int) $new_instance['number'];
		$instance['more_link_text'] = strip_tags($new_instance['more_link_text']);
		$instance['image_align']    = strip_tags($new_instance['image_align']);
		$instance['section_style']  = strip_tags($new_instance['section_style']);
		$instance['elipse_style']   = strip_tags($new_instance['elipse_style']);
		$instance['category']  		= strip_tags($new_instance['category']);
		$instance['wordwrap']       = (int) $new_instance['wordwrap'];
		$instance['thumbnail_size']       = $new_instance['thumbnail_size'];
		$instance['thumbnail_padding']       = $new_instance['thumbnail_padding'];
		$instance['box_style']       = $new_instance['box_style'];
		$this->_flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_lm_super_summary']) )
			delete_option('widget_lm_super_summary');

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '', 'thumbnail_size' => "medium" ) );
		$title          = strip_tags($instance['title']);
		if ( !isset($instance['section_style']) )   { $section_style = "posts"; } else { $section_style = $instance['section_style']; }
		if ( !isset($instance['image_align']) )     { $image_align = "left";    } else { $image_align   = $instance['image_align']; }
		if ( !isset($instance['elipse_style']) )    { $elipse_style = "";       } else { $elipse_style   = strip_tags($instance['elipse_style']); }
		if ( !isset($instance['number']) ||
				 !$number = (int) $instance['number'] ) { $number = 5; }
		if ( !isset($instance['wordwrap']) || 
				!$wordwrap = (int) $instance['wordwrap'] ) { 
		  if (@$wordwrap != "0") {
		$wordwrap = 225; 
		  }}
		
		$thumbnailSize = @$instance['thumbnail_size'];
		$thumbnailPadding = @$instance['thumbnail_padding'];
		
		$more_link_text = strip_tags(@$instance['more_link_text']);
		$selected_category = strip_tags(@$instance['category']);
				$random = rand();

?>

    <style>

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
.ui-widget-header { border: 0px; border-bottom: 1px solid #cccccc; background: repeat-x; background-color: none; color: #ffffff; font-weight: bold; }
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
{ border: 1px solid #333333;
font-weight: bold; color: #000000;
  background-color: #666 !important;
}
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
div.super-summary-widget-container div {
	margin-top: 10px;
}
</style>	
<script>


 

</script>
<div class='i3d-widget-container'>
    <div class='i3d-help-region'>
    <div class='i3d-help-region-closed'><div class='i3d-help-title-bar'><a target="_blank" href="http://www.youtube.com/watch?v=NkZI5tbnh7E"><i class='icon-youtube-play'></i> Watch Help Video &nbsp;  <i  class='icon-external-link'></i></a></div></div>
   <!-- <div class='i3d-help-region-opened i3d-help-region-hidden'>
    <div class='i3d-help-title-bar'>Hide <i class='icon-chevron-right'></i></div>
<iframe width="420" height="315" src="//www.youtube.com/embed/NkZI5tbnh7E" frameborder="0" allowfullscreen></iframe>
    </div>-->
    </div>
<div class='i3d-widget-main-large'>

    <div class='super-summary-widget-container super-summary-widget-<?php echo $random; ?>' id="super-summary-widget-<?php echo $random; ?>">
      <ul>
        <li><a href="#super-summary-widget-<?php echo $random; ?>-display">Display</a></li>
        <li><a href="#super-summary-widget-<?php echo $random; ?>-content">Content</a></li>
      </ul>
      <div id="super-summary-widget-<?php echo $random; ?>-display">			

 		<p><label style='font-weight: bold' for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title',"i3d-framework"); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<p><label class='label-135'  for="<?php echo $this->get_field_id('section_style'); ?>"><?php _e('Display Style:',"i3d-framework"); ?></label>
		<select  id="<?php echo $this->get_field_id('section_style'); ?>" name="<?php echo $this->get_field_name('section_style'); ?>">
      <option <?php if ($section_style == "posts") { print "selected"; } ?> value="posts"><?php _e('Recent Posts',"i3d-framework"); ?></option>
      <option <?php if ($section_style == "news") { print "selected"; } ?> value="news"><?php _e('Latest News',"i3d-framework"); ?></option>
<!--      <option <?php if ($section_style == "popular") { print "selected"; } ?> value="popular"><?php _e('Most Popular',"i3d-framework"); ?></option>
      <option <?php if ($section_style == "comments") { print "selected"; } ?> value="comments"><?php _e('Recent Comments',"i3d-framework"); ?></option>-->
    </select></p>


    <p><label  class='label-135'  for="<?php echo $this->get_field_id('thumbnail_size'); ?>"><?php _e('Thumbnail Size:',"i3d-framework"); ?></label>
		<select id="<?php echo $this->get_field_id('thumbnail_size'); ?>" name="<?php echo $this->get_field_name('thumbnail_size'); ?>">
      <option <?php if ($thumbnailSize == "small") { print "selected"; } ?> value="small"><?php _e('Small',"i3d-framework"); ?></option>
      <option <?php if ($thumbnailSize == "medium") { print "selected"; } ?> value="medium"><?php _e('Medium',"i3d-framework"); ?></option>
      <option <?php if ($thumbnailSize == "large") { print "selected"; } ?> value="large"><?php _e('Large',"i3d-framework"); ?></option>
    </select></p>		

    <p><label class='label-135' for="<?php echo $this->get_field_id('thumbnail_padding'); ?>"><?php _e('Thumbnail Padding:',"i3d-framework"); ?></label>
		<select  id="<?php echo $this->get_field_id('thumbnail_padding'); ?>" name="<?php echo $this->get_field_name('thumbnail_padding'); ?>">
      <option <?php if ($thumbnailPadding == "0") { print "selected"; } ?> value="0"><?php _e('None',"i3d-framework"); ?></option>
      <option <?php if ($thumbnailPadding == "1") { print "selected"; } ?> value="1"><?php _e('1px',"i3d-framework"); ?></option>
      <option <?php if ($thumbnailPadding == "2") { print "selected"; } ?> value="2"><?php _e('2px',"i3d-framework"); ?></option>
      <option <?php if ($thumbnailPadding == "3") { print "selected"; } ?> value="3"><?php _e('3px',"i3d-framework"); ?></option>
      <option <?php if ($thumbnailPadding == "4") { print "selected"; } ?> value="4"><?php _e('4px',"i3d-framework"); ?></option>
      <option <?php if ($thumbnailPadding == "5") { print "selected"; } ?> value="5"><?php _e('5px',"i3d-framework"); ?></option>
      <option <?php if ($thumbnailPadding == "7") { print "selected"; } ?> value="7"><?php _e('7px',"i3d-framework"); ?></option>
      <option <?php if ($thumbnailPadding == "10") { print "selected"; } ?> value="10"><?php _e('10px',"i3d-framework"); ?></option>
    </select></p>		

    
    <p><label class='label-135'  for="<?php echo $this->get_field_id('image_align'); ?>"><?php _e('Thumbnail Align:',"i3d-framework"); ?></label>
		<select id="<?php echo $this->get_field_id('image_align'); ?>" name="<?php echo $this->get_field_name('image_align'); ?>">
      <option <?php if ($image_align == "left") { print "selected"; } ?> value="left"><?php _e('Left',"i3d-framework"); ?></option>
      <option <?php if ($image_align == "right") { print "selected"; } ?> value="right"><?php _e('Right',"i3d-framework"); ?></option>
    </select></p>
    
    <div class='widget-column-50'>
	<label  class='label-regular'  for="<?php echo $this->get_field_id('more_label'); ?>"><?php _e('"Read More" link text:',"i3d-framework"); ?></label>
		<input class='input-small' id="<?php echo $this->get_field_id('more_link_text'); ?>" name="<?php echo $this->get_field_name('more_link_text'); ?>" type="text" value="<?php echo $more_link_text; ?>" /></p>
</div>
	<div class='widget-column-50'>
	<label  class='label-regular'  for="<?php echo $this->get_field_id('number'); ?>"><?php _e('# of Items to Show:',"i3d-framework"); ?></label>
		<input class='input-mini'  id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
	</div>	
    <div class='widget-column-50'>
	<label class='label-regular' for="<?php echo $this->get_field_id('wordwrap'); ?>"><?php _e('Max Characters',"i3d-framework"); ?></label>
		<input class='input-mini'  id="<?php echo $this->get_field_id('wordwrap'); ?>" name="<?php echo $this->get_field_name('wordwrap'); ?>" type="text" value="<?php echo $wordwrap; ?>" size="3" /></p>
	</div>
    <div class='widget-column-50'>
	<label class='label-regular' for="<?php echo $this->get_field_id('elipse_style'); ?>"><?php _e('Elipse Style',"i3d-framework"); ?></label>
		<input class='input-mini'  id="<?php echo $this->get_field_id('elipse_style'); ?>" name="<?php echo $this->get_field_name('elipse_style'); ?>" type="text" value="<?php echo $elipse_style; ?>" /></p>
	</div>
	<?php if (sizeof(I3D_Framework::$boxStyles) > 0) { ?>
	<div class='widget-column-50'>
	<label class='label-regular' for="<?php echo $this->get_field_id('box_style'); ?>"><?php _e('Box Style',"i3d-framework"); ?></label>
	<select style='width: 100%' id="<?php echo $this->get_field_id('box_style'); ?>" name="<?php echo $this->get_field_name('box_style'); ?>">
	<?php foreach (I3D_Framework::$boxStyles as $className => $boxStyle) { ?>
	  <option <?php if (@$instance['box_style'] == $className) { print "selected"; } ?> value="<?php echo $className; ?>"><?php echo $boxStyle; ?></option>
	<?php } ?>
			</select> 
			</div>
	<?php }  ?>
      
</div>
      <div id="super-summary-widget-<?php echo $random; ?>-content">
          <p><label style='font-weight: bold' for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category:',"i3d-framework"); ?></label>
          		<select class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">
                <option value="">-- All Posts --</option>

<?php
$categories = get_categories();
foreach ($categories as $category) { ?>
<option <?php if ($category->cat_ID == $selected_category) { print "selected"; } ?> value="<?php echo $category->cat_ID; ?>"><?php echo $category->name; ?></option>
<?php } ?>
			</select>
</p>

</div>
</div>
</div>
</div>
	<script type="text/javascript">
	jQuery(function(){
		jQuery('.super-summary-widget-<?php echo $random; ?>').tabs();
	});
	</script>
<?php
	}
}
?>