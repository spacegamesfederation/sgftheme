<?php get_header(); ?>
<div>
	<h3 style="text-align: center">Sports in Space #EqualSpace<sup style="font-size: 80%; font-family:Oswald;">™</sup><br> Where the Absence of Gravity Levels the Playing Field</h2>
</div>
	<div class="gdlr-content" id="spacegamesTV">
	
		<h1 style="margin-bottom:0px !important;">SpaceGames.TV</h1>
		<h2 style="font-size:100% !important;">More Challenging than anything on Earth</h3>
		<?php 
// Default homepage

		
	
	
			print slickVideo(); // loads vimeography playlists inside of slick
		
	?>

		<!-- Above Sidebar Section-->
		<?php global $gdlr_post_option, $above_sidebar_content, $with_sidebar_content, $below_sidebar_content; ?>
		<?php if(!empty($above_sidebar_content)){ ?>
			<div class="above-sidebar-wrapper"><?php gdlr_print_page_builder($above_sidebar_content); ?></div>
		<?php } ?>
		
		<!-- Sidebar With Content Section-->
		<?php 
			if( !empty($gdlr_post_option['sidebar']) && ($gdlr_post_option['sidebar'] != 'no-sidebar' )){
				global $gdlr_sidebar;
				
				$gdlr_sidebar = array(
					'type'=>$gdlr_post_option['sidebar'],
					'left-sidebar'=>$gdlr_post_option['left-sidebar'], 
					'right-sidebar'=>$gdlr_post_option['right-sidebar']
				); 
				$gdlr_sidebar = gdlr_get_sidebar_class($gdlr_sidebar);
		?>
			<div class="with-sidebar-wrapper gdlr-type-<?php echo esc_attr($gdlr_sidebar['type']); ?>">
				<div class="with-sidebar-container container">
					<div class="with-sidebar-left <?php echo esc_attr($gdlr_sidebar['outer']); ?> columns">
						<div class="with-sidebar-content <?php echo esc_attr($gdlr_sidebar['center']); ?> columns">
							<?php 
				 
						
							$mailchimp_url = get_post_meta( $post->ID, "mailchimp_url", true );
						?>
						
						<div class="newsletter-embed"><iframe id="newsletterframe" src="<?=@$mailchimp_url?>" allowfullscreen="allowfullscreen"><span data-mce-type="bookmark" style="display: inline-block; width: 0px; overflow: hidden; line-height: 0;" class="mce_SELRES_start"></span><span data-mce-type="bookmark" style="display: inline-block; width: 0px; overflow: hidden; line-height: 0;" class="mce_SELRES_start"></span><span data-mce-type="bookmark" style="display: inline-block; width: 0px; overflow: hidden; line-height: 0;" class="mce_SELRES_start"></span></iframe></div>
			<?php
								if( !empty($with_sidebar_content) ){
									gdlr_print_page_builder($with_sidebar_content, false);
								}
								if( !empty($gdlr_post_option['show-content']) && $gdlr_post_option['show-content'] != 'disable' ){
									get_template_part('single/content', 'page');
								}
							?>							
						</div>
						<?php get_sidebar('left'); ?>
						<div class="clear"></div>
					</div>
					<?php get_sidebar('right'); ?>
					<div class="clear"></div>
				</div>				
			</div>				
		<?php 
			}else{ 
				if( !empty($with_sidebar_content) ){ 
					echo '<div class="with-sidebar-wrapper gdlr-type-no-sidebar">';
					gdlr_print_page_builder($with_sidebar_content);
					echo '</div>';
				}
				if( empty($gdlr_post_option['show-content']) || $gdlr_post_option['show-content'] != 'disable' ){
					get_template_part('single/content', 'page');
				}
			} 
		?>

		
		<!-- Below Sidebar Section-->
		<?php if(!empty($below_sidebar_content)){ ?>
			<div class="below-sidebar-wrapper"><?php gdlr_print_page_builder($below_sidebar_content); ?></div>
		<?php } ?>

		
	</div><!-- gdlr-content -->
<?php get_footer(); ?>