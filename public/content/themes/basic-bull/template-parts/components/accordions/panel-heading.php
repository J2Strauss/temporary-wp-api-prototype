<?php if ( get_sub_field('panel_heading') ): ?>

    <div class="panel-heading" role="heading">

        <button aria-expanded="true" aria-controls="PANEL-CONTENT-ID">

            <?php the_sub_field('panel_heading'); ?>

            <i class="icon icon-plus-minus"></i>
            
        </button>

    </div>

<?php endif; ?>