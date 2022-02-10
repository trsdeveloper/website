<?php global $code_end_of_body, $copyright_message, $powered_by_message, $supportedSidebars, $myPageID, $lmCurrentSidebar, $pageTemplate;
global $renderedIsotopePortfolio;

global $i3d_using_external_header_call, $i3d_external_page_body;

if (@$i3d_using_external_header_call) {
  $i3d_external_page_body = ob_get_clean();
  ob_start();
}

if (!I3D_Framework::use_global_layout()) { 

if ($pageTemplate != "photo-slideshow" && $copyright_message != "" && $powered_by_message != "") { ?>
    <?php 
	ob_start();
	 i3d_show_widget_region("footer", array("container"), "DEFAULT-FOOTER");
	 $footerOutput = ob_get_clean();
	 if ($footerOutput != "") { ?>
<div class="footer"><div class="section-innner"><div class="wrapper"><div class="container"><div class="row inner ">

	<footer>
 	<div class="footer-top"><?php _e("Get in Touch!", get_template()); ?></div>
   
    <?php echo $footerOutput; ?>
    
 </footer>           
</div></div></div></div></div>
<?php } ?>

<!-- COPYRIGHT START -->
<div class="copyright"><div class="container"><div class="row inner">
    <?php i3d_show_widget_region("copyright", array("container"), ""); ?>

	<div class="pull-left margin-top-20">	
		<div class="website-name-hover">
				<span class="website-text1"><?php echo $powered_by_message; ?></span ><span class="website-text2"></span >
		</div>
	</div>
	<p class="pull-right margin-top-25"><?php echo $copyright_message; ?></p>
		


</div></div></div>
<!-- COPYRIGHT END -->

<?php } ?>
<?php } ?>
<?php if ($pageTemplate != "photo-slideshow") { ?>

<?php } ?>
<!-- google analytics tracking -->
<div class="google-analytics">
<?php i3d_render_tracking_script(); ?>
</div>

<!-- misc scripts 1 -->
<div class="misc-scripts1">
</div>

<!-- misc scripts 2 -->
<div class="misc-scripts2">
</div>

<?php wp_footer(); ?>

<?php i3d_render_soundcloud_player(); ?>
<script>
		<?php I3D_Framework::render_active_background_script(); ?>
</script>
<?php if ($renderedIsotopePortfolio) { ?>
<script>
//jQuery.noConflict();
		(function (jQuery) {

			var $container = jQuery('#isotope-container');

			if($container.length) {
				$container.waitForImages(function() {
												//  alert("yeah");

					// initialize isotope
					$container.isotope({
					  itemSelector : '.thumb',
					  layoutMode : 'fitRows'
					});
					//alert("yuppppp");
					// filter items when filter link is clicked
					jQuery('#isotope-buttons a').click(function(){
																
					  var selector = jQuery(this).attr('data-filter');
					  $container.isotope({ filter: selector });
					  jQuery(this).removeClass('active').addClass('active').siblings().removeClass('active all');
					  return false;
					});

				},null,true);
			}
			})(jQuery);

</script>

<?php } ?>

<?php echo $code_end_of_body; ?>
</body>
</html>
<?php 
if (@$i3d_using_external_header_call) {
  global $i3d_footer_output;
  $i3d_footer_output = "".ob_get_clean();
  require( get_stylesheet_directory() ."/index.php");
}
?>