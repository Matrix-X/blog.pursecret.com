<?php
/**
 * Displays primary navigation
 *
 * @package Clean_Portfolio
 */

?>
<div id="site-header-menu" class="site-header-menu">

	<div id="primary-menu-wrapper" class="menu-wrapper">
		<div class="menu-toggle-wrapper"><button id="primary-menu-toggle"  class="menu-toggle" aria-controls="top-menu" aria-expanded="false"><?php echo cleanportfolio_get_svg( array( 'icon' => 'bars' ) ); echo cleanportfolio_get_svg( array( 'icon' => 'close' ) ); ?><span class="menu-label"><?php echo esc_html_e( 'Menu', 'cleanportfolio' ); ?></span></button></div><!-- .menu-toggle-wrapper -->

		<div class="menu-inside-wrapper">
			<?php if ( has_nav_menu( 'menu-1' ) ) : ?>

				<nav id="site-navigation" class="main-navigation custom-primary-menu" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'cleanportfolio' ); ?>">
					<?php
						wp_nav_menu( array(
							'theme_location' => 'menu-1',
							'menu_class'     => 'primary-menu',
						 ) );
					?>
				</nav><!-- .main-navigation -->

			<?php else : ?>

				<nav id="site-navigation" class="main-navigation default-page-menu" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'cleanportfolio' ); ?>">
					<?php wp_page_menu(
						array(
							'menu_class' => 'primary-menu-container',
							'before'     => '<ul id="menu-primary-items" class="primary-menu">',
							'after'      => '</ul>'
						)
					); ?>
				</nav><!-- .main-navigation -->

			<?php endif; ?>

			<div class="mobile-social-search">
				<nav id="social-navigation" class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Social Links Menu', 'cleanportfolio' ); ?>">

					<div class="search-container">
						<?php get_Search_form(); ?>
					</div>

					<?php if ( has_nav_menu( 'social-menu' ) ) :  ?>
						<?php
							wp_nav_menu( array(
								'theme_location' 	=> 'social-menu',
								'menu_class'     	=> 'social-links-menu',
								'container'			=> 'div',
								'container_class'	=> 'menu-social-container',
								'depth'          	=> 1,
								'link_before'    	=> '<span class="screen-reader-text">',
								'link_after'     	=> '</span>' . cleanportfolio_get_svg( array( 'icon' => 'chain' ) ),
							) );
						?>
					<?php endif; ?>
				</nav><!-- .social-navigation -->
			</div><!-- .mobile-social-search -->

		</div><!-- .menu-inside-wrapper -->

	</div><!-- .menu-wrapper -->

	<div id="social-search-wrapper" class="menu-wrapper">

		<?php if ( has_nav_menu( 'social-menu' ) ) :  ?>
			<nav class="social-navigation social-top" role="navigation" aria-label="<?php _e( 'Social Menu', 'cleanportfolio' ); ?>">
				<?php
					wp_nav_menu( array(
						'theme_location' 	=> 'social-menu',
						'menu_class'     	=> 'social-links-menu',
						'container'			=> 'div',
						'container_class'	=> 'menu-social-container',
						'depth'          	=> 1,
						'link_before'    	=> '<span class="screen-reader-text">',
						'link_after'     	=> '</span>' . cleanportfolio_get_svg( array( 'icon' => 'chain' ) ),
					) );
				?>
			</nav><!-- .social-navigation -->
		<?php endif; ?>

		<div class="menu-toggle-wrapper"><button id="social-search-toggle" class="menu-toggle"><?php echo cleanportfolio_get_svg( array( 'icon' => 'search' ) ); echo cleanportfolio_get_svg( array( 'icon' => 'close' ) ); ?><span class="screen-reader-text"><?php esc_html_e( 'Search', 'cleanportfolio' ); ?></span></button></div><!-- .menu-toggle-wrapper -->

		<div class="menu-inside-wrapper">


			<nav id="social-navigation" class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Social Links Menu', 'cleanportfolio' ); ?>">

				<div class="search-container">
					<?php get_Search_form(); ?>
				</div>

				<?php if ( has_nav_menu( 'social-menu' ) ) :  ?>
					<nav class="social-navigation" role="navigation" aria-label="<?php _e( 'Social Menu', 'cleanportfolio' ); ?>">
						<?php
							wp_nav_menu( array(
								'theme_location' 	=> 'social-menu',
								'menu_class'     	=> 'social-links-menu',
								'container'			=> 'div',
								'container_class'	=> 'menu-social-container',
								'depth'          	=> 1,
								'link_before'    	=> '<span class="screen-reader-text">',
								'link_after'     	=> '</span>' . cleanportfolio_get_svg( array( 'icon' => 'chain' ) ),
							) );
						?>
					</nav><!-- .social-navigation -->
				<?php endif; ?>
			</nav><!-- .social-navigation -->


  		</div><!-- .menu-inside-wrapper -->

  	</div><!-- .menu-wrapper -->

</div><!-- .site-header-menu -->
