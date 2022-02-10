<?php
function i3d_show_top_menu() {
  global $pageID;
  global $pagg;
  global $page;
  global $myPageID;
  global $topMenuTag;
  
  if (!isset($topMenuTag)) {
	  $topMenuTag = "ul";
  }
  
 ?>	<!-- menu_top -->
<?php
                if (function_exists('wp_nav_menu')) {
					$menuOption = get_post_meta($myPageID, 'lm-dropdown-menu', true);
					if ($menuOption == "") {
						$menuOption = "lm-dropdown-menu";
					}
									if (menu_items_exist($menuOption)) {

                    ?>                    
                    
               
 <div class="container menu-wrap">                   
 <a class="btn btn-navbar" data-target=".nav-collapse" data-toggle="collapse">
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</a>                   
                    <div class="nav-collapse collapse">
                    <?php
                    wp_nav_menu(array( 'theme_location' => $menuOption, 'container' => false, 'items_wrap' => '<'.$topMenuTag.' id="menu" >%3$s</'.$topMenuTag.'>'));
                    ?>
                    </div>
					</div>

                    <?php
									} else { 
									//print "nope";
									}
                } ?>
                    <!-- /menu_top -->
<script type="text/javascript">
      jQuery("#menu-wrap").addClass("navbar");
      jQuery("#menu").addClass("nav");
      jQuery("#menu ul").addClass("dropdown-menu");

      // on the first level li, make it a typical bootstrap top menu drop down
      jQuery("#menu > li").each(function() {

        if (jQuery(this).children("ul").length > 0) {
          jQuery(this).addClass("dropdown");
          jQuery(this).children("a").addClass("dropdown-toggle");
          jQuery(this).children("a").attr("data-toggle", "dropdown");
          jQuery(this).children("a").html(jQuery(this).children("a").html() + '<strong class="caret"></strong>');

        }
         });

      // create sub-level drop downs
      jQuery("#menu > li > ul li").each(function() {

        if (jQuery(this).children("ul").length > 0) {
          jQuery(this).addClass("dropdown-submenu");
          jQuery(this).children("a").addClass("dropdown-toggle");
          jQuery(this).children("ul").addClass("dropdown-menu");
        }

      });

jQuery(document).ready(function() {
  // Handles menu drop down
  jQuery('.dropdown-menu').find('form').click(function (e) {
        e.stopPropagation();
        });
  });
</script>
<?php
}
?>