<?php 
if (!I3D_Framework::use_global_layout()) { 
?>
<div class='tab-pane fade special-region non-visible blog' id="tabs-blog-layout">

<?php
global $post, $columnSelectedId,$lmFrameworkVersion;
global $lmUsesCustomComponentRegions;
global $customComponentSidebars;
global $lmUsesConfigurableDropDowns;
global $wp_registered_widgets; 

	if (!isset($lmUsesConfigurableDropDowns)) {
		$lmUsesConfigurableDropDowns = false;
	}
?>
<style>
  .input-prepend select { font-size: 14px; padding-top: 4px; height: 20px;	padding-bottom: 4px; -moz-box-sizing:content-box;
	-webkit-box-sizing:content-box;
	-ms-box-sizing:content-box;
	box-sizing:content-box; }
  
  .marginleftzero {
	  margin-left: 0px !important;
  }
  .slider-range { margin-bottom: 10px; background-color: #D9EDF7; background-image: none;}
  .ui-widget { font-size: 14px }
</style>

                    <h5>Your "Blog" Layout Regions</h5>

<?php
//var_dump($pageRegions);
$template = "blog";
include("_layout.php");
?>
        

<div style='clear: both;'></div>

</div> <!-- end of tab content region -->
<?php } ?>
<div class='tab-pane fade special-region non-visible blog row-fluid' id="tabs-blog-settings">

<div class='well span6'>
<h4><i class='fa fa-sliders'></i> <?php _e("General Blog Layout Settings", "i3d-framework"); ?></h4>
<p>Here you can specify how you generally want your blog to display.  Choose from the "rows" layout, a fluid "grid" (masonry) layout, or chronilogical "timeline" layout.</p>

<ul class='blog-settings'>
	<li>
		<label class='primary-label' for="blog__style"><?php _e("Blog Style", "i3d-framework"); ?></label>
        <input type='hidden' name='__i3d_blog__style' id='__i3d_blog__style' value='<?php echo $blogData['style']; ?>' />
        <div>
          <img onclick='setBlogStyleFeatures("rows", this)' title='<?php _e("Rows", "i3d-framework"); ?>' class='blog-layout-icon <?php if ($blogData['style'] == "rows") { echo " blog-layout-icon-selected"; } ?>' src='<?php echo get_template_directory_uri(); ?>/includes/admin/images/blog-layout-rows.png' />
          <img onclick='setBlogStyleFeatures("grid", this)' title='<?php _e("Grid", "i3d-framework"); ?>' class='blog-layout-icon <?php if ($blogData['style'] == "grid") { echo " blog-layout-icon-selected"; } ?>' src='<?php echo get_template_directory_uri(); ?>/includes/admin/images/blog-layout-grid.png' />
          <img onclick='setBlogStyleFeatures("timeline", this)' title='<?php _e("Timeline", "i3d-framework"); ?>' class='blog-layout-icon <?php if ($blogData['style'] == "timeline") { echo " blog-layout-icon-selected"; } ?>' src='<?php echo get_template_directory_uri(); ?>/includes/admin/images/blog-layout-timeline.png' />
       
        </div>
	</li>	

	<li class="blog__grid" <?php if ($blogData['style'] != "grid") { ?>style='display: none;'<?php } ?>>
		<label class='primary-label' for="blog__columns"><?php _e("Columns", "i3d-framework"); ?></label>
        <div class="btn-group" data-toggle="buttons">
          <label class="btn btn-default <?php if ($blogData['columns'] == "2") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__columns" value="2" id="__i3d_blog__columns__2" <?php if ($blogData['columns'] == "2") { print "checked"; } ?>> 2
          </label>
          <label class="btn btn-default <?php if ($blogData['columns'] == "3") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__columns" value="3" id="__i3d_blog__columns__3" <?php if ($blogData['columns'] == "3") { print "checked"; } ?>> 3
          </label>
          <label class="btn btn-default <?php if ($blogData['columns'] == "4") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__columns" value="4" id="__i3d_blog__columns__4" <?php if ($blogData['columns'] == "4") { print "checked"; } ?>> 4
          </label>
        </div>        
	</li>	
	<li class="blog__grid" <?php if ($blogData['style'] != "grid") { ?>style='display: none;'<?php } ?>>
		<label class='primary-label' for="blog__lead_with_full_width_post"><?php _e("Lead With Full Width Post", "i3d-framework"); ?></label>
        <div class="btn-group" data-toggle="buttons">
          <label class="btn btn-default <?php if ($blogData['lead_with_full_width_post'] == "1") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__lead_with_full_width_post" value="1" id="__i3d_blog__lead_with_full_width_post__1" <?php if ($blogData['lead_with_full_width_post'] == "1") { print "checked"; } ?>> <?php _e("Yes", "i3d-framework"); ?>
          </label>
          <label class="btn btn-default <?php if ($blogData['lead_with_full_width_post'] == "0") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__lead_with_full_width_post" value="0" id="__i3d_blog__lead_with_full_width_post__0" <?php if ($blogData['lead_with_full_width_post'] == "0") { print "checked"; } ?>> <?php _e("No", "i3d-framework"); ?>
          </label>
        </div>        

	</li>	

</ul>
</div>

<div class='well span6'>

<h4><i class='fa fa-indent'></i> <?php _e("Blog Post Layout", "i3d-framework"); ?></h4>
<p>Here you can configure how you wish your blog post and meta-data is displayed. </p>
<ul class='blog-post-settings' style='margin-bottom: 0px; padding-bottom: 0px;'>
	<li class="blog__rows" <?php if ($blogData['style'] != "rows" && $blogData['style'] != "") { ?>style='display: none;'<?php } ?>>
		<label class='primary-label' for="blog__image_size"><?php _e("Image Size", "i3d-framework"); ?></label>

        <div class="btn-group" data-toggle="buttons">
          <label class="btn btn-default <?php if ($blogData['image_size'] == "full") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__image_size" value="full" id="__i3d_blog__lead_with_full_width_post__full" <?php if ($blogData['image_size'] == "full") { print "checked"; } ?>> <?php _e("Full", "i3d-framework"); ?>
          </label>
          <label class="btn btn-default <?php if ($blogData['image_size'] == "medium") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__image_size" value="medium" id="__i3d_blog__lead_with_full_width_post__medium" <?php if ($blogData['image_size'] == "medium") { print "checked"; } ?>> <?php _e("Medium", "i3d-framework"); ?>
          </label>
          <label class="btn btn-default <?php if ($blogData['image_size'] == "small") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__image_size" value="small" id="__i3d_blog__lead_with_full_width_post__small" <?php if ($blogData['image_size'] == "small") { print "checked"; } ?>> <?php _e("Small", "i3d-framework"); ?>
          </label>
        </div>        
    </li>	


	<li class='inline-block-li'>
		<label class='primary-label'for="blog__read_more">Read More Link Text</label>
        <div style='display: inline-block'>
        <input class='form-control' type="text" name="__i3d_blog__read_more" id="blog__read_more" value="<?php echo $blogData['read_more']; ?>" />
		</div>
        <div style='display: inline-block'>
		<?php I3D_Framework::renderFontAwesomeSelect("__i3d_blog__read_more_arrow", $blogData['read_more_arrow'] == 1 ? "fa-angle-right" : $blogData['read_more_arrow'], false, "-- No Arrow --", "-- No Arrow --", "", array("Directional Icons")); ?>
		</div>
	</li>	
	<li class='inline-block-li'>
		<label class='primary-label'for="blog__read_more">Read More Link Location</label>
        <div class="btn-group" data-toggle="buttons">
          <label class="btn btn-default <?php if ($blogData['read_more_location'] == "left") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__read_more_location" value="left" id="__i3d_blog__read_more_location__left" <?php if ($blogData['read_more_location'] == "left") { print "checked"; } ?>> <?php _e("Left", "i3d-framework"); ?>
          </label>
          <label class="btn btn-default <?php if ($blogData['read_more_location'] == "right" || $blogData['read_more_location'] == "") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__read_more_location" value="right" id="__i3d_blog__read_more_location__right" <?php if ($blogData['read_more_location'] == "right") { print "checked"; } ?>> <?php _e("Right", "i3d-framework"); ?>
          </label>

        </div> 		
	</li>
 </ul>
 
 <script>
 function handleCommentStatusChange(label) {
	var selectedValue = jQuery(label).find("input").val();
	if (selectedValue == "1") {
	  jQuery("#comment_status_style").css("display", "");
	  jQuery("#comment_status_location").css("display", "");
	} else {
	  jQuery("#comment_status_style").css("display", "none");
	  jQuery("#comment_status_location").css("display", "none");
	}
 }
 </script>
 <ul class='blog-post-settings'>   
	<li class='inline-block-li'>
		<label class='primary-label' for="blog__show_comments_status"><i class='fa fa-comments-o'></i> <?php _e("Show Comments Status", "i3d-framework"); ?></label>
        <div class="btn-group" data-toggle="buttons">
          <label onclick='handleCommentStatusChange(this)' class="btn btn-default <?php if ($blogData['show_comments_status'] == "1") { print "active"; } ?>">
            <input  type="radio" name="__i3d_blog__show_comments_status" value="1" id="__i3d_blog__show_comments_status__1" <?php if ($blogData['show_comments_status'] == "1") { print "checked"; } ?>> <?php _e("Yes", "i3d-framework"); ?>
          </label>
          <label  onclick='handleCommentStatusChange(this)' class="btn btn-default <?php if ($blogData['show_comments_status'] == "0" || $blogData['show_comments_status'] == "") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__show_comments_status" value="0" id="__i3d_blog__show_comments_status__0" <?php if ($blogData['show_comments_status'] == "0") { print "checked"; } ?>> <?php _e("No", "i3d-framework"); ?>
          </label>         
        </div>   	
    </li> 

	<li class='inline-block-li' id="comment_status_style" <?php if ($blogData['show_comments_status'] != "1") { ?>style='display: none;'<?php } ?>>
		<label class='primary-label' for="blog__show_comments_status"><?php _e("Comments Status Style", "i3d-framework"); ?></label>
        <div class="btn-group" data-toggle="buttons">
          <label class="btn btn-default <?php if (@$blogData['comments_status_style'] == "1") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__comments_status_style" value="1" id="__i3d_blog__show_comments_style__1" <?php if (@$blogData['comments_status_style'] == "1") { print "checked"; } ?>> <i class='fa fa-comments-o'></i> 3
          </label>
          <label class="btn btn-default <?php if (@$blogData['comments_status_style'] == "0" || @$blogData['comments_status_style'] == "") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__comments_status_style" value="0" id="__i3d_blog__show_comments_style__0" <?php if (@$blogData['comments_status_style'] == "0") { print "checked"; } ?>> 3 <?php _e("Comments", "i3d-framework"); ?>
          </label>         
        </div>   	
    </li>   

	<li class='inline-block-li' id="comment_status_location" <?php if (@$blogData['show_comments_status'] != "1") { ?>style='display: none;'<?php } ?>>
		<label class='primary-label' for="blog__show_comments_status"><?php _e("Comments Status Location", "i3d-framework"); ?></label>
        <div class="btn-group" data-toggle="buttons">
          <label class="btn btn-default <?php if (@$blogData['comments_status_location'] == "0" || @$blogData['comments_status_location'] == "") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__comments_status_location" value="0" id="__i3d_blog__show_comments_status__1" <?php if (@$blogData['comments_status_location'] == "0" || @$blogData['comments_status_location'] == "") { print "checked"; } ?>> <?php _e("Within Meta Data Region", "i3d-framework"); ?>
          </label>
          <label class="btn btn-default <?php if (@$blogData['comments_status_location'] == "1") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__comments_status_location" value="1" id="__i3d_blog__show_comments_status__2" <?php if (@$blogData['comments_status_location'] == "1") { print "checked"; } ?>> <?php _e("Opposite 'Read More' Link", "i3d-framework"); ?>
          </label>        
        </div>   	
    </li>    
  </ul>
  <br/>
  <h4><i class='fa fa-info-circle'></i> <?php _e("Meta Data Display", "i3d-framework"); ?></h4>
  <p>Meta data contains such items as the Author Name, Post Date, Post Tags, and Categories.</p>
  <ul class='blog-post-settings'>
	<li>
		<label class='primary-label' for="blog__meta_data_location"><?php _e("Location", "i3d-framework"); ?></label>

        <div class="btn-group" data-toggle="buttons">
          <label class="btn btn-default <?php if (@$blogData['meta_data_location'] == "above" || @$blogData['meta_data_location'] == "") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__meta_data_location" value="above" id="__i3d_blog__meta_data_location__above" <?php if (@$blogData['meta_data_location'] == "above") { print "checked"; } ?>> <?php _e("Above Content", "i3d-framework"); ?>
          </label>
          <label class="btn btn-default <?php if (@$blogData['meta_data_location'] == "below") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__meta_data_location" value="below" id="__i3d_blog__meta_data_location__below" <?php if (@$blogData['meta_data_location'] == "below") { print "checked"; } ?>> <?php _e("Below Content", "i3d-framework"); ?>
          </label>
        </div> 		    
    </li>
	<li>
		<label class='primary-label' for="blog__meta_data_location"><?php _e("Post Format", "i3d-framework"); ?></label>

        <div class="btn-group" data-toggle="buttons">
          <label class="btn btn-default <?php if ($blogData['show_post_format'] == "3x") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__show_post_format" value="3x" id="__i3d_blog__show_post_format__2" <?php if ($blogData['show_post_format'] == "3x") { print "checked"; } ?>> <?php _e("Large Badge", "i3d-framework"); ?>
          </label>
          <label class="btn btn-default <?php if ($blogData['show_post_format'] == "2x") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__show_post_format" value="2x" id="__i3d_blog__show_post_format__2" <?php if ($blogData['show_post_format'] == "2x") { print "checked"; } ?>> <?php _e("Medium Badge", "i3d-framework"); ?>
          </label>
          <label class="btn btn-default <?php if ($blogData['show_post_format'] == "lg") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__show_post_format" value="lg" id="__i3d_blog__show_post_format__2" <?php if ($blogData['show_post_format'] == "lg") { print "checked"; } ?>> <?php _e("Small Badge", "i3d-framework"); ?>
          </label>          
          <label class="btn btn-default <?php if ($blogData['show_post_format'] == "1") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__show_post_format" value="1" id="__i3d_blog__show_post_format__1" <?php if ($blogData['show_post_format'] == "1") { print "checked"; } ?>> <?php _e("Small Icon &amp; Text", "i3d-framework"); ?>
          </label>
          <label class="btn btn-default <?php if ($blogData['show_post_format'] == "0" || $blogData['show_post_format'] == "") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__show_post_format" value="0" id="__i3d_blog__show_post_format__0" <?php if ($blogData['show_post_format'] == "0") { print "checked"; } ?>> <?php _e("Do Not Display", "i3d-framework"); ?>
          </label>
      </div> 		    
    </li>
        		 
	<li class='inline-block-li'>
		<label class='primary-label' for="blog__show_author"><i class='fa fa-user'></i> Show Author</label>

        <div class="btn-group" data-toggle="buttons">
          <label class="btn btn-default <?php if ($blogData['show_author'] == "1") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__show_author" value="1" id="__i3d_blog__show_author__1" <?php if ($blogData['show_author'] == "1") { print "checked"; } ?>> <?php _e("Yes", "i3d-framework"); ?>
          </label>
          <label class="btn btn-default <?php if ($blogData['show_author'] == "0") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__show_author" value="0" id="__i3d_blog__show_author__0" <?php if ($blogData['show_author'] == "0") { print "checked"; } ?>> <?php _e("No", "i3d-framework"); ?>
          </label>
        </div>           
	</li>
	<li class='inline-block-li'>
		<label class='primary-label' for="blog__show_date"><i class='fa fa-calendar-o'></i> Show Date</label>
        <div class="btn-group" data-toggle="buttons">
          <label class="btn btn-default <?php if ($blogData['show_date'] == "1") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__show_date" value="1" id="__i3d_blog__show_date__1" <?php if ($blogData['show_date'] == "1") { print "checked"; } ?>> <?php _e("Yes", "i3d-framework"); ?>
          </label>
          <label class="btn btn-default <?php if ($blogData['show_date'] == "0") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__show_date" value="0" id="__i3d_blog__show_date__0" <?php if ($blogData['show_date'] == "0") { print "checked"; } ?>> <?php _e("No", "i3d-framework"); ?>
          </label>
        </div>              
	</li>

	<li class='inline-block-li'>
		<label class='primary-label' for="blog__show_tags"><i class='fa fa-tags'></i> Show Tags</label>       
        <div class="btn-group" data-toggle="buttons">
          <label class="btn btn-default <?php if ($blogData['show_tags'] == "1") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__show_tags" value="1" id="__i3d_blog__show_tags__1" <?php if ($blogData['show_tags'] == "1") { print "checked"; } ?>> <?php _e("Yes", "i3d-framework"); ?>
          </label>
          <label class="btn btn-default <?php if ($blogData['show_tags'] == "0") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__show_tags" value="0" id="__i3d_blog__show_tags__0" <?php if ($blogData['show_tags'] == "0") { print "checked"; } ?>> <?php _e("No", "i3d-framework"); ?>
          </label>
        </div>           
	</li>
	<li class='inline-block-li'>
		<label class='primary-label' for="blog__show_cateoriges"><i class='fa fa-sitemap'></i> Show Categories</label>

        <div class="btn-group" data-toggle="buttons">
          <label class="btn btn-default <?php if ($blogData['show_categories'] == "1") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__show_categories" value="1" id="__i3d_blog__show_categories__1" <?php if ($blogData['show_categories'] == "1") { print "checked"; } ?>> <?php _e("Yes", "i3d-framework"); ?>
          </label>
          <label class="btn btn-default <?php if ($blogData['show_categories'] == "0") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__show_categories" value="0" id="__i3d_blog__show_categories__0" <?php if ($blogData['show_categories'] == "0") { print "checked"; } ?>> <?php _e("No", "i3d-framework"); ?>
          </label>
        </div>        
	</li>
    <li></li>
	<li class='inline-block-li'>
		<label class='primary-label' for="blog__show_cateoriges"><i class='fa fa-minus'></i> <?php _e("Show Border", "i3d-framework"); ?></label>

        <div class="btn-group" data-toggle="buttons">
          <label class="btn btn-default <?php if ($blogData['show_hr'] == "above") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__show_hr" value="above" id="__i3d_blog__show_hr__above" <?php if ($blogData['show_hr'] == "above") { print "checked"; } ?>> <?php _e("Above", "i3d-framework"); ?>
          </label>
          <label class="btn btn-default <?php if ($blogData['show_hr'] == "below") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__show_hr" value="below" id="__i3d_blog__show_hr__below" <?php if ($blogData['show_hr'] == "below") { print "checked"; } ?>> <?php _e("Below", "i3d-framework"); ?>
          </label>
          <label class="btn btn-default <?php if ($blogData['show_hr'] == "above-below") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__show_hr" value="above-below" id="__i3d_blog__show_hr__above-below" <?php if ($blogData['show_hr'] == "above-below") { print "checked"; } ?>> <?php _e("Both", "i3d-framework"); ?>
          </label>        
          <label class="btn btn-default <?php if ($blogData['show_hr'] == "neither" || $blogData['show_hr'] == "") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__show_hr" value="neither" id="__i3d_blog__show_hr__neither" <?php if ($blogData['show_hr'] == "neither" || $blogData['show_hr'] == "") { print "checked"; } ?>> <?php _e("Neither", "i3d-framework"); ?>
          </label> 
       </div>        
	</li>
	<li class='inline-block-li'>
		<label class='primary-label' for="blog__hr_border"><?php _e("Border Type", "i3d-framework"); ?></label>

        <div class="btn-group" data-toggle="buttons">
          <label class="btn btn-default <?php if ($blogData['hr_border'] == "single" || $blogData['hr_border'] == "") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__hr_border" value="single" id="__i3d_blog__hr_border__single" <?php if ($blogData['hr_border'] == "single" || $blogData['hr_border'] == "") { print "checked"; } ?>> <?php _e("Single", "i3d-framework"); ?>
          </label>
          <label class="btn btn-default <?php if ($blogData['hr_border'] == "double") { print "active"; } ?>">
            <input type="radio" name="__i3d_blog__hr_border" value="double" id="__i3d_blog__hr_border__double" <?php if ($blogData['hr_border'] == "double") { print "checked"; } ?>> <?php _e("Double", "i3d-framework"); ?>
          </label>
       </div>        
	</li>
</ul>
</div>
</div>

<script type="text/javascript">
  function setBlogStyleFeatures(value, image) {
	  jQuery(image).parent().find("img").removeClass("blog-layout-icon-selected");
	  jQuery(image).addClass("blog-layout-icon-selected");
	  jQuery("#__i3d_blog__style").val(value);
	 
	if (value == "rows") {
	  jQuery(".blog__grid").css("display", "none");	
	  jQuery(".blog__rows").css("display", "block");	
	} else if (value == "grid") {
	  jQuery(".blog__grid").css("display", "block");	
	  jQuery(".blog__rows").css("display", "none");	
	} else if (value == "timeline") {
	  jQuery(".blog__grid").css("display", "none");	
	  jQuery(".blog__rows").css("display", "none");	
	}
  }
</script>