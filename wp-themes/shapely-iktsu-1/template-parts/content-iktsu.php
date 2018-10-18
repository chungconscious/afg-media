<?php
/**
 * Template part for displaying posts.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Shapely
 */

$dropcaps    = get_theme_mod( 'first_letter_caps', true );
$enable_tags = get_theme_mod( 'tags_post_meta', true );
$post_author = get_theme_mod( 'post_author_area', true );
$left_side   = get_theme_mod( 'post_author_left_side', false );
$post_title  = get_theme_mod( 'title_above_post', true );
$post_category  = get_theme_mod( 'post_category', true );

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-content post-grid-wide' ); ?>>
	<header class="entry-header nolist">
		<?php
		$category = get_the_category();
		if ( has_post_thumbnail() ) {
			$layout = shapely_get_layout_class();
			$size   = 'shapely-featured';

			if ( 'full-width' == $layout ) {
				$size = 'shapely-full';
			}
			$image = get_the_post_thumbnail( get_the_ID(), $size );

			$allowed_tags = array(
				'img'      => array(
					'data-srcset' => true,
					'data-src'    => true,
					'srcset'      => true,
					'sizes'       => true,
					'src'         => true,
					'class'       => true,
					'alt'         => true,
					'width'       => true,
					'height'      => true,
				),
				'noscript' => array(),
			);
		?>
		<a href="<?php echo esc_url( get_the_permalink() ); ?>">
			<?php echo wp_kses( $image, $allowed_tags ); ?>
		</a>

		<?php if ( isset( $category[0] ) && $post_category ) : ?>
			<span class="shapely-category">
				<a href="<?php echo esc_url( get_category_link( $category[0]->term_id ) ); ?>">
					<?php echo esc_html( $category[0]->name ); ?>
				</a>
			</span>
		<?php endif; ?>
		<?php }// End if().
	?>
	</header><!-- .entry-header -->
	<div class="entry-content">

		<!-- iktsu: removed	
		<h2 class="post-title">
			...
		</h2>		
		-->
		

				
		<?php  
		/* IKTSU CUSTOM HERO BANNER */
		$iktsu_hero_background_color = get_post_meta($post->ID, 'iktsu_hero_background_color', true);
		$iktsu_hero_color = get_post_meta($post->ID, 'iktsu_hero_color', true);
		$iktsu_hero_title = get_post_meta($post->ID, 'iktsu_hero_title', true);
		$iktsu_hero_subtitle_1 = get_post_meta($post->ID, 'iktsu_hero_subtitle_1', true);
		$iktsu_hero_subtitle_2 = get_post_meta($post->ID, 'iktsu_hero_subtitle_2', true);				
		$iktsu_hero_subtitle_3 = get_post_meta($post->ID, 'iktsu_hero_subtitle_3', true);				

		// Deprecate get_post_meta method. Use Advance Custom Fields since it's a less brittle solution than copying/pasting
		// a URL (user can instead pick a file).
		// $iktsu_hero_image_src = get_post_meta($post->ID, 'iktsu_hero_image_src', true);										
		if( get_field('iktsu_hero_image_src') ):
			$iktsu_hero_image_src = get_field('iktsu_hero_image_src');
		endif;
																				
		/* SET HERO STYLE */
		$iktsu_hero_style = '';		// init
		
		// append bg color if set
		if ($iktsu_hero_background_color != '') : 
			$iktsu_hero_style .= 'background-color:' . $iktsu_hero_background_color . ';';
		endif;
		
		// append text color if set
		if ($iktsu_hero_color != '') : 			
			$iktsu_hero_style .= 'color:' . $iktsu_hero_color . ';';
		endif;		
			
		/* GET IMAGE SRC */
		// base classes
		$iktsu_hero_classes = 'iktsu_hero_wrapper';
		$iktsu_hero_text_classes = 'iktsu_hero_text_wrapper';
					
		if ($iktsu_hero_image_src) :
			/* append dynamically the image url & position */
			$iktsu_hero_style .= 'background-image: url(' . $iktsu_hero_image_src . ');';
			$iktsu_hero_style .= 'background-position:' . get_field('iktsu_hero_background_position') . ';';
			

			/* append class to control background image css attrs - cover, etc */
			$iktsu_hero_classes .= ' iktsu_hero_image_container';
			
			/* append shaded background color to text to make it pop from image */
			$iktsu_hero_text_classes .= ' iktsu_hero_text_background';
		endif;


		/* DISPLAY HERO */	
		if ($iktsu_hero_title || $iktsu_hero_image_src || $iktsu_hero_background_color) : 
		?>
					
			<div class="<?php echo $iktsu_hero_classes;?>" style="<?php echo $iktsu_hero_style;?>" >
				<div class="<?php echo $iktsu_hero_text_classes;?>">
					
					<div class="iktsu_hero_title"><?php echo $iktsu_hero_title; ?></div>
				
					<?php if ($iktsu_hero_subtitle_1) : ?>									
						<div class="iktsu_hero_subtitle_1">
							<?php echo $iktsu_hero_subtitle_1; ?>
						</div>			
						<?php endif; ?>
	
					<?php if ($iktsu_hero_subtitle_2) : ?>									
						<div class="iktsu_hero_subtitle_2">
							<?php echo $iktsu_hero_subtitle_2; ?>
						</div>			
						<?php endif; ?>
	
					<?php if ($iktsu_hero_subtitle_3) : ?>									
						<div class="iktsu_hero_subtitle_3">
							<?php echo $iktsu_hero_subtitle_3; ?>
						</div>			
						<?php endif; ?>			
				</div>		
			</div>			
		<?php endif; 
		/* END IKTSU CUSTOM HERO BANNER */
		?>





				
		<div class="entry-meta">
			<?php
			shapely_posted_on_no_cat(); ?><!-- post-meta -->
		</div>

		<?php if ( $post_author && $left_side ) : ?>
			<div class="row">
				<div class="col-md-3 col-xs-12 author-bio-left-side">
					<?php
					shapely_author_bio();
					?>
				</div>
				<div class="col-md-9 col-xs-12 shapely-content <?php echo $dropcaps ? 'dropcaps-content' : ''; ?>">
					<?php
					the_content();

					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'shapely' ),
						'after'  => '</div>',
					) );
					?>
				</div>
			</div>
		<?php else : ?>
			<div class="shapely-content <?php echo $dropcaps ? 'dropcaps-content' : ''; ?>">
				<?php
				the_content();

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'shapely' ),
					'after'  => '</div>',
				) );
				?>
			</div>
		<?php endif; ?>
	</div><!-- .entry-content -->

	<?php
	if ( is_single() ) :
		$prev = get_previous_post_link();
		$prev = str_replace( '&laquo;', '<div class="wrapper"><span class="fa fa-angle-left"></span>', $prev );
		$prev = str_replace( '</a>', '</a></div>', $prev );
		$next = get_next_post_link();
		$next = str_replace( '&raquo;', '<span class="fa fa-angle-right"></span></div>', $next );
		$next = str_replace( '<a', '<div class="wrapper"><a', $next );
		?>
		<div class="shapely-next-prev row">
			<div class="col-md-6 text-left">
				<?php echo wp_kses_post( $prev ) ?>
			</div>
			<div class="col-md-6 text-right">
				<?php echo wp_kses_post( $next ) ?>
			</div>
		</div>

		<?php
		if ( $post_author && ! $left_side ) :
			shapely_author_bio();
		endif;

		if ( $enable_tags ) :
			$tags_list = get_the_tag_list( '', ' ' );
			echo ! empty( $tags_list ) ? '<div class="shapely-tags"><span class="fa fa-tags"></span>' . $tags_list . '</div>' : '';
		endif;
		?>

		<?php do_action( 'shapely_single_after_article' ); ?>
	<?php endif; ?>
</article>
