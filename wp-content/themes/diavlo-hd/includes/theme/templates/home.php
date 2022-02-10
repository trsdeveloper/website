<?php
/************* HOME *******************/
I3D_Framework::defineTemplateRegion('home', 
									'header-top', 
									'Located at the top of the page, the Control Panel normally contains a map as well as a contact form.',
									'user-defined', array("can-style-background" => false));

I3D_Framework::defineTemplateRegion('home', 
									'utility', 
									'The utility section contains your social media icon links, as well as the phone number and short menu.',
									'user-defined', array("can-style-background" => false));

/*
I3D_Framework::defineTemplateRegion('home', 
									'header-main', 
									'This region normally contains a short menu, and phone number.',
									'user-defined', array("can-style-background" => false));
*/

I3D_Framework::defineTemplateRegion('home', 
									'top', 
									'This region contains your logo and drop down menu',
									'pre-defined', 
									array(
										array('span' => 6, 'widgets' => array(array('class_name' => 'I3D_Widget_Logo', 'defaults' => array('menu' => 'i3d-dropdown-menu-1')) )),
										array('span' => 6, 'widgets' => array(array('class_name' => 'I3D_Widget_Menu', 'defaults' => array('menu' => 'i3d-dropdown-menu-1')) )) 																										  
									));
										


I3D_Framework::defineTemplateRegion('home', 
									'showcase', 
									'The showcase region contains your image or video slider',
									'pre-defined', 
									array(array('span' => 12, 'widgets' => array(array('class_name' => 'I3D_Widget_SliderRegion', 'defaults' => array())))));

I3D_Framework::defineTemplateRegion('home', 
									'header-lower', /* now called info boxes */
									'Located just below the slider region, this space is used for the info-boxes.',
									'user-defined', array("can-style-background" => true));

I3D_Framework::defineTemplateRegion('home', 
									'seo', 
									'Sometimes this space is used to show the H1, H2, H3 and H4 page meta titles.',
									'user-defined', array("can-style-background" => true));

I3D_Framework::defineTemplateRegion('home', 
									'divider-1', 
									'Optional Divider Region',
									'user-defined-divider', array("" => "None", "section-divider" => "Solid"));

I3D_Framework::defineTemplateRegion('home', 
									'breadcrumb', 
									'This is an optional region that may be used for whatever you wish, and shows up just below the SEO region.',
									'user-defined', array("can-style-background" => true));

I3D_Framework::defineTemplateRegion('home', 
									'divider-2', 
									'Optional Divider Region',
									'user-defined-divider', array("" => "None", "section-divider" => "Solid"));

I3D_Framework::defineTemplateRegion('home', 
									'advertising', 
									'Use this space is used a banner-ad, or call-to-action.',
									'user-defined', array("can-style-background" => true));

I3D_Framework::defineTemplateRegion('home', 
									'divider-3', 
									'Optional Divider Region',
									'user-defined-divider', array("" => "None", "section-divider" => "Solid"));

I3D_Framework::defineTemplateRegion('home', 
									'main-top',  
									'The Main TOP region is can be used to show an auxiliary html box.',
									'user-defined', array("can-style-background" => true));

I3D_Framework::defineTemplateRegion('home', 
									'divider-4', 
									'Optional Divider Region',
									'user-defined-divider', array("" => "None", "section-divider" => "Solid"));

I3D_Framework::defineTemplateRegion('home', 
									'main',
									'This region is the main content region of your page, where the regular textual content you write is  displayed.',
									'user-defined', array("can-style-background" => true, "default-sidebar" => "main"));

I3D_Framework::defineTemplateRegion('home', 
									'divider-5', 
									'Optional Divider Region',
									'user-defined-divider', array("" => "None", "section-divider" => "Solid"));

I3D_Framework::defineTemplateRegion('home', 
									'main-bottom', 
									'Use this region to display any widgets you may want to showcase',
									'user-defined', array("can-style-background" => true));

I3D_Framework::defineTemplateRegion('home', 
									'divider-6', 
									'Optional Divider Region',
									'user-defined-divider', array("" => "None", "section-divider" => "Solid"));

I3D_Framework::defineTemplateRegion('home', 
									'lower',      
									'Use this region to display any widgets you may want to showcase',
									'user-defined', array("can-style-background" => true));

I3D_Framework::defineTemplateRegion('home', 
									'divider-7', 
									'Optional Divider Region',
									'user-defined-divider', array("" => "None", "section-divider" => "Solid"));

I3D_Framework::defineTemplateRegion('home', 
									'bottom', 
									'Use this region to display any widgets you may want to showcase',									
									'user-defined', array("can-style-background" => true));


I3D_Framework::defineTemplateRegion('home', 
									'footer',      
									'This region contains often contains such elements as the Quick Links and Social Media Icons',
									'user-defined', array("default-sidebar" => "footer"));

I3D_Framework::defineTemplateRegion('home', 
									'copyright',
									'Use this region to display any widgets you may want to showcase',									
									'user-defined', '');

?>