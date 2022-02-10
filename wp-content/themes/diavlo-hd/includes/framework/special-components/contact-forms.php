<?php
/************************************************** CONTACT FORMS **************************************************/
add_shortcode('i3d_contact_form', 'i3d_contact_form');

if (!class_exists("i3dReCaptchaResponse")) {
		/**
	 * A ReCaptchaResponse is returned from recaptcha_check_answer()
	 */
	class i3dReCaptchaResponse {
			var $is_valid;
			var $error;
			var $score;
	}

	
}


if (!class_exists("i3dReCaptcha2")) { 

class i3dReCaptcha2
{
    private static $_signupUrl = "https://www.google.com/recaptcha/admin";
    private static $_siteVerifyUrl =
        "https://www.google.com/recaptcha/api/siteverify?";
    private $_secret;
    private static $_version = "php_1.0";

    /**
     * Constructor.
     *
     * @param string $secret shared secret between site and ReCAPTCHA server.
     */
    function i3dReCaptcha2($secret)
    {
        if ($secret == null || $secret == "") {
            die("To use reCAPTCHA you must get an API key from <a href='"
                . self::$_signupUrl . "'>" . self::$_signupUrl . "</a>");
        }
        $this->_secret=$secret;
    }

    /**
     * Encodes the given data into a query string format.
     *
     * @param array $data array of string elements to be encoded.
     *
     * @return string - encoded request.
     */
    private function _encodeQS($data)
    {
        $req = "";
        foreach ($data as $key => $value) {
            $req .= $key . '=' . urlencode(stripslashes($value)) . '&';
        }

        // Cut the last '&'
        $req=substr($req, 0, strlen($req)-1);
        return $req;
    }

    /**
     * Submits an HTTP GET to a reCAPTCHA server.
     *
     * @param string $path url path to recaptcha server.
     * @param array  $data array of parameters to be sent.
     *
     * @return array response
     */
    private function _submitHTTPGet($path, $data)
    {
        $req = $this->_encodeQS($data);
		$allow_url_fopen = ini_get("allow_url_fopen");
		
		if ($allow_url_fopen) {
        	$response = file_get_contents($path . $req);
		} else {
			$ch = curl_init(); //init
			curl_setopt($ch, CURLOPT_URL, $path . $req); 
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);  // follow redirects
			curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // return the response
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
			
			// send request and store response in variable
			$response = @curl_exec($ch);	
		}
        return $response;
    }

    /**
     * Calls the reCAPTCHA siteverify API to verify whether the user passes
     * CAPTCHA test.
     *
     * @param string $remoteIp   IP address of end user.
     * @param string $response   response string from recaptcha verification.
     *
     * @return ReCaptchaResponse
     */
    public function verifyResponse($remoteIp, $response)
    {
        // Discard empty solution submissions
        if ($response == null || strlen($response) == 0) {
            $recaptchaResponse = new i3dReCaptchaResponse();
            $recaptchaResponse->success = false;
            $recaptchaResponse->errorCodes = 'missing-input';
            return $recaptchaResponse;
        }

        $getResponse = $this->_submitHttpGet(
            self::$_siteVerifyUrl,
            array (
                'secret' => $this->_secret,
                'remoteip' => $remoteIp,
                'v' => self::$_version,
                'response' => $response
            )
        );
        $answers = json_decode($getResponse, true);
		//var_dump($answers);
        $recaptchaResponse = new i3dReCaptchaResponse();

        if (trim($answers ['success']) == true) {
            $recaptchaResponse->success = true;
			if (array_key_exists("score", $answers)) {
				$recaptchaResponse->score = $answers['score'];
			}
        } else {
            $recaptchaResponse->success = false;
            $recaptchaResponse->errorCodes = $answers [error-codes];
        }

        return $recaptchaResponse;
    }
	
  	
}
}

function i3d_contact_form($atts) {
	 if (file_exists("google-recpatcha/recaptchalib.php")) {
		 require_once("google-recaptcha/recaptchalib.php");  
	 } else {
		i3d_load_recaptcha_lib();
	 }
	global $page;
		
	extract($atts);	
	global $i3dBootstrapVersion;
	
	$forms = get_option("i3d_contact_forms");
	if (!isset($id) || !isset($forms) || !isset($forms["$id"])) {
		return "<p>It looks like you have not yet selected a form for this page.</p>";
		//return;
	}
	$form = $forms["$id"];
    $form = wp_parse_args( (array) $form, array( 'form_title' => '', 'form_title_wrap' => '', 'show_reset_button' => '', 'google_recaptcha_private_key' => '6Ld1htoSAAAAAHc7SI-RwWI71aR0YaVSze77fczU', 'google_recaptcha_public_key' => '6Ld1htoSAAAAAEayI5F-fVLCYaICJpaodJHuGb9R') );
	
$hasReCaptcha = false;
	if (array_key_exists("cmd", $_POST) && array_key_exists("form_id", $_POST) && $_POST['cmd'] == "submit" && $id == $_POST['form_id']) {
		$to = $form['form_email'];
		$subject = $form['form_title'];
				$headers  = array('MIME-Version: 1.0', 'Content-Type: text/html; charset=UTF-8');

		//$headers  = 'MIME-Version: 1.0';
		//$headers .= "\r\nContent-Type: text/html";
		//$headers .= "\r\nFrom: ".get_site_option('admin_email');
		
		//$headers = "From: ".get_site_option('admin_email');
		//$headers .= "\r\nContent-Type: text/html";
		unset($_POST['cmd']);
				unset($_POST['form_id']);
		
		
		
		$message = "<h3>{$form['form_title']}</h3>";
		$message .= "<p>{$form['form_description']}</p>";
		$hasSkill = false;
		$hasCaptcha = false;
		
		foreach ($form['fields'] as $fid => $field) {
		  if ($field['fieldtype'] == "captcha") {
			  $hasCaptcha = true;
		  } else if ($field['fieldtype'] == "captcha2") {
			  $hasCaptcha2 = true;
			  $secret_key = $field['secret_key'];
			  $site_key = $field['site_key'];
		  } else if ($field['fieldtype'] == "captcha2i") {
			  $hasCaptcha2i = true;
			  $secret_key = $field['secret_key_v2i'];
			  $site_key = $field['site_key_v2i'];
		  } else if ($field['fieldtype'] == "captcha3") {
			  $hasCaptcha3 = true;
			  $secret_key = $field['secret_key_v3'];
			  $site_key = $field['site_key_v3'];
			  $threshold = $field['threshold_v3'];
		  }
		}
		$passedSkill = false;
		foreach ($_POST as $key => $value) {
		  if ($key == "skilltest") {
		    $hasSkill = true;
			$answer = $_POST['skillanswer'] / 5;
		    if ($value == $answer) {
				$passedSkill = true;
			}
            continue;
		  
		  } else if ($key == "skillanswer") {
			  continue;
		  }  else if ($key == "recaptcha_challenge_field" || $key == "recpatcha_reponse_field") {
			  continue;
		  } else if ($key == "g-recaptcha-response") {
			continue;  
		  }
		  $message .= "<strong>".str_replace("_", " ", $key).":</strong> ".$value."<br>";

		}
		$passedCaptcha = false;
		
		if ($hasCaptcha2) { 
		 
		 	$reCaptcha 	= new i3dReCaptcha2($secret_key);
			$resp 		= $reCaptcha->verifyResponse($_SERVER["REMOTE_ADDR"], $_POST["g-recaptcha-response"]);
		
				if (!$resp->success) {
					print ("<div class='alert alert-danger'>The reCAPTCHA was not entered correctly.  Your form submission was not completed.  Please try again.</div>");
					  } else {
						$passedCaptcha2 = true;
					  }
			
		} else if ($hasCaptcha2i) { 
		 
		 	$reCaptcha 	= new i3dReCaptcha2($secret_key);
			$resp 		= $reCaptcha->verifyResponse($_SERVER["REMOTE_ADDR"], $_POST["g-recaptcha-response"]);
		
				if (!$resp->success) {
					print ("<div class='alert alert-danger'>The reCAPTCHA was not entered correctly.  Your form submission was not completed.  Please try again.</div>");
					} else {
						$passedCaptcha2i = true;
				}			
		} else if ($hasCaptcha3) { 
		 
		 	$reCaptcha 	= new i3dReCaptcha2($secret_key);
			$resp 		= $reCaptcha->verifyResponse($_SERVER["REMOTE_ADDR"], $_POST["g-recaptcha-response"]);
		
			
			
				if (!$resp->success) {
					print ("<div class='alert alert-danger'>The reCAPTCHA was not entered correctly.  Your form submission was not completed.  Please try again.</div>");
				} else if ($resp->score < $threshold) {
					print ("<div class='alert alert-danger'>Your form submission was not completed due to an invalid recaptcha score.  Please try again.</div>");

				} else {
					
						$passedCaptcha3 = true;
				}
		} else if ($hasCaptcha) {
			$resp = recaptcha_check_answer ($form['google_recaptcha_private_key'],
									$_SERVER["REMOTE_ADDR"],
									$_POST["recaptcha_challenge_field"],
									$_POST["recaptcha_response_field"]);
	
	  		if (!$resp->is_valid) {
				// What happens when the CAPTCHA was entered incorrectly
				print ("<div class='alert alert-danger'>The reCAPTCHA was not entered correctly.  Your form submission was not completed.  Please try again.</div>");
				//return
  			   
			} else {
				$passedCaptcha = true;
			}
			
		}
		if ($hasSkill && !$passedSkill) {
		   print("<div class='alert alert-danger'>The skill testing answer was not entered correctly.  Your form submission was not completed.  Please try again.</div>");
		} else if ($hasCaptcha2 && !$passedCaptcha2) {
		} else if ($hasCaptcha2i && !$passedCaptcha2i) {
		} else if ($hasCaptcha3 && !$passedCaptcha3) {
			// we already displayed the error message
		//	print "failed captcha?";
		} else if ($hasCaptcha && !$passedCaptcha) { 
			// we already displayed the error message
		
		} else {
					 $success = @wp_mail($to, $subject, $message, $headers);

		  //@mail($to, $subject, $message, $headers);
		  $permalink = get_permalink($form['redirect_page']);
		  wp_redirect($permalink);
		} 

	}
	
	//global $i3d_theme_extender;
	//@$i3d_theme_extender->include_google_recaptcha();
	ob_start();
	
	print "<div class='i3d_contact_form'>";
	if ($form['form_title'] != "" && $form['form_title_wrap'] != "x") {
		if ($form['form_title_wrap'] == "") {
			$form['form_title_wrap'] = "h3";
		}
	  $form_title_alignment = @$form['form_title_alignment'];
	  
	  print "<{$form['form_title_wrap']} class='title";
	  if ($form_title_alignment != "") {
		 print " text-".$form_title_alignment;
	  }
	  print "'>{$form['form_title']}</{$form['form_title_wrap']}>";	
	}
	if ($form['form_description'] != "") {
		print "<".I3D_Framework::$formDescriptionWrapperTag." class='description'>";
		echo wpautop($form['form_description']);
	    print "</".I3D_Framework::$formDescriptionWrapperTag.">";
	}
	
	
	
	print "<form class='form-horizontal' method='post' id='{$id}'>";
	print "<input type='hidden' name='form_id' value='{$id}' />";

	print "<input type='hidden' name='cmd' value='submit' />";
	if ($i3dBootstrapVersion >= 3) {
	  print "<div class='row'>";
	} else {
	  print "<div class='row-fluid'>";
	}
	$currentCount = 0;
	$hasSkillQuestion = false;

	if (is_array($form['fields'])) {
	
	foreach ($form['fields'] as $fid => $field) {
		      $field = wp_parse_args( (array) $field, array( 'fieldwidth' => '', 'fieldtype' => '', 'placeholder' => '', 'input_class' => '', 'date_format' => '') );
	  $thisCount = str_replace("span", "", $field['fieldwidth']);
	  if ($currentCount + $thisCount > 12) {
		  print "</div><div class='row".($i3dBootstrapVersion < 3 ? "-fluid" : "")."'>";
		  $currentCount = 0;
	  }
	  $currentCount += $thisCount;
	  if ($field['fieldtype'] == "skill") {
		  $question = date("N")." &#43; ".date("n");
		  $skillAnswer = date("N")+date("n");
		  $field['placeholder'] .= "({$question})";

	  }
	
	  ?><div <?php 
		if ($field['fieldtype'] == "separator") { 
	  		echo "style='clear: both;' class='".($i3dBootstrapVersion >= 3 ? "col-sm-12" : "span11")."'"; 
		} else { 

		  
		   $class = ($i3dBootstrapVersion >= 3 ? str_replace("span", "col-sm-", $field['fieldwidth']) : $field['fieldwidth']);
		 
		   
		   echo "class='{$class}'"; 
		 }
	   ?>><?php 
	   
	  if ($field['fieldtype'] != "separator") { 
	  if ($field['fieldtype'] != 'captcha3' && $field['fieldtype'] != 'captcha2i' && $field['fieldtype'] != "label" && $field['fieldtype'] != "heading"  && @$field['show_field_label'] != "0") { ?><label class='regular-label'><?php echo $field['label']; ?></label><?php } ?>
        <?php if ($field['prepend_icon'] != "") { 
		  if ($i3dBootstrapVersion >= 3) { 
		  ?><div class="form-group"><label class="col-sm-2 control-label" for=""><span class="input-group-addon"><i class="<?php echo I3D_Framework::conditionFontAwesomeIcon($field['prepend_icon']); ?>"></i></span></label><div class="col-sm-10"><?php
		  } else {	
		  ?><span class="input-prepend row-fluid"><span class="add-on"><i class="<?php echo $field['prepend_icon']; ?>"></i></span><?php 
		  } 
		  } 
		  
		    $originalLabel = $field['label'];
			$field['label'] = str_replace(" ", "_", $field['label']);

		 if ($field['fieldtype'] == "email") {
					   		  if ($i3dBootstrapVersion >= 3 && $field['input_class'] != "") {  print "<div><div class='{$field['input_class']}' style='padding-left: 0px !important;'>"; }

			?><input type='email' <?php if ($i3dBootstrapVersion >= 3) { print "class='form-control'"; } else { print "class='".($field['input_class'] == "" ? "input-block-level" : $field['input_class'])."'"; } ?> name="<?php  echo $field['label']; ?>" <?php if ($field['required'] == "1") { print "required"; } ?> placeholder="<?php echo $field['placeholder']; ?>" value='<?php echo format_to_edit(@$_POST["{$field['label']}"]); ?>' /><?php 
		 				  if ($i3dBootstrapVersion >= 3 && $field['input_class'] != "") {  print "</div></div>"; }

		 } else if ($field['fieldtype'] == "url") { 
		 		   		  if ($i3dBootstrapVersion >= 3 && $field['input_class'] != "") {  print "<div><div class='{$field['input_class']}' style='padding-left: 0px !important;'>"; }

		 ?><input type='url'  <?php if ($i3dBootstrapVersion >= 3) { print "class='form-control'"; } else { print "class='".($field['input_class'] == "" ? "input-block-level" : $field['input_class'])."'"; } ?> name="<?php  echo $field['label']; ?>" <?php if ($field['required'] == "1") { print "required"; } ?> placeholder="<?php echo $field['placeholder']; ?>" value='<?php echo format_to_edit(@$_POST["{$field['label']}"]); ?>' /><?php 
		 
		 				  if ($i3dBootstrapVersion >= 3 && $field['input_class'] != "") {  print "</div></div>"; }


		 } else if ($field['fieldtype'] == "captcha") {
			 $hasReCaptcha = true;
                         $recaptchaV = 1;
			 		   		  if ($i3dBootstrapVersion >= 3 && $field['input_class'] != "") {  print "<div><div class='{$field['input_class']}' style='padding-left: 0px !important;'>"; }

			 ?><script type="text/javascript" src="//www.google.com/recaptcha/api/challenge?k=<?php echo $form['google_recaptcha_public_key']; ?>"></script>
<noscript><iframe src="//www.google.com/recaptcha/api/noscript?k=<?php echo $form['google_recaptcha_public_key']; ?>" height="300" width="500" frameborder="0"></iframe><br><textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea><input type="hidden" name="recaptcha_response_field" value="manual_challenge" /></noscript><?php
	 if ($i3dBootstrapVersion >= 3 && $field['input_class'] != "") {  print "</div></div>"; }


 } else if ($field['fieldtype'] == "captcha2") {
			 $hasReCaptcha = true;
                         $recaptchaV = 2;			 
		   		  if ($i3dBootstrapVersion >= 3 && $field['input_class'] != "") {  print "<div><div class='{$field['input_class']}' style='padding-left: 0px !important;'>"; }

			 ?>
             <div class="g-recaptcha" data-sitekey="<?php echo $field['site_key']; ?>"></div>
<?php
	 if ($i3dBootstrapVersion >= 3 && $field['input_class'] != "") {  print "</div></div>"; }


} else if ($field['fieldtype'] == "captcha2i") {
			 $hasReCaptcha = true;
             $recaptchaV   = "2i";		
			 $site_key    = $field['site_key_v2i'];
			

} else if ($field['fieldtype'] == "captcha3") {
			 $hasReCaptcha = true;
             $recaptchaV   = "3";		
			 $site_key    = $field['site_key_v3'];
			

		 } else if ($field['fieldtype'] == "skill") {
			 $hasSkillQuestion = true;
			 		   		  if ($i3dBootstrapVersion >= 3 && $field['input_class'] != "") {  print "<div><div class='{$field['input_class']}' style='padding-left: 0px !important;'>"; }

			 ?><input type='text'  <?php if ($i3dBootstrapVersion >= 3) { print "class='form-control'"; } else { print "class='".($field['input_class'] == "" ? "input-block-level" : $field['input_class'])."'"; } ?> name="skilltest" required placeholder="<?php echo $field['placeholder']; ?>" /><input type='hidden'  name="skillanswer" value="<?php print $skillAnswer * 5; ?>" /><?php
		 				  if ($i3dBootstrapVersion >= 3 && $field['input_class'] != "") {  print "</div></div>"; }

		 } else if ($field['fieldtype'] == "checkbox") { 
		 ?><input  type='checkbox' name="<?php echo $field['label']; ?>" <?php if ($field['required'] == "1") { print "required"; } ?> value="<?php echo $field['checked_value']?>" <?php  if (@$_POST["{$field['label']}"] == $field['checked_value']) { print "checked"; } ?> /><?php 
		 
		 } else if ($field['fieldtype'] == "select") {
			 		   		  if ($i3dBootstrapVersion >= 3 && $field['input_class'] != "") {  print "<div><div class='{$field['input_class']}' style='padding-left: 0px !important;'>"; }

			 ?><select <?php if ($i3dBootstrapVersion >= 3) { print "class='form-control'"; } else { print "class='".($field['input_class'] == "" ? "input-block-level" : $field['input_class'])."'"; } ?> <?php if ($field['multiple'] == "1") { ?>multiple<?php } ?> name="<?php echo $field['label']; ?>"><?php 
		 $options = explode("\n", $field['options']);
		 foreach ($options as $option) {
			 $optionData = explode("=", $option);
			 $optionData[1] = trim($optionData[1]);
			 
			 print "<option ";
			 
			 if ($field['multiple'] == "1" && is_array(@$_POST["{$field['label']}"])) {
				 if (in_array($optionData[0], $_POST["{$field['label']}"])) {
					print " selected "; 						 
				 }
			 } else if (@$_POST["{$field['label']}"] == @$optionData[0]) { 
			 	print " selected "; 
			} 
			

			 print " value='{$optionData[0]}'>".($optionData[1] != "" ? $optionData[1] : $optionData[0])."</option>";
		 }
		 ?></select><?php 
		 
		 				  if ($i3dBootstrapVersion >= 3 && $field['input_class'] != "") {  print "</div></div>"; }

		 } else if ($field['fieldtype'] == "radio") {
		 $options = explode("\n", $field['options']);
		 $oid = 0;
			 foreach ($options as $option) {
				 $oid++;
				 $optionData = explode("=", $option);
				 print "<br/><input id='{$fid}-{$oid}' type='radio' name='{$field['label']}' ";
				 
                                 if ($field['required'] == "1") { print " required "; }
                                 if (@$_POST["{$field['label']}"] == @$optionData[0]) { print " checked "; } 
				 if (@$optionData[1] == "") {
				 	print "value='".@$optionData[0]."'> <label for='{$fid}-{$oid}'>".@$optionData[0]."</label>";
				 
				 } else {
				 	print "value='".@$optionData[0]."'> <label for='{$fid}-{$oid}'>".@$optionData[1]."</label>";
				 }
			 }
		 } else if ($field['fieldtype'] == "label") { ?><p><?php echo $originalLabel; ?></p><?php 
		 } else if ($field['fieldtype'] == "heading") { ?><h4><?php echo $originalLabel; ?></h4><?php 
		 } else if ($field['fieldtype'] == "textarea") {
		   if ($i3dBootstrapVersion >= 3 && $field['input_class'] != "") {  print "<div><div class='{$field['input_class']}' style='padding-left: 0px !important;'>"; }

		   ?><textarea  <?php if ($i3dBootstrapVersion >= 3) { print "class='form-control'"; } else { print "class='".($field['input_class'] == "" ? "input-block-level" : $field['input_class'])."'"; } ?> name="<?php echo $field['label']; ?>" <?php if ($field['required'] == "1") { print "required"; } ?> placeholder="<?php echo $field['placeholder']; ?>"><?php  echo @$_POST["{$field['label']}"]; ?></textarea><?php 
						  if ($i3dBootstrapVersion >= 3 && $field['input_class'] != "") {  print "</div></div>"; }

		} else if ($field['fieldtype'] == "date") {
					   		  if ($i3dBootstrapVersion >= 3 && $field['input_class'] != "") {  print "<div><div class='{$field['input_class']}' style='padding-left: 0px !important;'>"; }

			?><input id='dp<?php echo $fid; ?>'  data-date-format="yyyy-mm-dd" type='date' <?php if ($i3dBootstrapVersion >= 3) { print "class='form-control {$field['input_class']}'"; } else { print "class='".($field['input_class'] == "" ? "input-block-level" : $field['input_class'])."'"; } ?> name="<?php echo $field['label']; ?>" <?php if ($field['required'] == "1") { print "required"; } ?> placeholder="yyyy-mm-dd" value='<?php //echo format_to_edit(@$_POST["{$field['label']}"]); ?>'  />
<script>jQuery(document).ready(function() { if (!checkDateInput()) { jQuery("#dp<?php echo $fid; ?>").datepicker(); } });</script>
<?php 
						  if ($i3dBootstrapVersion >= 3 && $field['input_class'] != "") {  print "</div></div>"; }

		} else if ($field['fieldtype'] == "text") { 
		  if ($i3dBootstrapVersion >= 3 && $field['input_class'] != "") {  print "<div><div class='{$field['input_class']}' style='padding-left: 0px !important;'>"; }
		  ?><input type='text' <?php if ($i3dBootstrapVersion >= 3) { print "class='form-control'"; } else { print "class='".($field['input_class'] == "" ? "input-block-level" : $field['input_class'])."'"; } ?> name="<?php echo $field['label']; ?>" <?php if ($field['required'] == "1") { print "required"; } ?> placeholder="<?php echo $field['placeholder']; ?>" value='<?php echo format_to_edit(@$_POST["{$field['label']}"]); ?>'  /><?php 
				  if ($i3dBootstrapVersion >= 3 && $field['input_class'] != "") {  print "</div></div>"; }

		} ?>
        <?php if ($field['prepend_icon'] != "") {
			if ($i3dBootstrapVersion >= 3) { 
			?></div></div><?php } else { 
			?></span><?php } ?>
        <?php } ?>
       <?php } else { 
	    if ($field['visible'] == "1") { 
		?><hr /><?php 
		} ?>
       <?php }
	   ?></div><?php	
	  
	}
		
		
		
	}


	print "</div>";


		if ($hasReCaptcha && $recaptchaV == '2') {
			print "<script src='https://www.google.com/recaptcha/api.js' async defer></script>";
		} else if ($hasReCaptcha && $recaptchaV == "2i") {
			?>
 <script src='https://www.google.com/recaptcha/api.js' async defer></script>
 <script>
       function onSubmitWithGoogle<?php echo $id; ?>(token) {
		  
         document.getElementById("<?php echo $id; ?>").submit();
       }
     </script>
<?php
		}  else if ($hasReCaptcha && $recaptchaV == "3") {
			?>
<script>
	 var render_this_google_recaptcha = function() {
		
		 
		 grecaptcha.ready(function() {
      grecaptcha.execute('<?php echo $site_key; ?>', {action: 'form_<?php echo $id; ?>'}).then(function(token) {
		  
         var token_field = document.createElement("input");
		  token_field.setAttribute("type", "hidden");
		  token_field.setAttribute("name", "g-recaptcha-response");
		  token_field.setAttribute("value", token);
			 document.getElementById("<?php echo $id; ?>").appendChild(token_field);
      });
  });
	 };
  
     </script>
 <script src='https://www.google.com/recaptcha/api.js?onload=render_this_google_recaptcha&render=<?php echo $site_key; ?>' async defer></script>
 
<?php
		}
	
	?><div class='row-fluid' style='margin-top: 10px;'>
		<?php if ($hasReCaptcha && $recaptchaV == "2i") { ?>
		   	<button data-sitekey="<?php echo $site_key; ?>" data-callback='onSubmitWithGoogle<?php echo $id; ?>' class='g-recaptcha btn btn-primary <?php if ($form['show_reset_button'] != "1") { ?>full-width<?php } ?>'><?php echo $form['submit_button_label']; ?></button>

		<?php } else if ($hasReCaptcha && $recaptchaV == "3") { ?>
		   <input type='submit' class='btn btn-primary <?php if ($form['show_reset_button'] != "1") { ?>full-width<?php } ?>' value='<?php echo $form['submit_button_label']; ?>' />

		<?php } else { ?>
		   <input type='submit' class='btn btn-primary <?php if ($form['show_reset_button'] != "1") { ?>full-width<?php } ?>' value='<?php echo $form['submit_button_label']; ?>' />
		 <?php }  
	if ($form['show_reset_button'] == "1") { 
	?><input type='reset' class='btn'  /><?php 
	} ?></div></form><?php
	print "</div>";
	$form = ob_get_clean();
	if ($hasSkillQuestion) { 
	  $form = str_replace("ONSUBMIT", " onsubmit='return validateSkill(this)'", $form);
	} else {
	  $form = str_replace("ONSUBMIT", "", $form);
	}
    if ($hasReCaptcha) {
		$form = ' <script type="text/javascript">
 var RecaptchaOptions = {
    theme : "white"
 };
 </script>'.$form;
	}
 
	return $form;
}


?>
