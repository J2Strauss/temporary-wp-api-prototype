<?php if( get_sub_field('panel_heading') && get_sub_field('panel_content') ): ?>

    <div class="accordion-panel">

        <?php get_template_part( 'template-parts/components/accordions/panel', 'heading' ); ?>

        <?php get_template_part( 'template-parts/components/accordions/panel', 'content' ); ?>

    </div>

<?php endif; ?>
