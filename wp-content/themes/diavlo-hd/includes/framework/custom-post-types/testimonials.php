<?php

/************************************************** QUOTATIONS **************************************************/


if (!function_exists("testimonials_contextual_help")) { 
		register_post_type( 'i3d-testimonial',
			array(
				'labels' => array(
					'name' => 'Quotations',
					'singular_name' => 'Quote',
					'add_new' => 'Add New',
					'add_new_item' => 'Add Quote',
					'edit' => 'Edit',
					'edit_item' => 'Edit Quote',
					'new_item' => 'New Quote',
					'view' => 'View',
					'view_item' => 'View Quote',
					'search_items' => 'Search Quotations',
					'not_found' => 'No Quotations Found',
					'not_found_in_trash' => 'No Quotations found in Trash',
					'parent' => 'Parent Quotation'
				),
				'public' => true, 
				'menu_position' => 15,
				'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt'),
				'taxonomies' => array( '' ),
				'rewrite' => array('slug' => 'quote'),
				'show_in_nav_menus' => false,
				'show_in_menu' => false,
							
				'menu_icon' => null,
				'has_archive' => false
			)
		);

	register_taxonomy("i3d-quotation-category", "i3d-testimonial", 
						  array("hierarchial" => false, 
								"labels" => array('name' => _x("Quotation Categories", "Quotation Categories", "i3d-framework"),
												  'signular_name' => _x("Quotation Category", "Quotation Category", "i3d-framework"),
												  'search_items' => __("Search Categories", "Search Categories", "i3d-framework"),
												  'all_items' => __("All Categories", "All Categories", "i3d-framework"),
												  'parent_item' => __("Parent Category", "Parent Category", "i3d-framework"),
												  'parent_item_colon' => __("Parent Category:", "Parent Category", "i3d-framework"),
												  'edit_item' => __("Edit Category", "Edit Category", "i3d-framework"),
												  'update_item' => __("Update Category", "Update Category", "i3d-framework"),
												  "add_new_item" => __("Add New Quotation Category", "Add New Quotation", "i3d-framework"),
												  "new_item_name" => __("New Category Name", "New Category Name", "i3d-framework"),
												  "menu_name" => __("Quotation Categories", "Quotation Categories", "i3d-framework")
												  ),
								"query_var" => true, 
								"rewrite" => array("slug" => "quotation-category")
								));	
function testimonials_contextual_help( $contextual_help, $screen_id, $screen ) { 
//print $screen->id;
	if ( 'edit-i3d-testimonial' == $screen->id ) {

		$contextual_help = '<h2>Testimonials</h2><iframe width="420" height="315" src="//www.youtube.com/embed/YgiJJNuv3jM" frameborder="0" allowfullscreen></iframe>';

	} elseif ( 'i3d-testimonial' == $screen->id ) {

		$contextual_help = '<h2>Testimonials</h2><iframe width="420" height="315" src="//www.youtube.com/embed/YgiJJNuv3jM" frameborder="0" allowfullscreen></iframe>';

	}
	return $contextual_help;
}


function display_testimonials_meta_box( $testimonial ) {
    // Retrieve info based on review ID

	$title    = esc_html( get_post_meta( $testimonial->ID, 'quote_title', true ) );
	$subtitle    = esc_html( get_post_meta( $testimonial->ID, 'quote_subtitle', true ) );
    $authorName   = get_post_meta( $testimonial->ID, 'author_name', true ) ;
    $authorTitle  = get_post_meta( $testimonial->ID, 'author_title', true ) ;
    $authorURL  = get_post_meta( $testimonial->ID, 'author_url', true ) ;
    $authorURLTarget  = get_post_meta( $testimonial->ID, 'author_url_target', true ) ;


		?>
    <table>
      <tr>
            <td style='font-weight: bold'>Quote Title</td>
            <td colspan='3'><input type="text" name="quote_title" value="<?php echo addslashes($title); ?>" style='margin-bottom: 0px;' />
            (overrides the post title)
            </td>
              
              </tr>
      	
		<tr>
            <td style='font-weight: bold'>Quote Subtitle</td>
            <td colspan='3'><input type="text" name="quote_subtitle" value="<?php echo addslashes($subtitle); ?>" style='margin-bottom: 0px;' />
           
            </td>
              
              </tr>
                <tr>
            <td style='font-weight: bold'>Author Name</td>
            <td colspan='3'><input type="text" name="author_name" value="<?php echo addslashes($authorName); ?>" style='margin-bottom: 0px;' /></td>
              
              </tr>
                 <tr>
            <td style='font-weight: bold'>Author Title</td>
            <td colspan='3'><input type="text" name="author_title" value="<?php echo addslashes($authorTitle); ?>" style='margin-bottom: 0px;' /></td>
              
              </tr>
                 <tr>
            <td style='font-weight: bold'>Author Link</td>
            <td colspan='3'><input type="url" name="author_url" value="<?php echo $authorURL; ?>"  style='margin-bottom: 0px;'/></td>
              
              </tr>
                 <tr>
            <td style='font-weight: bold'>Author Link Target &nbsp; &nbsp;</td>
            <td colspan='3'>
              <select name="author_url_target" style='margin-bottom: 0px;'>
                <option value="">Same Window</option>
                <option <?php if ($authorURLTarget == "_blank") { print "selected"; } ?> value="_blank">New Window</option>
              </select>
              
              </tr>
        
       

    </table>
    <?php
}

function testimonials_admin() {
    add_meta_box( 'testimonials_admin_meta_box',
        'Quote Details',
        'display_testimonials_meta_box',
        'i3d-testimonial', 'normal', 'high'
    );
}
add_action( 'admin_init', 'testimonials_admin' );



function add_testimonial_fields( $testimonialID, $testimonial ) {
   
   // Check post type for movie reviews
    if ( $testimonial->post_type == 'i3d-testimonial' ) {
		//var_dump($_POST);
		//exit;
        // Store data in post meta table if present in post data
        //if ( isset( $_POST['flower_meaning_flower_alias'] ) && $_POST['flower_meaning_flower_alias'] != '' ) {
			$_POST = wp_parse_args( (array) $_POST, array( 'quote_title' => '','quote_subtitle' => '','author_name' => '', 'author_title' => '', 'author_url' => '', 'author_url_target' => ''  ) );

            update_post_meta( $testimonialID, 'quote_title', $_POST['quote_title'] );
            update_post_meta( $testimonialID, 'quote_subtitle', $_POST['quote_subtitle'] );
			
            update_post_meta( $testimonialID, 'author_name', $_POST['author_name'] );
            update_post_meta( $testimonialID, 'author_title', $_POST['author_title'] );
            update_post_meta( $testimonialID, 'author_url', $_POST['author_url'] );
            update_post_meta( $testimonialID, 'author_url_target', $_POST['author_url_target'] );

	}
}
add_action( 'save_post', 'add_testimonial_fields', 10, 2 );


add_action( 'contextual_help', 'testimonials_contextual_help', 10, 3 );

function include_template_function_i3d_testimonials( $template_path ) {
    if ( get_post_type() == 'i3d-testimonial' ) {
        if ( is_single() ) {
             if ( is_single() ) {
				if (!I3D_Framework::use_global_layout()) {
				//	print "not using global layout";
			   $theme_file = locate_template( array ( 'single-testimonial.php' ));
              
               $template_path = $theme_file;
				}
        }
        }
    }
    return $template_path;
}

add_filter( 'template_include', 'include_template_function_i3d_testimonials', 1 );
}
?>