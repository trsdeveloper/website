<?php
/************* BLOG *******************/
I3D_Framework::defineTemplateRegion('blog', 
									'header-top', 
									'Located at the top of the page, the Control Panel normally contains a map as well as a contact form.',
									'user-defined', array("can-style-background" => false));

I3D_Framework::defineTemplateRegion('blog', 
									'utility', 
									'The utility section contains your social media icon links, as well as the site search box.',
									'user-defined', array("can-style-background" => false));
/*

I3D_Framework::defineTemplateRegion('blog', 
									'header-main', 
									'This is where your logo/website name is displayed',
									'pre-defined', 
									array(array('span' => 12, 'widgets' => 
																	 array(
																		 
																		   array('class_name' => 'I3D_Widget_Logo', 'defaults' => array('menu' => 'i3d-dropdown-menu-1'))
																		   ))));
*/

I3D_Framework::defineTemplateRegion('home', 
									'top', 
									'This region contains your logo and drop down menu',
									'pre-defined', 
									array(
										array('span' => 6, 'widgets' => array(array('class_name' => 'I3D_Widget_Logo', 'defaults' => array('menu' => 'i3d-dropdown-menu-1')) )),
										array('span' => 6, 'widgets' => array(array('class_name' => 'I3D_Widget_Menu', 'defaults' => array('menu' => 'i3d-dropdown-menu-1')) )) 																										  
									));


I3D_Framework::defineTemplateRegion('blog', 
									'showcase', 
									'The showcase region contains your image or video slider',
									'user-defined', array("can-style-background" => true));

I3D_Framework::defineTemplateRegion('blog', 
									'seo', 
									'Sometimes this space is used to show the H1, H2, H3 and H4 page meta titles.',
									'user-defined', array("can-style-background" => true));

I3D_Framework::defineTemplateRegion('blog', 
									'header-lower', 
									'Located just below the logo region, this space is often used for auxilliary text links.',
									'user-defined', array("can-style-background" => true));

I3D_Framework::defineTemplateRegion('blog', 
									'divider-1', 
									'Optional Divider Region',
									'user-defined-divider', array("" => "None", "divider1" => "Light Diagonal Lines", "divider2" => "Dark Vertical Lines"));

I3D_Framework::defineTemplateRegion('blog', 
									'breadcrumb', 
									'This is an optional region that may be used for whatever you wish, and shows up just below the SEO region.',
									'user-defined', array("can-style-background" => true));

I3D_Framework::defineTemplateRegion('blog', 
									'divider-2', 
									'Optional Divider Region',
									'user-defined-divider', array("" => "None", "divider1" => "Light Diagonal Lines", "divider2" => "Dark Vertical Lines"));

I3D_Framework::defineTemplateRegion('blog', 
									'advertising', 
									'Use this space is used a banner-ad, or call-to-action.',
									'user-defined', array("can-style-background" => true));

I3D_Framework::defineTemplateRegion('blog', 
									'divider-3', 
									'Optional Divider Region',
									'user-defined-divider', array("" => "None", "divider1" => "Light Diagonal Lines", "divider2" => "Dark Vertical Lines"));

I3D_Framework::defineTemplateRegion('blog', 
									'main-top',  
									'The Main TOP region is often used to display info boxes.',
									'user-defined', array("can-style-background" => true));

I3D_Framework::defineTemplateRegion('blog', 
									'divider-4', 
									'Optional Divider Region',
									'user-defined-divider', array("" => "None", "divider1" => "Light Diagonal Lines", "divider2" => "Dark Vertical Lines"));

I3D_Framework::defineTemplateRegion('blog', 
									'main',
									'This region is the main content region of your page, where the regular textual content you write is  displayed.',
									'user-defined', array('default-sidebar' => 'main-3', "can-style-background" => true));

I3D_Framework::defineTemplateRegion('blog', 
									'divider-5', 
									'Optional Divider Region',
									'user-defined-divider', array("" => "None", "divider1" => "Light Diagonal Lines", "divider2" => "Dark Vertical Lines"));

I3D_Framework::defineTemplateRegion('blog', 
									'main-bottom', 
									'Use this region to display any widgets you may want to showcase',
									'user-defined', array("can-style-background" => true));

I3D_Framework::defineTemplateRegion('blog', 
									'divider-6', 
									'Optional Divider Region',
									'user-defined-divider', array("" => "None", "divider1" => "Light Diagonal Lines", "divider2" => "Dark Vertical Lines"));

I3D_Framework::defineTemplateRegion('blog', 
									'lower',      
									'Use this region to display any widgets you may want to showcase',
									'user-defined', array("can-style-background" => true));

I3D_Framework::defineTemplateRegion('blog', 
									'divider-7', 
									'Optional Divider Region',
									'user-defined-divider', array("" => "None", "divider1" => "Light Diagonal Lines", "divider2" => "Dark Vertical Lines"));

I3D_Framework::defineTemplateRegion('blog', 
									'bottom', 
									'Use this region to display any widgets you may want to showcase',									
									'user-defined', array("can-style-background" => true));

I3D_Framework::defineTemplateRegion('blog', 
									'footer',      
									'This region contains often contains such elements as the Quick Links and Social Media Icons',
									'user-defined', array("can-style-background" => false, 'default-sidebar' => 'footer'));
I3D_Framework::defineTemplateRegion('blog', 
									'copyright',
									'Use this region to display any widgets you may want to showcase',									
									'user-defined', '');

?>