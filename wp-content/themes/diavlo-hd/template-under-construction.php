<?php 
/*
 Template Name: Under Construction 
*/
I3D_Framework::template_header();

if (I3D_Framework::use_global_layout()) {
	I3D_Framework::render_page_in_layout($page_id);
	return;
} 

i3d_render_contact_panel();

?>
<div class="main-wrapper">

<div class="container-wrapper header-top">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
            	 <?php the_widget( 'I3D_Widget_Logo', I3D_Widget_Logo::getPageInstance($page_id));  ?>
            
            </div>
			<div class="col-md-7">

				</div>
			</div>
			<div class="col-md-2 hidden-sm visible-xs">
            
            </div>				

		</div>
	</div>
</div>
<div class='content-wrapper header-bottom'>
  <div class='container'>
    <div class='row'>
      <div class='col-md-3 hidden-sm hidden-xs'>&nbsp;</div>
      <div class='col-md-9'>
        <?php i3d_show_widget_region("utility", array()); ?> 		
     </div>
    </div>
  </div>
</div>

<!-- header
================================================== -->

<?php i3d_show_widget_region("seo", array("container-wrapper", "container minimized-header-bg")); ?> 		

<?php i3d_show_widget_region("header-lower", array("container-wrapper", "container"), ""); ?>
<?php i3d_show_divider_region("divider-1"); ?> 		
<?php i3d_show_widget_region("advertising", array("container-wrapper", "container")); ?>






<!-- Main content
================================================== -->
<div class="container-wrapper"> 

	<div class="container padding-bottom-40">


               <?php i3d_post_content(); ?>
	</div>


</div>


<!-- Footer 
================================================== -->

<div class="container-wrapper footer-bg">
  <div class="container">
	<div class="footer">
		<footer class="row">

<?php i3d_show_widget_region("footer", array("container"), ""); ?>
<?php i3d_show_widget_region("copyright", array("container"), ""); ?>

		</footer>
    </div>
  </div>
</div>

<?php get_footer(); ?>