<?php
$wp_include = "../../../wp-load.php";
$i = 0;

while (!file_exists($wp_include) && $i++ < 10) {
  $wp_include = "../".$wp_include;
}

//load wordpress info
require($wp_include);


//remove double quotes around values and replace spaces between key/value pairs with '&'
$pattern = '/(.*?)="(.*?)"[\s]/i';
$replacement = '&${1}=${2}';

//apply REGEX and parse string into an array like a GET string is
parse_str(str_replace(array('{lttag}','{gttag}','{newline}','{dblq}'), array('<','>',"\n",'"'), substr(preg_replace($pattern, $replacement, substr(str_replace("\n", '{newline}', stripslashes($_GET['properties'])),8).' '),1)), $properties);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link rel='stylesheet' href='<?php echo get_option("siteurl") ?>/wp-admin/load-styles.php?c=1&amp;dir=ltr&amp;load=global,wp-admin' type='text/css' media='all' />
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script>
	function clean_content_text(str) {
		return str.replace(/"/g,'{dblq}').replace(/\n/g,'{newline}').replace(/</g,'{lttag}').replace(/>/g,'{gttag}');
	}
	
	function add_content_to_display() {
		var returnStr = '<img src="'+tinymce.baseURL+'/plugins/wpgallery/img/t.gif" class="lmPayPalProduct mceItem" title="product'+tinymce.DOM.encode(' product_name="'+clean_content_text((document.getElementById("lm_product_name").value))+'" description="'+clean_content_text((document.getElementById("lm_product_description").value))+'" price="'+clean_content_text((document.getElementById("lm_product_price").value))+'" paypal_button="'+clean_content_text((document.getElementById("lm_paypal_button_code").value))+'"')+'" />';
		
		window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, returnStr);
		tinyMCEPopup.editor.execCommand('mceRepaint');
		tinyMCEPopup.close();
	}
	</script>
	<style>
	html, body {padding: 0px; margin: 0px;}
	input.text_input {width: 300px;}
	</style>
</head>
<body onLoad="tinyMCEPopup.executeOnLoad('init();');">
	<table>
		<tr><td colspan="2"><h3>Product Details</h3></td></tr>
		<tr><td><label for="lm_product_name">Product Name</label></td><td><input type="text" name="product_name" id="lm_product_name" value="<?php echo properties['product_name'];?>" class="text_input" /></td></tr>
		<tr><td><label for="lm_product_price">Product Price</label></td><td><input type="text" name="price" id="lm_product_price" value="<?php echo $properties['price'];?>" class="text_input" /></td></tr>
		<tr><td><label for="lm_product_description">Description</label></td><td><textarea style="width: 300px;" name="description" id="lm_product_description"><?php echo stripslashes($properties['description']);?></textarea></td></tr>
		
		<tr><td colspan="2"><h3>PayPal Button Code</h3></td></tr>
		<tr><td colspan="2"><textarea style="width: 380px; height: 100px;" name="paypal_button" id="lm_paypal_button_code"><?php echo stripslashes($properties['paypal_button']);?></textarea></td></tr>
		<tr><td colspan="2"><input type="button" name="nocmd" value="Insert" class="button" onClick="add_content_to_display()" /></td></tr>
	</table>
</body>
</html>