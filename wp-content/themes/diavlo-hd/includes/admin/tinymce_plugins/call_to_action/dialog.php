<?php
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
parse_str(str_replace('&#34;', '"', substr(preg_replace($pattern, $replacement, substr(stripslashes($_GET['properties']),7)),1)), $properties);
$pages = get_pages();
$pageOptions = "";

foreach ($pages as $page) {
	$pageOptions .= '<option value="'.$page->ID.'"'.($properties['redirect_to'] == $page->ID ? ' selected="selected"' : '').'>';
	$pageOptions .= $page->post_title;
	$pageOptions .= '</option>';
}	

$ctas = get_option("i3d_calls_to_action");
$ata = $ctas["{$properites['id']}"];
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link rel='stylesheet' href='<?php echo get_option("siteurl") ?>/wp-admin/load-styles.php?c=1&amp;dir=ltr&amp;load=global,buttons,wp-admin&amp;ver=3.0' type='text/css' media='all' />
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script>
	function add_content_to_display(buttonClicked) {
		//var returnStr = '[contact send_to="'+document.getElementById("lm_email_address").value+'" redirect_to="'+document.getElementById("lm_redirect_to").value+'" name_label="'+document.getElementById("lm_name_label").value+'" phone_label="'+document.getElementById("lm_phone_label").value+'" email_label="'+document.getElementById("lm_email_label").value+'" message_heading="'+document.getElementById("lm_message_heading").value+'" contact_info_heading="'+document.getElementById("lm_contact_info_heading").value+'" submit_label="'+document.getElementById("lm_submit_label").value+'"]';
		
		var checkedButton = getCheckedRadio(buttonClicked.form['i3d_cta_id']);
		var ctaID = checkedButton.value;
		var returnStr = '<img src="<?php echo $_GET['url']; ?>/images/t.gif" class="i3d_cta mceItem" title="i3d_cta'+tinymce.DOM.encode(' id="'+ctaID+'"') + '" />';

	   <?php
	   global $wp_version;
	   if (version_compare($wp_version, "3.9", "<")) { ?>

		  window.tinyMCE.execInstanceCommand('<?php echo $_GET['id']; ?>', 'mceInsertContent', false, returnStr);
		
		<?php } else { ?>
		tinyMCEPopup.editor.insertContent(returnStr);
			
		<?php } ?>
		tinyMCEPopup.editor.execCommand('mceRepaint');
		tinyMCEPopup.close();
	}
	
	function getCheckedRadio(radio_group) {
      for (var i = 0; i < radio_group.length; i++) {
        var button = radio_group[i];
        if (button.checked) {
            return button;
        }
    }
    return undefined;
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
<h3>Choose Form To Use</h3>
<?php
?>
<form>
<ul style='list-style-type: none;' class='choose-form'>
<?php foreach ($ctas as $id => $cta) { ?>
<li <?php if ($id == $properties['id']) { echo "class='selected'"; } ?>><input onclick='selectThisRadio(this)' id="cta_<?php echo $id; ?>" <?php if ($id == $properties['id']) { print "checked"; } ?> type='radio' name="i3d_cta_id" value="<?php echo $id; ?>"> <label for="cta_<?php echo $id; ?>"><?php echo $cta['title']; ?></label></li>
<?php } ?>
</ul>
<input style='float: right; margin-right: 10px;' class='button button-primary button-large' type="button" name="nocmd" value="Continue" onClick="add_content_to_display(this)" />

<h3 style='clear: both;' >Create a New Call To Action</h3>
<p>To create a new call-to-action, first save your page, then proceed to the <a target="_top" href="<?php echo get_option("siteurl") ?>/wp-admin/admin.php?page=i3d_calls_to_action">call-to-action creation page</a>.</p>
<input type='radio' name='i3d_cta_id' value='' style='display: none;' />
</form>
</body>
</html>