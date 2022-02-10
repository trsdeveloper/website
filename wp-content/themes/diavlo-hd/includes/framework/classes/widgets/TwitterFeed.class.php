<?php

/***********************************/
/**     LM*TWITTER WIDGET BOX     **/
/***********************************/
class I3D_Widget_TwitterFeed extends WP_Widget {
	function __construct() {
	//function I3D_Widget_TwitterFeed() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'A component renders your twitter feed', "i3d-framework") );
		parent::__construct('i3d_twitterfeed', __('i3d:Twitter Feed', "i3d-framework"), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
	
		$username = strip_tags(@$instance['username']);
		$height = strip_tags(@$instance['height']);
		
		echo $before_widget;
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } ?>
<a class="twitter-timeline" href="https://twitter.com/<?php echo $username; ?>" data-screen-name="<?php echo $username; ?>" data-widget-id="278303053629767681">Tweets by @<?php echo $username; ?></a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

<script>
var hideTwitterAttempts = 0;
function hideTwitterBoxElements() {
    setTimeout( function() {
        if ( $('[id*=twitter]').length ) {
        $('[id*=twitter]').each( function(){
            var ibody = $(this).contents().find( 'body' );
			<?php if ($height != "") { ?>
			if ( ibody.find( '.timeline .stream .h-feed li.tweet' ).length ) {
				ibody.find('.stream').css('height', '<?php echo $height; ?>');
			}
			<?php } ?>
/*
            if ( ibody.find( '.timeline .stream .h-feed li.tweet' ).length ) {
            ibody.find( '.customisable-border' ).css( 'border', 0 );
            ibody.find( '.timeline' ).css( 'background-color', 'transparent' ); //theme: shell: background:
            ibody.find( 'ol.h-feed' ).css( 'background-color', '#ffffff' ); //theme: tweets: background:
            ibody.find( 'ol.h-feed' ).css( 'border-radius', '5px 5px 5px 5px' );
            ibody.find( 'li.tweet' ).css( 'border-bottom', '1px dotted #FFFFFF' ); //theme: tweets: color:
            ibody.find( 'li.tweet' ).css( 'color', '#FFFFFF' ); //theme: tweets: color:
            ibody.find( '.customisable:link' ).css( 'color', '#07E0EB' ); //theme: tweets: links:
            ibody.find( '.footer' ).css( 'visibility', 'hidden' ); //hide reply, retweet, favorite images
            ibody.find( '.footer' ).css( 'min-height', 0 ); //hide reply, retweet, favorite images
            ibody.find( '.footer' ).css( 'height', 0 ); //hide reply, retweet, favorite images
            ibody.find( '.avatar' ).css( 'height', 0 ); //hide avatar
            ibody.find( '.avatar' ).css( 'width', 0 ); //hide avatar
            ibody.find( '.p-nickname' ).css( 'font-size', 0 ); //hide @name of tweet
            ibody.find( '.p-nickname' ).css( 'visibility', 'hidden' ); //hide @name of tweet
            ibody.find( '.e-entry-content' ).css( 'margin', '-25px 0px 0px 0px' ); //move tweet up (over @name of tweet)
            ibody.find( '.dt-updated' ).css( 'color', '#07E0EB' ); //theme: tweets: links:
            ibody.find( '.full-name' ).css( 'margin', '0px 0px 0px -35px' ); //move name of tweet to left (over avatar)
            ibody.find( 'h1.summary' ).replaceWith( '<h1 class="summary"><a class="customisable-highlight" title="Tweets from <?php echo $username; ?>" href="https://twitter.com/<?php echo $username; ?>" style="color: #FFFFFF;"><?php echo $username; ?></a></h1>' ); //replace Tweets text at top
            ibody.find( '.p-name' ).css( 'color', '#07E0EB' ); //theme: tweets: links:
            }
            else {
                $(this).hide();
            }
			*/
        });
        }
        hideTwitterAttempts++;
        if ( hideTwitterAttempts < 3 ) {
            hideTwitterBoxElements();
        }
    }, 1500);
}

// somewhere in your code after html page load
hideTwitterBoxElements();
</script>
		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['username'] = strip_tags($new_instance['username']);
		$instance['title']    = strip_tags($new_instance['title']);
		$instance['height']    = strip_tags($new_instance['height']);
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'username' => '', 'title' => '' ) );
		$title = strip_tags($instance['title']);
		$username = strip_tags($instance['username']);
		$height = strip_tags(@$instance['height']);
?>
        <script>

jQuery("a.widget-action").bind("click", function() {
				//shrinkVideoRegion(this);									

});
 
jQuery("a.widget-control-close").bind("click", function() {
				//shrinkVideoRegion(this);									

});
</script>

<div class='i3d-widget-container'>
    <div class='i3d-help-region'>
    <div class='i3d-help-region-closed'><div class='i3d-help-title-bar'><a target="_blank" href="http://www.youtube.com/watch?v=LxMalGndGIE"><i class='icon-youtube-play'></i> Watch Help Video &nbsp;  <i  class='icon-external-link'></i></a></div></div>
   <!-- <div class='i3d-help-region-opened i3d-help-region-hidden'>
    <div class='i3d-help-title-bar'>Hide <i class='icon-chevron-right'></i></div>
<iframe width="420" height="315" src="//www.youtube.com/embed/LxMalGndGIE" frameborder="0" allowfullscreen></iframe>
    </div>-->
    </div>
<div class='i3d-widget-main'>

		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:',"i3d-framework"); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Twitter Username:',"i3d-framework"); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo esc_attr($username); ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Height:',"i3d-framework"); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo esc_attr($height); ?>" /></p>
</div>
</div>
<?php
	}
}



?>