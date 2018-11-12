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

		<!-- afg: removed
		<h2 class="post-title">
			...
		</h2>
		-->



		<?php
		/**********************************
		1 - Handle main wrapper config
		**********************************/

		// baseline config
		$afg_hero_classes = 'afg_hero_wrapper';
		$afg_hero_style = '';

		// read config
		$afg_hero_id 										= get_post_meta($post->ID, 'afg_hero_id', true);
		$afg_hero_background_color 			= get_post_meta($post->ID, 'afg_hero_background_color', true);
		$afg_hero_color 								= get_post_meta($post->ID, 'afg_hero_color', true);
		$afg_hero_classes_ext 					= get_post_meta($post->ID, 'afg_hero_classes_ext', true);
		$afg_hero_text_style = '';

		// append config
		if ($afg_hero_classes_ext) {
			$afg_hero_classes .= ' ' . $afg_hero_classes_ext;
		}
		if ($afg_hero_background_color != '') {
			$afg_hero_style .= 'background-color:' . $afg_hero_background_color . ';';
		}
		if ($afg_hero_color != '') {
			$afg_hero_text_style .= 'color:' . $afg_hero_color . ' !important;';
		}


		/**********************************
		2 - Handle text config
		**********************************/

		// baseline config
		$afg_hero_text_classes = 'afg_hero_text_wrapper';
		$afg_hero_text_mask_classes = '';

		// read config
		$afg_hero_title 								= get_post_meta($post->ID, 'afg_hero_title', true);
		$afg_hero_subtitle_1 						= get_post_meta($post->ID, 'afg_hero_subtitle_1', true);
		$afg_hero_subtitle_2 						= get_post_meta($post->ID, 'afg_hero_subtitle_2', true);
		$afg_hero_subtitle_3 						= get_post_meta($post->ID, 'afg_hero_subtitle_3', true);
		$afg_hero_text_classes_ext 			= get_post_meta($post->ID, 'afg_hero_text_classes_ext', true);
		$afg_hero_text_mask_classes_ext = get_post_meta($post->ID, 'afg_hero_text_mask_classes_ext', true);

		// append config
		if ($afg_hero_text_classes_ext) {
			$afg_hero_text_classes .= ' ' . $afg_hero_text_classes_ext;
		}
		if ($afg_hero_text_mask_classes_ext) {
			// mask ext is required to make this work.
			// otherwise, afg_hero_text_mask will make every header a fixed size - even when height should be initial
			$afg_hero_text_mask_classes .= 'afg_hero_text_mask ' . $afg_hero_text_mask_classes_ext;
		}


		/**********************************
		3 - Handle image config

			- image class takes precedence since it would be more optimized.
			- src will be for basic users
		**********************************/
		// baseline config - NA

		// read config
		$afg_hero_image_classes 				= get_post_meta($post->ID, 'afg_hero_image_classes', true);
		$afg_hero_image_src 						= get_post_meta($post->ID, 'afg_hero_image_src', true);

		// append config
		if ($afg_hero_image_classes) {
			// add img container to parent class
			$afg_hero_classes .= ' afg_hero_image_container';

			/* append shaded background color to text to make it pop from image */
			// TODO: add this as a parameter in custom fields
			// $afg_hero_text_classes .= ' afg_hero_text_background';
		}
		elseif ($afg_hero_image_src) {
			/* append dynamically the image url & position */
			// TODO - refactor this to fit image classes impl above

			$afg_hero_background_position = get_post_meta($post->ID, 'afg_hero_background_position', true);

			$afg_hero_style .= 'background-image: url(' . $afg_hero_image_src . ');';
			$afg_hero_style .= 'background-position:' . $afg_hero_background_position . ';';

			/* append class to control background image css attrs - cover, etc */
			$afg_hero_classes .= ' afg_hero_image_container';

			/* append shaded background color to text to make it pop from image */
			$afg_hero_text_classes .= ' afg_hero_text_background';
		}



		/**********************************
		4 - Handle CTA config
		**********************************/
		// baseline config
		$afg_hero_cta_wrapper_classes = 'afg_hero_cta_wrapper';
		$afg_hero_cta_classes = 'afg-btn afg-btn--long-text et-click';

		// read config
		$afg_hero_cta_text                = get_post_meta($post->ID, 'afg_hero_cta_text', true);
		$afg_hero_cta_href                = get_post_meta($post->ID, 'afg_hero_cta_href', true);
		$afg_hero_cta_id 									= get_post_meta($post->ID, 'afg_hero_cta_id', true);
		$afg_hero_cta_classes_ext         = get_post_meta($post->ID, 'afg_hero_cta_classes_ext', true);
		$afg_hero_cta_wrapper_classes_ext = get_post_meta($post->ID, 'afg_hero_cta_wrapper_classes_ext', true);

		// append config
		if ($afg_hero_cta_wrapper_classes_ext) {
			$afg_hero_cta_wrapper_classes .= ' ' . $afg_hero_cta_wrapper_classes_ext;
		}
		if ($afg_hero_cta_classes_ext) {
			$afg_hero_cta_classes .= ' ' . $afg_hero_cta_classes_ext;
		}



		/**********************************
		5 - Display Hero
		**********************************/
		if ($afg_hero_title || $afg_hero_image_classes || $afg_hero_image_src || $afg_hero_background_color) :
		?>

			<div class="<?php echo $afg_hero_classes;?>" id="<?php echo $afg_hero_id;?>" style="<?php echo $afg_hero_style;?>" >

				<?php if ($afg_hero_image_classes) : ?>
				<div class="<?php echo $afg_hero_image_classes;?>"></div>
				<?php endif; ?>

				<div class="<?php echo $afg_hero_text_mask_classes;?>">
				<div class="<?php echo $afg_hero_text_classes;?>">

					<h1 class="afg_hero_title" style="<?php echo $afg_hero_text_style;?>"><?php echo $afg_hero_title; ?></h1>

					<?php if ($afg_hero_subtitle_1) : ?>
						<div class="afg_hero_subtitle_1" style="<?php echo $afg_hero_text_style;?>">
							<?php echo $afg_hero_subtitle_1; ?>
						</div>
						<?php endif; ?>

					<?php if ($afg_hero_subtitle_2) : ?>
						<div class="afg_hero_subtitle_2" style="<?php echo $afg_hero_text_style;?>">
							<?php echo $afg_hero_subtitle_2; ?>
						</div>
						<?php endif; ?>

					<?php if ($afg_hero_subtitle_3) : ?>
						<div class="afg_hero_subtitle_3" style="<?php echo $afg_hero_text_style;?>">
							<?php echo $afg_hero_subtitle_3; ?>
						</div>
						<?php endif; ?>
				</div>
				</div>


				<?php if ($afg_hero_cta_text) : ?>
				<div class="<?php echo $afg_hero_cta_wrapper_classes;?>">
					<a 	class="<?php echo $afg_hero_cta_classes;?>"
							href="<?php echo $afg_hero_cta_href;?>"
							id="<?php echo $afg_hero_cta_id;?>"
					>
						<?php echo $afg_hero_cta_text;?>
					</a>
				</div>
				<?php endif; ?>

			</div>
		<?php endif;
		/* END afg CUSTOM HERO BANNER */
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
