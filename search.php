<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package torg-vent-brest
 */

get_header();
?>

	<main id="primary" class="site-main py-12">
        <div class="container mx-auto px-4 max-w-[1240px]">
            <?php if ( have_posts() ) : ?>

                <header class="page-header mb-8">
                    <h1 class="page-title text-3xl font-bold text-gray-800 mb-6 border-b border-gray-200 pb-4">
                        <?php
                        /* translators: %s: search query. */
                        printf( esc_html__( 'Результаты поиска: %s', 'torg-vent-brest' ), '<span class="text-primary">' . get_search_query() . '</span>' );
                        ?>
                    </h1>
                </header><!-- .page-header -->

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php
                    /* Start the Loop */
                    while ( have_posts() ) :
                        the_post();

                        /**
                         * Run the loop for the search to output the results.
                         * If you want to overload this in a child theme then include a file
                         * called content-search.php and that will be used instead.
                         */
                        get_template_part( 'template-parts/content', 'search' );

                    endwhile;
                    ?>
                </div>

                <?php
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
