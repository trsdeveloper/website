<?php
function luckymarble_show_news_ticker() {
          
		$newsTickerOptions = get_option('luckymarble_news_ticker');
		$newsTickerItems = $newsTickerOptions['news'];
		$newsTickerOptions['speed'] = number_format($newsTickerOptions['speed'], 0, '', '');
		if ($newsTickerOptions['speed'] == "" || $newsTickerOptions['speed'] < 1) {
			$newsTickerOptions['speed'] = 3;
		}
		if ($newsTickerOptions['enabled'] == 1) { 
	?>
    <!--news_ticker-->
    <div id="news_ticker">
   

<script type="text/javascript" src="<?php get_template_directory_uri(); ?>/Site/javascript/webwidget_slideshow_common.js"></script>
<script language="javascript" type="text/javascript">
            jQuery(function() {
                jQuery("#webwidget_slideshow_common1").webwidget_slideshow_common({
                    slideshow_transition_effect: 'slide_down',//slide_left slide_down fade_in
                    slideshow_time_interval: '<?php echo $newsTickerOptions['speed']; ?>000',
                    slideshow_window_width: '800',
                    slideshow_window_height: '23',
                    slideshow_border_style: 'solid',//dashed dotted double groove hidden inset none outset ridge solid
                    slideshow_border_size: '0',
                    slideshow_border_color: '#AEDFE6',
                    slideshow_border_radius: '5',
                    slideshow_padding_size: '3',
                    slideshow_background_color: 'transparent'
                });
            });
        </script>
        
        
        
        
<div id="webwidget_slideshow_common1" class="webwidget_slideshow_common">


<h4><?php 
   if ($lmFrameworkVersion < 2.4 || $lmIncludedComponentsSub['news_ticker']['title']) { 
     echo $newsTickerOptions['title']; 
   }
    ?></h4>

            <ul>
 <?php 
 $linkCount = 0;
 foreach ($newsTickerItems as $newsTickerItem) { 
 		// define the link
		if ($newsTickerItem['link_type'] == "external") {
			$linkURL = $newsTickerItem['link'];
			//$linkTitle = $image['title'];
		
		} else if ($newsTickerItem['link_type'] == "page") {
			
				$linkURL = str_replace(home_url().'/', '' ,get_page_link($newsTickerItem['link']));
				
				if ($linkURL == "" && $newsTickerItem['link'] != "") {
					//$newsTickerItem['link'] = $newsTickerItem['link'];
				} else {
					//$newsTickerItem['link'] = "../../../".$linkURL;
				}
				$newsTickerItem['link'] = get_page_link($newsTickerItem['link']);
		
																																						
		} else if ($newsTickerItem['link_type'] == "post") {
			$newsTickerItem['link'] = str_replace(home_url().'/', '',get_page_link($newsTickerItem['link']));
		}           
           ?>
                <li><?php
				  if ($newsTickerItem['link'] != "") { 
				     echo '<a target="'.$newsTickerItem['link_target'].'" href="'.$newsTickerItem['link'].'">';
				  }
				  echo $newsTickerItem['ticker_text'];
                  if ($newsTickerItem['link'] != "") { 
				    echo "</a>";
				  }
				  ?>
                  </li>
				 <?php } ?>

            </ul> 


				

<div style="clear: both"></div>
</div>    
    </div>
    <!--/news_ticker-->

    <?php
		}
}
?>