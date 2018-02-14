<?php if ( get_sub_field('code_snippet') ) : ?>

    <div class="component code-component">

        <div class="component-content">

            <?php if ( get_sub_field('code_label') ) : ?>

                <div class="code-label">

                    <h5><?php the_sub_field('code_label'); ?></h5>
                    
                </div>

            <?php endif; ?>

            <?php if ( get_sub_field('code_snippet') ) : ?>
                
                <div class="code-sample">

                    <pre><code class="<?php the_sub_field('code_syntax');?>"><?php the_sub_field('code_snippet', false); ?></code></pre>

                </div>

            <?php endif; ?>

            <?php if ( get_sub_field('code_instructions') ) : ?>

                <div class="code-instructions">

                    <?php the_sub_field('code_instructions'); ?>
                    
                </div>

            <?php endif; ?>

        </div>

    </div>

<?php endif; ?>