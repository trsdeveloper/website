<?php
$typography->add("body",       "Body", array("color" => "", "font-family" => "", "font-size" => "", "font-weight" => ""));
$typography->add("h1",         "Heading 1", array("color" => "", "font-family" => "", "font-size" => "", "font-weight" => ""));
$typography->add("h2",         "Heading 2", array("color" => "", "font-family" => "", "font-size" => "", "font-weight" => ""));
$typography->add("h3",         "Heading 3", array("color" => "", "font-family" => "", "font-size" => "", "font-weight" => ""));
$typography->add("h4",         "Heading 4", array("color" => "", "font-family" => "", "font-size" => "", "font-weight" => ""));
$typography->add("h5",         "Heading 5", array("color" => "", "font-family" => "", "font-size" => "", "font-weight" => ""));
$typography->add("a",          "Hyperlink", array("color" => ""));

$typography->add(".navbar .nav > li > a",       "Navbar Link", array("color" => "", "font-family" => "", "font-size" => "", "font-weight" => ""));
$typography->add(".navbar .nav > li > a:hover", "Navbar Link (Hover)", array("color" => ""));

$typography->add(".website-text1", "Website Name (1st Color)", array("font-family" => "", "font-size" => "", "font-weight" => "", "color" => ""));
$typography->add(".website-text2", "Website Name (2nd Line)", array("font-family" => "","font-size" => "", "font-weight" => "", "color" => ""));

$typography->add(".tagline h4 a, .tagline h4, .tagline a, .tagline", "Tagline", array("font-family" => "", "font-size" => "", "font-weight" => "", "color" => ""));

$typography->add("#textlinks, #textlinks a", "Textlinks", array("font-family" => "", "font-size" => "", "font-weight" => "", "color" => ""));
$typography->add("#textlinks a:hover", "Textlinks (Hover)", array("font-family" => "", "font-size" => "", "font-weight" => "", "color" => ""));

$typography->add(".thumbnail .caption", "Thumbnail Caption", array("font-family" => "", "font-size" => "", "font-weight" => "", "color" => ""));

$typography->add(".amazingslider-title-0", "Amazing Slider Title", array("font-family" => "", "font-size" => "", "font-weight" => "", "color" => ""), true);
$typography->add(".amazingslider-description-0", "Amazing Slider Description", array("font-family" => "", "font-size" => "", "font-weight" => "", "color" => ""), true);


$typography->load();
?>