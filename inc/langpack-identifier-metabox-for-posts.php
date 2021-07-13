<?php

function metaboxes_for_normal_posts(){

    add_meta_box(
        'langpack_identifier',          // Id
        'Langpack',                     // Title
        'metabox_langpack_identifier',  // Callback
        'post',                         // CPT
        'side',                         // Where
        'default'                       // Load priority
    );

}
add_action('add_meta_boxes', 'metaboxes_for_normal_posts');


// Render langpack metabox
function metabox_langpack_identifier(){
    global $post;

    // Get current value
    $langpack_identifier = get_post_meta($post->ID, 'langpack_identifier', true);

    // Create nonce
    wp_nonce_field(basename( __FILE__ ), 'nonce_langpack_identifier');

    echo '
    <p><input name="langpack_identifier" value="'.esc_attr($langpack_identifier).'" type="text"></p>';

}


// Save metaboxes values
function save_metaboxes_values($post_id, $post){
    
    // Return if autosave
    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
        return $post_id;
    }
    
    // Return if not allowed
    if(!current_user_can('edit_post', $post_id)){
        return $post_id;
    }
    
    // Langpack identifier
    if( isset( $_POST['langpack_identifier'] ) and wp_verify_nonce( $_POST['nonce_langpack_identifier'], basename(__FILE__) ) ){
        
        $langpack_identifier = sanitize_text_field($_POST['langpack_identifier']);

        if(strlen($langpack_identifier) == 0){
            delete_post_meta($post_id, 'langpack_identifier');
        }else{
            update_post_meta($post_id, 'langpack_identifier', $langpack_identifier);
        }

    }else{
        update_post_meta($post_id, 'langpack_identifier', $_POST['langpack_identifier'].'NO-NONCE');
    }

    return $post_id;
}
add_action('save_post', 'save_metaboxes_values', 1, 2);