<?php
function i3d_get_header_tag_content($headerType) {
  global $pageTemplate;
  global $myPageID;
  global $page_id;
  global $onBlog;
  global $postCat;
  global $post;
  
  ob_start();
  if ($headerType == "h1") {
    if (is_search()) {
		$lmTitleValue = __("Search Results", "i3d-framework");
	} else if ($onBlog) {
		
      if ($postCat->taxonomy == "category") {
        $lmTitleValue = $postCat->name;
      } else  {
        $lmTitleValue = $postCat->post_title;
      }
    } else {
     	$lmTitleValue       = get_post_meta($myPageID, 'i3d_page_title', true);
    }
	
	if($lmTitleValue == "") { 
	   if (@$post->post_title == "") {
			echo str_replace(get_bloginfo(), "" ,wp_title('', 0)); 
	   } else {
			echo $post->post_title;   
	   }
	} else { 
		echo $lmTitleValue; 
	}
  } else if ($headerType == "h2") {
    if ($onBlog) {
      if ($postCat->taxonomy == "category") {
        $lmDescriptionValue = $postCat->category_description;
      } else {
        $lmDescriptionValue = "";
      }

    } else {

	 	$lmDescriptionValue = get_post_meta($myPageID, 'i3d_page_description', true);
    }

	 if($lmDescriptionValue == "") { echo ""; } else { echo $lmDescriptionValue; }

  } else {
	  if ($pageTemplate == "primary-accordion-menu") {
		$portfolioImages = get_option("i3d_accordion_menu-{$page_id}");
		if (!is_array($portfolioImages) || sizeof($portfolioImages) == 0) {
		  $portfolioImages = get_option('i3d_accordion_menu');
		}

		$portfolioText = $portfolioImages['text'];


		if ($headerType == "h3") {
		   $h3       = $portfolioText['title'];
		   if ($h3 == "") {
			 echo "";
		   } else {
			 echo $h3;
		   }
		} else if ($headerType == "h4") {
		   $h4 = $portfolioText['text'];
		   if($h4 == "") {
			 echo "";
		   } else {
			 echo $h4;
		   }
		}
	  } else {
		if ($headerType == "h3") {
		   $h3       = get_post_meta($myPageID, 'i3d_optional_title', true);
		   if ($h3 == "") {
			 echo "";
		   } else {
			 echo $h3;
		   }
		} else if ($headerType == "h4") {
		   $h4 = get_post_meta($myPageID, 'i3d_optional_description', true);
		   if($h4 == "") {
			 echo "";
		   } else {
			 echo $h4;
		   }
		}
	  }
  }
  return ob_get_clean();
}
?>