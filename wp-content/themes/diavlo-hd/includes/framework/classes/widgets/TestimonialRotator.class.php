<?php

/***********************************/
/**        HTML WIDGET BOX        **/
/***********************************/
class I3D_Widget_TestimonialRotator extends WP_Widget {
	function __construct() {
	//function I3D_Widget_TestimonialRotator() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'Renders a set of quotations.', "i3d-framework") );
		parent::__construct('i3d_testimonial_rotator', __('i3d:Quotator', "i3d-framework"), $widget_ops);
	}
    
	function renderRotatorLarge( $args, $instance ) {		
		extract( $args );
		$title = $instance['title'];
		$title = I3D_Framework::conditionFontAwesomeIcon($instance['title']);
		echo $before_widget;
		
		
//echo I3D_Framework::$quotatorVersion."xxxxx";
       //wp_enqueue_script( 'aquila-quotator-modernizr-js',    get_template_directory_uri().'/Library/shared/quotator/js/modernizr.custom.js', array('jquery'), '1.0' );
	  if (I3D_Framework::$quotatorVersion == "2") { 
     	wp_enqueue_script( 'i3d-modernizr-js' );
	    wp_enqueue_script( 'aquila-quotator-js',    get_template_directory_uri().'/Library/components/quotator/js/jquery.quotator.js', array('jquery'), '1.0' );
        wp_enqueue_style( 'aquila-quotator',                get_template_directory_uri().'/Library/components/quotator/css/quotator.css'); 
	  } else if (I3D_Framework::$quotatorVersion == "3") {
     	wp_enqueue_script( 'i3d-modernizr-js' );
	    wp_enqueue_script( 'aquila-quotator-js',    get_template_directory_uri().'/Library/components/quotator/js/jquery.quotator.js', array('jquery'), '1.0' );
	  } else {
     	 wp_enqueue_script( 'i3d-modernizr-js' );
	     wp_enqueue_script( 'aquila-quotator-js',    get_template_directory_uri().'/Library/shared/quotator/js/jquery.quotator.js', array('jquery'), '1.0' );
         wp_enqueue_style( 'aquila-quotator',                get_template_directory_uri().'/Library/shared/quotator/css/quotator.css');  
	  }
		
		$args = array( 'post_type' => 'i3d-testimonial', 'posts_per_page' => $instance['limit'], 'orderby' => 'menu_order', 'order' => 'ASC' );
        if ($instance['category'] != "") {
		  $args["taxonomy"] = "i3d-quotation-category";
		  $args["term"] = $instance['category'];
		}
		//var_dump($args);
		$loop = new WP_Query( $args );


		

		?>
<div class="container-quotator">

	<?php 
	
			if ( !empty( $title ) ) { echo $before_title;
		  if ($instance['vector_icon'] != "") {
			  echo "<i class='";
			  if (strstr($instance['vector_icon'], "fa-")) {
				  echo "fa ";
			  }
			  echo $instance['vector_icon'];
			  echo "'></i> ";
		  }
		echo $title . $after_title; } ?>

			<div class="main-quotator">
				<div id="cbp-qtrotator" class="cbp-qtrotator">
                <?php
				        while ( $loop->have_posts() ) : $loop->the_post();
						  $output = get_the_excerpt();
						  
						  if ($output == "") {
							$output = get_the_content('');
						
						  }
						?>
 					<div class="cbp-qtcontent">
						<blockquote>
						  <p><?php print $output; ?> <i class="icon-quote-right icon-2x pull-right icon-muted"></i>  </p>
						  <small><?php the_title(); ?><cite title="Source Title"></cite></small>
						</blockquote>
					</div>                       
                        
                <?php
				//echo '<div class="entry-content">';
               // the_content();
               // echo '</div>';
        endwhile;
		?>

				</div>
			</div>
		</div>
		<script>
			jQuery( function() {
				jQuery( '#cbp-qtrotator' ).cbpQTRotator({
				
				speed:700, 
				easing: 'ease', 
				interval: <?php echo $instance['delay'] * 1000; ?>}
				
				);
			} );
		</script>
        <?php

		echo $after_widget;
	}

	function renderRotatorSmall( $args, $instance ) {		
		extract( $args );
		$title = $instance['title'];
		$title = I3D_Framework::conditionFontAwesomeIcon($instance['title']);
		
		echo $before_widget;
	
		
    // wp_enqueue_script( 'i3d-modernizr-js' );

	    wp_enqueue_script( 'aquila-quotator-small-js',    get_template_directory_uri().'/Library/components/quote-rotator-small/js/jquery.quovolver.js', array('jquery'), '1.0' );
        // wp_enqueue_style( 'aquila-quotator',                get_template_directory_uri().'/Library/shared/quotator/css/quotator.css');  
		
		$args = array( 'post_type' => 'i3d-testimonial', 'posts_per_page' => $instance['limit'], 'orderby' => 'menu_order', 'order' => 'ASC' );
        if ($instance['category'] != "") {
		  $args["taxonomy"] = "i3d-quotation-category";
		  $args["term"] = $instance['category'];
		}
		//var_dump($args);
		$loop = new WP_Query( $args );


		?>
<div class="container-quotator quotes-rotator-small-wrapper">
    <div class="quotes-rotator-small box-article">
   	 <div class="box-section">
	<?php 
	
			if ( !empty( $title ) ) { echo $before_title;
		  if ($instance['vector_icon'] != "") {
			  echo "<i class='";
			  if (strstr($instance['vector_icon'], "fa-")) {
				  echo "fa ";
			  }
			  echo $instance['vector_icon'];
			  echo "'></i> ";
		  }
		echo $title . $after_title; } ?>

				
                <?php
				        while ( $loop->have_posts() ) : $loop->the_post();
						  $output = get_the_excerpt();
						  
						  if ($output == "") {
							$output = get_the_content('');
						
						  }
						?>            
         <div class="quote-rotator" style="display: none;">
			<p><?php print $output; ?></p>
			<p>&ndash; <?php the_title(); ?></p>
		</div>
                <?php

        endwhile;
		?>

			</div>
		</div>
		</div>
	
	<script type="text/javascript">
        jQuery(document).ready(function() {
                            
            jQuery('.quote-rotator').quovolver(500, <?php echo $instance['delay'] * 1000; ?>);
                            
            });
    </script>        
        <?php
        
		echo $after_widget;
	}


	function renderSlider( $args, $instance ) {		
		extract( $args );
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'title_icon' => '', 'title_tag' => 'h3'  ) );

		$title = __($instance['title'], "i3d-framework");
		$title = I3D_Framework::conditionFontAwesomeIcon($instance['title']);
		
		echo $before_widget;
	
		if (file_exists(get_template_directory()."/Library/components/testimonials-slider/js/modernizr.custom.28468.js")) {
        	//wp_enqueue_script( 'i3d-moderniz-28468-js', get_template_directory_uri().'/Library/components/testimonials-slider/js/modernizr.custom.28468.js', array('jquery'), '1.0');
        	wp_enqueue_script( 'i3d-modernizr-js'); // should be 28468
	
	    	wp_enqueue_script( 'aquila-quotator-slider-js',    get_template_directory_uri().'/Library/components/testimonials-slider/js/jquery.testimonials.slider.js', array('jquery'), '1.0' );
        	if (I3D_Framework::$quotatorVersion != "3") {
				wp_enqueue_style( 'aquila-quotator-slider',                get_template_directory_uri().'/Library/components/testimonials-slider/css/testimonials-slider.css');  
			}
		} else {
			
		}
//		wp_enqueue_style( 'aquila-quotator-slider',                get_template_directory_uri().'/Library/components/testimonials-slider/css/testimonials-slider.css');  
		
		$args = array( 'post_type' => 'i3d-testimonial', 'posts_per_page' => $instance['limit'], 'orderby' => 'menu_order', 'order' => 'ASC' );
        if ($instance['category'] != "") {
		  $args["taxonomy"] = "i3d-quotation-category";
		  $args["term"] = $instance['category'];
		}
		//var_dump($args);
		$loop = new WP_Query( $args );

       // $before_title = "<h2>";
		//$after_title = "</h2>";
		
        if (I3D_Framework::$quotatorVersion == 5) {
				
			if ( !empty( $title ) ) { echo $before_title;
		  if ($instance['vector_icon'] != "") {
			  echo "<i class='";
			  if (strstr($instance['vector_icon'], "fa-")) {
				  echo "fa ";
			  }
			  echo $instance['vector_icon'];
			  echo "'></i> ";
		  }
		echo $title . $after_title; } ?>
			

			
			
			<div class="bootstrap-quotes">
				<div class="container">
					<div id="bs-quotes" class="bs-quotes carousel slide" data-ride="carousel">
						<div class="carousel-inner wow flipInX">	
<?php
$isFirst = true;
$quoteCount = 0;
 						while ( $loop->have_posts() ) : $loop->the_post();
						$quoteCount++;
						  $output = get_the_excerpt();
						  $title = get_the_title();
						  $quoteID = get_the_ID();
						  
						  $quoteTitle        = get_post_meta( $quoteID, 'quote_title', true );
						 
						  $authorName   = get_post_meta( $quoteID, 'author_name', true ) ;
						  $authorTitle  = get_post_meta( $quoteID, 'author_title', true ) ;
						  $authorURL  = get_post_meta( $quoteID, 'author_url', true ) ;
						  $authorURLTarget  = get_post_meta( $quoteID, 'author_url_target', true ) ;
						  if ($quoteTitle == "") {
							  $quoteTitle = $title;
						  }
						  if ($output == "") {
							$output = get_the_content('');
						
						  }						?>
				<div class="item <?php if ($isFirst) { echo "active"; } ?>">
					<div class="bs-quote">										   
						<h3><?php echo $quoteTitle; ?></h3>
						<p><?php print $output; ?></p>
						<a <?php if ($authorURL != "" && $authorURLTarget != "") { print "target='{$authorURLTarget}' "; } else { print $authorURL; } ?> class="testimonials-link" href="<?php if ($authorURL == "") { print "#"; } else { print $authorURL; } ?>">
						<?php
						if (has_post_thumbnail()) {
									the_post_thumbnail('full', array('class' => "testimonial-slider-avatar"));
						} else if (I3D_Framework::$quotatorVersion == "3") {
						$themeRoot 			= get_stylesheet_directory_uri();
						$themeStyle 		= I3D_Framework::getThemeStyle();
						$themeStyleColor 	= I3D_Framework::getThemeStyleColor();
					
							?><img src='<?php echo "{$themeRoot}/Site/theme/{$themeStyle}/{$themeStyleColor}/graphics/quotator-avatar-placeholder.png"; ?>' alt='' class='testimonial-slider-avatar quotator-avatar-placeholder' /><?php
						}
						if ($authorName != "") {
							print "<strong>".$authorName."</strong>";
							if ($authorTitle != "") {
								print " | ".$authorTitle;
							}
						} else {
							print $title;
						}?></a>
					</div>
					</div>
                   <?php
				//echo '<div class="entry-content">';
               // the_content();
               // echo '</div>';
			   $isFirst = false;
        endwhile;
		?>						
						</div>
						
						<?php if (I3D_Framework::$showQuotatorIndicators) { ?>
			<a class="left carousel-control hidden-xs" data-slide="prev" href="#bs-quotes" role="button">
			<i class="fa fa-arrow-circle-left fa-3x"></i></a>
			<a class="right carousel-control hidden-xs" data-slide="next" href="#bs-quotes" role="button">
			<i class="fa fa-arrow-circle-right fa-3x"></i></a>


			<ol class="carousel-indicators">
				<li class="active" data-slide-to="0" data-target="#bs-quotes"></li>
				<?php for ($i = 1; $i < $quoteCount; $i++) { ?>
				<li data-slide-to="<?php echo $i; ?>" data-target="#bs-quotes"></li>
				<?php } ?>
			</ol>						
						<?php } ?>
					</div>
				</div>
			</div>
	<?php
			
		} else {		
		?><div class="testimonials-slider-wrapper"><?php 
	
			if ( !empty( $title ) ) { 
					echo str_replace("h3", $instance['title_tag'], $before_title);

		  if ($instance['title_icon'] != "") {
			  echo "<i class='";
			  if (strstr($instance['title_icon'], "fa-")) {
				  echo "fa ";
			  }
			  echo $instance['title_icon'];
			  echo "'></i> ";
		  }
		echo $title;
		
		echo str_replace("h3", $instance['title_tag'], $after_title);

		
		} ?><div class="testimonials-slider-inner-wrapper"><div id="testimonials-slider" class="testimonials-slider"> <?php
				        while ( $loop->have_posts() ) : $loop->the_post();
						  $output = get_the_excerpt();
						  $title = get_the_title();
						  $quoteID = get_the_ID();
						  
						  $quoteTitle        = get_post_meta( $quoteID, 'quote_title', true );
						 
						  $authorName   = get_post_meta( $quoteID, 'author_name', true ) ;
						  $authorTitle  = get_post_meta( $quoteID, 'author_title', true ) ;
						  $authorURL  = get_post_meta( $quoteID, 'author_url', true ) ;
						  $authorURLTarget  = get_post_meta( $quoteID, 'author_url_target', true ) ;
						  if ($quoteTitle == "") {
							  $quoteTitle = $title;
						  }
						  if ($output == "") {
							$output = get_the_content('');
						
						  }
						?><div class="testimonials-slide"><h2><?php echo $quoteTitle; ?></h2><p><?php print $output; ?></p><a <?php if ($authorURL != "" && $authorURLTarget != "") { print "target='{$authorURLTarget}' "; } else { print $authorURL; } ?> class="testimonials-link" href="<?php if ($authorURL == "") { print "#"; } else { print $authorURL; } ?>"><?php
	if (has_post_thumbnail()) {
			    the_post_thumbnail('full', array('class' => "testimonial-slider-avatar"));
	} else if (I3D_Framework::$quotatorVersion == "3") {
	$themeRoot 			= get_stylesheet_directory_uri();
	$themeStyle 		= I3D_Framework::getThemeStyle();
	$themeStyleColor 	= I3D_Framework::getThemeStyleColor();

		?><img src='<?php echo "{$themeRoot}/Site/theme/{$themeStyle}/{$themeStyleColor}/graphics/quotator-avatar-placeholder.png"; ?>' alt='' class='testimonial-slider-avatar quotator-avatar-placeholder' /><?php
	}
    if ($authorName != "") {
		print "<strong>".$authorName."</strong>";
		if ($authorTitle != "") {
			print " | ".$authorTitle;
		}
	} else {
		print $title;
	}?></a></div><?php

        endwhile;
		?><div class="testimonials-arrows"><span class="testimonials-arrows-prev"></span><span class="testimonials-arrows-next"></span></div></div></div></div>
<script type="text/javascript">
jQuery(window).bind("load", function() {
	jQuery('#testimonials-slider').testimonialsslider({
		current		: 0, 	<?php // index of current slide ?>
		bgincrement	: 450,	<?php // increment the bg position (parallax effect) when sliding ?>
		autoplay	: true, <?php // slideshow on / off ?>
		interval	: <?php echo $instance['delay'] * 1000;   // time between transitions ?>
	});
});
</script>	          
<?php
		}
		echo $after_widget;
	}

	
	
	function renderCarousel1( $args, $instance ) {
				extract( $args );

		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'title_icon' => '', 'title_tag' => 'h3'  ) );

		$title = __($instance['title'], "i3d-framework");
		$title = I3D_Framework::conditionFontAwesomeIcon($instance['title']);
		
		echo $before_widget;
	
		
		$args = array( 'post_type' => 'i3d-testimonial', 'posts_per_page' => $instance['limit'], 'orderby' => 'menu_order', 'order' => 'ASC' );
        
		if ($instance['category'] != "") {
		  $args["taxonomy"] = "i3d-quotation-category";
		  $args["term"] = $instance['category'];
		}
		$loop = new WP_Query( $args );

		

				
		if ( !empty( $title ) ) { 
		  echo $before_title;
		  if ($instance['vector_icon'] != "") {
			  echo "<i class='";
			  if (strstr($instance['vector_icon'], "fa-")) {
				  echo "fa ";
			  }
			  echo $instance['vector_icon'];
			  echo "'></i> ";
		  }
		echo $title . $after_title; 
		}
?>
<div id="bs-testimonials" class="bs-animate carousel slide" data-interval="25000">
 <!-- Indicators -->
        <ol class="carousel-indicators">
<?php

		$isFirst = true;
		$slideCount = 0;
 						while ( $loop->have_posts() ) {
							$loop->the_post();
						 				?>
		
				 <li data-target="#bs-testimonials" data-slide-to="<?php echo $slideCount; ?>" class="<?php if ($isFirst) { echo "active"; } ?>"></li>
				 <?php
				 $slideCount++;
				 $isFirst = false;
		}
?>

        </ol>
        <!-- Indicators -->


        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
<?php
rewind_posts(); 
		$isFirst = true;
		$slideCount = 0;
 						while ( $loop->have_posts() ) {
							$loop->the_post();
						$slideCount++;
						  $output = get_the_excerpt();
						  $title = get_the_title();
						  $quoteID = get_the_ID();
						  
						  $quoteTitle        = get_post_meta( $quoteID, 'quote_title', true );
						 
						  $authorName   = get_post_meta( $quoteID, 'author_name', true ) ;
						  $authorTitle  = get_post_meta( $quoteID, 'author_title', true ) ;
						  $authorURL  = get_post_meta( $quoteID, 'author_url', true ) ;
						  $authorURLTarget  = get_post_meta( $quoteID, 'author_url_target', true ) ;
						  if ($quoteTitle == "") {
							  $quoteTitle = $title;
						  }
						  if ($output == "") {
							$output = get_the_content('');
						
						  }					?>
            <!-- slide -->
            <div class="item <?php if ($isFirst) { echo "active"; } ?> bs-testimonials-slide<?php echo $slideCount; ?>">
            <?php if (I3D_Framework::$quotatorVersion == "6") { ?>
            	<div class="slidedivide"><?php echo $quoteTitle; ?></div>
            <?php } ?>
                <div class="carousel-caption">
                    <h2 data-animation="animated bounceInRight">
                    <?php echo $output; ?>
                    </h2>

      
					
 <?php
	if (has_post_thumbnail()) {
		?>
		
		<div class="icon-div icon-div-img-color" data-animation="animated bounceInLeft"><span>
		
		<?php
			    the_post_thumbnail('thumbnail', array('class' => "testimonial-carousel-avatar"));
				?></span></div><?php 
	} else {

		?>
		         <div class="icon-div icon-div-color" data-animation="animated bounceInLeft">
                        <span>
                            <i class="fa fa-quote-left fa-2x"></i>
                        </span>
                    </div>
		<?php
	}
	?>
	<a <?php if ($authorURL != "" && $authorURLTarget != "") { print "target='{$authorURLTarget}' "; } else { print $authorURL; } ?> class="btn btn-testimonials"  data-animation="animated zoomInUp" href="<?php if ($authorURL == "") { print "#"; } else { print $authorURL; } ?>">
	<?php
    if ($authorName != "") {
		print "<strong>".$authorName."</strong>";
		if ($authorTitle != "") {
			print " | ".$authorTitle;
		}
	} else {
		print $title;
	}?></a>					
                </div>
            </div>
            <!-- slide -->
<?php 
$isFirst = false;

} ?>

        </div>
        <!-- /.carousel-inner -->
        <!-- Controls -->
        <a class="left carousel-control" href="#bs-testimonials" role="button" data-slide="prev">
            <span>
                <img alt="previous" src="<?php echo get_stylesheet_directory_uri(); ?>/Site/graphics/car-arrow-prev.png"> </span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#bs-testimonials" role="button" data-slide="next">
            <span>
                <img alt="next" src="<?php echo get_stylesheet_directory_uri(); ?>/Site/graphics/car-arrow-next.png"> </span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <!-- /.carousel -->


<?php
	}

	function renderCarousel2( $args, $instance ) {
				extract( $args );

		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'title_icon' => '', 'title_tag' => 'h3'  ) );

		$title = __($instance['title'], "i3d-framework");
		$title = I3D_Framework::conditionFontAwesomeIcon($instance['title']);
		
		echo $before_widget;
	
		
		$args = array( 'post_type' => 'i3d-testimonial', 'posts_per_page' => $instance['limit'], 'orderby' => 'menu_order', 'order' => 'ASC' );
        
		if ($instance['category'] != "") {
		  $args["taxonomy"] = "i3d-quotation-category";
		  $args["term"] = $instance['category'];
		}
		$loop = new WP_Query( $args );

		

				
		if ( !empty( $title ) ) { 
		  echo $before_title;
		  if ($instance['vector_icon'] != "") {
			  echo "<i class='";
			  if (strstr($instance['vector_icon'], "fa-")) {
				  echo "fa ";
			  }
			  echo $instance['vector_icon'];
			  echo "'></i> ";
		  }
		echo $title . $after_title; 
		}
?>
    <div id="bs-quotes" class="bs-animate carousel slide" data-interval="20000">



        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
<?php
rewind_posts(); 
		$isFirst = true;
		$slideCount = 0;
 						while ( $loop->have_posts() ) {
						  $loop->the_post();
						  $slideCount++;
						  $output = get_the_excerpt();
						  $title = get_the_title();
						  $quoteID = get_the_ID();
						  
						  $quoteTitle        = get_post_meta( $quoteID, 'quote_title', true );
						  $subTitle        = get_post_meta( $quoteID, 'quote_subtitle', true );
						 
						  $authorName   = get_post_meta( $quoteID, 'author_name', true ) ;
						  $authorTitle  = get_post_meta( $quoteID, 'author_title', true ) ;
						  $authorURL  = get_post_meta( $quoteID, 'author_url', true ) ;
						  $authorURLTarget  = get_post_meta( $quoteID, 'author_url_target', true ) ;
						  if ($quoteTitle == "") {
							  $quoteTitle = $title;
						  }
						  if ($output == "") {
							$output = get_the_content('');
						
						  }					?>
            <!-- slide -->
            <div class="item <?php if ($isFirst) { echo "active"; } ?> bs-testimonials-slide<?php echo $slideCount; ?>">
         <?php if (I3D_Framework::$quotatorVersion == "6") { ?>
            	<div class="slidedivide"><?php echo $quoteTitle; ?></div>
            <?php } ?>
                <div class="carousel-caption">
				
                    <h2 data-animation="animated bounceInLeft">
                    <?php echo @$quoteTitle; ?>
                    </h2>
					
                    <h3 data-animation="animated bounceInRight">
                    <?php echo @$subTitle; ?>
                    </h3>

      <p class="lead" data-animation="animated zoomInUp">
                        <?php echo @$output; ?>
                    </p>
					
 <?php
	if (has_post_thumbnail()) {
		?>
                    <a <?php if ($authorURL != "" && $authorURLTarget != "") { print "target='{$authorURLTarget}' "; } else { print $authorURL; } ?> class="btn-quotes" data-animation="animated zoomInUp" href="<?php if ($authorURL == "") { print "#"; } else { print $authorURL; } ?>">
                        <span>
                           <?php
			    the_post_thumbnail('thumbnail', array('class' => "testimonial-carousel-avatar"));
				?>
                        </span>
                    </a>		
		<?php 
	} else {

		?>
		

                    <a <?php if ($authorURL != "" && $authorURLTarget != "") { print "target='{$authorURLTarget}' "; } else { print $authorURL; } ?> class="btn-quotes" data-animation="animated zoomInUp" href="<?php if ($authorURL == "") { print "#"; } else { print $authorURL; } ?>">
                        
						<span class="fa-stack fa-3x">
  <i class="fa fa-circle fa-stack-2x fa-inverse"></i>
  <i class="fa fa-sun-o fa-stack-1x"></i>
</span>
                    
                    </a>
            	

		<?php
	}
	?>
	<h4 data-animation="animated zoomInUp" data-animation="animated zoomInUp" >
	<?php
    if ($authorName != "") {
		print "<strong>".$authorName."</strong>";
		if ($authorTitle != "") {
			print " | ".$authorTitle;
		}
	} else {
		print $title;
	}?></h4>					
                </div>
            </div>
            <!-- slide -->
<?php 
$isFirst = false;

} ?>

        </div>
        <!-- /.carousel-inner -->
        <!-- Controls -->
        <a class="left carousel-control" href="#bs-quotes" role="button" data-slide="prev">
            <span>
                <img alt="previous" src="<?php echo get_stylesheet_directory_uri(); ?>/Site/graphics/car-arrow-prev.png"> </span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#bs-quotes" role="button" data-slide="next">
            <span>
                <img alt="next" src="<?php echo get_stylesheet_directory_uri(); ?>/Site/graphics/car-arrow-next.png"> </span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <!-- /.carousel -->

<?php		
	}

	function widget( $args, $instance ) {		
		extract( $args );
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
//		$title = I3D_Framework::conditionFontAwesomeIcon($instance['title']);
		//var_dump($instance);
		if (I3D_Framework::$quotatorVersion == "6" || I3D_Framework::$quotatorVersion == "7") {
				 if ($instance['style'] == "carousel-2") {
					$this->renderCarousel2($args, $instance);
				 } else {
			
			
					 $this->renderCarousel1($args, $instance);
					   
				  } 
		} else {
			if ($instance['style'] == "rotator-small") {
				$this->renderRotatorSmall($args, $instance);
			} else if ($instance['style'] == "slider") {
				$this->renderSlider($args, $instance);
			} else {
		
				$this->renderRotatorLarge($args, $instance);
				  
			}
		}
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'] ;
		$instance['title_tag'] = $new_instance['title_tag'] ;
		$instance['title_icon'] = $new_instance['title_icon'] ;
		$instance['style'] = $new_instance['style'] ;
		$instance['delay'] = $new_instance['delay'] ;
        $instance['category'] = $new_instance['category'];
        $instance['limit'] = $new_instance['limit'];
        $instance['justification'] = $new_instance['justification'];
		return $instance;
	}

/*
	function layout_configuration_form( $instance, $defaults, $row_id, $widget_id, $layout_id, $page_level = false ) {
		$instance = wp_parse_args( (array) $instance, array( 'delay' => '8', 'limit' => '5', 'title_tag' => '', 'title_icon' => '', 'title' => '', 'style' => '', 'category' => '' ) );
	  global $post;

	  $layouts = get_option('i3d_layouts');
	  if ($page_level) {
		 
		  $prefix = "__i3d_layouts__{$layout_id}__";
			$page_layouts 		= (array)get_post_meta($post->ID, "layouts", true);
			if (!array_key_exists($layout_id, $page_layouts)) {
				$page_layouts["{$layout_id}"] = array();
			}
			if (!array_key_exists($row_id, $page_layouts["{$layout_id}"])) {
				$page_layouts["{$layout_id}"]["{$row_id}"] = array();
			}
			if (!array_key_exists("configuration", $page_layouts["{$layout_id}"]["{$row_id}"])) {
				$page_layouts["{$layout_id}"]["{$row_id}"]["configuration"] = array();
			}
			if (!array_key_exists($widget_id, $page_layouts["{$layout_id}"]["{$row_id}"]["configuration"])) {
				$page_layouts["{$layout_id}"]["{$row_id}"]["configuration"]["$widget_id"] = array();
			}			
			$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"] =  wp_parse_args( (array) @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"], 
																									array( 'delay' => '8', 'limit' => '5', 'title_tag' => '', 'title_icon' => '', 'title' => '', 'style' => '', 'category' => '' )  );
	        
	        $delay 	= @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["delay"];
	        $limit 	= @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["limit"];
	        $title_tag 	= @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["title_tag"];
	        $title_icon 	= @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["title_icon"];
	        $title 	= @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["title"];
	        $style 	= @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["style"];
	        $category 	= @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["category"];
			
			$layoutID = $layout_id;
	  } else {
		//  global $layoutID;
		  
		  $prefix = "";
		  
	  }
?>
	<div class="input-group tt2" title="Choose Title Tag" >
  		<span class="input-group-addon detailed-addon"><i class="fa fa-header fa-fw"></i> <span class='detailed-label'>Title</span></span>
		<select class='form-control' name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__title_tag">
	    <?php 
		// if there is no prefix, then this is the layout manager level
		if ($prefix == "") { 
            
		// else, if there is a prefix, then this is the page level configurations
		} else {	?>
        <option value="*" ><?php _e("-- Layout Default --","i3d-framework"); ?></option>

		<?php } ?>

          <option value="h1">H1</option>
          <option <?php if ($instance['title_tag'] == "h2") { print "selected"; } ?> value="h2">H2</option>
          <option <?php if ($instance['title_tag'] == "h3" || $instance['title_tag'] == "") { print "selected"; } ?> value="h3">H3</option>
          <option <?php if ($instance['title_tag'] == "h4") { print "selected"; } ?> value="h4">H4</option>
          <option <?php if ($instance['title_tag'] == "h5") { print "selected"; } ?> value="h5">H5</option>
        </select>
	</div>
		
		<?php I3D_Framework::renderFontAwesomeSelect($prefix.$row_id."__configuration__".$widget_id."__title_icon", @$instance['title_icon'], false, __('-- No Icon --', "i3d-framework")); ?>
        
		<input class='form-control' name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__title" type="text" value="<?php echo stripslashes($title); ?>" />
				
				

<?php if (I3D_Framework::$quotatorVersion >= 2) { ?>
 	<div class="input-group tt2" title="Choose Quotator Style" >
  		<span class="input-group-addon detailed-addon"><i class="fa fa-paint-brush fa-fw"></i> <span class='detailed-label'>Style</span></span>
		<select class='form-control' name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__style">
	    <?php 
		// if there is no prefix, then this is the layout manager level
		if ($prefix == "") { 
            
		// else, if there is a prefix, then this is the page level configurations
		} else {	?>
        <option value="*" ><?php _e("-- Layout Default --","i3d-framework"); ?></option>

		<?php } ?>
		
		          <option value="">Rotator Large</option>
                  <option <?php if ($instance['style'] == "rotator-small") { echo "selected"; } ?> value="rotator-small">Rotator Small</option>
                  <option <?php if ($instance['style'] == "slider") { echo "selected"; } ?> value="slider">Slider</option>
          </select>
	</div>
<?php } ?>
 	<div class="input-group tt2" title="Choose Category" >
  		<span class="input-group-addon detailed-addon"><i class="fa fa-list fa-fw"></i> <span class='detailed-label'>Category</span></span>
		<select class='form-control' name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__category">
	    <?php 
		// if there is no prefix, then this is the layout manager level
		if ($prefix == "") { 
            
		// else, if there is a prefix, then this is the page level configurations
		} else {	?>
        <option value="*" ><?php _e("-- Layout Default --","i3d-framework"); ?></option>

		<?php } ?>
                  <option value="">-- <?php _e('Display All',"i3d-framework"); ?> --</option>
	  <?php
	    $categories = get_categories(array('type' => 'i3d-testimonial', 'taxonomy' => 'i3d-quotation-category'));
		//var_dump($categories);
		if (is_array($categories)) {
		foreach ($categories as $category) {
			$option = '<option ';
			if ($category->name == $instance['category']) {
				$option .= "selected=selected ";
			}
			$option .= ' value="'.$category->name.'">';
			$option .= $category->cat_name;
			$option .= ' ('.$category->category_count.')';
			$option .= '</option>';
			echo $option;
		  }
		}
		  ?>
          </select>
	  
</div>

 	<div class="input-group tt2" title="Choose Delay" >
  		<span class="input-group-addon detailed-addon"><i class="fa fa-clock-o fa-fw"></i> <span class='detailed-label'>Delay</span></span>

                <input class='form-control' name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__delay" type="number" value="<?php echo stripslashes($delay); ?>" /> <span style='display: inline'>seconds</span>
	</div>
         		
 	<div class="input-group tt2" title="Choose Delay" >
  		<span class="input-group-addon detailed-addon"><i class="fa fa-exclamation-circle fa-fw"></i> <span class='detailed-label'>Max Items</span></span>
                <input class='form-control' name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__limit"  type="number" value="<?php echo stripslashes($limit); ?>" />
				</div>

        <?php
	}
	
*/

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'delay' => '8', 'limit' => '5', 'title_tag' => '', 'title_icon' => '', 'title' => '', 'style' => '', 'category' => '' ) );
				$delay = $instance['delay'];
				$limit = $instance['limit'];
				$title = $instance['title'];

		?>
        
        <script>

jQuery("a.widget-action").bind("click", function() {
				//shrinkVideoRegion(this);									

});
 
jQuery("a.widget-control-close").bind("click", function() {
			//	shrinkVideoRegion(this);									

});
</script>

<div class='i3d-widget-container'>
    <div class='i3d-help-region'>
    <div class='i3d-help-region-closed'><div class='i3d-help-title-bar'><a target="_blank" href="http://www.youtube.com/watch?v=YgiJJNuv3jM"><i class='icon-youtube-play'></i> Watch Help Video &nbsp;  <i  class='icon-external-link'></i></a></div></div>

    </div>
<div>
<div class='i3d-widget-main-large'>
        		<label class='label-regular' for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title',"i3d-framework"); ?></label>
		<select style='display: inline-block' class='input-mini'  id="<?php echo $this->get_field_id('title_tag'); ?>" name="<?php echo $this->get_field_name('title_tag'); ?>">
          <option value="h1">H1</option>
          <option <?php if ($instance['title_tag'] == "h2") { print "selected"; } ?> value="h2">H2</option>
          <option <?php if ($instance['title_tag'] == "h3" || $instance['title_tag'] == "") { print "selected"; } ?> value="h3">H3</option>
          <option <?php if ($instance['title_tag'] == "h4") { print "selected"; } ?> value="h4">H4</option>
          <option <?php if ($instance['title_tag'] == "h5") { print "selected"; } ?> value="h5">H5</option>
        </select>
		
		<?php I3D_Framework::renderFontAwesomeSelect($this->get_field_name('title_icon'), @$instance['title_icon'], false, __('-- No Icon --', "i3d-framework")); ?>
                <input  id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo stripslashes($title); ?>" />
				
				<br/>

<?php if (I3D_Framework::$quotatorVersion >= 2) { ?>
        		<p><label class='label-75' for="<?php echo $this->get_field_id('style'); ?>"><?php _e('Style:',"i3d-framework"); ?></label>
                <select id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>">
                  <?php if (I3D_Framework::$quotatorVersion == 6) { ?>
				  <option value="">Carousel 1</option>
                  <option <?php if ($instance['style'] == "carousel-2") { echo "selected"; } ?> value="carousel-2">Carousel 2</option>  
				  <?php } else { ?>
				  <option value="">Rotator Large</option>
                  <option <?php if ($instance['style'] == "rotator-small") { echo "selected"; } ?> value="rotator-small">Rotator Small</option>
                  <option <?php if ($instance['style'] == "slider") { echo "selected"; } ?> value="slider">Slider</option>
				  <?php } ?>
          </select>
	  
</p>

<?php } ?>

        		<p><label class='label-75' for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category:',"i3d-framework"); ?></label>
                <select  id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">
                  <option value="">-- <?php _e('Display All',"i3d-framework"); ?> --</option>
	  <?php
	    $categories = get_categories(array('type' => 'i3d-testimonial', 'taxonomy' => 'i3d-quotation-category'));
		//var_dump($categories);
		if (is_array($categories)) {
		foreach ($categories as $category) {
			$option = '<option ';
			if ($category->name == $instance['category']) {
				$option .= "selected=selected ";
			}
			$option .= ' value="'.$category->name.'">';
			$option .= $category->cat_name;
			$option .= ' ('.$category->category_count.')';
			$option .= '</option>';
			echo $option;
		  }
		}
		  ?>
          </select>
	  
</p>
        		<div class='widget-column-50'>
				<label class='label-165' for="<?php echo $this->get_field_id('delay'); ?>"><?php _e('Delay',"i3d-framework"); ?></label>
                <input class='input-mini' style="display: inline" id="<?php echo $this->get_field_id('delay'); ?>" name="<?php echo $this->get_field_name('delay'); ?>" type="number" value="<?php echo stripslashes($delay); ?>" /> <span style='display: inline'>seconds</span>
				</div>
         		
                <div class='widget-column-50'>
				<label class='label-165' for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('Max Items To Display',"i3d-framework"); ?></label>
                <input class='input-mini' id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="number" value="<?php echo stripslashes($limit); ?>" />
				</div>
   </div>
   </div>
</div>
<?php


	}
}


?>