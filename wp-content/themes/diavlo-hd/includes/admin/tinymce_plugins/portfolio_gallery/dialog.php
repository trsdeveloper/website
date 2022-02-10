<?php
//require_once( dirname( __FILE__ ) . '/admin.php' );
$wp_include = "../../../wp-load.php";
$i = 0;

while (!file_exists($wp_include) && $i++ < 10) {
  $wp_include = "../".$wp_include;
}

//load wordpress info
require($wp_include);

//remove double quotes around values and replace spaces between key/value pairs with '&'
$pattern = '/(.*?)="(.*?)"[\s]?/i';
$replacement = '&${1}=${2}';

//apply REGEX and parse string into an array like a GET string is
parse_str(str_replace('&#34;', '"', substr(preg_replace($pattern, $replacement, substr(stripslashes(@$_GET['properties']),22)),1)), $properties);
$pages = get_pages();
$pageOptions = "";

foreach ($pages as $page) {
	$pageOptions .= '<option value="'.$page->ID.'"'.(@$properties['redirect_to'] == $page->ID ? ' selected="selected"' : '').'>';
	$pageOptions .= $page->post_title;
	$pageOptions .= '</option>';
}	

//var_dump($properties);
wp_enqueue_script('jquery'); 
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link rel='stylesheet' href='<?php echo get_option("siteurl") ?>/wp-admin/load-styles.php?c=1&amp;dir=ltr&amp;load=global,buttons,wp-admin&amp;ver=3.0' type='text/css' media='all' />
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/jquery/jquery.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/jquery/jquery-migrate.js"></script>
	<?php //include( ABSPATH . 'wp-admin/admin-header.php' );?>
	<script>
	function add_content_to_display(buttonClicked) {
		//var returnStr = '[contact send_to="'+document.getElementById("lm_email_address").value+'" redirect_to="'+document.getElementById("lm_redirect_to").value+'" name_label="'+document.getElementById("lm_name_label").value+'" phone_label="'+document.getElementById("lm_phone_label").value+'" email_label="'+document.getElementById("lm_email_label").value+'" message_heading="'+document.getElementById("lm_message_heading").value+'" contact_info_heading="'+document.getElementById("lm_contact_info_heading").value+'" submit_label="'+document.getElementById("lm_submit_label").value+'"]';
		/*
		var checkedButton = getCheckedRadio(buttonClicked.form['i3d_cta_id']);
		var ctaID = checkedButton.value;
		*/
		var taxonomy = jQuery("#taxonomy").val();
		var taxn = taxonomy;
		if (taxn == "") {
			taxn = "i3d-portfolio";
		}
		var categories = "";
		if (jQuery("#categories__" + taxn).val()) {
			
		   categories = jQuery("#categories__" + taxn).val();
		}
		var order = jQuery("#order").val();
		var aspect_ratio = jQuery("#aspect_ratio").val();
		
		//alert(categories);
		var returnStr = '<img  src="<?php echo $_GET['url']; ?>/images/t.gif" class="i3d_portfolio_gallery mceItem" title="i3d_portfolio_gallery'+tinymce.DOM.encode(' taxonomy="'+taxonomy+'" order="'+order+'" categories="'+categories+'" aspect_ratio="'+aspect_ratio+'"') + '" data-mce-resize="false" data-mce-placeholder="1" />';
	  /* get the TinyMCE version to account for API diffs */
    var tmce_ver=window.tinyMCE.majorVersion;

		if (tmce_ver>="4") {

		//	window.tinyMCE.execCommand('mceRemoveNode', false, "");
			window.tinyMCE.execCommand('mceInsertContent', false, returnStr);
		} else {
			window.tinyMCE.execInstanceCommand('<?php echo $_GET['id']; ?>', 'mceInsertContent', false, returnStr);
    }
 

		
		
		tinyMCEPopup.editor.execCommand('mceRepaint');
		tinyMCEPopup.close();
	}
	


	</script>
	<style>
	html, body {padding: 0px; margin: 0px; height: auto; background-color: #ffffff;}
	input.text_input {width: 300px;}
	ul.choose-form li { 
	  
	  /*border-top: 1px solid #cccccc; */
	  border-bottom: 1px solid #cccccc;
	  line-height: 30px;
	  padding-left: 10px;
	  margin-bottom: 0px;
	  
	}
	form {  }
	ul.choose-form {
	
	 border-top: 1px solid #cccccc;	
	}
	ul.choose-form li:nth-child(even) {
		background-color: #fafafa;
	}
	ul.choose-form li:hover {
	    background-color: #fafafa;	
	}
	
	ul.choose-form li.selected {
	  background-color: #E6FFE6;
	  font-weight: bold;
	}
	label { padding-left: 10px; display: inline-block; width: 90% }
	input[type=radio] { margin-top: 3px; } 
	h3 { margin-top: 5px; padding-left: 3px; font-family: sans-serif; font-size: 14pt; color: #333333; font-weight: normal; }
	input[type=button] { float: left; }
	</style>
    <script>
	function selectThisRadio(radioButton) {
		
   		for (var i = 0; i < radioButton.form['i3d_cta_id'].length; i++) {
          var button = radioButton.form['i3d_cta_id'][i];
          if (button.checked) {
			//  alert(button);
            button.parentNode.className="selected";
        } else {
			button.parentNode.className = "";
    	}
		}

	}
	</script>
</head>
<body onLoad="tinyMCEPopup.executeOnLoad('init();');" class='wp-core-ui'>
<h3>Choose Gallery To Use</h3>
<?php
	$taxonomies = array("" => __("Portfolio Items", "i3d-framework"), "i3d-team-member-department" => __("Team Members", "i3d-framework"));
?>
<form>
<ul style='list-style-type: none;' class='choose-form'>
<li>Post Type: <select id="taxonomy" name="taxonomy" onchange='handleTaxonomyChange(this)'>
        <?php foreach ($taxonomies as $taxonomy => $taxonomyName) { ?>
          <option <?php if (@$properties['taxonomy'] == $taxonomy) { print "selected"; } ?> value="<?php echo $taxonomy; ?>"><?php echo $taxonomyName; ?></option>
        <?php
		if ($taxonomy == "") {
		  $categories["i3d-portfolio"] = get_terms("i3d-portfolio", "hide_empty=1");
		} else {
		  $categories["$taxonomy"] = get_terms($taxonomy, "hide_empty=1");
		}
		
		} ?>
        </select> </li>
<li>Categories:         <?php foreach ($taxonomies as $taxonomy => $taxonomyName) { 

		      $taxn = ($taxonomy == "" ?  "i3d-portfolio" : $taxonomy);
			  ?>
        <div class='taxonomy-categories' id="i3d-portfolio-item-category-<?php echo $taxn;?>" <?php if (@$properties['taxonomy'] == $taxonomy) { } else { ?>style='display: none;'<?php } ?>>
		  <?php if (sizeof($categories["$taxn"]) == 0) { ?>
		  
		  <?php } else { ?>
		  
		   
	
		<p style='margin: 0px; font-size: 8pt;'>If none are selected, then all categories will be used.</p>
			<select multiple size=3 id="<?php echo 'categories__'.$taxn; ?>" name="<?php echo 'categories__'.$taxn; ?>[]">
        <?php
		if (@$properties['taxonomy'] == $taxonomy) {
			$txn_cat = explode(",", $properties['categories']);
		} else {
			$txn_cat = array();
		}
		//$txn_cat =  @$properties['categories__'.$taxn];
		foreach ($categories["$taxn"] as $category => $categoryObj) { ?>
          <option <?php if (@in_array($categoryObj->term_id, @$txn_cat)) { print "selected"; } ?> value="<?php echo $categoryObj->term_id; ?>"><?php echo $categoryObj->name; ?></option>
        <?php } ?>
		    </select>
		  <?php } ?>
		</div>
		<?php } ?></li>
<!--<li>Gallery Type:</li>-->
<?php if (sizeof(I3D_Framework::$portfolioStyles) > 0) { ?><li>Gallery Style:
        		
		<select id="<?php echo 'portfolio_style'; ?>" name="<?php echo 'portfolio_style'; ?>">
        <?php foreach (I3D_Framework::$portfolioStyles as $portfolioStyle => $porfolioStyleName) { ?>
          <option <?php if (@$properties['portfolio_style'] == $portfolioStyle) { print "selected"; } ?> value="<?php echo $portfolioStyle; ?>"><?php echo $porfolioStyleName; ?></option>
        <?php } ?>
                </select> 

</li>
                <?php } ?>
<li>Order: 		<select id="<?php echo 'order'; ?>" name="<?php echo 'order'; ?>">
		  <option value="">Default</option>
		  <option <?php if (@$properties['order'] == "alpha") { print "selected"; } ?> value="alpha">Alphabetically</option>
		</select>
</li>
<li>Aspect Ratio: 		<select id="<?php echo 'aspect_ratio'; ?>" name="<?php echo 'aspect_ratio'; ?>">
		  <option value="">Variable (Default)</option>
		  <option <?php if (@$properties['aspect_ratio'] == "constrained") { print "selected"; } ?> value="constrained">Constrained</option>
		</select>
</li>

</ul>

		
		

	<script>
	function handleTaxonomyChange(selectBox) {
		var txn = "";
			  var selectedIndex = selectBox.selectedIndex;
			  var txn = selectBox.options[selectedIndex].value;
			  if (txn == "") {
				  txn = "i3d-portfolio";
			  }
			 
		jQuery('.taxonomy-categories').css("display", "none");
		jQuery('#i3d-portfolio-item-category-' + txn).css("display", "block");
	}
		
</script>
		


<input style='float: right; margin-right: 10px;' class='button button-primary button-large' type="button" name="nocmd" value="Continue" onClick="add_content_to_display(this)" />


</form>
</body>
</html>