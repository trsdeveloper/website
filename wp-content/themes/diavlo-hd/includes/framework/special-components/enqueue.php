<?php

add_action("wp_print_styles", "i3d_enqueue_styles", 100);

function i3d_enqueue_styles() {
	global $wp_styles;
	$my_styles 			= array();
	$google_font_styles = array();
	$googleFonts = array();
	$enable_enqueing = false;
	
	if (!$enable_enqueing) { 
	  return;
	}
	//return;
	foreach ($wp_styles->registered as $style_id => $style_data) {
	  if (strstr($style_id, "aquila-") !== false || strstr($style_id, "bootstrap-") !== false) {
		   if (strstr($style_data->src, "fonts.googleapis.com") !== false) {
				//$google_font_styles["{$style_id}"] = $style_data;
			  $data = explode("fonts.googleapis.com/css?", $style_data->src);
			  
			  parse_str($data[1], $strdata);
			 
			  
			  if ($strdata['family'] != "") {
				  //print "yes";
				  $googleFonts[] = $strdata['family'];
			  }				
				 wp_dequeue_style("{$style_id}");			   
		   } else {
				$my_styles["{$style_id}"] = $style_data;
				 wp_dequeue_style("{$style_id}");		
		   }
		  // wp_dequeue_style("{$style_id}");			   
		   
	  } else if (strstr($style_data->src, "fonts.googleapis.com") !== false) {
			   // $google_font_styles["{$style_id}"] = $style_data;
			   			  $data = explode("fonts.googleapis.com/css?", $style_data->src);
			  
			  parse_str($data[1], $strdata);
			 
			  
			  if ($strdata['family'] != "") {
				 // print "yes";
				  $googleFonts[] = $strdata['family'];
			  }
			   
			   wp_dequeue_style("{$style_id}");
	  }
	}
	// build new string
	//wp_enqueue_style("i3d-theme-extender-enqueue", home_url()."/?i3d-enqueue=css");
	wp_enqueue_style("i3d-theme-extender-enqueue", get_permalink()."?i3d-enqueue=css");

	if (sizeof($googleFonts) > 0 ) {
		//print "yeah";
	 $googleFontURL = "";
	 foreach ($googleFonts as $fontFamily) {
		 if ($googleFontURL != "") {
			 $googleFontURL .= "|";
		 }
		 if ($googleFontURL == "") {
			 $googleFontURL = "//fonts.googleapis.com/css?family=";
		 }
		 $googleFontURL .= str_replace(" ", "+", $fontFamily);
	 }
	 
	 if ($googleFontURL != "") {
		wp_enqueue_style("i3d-theme-extender-google-fonts", $googleFontURL);	
		 
	 }		
	}
	
    if (@$_GET['i3d-enqueue'] == "css") {
		ob_end_clean();
		header("Content-Type: text/css");
		$googleFonts = array();
	 
	 foreach ($google_font_styles as $my_key => $my_style) {

		 if (strstr($my_style->src, home_url()) === false) { 
		 	if (strstr($my_style->src, "fonts.googleapis.com") !== false) {
			//  $data = explode("fonts.googleapis.com/css?", $my_style->src);
			  
			//  parse_str($data[1], $strdata);
			 
			  
			//  if ($strdata['family'] != "") {
				 // print "yes";
			//	  $googleFonts[] = $strdata['family'];
			//  }
			} else {
			 print "@import url('{$my_style->src}');\n";
			}
		  
		 } 
		// print $style_data;
	    // print "\n\n";
	 }


		foreach ($my_styles as $my_key => $my_style) {

		 if (strstr($my_style->src, home_url()) === false) { 
		 	if (strstr($my_style->src, "fonts.googleapis.com") !== false) {
			 // $data = explode("fonts.googleapis.com/css?", $my_style->src);
			  
			 // parse_str($data[1], $strdata);
			 
			  
			 // if ($strdata['family'] != "") {
				 // print "yes";
			//	  $googleFonts[] = $strdata['family'];
			 // }
			} else {
			 print "@import url('{$my_style->src}');\n";
			}
		  
		 } 
		// print $style_data;
	    // print "\n\n";
	 }

		 
	foreach ($my_styles as $my_key => $my_style) {
	
		
		 print "/** {$my_style->handle} **/\n";
		 //print "@import url('{$my_style->src}');\n";
		 if (strstr($my_style->src, home_url()) !== false) { 
		  $style_data = implode("", file($my_style->src));
		// print "found ".home_url()." in ".$my_style->src."\n\n";
		 $path = explode("/", $my_style->src);
		 array_pop($path);
		 array_pop($path);
		 $resolved_url = implode("/", $path)."/";
		// print $resolved_url."\n";
		 $style_data = str_replace("../", $resolved_url, $style_data);
		 } else {
			// print "@import url('{$my_style->src}');\n";
		 }
		 print i3d_minimize_css($style_data);
	    // print "\n\n";
	 }
	//  print "body { background-color: #ffff00; }";
	  exit;
	}
}

function i3d_minimize_css($code) {
	//$code = str_replace("\r", "", $code);
	//$code = str_replace("\n", "", $code);
	//return $code;
		
		$code = preg_replace('/\/\*.*\*\//mi', '', $code);
		
		$code = str_replace("{\r\n", "{", $code);
		$code = str_replace("{ ", "{", $code);
		$code = str_replace("\r\n\r\n}", "}", $code);
		$code = str_replace("\r\n}", "}", $code);
		$code = str_replace(" }", "}", $code);
		$code = str_replace(";\r\n", ";", $code);
		$code = str_replace("; ", ";", $code);
		$code = str_replace(": ", ":", $code);
		$code = str_replace("  ", "", $code);
		$code = str_replace("\t", "", $code);
		$code = str_replace("\r\n\r\n", "\r\n", $code);
		$code = str_replace("\r\n \r\n", "\r\n", $code);
		$code = str_replace("\r", "", $code);
		$code = str_replace("\n", "", $code);
		$code = str_replace(' {', '{', $code);
		$code = str_replace('{ ', '{', $code);
		$code = str_replace(' }', '}', $code);
		$code = str_replace('} ', '}', $code);
		$code = str_replace('; ', ';', $code);
		$code = str_replace(', ', ',', $code);

	//$code = str_replace("*/.", "*/\n", $code);

	return $code;
}
?>
