<?php
// framework 2.2
include ("classes/widgets/SuperSummary.class.php");


// framework 4
include ("classes/widgets/ColumnBreak.class.php");
include ("classes/widgets/RowBreak.class.php");
include ("classes/widgets/Logo.class.php");
include ("classes/widgets/PhoneNumber.class.php");
include ("classes/widgets/SEOTags.class.php");
include ("classes/widgets/Image.class.php");
include ("classes/widgets/HTMLBox.class.php");
include ("classes/widgets/Menu.class.php");
include ("classes/widgets/ContentRegion.class.php");
include ("classes/widgets/InfoBox.class.php");
include ("classes/widgets/TwitterFeed.class.php");
include ("classes/widgets/SocialMediaIconShortcuts.class.php");
include ("classes/widgets/FooterContactBox.class.php");
include ("classes/widgets/SearchForm.class.php");
include ("classes/widgets/TestimonialRotator.class.php");
include ("classes/widgets/SliderRegion.class.php");
include ("classes/widgets/BackToTop.class.php");
include ("classes/widgets/FontSizer.class.php");
include ("classes/widgets/ContactForm.class.php");
include ("classes/widgets/ContactFormMenu.class.php");
include ("classes/widgets/Breadcrumb.class.php");
include ("classes/widgets/CallToAction.class.php");
include ("classes/widgets/GoogleMap.class.php");
include ("classes/widgets/InfoBoxSlider.class.php");
include ("classes/widgets/ContentPanelGroup.class.php");
include ("classes/widgets/AnimatedLogo.class.php");
include ("classes/widgets/Portfolio.class.php");
include ("classes/widgets/Flickr.class.php");
include ("classes/widgets/FocalBox.class.php");
include ("classes/widgets/SidebarRegion.class.php");
include ("classes/widgets/PhotoSlideshow.class.php");
include ("classes/widgets/MapBanner.class.php");
include ("classes/widgets/ContactPanel.class.php");
include ("classes/widgets/LayerSlider.class.php");
include ("classes/widgets/HeaderPreset.class.php");
include ("classes/widgets/ProgressBar.class.php");
include ("classes/widgets/CounterBox.class.php");
include ("classes/widgets/ImageCarousel.class.php");


add_action('widgets_init', array("I3D_Framework",'init_widgets'));

include("classes/typography-class.php");
?>