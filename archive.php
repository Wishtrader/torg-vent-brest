<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package torg-vent-brest
 */

get_header();
?>

	<main id="primary" class="site-main py-12">
        <div class="container mx-auto px-4 max-w-[1240px]">
            <?php if ( have_posts() ) : ?>

                <header class="page-header mb-8">
                    <?php
                    the_archive_title( '<h1 class="page-title text-3xl font-bold text-gray-800 mb-4">', '</h1>' );
                    the_archive_description( '<div class="archive-description text-gray-600">', '</div>' );
                    ?>
                </header><!-- .page-header -->

                <?php
                /* Start the Loop */
                while ( have_posts() ) :
                    the_post();

                    /*
                     * Include the Post-Type-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                     */
                    get_template_part( 'template-parts/content', get_post_type() );

                endwhile;

                the_posts_navigation();

            else :

                get_template_part( 'template-parts/content', 'none' );

            endif;
            ?>
        </div>
	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
