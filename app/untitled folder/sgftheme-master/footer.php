	<?php global $theme_option; ?>
	<div class="clear" ></div>
	</div><!-- content wrapper -->
<?php //wp_editor("text","editor", array("") ); ?> 


	<?php 
		// page style
		global $gdlr_post_option;
		if( empty($gdlr_post_option) || empty($gdlr_post_option['page-style']) ||
			  $gdlr_post_option['page-style'] == 'normal' || 
			  $gdlr_post_option['page-style'] == 'no-header'){ 
	?>	
	
	<footer class="footer-wrapper" >

<div id="mc_embed_signup">
<form action="https://SpaceGamesFederation.us9.list-manage.com/subscribe/post?u=d078573837e6898fa07883899&amp;id=18dd8b425a" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
    <div id="mc_embed_signup_scroll">
	<h2>Subscribe to our mailing list</h2>
<div class="indicates-required"><span class="asterisk">*</span> indicates required</div>
<div class="mc-field-group name-input">
	<span>
	<label for="mce-FNAME">First Name </label>
	<input type="text" value="" name="FNAME" class="" id="mce-FNAME">
</span>
	<span>
	<label for="mce-LNAME">Last Name </label>
	<input type="text" value="" name="LNAME" class="" id="mce-LNAME">
		</span>
</div>
<div class="mc-field-group">
	<label for="mce-EMAIL">Email Address  <span class="asterisk">*</span>
</label>
	<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
</div>
<div class="mc-field-group">
	<input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
</div>
	<div id="mce-responses" class="clear">
		<div class="response" id="mce-error-response" style="display:none"></div>
		<div class="response" id="mce-success-response" style="display:none"></div>
	</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_d078573837e6898fa07883899_18dd8b425a" tabindex="-1" value=""></div>

    </div>
</form>
</div>
<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';fnames[0]='EMAIL';ftypes[0]='email';fnames[3]='MMERGE3';ftypes[3]='text';fnames[4]='MMERGE4';ftypes[4]='text';fnames[5]='MMERGE5';ftypes[5]='text';fnames[6]='MMERGE6';ftypes[6]='text';fnames[7]='MMERGE7';ftypes[7]='text';fnames[8]='MMERGE8';ftypes[8]='text';fnames[9]='MMERGE9';ftypes[9]='url';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
<!--End mc_embed_signup-->
		
		
		<?php if( $theme_option['show-footer'] != 'disable' ){ ?>
		<div class="footer-container container">
			<?php 	
				$i = 1;
				$theme_option['footer-layout'] = empty($theme_option['footer-layout'])? '1': $theme_option['footer-layout'];
				$gdlr_footer_layout = array(
					'1'=>array('twelve columns'),
					'2'=>array('three columns', 'three columns', 'three columns', 'three columns'),
					'3'=>array('three columns', 'three columns', 'six columns',),
					'4'=>array('four columns', 'four columns', 'four columns'),
					'5'=>array('four columns', 'four columns', 'eight columns'),
					'6'=>array('eight columns', 'four columns', 'four columns'),
				);
			?>
			<?php foreach( $gdlr_footer_layout[$theme_option['footer-layout']] as $footer_class ){ ?>
				<div class="footer-column <?php echo esc_attr($footer_class); ?>" id="footer-widget-<?php echo esc_attr($i); ?>" >
					<?php //dynamic_sidebar('Footer ' . $i); ?>
				</div>
			<?php $i++; ?>
			<?php } ?>
			<div class="clear"></div>
		</div>
		<?php } ?>
		
		
	</footer>
<div class="hero-wrap" id="antihero-wrap">
	<div class="hero" id="anti-hero" role="banner">
	
	
  <div class="bg-video">
   <h2>ENGAGE!</h2>
   <div id="social">
	<ul>
		<li><a href="#" target="_blank" onclick="eMe();return false;" title="Contact the Space Games Federation"><img src="/wp-content/uploads/email-icon-01.svg" alt="Facebook"></a></li>
		<li><a href="https://www.facebook.com/SpaceGamesFederation" target="_blank" title="Like our Facebook Page"><img src="/wp-content/uploads/Facebook-White-02.svg" alt="Facebook"></a></li>
		<li><a href="https://twitter.com/spacegamesfed/" target="_blank" title="Follow us on Twitter"><img src="/wp-content/uploads/Twitter-White-01.svg" alt="Twitter"></a></li>
		<li><a href="https://www.instagram.com/spacegamesfederation/" target="_blank" title="Check it out on Instagram"><img src="/wp-content/uploads/Instagram-White-01.svg" alt="Instagram"></a></li>
		<li><a href="https://vimeo.com/spacegamesfederation" target="_blank" title="Watch us on Vimeo"><img src="/wp-content/uploads/Vimeo-White-01.svg" alt="Vimeo"></a></li>
		<li><a href="https://www.youtube.com/channel/UC5cdpDVq32JuHl8cN6g92TA" title="Subscribe to our YouTube Channel" target="_blank"><img src="/wp-content/uploads/YouTube-White-01.svg" alt="YouTube"></a></li> 
	</ul>
	</div>
   
   
   
    <video poster="/wp-content/uploads/earth-poster.jpg" id="bgvid" width="100%" tabindex="0" autoplay loop>
      <source src="/wp-content/uploads/Earth1280x160-1.mp4" type="video/mp4">
    </video>
    <?php if( $theme_option['show-copyright'] != 'disable' ){ ?>
		<div class="copyright-wrapper">
			<div id="optin"></div>
			<div class="copyright-container container">
				<div class="copyright-left">
					<?php if( !empty($theme_option['copyright-left-text']) ) echo $theme_option['copyright-left-text']; ?>
				</div>
				<div class="copyright-right">
					<?php if( !empty($theme_option['copyright-right-text']) ) echo $theme_option['copyright-right-text']; ?>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<?php } ?>
  </div>
	</div>
		
	<?php } // page style ?>
</div> <!-- body-wrapper -->
</body>
<?php 
$login_page = get_page_by_title( 'Log In' );
wp_footer(); ?>
<script>
	function eMe(){
		window.location = 'mailto:info@spacegamesfederation.com';
		return false;
	}

jQuery(window).load(function(){
	var content = `<?php echo apply_filters('the_content',$login_page->post_content); ?>`;
	if ( jQuery( "#loginform" ).length ) {
		//jQuery(".gdlr-main-content").append('<div class="login-text-box"><h1>Welcome</h1><p>Please register here if you do not have a VIP login access.Looking forward to having you as a member of Space Games Federation.</p><p><a href="https://spacegamesfederation.com/register/" class="button">Register</a></p></div>');
		jQuery(".gdlr-main-content").append(content);
	}

});
</script>
<script>
	document.addEventListener( 'wpcf7submit', function( event ) {
    var inputs = event.detail.inputs;
 
    for ( var i = 0; i < inputs.length; i++ ) {
        if ( 'your-name' == inputs[i].name ) {
            console.log( inputs[i].value );
            break;
        }
    }
}, false );
</script>





</html>