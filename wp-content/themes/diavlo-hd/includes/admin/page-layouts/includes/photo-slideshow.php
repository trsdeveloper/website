<?php
global $post, $columnSelectedId, $lmTemplates, $lmColumns, $defaultTemplate, $lmNivoVersion, $templateName;
if (I3D_Framework::use_global_layout()) { 
   return;
  }
  
  
  // calculate progress
  $wordCount = str_word_count( strip_tags( $post->post_content ) );
  $progress['page_content']['percent'] = number_format($wordCount / 250 * 100, 0, '.', ',');
  $progress['page_content']['percent'] = $progress['page_content']['percent'] > 100 ? 100 : $progress['page_content']['percent']; 
  $progress['page_content']['tip'] = "You should have at least 250 words on your page for search engines to find it worth any merit.";
  
  $progress['seo']['percent'] 	= getSeoProgressData($post, "percent"); 
  $progress['seo']['tip'] 		= getSeoProgressData($post, "tip");

  $progress['slider']['percent'] 	= getSliderProgressData($post, "percent"); 
  $progress['slider']['tip'] 		= getSliderProgressData($post, "tip");

  $progress['menu']['percent'] 	= getMenuProgressData($post, "percent"); 
  $progress['menu']['tip'] 		= getMenuProgressData($post, "tip");

  $progress['layout']['percent'] 	= getLayoutProgressData($post, "percent"); 
  $progress['layout']['tip'] 		= getLayoutProgressData($post, "tip");

?>
<div class='special-region non-visible photo-slideshow' id="tabs-photo-slideshow-overview">
<?php
//var_dump($slideShowData);
?>
<div class='page-layout-editor-summary row-fluid'>
	<!--<div class='span2'><img src="<?php echo get_template_directory_uri(); ?>/images/layouts/photo-slideshow.jpg" /></div>-->
        <div class='col-sm-12'>
            <h2>Selected Layout: Photo Slideshow</h2>
            <p> The "Photo Slideshow" layout is designed to showcase images to do with your website or business.</p>
            <!--<h5>Your "Photo Slideshow" Checklist</h5>
            <p>Once you complete the following, consider this page done!</p>-->
            
       
        </div>
	</div>
</div>
