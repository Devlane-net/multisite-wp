<?php


function add_hreflang_in_head(){

    if(is_singular('post')){
    global $post;
        $langpack_identifier = get_post_meta($post->ID, 'langpack_identifier', true);
        if(!empty($langpack_identifier)){

            // Fetch posts in langpack for the whole network
            $sites = get_sites();
            $all_posts = array();
            foreach($sites as $site){
                switch_to_blog($site->blog_id);

                // get site slug (contains the language in ISO format)
                $site_slug = str_replace( '/', '', get_blog_details()->path);

                $args = array(
                    'meta_query'        => array(
                        array(
                            'key'       => 'langpack_identifier',
                            'value'     => $langpack_identifier
                        )
                    ),
                    'post_type'         => 'post',
                    'posts_per_page'    => '-1'
                );
                $all_results = get_posts($args);
            
                foreach($all_results as $result){
                    $all_posts[] = array(
                        'site_id'   => $site->blog_id,
                        'site_slug' => $site_slug,
                        'post_id'   => $result->ID,
                        'url'       => get_permalink($result->ID)
                    );
                }


                restore_current_blog();
            }
        }

        // Add alternate links
        foreach($all_posts as $single_post){
            echo '
            <link rel="alternate" href="'.$single_post['url'].'" hreflang="'.$single_post['site_slug'].'" />';
        }

    }
}
add_action('wp_head', 'add_hreflang_in_head');