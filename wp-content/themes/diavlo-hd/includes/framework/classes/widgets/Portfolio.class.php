<?php

/***********************************/
/**        CONTENT REGION         **/
/***********************************/
class I3D_Widget_Portfolio extends WP_Widget {
	function __construct() {
	//function I3D_Widget_Portfolio() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'Renders a given portfolio', "i3d-framework") );
		parent::__construct('i3d_portfolio', __('i3d:Portfolio', "i3d-framework"), $widget_ops);
	}

	function widget( $args, $instance ) {		
		extract( $args );
		//$before_widget = str_replace("i3d-opt-box-style", $instance['box_style'], $before_widget);
//var_dump($instance);
		echo $before_widget;
		$taxonomy = $instance['taxonomy'];
		if ($taxonomy == "") {
			$taxonomy = "i3d-portfolio";
		}
		$categories = "";
		$categoryStr = "";
		$orderStr = "";
		
		if (is_array(@$instance['categories__'.$taxonomy])) {
			$categories = implode(",", $instance['categories__'.$taxonomy]);
		}
		if ($categories != "") {
			$categoryStr = " categories='{$categories}'";
		}
		if (@$instance['order'] != "") {
		  $orderStr = " order='{$instance['order']}'";
		}
		
		if (@$instance['taxonomy'] == "") {
			if (@$instance['portfolio_style'] == "isotope") {
				echo do_shortcode("[i3d_isotope_portfolio{$categoryStr}{$orderStr}]");
			} else {
				echo do_shortcode("[i3d_default_portfolio{$categoryStr}{$orderStr}]");
			}
		   	
		} else {
				
				echo do_shortcode("[i3d_default_portfolio taxonomy='{$instance['taxonomy']}'{$categoryStr}{$orderStr}]");
			
		}
		echo $after_widget;
	}



	function update( $new_instance, $old_instance ) {
		//var_dump($new_instance);
		return $new_instance;
	}


	function layout_configuration_form( $instance, $defaults, $row_id, $widget_id, $layout_id, $page_level = false ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '', 'taxonomy' => '', 'order' => '', 'portfolio_style' => '', 'categories' => array() ) );
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
			$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"] =   wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '', 'taxonomy' => '', 'order' => '', 'portfolio_style' => '', 'categories' => array() ) );
	        
			
			$layoutID = $layout_id;
	  } else {
		//  global $layoutID;
		  
		  $prefix = "";
		  
	  }
       $rand = rand();
	 $categories = array();
	 
	 		$taxonomies = array("" => __("Portfolio Items", "i3d-framework"), "i3d-team-member-department" => __("Team Members", "i3d-framework"));

	 ?>
	<div class="input-group tt2" title="Post Type" >
  		<span class="input-group-addon detailed-addon"><i class="fa fa-archive fa-fw"></i> <span class='detailed-label'>Post Type</span></span>

		<select class='form-control' id="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__taxonomy" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__taxonomy">
	    <?php 
		// if there is no prefix, then this is the layout manager level
		if ($prefix == "") { 
            
	
		// else, if there is a prefix, then this is the page level configurations
		} else {

			?>
        <option value="*" ><?php _e("-- Layout Default --","i3d-framework"); ?></option>

		<?php } ?>
		 <?php foreach ($taxonomies as $taxonomy => $taxonomyName) { ?>
          <option <?php if (@$instance['taxonomy'] == $taxonomy) { print "selected"; } ?> value="<?php echo $taxonomy; ?>"><?php echo $taxonomyName; ?></option>
        <?php
		if ($taxonomy == "") {
		  $categories["i3d-portfolio"] = get_terms("i3d-portfolio", "hide_empty=1");
		} else {
		  $categories["$taxonomy"] = get_terms($taxonomy, "hide_empty=1");
		}
		
		} ?>
                </select> 
				
				</div>
        <script>
		jQuery("#<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__taxonomy").bind("change", function() {
																															  jQuery(".i3d-portfolio-item-category-<?php echo $rand; ?>").addClass("hidden-block");
																															  jQuery("#i3d-portfolio-item-category-" + jQuery(this).val() + "-<?php echo $rand; ?>").removeClass("hidden-block");
																															  //alert(jQuery(this).val());
																															  });
		</script>
		<?php
		//var_dump($instance);
		foreach ($taxonomies as $taxonomy => $taxonomyName) { 
		      $taxn = ($taxonomy == "" ?  "i3d-portfolio" : $taxonomy);
			  ?>
        <div id="i3d-portfolio-item-category-<?php echo $taxonomy;?>-<?php echo $rand; ?>" class='i3d-portfolio-item-category-<?php echo $rand; ?> <?php if ($taxonomy != $instance['taxonomy']) { print "hidden-block"; } ?>'>
		  <?php if (sizeof($categories["$taxn"]) == 0) { ?>
		  
		  <?php } else { ?>
		  
		<div class="input-group tt2" title="Post Type" >
  			<span class="input-group-addon detailed-addon"><i class="fa fa-list fa-fw"></i> <span class='detailed-label'>Categories</span></span>
			<select class='form-control' multiple size=3 name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__categories__<?php echo $taxn; ?>[]">
        <?php
		
		$txn_cat =  @$instance['categories__'.$taxn];
		//var_dump($txn_cat);
		foreach ($categories["$taxn"] as $category => $categoryObj) { ?>
          <option <?php if (@in_array($categoryObj->term_id, @$txn_cat)) { print "selected"; } ?> value="<?php echo $categoryObj->term_id; ?>"><?php echo $categoryObj->name; ?></option>
        <?php } ?>
		    </select>
		</div>
				<p class="help-block">If none are selected, then all categories will be used.</p>

		  <?php } ?>
		
		</div>
		<?php } ?>
		
		
        <?php if (sizeof(I3D_Framework::$portfolioStyles) > 0) { ?>
		<div class="input-group tt2" title="Post Type" >
  			<span class="input-group-addon detailed-addon"><i class="fa fa-paint-brush fa-fw"></i> <span class='detailed-label'>Portfolio Style</span></span>
		<select class='form-control'  name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__portfolio_style">
	    <?php 
		// if there is no prefix, then this is the layout manager level
		if ($prefix == "") { 
            
	
		// else, if there is a prefix, then this is the page level configurations
		} else {

			?>
        <option value="*" ><?php _e("-- Layout Default --","i3d-framework"); ?></option>

		<?php } ?>
		<?php foreach (I3D_Framework::$portfolioStyles as $portfolioStyle => $porfolioStyleName) { ?>
          <option <?php if (@$instance['portfolio_style'] == $portfolioStyle) { print "selected"; } ?> value="<?php echo $portfolioStyle; ?>"><?php echo $porfolioStyleName; ?></option>
        <?php } ?>
                </select> 
				</div>
                <?php } 
?>
		
		
       
		<div class="input-group tt2" title="Post Type" >
  			<span class="input-group-addon detailed-addon"><i class="fa fa-sort-amount-desc fa-fw"></i> <span class='detailed-label'>Order</span></span>
		
		<select class='form-control' name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__order">
		  <option value="">Most Recent</option>
		  <option <?php if (@$instance['order'] == "alpha") { print "selected"; } ?> value="alpha">Alphabetically</option>
		</select>
		</div>
<?php
	}


	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '', 'taxonomy' => '', 'order' => '', 'portfolio_style' => '', 'categories' => '' ) );
		$taxonomies = array("" => __("Portfolio Items", "i3d-framework"), "i3d-team-member-department" => __("Team Members", "i3d-framework"));
		$rand = rand();
		//var_dump($instance);
?>
<script>
jQuery("a.widget-action").bind("click", function() {
				//shrinkVideoRegion(this);									

});
 
jQuery("a.widget-control-close").bind("click", function() {
				//shrinkVideoRegion(this);									

});
</script><div class='i3d-widget-container'>
    <div class='i3d-help-region'>
    <div class='i3d-help-region-closed'><div class='i3d-help-title-bar'><a target="_blank" href="http://youtu.be/JPKGhJgrbTk"><i class='icon-youtube-play'></i> Watch Help Video &nbsp;  <i  class='icon-external-link'></i></a></div></div>
    </div>
    </div>
	<?php $categories = array(); ?>
    <div class='i3d-widget-main-large'>
        <label class='label-100' for="<?php echo $this->get_field_id('taxonomy'); ?>"><?php _e('Post Type:',"i3d-framework"); ?></label>
		<select id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>">
        <?php foreach ($taxonomies as $taxonomy => $taxonomyName) { ?>
          <option <?php if (@$instance['taxonomy'] == $taxonomy) { print "selected"; } ?> value="<?php echo $taxonomy; ?>"><?php echo $taxonomyName; ?></option>
        <?php
		if ($taxonomy == "") {
		  $categories["i3d-portfolio"] = get_terms("i3d-portfolio", "hide_empty=1");
		} else {
		  $categories["$taxonomy"] = get_terms($taxonomy, "hide_empty=1");
		}
		
		} ?>
                </select> 
        <?php foreach ($taxonomies as $taxonomy => $taxonomyName) { 
	//	var_dump($categories); 
		      $taxn = ($taxonomy == "" ?  "i3d-portfolio" : $taxonomy);
			  ?>
        <div id="i3d-portfolio-item-category-<?php echo $taxn;?>-<?php echo $rand; ?>">
		  <?php if (sizeof($categories["$taxn"]) == 0) { ?>
		  
		  <?php } else { ?>
		  
		   
		<label class='label-100' for="<?php echo $this->get_field_id('categories__'.$taxn); ?>"><?php _e('Categories:',"i3d-framework"); ?></label>
		<p style='margin: 0px; font-size: 8pt;'>If none are selected, then all categories will be used.</p>
			<select multiple size=3 id="<?php echo $this->get_field_id('categories__'.$taxn); ?>" name="<?php echo $this->get_field_name('categories__'.$taxn); ?>[]">
        <?php
		$txn_cat =  @$instance['categories__'.$taxn];
		foreach ($categories["$taxn"] as $category => $categoryObj) { ?>
          <option <?php if (@in_array($categoryObj->term_id, @$txn_cat)) { print "selected"; } ?> value="<?php echo $categoryObj->term_id; ?>"><?php echo $categoryObj->name; ?></option>
        <?php } ?>
		    </select>
		  <?php } ?>
		</div>
		<?php } ?>
		
		
        <?php if (sizeof(I3D_Framework::$portfolioStyles) > 0) { ?>
        <br/>
        <label class='label-100' for="<?php echo $this->get_field_id('portfolio_style'); ?>"><?php _e('Portfolio Style:',"i3d-framework"); ?></label>
		
		<select id="<?php echo $this->get_field_id('portfolio_style'); ?>" name="<?php echo $this->get_field_name('portfolio_style'); ?>">
        <?php foreach (I3D_Framework::$portfolioStyles as $portfolioStyle => $porfolioStyleName) { ?>
          <option <?php if (@$instance['portfolio_style'] == $portfolioStyle) { print "selected"; } ?> value="<?php echo $portfolioStyle; ?>"><?php echo $porfolioStyleName; ?></option>
        <?php } ?>
                </select> 
                <?php } 
?>

        <br/>
        <label class='label-100' for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order:',"i3d-framework"); ?></label>
		
		<select id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
		  <option value="">Most Recent</option>
		  <option <?php if (@$instance['order'] == "alpha") { print "selected"; } ?> value="alpha">Alphabetically</option>
		</select>

</div>
	<?php
    }
}


?>