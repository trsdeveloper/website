(function() {
  var $;
  $ = jQuery;
  (function(jQuery){var g,d,j=1,a,b=this,f=!1,h="postMessage",e="addEventListener",c,i=b[h]&&!$.browser.opera;$[h]=function(k,l,m){if(!l){return}k=typeof k==="string"?k:$.param(k);m=m||parent;if(i){m[h](k,l.replace(/([^:]+:\/\/[^\/]+).*/,"$1"))}else{if(l){m.location=l.replace(/#.*$/,"")+"#"+(+new Date)+(j++)+"&"+k}}};$.receiveMessage=c=function(l,m,k){if(i){if(l){a&&c();a=function(n){if((typeof m==="string"&&n.origin!==m)||($.isFunction(m)&&m(n.origin)===f)){return f}l(n)}}if(b[e]){b[l?e:"removeEventListener"]("message",a,f)}else{b[l?"attachEvent":"detachEvent"]("onmessage",a)}}else{g&&clearInterval(g);g=null;if(l){k=typeof m==="number"?m:typeof k==="number"?k:100;g=setInterval(function(){var o=document.location.hash,n=/^#?\d+&/;if(o!==d&&n.test(o)){d=o;l({data:o.replace(n,"")})}},k)}}}})(jQuery);;
  jQuery.fn.stratus = function(settings) {
    return jQuery.stratus(settings);
  };
  jQuery.stratus = function(settings) {
    var root_url, src;
    root_url = settings.env === 'development' ? 'http://example.com:3000' : 'http://stratus.sc';
    if (Array.isArray(settings.links)) {
      console.error("Stratus 1 detected. Visit http://stratus.sc to make sure your code is up to date.");
      console.warn("The Stratus function links has been replaced with a comma seperated string.");
      settings.links = jQuery.map(settings.links, function(link, index) {
        return link['url'];
      });
      settings.links = settings.links.join(',');
    }
    if (settings.randomize !== void 0) {
      console.warn("The Stratus function randomize has been replaced with random.");
      settings.random = settings.randomize;
      delete settings.randomize;
    }
    if (settings.show_user !== void 0) {
      console.warn("The Stratus function show_user has been replaced with user.");
      settings.user = settings.show_user;
      delete settings.show_user;
    }
    if (settings.show_playcount !== void 0) {
      console.warn("The Stratus function show_playcount has been replaced with stats.");
      settings.stats = settings.show_playcount;
      delete settings.show_playcount;
    }
    jQuery('head').append("<link rel='stylesheet' href='" + root_url + "/stratus.css' type='text/css'/>");
    if (settings.align === 'top') {
      jQuery('head').append("<style>#stratus{ top: 0; }</style>");
    }
    jQuery('body').append("<div id='stratus'><iframe allowtransparency='true' frameborder='0' scrolling='0'></div>");
    src = root_url + '/player?' + jQuery.param(settings, true) + '&link=' + encodeURIComponent(document.location.href);
    jQuery('#stratus iframe').attr({
      src: src
    });
    jQuery('#stratus iframe').load(function() {
      return jQuery(this).css({
        visibility: 'visible'
      });
    });
    jQuery('#stratus').show();
    jQuery('a.stratus').click(function() {
      jQuery.postMessage(jQuery(this).attr('href'), src, jQuery('#stratus iframe')[0].contentWindow);
      return false;
    });
    return jQuery.receiveMessage(function(e) {
      return jQuery('#stratus').toggleClass('open');
    }, root_url);
  };
}).call(this);
