<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Eximious_Magazine
 */

if ( ! function_exists( 'eximious_magazine_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function eximious_magazine_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		?>
        <span class="posted-on">
            <?php echo $time_string ?>
        </span>
        <?php
	}
endif;

if ( ! function_exists( 'eximious_magazine_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function eximious_magazine_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'By %s', 'post author', 'eximious-magazine' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'eximious_magazine_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
     *
     * @since 1.0.0
     *
     * @param boolean $cat
     * @param boolean $tag
     * @param boolean $comment
	 */
	function eximious_magazine_entry_footer($cat = true, $tag = true, $comment = true) {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {

		    if(true == $cat){
                $categories = wp_get_post_categories(get_the_ID());
                if(!empty($categories)){
                    ?>
                    <span class="cat-links">
                    <?php _e('Categories', 'eximious-magazine')?>
                        <?php
                        foreach($categories as $c){
                            $style = '';
                            $cat = get_category( $c );
                            $color = get_term_meta($cat->term_id, 'category_color', true);
                            if($color){
                                $style = "background-color:".esc_attr($color);
                            }
                            ?>
                            <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" style="<?php echo esc_attr($style);?>"><?php echo esc_html($cat->cat_name);?></a>
                            <?php
                        }
                    ?>
                    </span>
                    <?php
                }
            }

            if(true == $tag){
                $tags_list = get_the_tag_list( '', esc_html_x( ' ', 'list item separator', 'eximious-magazine' ) );
                if ( $tags_list ) {
                    ?>
                    <span class="tags-links">
                    <?php _e('Tags', 'eximious-magazine')?>
                    <?php echo wp_kses_post($tags_list);?>
                </span>
                    <?php
                }
            }

		}

		if(true == $comment){
            if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
                echo '<span class="comments-link">';
                comments_popup_link(
                    sprintf(
                        wp_kses(
                        /* translators: %s: post title */
                            __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'eximious-magazine' ),
                            array(
                                'span' => array(
                                    'class' => array(),
                                ),
                            )
                        ),
                        get_the_title()
                    )
                );
                echo '</span>';
            }
        }

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'eximious-magazine' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'eximious_magazine_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function eximious_magazine_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;