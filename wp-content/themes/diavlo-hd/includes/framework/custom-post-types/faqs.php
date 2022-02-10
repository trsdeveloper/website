<?php

/************************************************** FAQS **************************************************/
if (!function_exists("i3d_include_template_function_faqs")) { 
	register_post_type( 'i3d-faq',
		array(
            	'labels' => array(
                'name' => 'FAQs',
                'singular_name' => 'FAQ',
                'add_new' => 'Add New',
                'add_new_item' => 'Add FAQ',
                'edit' => 'Edit',
                'edit_item' => 'Edit FAQ',
                'new_item' => 'New FAQ',
                'view' => 'View',
                'view_item' => 'View FAQ',
                'search_items' => 'Search FAQs',
                'not_found' => 'No FAQs Found',
                'not_found_in_trash' => 'No FAQs found in Trash',
                'parent' => 'Parent FAQ'
            ),
            'public' => true, 
            'menu_position' => 15,
            'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt'),
            'taxonomies' => array( 'i3d-faq-category' ),
			'rewrite' => array('slug' => 'faq'),
			'show_in_nav_menus' => false,
			'show_in_menu' => false,
						
            'menu_icon' => null,
            'has_archive' => true
        	)
		);
	
	
	register_taxonomy("i3d-faq-category", "i3d-faq", 
						  array("hierarchial" => false, 
								"labels" => array('name' => __("FAQ Categories", "", "i3d-framework"),
												  'signular_name' => __("FAQ Category", "",  "i3d-framework"),
												  'search_items' => __("Search Categories",  "", "i3d-framework"),
												  'all_items' => __("All Categories",   "", "i3d-framework"),
												  'parent_item' => __("Parent Category",  "", "i3d-framework"),
												  'parent_item_colon' => __("Parent Category:",  "", "i3d-framework"),
												  'edit_item' => __("Edit Category",  "", "i3d-framework"),
												  'update_item' => __("Update Category",  "", "i3d-framework"),
												  "add_new_item" => __("Add New FAQ Category",  "", "i3d-framework"),
												  "new_item_name" => __("New Category Name",  "", "i3d-framework"),
												  "menu_name" => __("FAQ Categories",  "", "i3d-framework")
												  ),
								"query_var" => true, 
								"rewrite" => array("slug" => "faqs-category")
								));
	
	function i3d_include_template_function_faqs($template_path) {
    	if ( get_post_type() == 'i3d-faq' ) {
        	if ( is_single() ) {
            	// checks if the file exists in the theme first,
				$theme_file = locate_template( array ( 'template-faqs.php' ));
                $template_path = $theme_file;
        	}
    	}
    	return $template_path;
	}
}

?>