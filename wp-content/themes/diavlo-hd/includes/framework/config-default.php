<?php
/*******************************
 * PAGES
 *******************************/

I3D_Framework::addPage(array('post_title'   => 'Home',
							 'post_content' => '<center><h2>Welcome to Diavlo HD</h2> <h3>Another stunning WordPress Theme from i3dTHEMES.com</h3></center>',
										 'post_status' => 'publish',
										 'post_type' => 'page',
										 'menu_order' => 0,
										 'comment_status' => 'closed',
										 'ping_status' => 'closed'),
							 array('_wp_page_template' => 'template-home.php',
								   'i3d_page_title'			=> 'Diavlo HD',
								   'i3d_page_description' 	=> '',
									'i3d_optional_title' 		=> '',
									'i3d_optional_description' => '',
									'layout_regions' => array('home' => array('header-top'   => array('sidebar' => 'i3d-widget-area-header-top', 'columns' => '2', 'width' => 'contained', 'layout' => '6|6', 	'bg' => ''),
																			  'seo' 		 => array('sidebar' => '', 							 'columns' => '1', 'width' => 'contained', 'layout' => '12', 	'bg' => ''),
																			  'advertising'  => array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12', 	'bg' => 'bg10'),
																			  'header-lower' => array('sidebar' => 'i3d-widget-area-header-lower', 'columns' => '3', 'width' => 'contained', 'layout' => '3|3|3|3', 'bg' => ''),
																			  'utility' 	 => array('sidebar' => 'i3d-widget-area-utility', 	 'columns' => '2', 'width' => 'contained', 'layout' => '6|6',   'bg' => ''),
																			  'breadcrumb'	 => array('sidebar' => 'i3d-widget-area-main-top',	'columns' => '1', 'width' => 'contained', 'layout' => '12', 	'bg' => 'section1 animated'),
																			  'main-top'	 => array('sidebar' => 'i3d-widget-area-custom-1', 	'columns' => '2', 'width' => 'contained', 'layout' => '6|6', 	'bg' => 'section1 animated'),
																			  'main'		 => array('sidebar' => 'i3d-widget-area-main-2', 	'columns' => '1', 'width' => 'contained', 'layout' => '12', 	'bg' => 'section1 animated'),
																			  'main-bottom'	 => array('sidebar' => 'i3d-widget-area-advertising', 'columns' => '1', 'width' => 'contained', 'layout' => '12', 	'bg' => 'parallax1 section-animated'),
																			  'lower'		 => array('sidebar' => 'i3d-widget-area-custom-2', 	'columns' => '1', 'width' => 'contained', 'layout' => '12', 	'bg' => 'section2'),
																			  'bottom'		 => array('sidebar' => 'i3d-widget-area-lower', 	'columns' => '1', 'width' => 'contained', 'layout' => '12', 	'bg' => 'padding-top-40 padding-bottom-40'),
																			  'footer'		 => array('sidebar' => 'i3d-widget-area-footer', 	'columns' => '4', 'width' => 'contained', 'layout' => '4|4|2|2', 	'bg' => ''),
																			  'copyright'	 => array('sidebar' => '', 							'columns' => '1', 'width' => 'contained', 'layout' => '12', 	'bg' => ''),
																			 ))
										 )
							 );

I3D_Framework::addPage(array('post_title'   => 'Blog',
							 'post_content' => '',
										 'post_status' => 'publish',
										 'post_type' => 'page',
										 'menu_order' => 1,
										 'comment_status' => 'closed',
										 'ping_status' => 'closed'),
							 array('_wp_page_template' => 'template-blog.php',
										 'i3d_page_title'			=> 'Your Blog Page',
										 'i3d_page_description' 	=> 'This is an example blog page.',
										 'i3d_optional_title' 		=> '',
										 'i3d_optional_description' => '',
										 'selected_layout' => 'default-2r',
										 'selected_page_type' => 'blog',
										 
										 'blog' => array('read_more' => "Read More", 'style' => 'grid', 'read_more_arrow' => 1, 'columns' => 2, 'lead_with_full_width_post' => 1),
										 'layout_regions' => array('blog' => array('header-top'   => array('sidebar' => 'i3d-widget-area-header-top',   'columns' => '2', 'width' => 'contained', 'layout' => '6|6', 'bg' => ''),
																				   'showcase' 	=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12', 'bg' => ''),
																				   'seo' 			=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12', 'bg' => ''),
																				   'advertising' 	=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12', 'bg' => ''),
																				   'header-lower' => array('sidebar' => '', 'columns' => '2', 'width' => 'contained', 'layout' => '6|6', 'bg' => ''),
																				   'utility' => array('sidebar' => '', 'columns' => '2', 'width' => 'contained', 'layout' => '6|6', 'bg' => ''),
																				 'breadcrumb'	=> array('sidebar' => 'i3d-widget-area-breadcrumb', 'columns' => '1', 'width' => 'contained', 'layout' => '12', 'bg' => ''),
																				 'main-top'		=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12', 'bg' => ''),
																				 'main'			=> array('sidebar' => 'i3d-widget-area-main-3', 'columns' => '2', 'width' => 'contained', 'layout' => '9|3', 'bg' => ''),
																				 'main-bottom'	=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12', 'bg' => ''),
																				 'lower'		=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12', 'bg' => ''),
																				 'bottom'		=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12', 'bg' => ''),
																				 'footer'		=> array('sidebar' => 'i3d-widget-area-footer', 'columns' => '4', 'width' => 'contained', 'layout' => '4|4|2|2', 'bg' => ''),
																				 'copyright'	=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12', 'bg' => ''),
																				 ))
								)
							 );
I3D_Framework::addPage(array('post_title'   => 'About Us',
							 'post_content' => "<b>The Directors</b>
This is a great place to describe how the director(s)/operator(s) started the 'business'.  Describe them and their passions, and why someone should entrust their business to your team.

<b>The Team</b>
Describe your team of professionals.  Share with your reader what qualifications your team has, and what they have to offer in experience to help the reader decide that your business is who they want to do business with.",
										 'post_status' => 'publish',
										 'post_type' => 'page',
										 'menu_order' => 2,
										 'comment_status' => 'closed',
										 'ping_status' => 'closed'),
							 array('_wp_page_template' => 'template-team-members.php',
										 'i3d_page_title'			=> 'About Us',
										 'i3d_page_description' 	=> '',
										 'i3d_optional_title' 		=> '',
										 'i3d_optional_description' => '',
										 'layout_regions' => array('team-members' => array('header-top'   => array('sidebar' => 'i3d-widget-area-header-top',   'columns' => '2', 'width' => 'contained', 'layout' => '6|6'),
																				 'seo' 			=> array('sidebar' => 'i3d-widget-area-seo', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																			  	 'advertising'  => array('sidebar' => 'i3d-widget-area-advertising', 'columns' => '1', 'width' => 'contained', 'layout' => '12', 'bg' => 'bg3'),
																				 'header-lower' => array('sidebar' => '', 'columns' => '2', 'width' => 'contained', 'layout' => '6|6'),
																				 'utility' 		=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'breadcrumb'	=> array('sidebar' => 'i3d-widget-area-breadcrumb', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'main-top'		=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'main'			=> array('sidebar' => 'i3d-widget-area-main-4', 'columns' => '2', 'width' => 'contained', 'layout' => '9|3', 'bg' => 'padding-top-40 padding-bottom-40'),
																				 'main-bottom'	=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'lower'		=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'bottom'		=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'footer'		=> array('sidebar' => 'i3d-widget-area-footer', 'columns' => '4', 'width' => 'contained', 'layout' => '4|4|2|2', 'bg' => ''),
																				 'copyright'	=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 ))

						)

							 );
I3D_Framework::addPage(array('post_title'   => 'Contact',
							 'post_content' => '[i3d_contact_form id="'.I3D_Framework::getContactFormID("We'd Love To Hear From You!").'"]',
										 'post_status' => 'publish',
										 'post_type' => 'page',
										 'menu_order' => 2,
										 'comment_status' => 'closed',
										 'ping_status' => 'closed'),
							 array('_wp_page_template' => 'template-contact.php',
										 'i3d_page_title'			=> 'Contact Us',
										 'i3d_page_description' 	=> '',
										 'i3d_optional_title' 		=> '',
										 'i3d_optional_description' => '',
										 'map' => array("primary_location" => "Saanich, BC, Canada", "height" => "300", "width" => "fullscreen", "zoom" => 12, 'type' => "roadmap", 'markers' => array(array('location' => "C2-100 Aldersmith Pl, Victoria, BC", 'label' => 'i3dTHEMES<br>C2-100 Aldersmith Pl<br>Victoria, BC, CANADA<br>1-866-943-5733'))),
										 'layout_regions' => array('contact' => array('header-top'   => array('sidebar' => 'i3d-widget-area-header-top',   'columns' => '2', 'width' => 'contained', 'layout' => '6|6'),
																				 'seo' 			=> array('sidebar' => 'i3d-widget-area-seo', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'advertising' => array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'header-lower' => array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'utility' 		=> array('sidebar' => '', 'columns' => '2', 'width' => 'contained', 'layout' => '6|6'),
																				 'breadcrumb'	=> array('sidebar' => 'i3d-widget-area-breadcrumb', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'main-top'		=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'main'			=> array('sidebar' => 'i3d-widget-area-main-4', 'columns' => '1', 'width' => 'contained', 'layout' => '9|3'),
																				 'main-bottom'	=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'lower'		=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'bottom'		=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'footer'		=> array('sidebar' => 'i3d-widget-area-footer', 'columns' => '4', 'width' => 'contained', 'layout' => '4|4|2|2', 'bg' => ''),
																				 'copyright'	=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 ))
										 
										 )

							 );



I3D_Framework::addPage(array('post_title'   => 'FAQs',
							 'post_content' => '<h4>Frequently Asked Questions</h4><p>Here we answer some of the most common questions.</p>',
										 'post_status' => 'publish',
										 'post_type' => 'page',
										 'menu_order' => 3,
										 'comment_status' => 'closed',
										 'ping_status' => 'closed'),
							 array('_wp_page_template' => 'template-faqs.php',
										 'i3d_page_title'			=> 'FAQs',
										 'i3d_page_description' 	=> 'Learn Some Stuff Here!',
										 'i3d_optional_title' 		=> '',
										 'i3d_optional_description' => '',
										 'i3d_optional_description' => '',
										 'layout_regions' => array('faqs' => array('header-top'   => array('sidebar' => 'i3d-widget-area-header-top',   'columns' => '2', 'width' => 'contained', 'layout' => '6|6'),
																				 'seo' 			=> array('sidebar' => 'i3d-widget-area-seo', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'advertising' => array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'header-lower' => array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'utility' 	=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'breadcrumb'	=> array('sidebar' => 'i3d-widget-area-breadcrumb', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'main-top'		=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'main'			=> array('sidebar' => 'i3d-widget-area-main-4', 'columns' => '2', 'width' => 'contained', 'layout' => '9|3'),
																				 'main-bottom'	=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'lower'		=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'bottom'		=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'footer'		=> array('sidebar' => 'i3d-widget-area-footer', 'columns' => '4', 'width' => 'contained', 'layout' => '4|4|2|2', 'bg' => ''),
																				 'copyright'	=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 ))
										 
										 )
							 );

I3D_Framework::addPage(array('post_title'   => 'Sitemap',
							 'post_content' => '',
										 'post_status' => 'publish',
										 'post_type' => 'page',
										 'menu_order' => 4,
										 'comment_status' => 'closed', 
										 'ping_status' => 'closed'),
							 array('_wp_page_template' => 'template-sitemap.php',
										 'i3d_page_title'			=> 'Sitemap',
										 'i3d_page_description' 	=> '',
										 'i3d_optional_title' 		=> '',
										 'i3d_optional_description' => '',
										 'sitemap' => array("show_sitemap" => 1, "show_sitemap" => 1, "show_archives" => 1, "show_most_recent_posts" => 1),
										 'layout_regions' => array('sitemap' => array('header-top'   => array('sidebar' => 'i3d-widget-area-header-top',   'columns' => '2', 'width' => 'contained', 'layout' => '6|6'),
																				 'seo' 			=> array('sidebar' => 'i3d-widget-area-seo', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'advertising' => array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'header-lower' => array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'utility' 	=> array('sidebar' => 'i3d-widget-area-utility', 'columns' => '2', 'width' => 'contained', 'layout' => '6|6', 'bg' => 'padding-top-40 padding-bottom-40'),
																				 'breadcrumb'	=> array('sidebar' => 'i3d-widget-area-breadcrumb', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'main-top'		=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'main-bottom'	=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'lower'		=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'bottom'		=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'footer'		=> array('sidebar' => 'i3d-widget-area-footer', 'columns' => '4', 'width' => 'contained', 'layout' => '4|4|2|2', 'bg' => ''),
																				 'copyright'	=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 ))
										 
										 )
							 );


I3D_Framework::addPage(array('post_title'   => 'Photo Gallery',
							 'post_content' => '[gallery ids=""]',
										 'post_status' => 'publish',
										 'post_type' => 'page',
										 'menu_order' => 5,
										 'comment_status' => 'closed',
										 'ping_status' => 'closed'),
							 array('_wp_page_template' => 'template-photo-slideshow.php',
										 'i3d_page_title'			=> 'Photo Gallery',
										 'i3d_page_description' 	=> '',
										 'i3d_optional_title' 		=> '',
										 'i3d_optional_description' => '',
										 'slideshow' => array("slide_interval" => "5", "autoplay" => "1", "transition" => "0", "transition_speed" => "2"),
										 'layout_regions' => array()
										 
										 )
							 );



I3D_Framework::addPage(array('post_title'   => 'Privacy Policy',
							 'post_content' => '<h2>Web Site Privacy Policies</h2>
<h3>Company Name</h3>
	
<!-- privacy page center content -->

<p>We recongize that respecting user privacy over the Internet is of utmost importance. This privacy statement is designed to provide information about the privacy and data collection practices for the site: http://www.YOURWEBSITE.COM. The Site is operated by <span class="redfont">YOUR COMPANY NAME</span>.</p>
<p>If you have questions or concerns regarding this statement, you should first contact our site coordinator at <span class="redfont">YOU@YOUREMAILADDRESS.COM</span> or by postal mail to:</p>
<ul>
	<li>YOUR COMPANY NAME</li>
	<li>1234 STREET DRIVE</li>
	<li>CITY, STATE/PROVINCE</li>
	<li>POSTAL CODE</li>
</ul>
<p>Identifying Information. In general, you can visit the Site without telling us who you are or providing any information about yourself. In some areas of the Site, we ask you to provide information that will enable us to process an order, offer services that require registration, assist you with technical support issues or to follow up with you. Generally, <span class="redfont">COMPANY NAME</span> requests identifying information when you: </p>
<ul>
	<li>Register on any of our web sites. </li>
	<li>Place an order. </li>
	<li>Provide feedback to an online survey or tell us about an idea or suggestion. </li>
	<li>Participate in a rebate program, contest, or other promotional offer. </li>
	<li>Request a SPECIAL SERVICE</li>
	<li>Request information or files from technical support or customer service.</li>
</ul>
<p>In these instances, YOUR COMPANY NAME will ask for your name, address, e-mail address, phone number and other appropriate information needed to provide you with these services. In all instances, if you receive a newsletter or other mailing from us, you will always be able to &quot;unsubscribe&quot; to these mailings at any time.</p>
<p>What YOUR COMPANY NAME Will Do With Your Information. If you choose to give us personal information for any of the purposes above, this information is retained by YOUR COMPANY NAME and will only be used by YOUR COMPANY NAME to support your customer relationship with us. We will not add you to a mailing list, or newsletter without your registration for this service. We will only contact you if further information is required from you to complete a service.</p>
<p>What Others May Do With Your Information. YOUR COMPANY NAME does not share, rent, or sell any personally identifying information provided through our Site (such as your name or email address) to any outside organization for use in its marketing or solicitations. From time to time YOUR COMPANY NAME may use agents or contractors who will have access to your personal information to perform services for YOUR COMPANY NAME (such as DATABASE MAINTENANCE, FURTHER EXAMPLES), however, they are required by us to keep the information 
confidential and may not use it for any purpose other than to carry out the services for YOUR COMPANY NAME. In addition, YOUR COMPANY NAME may also share aggregate information about its customers and its web site visitors to advertisers, business partners, and other third parties. For example, we might share that our users are x percent PCs users and y percent Macintosh users. None of this information, however, will contain personal, identifying information about our users. </p>
<p>YOUR COMPANY NAME On-line Store. The YOUR COMPANY NAME On-line Store is designed to give you options concerning the privacy of your identifying information. If you choose, you can set up an account. This will allow you to have a customized order page for express ordering and to view your purchasing history. To protect your privacy, we have designed the Sites to include certain steps to verify your identity before granting you access or enabling you to make corrections in an account. You will always have access to this account information and can view it, update it or correct it at any time. To access your information, you will need to use a password. </p>
<p>When purchasing products through the our web site, the order form will also ask you to provide a daytime telephone number. However, the telephone number is only used to quickly resolve questions relative to an order, such as to clarify customer email addresses that are inactive, or entered incorrectly.</p>
<h4>Third Party Links</h4>
<p>YOURCOMPANYNAME.com does provide links to other sites. Other Internet sites and services have separate privacy and data collection practices. Once you leave WWW.YOURCOMPANYNAME.COM, YOUR COMPANY NAME cannot control, and has no responsibility for, the privacy policies or data collection activities at another site. </p>
<h4>Cookies </h4>
<p>At times, we will use a feature on your web browser to send your computer a &quot;cookie&quot;. We do not use cookies to retrieve any personal information from your computer. We only use cookies to learn ways to enhance our Sites, and to give you better, more personalized service while in our web site. You can reset your browser to refuse all cookies or indicate when a cookie is sent. However, some functions of the Sites will not function if you refuse cookies. These areas of our web site will have information posted about cookies, and when a cookie will be uploaded to your computer.</p>
<h4>Children&#39;s Privacy Protection</h4>
<p>YOUR COMPANY NAME is sensitive to the heightened need to protect the privacy of children under the age of 13. The vast majority of the material on our web site is not intended for children and is not targeted to children under the age of 13. We do not knowingly collect data from children and, if we learn that we have received personal data from a child, we will remove this information from our database. </p>
<h4>Changes to this Policy</h4>
<p>YOUR COMPANY NAME may from time to time revise its privacy policy. You should therefore periodically visit this page, so you are aware of any such revisions. We will not, however, use your existing information in a manner not previously disclosed. You will be advised and have the opportunity to opt out of any new use of your information. <br />Contacting Us. If you have any questions about our privacy policy and/or the practices of our web site, you can write to:</p>
<ul>
	<li>YOUR COMPANY NAME</li>
	<li>1234 STREET DRIVE</li>
	<li>CITY, STATE/PROVINCE</li>
	<li>POSTAL CODE</li>
</ul>
<h4>Credit Card Security</h4>
<p>We know customers are concerned about credit card security. We use one of the worlds largest funds transfer agencies - PayPal.<br />If you choose to use a PayPal account, your personal credit card information will not be given to YOUR COMPANY NAME.</p>',
										 'post_status' => 'publish',
										 'post_type' => 'page',
										 'menu_order' => 6,
										 'comment_status' => 'closed',
										 'ping_status' => 'closed'),
							 array('_wp_page_template' => 'template-default.php',
										 'i3d_page_title'			=> 'Privacy Policy',
										 'i3d_page_description' 	=> '',
										 'i3d_optional_title' 		=> '',
										 'i3d_optional_description' => '',										 
										 'layout_regions' => array('default' => array('header-top'   => array('sidebar' => 'i3d-widget-area-header-top',   'columns' => '2', 'width' => 'contained', 'layout' => '6|6'),
																				 'seo' 			=> array('sidebar' => 'i3d-widget-area-seo', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'advertising' 	=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'header-lower' => array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'utility' 		=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'breadcrumb'	=> array('sidebar' => 'i3d-widget-area-breadcrumb', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'main-top'		=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'main'			=> array('sidebar' => 'i3d-widget-area-main-5', 'columns' => '2', 'width' => 'contained', 'layout' => '3|9'),
																				 'main-bottom'	=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'lower'		=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'bottom'		=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 'footer'		=> array('sidebar' => 'i3d-widget-area-footer', 'columns' => '4', 'width' => 'contained', 'layout' => '4|4|2|2', 'bg' => ''),
																				 'copyright'	=> array('sidebar' => '', 'columns' => '1', 'width' => 'contained', 'layout' => '12'),
																				 ))
										 )
							 );

/***************************************************
 * WIDGET PLACEMENT IN SIDEBARS
 ***************************************************/
global $defaultWidgets;
$defaultWidgets = array(
					   'i3d-widget-area-header-top'    	=> array(
				 array('class_name' => 'I3D_Widget_GoogleMap', 'default_settings' => array('justification' => 'left', 'map_location' => '100 Aldersmith Pl, Victoria, BC, Canada')),														 
				 array('class_name' => 'I3D_Widget_ColumnBreak', 'default_settings' => array()),
				 array('class_name' => 'I3D_Widget_ContactForm', 'default_settings' => array('form_id' => I3D_Framework::getContactFormID("Contact Panel"))),
																 ),
			
					  'i3d-widget-area-top' 		   	=> array(NULL),
					   'i3d-widget-area-header-main'   	=> array(
					   
				 array('class_name' => 'WP_Widget_Recent_Posts', 'default_settings' => array()),																 
				 array('class_name' => 'WP_Widget_Categories', 'default_settings' => array()),																 
				 array('class_name' => 'WP_Widget_Calendar', 'default_settings' => array()),																 
				 array('class_name' => 'WP_Widget_Meta', 'default_settings' => array()),																 
				 array('class_name' => 'WP_Widget_Links', 'default_settings' => array()),																 				 
				 array('class_name' => 'I3D_Widget_SocialMediaIconShortcuts', 'default_settings' => array('icon_size' => '-s', 'justification' => 'left', 'social_icon__facebook' => '1', 'social_icon__twitter' => '1', 'social_icon__googleplus' => '1', 'social_icon__pinterest' => '1', 'social_icon__tumblr' => '1', 'social_icon__rss' => '1')),

													
																 
																 ),
					   'i3d-widget-area-showcase'      	=> array(array('class_name' => 'I3D_Widget_SliderRegion', 'default_settings' => array('styled_bg' => '1'))),
					   'i3d-widget-area-seo'           	=> array(array('class_name' => 'I3D_Widget_SEOTags', 'default_settings' => array('justification' => 'center'))),
																 

					   'i3d-widget-area-header-lower'  	=> array(
				array('class_name' => 'I3D_Widget_InfoBox', 'default_settings' => array('page' => '', 'title_text' => 'Info Box 1','title_text_2' => '','title_text_linkable' => '','description_text' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce vel feugiat sapien, et tristique tellus.\n\nMaecenas porttitor ligula eget turpis fermentum mollis. Sed vel consectetur leo.",'more_link_text' => 'More &raquo;','page_image' => 'holder1','linktype' => 'external','layout' => 'feature-box','linktarget' => '','external_url' => '#','title_tag' => 'h3','bold_lead_paragraph' => '1','hr' => '')),
				array('class_name' => 'I3D_Widget_ColumnBreak', 'default_settings' => array()),
				array('class_name' => 'I3D_Widget_InfoBox', 'default_settings' => array('page' => '', 'title_text' => 'Info Box 2','title_text_2' => '','title_text_linkable' => '','description_text' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce vel feugiat sapien, et tristique tellus.\n\nMaecenas porttitor ligula eget turpis fermentum mollis. Sed vel consectetur leo.",'more_link_text' => 'More &raquo;','page_image' => 'holder2','linktype' => 'external','layout' => 'feature-box','linktarget' => '','external_url' => '#','title_tag' => 'h3','bold_lead_paragraph' => '1','hr' => '')),
				array('class_name' => 'I3D_Widget_ColumnBreak', 'default_settings' => array()),
				array('class_name' => 'I3D_Widget_InfoBox', 'default_settings' => array('page' => '', 'title_text' => 'Info Box 3','title_text_2' => '','title_text_linkable' => '','description_text' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce vel feugiat sapien, et tristique tellus.\n\nMaecenas porttitor ligula eget turpis fermentum mollis. Sed vel consectetur leo.",'more_link_text' => 'More &raquo;','page_image' => 'holder3','linktype' => 'external','layout' => 'feature-box','linktarget' => '','external_url' => '#','title_tag' => 'h3','bold_lead_paragraph' => '1','hr' => '')),
				array('class_name' => 'I3D_Widget_ColumnBreak', 'default_settings' => array()),
				array('class_name' => 'I3D_Widget_InfoBox', 'default_settings' => array('page' => '', 'title_text' => 'Info Box 4','title_text_2' => '','title_text_linkable' => '','description_text' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce vel feugiat sapien, et tristique tellus.\n\nMaecenas porttitor ligula eget turpis fermentum mollis. Sed vel consectetur leo.",'more_link_text' => 'More &raquo;','page_image' => 'holder3','linktype' => 'external','layout' => 'feature-box','linktarget' => '','external_url' => '#','title_tag' => 'h3','bold_lead_paragraph' => '1','hr' => '')),
																 ),
					   
				 	   'i3d-widget-area-utility'       	=> array(
						array('class_name' => 'I3D_Widget_Menu', 'default_settings' => array('justification' => 'left', 'menu' => I3D_Framework::getMenuID("I3D*Text"), 'menu_type' => 'secondary-horizontal', 'suppress_icons' => 1)),																 
				 array('class_name' => 'I3D_Widget_ColumnBreak', 'default_settings' => array()),																 
				 array('class_name' => 'WP_Widget_Search', 'default_settings' => array()),														 
				 array('class_name' => 'I3D_Widget_SocialMediaIconShortcuts', 'default_settings' => array('icon_size' => '-s', 'version' => 2, 'justification' => 'right', 'social_icon__facebook' => '1', 'social_icon__twitter' => '1', 'social_icon__googleplus' => '1', 'social_icon__pinterest' => '1', 'social_icon__tumblr' => '1', 'social_icon__rss' => '1')),
																 ),
					   
					   'i3d-widget-area-advertising'   	=> array(				 
												array('class_name' => 'I3D_Widget_CallToAction', 'default_settings' => array('default_call_to_action_id' => "i3d_cta_recipe"))
																),
					   
					   'i3d-widget-area-breadcrumb'    	=> array(array('class_name' => 'I3D_Widget_Breadcrumb', 'default_settings' => array())),
					   'i3d-widget-area-main-top'      	=> array(array('class_name' => 'I3D_Widget_HTMLBox', 'default_settings' => array('title' => 'About Diavlo', 'title_tag' => 'h1', 'title_animation' => 'animated-fade-in-down', 'text_class' => '', 'text_animation' => 'animated-fade-in-up', 'text' => 'Ready for Mobile, tablets and desktops or all resolutions Diavlo is loaded with features that will impress your visitor and keep them engaged with your website.', 'justification' => 'center'))),
					   'i3d-widget-area-main'        	=> array(
				 array('class_name' => 'I3D_Widget_SEOTags', 'default_settings' => array('box_style' => "", 'justification' => 'center')),																 
				 array('class_name' => 'I3D_Widget_ContentRegion', 'default_settings' => array('box_style' => "")),	 		
				 array('class_name' => 'I3D_Widget_ContentPanelGroup', 'default_settings' => array('id' => I3D_Framework::getContentPanelGroupID("Example Accordion Content Panel Group"))),													 

				 array('class_name' => 'I3D_Widget_ColumnBreak', 'default_settings' => array()),
				 array('class_name' => 'I3D_Widget_Menu', 'default_settings' => array('justification' => 'left', 'menu' => I3D_Framework::getMenuID("I3D*Side"), 'menu_type' => 'primary-vertical')),
				 array('class_name' => 'WP_Widget_Meta', 'default_settings' => array()),																 
				 array('class_name' => 'WP_Widget_Links', 'default_settings' => array()),																 				 
																 ), 
					   'i3d-widget-area-main-2'		   	=> array(
				 array('class_name' => 'I3D_Widget_SEOTags', 'default_settings' => array( 'justification' => 'center')),																 
				 array('class_name' => 'I3D_Widget_ContentRegion', 'default_settings' => array()),	 																		 
																 ), 
					   'i3d-widget-area-main-3'        	=> array(
				 array('class_name' => 'I3D_Widget_SEOTags', 'default_settings' => array('box_style' => "", 'justification' => 'center')),																 
				 array('class_name' => 'I3D_Widget_ContentRegion', 'default_settings' => array('box_style' => "box-article")),													 
				 array('class_name' => 'I3D_Widget_ColumnBreak', 'default_settings' => array()),
				 array('class_name' => 'WP_Widget_Categories', 'default_settings' => array()),																 
				 array('class_name' => 'WP_Widget_Calendar', 'default_settings' => array()),																 
				 array('class_name' => 'WP_Widget_Meta', 'default_settings' => array()),																 
				 array('class_name' => 'WP_Widget_Links', 'default_settings' => array()),																 				 
				 
																 ),
					   'i3d-widget-area-main-4' 		=> array(
				 array('class_name' => 'I3D_Widget_ContentRegion', 'default_settings' => array()),													 
				 array('class_name' => 'I3D_Widget_ColumnBreak', 'default_settings' => array()),
array('class_name' => 'I3D_Widget_FooterContactBox', 'default_settings' => array('title' => '<i class="icon-phone-sign icon-large"></i> Contact Info',
																								   'text' => '',
																								   'address' => '123 My St. | Anytime | Anyplace USA', 
																								   'phone'   => "(555) 555-1234 or (555) 555-5678",
																								   'email'   => "you[at]yourweb.com",
																								   'contact' => "Your Name")),				 
					 array('class_name' => 'I3D_Widget_Menu', 'default_settings' => array('justification' => 'left', 'menu' => I3D_Framework::getMenuID("I3D*Side"), 'menu_type' => 'primary-vertical')),
				 array('class_name' => 'I3D_Widget_SocialMediaIconShortcuts', 'default_settings' => array('icon_size' => '-s', 'justification' => 'left', 'social_icon__facebook' => '1', 'social_icon__twitter' => '1', 'social_icon__googleplus' => '1', 'social_icon__pinterest' => '1', 'social_icon__tumblr' => '1', 'social_icon__rss' => '1')),

					),
					   'i3d-widget-area-main-5' 		=> array(
				array('class_name' => 'I3D_Widget_FooterContactBox', 'default_settings' => array('title' => '<i class="icon-phone-sign icon-large"></i> Contact Info',
																							   'text' => '',
																							   'address' => '123 My St. | Anytime | Anyplace USA', 
																							   'phone'   => "(555) 555-1234 or (555) 555-5678",
																							   'email'   => "you[at]yourweb.com",
																							   'contact' => "Your Name")),				 
				 array('class_name' => 'I3D_Widget_Menu', 'default_settings' => array('justification' => 'left', 'menu' => I3D_Framework::getMenuID("I3D*Side"), 'menu_type' => 'primary-vertical')),
				 array('class_name' => 'I3D_Widget_SocialMediaIconShortcuts', 'default_settings' => array('icon_size' => '-s', 'justification' => 'left', 'social_icon__facebook' => '1', 'social_icon__twitter' => '1', 'social_icon__googleplus' => '1', 'social_icon__pinterest' => '1', 'social_icon__tumblr' => '1', 'social_icon__rss' => '1')),
				 array('class_name' => 'I3D_Widget_ColumnBreak', 'default_settings' => array()),
				 array('class_name' => 'I3D_Widget_ContentRegion', 'default_settings' => array()),													  
																 ),
					   'i3d-widget-area-main-6'     	=> array(
				 array('class_name' => 'WP_Widget_Calendar', 'default_settings' => array()),																 
				 array('class_name' => 'WP_Widget_Meta', 'default_settings' => array()),																 
				 array('class_name' => 'WP_Widget_Links', 'default_settings' => array()),																 				 
				 array('class_name' => 'I3D_Widget_ColumnBreak', 'default_settings' => array()),																 
				 array('class_name' => 'I3D_Widget_ContentRegion', 'default_settings' => array()),													 																 
																 ), 
					   'i3d-widget-area-main-bottom'   	=> array(NULL),
					   'i3d-widget-area-lower'         	=> array(
				 array('class_name' => 'I3D_Widget_TestimonialRotator', 'default_settings' => array('title' => '', 'style' => 'slider', 'delay' => "8", "limit" => '5', 'category' => '')),	 
																 ),
					   'i3d-widget-area-bottom'        	=> array(NULL),
					   'i3d-widget-area-footer'        	=> array(
				 array('class_name' => 'I3D_Widget_HTMLBox', 'default_settings' => array('title' => 'About Our Company', 'text' => '<img src="http://www.i3dthemes.com/_images/vxiii/aquila-logo.png" alt="" class="pull-left" style="margin-right: 10px" /> Add a small bit of information about your company here to help the search engines spider your page a bit better. As you add more information the content will expand. For best \'looks\' try to match the amount of text up with the height of the other containers in the footer.', 'justification' => 'left')),
				 array('class_name' => 'I3D_Widget_ColumnBreak', 'default_settings' => array()),

				 array('class_name' => 'I3D_Widget_HTMLBox', 'default_settings' => array('title' => 'Recent Updates', 'text' => '<ul class="footer-updates"><li><i class="fa fa-crosshairs"></i> Add a bit of information here on a monthly basis to tell your visitors and search engines which pages you\'ve recently updated, and with what information. </li><li><i class="fa fa-crosshairs"></i> Add a bit of information here on a monthly basis to tell your visitors and search engines which pages you\'ve recently updated. </li></ul>', 'justification' => 'left')),
				 array('class_name' => 'I3D_Widget_ColumnBreak', 'default_settings' => array()),

				 array('class_name' => 'I3D_Widget_Menu', 'default_settings' => array('justification' => 'left', 'menu' => I3D_Framework::getMenuID("I3D*Footer"), 'menu_type' => 'secondary-vertical', 'title' => 'Helpful Links')),			
				 array('class_name' => 'I3D_Widget_ColumnBreak', 'default_settings' => array()),

				 array('class_name' => 'I3D_Widget_FooterContactBox', 'default_settings' => array('title' => 'Contact Info',
																								   'text' => '',
																								   'address' => '123 My St, Anyplace ST', 
																								   'phone'   => "(555) 555-1234",
																								   'email'   => "you[at]yourweb.com",
																								   'contact' => "Your Name",
																								   'show_field_labels' => "1",
																								   'show_field_icons' => "0")),

																 ),
					
					   'i3d-widget-area-copyright'     	=> array(), 
					   'i3d-widget-area-custom-1'      	=> array(
						array('class_name' => 'I3D_Widget_HTMLBox', 'default_settings' => array('vector_icon' => 'fa-mobile', 'vector_icon_animation' => 'animated-fade-in-down', 'vector_icon_animation_delay' => 'delay-250',
																								'title' => 'Fully Responsive', 'title_tag' => 'h3', 'title_animation' => '', 
																								'text_class' => '', 'text_animation' => '', 'text' => 'Design that looks great on desktop or any mobile device. Your website will respond and adapt to various devices and screen resolutions.', 
																								'box_layout' => 'section-list', 'justification' => 'left', 'box_style' => '')),															 
						array('class_name' => 'I3D_Widget_HTMLBox', 'default_settings' => array('vector_icon' => 'fa-ellipsis-h', 'vector_icon_animation' => 'animated-fade-in-down', 'vector_icon_animation_delay' => 'delay-250',
																								'title' => 'Multiple Sliders', 'title_tag' => 'h3', 'title_animation' => '', 
																								'text_class' => '', 'text_animation' => '', 'text' => 'Great selection to choose from, for any page design, including the Fullscreen slider, Nivo Slider, Amazing Slider, and 3 fullscreen carousels.', 
																								'box_layout' => 'section-list', 'justification' => 'left', 'box_style' => '')),															 
				 		array('class_name' => 'I3D_Widget_ColumnBreak', 'default_settings' => array()),					
						array('class_name' => 'I3D_Widget_HTMLBox', 'default_settings' => array('vector_icon' => 'fa-video-camera', 'vector_icon_animation' => 'animated-fade-in-down', 'vector_icon_animation_delay' => 'delay-250',
																								'title' => 'Comprehensive Video Tutorials', 'title_tag' => 'h3', 'title_animation' => '', 
																								'text_class' => '', 'text_animation' => '', 'text' => "Instructions and video demonstrations to walk you through some of the tricky stuff, and all the 'how to's.", 
																								'box_layout' => 'section-list', 'justification' => 'left', 'box_style' => '')),															 
						array('class_name' => 'I3D_Widget_HTMLBox', 'default_settings' => array('vector_icon' => 'fa-bars', 'vector_icon_animation' => 'animated-fade-in-down', 'vector_icon_animation_delay' => 'delay-250',
																								'title' => 'Built In Form Handling', 'title_tag' => 'h3', 'title_animation' => '', 
																								'text_class' => '', 'text_animation' => '', 'text' => 'Included is a form builder so that you can create as many forms as you like.', 
																								'box_layout' => 'section-list', 'justification' => 'left', 'box_style' => ''))															 
																 ),
					   'i3d-widget-area-custom-2'      => array(
						array('class_name' => 'I3D_Widget_HTMLBox', 'default_settings' => array('vector_icon' => '', 'vector_icon_animation' => '', 'vector_icon_animation_delay' => '',
																								'title' => 'Meet the Team!', 'title_tag' => 'h1', 'title_animation' => '', 
																								'text_class' => 'lead', 'text_animation' => '', 'text' => 'Teamwork is the ability to work as a group toward a common vision, even if that vision becomes extremely blurry.', 
																								'box_layout' => '', 'justification' => 'center', 'box_style' => '')),															 
						array('class_name' => 'I3D_Widget_HTMLBox', 'default_settings' => array('vector_icon' => '', 'vector_icon_animation' => '', 'vector_icon_animation_delay' => '',
																								'title' => '', 'title_tag' => 'h3', 'title_animation' => '', 
																								'text_class' => '', 'text_animation' => '', 'text' => 'More than a bunch of pretty faces, our team (Your Team! that is..) have been working together for more than 10 years, developing unique, professional web templates that are head and shoulders above anything else you\'ll find on the market today.

Our business philosophy has always been "be first, be better and ALWAYS be human". We\'re one of the few or maybe only web template company that designs, develops and supports our own products in house. When you call us Toll FREE you speak the actual people who design and develop your templates and modules.

Whether you need help deciding which template will work best for your needs, have a question about one of our products, or just want to make sure we really are as human as we claim... just call use TOLL FREE 1-866-943-5733 or click the button to learn more about us! 

<div class=\'text-center\'><a href="#" class=\'btn btn-primary\'>Contact Us</a></div>', 
																								'box_layout' => '', 'justification' => 'left', 'box_style' => '')),															 
																
																),	
				
					   'i3d-widget-area-custom-3'      	=> array(
																 
				 array('class_name' => 'I3D_Widget_Menu', 'default_settings' => array('justification' => 'left', 'menu' => I3D_Framework::getMenuID("I3D*Side"), 'menu_type' => 'primary-vertical')),
				 array('class_name' => 'WP_Widget_Meta', 'default_settings' => array()),																 
				 array('class_name' => 'WP_Widget_Links', 'default_settings' => array()),																 				 
				 array('class_name' => 'I3D_Widget_SocialMediaIconShortcuts', 'default_settings' => array('icon_size' => '-s', 'justification' => 'left', 'social_icon__facebook' => '1', 'social_icon__twitter' => '1', 'social_icon__googleplus' => '1', 'social_icon__pinterest' => '1', 'social_icon__tumblr' => '1', 'social_icon__rss' => '1')),
																 
																 ));

	
global $defaultPosts;
$defaultPosts = array(
		array('title' => 'Example Post 5', 'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce suscipit faucibus dui non dignissim. Integer mi tellus, dictum scelerisque venenatis eu, iaculis laoreet eros. Mauris et diam eu turpis mattis cursus et non lorem. Sed sit amet magna sed mi tempus porta. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Proin id faucibus tellus. Proin sollicitudin accumsan egestas.'),
		array('title' => 'Example Post 4', 'content' => 'Sed ipsum ante, cursus sit amet faucibus dictum, auctor in sapien. Nullam non nibh neque, ac congue felis. Vivamus pretium lacus sed elit luctus eget sagittis felis tempus. Phasellus cursus posuere tortor ac adipiscing. Cras sed massa est, pharetra posuere turpis. Integer eleifend, magna id bibendum convallis, dolor sapien auctor urna, sit amet commodo turpis quam ac orci.'),
		array('title' => 'Example Post 3', 'content' => 'Curabitur mollis est at diam adipiscing interdum. Proin vel libero ac tellus aliquam cursus. Sed in mauris diam, sed mollis velit. Cras ultricies tempus lectus, et pulvinar nunc auctor vitae. Donec malesuada bibendum eleifend. Donec gravida, est nec eleifend ullamcorper, mauris felis lobortis est, vel tincidunt est ante a odio.'),
		array('title' => 'Example Post 2', 'content' => 'Proin quis urna lorem. Ut ac dui et velit rutrum placerat. Donec vestibulum nibh at tortor elementum aliquet. Duis turpis mauris, porta ut tempus eu, euismod id lorem. Suspendisse tincidunt dapibus ipsum, sit amet mollis mauris aliquet ac. Integer risus dolor, eleifend sit amet tincidunt semper, tristique vel justo.'),
		array('title' => 'Example Feature Post', 'content' => 'Aliquam convallis interdum neque, non rhoncus leo feugiat eget. Duis id ultrices enim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse rutrum diam eget ipsum consequat congue. Pellentesque lobortis tincidunt augue ac tempus. Proin ac risus erat. Aenean odio dui, porttitor et hendrerit a, semper ut nisi.'),
);


I3D_Framework::renameSidebar("header-top",   "Contact Panel");
I3D_Framework::renameSidebar("top", 		 "Logo/Menu"); 
I3D_Framework::renameSidebar("header-lower", "Info Boxes");
I3D_Framework::renameSidebar("lower",        "Testimonials");

I3D_Framework::renameSidebar("custom-3",        "Left");
I3D_Framework::renameSidebar("header-main",     "Right");


I3D_Framework::reorderSidebars(array("header-top", "utility", "top", "showcase", "seo", "header-lower", "breadcrumb", "main-top", "main", "main-2", "main-3", "main-4", "main-5", "main-6", "main-bottom", "lower", "advertising", "footer", "copyright", "custom-1", "custom-2", "custom-3", "header-main"));
?>