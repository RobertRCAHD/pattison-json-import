<?php

function my_plugin_add_settings_page()
{
    add_menu_page(
        'JSON Importer Settings',       // Page title
        'JSON Importer',                // Menu title
        'manage_options',               // Capability
        'json-importer-settings',       // Menu slug
        'json_importer_settings_page',   // Callback function
        'dashicons-database-import'     // Dashicon
    );
}

add_action('admin_menu', 'my_plugin_add_settings_page');

// Define the settings page rendering
function json_importer_settings_page()
{
    global $json_importer_message;
?>
    <div class="wrap json-importer-settings">
        <h1>JSON Importer Settings</h1>
        <div>
            <p><strong>Click the button below to import the Post data from <a href="https://jsonplaceholder.org/posts" target="_blank" rel="noopener noreferrer">https://jsonplaceholder.org/posts</a>.</strong></p>
            <p>Then checkout the frontend of the site to view individual posts.</p>
            <p>This Plugin has a feature that stops Posts from being imported twice. To see it in action, click the button to run the first import, then click it again to see the Plugin handle the duplicate posts.</p>
        </div>
        <?php if (!empty($json_importer_message)) : ?>
            <div class="notice notice-success is-dismissible">
                <p><?php echo esc_html($json_importer_message); ?></p>
            </div>
        <?php endif; ?>
        <form method="post" action="">
            <?php
            wp_nonce_field('json_importer_nonce_action', 'json_importer_nonce');
            submit_button('Import JSON Data');
            ?>
        </form>
    </div>
<?php
}

// Add 'settings' link to Plugins index
function json_importer_add_settings_link($links)
{
    if (current_user_can('manage_options')) {
        $settings_link = '<a href="' . admin_url('admin.php?page=json-importer-settings') . '">Settings</a>';
        array_push($links, $settings_link);
    }

    return $links;
}
add_filter('plugin_action_links_json-importer/json-importer.php', 'json_importer_add_settings_link');

// Settings CSS
function json_importer_admin_styles()
{
    wp_enqueue_style('json-importer-css', plugin_dir_url(__FILE__) . 'css/json-importer.css');
}
add_action('admin_enqueue_scripts', 'json_importer_admin_styles');
