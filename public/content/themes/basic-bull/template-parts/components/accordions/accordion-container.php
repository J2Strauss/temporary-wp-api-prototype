<?php if ( have_rows('accordion_panel') ): ?>

    <div class="component accordion-component" role="presentation">

        <?php while ( have_rows('accordion_panel') ) : the_row(); ?>

            <?php get_template_part( 'template-parts/components/accordions/accordion', 'panel' ); ?>

        <?php endwhile; ?>

    </div>

<?php endif; ?>