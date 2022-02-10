/**
 * masonry-init.js functions
 */


function init_masonry(span){
	if (span == 2) {
		init_masonry_2_columns();
	} else if (span == 3) {
		init_masonry_3_columns();
		
	} else if (span == 4) {
		init_masonry_4_columns();
		
	}
}

function init_masonry_2_columns() {
    jQuery('.masonry-container').each(function() {
		var gutter = 10;
		var min_width = 350;			   
		var $container = jQuery(this);
		if (jQuery(".blog-type-timeline").size() > 0) {
			$container.masonry({isInitLayout: false, transitionDuration: 0});
		} else {
			var num_of_boxes = 2;				
			var containerWidth = jQuery(".masonry-container").width();
			var box_width = (((containerWidth - (num_of_boxes-1)*gutter)/num_of_boxes) | 0) ;
				
			if (containerWidth < min_width) {
				box_width = containerWidth;
			}

			$container.masonry({isInitLayout: false, transitionDuration: 0});
		}

		$container.imagesLoaded( function(){
										
			if (jQuery(".blog-type-timeline").size() > 0) {
				//alert('x');
				$container.masonry({itemSelector: '.boxit.span6',
									gutter: '.gutter-sizer'
							   		});	
				
				var msnry = $container.data("masonry");
				msnry.on("layoutComplete", function() { 
					$container.find(".boxit.span6").each(function() {
						var left = jQuery(this).css("left");
						
						if (left == "0px") {
							jQuery(this).addClass("timeline-left");
						} else {
							jQuery(this).css("left", "auto");
							jQuery(this).css("right", "0px");
							jQuery(this).addClass("timeline-right");
						}
					});
				} );
				msnry.layout();
				
			} else {
				var num_of_boxes = 2;
				var containerWidth = jQuery(".masonry-container").width();
				var box_width = (((containerWidth - (num_of_boxes-1)*gutter)/num_of_boxes) | 0) ;
				
				if (containerWidth < min_width) {
					box_width = containerWidth;
					
				}
               // jQuery('.boxit.span6').width(box_width);
				//alert(box_width);
				$container.masonry({itemSelector: '.boxit.span6', gutter: '.gutter-sizer'});

				var msnry = $container.data("masonry");
				msnry.on("layoutComplete", function() { 
					$container.find(".boxit.span6").each(function() {
						var left = jQuery(this).css("left");
						//alert(left);
						if (left == "0px") {
							jQuery(this).addClass("timeline-left");
							
						} else {
							jQuery(this).css("left", "auto");
							jQuery(this).css("right", "0px");
							jQuery(this).addClass("timeline-right");
						}
					});
													
				} );
				msnry.layout();				
			}


			
		

		});	
											   });


}

function init_masonry_3_columns() {
    jQuery('.masonry-container').each(function() {
		var gutter = 30;
		var min_width = 150;			   
		var $container = jQuery(this);

			var num_of_boxes = 3;				
			var containerWidth = jQuery(".masonry-container").width();
			var box_width = (((containerWidth - (num_of_boxes-1)*gutter)/num_of_boxes) | 0) ;
				
			if (containerWidth < min_width) {
				box_width = containerWidth;
			}

			$container.masonry({isInitLayout: false, transitionDuration: 0});


		$container.imagesLoaded( function(){
										
			
				var num_of_boxes = 3;
				var containerWidth = jQuery(".masonry-container").width();
				var box_width = (((containerWidth - (num_of_boxes-1)*gutter)/num_of_boxes) | 0) ;
				if (containerWidth < min_width) {
					box_width = containerWidth;
					
				}
               // jQuery('.boxit.span6').width(box_width);
				//alert(box_width);
				$container.masonry({itemSelector: '.boxit.span4', gutter: '.gutter-sizer-3'});

				var msnry = $container.data("masonry");
				msnry.on("layoutComplete", function() { 
					var containerWidth = jQuery(".masonry-container").width();
					//alert(containerWidth);
					$container.find(".boxit.span4").each(function() {
						var left = jQuery(this).css("left");
					//alert(left);
						if (left == "0px") {
							//jQuery(this).addClass("timeline-left");
						} else if (parseInt(left) < containerWidth/2) {
							var newLeft = (containerWidth/2) - jQuery(this).width() / 2;
							//alert(newLeft);
							jQuery(this).css("left", newLeft + "px");
							
						} else {
							jQuery(this).css("left", "auto");
							jQuery(this).css("right", "0px");
							//jQuery(this).addClass("timeline-right");
						}
					});
													
				} );
				
				msnry.layout();				
		


			
		

		});	
											   });

}
function init_masonry_4_columns() {
    jQuery('.masonry-container').each(function() {
		var gutter = 30;
		var min_width = 150;			   
		var $container = jQuery(this);

			var num_of_boxes = 4;				
			var containerWidth = jQuery(".masonry-container").width();
			var box_width = (((containerWidth - (num_of_boxes-1)*gutter)/num_of_boxes) | 0) ;
				
			if (containerWidth < min_width) {
				box_width = containerWidth;
			}

			$container.masonry({isInitLayout: false, transitionDuration: 0});


		$container.imagesLoaded( function(){
										
			
				var num_of_boxes = 4;
				var containerWidth = jQuery(".masonry-container").width();
				var box_width = (((containerWidth - (num_of_boxes-1)*gutter)/num_of_boxes) | 0) ;
				if (containerWidth < min_width) {
					box_width = containerWidth;
					
				}
               // jQuery('.boxit.span6').width(box_width);
				//alert(box_width);
				$container.masonry({itemSelector: '.boxit.span3', gutter: '.gutter-sizer-4'});

				var msnry = $container.data("masonry");
				msnry.on("layoutComplete", function() { 
					var containerWidth = jQuery(".masonry-container").width();
					//alert(containerWidth);
					$container.find(".boxit.span3").each(function() {
																  
						var left = jQuery(this).css("left");
					//alert(left);
						if (left == "0px") {
							//jQuery(this).addClass("timeline-left");
						} else if (parseInt(left) < containerWidth/2.5) {
							var newMargin = (containerWidth - jQuery(this).width() * 4) ;
						//	alert(newMargin);
							var newLeft = jQuery(this).width() + (newMargin / 3);
							
							//alert(newLeft);
							jQuery(this).css("left", newLeft + "px");

						} else if (parseInt(left) < containerWidth/3 * 2) {
							var newMargin = (containerWidth - jQuery(this).width() * 4) ;
							var newLeft =  jQuery(this).width() + (newMargin / 3);
							//alert(newLeft);
							//alert(newMargin);
							jQuery(this).css("left", "auto");
							jQuery(this).css("right", newLeft + "px");

						} else {
							jQuery(this).css("left", "auto");
							jQuery(this).css("right", "0px");
							//jQuery(this).addClass("timeline-right");
						}
						
					});
													
				} );
				
				msnry.layout();				
		


			
		

		});	
											   });
}