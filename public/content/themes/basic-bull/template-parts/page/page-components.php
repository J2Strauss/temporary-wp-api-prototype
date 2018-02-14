<?php
/**
 * Template part for displaying components
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package cohere-foundation
 */

?>

<?php if( have_rows('components') ): ?>

    <div class="block block-components">

        <?php while ( have_rows('components') ) : the_row(); ?>

            <?php if( get_row_layout() == 'general' ): ?>

            	<?php get_template_part( 'template-parts/content/general', 'content' );  ?>

            <?php elseif( get_row_layout() == 'accordion_component' ):  ?>

            	<?php get_template_part( 'template-parts/components/accordions/accordion', 'container' );  ?>

            <?php elseif( get_row_layout() == 'code_component' ):  ?>

                <?php get_template_part( 'template-parts/tool/components/code', 'sample' );  ?>

            <?php endif; ?>

       <?php  endwhile; ?>

    </div>

<?php endif; ?>
