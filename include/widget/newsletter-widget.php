<?php
/**
 * Plugin Name: newsletters Widget
 * Plugin URI: http://goodlayers.com/
 * Description: A widget that show flickr image.
 * Version: 1.0
 * Author: Goodlayers
 * Author URI: http://www.goodlayers.com
 *
 */

add_action( 'widgets_init', 'newsletters_widget' );
if( !function_exists('newsletters_widget') ){
	function newsletters_widget() {
		register_widget( 'Newsletters_Widget' );
	}
}

if( !class_exists('Newsletters_Widget') ){
	class Newsletters_Widget extends WP_Widget{

		// Initialize the widget
		function __construct() {
			parent::__construct(
				'newsletters-widget', 
				__('newsletters Widget','gdlr_translate'), 
				array('description' => __('A widget that show image from flickr', 'gdlr_translate')));  
		}

		// Output of the widget
		function widget( $args, $instance ) {
			global $theme_option;	
				
			$title = apply_filters( 'widget_title', $instance['title'] );
			$id = $instance['id'];
			$num_fetch = $instance['num_fetch'];
			$orderby = $instance['orderby'];
			
			// Opening of widget
			echo $args['before_widget'];
			
			// Open of title tag
			if( !empty($title) ){ 
				echo $args['before_title'] . $title . $args['after_title']; 
			}
				
			// Widget Content
			
					global $wpdb;
		
		$post_db = $wpdb->prefix."posts";
	
		$sql = "select ID, post_title from $post_db where post_status = 'publish' and post_type = 'emailarchive' order by post_date desc limit 0,10";
		$newsletters = $wpdb->get_results($sql);
	
			
			
			?>
			<div id="categories-4" class="widget widget_categories gdlr-item gdlr-widget"><h3 class="gdlr-widget-title">RECENT</h3><div class="clear"></div>
				<ul>
					<?php 
			
				
				$counter = 0;
			foreach($newsletters as $key => $newsletter){
				extract((array) $newsletter);
				?>
					<li>
						<a href="#" onclick="iframeSrc('#newsletterframe','<?=get_post_meta($ID,'mailchimp_url',true)?>');return false;">
							<?=$post_title?>
						</a>
					</li>
					
				<?php 
			}
				?>
				
				</ul>
</div>
			<?php
			
					
			// Closing of widget
			echo $args['after_widget'];	
		}

		// Widget Form
		function form( $instance ) {
			$title = isset($instance['title'])? $instance['title']: '';
			$id = isset($instance['id'])? $instance['id']: '';
			$num_fetch = isset($instance['num_fetch'])? $instance['num_fetch']: 6;
			$orderby = isset($instance['orderby'])? $instance['orderby']: 'latest';
			
			?>

			This shows active newsletters


		<?php
		}
		
		// Update the widget
		function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = (empty($new_instance['title']))? '': strip_tags($new_instance['title']);
			$instance['id'] = (empty($new_instance['id']))? '': strip_tags($new_instance['id']);
			$instance['num_fetch'] = (empty($new_instance['num_fetch']))? '': strip_tags($new_instance['num_fetch']);
			$instance['orderby'] = (empty($new_instance['orderby']))? '': strip_tags($new_instance['orderby']);

			return $instance;
		}	
	}
}
?>