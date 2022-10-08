
<?php

function load_more_posts() { 
    $next_page = $_POST['current_page'] +1;
    $parent = $_POST['parent_group'];
    // $current_group = $_POST['current_group'];
    
    $query = new WP_Query([
        'post_type' => 'textbooks',
        'posts_per_page' => 8,
        'paged' => $next_page,
        'tax_query' => array(
              array(
                'taxonomy' => 'category',
                'terms' => $parent
                ),
            ), 
            'meta_key' => 'introduction_chapter_number',
            'meta_type' => 'NUMERIC',
            'orderby'  => 'meta_value_num',
            'order' => 'ASC'
    ]);
    
    if ($query->have_posts() ) :
        ob_start();

    while($query->have_posts() ) : $query->the_post();
        get_template_part('template-parts/tb-grid-item');

    endwhile;

    wp_send_json_success(ob_get_clean());


    else :

    wp_send_json_error('No more posts');

    endif;

}

add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');

?>