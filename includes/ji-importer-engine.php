<?php

function fetch_json_data_once()
{
    static $data = null;

    if ($data === null) {
        $response = wp_remote_get('https://jsonplaceholder.org/posts');
        if (is_wp_error($response)) {
            return 'Error fetching data: ' . $response->get_error_message();
        }
        $data = json_decode(wp_remote_retrieve_body($response), true);
    }

    return $data;
}

function json_importer_import_data()
{
    $posts_data = fetch_json_data_once();

    if (is_string($posts_data)) {
        return $posts_data;
    }

    if (empty($posts_data)) {
        return 'No data found or data is not in valid format.';
    }

    $skipped_posts = array();
    foreach ($posts_data as $post_data) {
        // Check if the Post with this 'id' already exists
        $existing_posts = get_posts(array(
            'meta_key' => 'original_id',
            'meta_value' => $post_data['id'],
            'post_status' => 'any',
            'post_type' => 'post'
        ));

        if (count($existing_posts) > 0) {
            // Skip duplicate Posts
            $skipped_posts[] = $post_data['id'];
            continue;
        }
        $date = date('Y-m-d H:i:s', strtotime($post_data['publishedAt']));
        $post_arr = array(
            'post_title'   => sanitize_text_field($post_data['title']),
            'post_content' => sanitize_textarea_field($post_data['content']),
            'post_status'  => 'publish',
            'post_author'  => get_current_user_id(),
            'post_date'    => $date,
            'post_date_gmt' => get_gmt_from_date($date)
        );

        $post_id = wp_insert_post($post_arr);

        if (!is_wp_error($post_id)) {
            update_post_meta($post_id, 'original_id', $post_data['id']);
            update_post_meta($post_id, 'slug', $post_data['slug']);
            update_post_meta($post_id, 'original_url', $post_data['url']);
            update_post_meta($post_id, 'image_url', $post_data['image']);
            update_post_meta($post_id, 'thumbnail_url', $post_data['thumbnail']);
            update_post_meta($post_id, 'category', $post_data['category']);
            update_post_meta($post_id, 'updated_at', $post_data['updatedAt']);
            update_post_meta($post_id, 'original_user_id', $post_data['userId']);


            // Handle category
            $category_name = $post_data['category'];
            if (!empty($category_name)) {
                $category = get_category_by_slug($category_name);
                if (!$category) {
                    $category_id = wp_create_category($category_name);
                } else {
                    $category_id = $category->term_id;
                }

                // Set the Post's category
                wp_set_post_categories($post_id, array($category_id), false);
            }
        } else {
            return 'Error inserting post: ' . $post_id->get_error_message();
        }
    }

    if (!empty($skipped_posts)) {
        return 'Import completed with some posts skipped because they were already imported (IDs: ' . implode(', ', $skipped_posts) . ').';
    }

    return 'Import completed successfully.';
}


// Handle form submission for settings page
function json_importer_handle_form_submission()
{
    global $json_importer_message;

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['json_importer_nonce']) && wp_verify_nonce($_POST['json_importer_nonce'], 'json_importer_nonce_action')) {
        $json_importer_message = json_importer_import_data();
    }
}
add_action('admin_init', 'json_importer_handle_form_submission');
