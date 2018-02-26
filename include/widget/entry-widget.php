<?php
/**
 * Plugin Name: Entries Widget
 * Author: Goodlayers
 *
 */

add_action( 'widgets_init', 'Entries_widget' );
if( !function_exists('Entries_widget') ){
	function Entries_widget() {
		register_widget( 'Entries_Widget' );
	}
}

if( !class_exists('Entries_Widget') ){
	class Entries_Widget extends WP_Widget{

		// Initialize the widget
		function __construct() {
			parent::__construct(
				'Entries-widget', 
				__('Entries Widget','gdlr_translate'), 
				array('description' => __('Contest Entries')));  
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
				
					$sql = "select ID, post_title, post_content, post_excerpt, post_date from $post_db where post_status = 'publish' and post_type = 'entry' order by post_date";
					$Entries = $wpdb->get_results($sql);
	
			
			
			?>
<form action="" method="post">
			<div id="categories-4" class="widget widget_categories gdlr-item gdlr-widget">
				<h3>Judges:</h3>
				<h4 class="gdlr-widget-title">RANK YOUR FAVORITES</h4>
<h6>Drag and Drop the order.
				Highest = Best</h6>
				<div class="clear"></div>
				<ul id="sortable">
			
					<?php 
			
				
				$counter = 1;
			foreach($Entries as $key => $Entry){
				extract((array) $Entry);
				



				?>
					<li title="<?=$post_title?>" id="label<?=$ID?>" data-id="<?=$ID?>">
						<span class="rank"></span>
						<!--<input type="radio" name="vote" value="<?=$post_title?>">-->
						
						<a href="#" onclick="setEntry(<?=$ID?>);return false;">
							<?=$post_title?>
						</a>
					</li>
					
				<?php
				//die();
					$counter++;
			}
				?>
				
				</ul>
				<p>When you are finished ranking the entries above, please submit the form below</p>
</div>

</form>
<?php echo do_shortcode('[contact-form-7 id="4763" title="Vote on #EqualSpace Challenge Entries"]') ?>
<div style="display:none">

<?php
			
		$counter = 0;
			foreach($Entries as $key => $Entry){
				extract((array) $Entry);
				$video_url = get_post_meta($ID,'challenge_video',true);
				$challengers = get_post_meta($ID,'challengers',true);
				?>
					<div id="entry<?=$ID?>">
						
							<h2><?=$post_title?></h2>
							<h4>by <?=$challengers?></h4>
						
							<h3><?=$post_excerpt?></h3>
						
								<br>
							<?php 
					
					
					
					$img = wp_get_attachment_image_src( get_post_thumbnail_id( $ID ),"full");

					if($img[0] !=""){
						
						?>
						<a href="<?=$img[0]?>" target="_blank">
						<img src="<?=$img[0]?>">
						</a>
							<?php
					}
					
					
					echo wpautop($post_content)?>
						<?php
					
					
					
					
					
					if(@$video_url != ''){
						
					?>
						<div class="videoWrapper"><iframe src="<?=$video_url?>"  allowfullscreen="allowfullscreen"></iframe></div>	
						
					
					
				<?php 
					}?>
						</div>
	<?php
			}
				?>
				
				
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

			This shows active Entries


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