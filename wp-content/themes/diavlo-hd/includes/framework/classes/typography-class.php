<?php
class I3D_Theme_Typography {
	var $items;
	var $fonts;
	var $googlefonts;
	var $fontsizes;
	
	function __construct() {
	//function I3D_Theme_Typography() {
	//	return;
	  $this->items = array();	
	  $this->fonts = array("Arial", "Verdana", "Trebuchet", "Georgia", "Times New Roman", "Tahoma", "Palatino","Courier");
	  $this->googlefonts = get_option("google-fonts", array());
	  
	  $this->googlefonts_json = json_decode(get_option("google-fonts-json"), true);
	  if (!is_array($this->googlefonts_json) || sizeof($this->googlefonts_json) == 0) {
	   I3D_Framework::refreshGoogleFonts(false);
	   $font_data = json_decode(get_option("google-fonts-json"), true);
	   //var_dump($font_data);
	 // print "vvv";
	  //var_dump($font_data['items']);
	//  exit;
	    $this->googlefonts_json = $font_data;
	
	  } else {
		//  print "Nope";
		//$this->googlefonts_json = array();
	  }
	  $font_data = array();
	//  var_dump($this->googlefonts_json);
	  if (is_array($this->googlefonts_json['items'])) {
		  foreach ($this->googlefonts_json['items'] as $item) {
			  $font_name = $item['family'];
			  $font_data["{$font_name}"] = $item;
			  //if ($font_name == "Open Sans Condensed") {
			 // var_dump($item);
			 // }
			//  var_dump($item['variants']);
			//  exit;
		  }
	  }
	 // print sizeof($font_data);
	  $this->googlefonts_resolved = $font_data;
	  //	
	  //if (!is_array($this->googlefonts) || sizeof($this->googlefonts) == 0) {
	//	I3D_Framework::refreshGoogleFonts();
	//	$this->googlefonts = get_option("google-fonts");
	  //}
	  $this->fontsizes = array("5px", "6px", "7px", "8px", "9px", "10px", "11px", "12px", "13px", "14px", "15px", "16px", "17px", "18px", "19px", "20px", "21px", "22px", "23px", "24px", "25px", "26px", "27px", "28px", "29px", "30px", "35px", "40px", "45px", "55px", "60px", "70px",
							   ".2em", ".3em", ".4em", ".5em", ".6em", ".7em", ".8em", ".9em", "1em", "1.1em", "1.2em", "1.3em", "1.4em", "1.5em", "1.6em", "1.7em", "1.8em", "1.9em", "2em", "2.5em", "3em", "4em");
	}
	
	function clear() {
	  $this->items = array();
	} 
	function add($path, $name, $elements = array(), $section = "") {
		$this->items[] = array("path" => $path, "name" => $name, "elements" => $elements, "section" => $section);
	}

    function set($path, $element, $setting) {
		foreach ($this->items as $i => $itemElement) {
			if ($itemElement['path'] == $path) {
				if ($element == "color" || $element == "background-color") {
				  if ($setting != "") {
					$setting = "#".ltrim($setting, "#");  
				  }
				}
		      $this->items["$i"]["elements"]["$element"] = $setting;
			  break;
			}
		}
		
	}
	
	function load() {
		$typographySettings = get_option("i3d_typography_settings");
		if (is_array($typographySettings)) {
		  foreach ($typographySettings as $index => $item) {
			foreach ($item['elements'] as $element => $setting) {
			  
			  $this->set($item['path'], $element, $setting);
			 // print $item['path']." == ".$element." == $setting <br>";
			}
		  }
		}
	}
	function save() { 
	   update_option("i3d_typography_settings", $this->items);
	}
	
	function googleFontLinks() {
	  $this->getStyles(true);	
	}
	function getStyles($googleFonts = false) {
		$googleFontsToImport = array();
		$output = "";
		foreach ($this->items as $index => $item) {
		  $output .= "/* {$item['name']} */ ";
		  $output .= $item['path']." {";
		  foreach ($item['elements'] as $elementName => $elementSetting) {
		    if ($elementSetting != "") {
				 if ($elementName == "font-family" && array_key_exists($elementSetting, $this->googlefonts_resolved)) { 
				   
					$font_data = $this->googlefonts_resolved["{$elementSetting}"];
					$variant = @$font_data['variants'][0];
					if ($variant != "") {
						$googleFontsToImport[] = $elementSetting.":".$variant;
						
					} else {
							$googleFontsToImport[] = $elementSetting;
					}
					
				} else if ($elementName == "font-family" && in_array($elementSetting, $this->googlefonts)) {
					
					$googleFontsToImport[] = $elementSetting;
				} 
				
				if ($elementName == "font-family") {
					$output .= "{$elementName}: '{$elementSetting}';";
					
				} else {
					$output .= "{$elementName}: {$elementSetting};";
					
				}
			}
		  }
		  $output .= "}\n";
		}
		if ($googleFonts) { 
			foreach ($googleFontsToImport as $googleFont) {
				print "<link href='https://fonts.googleapis.com/css?family=".urlencode($googleFont)."' rel='stylesheet' type='text/css'>\n";
			} 
		}
	
		
		return $output;
		//echo $output;
			
		
	}
	
	function renderComponents($index, $elements) {
		//var_dump($elements);
		if (isset($elements['font-size'])) {
			$this->renderFontSizeComponent($index, $elements['font-size']);
		}
		if (isset($elements['font-family'])) {
			$this->renderFontFamilyComponent($index, $elements['font-family']);
		}
		if (isset($elements['font-weight'])) {
			$this->renderFontWeightComponent($index, $elements['font-weight']);	
		}
		if (isset($elements['font-style'])) {
			$this->renderFontStyleComponent($index, $elements['font-style']);	
		}
		if (isset($elements['color'])) {
			$this->renderColorComponent($index, $elements['color']);
		}
		if (isset($elements['background-color'])) {
			$this->renderBackgroundColorComponent($index, $elements['background-color']);
		}
		
		$this->renderIndexKey($index);
		
	}
	
	function renderIndexKey($index) {
		print "<input type='hidden' name='typography__index-key__{$index}' value='".$this->items["{$index}"]["path"]."' />";
	}
	
	function renderColorComponent($index, $setting) {
		print "<input type='text' class='colorwell' name='typography__color__{$index}' value='{$setting}' placeholder='Text Color Example: #336699' />";
	}

	function renderBackgroundColorComponent($index, $setting) {
		print "<input type='text' class='colorwell' name='typography__background-color__{$index}' value='{$setting}' placeholder='Background Color Example: #336699' />";
	}

	function renderFontSizeComponent($index, $setting) {
	  echo "<select  class='input-medium' name='typography__font-size__{$index}'>";
	  echo "<option value=''>-- Default Size --</option>";
	  foreach ($this->fontsizes as $fontSize) { 
	    echo "<option ".($setting == $fontSize ? "selected" : "")." value='{$fontSize}'>{$fontSize}</option>";
	  }
	  echo "</select>";
		
	}
	
	function renderFontFamilyComponent($index, $setting) {
	//	print sizeof ($this->googlefonts);
	  echo "<select class='input-medium' name='typography__font-family__{$index}'>";
	  echo "<option value=''>-- Default Font --</option>";
	  foreach ($this->fonts as $fontName) { 
	  echo "<option ".($setting == $fontName ? "selected" : "")." value='{$fontName}'>{$fontName}</option>";
	  }
	  echo "<option disabled value=''>-- Google Fonts --</option>";
	 foreach ($this->googlefonts_resolved as $font) { 
			$fontName = $font['family'];
	  echo "<option ".($setting == $fontName ? "selected" : "")." value='{$fontName}'>{$fontName}</option>";
	  }	 
	  echo "</select>";
	}
	
	function renderFontWeightComponent($index, $setting) {
	  echo "<select class='input-medium' name='typography__font-weight__{$index}'>";
	  echo "<option value=''>-- Default Weight --</option>";
	  echo "<option ".($setting == "normal" ? "selected" : "")." value='normal'>Normal</option>";
	  echo "<option ".($setting == "bold" ? "selected" : "")." value='bold'>Bold</option>";
	  echo "</select>";
	}
	
	function renderFontStyleComponent($index, $setting) { 
	  echo "<select class='input-medium' name='typography__font-style__{$index}'>";
	  echo "<option value=''>-- Default Style --</option>";
	  echo "<option ".($setting == "normal" ? "selected" : "")." value='normal'>Normal</option>";
	  echo "<option ".($setting == "italic" ? "selected" : "")." value='italic'>Italic</option>";
	  echo "</select>";
	}
}
$typography = new I3D_Theme_Typography();
?>