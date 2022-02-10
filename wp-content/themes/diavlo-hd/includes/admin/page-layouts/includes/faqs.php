<?php
global $post, $columnSelectedId, $lmTemplates, $lmColumns, $defaultTemplate, $lmNivoVersion, $templateName;
if (I3D_Framework::use_global_layout()) { 
   return;
  }
  

  // calculate progress
  $wordCount = str_word_count( strip_tags( $post->post_content ) );
   	$wpq = array("post_type" => "i3d-faq");
	$faqPosts = new WP_Query($wpq);
	foreach ($faqPosts->posts as $faqPost) {
		$wordCount += str_word_count( strip_tags($faqPost->post_title));
	} 
 // $wordCount += sizeof($categoryPosts->posts) * 5;
  
  $progress['page_content']['percent'] = number_format($wordCount / 250 * 100, 0, '.', ',');
  

	//print sizeof($categoryPosts->posts);
  
  $progress['page_content']['percent'] = $progress['page_content']['percent'] > 100 ? 100 : $progress['page_content']['percent']; 
  $progress['page_content']['tip'] = "You should have at least 250 words on your page, including FAQS, for search engines to find it worth any merit.";
  
  $progress['seo']['percent'] 	= getSeoProgressData($post, "percent"); 
  $progress['seo']['tip'] 		= getSeoProgressData($post, "tip");

  $progress['slider']['percent'] 	= getSliderProgressData($post, "percent"); 
  $progress['slider']['tip'] 		= getSliderProgressData($post, "tip");

  $progress['menu']['percent'] 	= getMenuProgressData($post, "percent"); 
  $progress['menu']['tip'] 		= getMenuProgressData($post, "tip");

  $progress['layout']['percent'] 	= getLayoutProgressData($post, "percent"); 
  $progress['layout']['tip'] 		= getLayoutProgressData($post, "tip");

?>
<div class='special-region non-visible faqs' id="tabs-faqs-overview">
<div class='page-layout-editor-summary row-fluid'>
<!--	<div class='span2'><img src="<?php echo get_template_directory_uri(); ?>/images/layouts/faqs.jpg" /></div>-->
        <div class='col-sm-12'>
            <h2>Selected Layout: FAQs</h2>
            <p class='lead'> The "FAQs Layout" is designed to showcase Frequently Asked Questions (with Answers).  Use this to answer the important information about your website or organization.</p>
           <!-- <h5>Your "FAQs Layout" Checklist</h5>
            <p>Once you complete the following, consider this page done!</p>-->
        </div>
        <div class='col-sm-12'>
            <div class='row'>
              <div class='col-sm-4'><label><i class='icon-pencil'></i> Page Content <i class='icon-info-sign icon-tooltip' data-toggle='tooltip' title='<?php echo $progress['page_content']['tip']?>'></i></label> <div class="progress"><div class="progress-bar <?php echo getProgressStyle($progress['page_content']['percent']); ?>" style="width: <?php echo $progress['page_content']['percent']; ?>%;"><?php print $progress['page_content']['percent']?>%</div></div></div>
              <div class='col-sm-4'><label><i class='icon-shield'></i> SEO <i class='icon-info-sign icon-tooltip' data-toggle='tooltip' title='<?php echo $progress['seo']['tip']?>'></i></label><div class="progress"><div class="progress-bar <?php echo getProgressStyle($progress['seo']['percent']); ?>" style="width: <?php echo $progress['seo']['percent'] == 0 ? 1 : $progress['seo']['percent']; ?>%;"><?php print $progress['seo']['percent']?>%</div></div></div>
              <div class='col-sm-4'><label><i class='icon-tasks'></i> Layout <i class='icon-info-sign icon-tooltip' data-toggle='tooltip' title='<?php echo $progress['layout']['tip']?>'></i></label><div class="progress"><div class="progress-bar <?php echo getProgressStyle($progress['layout']['percent']); ?>" style="width: <?php echo $progress['layout']['percent'] == 0 ? 1 : $progress['layout']['percent']; ?>%;"><?php print $progress['layout']['percent']?>%</div></div></div>
            </div>
            <div style='clear: both;'></div>
        </div>
	</div>
</div>
