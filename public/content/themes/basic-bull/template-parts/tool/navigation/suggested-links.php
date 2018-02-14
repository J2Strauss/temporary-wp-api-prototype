<?php 

    $suggestedLinks = get_field('suggested_links');

    if( $suggestedLinks ): 

?>

    <div class="suggested-links large-links">

        <h6>Suggested Links:</h6>

        <div class="suggested-link-container">
        
            <?php foreach( $suggestedLinks as $post ): // variable must be called $post (IMPORTANT) ?>
                
                <?php setup_postdata( $post ); ?>
                   
                    <a href="<?php the_permalink(); ?>">

                        <span class="link-text">

                            <?php the_title(); ?>

                        </span>

                    </a>
                
            <?php endforeach; ?>
            
            <?php wp_reset_postdata(); ?>

        </div>

    </div>

<?php else : ?>

    <?php if( get_field('popular_links', 'option') ): ?>
    
        <?php $minimumPageViews = '100'; ?>

        <?php 

            $homeId = get_option('page_on_front');
            $currentPage = get_the_ID();

            $popularLinks = get_posts(array(
                'post_type'         => 'page',
                'posts_per_page'    => 6,
                'post__not_in'      => array( $homeId, $currentPage ),
                'meta_key'          => 'page_views',
                'meta_type'         => 'NUMERIC',
                'orderby'           => 'meta_value_num',
                'order'             => 'DESC',
                'meta_query'        => array (
                    array (     
                        //'relation' => 'OR',
                        'key' => 'page_views', //The field to check.
                        'value' => $minimumPageViews, //The value of the field.
                        'compare' => '>=', //Conditional statement used on the value.
                        'type' => 'NUMERIC',
                    ),  
                ),
            ));

            if( $popularLinks ): 

        ?>

            <div class="suggested-links small-links">

                <h6>Popular Links:</h6>

                <div class="suggested-link-container">
                    
                    <?php foreach( $popularLinks as $post ): ?>

                        <?php setup_postdata( $post ); ?>

                       

                            <a href="<?php the_permalink(); ?>">

                                <span class="link-text">

                                    <?php the_title(); ?>

                                </span>

                            </a>

                        
                    
                    <?php endforeach; ?>
                
                    <?php wp_reset_postdata(); ?>

                </div>

            </div>

        <?php endif; ?>

    <?php endif; ?>

<?php endif; ?>