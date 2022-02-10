<?php
global $post, $columnSelectedId, $lmTemplates, $lmColumns, $defaultTemplate, $lmNivoVersion, $templateName;

  
  $blogData = get_post_meta($post->ID, "blog", true);
  if (!is_array($blogData)) {
	  $blogData = array();
  }
  $blogData = wp_parse_args( (array) $blogData, array( 'read_more' => 'Read More', 'style' => 'rows', 'columns' => 2, 'lead_with_full_post' => 1, 'image_size' => 'medium', 'read_more_arrow' => 'fa-angle-double-right', 'read_more_location' => '', 'show_comments_status' => '', 'meta_data_location' => 'above',
													   'show_post_format' => '', 'show_author' => 0, 'show_date' => 1, 'show_tags' => 0, 'show_categories' => 0, 'show_hr' => 'above-below', 'hr_border' => 'single') );
 
  //var_dump($blogData);

if (I3D_Framework::use_global_layout()) { 
   return;
  }
global $post, $columnSelectedId, $lmTemplates, $lmColumns, $defaultTemplate, $lmNivoVersion, $templateName;
  
  // calculate progress
  $wordCount = str_word_count( strip_tags( $post->post_content ) );
  $progress['page_content']['percent'] = number_format($wordCount / 250 * 100, 0, '.', ',');
  $progress['page_content']['percent'] = $progress['page_content']['percent'] > 100 ? 100 : $progress['page_content']['percent']; 
  $progress['page_content']['tip'] = "You should have at least 250 words on your page for search engines to find it worth any merit.";

  $progress['posts']['percent'] 	= getPostProgressData("percent"); 
  $progress['posts']['tip'] 		= getPostProgressData("tip");

  $progress['seo']['percent'] 	= getSeoProgressData($post, "percent"); 
  $progress['seo']['tip'] 		= getSeoProgressData($post, "tip");

  $progress['slider']['percent'] 	= getSliderProgressData($post, "percent"); 
  $progress['slider']['tip'] 		= getSliderProgressData($post, "tip");

  $progress['menu']['percent'] 	= getMenuProgressData($post, "percent"); 
  $progress['menu']['tip'] 		= getMenuProgressData($post, "tip");

  $progress['layout']['percent'] 	= getLayoutProgressData($post, "percent"); 
  $progress['layout']['tip'] 		= getLayoutProgressData($post, "tip");

?>
<div class='special-region non-visible blog' id="tabs-blog-overview">
<div class='page-layout-editor-summary row-fluid'>
	<!--<div class='span2'><img src="<?php echo get_template_directory_uri(); ?>/images/layouts/blog.jpg" /></div>-->
        <div class='col-sm-12'>
            <h2>Selected Layout: Blog</h2>
            <p class='lead'> The "Blog" layout is designed to be secondary to your website's landing page, however it may also act as your home page if you decide to run a blog centric website.</p>
            <!--<h5>Your "Blog Layout" Checklist</h5>
            <p>Once you complete the following, consider this page done!</p>-->
         </div>
         <div class='col-sm-12'>
            <div class='row'>
              <div class='col-sm-4'><label><i class='icon-pencil'></i> Posts <i class='icon-info-sign icon-tooltip' data-toggle='tooltip' title='<?php echo $progress['posts']['tip']?>'></i> <a class='btn btn-success btn-xs pull-right' href="edit.php" style='margin-left: 17px; margin-bottom: 1px; padding-bottom: 1px'>Manage Posts</a></label> <div style='clear: right;' class="progress"><div class="progress-bar <?php echo getProgressStyle($progress['posts']['percent']); ?>" style="width: <?php echo $progress['posts']['percent']; ?>%;"><?php print $progress['posts']['percent']?>%</div></div></div>
              <div class='col-sm-4'><label><i class='icon-shield'></i> SEO <i class='icon-info-sign icon-tooltip' data-toggle='tooltip' title='<?php echo $progress['seo']['tip']?>'></i></label><div class="progress"><div class="progress-bar <?php echo getProgressStyle($progress['seo']['percent']); ?>" style="width: <?php echo $progress['seo']['percent'] == 0 ? 1 : $progress['seo']['percent']; ?>%;"><?php print $progress['seo']['percent']?>%</div></div></div>
              <div class='col-sm-4'><label><i class='icon-tasks'></i> Layout <i class='icon-info-sign icon-tooltip' data-toggle='tooltip' title='<?php echo $progress['layout']['tip']?>'></i></label><div class="progress"><div class="progress-bar <?php echo getProgressStyle($progress['layout']['percent']); ?>" style="width: <?php echo $progress['layout']['percent'] == 0 ? 1 : $progress['layout']['percent']; ?>%;"><?php print $progress['layout']['percent']?>%</div></div></div>
            </div>
            <div style='clear: both;'></div>
        </div>
	</div>
</div>
