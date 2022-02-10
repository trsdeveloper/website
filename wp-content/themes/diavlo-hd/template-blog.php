<?php
/*
Template Name: Blog
*/
I3D_Framework::template_header();

if (I3D_Framework::use_global_layout()) {
	I3D_Framework::render_page_in_layout($page_id);
	return;
} 
i3d_render_contact_panel();
?>
<div class="header fullscreen-maybe">
  	<?php i3d_show_widget_region("showcase", array("container-wrapper", "container")); ?> 		


	<div class="top">
		<?php i3d_show_widget_region("utility", array("container", "row inner")); ?>
	</div>
	<!-- TOP END -->

<div class="sticky-menubar"><div class="container"><div class="row inner">
	<?php the_widget( 'I3D_Widget_Logo', I3D_Widget_Logo::getPageInstance($page_id));  ?>
			
	<div class="menu-top">
		<nav class="navbar navbar-default cl-effect-4" role="navigation">
  			<div class="navbar-header">
    			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="menu-toggle">Main Menu</span>
					<span class="fa fa-th-list"></span>
				</button>
			</div>
			<div class='collapse navbar-collapse navbar-ex1-collapse'>
				<?php the_widget( 'I3D_Widget_Menu', array("no_wrapper" => true, "theme_location" => I3D_Framework::getDropDownsMenuID($page_id), "menu_type" => "primary-horizontal"));  ?>
			</div>
		</nav>
	</div>			
</div></div></div>
<!--/STICKY MENUBAR END -->

<div class="feature-boxes"><div class="container"><div class="row inner">
  <?php i3d_show_widget_region("header-lower", array("feature-box-wrapper", "fb-outer-wrapper")); ?>
</div></div></div>
<!--/FEATURE BOXES -->


</div>
<!--/HEADER -->

<div class="section-divider"></div>
<a id="showHere"></a>					
<!-- body content -->
<div class='main-content' id="content-scroller">

<?php i3d_show_widget_region("seo", array("content-wrapper", "container")); ?>
<?php i3d_show_divider_region("divider-1"); ?> 		
<?php i3d_show_widget_region("breadcrumb", array("content-wrapper", "container")); ?>
<?php i3d_show_divider_region("divider-2"); ?> 		
<?php i3d_show_widget_region("advertising", array("content-wrapper", "container")); ?>
<?php i3d_show_divider_region("divider-3"); ?> 		
<?php i3d_show_widget_region("main-top", array("content-wrapper", "container")); ?>
<?php i3d_show_divider_region("divider-4"); ?> 		
<?php i3d_show_widget_region("main", array("content-wrapper",  "container main-content-container"), 'DEFAULT-CONTENT'); ?>
<?php i3d_show_divider_region("divider-5"); ?> 		
<?php i3d_show_widget_region("main-bottom", array("content-wrapper", "section-inner", "container")); ?>
<?php i3d_show_divider_region("divider-6"); ?> 		
<?php i3d_show_widget_region("lower", array("content-wrapper", "section-inner ourteam", "container")); ?>
<?php i3d_show_divider_region("divider-7"); ?> 		
<?php i3d_show_widget_region("bottom", array("content-wrapper", "container")); ?>
</div>

<?php get_footer(); ?>