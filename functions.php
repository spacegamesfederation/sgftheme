<?php
	/*	
	*	Goodlayers Function File
	*	---------------------------------------------------------------------
	*	This file include all of important function and features of the theme
	*	---------------------------------------------------------------------
	*/
	
	////// DO NOT REMOVE OR MODIFY THIS /////
	define('WP_THEME_KEY', 'goodlayers');  //
	/////////////////////////////////////////
	
	define('THEME_FULL_NAME', 'The Keynote');
	define('THEME_SHORT_NAME', 'tkno');
	define('THEME_SLUG', 'thekeynote');
	
	define('AJAX_URL', admin_url('admin-ajax.php'));
	define('GDLR_PATH', get_template_directory_uri());
	define('GDLR_LOCAL_PATH', get_template_directory());
	
	if ( !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443 ) {
		define('GDLR_HTTP', 'https://');
	}else{
		define('GDLR_HTTP', 'http://');
	}


	$gdlr_gallery_id = 0;
	$gdlr_lightbox_id = 0;
	$gdlr_crop_video = false;
	$gdlr_excerpt_length = 55;
	$gdlr_excerpt_read_more = false;

	$gdlr_spaces = array(
		'top-wrapper' => '70px', 
		'bottom-wrapper'=>'40px', 
		'top-full-wrapper' => '0px', 
		'bottom-item' => '20px',
		'bottom-blog-item' => '0px',
		'bottom-divider-item' => '50px'
	);
	
	$theme_option = get_option(THEME_SHORT_NAME . '_admin_option', array());
	$theme_option['content-width'] = 960;
	
	// include goodlayers framework
	include_once( 'framework/gdlr-framework.php' );
	
	//-------------------------- theme section ---------------------------//

	// create sidebar controller
	$gdlr_sidebar_controller = new gdlr_sidebar_generator();	
	
	// create font controller
	if( empty($theme_option['upload-font']) ){ $theme_option['upload-font'] = ''; }
	$gdlr_font_controller = new gdlr_font_loader( json_decode($theme_option['upload-font'], true) );	
	
	// create navigation controller
	if( empty($theme_option['enable-goodlayers-navigation']) || $theme_option['enable-goodlayers-navigation'] != 'disable'){
		include_once( 'include/gdlr-navigation-menu.php');
	}	
	if( empty($theme_option['enable-goodlayers-mobile-navigation']) || $theme_option['enable-goodlayers-mobile-navigation'] != 'disable'){
		include_once( 'include/gdlr-responsive-menu.php');
	}
	
	// utility function
	include_once( 'include/function/gdlr-media.php');
	include_once( 'include/function/gdlr-utility.php');		

	// register function / filter / action
	include_once( 'functions-size.php');	
	include_once( 'include/gdlr-include-script.php');	
	include_once( 'include/function/gdlr-function-regist.php');	
	
	// create admin option
	include_once( 'include/gdlr-admin-option.php');
	include_once( 'include/gdlr-plugin-option.php');
	include_once( 'include/gdlr-font-controls.php');
	include_once( 'include/gdlr-social-icon.php');

	// create page options
	include_once( 'include/gdlr-page-options.php');
	include_once( 'include/gdlr-demo-page.php');
	include_once( 'include/gdlr-post-options.php');
	
	// create page builder
	include_once( 'include/gdlr-page-builder-option.php');
	include_once( 'include/function/gdlr-page-builder.php');
	
	include_once( 'include/function/gdlr-page-item.php');
	include_once( 'include/function/gdlr-blog-item.php');
	
	// widget
	include_once( 'include/widget/recent-comment.php');
	include_once( 'include/widget/recent-post-widget.php');
	include_once( 'include/widget/popular-post-widget.php');
	include_once( 'include/widget/post-slider-widget.php');	
	include_once( 'include/widget/recent-port-widget.php');
	include_once( 'include/widget/recent-port-widget-2.php');
	include_once( 'include/widget/port-slider-widget.php');
	include_once( 'include/widget/twitter-widget.php');
	include_once( 'include/widget/flickr-widget.php');
	include_once( 'include/widget/video-widget.php');
	
	//custom widgets
	include_once( 'include/widget/newsletter-widget.php');
	include_once( 'include/widget/entry-widget.php');

	// plugin support
	include_once( 'plugins/gdlr-paypal.php');
	include_once( 'plugins/wpml.php');
	include_once( 'plugins/layerslider.php' );
	include_once( 'plugins/masterslider.php' );
	include_once( 'plugins/woocommerce.php' );
	include_once( 'plugins/twitteroauth.php' );
	include_once( 'plugins/goodlayers-importer.php' );
	
	if( empty($theme_option['enable-plugin-recommendation']) || $theme_option['enable-plugin-recommendation'] == 'enable' ){
		include_once( 'include/plugin/gdlr-plugin-activation.php');
	}

	// init include script class
	if( !is_admin() ){ new gdlr_include_script(); }	
	function my_page_template_redirect()
{
    if( is_user_logged_in() )
    {
        wp_redirect( 'http://spacegamesfederation.com/landing/'  );
        exit();
    }
}


/* BELOW HERE IS CUSTOM CODE ADDED TO THE KEYNOTE THEME*/
	wp_enqueue_script('threejs','https://cdnjs.cloudflare.com/ajax/libs/three.js/r71/three.min.js',false,'1.1',false);
	wp_enqueue_script('main', get_stylesheet_directory_uri() . '/main.js',false,'1.1',"all");


function team_meta_box( $meta_boxes ) {
	$prefix = 'team_';

	$meta_boxes[] = array(
		'id' => 'team-info',
		'title' => esc_html__( 'Team Member Data', 'team-member-info' ),
		'post_types' => array( 'team' ),
		'context' => 'advanced',
		'priority' => 'default',
		'autosave' => false,
		'fields' => array(
			array(
				'id' => $prefix . 'email',
				'type' => 'text',
				'name' => esc_html__( 'Email Address', 'team-member-info' ),
				'desc' => esc_html__( '', 'team-member-info' ),
				'placeholder' => esc_html__( '', 'team-member-info' ),
				'size' => 15,
			),
			array(
				'id' => $prefix . 'phone',
				'type' => 'text',
				'name' => esc_html__( 'Phone Number', 'team-member-info' ),
				'desc' => esc_html__( ' ', 'team-member-info' ),
				'placeholder' => esc_html__( '', 'team-member-info' ),
				'size' => 15,
			),
			array(
				'id' => $prefix . 'twitter',
				'type' => 'text',
				'name' => esc_html__( 'Twitter', 'team-member-info' ),
				'desc' => esc_html__( 'Twitter Handle (sans @)', 'team-member-info' ),
				'placeholder' => esc_html__( '@twitterhandle', 'team-member-info' ),
				'size' => 15,
			),
			array(
				'id' => $prefix . 'facebook',
				'type' => 'text',
				'name' => esc_html__( 'Facebook Page name', 'team-member-info' ),
				'desc' => esc_html__( 'Facebook Slug (sans url) ', 'team-member-info' ),
				'placeholder' => esc_html__( 'name only after facebook.com/____', 'team-member-info' ),
				'size' => 15,
			),
			array(
				'id' => $prefix . 'instagram',
				'type' => 'text',
				'name' => esc_html__( 'Facebook Page', 'team-member-info' ),
				'desc' => esc_html__( 'http://facebook.com/ ', 'team-member-info' ),
				'placeholder' => esc_html__( 'Full I URL', 'team-member-info' ),
				'size' => 15,
			),
			array(
				'id' => $prefix . 'linkedin',
				'type' => 'text',
				'name' => esc_html__( 'Linked-In', 'team-member-info' ),
				'desc' => esc_html__( 'Linked In Slug (sans url)', 'team-member-info' ),
				'placeholder' => esc_html__( 'name only (after /in/', 'team-member-info' ),
				'size' => 15,
			),
			
			
			array(
				'id' => $prefix . 'youtube',
				'type' => 'text',
				'name' => esc_html__( 'YouTube', 'team-member-info' ),
				'desc' => esc_html__( 'YouTube Channel URL', 'team-member-info' ),
				'placeholder' => esc_html__( 'http://youtube/', 'team-member-info' ),
				'size' => 15,
			),
			array(
				'id' => $prefix . 'vimeo',
				'type' => 'text',
				'name' => esc_html__( 'Vimeo', 'team-member-info' ),
				'desc' => esc_html__( 'Vimeo URL', 'team-member-info' ),
				'placeholder' => esc_html__( '', 'team-member-info' ),
				'size' => 15,
			)
		),
	);

	return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'team_meta_box' );

function social_meta_box( $meta_boxes ) {
	$prefix = 'social_';

	$meta_boxes[] = array(
		'id' => 'social-info',
		'title' => esc_html__( 'Social Media', 'social-member-info' ),
		'post_types' => array( 'social' ),
		'context' => 'advanced',
		'priority' => 'default',
		'autosave' => false,
		'fields' => array(
			array(
				'id' => $prefix . 'url',
				'type' => 'text',
				'name' => esc_html__( 'Social URL', 'social-member-info' ),
				'desc' => esc_html__( 'Enter Full URL', 'social-member-info' ),
				'placeholder' => esc_html__( 'Social Network URL', 'social-member-info' ),
				'size' => 30,
			),array(
				'id' => $prefix . 'greeting',
				'type' => 'text',
				'name' => esc_html__( 'Greeting Text', 'social-member-info' ),
				'desc' => esc_html__( 'Seen on Hover.', 'social-member-info' ),
				'placeholder' => esc_html__( 'like us, follow us...', 'social-member-info' ),
				'size' => 30,
			)
			
		),
	);

	return $meta_boxes;
}


add_filter( 'rwmb_meta_boxes', 'social_meta_box' );


function video_meta_box( $meta_boxes ) {
	$prefix = 'video_';

	$meta_boxes[] = array(
		'id' => 'video-info',
		'title' => esc_html__( 'Video', 'video-info' ),
		'post_types' => array( 'video' ),
		'context' => 'advanced',
		'priority' => 'default',
		'autosave' => false,
		'fields' => array(
			
			array(
				'id' => $prefix . 'platform',
				'name' => esc_html__( 'Video Platform', 'metabox-online-generator' ),
				'type' => 'select_advanced',
				'placeholder' => esc_html__( 'Select Platform', 'metabox-online-generator' ),
				'options' => array(
					'vimeo' => 'Vimeo',
					'youtube' => 'YouTube',
				),
			),
			array(
				'id' => $prefix . 'id',
				'type' => 'text',
				'name' => esc_html__( 'Video ID', 'video-info' ),
				'desc' => esc_html__( '(code only, no url)', 'video-info' ),
				'placeholder' => esc_html__( '', 'video-info' ),
				'size' => 15,
			)



		),
	);

	return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'video_meta_box' );

function featured_video_meta_box( $meta_boxes ) {
	$prefix = 'video_';
		global $wpdb;
		$sql = "select ID, post_title from wp_posts where post_type = 'video' and post_status = 'publish' order by post_title";
		$video_list = $wpdb->get_results($sql);
		$video_array = array();
			foreach($video_list as $key => $value){
				$platform = get_post_meta($value->ID,"video_platform",true);
					$video_array[$value->ID] =  $value->post_title . " (" .ucfirst($platform) .")";
			}


	$meta_boxes[] = array(
		'id' => 'video-info',
		'title' => esc_html__( 'Video', 'video-info' ),
		'post_types' => array( 'post', 'page' ),
		'context' => 'advanced',
		'priority' => 'default',
		'autosave' => false,
		'fields' => array(
			
			array(
				'id' => $prefix . 'featured',
				'name' => esc_html__( 'Select Video', 'metabox-online-generator' ),
				'type' => 'select_advanced',
				'placeholder' => esc_html__( 'Video List', 'video-info' ),
				'options' => $video_array,
			),
			array(
				'id' => $prefix . 'display_title',
				'type' => 'text',
				'name' => esc_html__( 'Display Title', 'video-info' ),
				'desc' => esc_html__( '(optional override to title)', 'video-info' ),
				'placeholder' => esc_html__( '', 'video-info' ),
				'size' => 30,
			)



		),
	);

	return $meta_boxes;
}



add_filter( 'rwmb_meta_boxes', 'featured_video_meta_box' );














	//slick
	wp_enqueue_script( 'slickjs', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js',false,'1.1','all');
	wp_enqueue_style( 'slickcss', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css', array ( 'jquery' ), 1.1, true);
//	wp_enqueue_script('threejs','https://cdnjs.cloudflare.com/ajax/libs/three.js/r71/three.min.js',false,'1.1','all');
//	wp_enqueue_script('stars', get_template_directory_uri() . '/app/js/starfield.js',false,'1.1',true);
    wp_enqueue_script('app', get_template_directory_uri() . '/app/js/app.js',false,'1.1',true);
	if($post->ID == "4020"){
//		wp_enqueue_script('entryForm', get_template_directory_uri() . '/app/js/entryform.js',false,'1.1',true);
		wp_enqueue_script('countable', get_template_directory_uri() . '/app/js/countable.min.js',false,'1.1',true);
	}
	if(print $post->ID == "4649"){
		wp_enqueue_script('tv_carousel', get_template_directory_uri() . '/app/js/tv-carousel.js',false,'1.1',true);
	}
if(print $post->ID == "4757"){
		wp_enqueue_script('jquery-ui-sortable', get_template_directory_uri() . 'https://code.jquery.com/ui/1.12.1/jquery-ui.js',false,'1.1',true);
	}





function display_content( $atts ){
	
	 $p = get_post($atts['id']);
	//print var_dump($atts);
   return wpautop($p->post_content);
	
}
add_shortcode( 'rules', 'display_content' );


;


add_filter( 'wpcf7_form_elements', 'mycustom_wpcf7_form_elements' );
function mycustom_wpcf7_form_elements( $form ) {
	
  $form = do_shortcode( $form );
  
  return $form;
}



function my_format_TinyMCE( $in ) {
	$in['remove_linebreaks'] = false;
	$in['gecko_spellcheck'] = false;
	$in['keep_styles'] = true;
	$in['accessibility_focus'] = true;
	$in['tabfocus_elements'] = 'major-publishing-actions';
	$in['media_strict'] = false;
	$in['paste_remove_styles'] = false;
	$in['paste_remove_spans'] = false;
	$in['paste_strip_class_attributes'] = 'none';
	$in['paste_text_use_dialog'] = true;
	$in['wpeditimage_disable_captions'] = true;
	$in['plugins'] = 'tabfocus,paste,media,fullscreen,wordpress,wpeditimage,wpgallery,wplink,wpdialogs,wpfullscreen';
	$in['content_css'] = get_template_directory_uri() . "/editor-style.css";
	$in['wpautop'] = true;
	$in['apply_source_formatting'] = false;
        $in['block_formats'] = "Paragraph=p; Heading 3=h3; Heading 4=h4";
	$in['toolbar1'] = 'bold,italic,strikethrough,bullist,numlist,blockquote,hr,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,wp_fullscreen,wp_adv ';
	$in['toolbar2'] = 'formatselect,underline,alignjustify,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help ';
	$in['toolbar3'] = '';
	$in['toolbar4'] = '';
	return $in;
}
add_filter( 'tiny_mce_before_init', 'my_format_TinyMCE' );



function yoastVariableToTitle($post_id) {
    $yoast_title = get_post_meta($post_id, '_yoast_wpseo_title', true);
    $title = strstr($yoast_title, '%%', true);
    if (empty($title)) {
        $title = get_the_title($post_id);
    }
    return $title;
}





function yoastVariableToDescription($post_id) {
    $yoast_description = get_post_meta($post_id, '_yoast_wpseo_description', true);
    $description = strstr($yoast_description, '%%', true);
    if (empty($description)) {
		
        $description = get_bloginfo( 'description' );
		
    }
    return $description;
}


function init_widgets() {
	register_sidebar( array(
		'name'          => __( 'VideoMenu', '' ),
		'id'            => 'video-menu',
		'description'   => __( '', '' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
		register_sidebar( array(
		'name'          => __( 'Newsletter Menu', '' ),
		'id'            => 'newsletter-menu',
		'description'   => __( '', '' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
register_sidebar( array(
		'name'          => __( 'Challenge Entries', '' ),
		'id'            => 'challenge-entry',
		'description'   => __( '', '' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );

}


add_action( 'widgets_init', 'init_widgets' );



function getThumbnail($id, $size="thumbnail"){
		global $post;
		global $wpdb;
	
		$img = wp_get_attachment_image_src( get_post_thumbnail_id( $id ),$size);

		if($img[0] !=""){
		
			return $img[0];	
		}	
}

function get_extension($file) {
 $extension = end(explode(".", $file));
 return $extension ? $extension : false;
}

function slickVideo(){

		global $wpdb;
		
		$vimeography_gallery_db = $wpdb->prefix."vimeography_gallery";
	
		$sql = "select id, title from $vimeography_gallery_db order by list_order";
		$galleries = $wpdb->get_results($sql);
	
	ob_start();
?>

<div id="video-carousel">	

	<div id="channels">
	
	<nav id="video-subnav" class="video-navigation" role="navigation">
			<ul>
	<?php
		
	$counter = 0;
foreach($galleries as $key => $gallery){
		extract((array) $gallery);
		$src= getThumbnail($ID,"Full");
		$ext = get_extension($src);
		$this_class = "thumb";
		

		?>
		<li title="<?=$title?>">
			<a href="#" data-slide="<?=$counter?>"><?=$title?></a>

		</li>
		<?php
		$counter++;		
	}
?>
		</ul>		
	</nav> 
	</div>



			<div class="slideshow" id="spacegamesTV" style="display: none;">
				
	<?php
	
	$counter = 0;
	
foreach($galleries as $key => $gallery){
	
	extract((array) $gallery);
	
		
		//$src= getThumbnail($ID,"Full");
		$ext = get_extension($src);
		$this_class = "thumb";
		

		?>
		<div>
				<div class="slide-wrap">
				<h2><?=$title?></h2>
			<?php print 	do_shortcode( '[vimeography id="'.$id.'"]' );	?>
			</div>
				</div>
		
		<?php
		$counter++;		
	}
?>
	</div>
</div>
<?php	
	return ob_get_clean();
}


function displayVideo($id,$title=""){
	ob_start();

		$video_id = get_post_meta($id,"video_id",true);
		$video_platform = get_post_meta($id,"video_platform",true);

			if($video_platform == 'vimeo'){
				$video_url = 'https://player.vimeo.com/video/'.$video_id;
			} else if ($video_platform == 'youtube'){
				 $video_url = 'https://www.youtube.com/embed/'.$video_id."?rel=0";
			}


		?>
<div class="video-wrapper"><iframe src="<?=$video_url?>" allowfullscreen="allowfullscreen"></iframe></div>


		<?php



	return ob_get_clean();
}


function getSocialIcons(){
		
		global $wpdb;
		$sql = "select ID, post_title from wp_posts where post_type = 'social' and post_status = 'publish'";
		$social_data = $wpdb->get_results($sql);


		ob_start();
		?>
		<div class="social-icons" id="social-menu">
			<ul>
		<?php
		if(count($social_data)){

			foreach($social_data as $key => $value ){
				$icon = getThumbnail($value->ID);
				$social_url = get_post_meta($value->ID,"social_url",true);
				$greeting= get_post_meta($value->ID,"social_greeting",true);
				?>
					<li><a href="<?=$social_url?>" target="_blank"><img class="style-svg" src="<?=$icon?>" alt="<?=$value->post_title?> icon"></a></li>

				<?php


			}
		}
		print "</ul>
		</div>";

		return ob_get_clean();	
}


function countdown(){
	$today_start = strtotime('today');
	$year=date("Y",$today_start);
	$month=date("n",$today_start);
	$day=date("j",$today_start);
	$days = ceil((strtotime("4/15/".$year) - time())/(60*60*24));

	if($days<0){
		$year++;
		$days = ceil((strtotime("4/15/".$year) - time())/(60*60*24));
	}



	
    
// Hours (in the last hour will be zero)

	
	return $days;

}










function display_countrylist( $atts ){
	$options = 
'<option value="United States">United States</option>
<option value="United Kingdom">United Kingdom</option>
<option value="Canada">Canada</option>
<option value="Afghanistan">Afghanistan</option>
<option value="Albania">Albania</option>
<option value="Algeria">Algeria</option>
<option value="American Samoa">American Samoa</option>
<option value="Andorra">Andorra</option>
<option value="Angola">Angola</option>
<option value="Anguilla">Anguilla</option>
<option value="Antigua and Barbuda">Antigua and Barbuda</option>
<option value="Argentina">Argentina</option>
<option value="Armenia">Armenia</option>
<option value="Aruba">Aruba</option>
<option value="Australia">Australia</option>
<option value="Austria">Austria</option>
<option value="Azerbaijan">Azerbaijan</option>
<option value="The Bahamas">The Bahamas</option>
<option value="Bahrain">Bahrain</option>
<option value="Bangladesh">Bangladesh</option>
<option value="Barbados">Barbados</option>
<option value="Belarus">Belarus</option>
<option value="Belgium">Belgium</option>
<option value="Belize">Belize</option>
<option value="Benin">Benin</option>
<option value="Bermuda">Bermuda</option>
<option value="Bhutan">Bhutan</option>
<option value="Bolivia">Bolivia</option>
<option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
<option value="Botswana">Botswana</option>
<option value="Brazil">Brazil</option>
<option value="Brunei">Brunei</option>
<option value="Bulgaria">Bulgaria</option>
<option value="Burkina Faso">Burkina Faso</option>
<option value="Burundi">Burundi</option>
<option value="Cambodia">Cambodia</option>
<option value="Cameroon">Cameroon</option>
<option value="Canada">Canada</option>
<option value="Cape Verde">Cape Verde</option>
<option value="Cayman Islands">Cayman Islands</option>
<option value="Central African Republic">Central African Republic</option>
<option value="Chad">Chad</option>
<option value="Chile">Chile</option>
<option value="People\'s Republic of China">People\'s Republic of China</option>
<option value="Republic of China">Republic of China</option>
<option value="Christmas Island">Christmas Island</option>
<option value="Cocos(Keeling) Islands">Cocos(Keeling) Islands</option>
<option value="Colombia">Colombia</option>
<option value="Comoros">Comoros</option>
<option value="Congo">Congo</option>
<option value="Cook Islands">Cook Islands</option>
<option value="Costa Rica">Costa Rica</option>
<option value="Cote d\'Ivoire">Cote d\'Ivoire</option>
<option value="Croatia">Croatia</option>
<option value="Cuba">Cuba</option>
<option value="Cyprus">Cyprus</option>
<option value="Czech Republic">Czech Republic</option>
<option value="Denmark">Denmark</option>
<option value="Djibouti">Djibouti</option>
<option value="Dominica">Dominica</option>
<option value="Dominican Republic">Dominican Republic</option>
<option value="Ecuador">Ecuador</option>
<option value="Egypt">Egypt</option>
<option value="El Salvador">El Salvador</option>
<option value="Equatorial Guinea">Equatorial Guinea</option>
<option value="Eritrea">Eritrea</option>
<option value="Estonia">Estonia</option>
<option value="Ethiopia">Ethiopia</option>
<option value="Falkland Islands">Falkland Islands</option>
<option value="Faroe Islands">Faroe Islands</option>
<option value="Fiji">Fiji</option>
<option value="Finland">Finland</option>
<option value="France">France</option>
<option value="French Polynesia">French Polynesia</option>
<option value="Gabon">Gabon</option>
<option value="The Gambia">The Gambia</option>
<option value="Georgia">Georgia</option>
<option value="Germany">Germany</option>
<option value="Ghana">Ghana</option>
<option value="Gibraltar">Gibraltar</option>
<option value="Greece">Greece</option>
<option value="Greenland">Greenland</option>
<option value="Grenada">Grenada</option>
<option value="Guadeloupe">Guadeloupe</option>
<option value="Guam">Guam</option>
<option value="Guatemala">Guatemala</option>
<option value="Guernsey">Guernsey</option>
<option value="Guinea">Guinea</option>
<option value="Guinea - Bissau">Guinea - Bissau</option>
<option value="Guyana">Guyana</option>
<option value="Haiti">Haiti</option>
<option value="Honduras">Honduras</option>
<option value="Hong Kong">Hong Kong</option>
<option value="Hungary">Hungary</option>
<option value="Iceland">Iceland</option>
<option value="India">India</option>
<option value="Indonesia">Indonesia</option>
<option value="Iran">Iran</option>
<option value="Iraq">Iraq</option>
<option value="Ireland">Ireland</option>
<option value="Israel">Israel</option>
<option value="Italy">Italy</option>
<option value="Jamaica">Jamaica</option>
<option value="Japan">Japan</option>
<option value="Jersey">Jersey</option>
<option value="Jordan">Jordan</option>
<option value="Kazakhstan">Kazakhstan</option>
<option value="Kenya">Kenya</option>
<option value="Kiribati">Kiribati</option>
<option value="North Korea">North Korea</option>
<option value="South Korea">South Korea</option>
<option value="Kosovo">Kosovo</option>
<option value="Kuwait">Kuwait</option>
<option value="Kyrgyzstan">Kyrgyzstan</option>
<option value="Laos">Laos</option>
<option value="Latvia">Latvia</option>
<option value="Lebanon">Lebanon</option>
<option value="Lesotho">Lesotho</option>
<option value="Liberia">Liberia</option>
<option value="Libya">Libya</option>
<option value="Liechtenstein">Liechtenstein</option>
<option value="Lithuania">Lithuania</option>
<option value="Luxembourg">Luxembourg</option>
<option value="Macau">Macau</option>
<option value="Macedonia">Macedonia</option>
<option value="Madagascar">Madagascar</option>
<option value="Malawi">Malawi</option>
<option value="Malaysia">Malaysia</option>
<option value="Maldives">Maldives</option>
<option value="Mali">Mali</option>
<option value="Malta">Malta</option>
<option value="Marshall Islands">Marshall Islands</option>
<option value="Martinique">Martinique</option>
<option value="Mauritania">Mauritania</option>
<option value="Mauritius">Mauritius</option>
<option value="Mayotte">Mayotte</option>
<option value="Mexico">Mexico</option>
<option value="Micronesia">Micronesia</option>
<option value="Moldova">Moldova</option>
<option value="Monaco">Monaco</option>
<option value="Mongolia">Mongolia</option>
<option value="Montenegro">Montenegro</option>
<option value="Montserrat">Montserrat</option>
<option value="Morocco">Morocco</option>
<option value="Mozambique">Mozambique</option>
<option value="Myanmar">Myanmar</option>
<option value="Nagorno - Karabakh">Nagorno - Karabakh</option>
<option value="Namibia">Namibia</option>
<option value="Nauru">Nauru</option>
<option value="Nepal">Nepal</option>
<option value="Netherlands">Netherlands</option>
<option value="Netherlands Antilles">Netherlands Antilles</option>
<option value="New Caledonia">New Caledonia</option>
<option value="New Zealand">New Zealand</option>
<option value="Nicaragua">Nicaragua</option>
<option value="Niger">Niger</option>
<option value="Nigeria">Nigeria</option>
<option value="Niue">Niue</option>
<option value="Norfolk Island">Norfolk Island</option>
<option value="Turkish Republic of Northern Cyprus">Turkish Republic of Northern Cyprus</option>
<option value="Northern Mariana">Northern Mariana</option>
<option value="Norway">Norway</option>
<option value="Oman">Oman</option>
<option value="Pakistan">Pakistan</option>
<option value="Palau">Palau</option>
<option value="Palestine">Palestine</option>
<option value="Panama">Panama</option>
<option value="Papua New Guinea">Papua New Guinea</option>
<option value="Paraguay">Paraguay</option>
<option value="Peru">Peru</option>
<option value="Philippines">Philippines</option>
<option value="Pitcairn Islands">Pitcairn Islands</option>
<option value="Poland">Poland</option>
<option value="Portugal">Portugal</option>
<option value="Puerto Rico">Puerto Rico</option>
<option value="Qatar">Qatar</option>
<option value="Romania">Romania</option>
<option value="Russia">Russia</option>
<option value="Rwanda">Rwanda</option>
<option value="Saint Barthelemy">Saint Barthelemy</option>
<option value="Saint Helena">Saint Helena</option>
<option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
<option value="Saint Lucia">Saint Lucia</option>
<option value="Saint Martin">Saint Martin</option>
<option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
<option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
<option value="Samoa">Samoa</option>
<option value="San Marino">San Marino</option>
<option value="Sao Tome and Principe">Sao Tome and Principe</option>
<option value="Saudi Arabia">Saudi Arabia</option>
<option value="Senegal">Senegal</option>
<option value="Serbia">Serbia</option>
<option value="Seychelles">Seychelles</option>
<option value="Sierra Leone">Sierra Leone</option>
<option value="Singapore">Singapore</option>
<option value="Slovakia">Slovakia</option>
<option value="Slovenia">Slovenia</option>
<option value="Solomon Islands">Solomon Islands</option>
<option value="Somalia">Somalia</option>
<option value="Somaliland">Somaliland</option>
<option value="South Africa">South Africa</option>
<option value="South Ossetia">South Ossetia</option>
<option value="Spain">Spain</option>
<option value="Sri Lanka">Sri Lanka</option>
<option value="Sudan">Sudan</option>
<option value="Suriname">Suriname</option>
<option value="Svalbard">Svalbard</option>
<option value="Swaziland">Swaziland</option>
<option value="Sweden">Sweden</option>
<option value="Switzerland">Switzerland</option>
<option value="Syria">Syria</option>
<option value="Taiwan">Taiwan</option>
<option value="Tajikistan">Tajikistan</option>
<option value="Tanzania">Tanzania</option>
<option value="Thailand">Thailand</option>
<option value="Timor - Leste">Timor - Leste</option>
<option value="Togo">Togo</option>
<option value="Tokelau">Tokelau</option>
<option value="Tonga">Tonga</option>
<option value="Transnistria Pridnestrovie">Transnistria Pridnestrovie</option>
<option value="Trinidad and Tobago">Trinidad and Tobago</option>
<option value="Tristan da Cunha">Tristan da Cunha</option>
<option value="Tunisia">Tunisia</option>
<option value="Turkey">Turkey</option>
<option value="Turkmenistan">Turkmenistan</option>
<option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
<option value="Tuvalu">Tuvalu</option>
<option value="Uganda">Uganda</option>
<option value="Ukraine">Ukraine</option>
<option value="United Arab Emirates">United Arab Emirates</option>
<option value="United Kingdom">United Kingdom</option>
<option value="United States">United States</option>
<option value="Uruguay">Uruguay</option>
<option value="Uzbekistan">Uzbekistan</option>
<option value="Vanuatu">Vanuatu</option>
<option value="Vatican City">Vatican City</option>
<option value="Venezuela">Venezuela</option>
<option value="Vietnam">Vietnam</option>
<option value="British Virgin Islands">British Virgin Islands</option>
<option value="Isle of Man">Isle of Man</option>
<option value="US Virgin Islands">US Virgin Islands</option>
<option value="Wallis and Futuna">Wallis and Futuna</option>
<option value="Western Sahara">Western Sahara</option>
<option value="Yemen">Yemen</option>
<option value="Zambia">Zambia</option>
<option value="Zimbabwe">Zimbabwe</option>';

   return $options;
	
}
add_shortcode( 'country_options', 'display_countrylist' )


?>

