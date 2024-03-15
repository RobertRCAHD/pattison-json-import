<?php

/**
 * Appends the CTA to individual/single Posts
 */

function json_importer_enqueue_scripts()
{
    // Enqueue Bootstrap 5
    wp_enqueue_style(
        'bootstrap-css',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css',
        array(),
        '5.0.2',
        'all',
        array('integrity' => 'sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC', 'crossorigin' => 'anonymous')
    );
    wp_enqueue_script(
        'bootstrap-js',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js',
        array(),
        '5.0.2',
        true,
        array('integrity' => 'sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM', 'crossorigin' => 'anonymous')
    );
    wp_enqueue_style('json-importer-css', plugin_dir_url(__FILE__) . 'css/json-importer.css');
}
add_action('wp_enqueue_scripts', 'json_importer_enqueue_scripts');


function append_cta($content)
{
    if (is_single()) {
        $plugin_dir_path = str_replace('\\', '/', plugin_dir_path(__FILE__));
        $html_file = $plugin_dir_path . 'html/ji-cta.html';

        if (file_exists($html_file)) {
            $htmlContent = file_get_contents($html_file);
            $content .= $htmlContent;
        } else {
            $content .= '<p>Error: The CTA was unable to load. Please contact the Plugin developer.</p>';
        }
    }
    return $content;
}
add_filter('the_content', 'append_cta');
