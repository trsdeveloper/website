/*
i3dthemes Animations - v2.0.4
Copyright (c) 2011-2014 Luckymarble Solutions Co
*/


/* fadeIn */
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-fade-in').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated fadeOut');
    jQuery(this).addClass('animated fadeIn');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-fade-in').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated fadeIn');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated fadeIn');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-fade-in').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated fadeIn');
    jQuery(this).addClass('animated fadeOut');
  }
}, {
  offset:'80%'
});
});
/* fadeIn */

/* fadeInDown*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-fade-in-down').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated fadeOutUp');
    jQuery(this).addClass('animated fadeInDown');
 
  }
}, {
  offset:'90%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-fade-in-down').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated fadeInDown');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated fadeInDown');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-fade-in-down').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated fadeInDown');
    jQuery(this).addClass('animated fadeOutUp');
  }
}, {
  offset:'90%'
});
});
/* fadeInDown*/


/* fadeInDownBig*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-fade-in-down-big').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated fadeOutUpBig');
    jQuery(this).addClass('animated fadeInDownBig');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-fade-in-down-big').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated fadeInDownBig');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated fadeInDownBig');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-fade-in-down-big').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated fadeInDownBig');
    jQuery(this).addClass('animated fadeOutUpBig');
  }
}, {
  offset:'80%'
});
});
/* fadeInDownBig*/


/* fadeInLeft*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-fade-in-left').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated fadeOutRight');
    jQuery(this).addClass('animated fadeInLeft');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-fade-in-left').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated fadeInLeft');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated fadeInLeft');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-fade-in-left').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated fadeInLeft');
    jQuery(this).addClass('animated fadeOutRight');
  }
}, {
  offset:'80%'
});
});
/* fadeInLeft*/



/* fadeInLeft*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-fade-in-left-big').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated fadeOutRightBig');
    jQuery(this).addClass('animated fadeInLeftBig');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-fade-in-left-big').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated fadeInLeftBig');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated fadeInLeftBig');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-fade-in-left-big').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated fadeInLeftBig');
    jQuery(this).addClass('animated fadeOutRightBig');
  }
}, {
  offset:'80%'
});
});
/* fadeInLeft*/



/* animated-fade-in-right*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-fade-in-right').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated fadeOutLeft');
    jQuery(this).addClass('animated fadeInRight');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-fade-in-right').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated fadeInRight');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated fadeInRight');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-fade-in-right').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated fadeOutLeft');
    jQuery(this).addClass('animated fadeOutLeftBig');
  }
}, {
  offset:'80%'
});
});
/* animated-fade-in-right*/



/* animated-fade-in-right-big*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-fade-in-right-big').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated fadeOutLeftBig');
    jQuery(this).addClass('animated fadeInRightBig');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-fade-in-right-big').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated fadeInRightBig');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated fadeInRightBig');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-fade-in-right-big').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated fadeInRightBig');
    jQuery(this).addClass('animated fadeOutLeftBig');
  }
}, {
  offset:'80%'
});
});
/* animated-fade-in-right-big*/



/* animated-fade-in-up*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-fade-in-up').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated fadeOutDown');
    jQuery(this).addClass('animated fadeInUp');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-fade-in-up').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated fadeInUp');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated fadeInUp');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-fade-in-up').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated fadeInUp');
    jQuery(this).addClass('animated fadeOutDown');
  }
}, {
  offset:'80%'
});
});
/* animated-fade-in-up*/



/* animated-fade-in-up-big*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-fade-in-up-big').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated fadeOutDownBig');
    jQuery(this).addClass('animated fadeInUpBig');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-fade-in-up-big').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated fadeInUpBig');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated fadeInUpBig');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-fade-in-up-big').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated fadeInUpBig');
    jQuery(this).addClass('animated fadeOutDownBig');
  }
}, {
  offset:'80%'
});
});
/* animated-fade-in-up-big*/




/* animated-bounce-in*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-bounce-in').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated bounceOut');
    jQuery(this).addClass('animated bounceIn');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-bounce-in').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated bounceIn');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated bounceIn');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-bounce-in').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated bounceIn');
    jQuery(this).addClass('animated bounceOut');
  }
}, {
  offset:'80%'
});
});
/* animated-bounce-in*/



/* animated-bounce-in-down */
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-bounce-in-down').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated bounceOutUp');
    jQuery(this).addClass('animated bounceInDown');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-bounce-in-down').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated bounceInDown');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated bounceInDown');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-bounce-in-down').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated bounceInDown');
    jQuery(this).addClass('animated bounceOutUp');
  }
}, {
  offset:'80%'
});
});
/* animated-bounce-in-down*/



/* animated-bounce-in-left*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-bounce-in-left').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated bounceOutRight');
    jQuery(this).addClass('animated bounceInLeft');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-bounce-in-left').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated bounceInLeft');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated bounceInLeft');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-bounce-in-left').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated bounceInLeft');
    jQuery(this).addClass('animated bounceOutRight');
  }
}, {
  offset:'80%'
});
});
/* animated-bounce-in-left*/



/* animated-bounce-in-right*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-bounce-in-right').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated bounceOutLeft');
    jQuery(this).addClass('animated bounceInRight');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-bounce-in-right').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated bounceInRight');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated bounceInRight');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-bounce-in-right').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated bounceInRight');
    jQuery(this).addClass('animated bounceOutLeft');
  }
}, {
  offset:'80%'
});
});
/* animated-bounce-in-right*/



/* animated-bounce-in-up*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-bounce-in-up').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated bounceOutDown');
    jQuery(this).addClass('animated bounceInUp');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-bounce-in-up').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated bounceInUp');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated bounceInUp');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-bounce-in-up').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated bounceInUp');
    jQuery(this).addClass('animated bounceOutDown');
  }
}, {
  offset:'80%'
});
});
/* animated-bounce-in-up*/





/* animated-rotate-in*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-rotate-in').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated rotateOut');
    jQuery(this).addClass('animated rotateIn');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-rotate-in').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated rotateIn');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated rotateIn');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-rotate-in').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated rotateIn');
    jQuery(this).addClass('animated rotateOut');
  }
}, {
  offset:'80%'
});
});
/* animated-rotate-in*/




/* animated-rotate-in-down-left*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-rotate-in-down-left').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated rotateOutUpRight');
    jQuery(this).addClass('animated rotateInDownLeft');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-rotate-in-down-left').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated rotateInDownLeft');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated rotateInDownLeft');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-rotate-in-down-left').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated rotateInDownLeft');
    jQuery(this).addClass('animated rotateOutUpRight');
  }
}, {
  offset:'80%'
});
});
/* animated-rotate-in-down-left*/




/* animated-rotate-in-down-right*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-rotate-in-down-right').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated rotateOutUpLeft');
    jQuery(this).addClass('animated rotateInDownRight');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-rotate-in-down-right').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated rotateInDownRight');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated rotateInDownRight');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-rotate-in-down-right').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated rotateInDownRight');
    jQuery(this).addClass('animated rotateOutUpLeft');
  }
}, {
  offset:'80%'
});
});
/* animated-rotate-in-down-right*/




/* animated-rotate-in-up-left*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-rotate-in-up-left').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated rotateOutDownRight');
    jQuery(this).addClass('animated rotateInUpLeft');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-rotate-in-up-left').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated rotateInUpLeft');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated rotateInUpLeft');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-rotate-in-up-left').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated rotateInUpLeft');
    jQuery(this).addClass('animated rotateOutDownRight');
  }
}, {
  offset:'80%'
});
});
/* animated-rotate-in-up-left*/




/* animated-rotate-in-up-right*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-rotate-in-up-right').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated rotateOutDownLeft');
    jQuery(this).addClass('animated rotateInUpRight');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-rotate-in-up-right').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated rotateInUpRight');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated rotateInUpRight');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-rotate-in-up-right').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated rotateInUpRight');
    jQuery(this).addClass('animated rotateOutDownLeft');
  }
}, {
  offset:'80%'
});
});
/* animated-rotate-in-up-right*/




/* animated-zoom-in*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-zoom-in').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated zoomOut');
    jQuery(this).addClass('animated zoomIn');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-zoom-in').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated zoomIn');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated zoomIn');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-zoom-in').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated zoomIn');
    jQuery(this).addClass('animated zoomOut');
  }
}, {
  offset:'80%'
});
});
/* animated-zoom-in*/



/* animated-zoom-in-down */
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-zoom-in-down').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated zoomOut');
    jQuery(this).addClass('animated zoomInLeftLeftDown');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-zoom-in-down').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated zoomInLeftLeftLeftDown');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated zoomInLeftLeftDown');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-zoom-in-down').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated zoomInLeftLeftDown');
    jQuery(this).addClass('animated zoomOut');
  }
}, {
  offset:'80%'
});
});
/* animated-zoom-in-down */



/* animated-zoom-in-up */
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-zoom-in-up').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated zoomOutDown');
    jQuery(this).addClass('animated zoomInUp');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-zoom-in-up').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated zoomInUp');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated zoomInUp');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-zoom-in-up').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated zoomInUp');
    jQuery(this).addClass('animated zoomOutDown');
  }
}, {
  offset:'80%'
});
});
/* animated-zoom-in-up */



/* animated-zoom-in-left*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-zoom-in-left').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated zoomOut');
    jQuery(this).addClass('animated zoomInRightRightLeft');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-zoom-in-left').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated zoomInRightRightLeft');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated zoomInRightRightLeft');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-zoom-in-left').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated zoomInRightRightLeft');
    jQuery(this).addClass('animated zoomOut');
  }
}, {
  offset:'80%'
});
});
/* animated-zoom-in*/



/* animated-zoom-in-right*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-zoom-in-right').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated zoomOut');
    jQuery(this).addClass('animated zoomInRight');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-zoom-in-right').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated zoomInRight');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated zoomInRight');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-zoom-in-right').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated zoomInRight');
    jQuery(this).addClass('animated zoomOut');
  }
}, {
  offset:'80%'
});
});
/* animated-zoom-in-right-right*/



/* animated-roll-in*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-roll-in').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated rollOut');
    jQuery(this).addClass('animated rollIn');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-roll-in').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated rollIn');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated rollIn');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-roll-in').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated rollIn');
    jQuery(this).addClass('animated rollOut');
  }
}, {
  offset:'80%'
});
});
/* animated-roll-in*/



/* animated-hinge*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-hinge').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated fadeOut');
    jQuery(this).addClass('animated hinge');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-hinge').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated hinge');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated hinge');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-hinge').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated hinge');
    jQuery(this).addClass('animated fadeOut');
  }
}, {
  offset:'80%'
});
});
/* animated-hinge*/



/* animated-slide-in-down*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-slide-in-down').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated slideOutUp');
    jQuery(this).addClass('animated slideInDown');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-slide-in-down').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated slideInDown');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated slideInDown');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-slide-in-down').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated slideInDown');
    jQuery(this).addClass('animated slideOutUp');
  }
}, {
  offset:'80%'
});
});
/* animated-slide-in-down*/



/* animated-slide-in-left*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-slide-in-left').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated slideOutRight');
    jQuery(this).addClass('animated slideInLeft');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-slide-in-left').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated slideInLeft');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated slideInLeft');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-slide-in-left').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated slideInLeft');
    jQuery(this).addClass('animated slideOutRight');
  }
}, {
  offset:'80%'
});
});
/* animated-slide-in-left*/




/* animated-slide-in-right*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-slide-in-right').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated slideOutLeft');
    jQuery(this).addClass('animated slideInRight');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-slide-in-right').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated slideInRight');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated slideInRight');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-slide-in-right').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated slideInRight');
    jQuery(this).addClass('animated slideOutLeft');
  }
}, {
  offset:'80%'
});
});
/* animated-slide-in-right*/




/* animated-slide-in-up*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-slide-in-up').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated slideOutDown');
    jQuery(this).addClass('animated slideInUp');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-slide-in-up').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated slideInUp');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated slideInUp');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-slide-in-up').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated slideInUp');
    jQuery(this).addClass('animated slideOutDown');
  }
}, {
  offset:'80%'
});
});
/* animated-slide-in-up*/



/* animated-flip*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-flip').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated flipOutX');
    jQuery(this).addClass('animated flip');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-flip').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated flip');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated flip');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-flip').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated flip');
    jQuery(this).addClass('animated flipOutX');
  }
}, {
  offset:'80%'
});
});
/* animated-flip*/




/* animated-flip-in-x*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-flip-in-x').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated flipOutY');
    jQuery(this).addClass('animated flipInX');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-flip-in-x').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated flipInX');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated flipInX');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-flip-in-x').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated flipInX');
    jQuery(this).addClass('animated flipOutY');
  }
}, {
  offset:'80%'
});
});
/* animated-flip-in-x*/




/* animated-flip-in-y*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-flip-in-y').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated flipOutX');
    jQuery(this).addClass('animated flipInY');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-flip-in-y').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated flipInY');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated flipInY');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-flip-in-y').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated flipInY');
    jQuery(this).addClass('animated flipOutX');
  }
}, {
  offset:'80%'
});
});
/* animated-flip-in-y*/



/* animated-light-speed-in*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-light-speed-in').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated lightSpeedOut');
    jQuery(this).addClass('animated lightSpeedIn');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-light-speed-in').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated lightSpeedIn');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated lightSpeedIn');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-light-speed-in').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated lightSpeedIn');
    jQuery(this).addClass('animated lightSpeedOut');
  }
}, {
  offset:'80%'
});
});
/* animated-light-speed-in*/




/* animated-bounce*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-bounce').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated bounceOut');
    jQuery(this).addClass('animated bounceIn');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-bounce').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated bounceIn');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated bounceIn');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-bounce').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated bounceIn');
    jQuery(this).addClass('animated bounceOut');
  }
}, {
  offset:'80%'
});
});
/* animated-bounce*/



/* animated-flash*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-flash').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated zoomOut');
    jQuery(this).addClass('animated flash');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-flash').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated flash');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated flash');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-flash').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated flash');
    jQuery(this).addClass('animated zoomOut');
  }
}, {
  offset:'80%'
});
});
/* animated-flash*/




/* animated-pulse*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-pulse').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated zoomOut');
    jQuery(this).addClass('animated pulse');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-pulse').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated pulse');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated pulse');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-pulse').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated pulse');
    jQuery(this).addClass('animated zoomOut');
  }
}, {
  offset:'80%'
});
});
/* animated-pulse*/




/* animated-rubber-band*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-rubber-band').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated zoomOut');
    jQuery(this).addClass('animated rubberBand');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-rubber-band').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated rubberBand');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated rubberBand');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-rubber-band').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated rubberBand');
    jQuery(this).addClass('animated zoomOut');
  }
}, {
  offset:'80%'
});
});
/* animated-rubber-band*/




/* animated-shake*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-shake').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated zoomOut');
    jQuery(this).addClass('animated shake');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-shake').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated shake');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated shake');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-shake').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated shake');
    jQuery(this).addClass('animated zoomOut');
  }
}, {
  offset:'80%'
});
});
/* animated-shake*/




/* animated-swing*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-swing').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated zoomOut');
    jQuery(this).addClass('animated swing');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-swing').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated swing');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated swing');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-swing').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated swing');
    jQuery(this).addClass('animated zoomOut');
  }
}, {
  offset:'80%'
});
});
/* animated-swing*/




/* animated-tada*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-tada').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated zoomOut');
    jQuery(this).addClass('animated tada');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-tada').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated tada');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated tada');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-tada').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated tada');
    jQuery(this).addClass('animated zoomOut');
  }
}, {
  offset:'80%'
});
});
/* animated-tada*/




/* animated-wobble*/
jQuery(document).ready( function () { 

/* (action1) enter page - scrolling down */
jQuery('.animated-wobble').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('');

  } else if (direction == "down") {
    jQuery(this).removeClass('animated zoomOut');
    jQuery(this).addClass('animated wobble');
 
  }
}, {
  offset:'80%'
});

/* (action3) enter page - scrolling up */
jQuery('.animated-wobble').waypoint(function(direction) {
  if (direction == "up") {
    jQuery(this).addClass('animated wobble');

/* (action2) leave page - scrolling down */
  } else if (direction == "down") { 
    jQuery(this).removeClass('animated wobble');/* removes active class when scrolled off top of page */
  }
}, { offset:  function() { return -$(this).height() * .6; }
});

/* scrolling down first action */
jQuery('.animated-wobble').waypoint(function(direction) {
  if (direction == "down") {
   // jQuery(this).addClass('');
  } else if (direction == "up") {
    jQuery(this).removeClass('animated wobble');
    jQuery(this).addClass('animated zoomOut');
  }
}, {
  offset:'80%'
});
});
/* animated-wobble*/

























