<?php
global $post, $columnSelectedId, $lmTemplates, $lmColumns, $defaultTemplate, $lmNivoVersion, $templateName;
  $curtainMenuData = get_post_meta($post->ID, "curtain_menu", true);
  if (!is_array($curtainMenuData)) {
	  $curtainMenuData = array();
  }
  $curtainMenuData = wp_parse_args( (array) $curtainMenuData, array( 'intro-panel-1' => '',
																	'intro-panel-2' => '',
																	'intro-panel-3' => '',
																	'intro-panel-4' => '',
																	'intro-panel-5' => '',
																	'intro-panel-6' => '',
																	'intro-panel-7' => '',
																	'intro-panel-8' => '') );
  
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


if (I3D_Framework::use_global_layout()) { 
   return;
  }

?>
<div class='special-region non-visible intro'>
<div class='page-layout-editor-summary row-fluid'>
	<!--<div class='span2'><img src="<?php echo get_template_directory_uri(); ?>/images/layouts/home.jpg" /></div>-->
        <div class='col-sm-12'>
            <h2>Intro Layout</h2>
            <p class='lead'> The "Intro Page" layout is designed to be your website's landing page.  Use this layout if you need a high impact page to welcome your visitors.</p>
            <h5>Your "Intro" Checklist</h5>
            <p>Once you complete the following, consider this page done!</p>
            <div class='row-fluid'>
              <div>
                <label><i class='icon-pencil'></i> Page Content <?php print $progress['page_content']['percent']?>% <i class='icon-info-sign icon-tooltip' data-toggle='tooltip' title='<?php echo $progress['page_content']['tip']?>'></i></label> <div class="progress <?php echo getProgressStyle($progress['page_content']['percent']); ?>"><div class="bar" style="width: <?php echo $progress['page_content']['percent']; ?>%;"></div></div>
              </div>

              <div><label><i class='icon-shield'></i> SEO <?php print $progress['seo']['percent']?>% <i class='icon-info-sign icon-tooltip' data-toggle='tooltip' title='<?php echo $progress['seo']['tip']?>'></i></label><div class="progress <?php echo getProgressStyle($progress['seo']['percent']); ?>"><div class="bar" style="width: <?php echo $progress['seo']['percent'] == 0 ? 1 : $progress['seo']['percent']; ?>%;"></div></div></div>
              <div><label><i class='icon-tasks'></i> Layout <?php print $progress['layout']['percent']?>% <i class='icon-info-sign icon-tooltip' data-toggle='tooltip' title='<?php echo $progress['layout']['tip']?>'></i></label><div class="progress <?php echo getProgressStyle($progress['layout']['percent']); ?>"><div class="bar" style="width: <?php echo $progress['layout']['percent'] == 0 ? 1 : $progress['layout']['percent']; ?>%;"></div></div></div>
            </div>
            <div style='clear: both;'></div>
        </div>
	</div>
</div>
