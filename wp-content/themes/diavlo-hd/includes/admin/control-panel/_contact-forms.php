<?php
function i3d_contact_forms() { 
 
  if (@$_GET['cmd'] == "reset") {
	update_option('i3d_contact_forms', array());
	wp_redirect(admin_url("admin.php?page=i3d_contact_forms"));
  } else if (@$_GET['cmd'] == "init") {
	  I3D_Framework::init_forms(true);
	wp_redirect(admin_url("admin.php?page=i3d_contact_forms"));
  } else if (@$_GET['cmd'] == "new" && @$_POST['cmd2'] != translate('Cancel', get_option("template"))) {
	  i3d_create_contact_form();
      return;
  } else if (@$_POST['cmd2'] == translate('Cancel', get_option("template"))) {
	  
	wp_redirect(admin_url("admin.php?page=i3d_contact_forms"));

  } else if (@$_GET['form'] != "") {
	if (@$_GET['action'] == "trash") {
	  $forms = get_option('i3d_contact_forms');
	  unset($forms[$_GET['form']]);
	  update_option('i3d_contact_forms', $forms);
	  wp_redirect(admin_url("admin.php?page=i3d_contact_forms"));

	} else {
	  i3d_contact_form_editor(@$_GET['form']);
	  return;
	}
  } else if (@$_POST['slider'] != "") {
	 // print "yes";
	  
	 i3d_contact_form_editor($_POST['form']); 
	 return;
  }
  
  $forms = get_option('i3d_contact_forms');
  if (!is_array($forms)) {
	  $forms = array();
  }
  
  
?>
  <div class='wrap'>
  <h2>Contact Forms <a class="add-new-h2" href="admin.php?page=i3d_contact_forms&cmd=new">Add New</a></h2>

  <table cellspacing="0" class="wp-list-table widefat fixed posts">
	<thead>
	<tr>
		<th style="display: none;"  class="manage-column column-cb check-column" id="cb" scope="col"><label for="cb-select-all-1" class="screen-reader-text">Select All</label><input type="checkbox" id="cb-select-all-1"></th>
        <th style="" class="manage-column" id="title" scope="col"><span>Title</span></th>
    </tr>
	</thead>

	<tfoot>
	<tr>
		<th style="display: none;"  class="manage-column column-cb check-column" id="cb" scope="col"><label for="cb-select-all-2" class="screen-reader-text">Select All</label><input type="checkbox" id="cb-select-all-1"></th>
        <th style="" class="manage-column" id="title" scope="col"><span>Title</span></th>
    </tr>
	</tfoot>
	<tbody id="the-list">
<?php if (sizeof($forms) == 0) { ?>
  				<tr valign="top" class="slider-none hentry alternate" id="slider-none">
				<th style="display: none;" class="check-column" scope="row">
					
							</th>
						<td class="post-title page-title column-title" colspan="1">There are currently no forms in the system.  Click "add new" at the top of the page to create a new form.
</td>
		</tr>

<?php } 
//var_dump($sliders);
?>
<?php foreach ($forms as $form) { ?>
    
				<tr valign="top" class="slider-<?php echo $form['id']; ?> hentry alternate" id="slider-<?php echo $form['id']; ?>">
				<th style="display: none;"  class="check-column" scope="row">
					<label for="cb-select-<?php echo $form['id']; ?>" class="screen-reader-text">Select <?php echo $form['form_title']; ?></label>
				<input type="checkbox" value="<?php echo $form['id']; ?>" name="slider[]" id="cb-select-<?php echo $form['id']; ?>">
							</th>
						<td class="post-title page-title column-title"><strong><a title="Edit '<?php echo $form['form_title']; ?>'" href="?page=i3d_contact_forms&form=<?php echo $form['id']; ?>&amp;action=edit" class="row-title"><?php echo $form['form_title']; ?></a></strong>
<div class="row-actions"><span class="edit"><a title="Edit this item" href="?page=i3d_contact_forms&form=<?php echo $form['id']; ?>&amp;action=edit">Edit</a> | </span><span class="trash"><a href="?page=i3d_contact_forms&form=<?php echo $form['id']; ?>&amp;action=trash" title="Delete this Form" class="submitdelete">Delete</a></span></div>
</td>
		</tr>
<?php } ?>        
		</tbody>
</table>

    </div>
    <?php
}

function i3d_create_contact_form() {
	//if ($_POST['cmd2'] == translate('Create', get_option("template"))) {
 		 $forms = get_option('i3d_contact_forms');
		// $id = wp_create_nonce("i3d_contact_form".mktime());
		 		 $id = "cf_".I3D_Framework::get_unique_id("i3d_contact_form");

		// if ($_POST['form_title'] != "") {
		   $forms["{$id}"] = array('id' => $id,
									 'form_title' => "New Form",
									 'submit_button_label' => "Submit",
									 'form_email' => get_site_option('admin_email')
								     );
		   
		   update_option('i3d_contact_forms', $forms);
		   wp_redirect(admin_url("admin.php?page=i3d_contact_forms&form={$id}&action=edit"));

		   
		   return;
		// }
		 
//	}

  
}

function i3d_contact_form_editor($formID) {
	global $wpdb;
	$forms = get_option('i3d_contact_forms');
	$form  = $forms["{$formID}"];
	 if(array_key_exists("cmd", $_POST) && $_POST['cmd'] == "test") {
		$to = $form['form_email'];
		$subject = $form['form_title'];
		$headers  = array('MIME-Version: 1.0', 'Content-Type: text/html; charset=UTF-8');
		//$headers .= "\r\nContent-Type: text/html";
		//$headers .= "\r\nFrom: ".get_site_option('admin_email');
		unset($_POST['cmd']);
				unset($_POST['form_id']);

		$message = "<h3>{$form['form_title']}</h3>";
		$message .= "<p>{$form['form_description']}</p>";
		 
		 $success = wp_mail($to, $subject, $message, $headers);
		 $outputMessage = "";
		 if ($success) {
		   $outputMessage = "<span style='color: #009900'><i class='fa fa-check'></i> Mail Send Successful</span>";
		 } else {
			$outputMessage = "<span class='alert alert-danger alert-sm'><i class='fa fa-close'></i> Mail Send Failed -- Problem exists with web server SENDMAIL system.</span>";
		 }
	  ?>
	  <script>
	  jQuery("#test-send-button", window.parent.document).html("Test");
	  jQuery("#test-send-button", window.parent.document).removeAttr("disabled");
	  jQuery("#test-send-message", window.parent.document).html("<?php echo $outputMessage; ?>");
	  //window.parent.document.alert("alright");
	  </script>
	  <?php
	  exit;
	 } else if(array_key_exists("cmd", $_POST) && $_POST['cmd'] == "save") {
		$doingSave = true;

		$fields = array();

		if(array_key_exists("fields", $_POST) && is_array($_POST['fields'])) {
		  foreach($_POST['fields'] as $id) {
			  
			  $fields[] = array('fieldtype' => @$_POST["{$id}__fieldtype"],
								'fieldwidth' => @$_POST["{$id}__fieldwidth"],
								'label' => stripslashes($_POST["{$id}__label"]),
								'required' => @$_POST["{$id}__required"],
								'placeholder' => stripslashes(@$_POST["{$id}__placeholder"]),
								'visible' => @$_POST["{$id}__visible"],
								'options' => stripslashes(@$_POST["{$id}__options"]),
								'multiple' => @$_POST["{$id}__multiple"],
								'prepend_icon' => @$_POST["{$id}__prepend_icon"],
								'checked_value' => @$_POST["{$id}__checked_value"],
								'date_format' => @$_POST["{$id}__date_format"],
								'site_key' => @$_POST["{$id}__site_key"],
								'secret_key' => @$_POST["{$id}__secret_key"],
								
								'site_key_v2i' => @$_POST["{$id}__site_key_v2i"],
								'secret_key_v2i' => @$_POST["{$id}__secret_key_v2i"],
								
								'site_key_v3' => @$_POST["{$id}__site_key_v3"],
								'secret_key_v3' => @$_POST["{$id}__secret_key_v3"],
								'threshold_v3' => @$_POST["{$id}__threshold_v3"],
								
								'show_field_label' => @$_POST["{$id}__show_field_label"],
								'input_class' => @$_POST["{$id}__input_class"]
								
								);
								
			 
		}
	  }
		//$sliders["{$sliderID}"]["slides"] = $portfolioImages;
		$forms["{$formID}"]["form_title"]          = stripslashes($_POST['form_title']);
		$forms["{$formID}"]["form_title_wrap"]          = stripslashes($_POST['form_title_wrap']);
		$forms["{$formID}"]["form_title_alignment"]          = stripslashes($_POST['form_title_alignment']);
		$forms["{$formID}"]["form_description"]          = stripslashes($_POST['form_description']);
		$forms["{$formID}"]["redirect_page"]       = $_POST['redirect_page'];
		$forms["{$formID}"]["form_email"]               = $_POST['form_email'];
		$forms["{$formID}"]["submit_button_label"] = $_POST['submit_button_label'];
		$forms["{$formID}"]["show_reset_button"]   = $_POST['show_reset_button'];
		$forms["{$formID}"]["fields"]   = $fields;
		$form = $forms["{$formID}"];
		//var_dump($form);
		update_option("i3d_contact_forms", $forms);
	}


function renderRedirectPageOptions($selectedPage) {
	$pages = get_pages();
	$redirectPageOptions = "";

	foreach ($pages as $page) {
		$redirectPageOptions .= '<option value="'.$page->ID.'"';
		if ($page->ID == $selectedPage) { 
		$redirectPageOptions .= " selected";
		}
		$redirectPageOptions .= '>';
		$redirectPageOptions .= addslashes($page->post_title);
		$redirectPageOptions .= '</option>';
	}
  echo $redirectPageOptions;
}

	$posts = get_posts(array('numberposts' => 25));
	$newPostOptions = "";

	foreach ($posts as $post) {
		$newPostOptions .= '<option value="'.$post->ID.'">';
		$newPostOptions .= addslashes($post->post_title);
		$newPostOptions .= '</option>';
	}



	$fieldTypes  = '<option style="disabled" value="">-- Choose Object --&nbsp;</option>';
	$fieldTypes .= '<option value="text">Text</option>';
	$fieldTypes .= '<option value="textarea">Textarea</option>';
	$fieldTypes .= '<option value="checkbox">Checkbox</option>';
	$fieldTypes .= '<option value="radio">Radio Button</option>';
	$fieldTypes .= '<option value="select">Select Box</option>';
	$fieldTypes .= '<option value="email">Email</option>';
	$fieldTypes .= '<option value="url">Website Address</option>';
	$fieldTypes .= '<option value="date">Date</option>';
	$fieldTypes .= '<option value="captcha2">Google reCAPTCHA V2</option>';
	$fieldTypes .= '<option value="captcha2i">Google reCAPTCHA V2 (Invisible)</option>';
	$fieldTypes .= '<option value="captcha3">Google reCAPTCHA V3</option>';
	//$fieldTypes .= '<option value="captcha"  disabled>Google reCAPTCHA V1 (Deprecated)</option>';
	//$fieldTypes .= '<option value="skill" disabled>Skill Testing Question (Deprecated)</option>';
	$fieldTypes .= '<option disabled>-- Display Options --</option>';
	$fieldTypes .= '<option value="label">Label</option>';
	$fieldTypes .= '<option value="heading">Heading</option>';
	//$fieldTypes .= '<option value="file">File Upload</option>';
	$fieldTypes .= '<option value="separator">Separator</option>';

	$fieldWidths  = '<option value="span12">100%</option>';
	$fieldWidths .= '<option value="span9">75%</option>';
	$fieldWidths .= '<option value="span6">50%</option>';
	$fieldWidths .= '<option value="span3">25%</option>';


?>

	<style>
	#sortable li { cursor: move; }
		#sortable label {width: 100px; display: inline-block; font-weight: bold;}
		#sortable input.text_input {width: 200px;}
		table.form_field {   }

		div.loading {
			background-image: url(<?php echo I3D_Framework::getAuxIconSrc('loading-bg'); ?>) !important;
			background-repeat: no-repeat !important;
			background-position: center center !important;
			height: 40px;
		}

		div.image-choice-featured { font-weight: bold; line-height: 17px; width: 217px !important; height: 148px; float: left; margin: 2px; padding: 2px; border: 1px solid #cccccc; border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px; }
		div.image-choice { width: 69px !important; height: 69px; float: left; margin: 2px; padding: 2px; border: 1px solid #cccccc; border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px; }
    div.image-selected {
			background-color: #ffcc00;
		}

		div.change-image-link {
			display: block; padding: 2px; border-radius: 2px; -moz-border-radius: 2px; -webkit-border-radius: 2px; border: 1px solid #cccccc !important;
		}
		
		
		.editorvisual .span3  { height: 140px; margin: 1%; width: 23.75%; 		 float: left;     }
		.editorvisual .span6  { height: 140px; margin: 1%; width: 48.7%;		 float: left;	}
		.editorvisual .span9  { height: 140px; margin: 1%; width: 73.5%;		 float: left;	}
		.editorvisual .span12 { height: 140px; margin: 1%; width: 98.70%;		 float: left;	}
		.editorvisual textarea { height: 20px; margin-bottom: 0px; } 
		.editorvisual .span3 textarea,
		.editorvisual .span3 input { width: auto;  } 
		.editorvisual .span3 input[type=text],
		.editorvisual .span3 select
		{ width: 100%; max-width: 90%;  }
		.editorvisual .span3 select.width { width: auto; margin-right: 0px; }
		.editorvisual .span3 label { width: 45px; }
		
		div.change-image-link img { margin-bottom: -5px; cursor: pointer; }
		#sortable li:not(.fa-icon-chooser-li) { margin-bottom: 15px; border: 1px solid #dadada; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; background-color: #fafafa; box-shadow: 0px 0px 3px #cccccc;}
		#sortable li.new-field { 
		  background-color: #ABD3AC;
		}
		.editorvisual .visual { display: block; }
		
		.editordesign .visual { display: none; }
		.editordesign .design { /* display:inherit;  */ }
		.editorvisual .design { display: none !important; }
		.editorvisual .span3 .visual50 { display: none !important; }
		.editordesign select.design { display: inline-block; }
		.editordesign li.span6, .editorvisual li.span6 { margin-left: 0px !important; }
		.editordesign li.span3, .editorvisual li.span3 { margin-left: 0px !important; }
		.editordesign li.span12, .editorvisual li.span12 { margin-left: 0px !important; }
		.editordesign li.span9, .editorvisual li.span9 { margin-left: 0px !important; }
		
				.editordesign li.span12 { width: 100%; }
				.editordesign li.span6 { width: 100%; }
				.editordesign li.span3 { width: 100%; }
				.editordesign li.span9 { width: 100%; }

		 ul.editordesign, ul.editorvisual { margin: 0px !important; padding: 10px; padding-right: 15px; }
		 #sortable { clear: both; } 
		 #sortable li:not(.fa-icon-chooser-li)  { padding: 0px; }
		 #sortable li div.li-padder { padding: 10px; }
		
		#sortable.editorvisual .span3 label { width: 45px !important; }
			a.mceButton.mce_i3d_contact_form { display: none; }
			.mce-i3d_contact_form { display: none; } 

	
  </style>

  <link rel='stylesheet' type='text/css' href='<?php echo site_url() ; ?>/wp-admin/load-styles.php?c=1&amp;load=thickbox' />
	<script type="text/javascript">
	jQuery(function($) {
	//	jQuery("#sortable").sortable();
		jQuery("#sortable").sortable({cancel: ".fa-icon-chooser,input,textarea,button,select,option" });
		//jQuery("#sortable .fa-icon-chooser").disableSelection();
		
	    //jQuery("#sortable li").resizable({grid: 50});
	});

function changeMode(radioButton) {
	if (jQuery(radioButton).is(':checked')) {
  	var selectedValue = jQuery(radioButton).val();
  
  
  if (selectedValue == "design") {
    jQuery("#sortable").removeClass("editorvisual");
    jQuery("#sortable").addClass("editordesign");
	  
  } else {
    jQuery("#sortable").removeClass("editordesign");
    jQuery("#sortable").addClass("editorvisual");
	
  }
	}
 
	

}

var stylesheetDirectory = "<?php echo get_stylesheet_directory_uri() ; ?>";
    function renderPreview(id) {
		var selectedValue = jQuery("#" + id + "__fieldtype").val();
		var html = "";
		if (selectedValue == "heading") {
			html = "<h3>" + jQuery("#" + id + "__label").val() + "</h3>";
		} else if (selectedValue == "label") {
			html = "<p>" + jQuery("#" + id + "__label").val() + "</p>";
		} else if (selectedValue == "separator") {
			html = "<hr />";
			
		} else if (selectedValue == "text" || selectedValue == "url" || selectedValue == "email") {
		   if (jQuery("#" + id + "__show_field_label").val() == "1") {
			 html = "<label>" + jQuery("#" + id + "__label").val() + "</label>";   
		   }
		   //alert(jQuery("#" + id + "__label").val());
		   //alert(id);
		   
		   if (jQuery("#hidden__" + id + "__prepend_icon").val() != "") {
        

			 html = html + "<div class='input-group'><span class='input-group-addon'><i class='fa " + jQuery("#hidden__" + id + "__prepend_icon").val() + "'></i></span>";   
		     
		   } 
		   
		   html = html + "<input type='text' placeholder='" + jQuery("#" + id + "__placeholder").val() + "' class='" + jQuery("#" + id + "__input_width").val() + "' />";
		   
		   // close the prepended icon span
		   if (jQuery("#hidden__" + id + "__prepend_icon").val() != "") {
			  html = html + "</div>"; 
		   }

		} else if (selectedValue == "date") {
		   if (jQuery("#" + id + "__show_field_label").val() == "1") {
			 html = "<label>" + jQuery("#" + id + "__label").val() + "</label>";   
		   }
		   
		   if (jQuery("#hidden__" + id + "__prepend_icon").val() != "") {
			 html = html + "<div class='input-group'><span class='input-group-addon'><i class='fa " + jQuery("#hidden__" + id + "__prepend_icon").val() + "'></i></span>";   
		     
		   } 
		   
		   html = html + "<input type='text' placeholder='" + jQuery("#" + id + "__date_format").val() + "' class='" + jQuery("#" + id + "__input_width").val() + "' />";
		   
		   // close the prepended icon span
		   if (jQuery("#hidden__" + id + "__prepend_icon").val() != "") {
			  html = html + "</div>"; 
		   }


		} else if (selectedValue == "skill") {
		   if (jQuery("#" + id + "__show_field_label").val() == "1") {
			 html = "<label>" + jQuery("#" + id + "__label").val() + "</label>";   
		   }
		   
		   if (jQuery("#hidden__" + id + "__prepend_icon").val() != "") {
			 html = html + "<div class='input-group'><span class='input-group-addon'><i class='fa " + jQuery("#hidden__" + id + "__prepend_icon").val() + "'></i></span>";   
		     
		   } 
		   
		   html = html + "27 + 8 = <input type='text' placeholder='" + jQuery("#" + id + "__placeholder").val() + "' class='" + jQuery("#" + id + "__input_width").val() + "' />";
		   
		   // close the prepended icon span
		   if (jQuery("#hidden__" + id + "__prepend_icon").val() != "") {
			  html = html + "</div>"; 
		   }

		} else if (selectedValue == "textarea") {
		   if (jQuery("#" + id + "__show_field_label").val() == "1") {
			 html = "<label>" + jQuery("#" + id + "__label").val() + "</label>";   
		   }
		   
		   if (jQuery("#hidden__" + id + "__prepend_icon").val() != "") {
			 html = html + "<div class='input-group'><span class='input-group-addon'><i class='fa " + jQuery("#hidden__" + id + "__prepend_icon").val() + "'></i></span>";   
		   } 
		   
		   html = html + "<textarea placeholder='" + jQuery("#" + id + "__placeholder").val() + "' class='" + jQuery("#" + id + "__input_width").val() + "'></textarea>";
		   
		   // close the prepended icon span
		   if (jQuery("#hidden__" + id + "__prepend_icon").val() != "") {
			  html = html + "</div>"; 
		   }
		} else if (selectedValue == "checkbox") {

		   
		   html = html + "<input type='checkbox' />";
	
			if (jQuery("#" + id + "__show_field_label").val() == "1") {
			 html  =  html + " <label style='display: inline-block !important; padding-top: 7px;'>" + jQuery("#" + id + "__label").val() + "</label>";   
		   }
		} else if (selectedValue == "captcha") {
		   if (jQuery("#" + id + "__show_field_label").val() == "1") {
			 html = "<label>" + jQuery("#" + id + "__label").val() + "</label>";   
		   }		
			html = html + "<img src='<?php echo get_stylesheet_directory_uri()."/includes/admin/images/google-recaptcha-placeholder.jpg"; ?>' />";

		} else if (selectedValue == "captcha2") {
		   if (jQuery("#" + id + "__show_field_label").val() == "1") {
			 html = "<label>" + jQuery("#" + id + "__label").val() + "</label>";   
		   }		
			html = html + "<img src='<?php echo get_stylesheet_directory_uri()."/includes/admin/images/google-recaptcha2-placeholder.jpg"; ?>' />";


		} else if (selectedValue == "select") {

		   if (jQuery("#" + id + "__show_field_label").val() == "1") {
			 html = "<label>" + jQuery("#" + id + "__label").val() + "</label>";   
		   }
		   
		   if (jQuery("#hidden__" + id + "__prepend_icon").val() != "") {
			 html = html + "<div class='input-group'><span class='input-group-addon'><i class='fa " + jQuery("#hidden__" + id + "__prepend_icon").val() + "'></i></span>";   
		     
		   } 
		   
		   html = html + "<select class='" + jQuery("#" + id + "__input_width").val() + "'>";
		   var selectOptions = jQuery("#" + id + "__options").val();
		   selectOptions = selectOptions.split("\n");
		   for (var i = 0; i < selectOptions.length; i++) {
			   html = html + "<option>" + selectOptions[i] + "</option>";
		   }
		   html = html + "</select>";
		   
		   // close the prepended icon span
		   if (jQuery("#hidden__" + id + "__prepend_icon").val() != "") {
			  html = html + "</div>"; 
		   }
		} else if (selectedValue == "radio") {

		   if (jQuery("#" + id + "__show_field_label").val() == "1") {
			 html = "<label>" + jQuery("#" + id + "__label").val() + "</label>";   
		   }
		   
		   if (jQuery("#hidden__" + id + "__prepend_icon").val() != "") {
			 html = html + "<div class='input-group'><span class='input-group-addon'><i class='fa " + jQuery("#hidden__" + id + "__prepend_icon").val() + "'></i></span>";   
		     
		   } 
		 
		   
		   //html = html + "<select class='" + jQuery("#" + id + "__input_width").val() + "'>";
		   var selectOptions = jQuery("#" + id + "__options").val();
		   selectOptions = selectOptions.split("\n");
		   for (var i = 0; i < selectOptions.length; i++) {
			   html = html + "<input type='radio' name='radio-" + id + "' id='radio-" + id + "-" + i + "'> <label for='radio-" + id + "-" + i + "' style='font-weight: normal; display: inline-block !important; padding-top: 8px;'>" + selectOptions[i] + "</label><br/>";
		   }
		   //html = html + "</select>";
		   
		   // close the prepended icon span
		   if (jQuery("#hidden__" + id + "__prepend_icon").val() != "") {
			  html = html + "</div>"; 
		   }
		}
		
		html = "<div class='preview-text'>Example</div>" + html;
		if (selectedValue == "captcha2i" || selectedValue == "captcha3") {
			jQuery("#" + id + "__preview").css("display", "none");
		} else {
			jQuery("#" + id + "__preview").css("display", "block");
			jQuery("#" + id + "__preview").html(html);
		}
		
		
	}

	function changeFieldType(selectBox,id) {
		var selectedValue = selectBox.options[selectBox.selectedIndex].value;
		
		if (selectedValue != "") {
			jQuery("li#field__"+id).removeClass("new-field");
		} else {
			
		}
		jQuery("#field_details_all__"+id).find(".field_details_container").css("display", "none");
        
		if (selectedValue != "") {
		  jQuery(".field_details__"+id+"__" + selectedValue).css("display", "table-cell");
		  
		  if (selectedValue != "separator") {
		    jQuery(".field_details__"+id+"__all").css("display", "table-cell");
		  } 
		  
		  if (selectedValue != "separator" && selectedValue != "label" && selectedValue != "heading") {
		    jQuery(".field_details__"+id+"__required").css("display", "table-cell");
			  
		  }
		  if (selectedValue == "separator" || selectedValue == "label" || selectedValue == "heading") {
		    jQuery(".field_details__"+id+"__expansion").css("display", "table-cell");
			  
		  }
		  if (selectedValue != "separator" && selectedValue != "label" && selectedValue != "heading" && selectedValue != "checkbox" && selectedValue != "radio") {
		    jQuery(".field_details__"+id+"__show_label").css("display", "table-cell");  
		  }	
		  
		  if (selectedValue != "separator" && selectedValue != "label" && selectedValue != "heading" && selectedValue != "checkbox" && selectedValue != "radio") {
		    jQuery(".field_details__"+id+"__show_icon").css("display", "table-cell");  
		  }			  

		  if (selectedValue != "separator" && selectedValue != "label" && selectedValue != "heading" && selectedValue != "checkbox" && selectedValue != "radio") {
		    jQuery(".field_details__"+id+"__input_width").css("display", "table-cell");  
		  }			  


		  if (selectedValue == "radio" || selectedValue == "select") {
		    jQuery(".field_details__"+id+"__options").css("display", "table-cell");
		  }
		  if (selectedValue == "select") {
		    jQuery(".field_details__"+id+"__multiple").css("display", "block");
		  }		  
		  if (selectedValue == "textarea" || selectedValue == "url" || selectedValue == "email") {
		    jQuery(".field_details__"+id+"__text").css("display", "table-cell");
			  
		  }
			
		  if (selectedValue == "captcha2") {
			     jQuery(".field_details__"+id+"__required").css("display", "none");
		  }
		  if (selectedValue == "captcha2i") {
			   jQuery(".field_details__"+id+"__required").css("display", "none");
			  jQuery(".field_details__"+id+"__show_label").css("display", "none");
			  jQuery(".field_details__"+id+"__all").css("display", "none");
			  			jQuery(".field_details__"+id+"__show_icon").css("display", "none");
			  jQuery(".field_details__"+id+"__input_width").css("display", "none");
		  }
			
		if (selectedValue == "captcha3") {
			   jQuery(".field_details__"+id+"__required").css("display", "none");
			jQuery(".field_details__"+id+"__show_label").css("display", "none");
				jQuery(".field_details__"+id+"__all").css("display", "none");
			jQuery(".field_details__"+id+"__show_icon").css("display", "none");
			jQuery(".field_details__"+id+"__input_width").css("display", "none");
			
		  }
			
		  
		  
		  
		//  selectBox.options[0].disabled = true;
		}
		renderPreview(id);
	}
	function changeFieldWidth(selectBox,id) {
		var selectedValue = selectBox.options[selectBox.selectedIndex].value;
		jQuery("li#field__"+id).removeClass("span12");
		jQuery("li#field__"+id).removeClass("span9");
		jQuery("li#field__"+id).removeClass("span6");
		jQuery("li#field__"+id).removeClass("span3");
		jQuery("li#field__"+id).addClass(selectedValue);
    
	}
	function remove_field(id) {
		if (!confirm("Are you sure you wish to remove this field?")) {
			return;
		}
		//get containing div element (container)
		var container = document.getElementById('sortable');

		//get div element to remove
		var olddiv = document.getElementById('field__'+id);

		//remove the div element from the container
		container.removeChild(olddiv);
	}	

	function add_new_form_item() {
		var id = "";
		var source = "";
		var title = "Example Field Name";
		var caption = "Example Default Value";
		var description = "Example Long Description";
		var linkLabel = "Click Here";
        var tempFontAwesome = jQuery("#temp-fontawesome").html();
		tempFontAwesome = tempFontAwesome.replace(/newcounter/g, 'new'+counter);
		
		jQuery("#sortable").append('<li id="field__new'+counter+'" class="span12 new-field">' +
		 '<div class="li-padder">' + 
		 '<table id="new'+counter+'__table" class="form_field" cellspacing="0" width="100%" height="100%">' +
		 '<tr>' + 													 
		 '<td>' +
		 '<button class="remove button" name="nocmd" onclick="remove_field(\'new' + counter + '\');"><i class="fa fa-times"></i></button>' +
		 '<div class="visual">' + 
         '<span class="input-prepend" style="display: block;">' +
                '<span class="add-on visual50" style="width: 150px"><i class="fa fa-arrows-h"></i> Column Width</span>' + 
                '<select class="width" style="width: 100px" onchange="changeFieldWidth(this,\'new' + counter + '\')" id="new' + counter + '__fieldwidth" name="' + counter + '__fieldwidth"><?php echo $fieldWidths; ?></select>' + 
         '</span>' + 
		 '</div>' +
         '<div id="field_details_all__new' + counter + '" class="design">'+
         '<table class="table table-striped">'+
          '<tr>'+
            '<th style="width: 145px;">Object <i class="fa fa-info-circle tt" title="This is the type of input field, or display object (Heading, Label, Separator) that you want to display."></i></th>'+
            '<th style="width: 145px; display: none;" class="field_details_container field_details__new' + counter + '__all">Name/Label <i class="fa fa-info-circle tt" title="Even if you are not showing the label, you must define the Name/Label in order for the contents of the field to be emailed to you."></i></th>' +
            '<th class="field_details_container field_details__new' + counter + '__show_label" style="width: 70px; display: none;">Visible <i class="fa fa-info-circle tt" title="You may choose not to display the field label."></i></th>'+
            '<th class="field_details_container field_details__new' + counter + '__show_icon" style="width: 105px; display: none;">Icon <i class="fa fa-info-circle tt" title="You may specify an icon that prepends the input field."></i></th>'+
            '<th class="field_details_container field_details__new' + counter + '__required" style="width: 70px; display: none;">Required <i class="fa fa-circle-sign tt" title="You may choose to make your input field required."></i></th>'+
            '<th class="field_details_container field_details__new' + counter + '__input_width" style="display: none;">Width <i class="fa fa-info-circle tt" title="This is the width of the input field (for text, select boxes, and textareas)"></i></th>'+
            '<th class="field_details_container field_details__new' + counter + '__text" style="display: none;">Placeholder Text <i class="fa fa-info-circle tt" title="This is displayed in text, urls, email addresses, and textareas."></i></th>'+
            '<th class="field_details_container field_details__new' + counter + '__checkbox" style="display: none;">Checked Value <i class="fa fa-info-circle tt" title="This is required for checkboxes."></i></th>'+
            '<th class="field_details_container field_details__new' + counter + '__options" style="display: none;">Options <i class="fa fa-info-circle tt" title="Specify an option on each line, for select boxes, or radio buttons."></i></th>'+
            '<th class="field_details_container field_details__new' + counter + '__date" style="display: none;">Format <i class="fa fa-info-circle tt" title="Specify the date format you wish to collect."></i></th>'+
             '<th class="field_details_container field_details__new' + counter + '__skill" style="display: none;">&nbsp;</th>'+
             '<th class="field_details_container field_details__new' + counter + '__expansion" style="display: none;">&nbsp;</th>'+
           '</tr>'+
           '<tr>'+
             '<td><select style="width: auto;" onchange="changeFieldType(this,\'new' + counter + '\')" id="new' + counter + '__fieldtype" name="new' + counter + '__fieldtype"><?php echo $fieldTypes; ?></select></td>'+
             '<td class="field_details_container field_details__new' + counter + '__all" style="display: none;"><input  onkeyup="renderPreview(\'new' + counter + '\');" style="width: 140px;" type="text" id="new' + counter + '__label" name="new' + counter + '__label" value="Your Field Name" /></td>'+
             '<td class="field_details_container field_details__new' + counter + '__show_label" style="display: none;"><select onchange="renderPreview(\'new' + counter + '\');"  style="width: 60px;" class="design" id="new' + counter + '__show_field_label" name="new' + counter + '__show_field_label"><option value="1">Yes</option><option value="0">No</option></select></td>'+
             '<td class="field_details_container field_details__new' + counter + '__show_icon" style="display: none;">'+
			 ''+ tempFontAwesome + 
             '<td class="field_details_container field_details__new' + counter + '__required" style="display: none;"><select style="width: 60px;"  class="design" id="new' + counter + '__required" name="new' + counter + '__required"><option value="0">No</option><option value="1">Yes</option></select></td>'+
             '<td class="field_details_container field_details__new' + counter + '__input_width" style="display: none;"><select onchange="renderPreview(\'new' + counter + '\');" style="width: 60px;" class="design" id="new' + counter + '__input_class" name="new' + counter + '__input_class">'+
                   <?php if (I3D_Framework::$bootstrapVersion < 3) { ?>
                    '<option value="">100%</option>'+
                   '<option value="input-xxlarge">XXLarge</option>'+
                   '<option value="input-xlarge">XLarge</option>'+
                   '<option value="input-large">Large</option>'+
                   '<option value="input-medium">Medium</option>'+
                   '<option value="input-small">Small</option>'+
                   '<option value="input-mini">Mini</option>'+
                   <?php } else { ?>
                   '<option value="">100%</option>'+
                   '<option value="col-sm-9">75%</option>'+
                   '<option value="col-sm-6">50%</option>'+
                   '<option value="col-sm-3">25%</option>'+
                   '<option value="col-sm-2">16%</option>'+
                   '<option value="col-sm-1">8%</option>'+
                   <?php } ?>
                   '</select>'+
             '</td>'+
             '<td class="field_details_container field_details__new' + counter + '__text field_details__new' + counter + '__textarea" style="display: none;"><input onkeyup="renderPreview(\'new' + counter + '\');" style="width: 140px;" type="text" id="new' + counter + '__placeholder" name="new' + counter + '__placeholder" value="" /></td>'+
             '<td class="field_details_container field_details__new' + counter + '__checkbox" style="display: none;"><input style="width: 140px;" type="text" id="new' + counter + '__checked_value" name="new' + counter + '__checked_value" value="" /></td>'+
             '<td class="field_details_container field_details__new' + counter + '__options" style="display: none;"><textarea onkeyup="renderPreview(\'new' + counter + '\');" style="width: 140px;"  id="new' + counter + '__options" name="new' + counter + '__options"></textarea>'+
             '<div class="field_details_container field_details__new' + counter + '__multiple"  style="display: none;"><select onkeyup="renderPreview(\'new' + counter + '\');" style="width: 150px;" id="new' + counter + '__multiple" name="new' + counter + '__multiple"><option value="0">Single</option><option value="1">Multi-Select</option></select></div>'+
             '</td>'+
             '<td class="field_details_container field_details__new' + counter + '__date" style="display: none;">' +
             	'<select style="width: 140px;"  class="design" id="new' + counter + '__date_format" name="new' + counter + '__date_format">' +
                	'<option value="mm/dd/yyyy">mm/dd/yyyy</option>' +
                	'<option value="mm-dd-yyyy">mm-dd-yyyy</option>'+
                	'<option value="dd/mm/yyyy">dd/mm/yyyy</option>'+
                	'<option value="dd-mm-yyyy">dd-mm-yyyy</option>'+
                	'<option value="m d, yyyy">m d, yyyy</option>'+
                	'<option value="yyyy-mm-dd">yyyy-mm-dd</option>'+
                "</select>" +
             "</td>" +
             "<td class='field_details_container field_details__new" + counter + "__skill' style='display: none;'>"+
             	"<div style='width: 140px;'>&nbsp;</div>" +
             "</td>" +
             "<td class='field_details_container field_details__new" + counter + "__expansion' style='display: none;'>" + 
             	"<div style='width: 140px;'>&nbsp;</div>" +
             '</td>' +
          '</tr>' +
         '</table>' +
        '</div>' +
		 '<div class="preview-pane">' +
           '<div id="new' + counter +'__preview">' +
           '</div>'+
        '</div>'+
		'<input type="hidden" id="new'+counter+'__field_id" name="new'+counter+'__field_id" value="'+id+'" /><input type="hidden" name="fields[]" value="new'+counter+'" />' +
		 '</td>' +															 
		 '</tr></table></div></li>');
		 
		jQuery('html, body').animate({scrollTop: jQuery("#bottom-of-page").offset().top}, 1000);
												   
																				

		counter++;
	}

	var counter = 1;
	
	jQuery('form button').on("click",function(e){
    e.preventDefault;
});
	</script>
<style>



.remove { 
  float: right;
  margin-right: -20px !important;
  margin-top: -20px  !important;
  border-radius: 100% !important;
  -webkit-border-radius: 100% !important;
  -moz-border-radius: 100%  !important;
  height: 20px !important;
  width: 20px !important;
  padding: 0px 0px 0px 0px !important;
  line-height: 15px !important;
  font-size: 12px !important;
  background-color: #ffffff !important;
  z-index: 99;
  transition: 1s ease-in-out;
  -webkit-transition: 1s ease-in-out;
}

.remove:hover {
	color: #cc0000 !important;
	border-color: #cc0000 !important;
	-moz-transform: rotate(720deg);
	-webkit-transform: rotate(720deg);
	-o-transform: rotate(720deg);
	-ms-transform: rotate(720deg);
	transform: rotate(720deg);

}
.form-options label, label.shortcode {
	font-weight: bold;
	display: block;
}

a#form_description_i3d_contact_form { display: none; }



#wp-form_description-wrap { margin-top: -30px; padding-left: 10px;}
#shortcode input[readonly] { cursor: pointer !important; background-color: #ffffff !important;}
#sortable select { line-height: 30px; height: 30px;  padding: 4px 6px;}

.input-prepend select {
    -moz-box-sizing: content-box;
    font-size: 14px;
    height: 20px !important;
    padding-bottom: 4px;
    padding-top: 4px;
	
	line-height: 30px !important;
}

#sortable .fa-icon-chooser { display: inline-block; 
-webkit-border-top-left-radius: 0px;
-webkit-border-bottom-left-radius: 0px;
-moz-border-radius-topleft: 0px;
-moz-border-radius-bottomleft: 0px;
border-top-left-radius: 0px;
border-bottom-left-radius: 0px;
margin-bottom: 0px;
font-size: 14px;
}
#sortable .fa-icon-chooser {margin-bottom: -10px; }

#sortable .fa-icon-chooser > li {
-webkit-border-top-left-radius: 0px;
-webkit-border-bottom-left-radius: 0px;
-moz-border-radius-topleft: 0px;
-moz-border-radius-bottomleft: 0px;
border-top-left-radius: 0px;
border-bottom-left-radius: 0px;
box-shadow: 0 0 0;
white-space: normal;
margin-bottom: 0px;

}
#sortable .fa-icon-chooser > li > a { 
-webkit-border-top-left-radius: 0px;
-webkit-border-bottom-left-radius: 0px;
-moz-border-radius-topleft: 0px;
-moz-border-radius-bottomleft: 0px;
border-top-left-radius: 0px;
border-bottom-left-radius: 0px;
padding-top: 7px;
padding-bottom: 7px;
}
#sortable .fa-icon-chooser ul.dropdown-menu {  margin-top: 5px; }

table.table-striped tr:first-child th {
  background-color: #eeeeee !important;	
}
.design textarea { width: 90%; }
table.table-striped {
	margin-bottom: 0px;
}
.preview-pane small { font-size: 8pt; 

text-transform: lowercase;
border-bottom: 1px solid #cccccc;
display: block;
}

.preview-pane { background-color: #ffffff; padding: 10px; border: 1px solid #cccccc;}
.preview-pane > div {  }
.preview-pane select, .preview-pane input { margin-bottom: 0px; }
.preview-pane label { padding-top: 3px; white-space: nowrap; width: auto; min-width:100px; display: block !important; }
.preview-pane .preview-text { float: right;
 padding: 0px 5px;
 margin-right: -10px;

text-transform: uppercase;

font-size: 8px;
background-color: #eeeeee;
margin-top: -10px;
}
.preview-pane h3 { margin: 0px; }

.mode-selector {
  margin-top: 5px; margin-left: 5px;
  
}
</style>
	<div class="wrap">
	

		<h2>Manage Contact Form  <a class="add-new-h2" href="admin.php?page=i3d_contact_forms&cmd=new">Add New</a> <a class="add-new-h2" href="admin.php?page=i3d_contact_forms">Cancel</a></h2>
  <?php if (@$doingSave) { ?>
  <div class='updated' style='padding-top: 10px; padding-bottom: 10px;'>
    Form saved.
  </div>
  <?php } ?>
  <div style='display:none;' id='temp-fontawesome'>
  <?php I3D_Framework::renderFontAwesomeSelect("newcounter__prepend_icon", "", false, '-- None --', '-- None --', "renderPreview('newcounter')"); ?>
  </div>
   <form method="post" style='max-width: 950px' id='the_form'>
<input style='float: right; padding: 0px 0px !important; width: 150px; margin-right: 10px;' type="submit" name="nocmd" class="button button-primary" value="<?php _e("Save Changes", "i3d-framework"); ?>" />
<ul class="nav nav-tabs">
  <li <?php if (@!$doingSave) { ?>class="active"<?php } ?>><a href="#settings" data-toggle="tab"><?php _e("Settings", "i3d-framework"); ?></a></li>
  <li <?php if (@$doingSave) { ?>class="active"<?php } ?>><a href="#fields" data-toggle="tab"><?php _e("Form Fields", "i3d-framework"); ?></a></li>
  <li><a href="#shortcode" data-toggle="tab"><?php _e("Shortcode", "i3d-framework"); ?></a></li>
</ul>
<script>
  function testSend() {
	  jQuery('#test-send-button').attr("disabled", true);
	  jQuery('#test-send-button').html('<i class="icon-gear icon-spin icon-large"></i>');
	  jQuery('#test-send-message').html("");
	  jQuery("#the_form input[name=cmd]").val("test");
	  jQuery("#the_form").attr("target", "silent-submit");
	  jQuery("#the_form").submit();		
	  jQuery("#the_form").removeAttr("target");
	  
	  //alert('submitted');
	}
</script>
<!-- Tab panes -->
<div class="tab-content">
  
  <div class="tab-pane <?php if (@!$doingSave) { ?>active<?php } ?>" id="settings">
  <ul style='max-width: 950px;' class='form-options'>
	<li>   
      <label><?php _e("Title", "i3d-framework"); ?></label>
      <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-text-height'></i> <?php _e("Size", "i3d-framework"); ?></span>
           <select name="form_title_wrap"   class='form-control' style='max-width: 200px;' >
                <option value="x" <?php if (@$form['form_title_wrap'] == "x") { ?>selected<?php } ?>>-- Do Not Display --</option>
                <option value="h1" <?php if (@$form['form_title_wrap'] == "h1") { ?>selected<?php } ?>>H1 (largest)</option>
                <option value="h2" <?php if (@$form['form_title_wrap'] == "h2") { ?>selected<?php } ?>>H2 (larger)</option>
                <option value="h3" <?php if (@$form['form_title_wrap'] == "h3" || @$form['form_title_wrap'] == "") { ?>selected<?php } ?>>H3 (default)</option>
                <option value="h4" <?php if (@$form['form_title_wrap'] == "h4") { ?>selected<?php } ?>>H4 (smaller)</option>
              </select>
	  </div>			  
      <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-align-left'></i> <?php _e("Alignment", "i3d-framework"); ?></span>
           <select name="form_title_alignment"   class='form-control' style='max-width: 200px;' >
                <option value="" <?php if (@$form['form_title_alignment'] == "") { ?>selected<?php } ?>>Default</option>
                <option value="left" <?php if (@$form['form_title_alignment'] == "left") { ?>selected<?php } ?>>Left</option>
                <option value="right" <?php if (@$form['form_title_alignment'] == "right") { ?>selected<?php } ?>>Right</option>
                <option value="center" <?php if (@$form['form_title_alignment'] == "center") { ?>selected<?php } ?>>Center</option>
              </select>
       </div>          
	      
        <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-quote-left'></i> <?php _e("Text", "i3d-framework"); ?></span>
            <input style='max-width: 200px;' class='form-control' type='text' name='form_title' value="<?php echo $form['form_title']; ?>" />
        </div>
	</li>
          <li style='margin-top: 20px;'><label><?php _e("Description", "i3d-framework"); ?></label>		  
          <?php wp_editor( @$form['form_description'], 'form_description', array('wpautop' => true, 'textarea_rows' => 3, 'media_buttons' => false) ); ?> 
          </li>
          <li style='margin-top: 20px;'>
          <label><?php _e("Redirect After Submit", "i3d-framework"); ?></label>
      <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-file-text-o'></i> <?php _e("Page", "i3d-framework"); ?></span>
          
          
           <select name="redirect_page" class='form-control' style='max-width: 200px;' >
            <?php renderRedirectPageOptions(@$form['redirect_page']); ?>
          </select>
          </div>
          </li>
          <li style='margin-top: 20px;'>
          <label><?php _e("Send Form Results To","i3d-framework"); ?></label>
      <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-envelope'></i> <?php _e("Email Address", "i3d-framework"); ?></span>
          
          
          <input class='form-control' style='max-width: 200px;'  type='text' name='form_email' value="<?php echo $form['form_email']; ?>" />
          &nbsp;<a id='test-send-button' class='btn btn-info' href='javascript:testSend();'>Test</a> <span id='test-send-message'></span>
		  <iframe name="silent-submit" id="silent-submit" style='display:none;'></iframe>
		  </div>
          </li>

		  
          <li style='margin-top: 20px;'>
          <label><?php _e("Buttons", "i3d-framework"); ?></label>
      <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-quote-left'></i> <?php _e("Submit Button Label", "i3d-framework"); ?></span>

          <input class='form-control' style='max-width: 200px;' type='text' name='submit_button_label' value="<?php echo $form['submit_button_label']; ?>" />
          </div>
      <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-undo'></i> <?php _e("Show Reset Button", "i3d-framework"); ?></span>
          
<select class='form-control' style='max-width: 200px;'  name="show_reset_button">
          <option value='0'><?php _e("No", "i3d-framework"); ?></option>
          <option value='1' <?php if ($form['show_reset_button'] == "1") { print "selected"; } ?>><?php _e("Yes", "i3d-framework"); ?></option>
          </select>
          </div>
          </li>

        </ul> 
  
  </div>
  <div class="tab-pane <?php if (@$doingSave) { ?>active<?php } ?>" id="fields">
   <input onclick='add_new_form_item()' style='float: right; padding: 0px 0px !important; width: 150px; margin-right: 10px; margin-top: 5px;' type="button"  class="button button-primary" value="Add New Field" />

        <input type='hidden' value='<?php echo $formID; ?>' name='form' />
        
        <div class="btn-group mode-selector" data-toggle="buttons">
          <label class="btn btn-default active">
            <input type="radio" name="mode" value="design" id="__mode_design" checked onchange='changeMode(this)'> Design
          </label>
          <label class="btn btn-default">
            <input type="radio" name="mode" value="visual" id="__mode_visual" onchange='changeMode(this)'> Layout
          </label>
        </div>      

		

 
		<?php
		
			$fields = @$form['fields'];
			
			
			
			$counter = 0;
			if (!is_array($fields)) {
				$fields = array();
			}

?>
		
<?php
			echo '<ul id="sortable" class="editordesign">';
			foreach($fields as $field) {
				$field = wp_parse_args( (array) $field, array( 'fieldtype' => 'text',
															  'fieldwidth' => 'span12', 
															  'show_field_label' => 1, 
															  'input_class' => '') );

			//only list image if it still exists
				//if(wp_attachment_is_image($image['id']) || $image['id'] == "default") {


	
	$fieldTypes = '<option '.($field['fieldtype'] == "text" ? "selected='selected'" : "").' value="text">Text</option>';
	$fieldTypes .= '<option '.($field['fieldtype'] == "textarea" ? "selected='selected'" : "").' value="textarea">Textarea</option>';
	$fieldTypes .= '<option '.($field['fieldtype'] == "checkbox" ? "selected='selected'" : "").' value="checkbox">Checkbox</option>';
	$fieldTypes .= '<option '.($field['fieldtype'] == "radio" ? "selected='selected'" : "").'  value="radio">Radio Button</option>';
	$fieldTypes .= '<option '.($field['fieldtype'] == "select" ? "selected='selected'" : "").' value="select">Select Box</option>';
	$fieldTypes .= '<option '.($field['fieldtype'] == "email" ? "selected='selected'" : "").' value="email">Email</option>';
	$fieldTypes .= '<option '.($field['fieldtype'] == "url" ? "selected='selected'" : "").' value="url">Website Address</option>';
	$fieldTypes .= '<option '.($field['fieldtype'] == "date" ? "selected='selected'" : "").' value="date">Date</option>';
	$fieldTypes .= '<option '.($field['fieldtype'] == "captcha3" ? "selected='selected'" : "").' value="captcha3">Google reCAPTCHA V3</option>';
	$fieldTypes .= '<option '.($field['fieldtype'] == "captcha2i" ? "selected='selected'" : "").' value="captcha2i">Google reCAPTCHA V2 (Invisible)</option>';
	$fieldTypes .= '<option '.($field['fieldtype'] == "captcha2" ? "selected='selected'" : "").' value="captcha2">Google reCAPTCHA V2</option>';
	$fieldTypes .= '<option disabled '.($field['fieldtype'] == "captcha" ? "selected='selected'" : "").' value="captcha">Google reCAPTCHA V1 (Deprecated)</option>';
	$fieldTypes .= '<option disabled '.($field['fieldtype'] == "skill" ? "selected='selected'" : "").' value="skill">Skill Testing Question (Deprecated)</option>';
	$fieldTypes .= '<option disabled>-- Display Options --</option>';
	$fieldTypes .= '<option '.($field['fieldtype'] == "heading" ? "selected='selected'" : "").' value="heading">Heading</option>';
	$fieldTypes .= '<option '.($field['fieldtype'] == "label" ? "selected='selected'" : "").' value="label">Label</option>';
//	$fieldTypes .= '<option '.($field['fieldtype'] == "file" ? "selected='selected'" : "").' value="file">File Upload</option>';
	$fieldTypes .= '<option '.($field['fieldtype'] == "separator" ? "selected='selected'" : "").' value="separator">Separator</option>';

	$fieldWidths  = '<option '.($field['fieldwidth'] == "span12" ? "selected='selected'" : "").' value="span12">100%</option>';
	$fieldWidths .= '<option '.($field['fieldwidth'] == "span9" ? "selected='selected'" : "").' value="span9">75%</option>';
	$fieldWidths .= '<option '.($field['fieldwidth'] == "span6" ? "selected='selected'" : "").' value="span6">50%</option>';
	$fieldWidths .= '<option '.($field['fieldwidth'] == "span3" ? "selected='selected'" : "").' value="span3">25%</option>';
					

?>
				<li id="field__<?php echo $counter; ?>" class="<?php echo $field['fieldwidth']?>"><div class='li-padder'>
		 <table id="<?php echo $counter; ?>__table" class="form_field" cellspacing="0" width="100%" height="100%">
		 <tr>											 
		 <td>
         <button class='remove button' name='nocmd' onclick='remove_field("<?php echo $counter; ?>");'><i class='fa fa-times'></i></button>
		 <div class="visual">
         	<span class="input-prepend" style='display: block;'>
                <span class="add-on visual50" style='width: 150px'><i class='fa fa-arrows-h'></i> Column Width</span>
                <select class="width" style='width: 100px' onchange="changeFieldWidth(this,'<?php echo $counter; ?>')" id="<?php echo $counter; ?>__fieldwidth" name="<?php echo $counter; ?>__fieldwidth"><?php echo $fieldWidths; ?></select>
         	</span>
         </div>
         <div id="field_details_all__<?php echo $counter; ?>" class="design">
         <table class='table table-striped'>
           <tr>
             <th style='width: 145px; '>Object <i class='fa fa-info-circle tt' title='This is the type of input field, or display object (Heading, Label, Separator) that you want to display.'></i></th>
             <th style='width: 145px; <?php if ($field['fieldtype'] == "captcha2i" || $field['fieldtype'] == "captcha3") { ?> display: none;<?php } ?>' class='field_details_container field_details__<?php echo $counter; ?>__all'>Name/Label <i class='fa fa-info-circle tt' title='Even if you are not showing the label, you must define the Name/Label in order for the contents of the field to be emailed to you.'></i></th>
             <th class='field_details_container field_details__<?php echo $counter; ?>__show_label' style='width: 70px; <?php if ($field['fieldtype'] == "captcha2i" || $field['fieldtype'] == "captcha3" || $field['fieldtype'] == "separator" || $field['fieldtype'] == "heading" || $field['fieldtype'] == "label"  || $field['fieldtype'] == "radio" || $field['fieldtype'] == "checkbox") {?> display: none;<?php } ?>'>Visible <i class='fa fa-info-circle tt' title='You may choose not to display the field label.'></i></th>
             <th class='field_details_container field_details__<?php echo $counter; ?>__show_icon' style='width: 105px;<?php if ($field['fieldtype'] == "captcha2i" || $field['fieldtype'] == "captcha3" || $field['fieldtype'] == "separator" || $field['fieldtype'] == "heading" || $field['fieldtype'] == "label"  || $field['fieldtype'] == "radio" || $field['fieldtype'] == "checkbox") {?> display: none;<?php } ?>'>Icon <i class='fa fa-info-circle tt' title='You may specify an icon that prepends the input field.'></i></th>
             <th class='field_details_container field_details__<?php echo $counter; ?>__required' style='width: 80px; <?php if ($field['fieldtype'] == "captcha2i" || $field['fieldtype'] == "captcha3" || $field['fieldtype'] == "separator" || $field['fieldtype'] == "captcha2" || $field['fieldtype'] == "heading" || $field['fieldtype'] == "label") {?>display: none;<?php } ?>'>Required <i class='fa fa-circle-sign tt' title='You may choose to make your input field required.'></i></th>
             <th class='field_details_container field_details__<?php echo $counter; ?>__input_width' <?php if ($field['fieldtype'] == "captcha2i" || $field['fieldtype'] == "captcha3" || $field['fieldtype'] == "separator" || $field['fieldtype'] == "heading" || $field['fieldtype'] == "label" || $field['fieldtype'] == "radio" || $field['fieldtype'] == "checkbox") { ?> style="display: none;"<?php } ?>>Width <i class='fa fa-info-circle tt' title='This is the width of the input field (for text, select boxes, and textareas)'></i></th>
             <th class='field_details_container field_details__<?php echo $counter; ?>__text'  <?php  if ($field['fieldtype'] != "text" && $field['fieldtype'] != "textarea" && $field['fieldtype'] != "email" && $field['fieldtype'] != "url" ) { ?>style="display: none;"<?php } ?>>Placeholder Text <i class='fa fa-info-circle tt' title='This is displayed in text, urls, email addresses, and textareas.'></i></th>
             <th class='field_details_container field_details__<?php echo $counter; ?>__checkbox' <?php  if ($field['fieldtype'] != "checkbox") { ?>style="display: none;"<?php } ?>>Checked Value <i class='fa fa-info-circle tt' title='This is required for checkboxes.'></i></th>
             <th class='field_details_container field_details__<?php echo $counter; ?>__options' <?php if ($field['fieldtype'] != "radio" && $field['fieldtype'] != "select") {?>style="display: none;"<?php } ?>>Options <i class='fa fa-info-circle tt' title='Specify an option on each line, for select boxes, or radio buttons.'></i></th>
             <th class='field_details_container field_details__<?php echo $counter; ?>__date' <?php if ($field['fieldtype'] != "date") {?>style="display: none;"<?php } ?>>Format <i class='fa fa-info-circle tt' title='Specify the date format you wish to collect.'></i></th>
             <th class='field_details_container field_details__<?php echo $counter; ?>__captcha2' <?php if ($field['fieldtype'] != "captcha2") {?>style="display: none;"<?php } ?>>Site Key <i class='fa fa-info-circle tt' title='Specify your V2 (Checkbox) Site Key.  Click the [G] icon to go to Google to get your Site and Secret Key.'></i> <a href='https://www.google.com/recaptcha/admin' target="_blank"><i class='fa fa-google'></i></a></th>
             <th class='field_details_container field_details__<?php echo $counter; ?>__captcha2' <?php if ($field['fieldtype'] != "captcha2") {?>style="display: none;"<?php } ?>>Secret Key <i class='fa fa-info-circle tt' title='Specify your V2 (Checkbox) Secret Key.  Click the [G] icon to go to Google to get your Site and Secret Key.'></i> <a href='https://www.google.com/recaptcha/admin' target="_blank"><i class='fa fa-google'></i></th>
             
             <th class='field_details_container field_details__<?php echo $counter; ?>__captcha2i' <?php if ($field['fieldtype'] != "captcha2i") {?>style="display: none;"<?php } ?>>Site Key <i class='fa fa-info-circle tt' title='Specify your V2 (Invisible) Site Key.  Click the [G] icon to go to Google to get your Site and Secret Key.'></i> <a href='https://www.google.com/recaptcha/admin' target="_blank"><i class='fa fa-google'></i></a></th>
             <th class='field_details_container field_details__<?php echo $counter; ?>__captcha2i' <?php if ($field['fieldtype'] != "captcha2i") {?>style="display: none;"<?php } ?>>Secret Key <i class='fa fa-info-circle tt' title='Specify your V2 (Invisible) Secret Key.  Click the [G] icon to go to Google to get your Site and Secret Key.'></i> <a href='https://www.google.com/recaptcha/admin' target="_blank"><i class='fa fa-google'></i></th>

             <th class='field_details_container field_details__<?php echo $counter; ?>__captcha3' <?php if ($field['fieldtype'] != "captcha3") {?>style="display: none;"<?php } ?>>Site Key <i class='fa fa-info-circle tt' title='Specify your V3 Site Key.  Click the [G] icon to go to Google to get your Site and Secret Key.'></i> <a href='https://www.google.com/recaptcha/admin' target="_blank"><i class='fa fa-google'></i></a></th>
             <th class='field_details_container field_details__<?php echo $counter; ?>__captcha3' <?php if ($field['fieldtype'] != "captcha3") {?>style="display: none;"<?php } ?>>Secret Key <i class='fa fa-info-circle tt' title='Specify your V3 Secret Key.  Click the [G] icon to go to Google to get your Site and Secret Key.'></i> <a href='https://www.google.com/recaptcha/admin' target="_blank"><i class='fa fa-google'></i></th>
             <th class='field_details_container field_details__<?php echo $counter; ?>__captcha3' <?php if ($field['fieldtype'] != "captcha3") {?>style="display: none;"<?php } ?>>Sensitivity </th>
				 
			 <th class='field_details_container field_details__<?php echo $counter; ?>__skill' <?php if ($field['fieldtype'] != "skill") {?>style="display: none;"<?php } ?>>&nbsp;</th>
             <th class='field_details_container field_details__<?php echo $counter; ?>__expansion' <?php if ($field['fieldtype'] != "separator" && $field['fieldtype'] != "heading" && $field['fieldtype'] != "label") { ?>style="display: none;"<?php } ?>>&nbsp;</th>
           
           
           </tr>
           <tr>
             <td><select style='width: auto;' onchange="changeFieldType(this,'<?php echo $counter; ?>')" id="<?php echo $counter; ?>__fieldtype" name="<?php echo $counter; ?>__fieldtype"><?php echo $fieldTypes; ?></select></td>
             <td class='field_details_container field_details__<?php echo $counter; ?>__all' <?php if ($field['fieldtype'] == "captcha2i" || $field['fieldtype'] == "captcha3") { ?>style='display: none;'<?php } ?>><input  onkeyup='renderPreview(<?php echo $counter; ?>);'  onchange='renderPreview(<?php echo $counter; ?>);'  style='width: 140px;' type="text" id="<?php echo $counter; ?>__label" name="<?php echo $counter; ?>__label" value="<?php echo $field['label']; ?>" /></td>
             <td class='field_details_container field_details__<?php echo $counter; ?>__show_label' <?php if ($field['fieldtype'] == "captcha2i" || $field['fieldtype'] == "captcha3" || $field['fieldtype'] == "separator" || $field['fieldtype'] == "heading" || $field['fieldtype'] == "label"  || $field['fieldtype'] == "radio" || $field['fieldtype'] == "checkbox") {?> style="display: none;"<?php } ?>><select onchange='renderPreview(<?php echo $counter; ?>);'  style='width: 60px;' class="design" id="<?php echo $counter; ?>__show_field_label" name="<?php echo $counter; ?>__show_field_label"><option value="0">No</option><option <?php if ($field['show_field_label'] == "1" || $field['show_field_label'] == "" ) { echo "selected"; } ?> value="1">Yes</option></select></td>
             <td class='field_details_container field_details__<?php echo $counter; ?>__show_icon' <?php if ($field['fieldtype'] == "captcha2i" || $field['fieldtype'] == "captcha3" || $field['fieldtype'] == "separator" || $field['fieldtype'] == "heading" || $field['fieldtype'] == "label"  || $field['fieldtype'] == "radio" || $field['fieldtype'] == "checkbox") {?> style="display: none;"<?php } ?>><?php I3D_Framework::renderFontAwesomeSelect("{$counter}__prepend_icon", $field['prepend_icon'], false, '-- None --', '-- None --', 'renderPreview('.$counter.')'); ?>
             <td class='field_details_container field_details__<?php echo $counter; ?>__required' <?php if ($field['fieldtype'] == "captcha2i" || $field['fieldtype'] == "captcha3" || $field['fieldtype'] == "separator" || $field['fieldtype'] == "heading" || $field['fieldtype'] == "captcha2" ||  $field['fieldtype'] == "label" ) {?>style="display: none;"<?php } ?>><select style='width: 60px;'  class="design" id="<?php echo $counter; ?>__required" name="<?php echo $counter; ?>__required"><option value="0">No</option><option <?php if ($field['required'] == "1" ) { echo "selected"; } ?> value="1">Yes</option></select></td>
             <td class='field_details_container field_details__<?php echo $counter; ?>__input_width' <?php if ($field['fieldtype'] == "captcha2i" || $field['fieldtype'] == "captcha3" || $field['fieldtype'] == "separator" || $field['fieldtype'] == "heading" || $field['fieldtype'] == "label" || $field['fieldtype'] == "radio" || $field['fieldtype'] == "checkbox") { ?> style="display: none;"<?php } ?>><select onchange='renderPreview(<?php echo $counter; ?>);' style='width: 60px;' class="design" id="<?php echo $counter; ?>__input_class" name="<?php echo $counter; ?>__input_class">
                   <?php if (I3D_Framework::$bootstrapVersion < 3) { ?>
                    <option value="">100%</option>
                   <option <?php if ($field['input_class'] == "input-xxlarge" ) { echo "selected"; } ?> value="input-xxlarge">XXLarge</option>
                   <option <?php if ($field['input_class'] == "input-xlarge" ) { echo "selected"; } ?> value="input-xlarge">XLarge</option>
                   <option <?php if ($field['input_class'] == "input-large" ) { echo "selected"; } ?> value="input-large">Large</option>
                   <option <?php if ($field['input_class'] == "input-medium" ) { echo "selected"; } ?> value="input-medium">Medium</option>
                   <option <?php if ($field['input_class'] == "input-small" ) { echo "selected"; } ?> value="input-small">Small</option>
                   <option <?php if ($field['input_class'] == "input-mini" ) { echo "selected"; } ?> value="input-mini">Mini</option>
                  
                   <?php } else { ?>
                   <option value="">100%</option>
                   <option <?php if ($field['input_class'] == "col-sm-9" ) { echo "selected"; } ?> value="col-sm-9">75%</option>
                   <option <?php if ($field['input_class'] == "col-sm-6" ) { echo "selected"; } ?> value="col-sm-6">50%</option>
                   <option <?php if ($field['input_class'] == "col-sm-3" ) { echo "selected"; } ?> value="col-sm-3">25%</option>
                   <option <?php if ($field['input_class'] == "col-sm-2" ) { echo "selected"; } ?> value="col-sm-2">16%</option>
                   <option <?php if ($field['input_class'] == "col-sm-1" ) { echo "selected"; } ?> value="col-sm-1">8%</option>
                   <?php } ?>
                   </select>
             </td>
             <td class='field_details_container field_details__<?php echo $counter; ?>__text field_details__<?php echo $counter; ?>__textarea'  <?php  if ($field['fieldtype'] != "text" && $field['fieldtype'] != "textarea" && $field['fieldtype'] != "email" && $field['fieldtype'] != "url" ) { ?>style="display: none;"<?php } ?>><input onkeyup='renderPreview(<?php echo $counter; ?>);' style='width: 140px;' type="text" id="<?php echo $counter; ?>__placeholder" name="<?php echo $counter; ?>__placeholder" value="<?php echo $field['placeholder']; ?>" /></td>
             <td class='field_details_container field_details__<?php echo $counter; ?>__checkbox' <?php  if ($field['fieldtype'] != "checkbox") { ?>style="display: none;"<?php } ?>><input style='width: 140px;' type="text" id="<?php echo $counter; ?>__checked_value" name="<?php echo $counter; ?>__checked_value" value="<?php echo $field['checked_value']; ?>" /></td>
             <td class='field_details_container field_details__<?php echo $counter; ?>__options' <?php if ($field['fieldtype'] != "radio" && $field['fieldtype'] != "select") { ?>style="display: none;"<?php } ?>><textarea onkeyup='renderPreview(<?php echo $counter; ?>);'  style='width: 140px;'  id="<?php echo $counter; ?>__options" name="<?php echo $counter; ?>__options"><?php echo $field['options']; ?></textarea>
             <div class='field_details_container field_details__<?php echo $counter; ?>__multiple'  <?php if ( $field['fieldtype'] != "select") { ?>style="display: none;"<?php } ?>><select onkeyup='renderPreview(<?php echo $counter; ?>);'  style='width: 150px;' id="<?php echo $counter; ?>__multiple" name="<?php echo $counter; ?>__multiple"><option value="0">Single</option><option <?php if ($field['multiple'] == "1" ) { echo "selected"; } ?> value="1">Multi-Select</option></select></div>
             
             </td>
             <td class='field_details_container field_details__<?php echo $counter; ?>__date' <?php if ($field['fieldtype'] != "date") { ?>style="display: none;"<?php } ?>>
             	<select style='width: 140px;'  class="design" id="<?php echo $counter; ?>__date_format" name="<?php echo $counter; ?>__date_format">
                	<option <?php if (@$field['date_format'] == "mm/dd/yyyy" ) { echo "selected"; } ?> value="mm/dd/yyyy">mm/dd/yyyy</option>
                	<option <?php if (@$field['date_format'] == "mm-dd-yyyy" ) { echo "selected"; } ?> value="mm-dd-yyyy">mm-dd-yyyy</option>
                	<option <?php if (@$field['date_format'] == "dd/mm/yyyy" ) { echo "selected"; } ?> value="dd/mm/yyyy">dd/mm/yyyy</option>
                	<option <?php if (@$field['date_format'] == "dd-mm-yyyy" ) { echo "selected"; } ?> value="dd-mm-yyyy">dd-mm-yyyy</option>
                	<option <?php if (@$field['date_format'] == "m d, yyyy" ) { echo "selected"; } ?> value="m d, yyyy">m d, yyyy</option>
                	<option <?php if (@$field['date_format'] == "yyyy-mm-dd" ) { echo "selected"; } ?> value="yyyy-mm-dd">yyyy-mm-dd</option>
                </select>
             </td>
			   
            <td class='field_details_container field_details__<?php echo $counter; ?>__captcha2' <?php if ($field['fieldtype'] != "captcha2") { ?>style="display: none;"<?php } ?>>
             	<input type='text' style='width: 50px;'  class="design" id="<?php echo $counter; ?>__site_key" name="<?php echo $counter; ?>__site_key" value="<?php echo $field['site_key']; ?>">
             </td>             
            <td class='field_details_container field_details__<?php echo $counter; ?>__captcha2' <?php if ($field['fieldtype'] != "captcha2") { ?>style="display: none;"<?php } ?>>
             	<input type='text' style='width: 50px;'  class="design" id="<?php echo $counter; ?>__secret_key" name="<?php echo $counter; ?>__secret_key" value="<?php echo $field['secret_key']; ?>">
             </td>
			   
            <td class='field_details_container field_details__<?php echo $counter; ?>__captcha2i' <?php if ($field['fieldtype'] != "captcha2i") { ?>style="display: none;"<?php } ?>>
             	<input type='text' style='width: 150px;'  class="design" id="<?php echo $counter; ?>__site_key_v2i" name="<?php echo $counter; ?>__site_key_v2i" value="<?php echo $field['site_key_v2i']; ?>">
            </td>             
            <td class='field_details_container field_details__<?php echo $counter; ?>__captcha2i' <?php if ($field['fieldtype'] != "captcha2i") { ?>style="display: none;"<?php } ?>>
             	<input type='text' style='width: 150px;'  class="design" id="<?php echo $counter; ?>__secret_key_v2i" name="<?php echo $counter; ?>__secret_key_v2i" value="<?php echo $field['secret_key_v2i']; ?>">
            </td>

            <td class='field_details_container field_details__<?php echo $counter; ?>__captcha3' <?php if ($field['fieldtype'] != "captcha3") { ?>style="display: none;"<?php } ?>>
             	<input type='text' style='width: 150px;'  class="design" id="<?php echo $counter; ?>__site_key_v3" name="<?php echo $counter; ?>__site_key_v3" value="<?php echo $field['site_key_v3']; ?>">
            </td>             
            <td class='field_details_container field_details__<?php echo $counter; ?>__captcha3' <?php if ($field['fieldtype'] != "captcha3") { ?>style="display: none;"<?php } ?>>
             	<input type='text' style='width: 150px;'  class="design" id="<?php echo $counter; ?>__secret_key_v3" name="<?php echo $counter; ?>__secret_key_v3" value="<?php echo $field['secret_key_v3']; ?>">
            </td>			   
            <td class='field_details_container field_details__<?php echo $counter; ?>__captcha3' <?php if ($field['fieldtype'] != "captcha3") { ?>style="display: none;"<?php } ?>>
             	<select style='width: 100px;'  class="design" id="<?php echo $counter; ?>__threshold_v3" name="<?php echo $counter; ?>__threshold_v3">
				  <option <?php if ($field['threshold_v3'] == '1.0') { print "selected"; } ?> value='1.0'>1.0 (High)</option>
				  <option <?php if ($field['threshold_v3'] == '0.9') { print "selected"; } ?> value='0.9'>0.9</option>
				  <option <?php if ($field['threshold_v3'] == '0.8') { print "selected"; } ?> value='0.8'>0.8</option>
				  <option <?php if ($field['threshold_v3'] == '0.7') { print "selected"; } ?> value='0.7'>0.7</option>
				  <option <?php if ($field['threshold_v3'] == '0.6') { print "selected"; } ?> value='0.6'>0.6</option>
				  <option <?php if ($field['threshold_v3'] == '0.5') { print "selected"; } ?> value='0.5'>0.5 (Mid)</option>
				  <option <?php if ($field['threshold_v3'] == '0.4') { print "selected"; } ?> value='0.4'>0.4</option>
				  <option <?php if ($field['threshold_v3'] == '0.3') { print "selected"; } ?> value='0.3'>0.3</option>
				  <option <?php if ($field['threshold_v3'] == '0.2') { print "selected"; } ?> value='0.2'>0.2</option>
				  <option <?php if ($field['threshold_v3'] == '0.1') { print "selected"; } ?> value='0.1'>0.1 (Weak) </option>
				 
				</select>
            </td>			   
			   
             <td class='field_details_container field_details__<?php echo $counter; ?>__skill' <?php if ($field['fieldtype'] != "skill") { ?>style="display: none;"<?php } ?>>
             	<div style='width: 140px;'>&nbsp;</div>
             </td>
             <td class='field_details_container field_details__<?php echo $counter; ?>__expansion' <?php if ($field['fieldtype'] != "separator" && $field['fieldtype'] != "heading"&& $field['fieldtype'] != "label") { ?>style="display: none;"<?php } ?>>
             	<div style='width: 140px;'>&nbsp;</div>
             </td>
          </tr>
         </table>

         </div>
		 <div class='preview-pane'>
           <div id='<?php echo $counter; ?>__preview'>
            
           </div>
         </div>
         <script>
		   renderPreview(<?php echo $counter; ?>);
		 </script>
         <input type="hidden" name="fields[]" value="<?php echo $counter; ?>" />
		 </td>														 
		 </tr></table>
         </div>
         
         </li>

<?php

					$counter++;
			//	}
			}
		?>
			</ul>
            
			<input type="hidden" name="cmd" value="save" />
<div id='bottom-of-page' style='clear: both;'></div>&nbsp;
  
  </div>
  <div class="tab-pane" id="shortcode">
  <p>You can copy and place this shortcode within any page.  Simply click in the text area below, and press CTRL/CMD-C on your keyboard.  Then, within the edit region of your page, paste (CTRL/CMD-V) the shortcode, and then save your page.</p>
  
        <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-share'></i> <?php _e("Shortcode", "i3d-framework"); ?></span>
<input readonly onclick='this.select();' onfocus='this.select();'style='max-width: 500px;' class='input-xlarge' type="text" value="[i3d_contact_form id=<?php echo $formID; ?>]" />
</div>
  </div>
</div>
       
     

	</form>
	</div>
    <script>
	jQuery(document).ready(function() {
	jQuery(".tt").tooltip();
									});
	</script>
	<?php
}
function i3d_contact_forms_contextual_help( $contextual_help, $screen_id, $screen ) { 
		if (I3D_Framework::$supportType == "i3d") { 

	if (strstr($screen->id, '_page_i3d_contact_forms')) {
		ob_start();
		?>
        <h3>Contact Forms</h3>
        <p>You can create as many forms as you need for your website.  Click on the "<strong>Add New</strong>" button below to create a new form.</p>
        <p><a style='margin: 5px 0px;' class='btn btn-default' href="http://youtu.be/ProIrVGePk4" target="_blank"><i class='fa fa-play-circle'></i> Watch The Help Video</a></p>

        
        <p><strong>Special Operations</strong></p>
        <ul>
        	<li><a onclick='return confirm("Are you certain you wish to delete all of your forms? This cannot be undone.")' href="?page=i3d_contact_forms&cmd=reset">Delete All Forms</a> <span class='label label-danger'>Warning -- this cannot be undone!</span></li>
        	<li><a href="?page=i3d_contact_forms&cmd=init">Install Default Forms</a></li>
        </ul>
        <?php
		
		
		$contextual_help = ob_get_clean();

	} 
		}
	return $contextual_help;
}
add_action( 'contextual_help', 'i3d_contact_forms_contextual_help', 10, 3 );

?>