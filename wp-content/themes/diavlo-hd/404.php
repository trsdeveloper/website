<?php 


I3D_Framework::template_header();

if (I3D_Framework::use_global_layout()) {
	I3D_Framework::render_page_in_layout($page_id);
	return;
} 


?>
<div class="main-wrapper">

<div class="container-wrapper header-top">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
            	 <?php the_widget( 'I3D_Widget_Logo', I3D_Widget_Logo::getPageInstance($page_id));  ?>
            
            </div>
			<div class="col-md-7">
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
			</div>
			<div class="col-md-2 hidden-sm visible-xs">
            	 <?php the_widget( 'I3D_Widget_SearchForm', I3D_Widget_SearchForm::getPageInstance($page_id, array('justification' => 'right', 'use_icon' => true)));  ?>
            
            </div>				

		</div>
	</div>
</div>




<?php i3d_show_widget_region("seo", array("content-wrapper minimized-header-bg", "container"), "seo"); ?> 		




<!-- Main content
================================================== -->

<div class="container-wrapper"> 

	<div class="container text-center padding-bottom-40" id="fourohfour-content">
			
			
               <?php i3d_404_content(); ?>
           
</div>

      
</div>





<!-- Footer 
================================================== -->

<div class="container-wrapper footer-bg">
  <div class="container">
	<div class="footer">
		<footer class="row">

<?php // i3d_show_widget_region("footer", array("container"), "footer"); ?>
<?php //i3d_show_widget_region("copyright", array("container"), "copyright"); ?>

		
		</footer>
    </div>
  </div>
</div>

<?php get_footer(); ?>