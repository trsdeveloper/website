<?php
function luckymarble_show_get_in_touch() {
          ?>
              <!--get in touch-->
    <div id="get_in_touch">
    <?php
		$getInTouchButtonOptions = get_option('luckymarble_get_in_touch');

		$getInTouchButtonOptions['link'] = str_replace(home_url().'/', '',get_page_link($getInTouchButtonOptions['link']));
		if ($getInTouchButtonOptions['show'] == 1 && $getInTouchButtonOptions['link'] != "") {
	?>
    
<a href="<?php echo $getInTouchButtonOptions['link']; ?>"><img src="<?php get_template_directory_uri(); ?>/Site/graphics/get_in_touch.png" class="getintouch" alt="get in touch" style="border-style: solid; border-width: 0px" /></a>
<?php } ?>

    </div>
    <!--/get in touch-->
    <?php
}

function luckymarble_show_social_icons() {
	global $linkedin_account, $facebook_account, $twitter_account;
	?>
    <!--twitter-facebook-->
    <div id="twitter_facebook">
    <div>
    <?php if($linkedin_account) { ?>
    <a href="http://www.linkedin.com/<?php echo $linkedin_account; ?>"><img class="tfl" alt="Follow me on LinkedIn" 	title="LinkedIn" 	src="<?php get_template_directory_uri(); ?>/Site/themed_images/linkedin.png" 	style="border:0px;" /></a>
    <?php } ?>
    <?php if($facebook_account) { ?>
    <a href="http://www.facebook.com/<?php echo $facebook_account; ?>/"><img class="tfl"  alt="follow me on facebook" 	title="Facebook" 	src="<?php get_template_directory_uri(); ?>/Site/themed_images/facebook_badge.png" 	style="border:0px;" /></a>
    <?php } ?>
    <?php if($twitter_account) { ?>
    <a href="http://www.twitter.com/<?php echo $twitter_account; ?>/"><img class="tfl"  alt="tweet me" 				title="Twitter" 	src="<?php get_template_directory_uri(); ?>/Site/themed_images/t_logo-a.png" 		 style="border:0px;" /></a>
    <?php } ?>
    <!--
    <a href="<?php echo site_url(); ?>/?feed=rss2"><img alt="RSS" 				title="RSS Feed" 	src="<?php get_template_directory_uri(); ?>/Site/themed_images/rss.png" 			width="36" height="36" style="border:0px;" /></a>
    -->
    </div>
    </div>
    <!--/twitter-facebook-->	
<?php	
}

function luckymarble_show_bookmark() {
	global $addthis_account;
	
	if ($addthis_account) { ?>
    <!--bookmark-->
    <div id="bookmark">
    <a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&username=<?php echo $addthis_account; ?>"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=<?php echo $addthis_account; ?>"></script>
    </div>
    <!--/bookmark-->
	<?php }
}
?>