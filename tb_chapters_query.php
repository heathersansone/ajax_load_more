 <?php
    $parts = get_sub_field( 'chapter_parent' );  
    

    foreach ( (array) $parts as $part ) {
        
        setup_postdata($part); 

        $part_query = new WP_Query( array(
            'post_type' => 'textbooks',
            'posts_per_page' => 8,
            
            'tax_query' => array(
              array(
                'taxonomy' => 'category',
                'terms' => $parts
                ),
            ), 
            'meta_key' => 'introduction_chapter_number',
            'meta_type' => 'NUMERIC',
            'orderby'  => 'meta_value_num',
            'orderby' => 'menu_order',
            'order' => 'ASC'
        ) );

            if ( $part_query->have_posts() ) : ?>

                <?php $paged = get_query_var( 'paged', 1 ); ?>
                 <div id="gallery-works" class="w-full ca-wrapper-grid">
                    <div id="tb-gallery-<?php echo($parts); ?>" class="textbook-grid"
                        data-page="1" 
                        data-max="<?php echo $part_query->max_num_pages; ?>"
                    >


               <?php while ( $part_query->have_posts() ) : $part_query->the_post(); ?>
                        <?php if( have_rows('introduction') ): ?>
                            <?php while( have_rows('introduction') ): the_row(); ?>
                               <div class="textbook-grid-item">
                                    <a class="box-shadow hover-connect" href="<?php the_permalink(); ?>">
                                        <?php
                                        $img_exists = has_post_thumbnail(get_the_ID());
                                        if ($img_exists) {
                                            $id = get_post_thumbnail_id(get_the_ID());
                                            echo '<img class="mx-a" ' . awesome_acf_responsive_image($id,'tb-grid','570px') . ' alt="' . get_the_title(get_the_ID()) . '" />';
                                        } else {
                            
                                            printf('<img class="mx-a" src="%s" alt="Smarthistory">', get_stylesheet_directory_uri() . '/assets/images/sh-placeholder.png');
                                        }
                                        ?>
                                    </a>
                                    <h5 class="chapter-title hover-connect">
                                        <a class="work-title-link chapter-title" href="<?php the_permalink(); ?>">
                                            <h6 class="chapter-number gallery-extra-margin">Chapter <?php the_sub_field('chapter_number'); ?></h6>
                                            <?php the_title(); ?></a>
                                    </h5>
                                </div> <!-- end textbook-grid-item -->
                            <?php endwhile; ?>
                        <?php endif; ?>
                    
                <?php endwhile;  ?>
                  </div> <!-- end tb-gallery -->
                  <div class="gallery-gradient"></div>
                </div> <!-- end gallery-works -->
            <?php endif; ?> 
                <div id="lm-line" class="lm-commons-line mt-10 border-b-2 text-centered pb-3px border-grey-light text-normal">
                       <a id="commons-lm-<?php echo($parts); ?>"  data-value="<?php echo($parts); ?>" class="lm-commons-text text-red focus:text-red hover:text-grey hover:no-border inline-block font-medium uppercase pb-1 pt-0 px-10 relative">Load all Chapters in Part <?php the_sub_field('part_number'); ?></a>
                </div>

        
                
    <?php  wp_reset_postdata(); ?>
        
<?php } ?>
