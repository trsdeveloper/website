<?php

/************* TEAM MEMBERS *******************/
I3D_Framework::defineTemplateRegion('team-members', 
									'header-top', 
									'Located at the top of the page, the Control Panel normally contains a map as well as a contact form.',
									'user-defined', array("can-style-background" => false));

I3D_Framework::defineTemplateRegion('team-members', 
									'header-main', 
									'This is where your logo/website name is displayed',
									'pre-defined', 
									array(array('span' => 12, 'widgets' => 
																	 array(
																		   /* widgets */
																		   array('class_name' => 'I3D_Widget_Logo', 'defaults' => array('menu' => 'i3d-dropdown-menu-1'))
																		   ))));

I3D_Framework::defineTemplateRegion('team-members', 
									'top', 
									'This region contains your drop down menu and drop down contact form',
									'pre-defined', 
									array(array('span' => 9, 'widgets' => array(array('class_name' => 'I3D_Widget_Menu', 'defaults' => array('menu' => 'i3d-dropdown-menu-1')) )),
										  array('span' => 3, 'widgets' => array(array('class_name' => 'I3D_Widget_ContactFormMenu', 'defaults' => array("title" => "<i class='icon-envelope'></i> Contact Us", "form_id" => I3D_Framework::getContactFormID("Contact Box")))))
										));

I3D_Framework::defineTemplateRegion('team-members', 
									'utility', 
									'The utility section contains your social media icon links, as well as the site search box.',
									'user-defined', array("can-style-background" => true));

I3D_Framework::defineTemplateRegion('team-members', 
									'seo', 
									'Sometimes this space is used to show the H1, H2, H3 and H4 page meta titles.',
									'user-defined', array("can-style-background" => true));


I3D_Framework::defineTemplateRegion('team-members', 
									'header-lower', 
									'Located just below the logo region, this space is often used for auxilliary text links.',
									'user-defined', array("can-style-background" => true));

I3D_Framework::defineTemplateRegion('team-members', 
									'divider-1', 
									'Optional Divider Region',
									'user-defined-divider', array("" => "None", "divider1" => "Light Diagonal Lines", "divider2" => "Dark Vertical Lines"));

I3D_Framework::defineTemplateRegion('team-members', 
									'breadcrumb', 
									'This is an optional region that may be used for whatever you wish, and shows up just below the SEO region.',
									'user-defined', array("can-style-background" => true));

I3D_Framework::defineTemplateRegion('team-members', 
									'divider-2', 
									'Optional Divider Region',
									'user-defined-divider', array("" => "None", "divider1" => "Light Diagonal Lines", "divider2" => "Dark Vertical Lines"));

I3D_Framework::defineTemplateRegion('team-members', 
									'advertising', 
									'Use this space is used a banner-ad, or call-to-action.',
									'user-defined', array("can-style-background" => true));

I3D_Framework::defineTemplateRegion('team-members', 
									'divider-3', 
									'Optional Divider Region',
									'user-defined-divider', array("" => "None", "divider1" => "Light Diagonal Lines", "divider2" => "Dark Vertical Lines"));

I3D_Framework::defineTemplateRegion('team-members', 
									'main-top',  
									'The Main TOP region is often used to display info boxes.',
									'user-defined', array("can-style-background" => true));

I3D_Framework::defineTemplateRegion('team-members', 
									'divider-4', 
									'Optional Divider Region',
									'user-defined-divider', array("" => "None", "divider1" => "Light Diagonal Lines", "divider2" => "Dark Vertical Lines"));

I3D_Framework::defineTemplateRegion('team-members', 
									'main',
									'This region is the main content region of your page, where the regular textual content you write is  displayed.',
									'user-defined', array("can-style-background" => true));

I3D_Framework::defineTemplateRegion('team-members', 
									'divider-5', 
									'Optional Divider Region',
									'user-defined-divider', array("" => "None", "divider1" => "Light Diagonal Lines", "divider2" => "Dark Vertical Lines"));

I3D_Framework::defineTemplateRegion('team-members', 
									'main-bottom', 
									'Use this region to display any widgets you may want to showcase',
									'user-defined', array("can-style-background" => true));

I3D_Framework::defineTemplateRegion('team-members', 
									'divider-6', 
									'Optional Divider Region',
									'user-defined-divider', array("" => "None", "divider1" => "Light Diagonal Lines", "divider2" => "Dark Vertical Lines"));

I3D_Framework::defineTemplateRegion('team-members', 
									'lower',      
									'Use this region to display any widgets you may want to showcase',
									'user-defined', array("can-style-background" => true));

I3D_Framework::defineTemplateRegion('team-members', 
									'divider-7', 
									'Optional Divider Region',
									'user-defined-divider', array("" => "None", "divider1" => "Light Diagonal Lines", "divider2" => "Dark Vertical Lines"));

I3D_Framework::defineTemplateRegion('team-members', 
									'bottom', 
									'Use this region to display any widgets you may want to showcase',									
									'user-defined', array("can-style-background" => true));

I3D_Framework::defineTemplateRegion('team-members', 
									'footer',      
									'This region contains often contains such elements as the Quick Links and Social Media Icons',
									'user-defined', '');

I3D_Framework::defineTemplateRegion('team-members', 
									'copyright',
									'Use this region to display any widgets you may want to showcase',									
									'user-defined', '');
?>