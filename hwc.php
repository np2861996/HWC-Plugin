<?php
/*
Plugin Name: HWC
Plugin URI: https://hwcthemeplugin.com/
Description: A simple WordPress plugin for HWC functionality.
Version: 1.0
Author: HWC Theme Plugin
Author URI: https://example.com
License: GPL2
*/

// Prevent direct access to the file
if (! defined('ABSPATH')) {
    exit;
}

/*--------------------------------------------------------------
	>>> All Action and Filter Functions
----------------------------------------------------------------*/
register_activation_hook(__FILE__, 'hwc_plugin_activation');
register_activation_hook(__FILE__, 'hwc_plugin_activate');
add_action('admin_notices', 'hwc_plugin_activation_notice');
add_action('init', 'hwc_register_custom_post_types');
add_action('acf/init', 'hwc_setup_acf_fields_for_pages');
add_action('acf/init', 'hwc_set_default_acf_field_values');
add_action('acf/init', 'hwc_add_acf_fields');
add_action('acf/init', 'hwc_populate_default_data');


/*--------------------------------------------------------------
	>>> Show admin notice only after plugin activation
----------------------------------------------------------------*/
function hwc_plugin_activation_notice()
{
    // Check if the transient is set
    if (get_transient('hwc_plugin_activated')) {
        echo '<div class="notice notice-success is-dismissible">
            <p>HWC Plugin activated successfully!</p>
        </div>';

        // Delete the transient so it doesn't show again
        delete_transient('hwc_plugin_activated');
    }
}
// Set transient on plugin activation
function hwc_plugin_activate()
{
    // Set a transient that expires after 60 seconds
    set_transient('hwc_plugin_activated', true, 60);
}

/*--------------------------------------------------------------
	>>> Define the main activation function that will handle the activation logic.
----------------------------------------------------------------*/
function hwc_plugin_activation()
{
    hwc_plugin_activation_pages_setup();
    hwc_plugin_check_acf_pro_before_activation();  // Check if ACF Pro is installed.
    hwc_create_categories_and_manual_posts();
    hwc_populate_default_team_data();
    flush_rewrite_rules();
}

/*--------------------------------------------------------------
	>>> Include Function for create dummy posts from files
----------------------------------------------------------------*/
require_once plugin_dir_path(__FILE__) . 'inc/hwc-posts/categories_and_manual_posts.php';
require_once plugin_dir_path(__FILE__) . '/inc/hwc-players/hwc-players.php';
require_once plugin_dir_path(__FILE__) . '/inc/hwc-teams/hwc-teams.php';
require_once plugin_dir_path(__FILE__) . '/inc/hwc-staff/hwc-staff.php';
require_once plugin_dir_path(__FILE__) . '/inc/hwc-matches/hwc-matches.php';
require_once plugin_dir_path(__FILE__) . '/inc/hwc-results/hwc-results.php';


// Helper function to get page ID by title
function get_page_id_by_title($title)
{
    $query = new WP_Query(array(
        'post_type' => 'page',
        'post_status' => 'publish',
        'title' => $title,
        'fields' => 'ids',
    ));
    return $query->posts ? $query->posts[0] : null;
}


/*--------------------------------------------------------------
	>>> Hook into 'after_switch_theme' to run the check when the theme is activated
	----------------------------------------------------------------*/
function hwc_create_page_with_template($title, $template_path, $slug)
{
    // Check if the page already exists
    $page = get_page_by_path($slug);

    if (!$page) {
        // Create the page
        $page_id = wp_insert_post(array(
            'post_title'    => $title,
            'post_name'     => $slug,
            'post_content'  => '',
            'post_status'   => 'publish',
            'post_type'     => 'page',
        ));

        // Set the page template if the page was created successfully
        if ($page_id) {
            update_post_meta($page_id, '_wp_page_template', $template_path);
            return $page_id; // Return the ID of the newly created page
        }
    } else {
        // Optionally update the page template if it doesn't match the current template
        $current_template = get_post_meta($page->ID, '_wp_page_template', true);
        if ($current_template !== $template_path) {
            update_post_meta($page->ID, '_wp_page_template', $template_path);
        }
        return $page->ID; // Return the ID of the existing page
    }

    return 0; // Return 0 if the page wasn't created or found
}


/*--------------------------------------------------------------
	>>> Hook into 'after_switch_theme' to run the check when the theme is activated
	----------------------------------------------------------------*/
function hwc_plugin_activation_pages_setup()
{

    if (!is_acf_pro_plugin_installed()) {
        // Return back if ACF Pro is not available
        return;
    }

    // Define an array of pages to create with their templates and slugs
    $pages = array(
        array(
            'title'     => 'Home',
            'template'  => 'template-parts/template-home.php',
            'slug'      => 'home'
        ),
        array(
            'title'     => 'News',
            'template'  => 'template-parts/template-news.php',
            'slug'      => 'news'
        ),
        array(
            'title'     => 'Team',
            'template'  => 'template-parts/template-team.php',
            'slug'      => 'team'
        ),
        array(
            'title'     => 'Matches',
            'template'  => 'template-parts/template-matches.php',
            'slug'      => 'matches'
        ),
        array(
            'title'     => 'Club',
            'template'  => 'template-parts/template-club.php',
            'slug'      => 'club'
        ),
        array(
            'title'     => 'Community',
            'template'  => 'template-parts/template-community.php',
            'slug'      => 'community'
        ),
        array(
            'title'     => 'Academy',
            'template'  => 'template-parts/template-academy.php',
            'slug'      => 'academy'
        ),
        array(
            'title'     => 'Video',
            'template'  => 'template-parts/template-video.php',
            'slug'      => 'video'
        ),
        array(
            'title'     => 'Accessibility',
            'template'  => 'template-parts/template-accessibility.php',
            'slug'      => 'accessibility'
        ),
        array(
            'title'     => 'Commercial',
            'template'  => 'template-parts/template-commercial.php',
            'slug'      => 'commercial'
        )
    );

    // Create pages and set their templates
    $home_page_id = 0; // Initialize variable to store Home page ID

    foreach ($pages as $page) {
        $page_id = hwc_create_page_with_template($page['title'], $page['template'], $page['slug']);

        // Store Home page ID
        if ($page['slug'] === 'home') {
            $home_page_id = $page_id;
        }
    }

    // Set Home page as the front page
    if ($home_page_id) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $home_page_id);
    }
}

/*--------------------------------------------------------------
	>>> Hook into 'after_switch_theme' to run the check when the theme is activated
	----------------------------------------------------------------*/
function hwc_plugin_check_acf_pro_before_activation()
{

    include_once(ABSPATH . 'wp-admin/includes/plugin.php');

    // Check if ACF Pro is installed
    if (!is_acf_pro_plugin_installed()) {
        // Show error if ACF Pro is not available
        add_action('admin_notices', 'acf_pro_plugin_missing_error');
        switch_theme(WP_DEFAULT_THEME); // Revert to the default theme if ACF Pro is not installed
        return;
    }

    // Check if ACF Pro is installed but inactive
    if (!is_plugin_active('advanced-custom-fields-pro/acf.php')) {
        // Activate ACF Pro if installed but not active
        activate_plugin('advanced-custom-fields-pro/acf.php');
    }

    // Ensure ACF content remains unchanged (ACF data is saved in the database, so this happens automatically)
}

function is_acf_pro_plugin_installed()
{
    // Check if ACF Pro is installed by looking at the plugin directory
    $acf_pro_plugin_path = WP_PLUGIN_DIR . '/advanced-custom-fields-pro/acf.php';
    return file_exists($acf_pro_plugin_path);
}


// Admin notice to show when ACF Pro is missing
function acf_pro_plugin_missing_error()
{
?>
    <div class="error notice">
        <p><?php _e('Error: ACF Pro is required to use this theme. Please install and activate ACF Pro.', 'hwc'); ?></p>
    </div>
<?php
}

/*--------------------------------------------------------------
	>>> Hook into theme activation Register Custom Post Types
	----------------------------------------------------------------*/
function hwc_register_custom_post_types()
{

    // League Table
    register_post_type('league_table', array(
        'labels' => array(
            'name' => 'League Tables',
            'singular_name' => 'League Table',
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
    ));
}


/*--------------------------------------------------------------
	>>> Function to set up ACF fields for each page
	----------------------------------------------------------------*/
function hwc_setup_acf_fields_for_pages()
{
    if (function_exists('acf_add_local_field_group')) {

        // Define field groups for each page
        $field_groups = array(
            'Home' => array(
                'key' => 'group_home',
                'title' => 'Home Page Fields',
                'fields' => array(
                    array(
                        'key' => 'home_title1',
                        'label' => 'Title 1',
                        'name' => 'home_title1',
                        'type' => 'text',
                        'instructions' => 'Enter the main title for the Home page.',
                    ),
                    array(
                        'key' => 'home_image1',
                        'label' => 'Image 1',
                        'name' => 'home_image1',
                        'type' => 'image',
                        'instructions' => 'Upload an image for the Home page.',
                    ),
                    array(
                        'key' => 'home_description',
                        'label' => 'Description',
                        'name' => 'home_description',
                        'type' => 'textarea',
                        'instructions' => 'Enter the description for the Home page.',
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'post',
                            'operator' => '==',
                            'value' => get_page_id_by_title('Home'),
                        ),
                    ),
                ),
            ),
            'News' => array(
                'key' => 'group_news',
                'title' => 'News Page Fields',
                'fields' => array(
                    array(
                        'key' => 'news_title',
                        'label' => 'News Title',
                        'name' => 'news_title',
                        'type' => 'text',
                        'instructions' => 'Enter the title for the News page.',
                    ),
                    array(
                        'key' => 'news_image',
                        'label' => 'News Image',
                        'name' => 'news_image',
                        'type' => 'image',
                        'instructions' => 'Upload an image for the News page.',
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'post',
                            'operator' => '==',
                            'value' => get_page_id_by_title('News'),
                        ),
                    ),
                ),
            ),
            // Define more field groups for other pages similarly...
        );

        foreach ($field_groups as $page_title => $field_group) {
            $page_id = get_page_id_by_title($page_title);
            if ($page_id) {
                acf_add_local_field_group($field_group);
            }
        }
    }
}

/*--------------------------------------------------------------
	>>> Function for upload image from theme
	----------------------------------------------------------------*/
function upload_image_to_acf_field($image_url, $post_id, $acf_field_name)
{
    // Ensure the image URL is valid
    if (empty($image_url)) {
        return false;
    }

    // Temporary filename for the image
    $tmp = download_url($image_url);

    // Check for errors
    if (is_wp_error($tmp)) {
        return false;
    }

    // Prepare an array for the attachment
    $file_array = array(
        'name' => basename($image_url), // Get the image name
        'tmp_name' => $tmp // Path to the temporary file
    );

    // Handle file upload
    $attachment_id = media_handle_sideload($file_array, $post_id);

    // Check for upload errors
    if (is_wp_error($attachment_id)) {
        @unlink($file_array['tmp_name']); // Clean up
        return false;
    }

    // Update ACF field with the attachment ID
    update_field($acf_field_name, $attachment_id, $post_id);

    return $attachment_id;
}


/*--------------------------------------------------------------
	>>> Function to set default values in ACF fields for each page
	----------------------------------------------------------------*/
function hwc_set_default_acf_field_values()
{
    // Check if default values have already been set
    if (get_option('acf_defaults_set')) {
        return; // Exit if defaults have already been set
    }

    $page_fields = array(
        'Home' => array(
            'home_title1' => 'Welcome to Our Website',
            //'home_image1' => 'wp-img.png', // Store image filename
            'home_description' => 'Welcome to the home page of our website. We provide the best services in the industry.',
        ),

        'News' => array(
            'news_title' => 'Latest News',
            // 'news_image' => 'wp-img.png', // Store image filename
        ),
        // Add other pages and fields here as needed...
    );

    foreach ($page_fields as $page_title => $fields) {
        // Use WP_Query to get the page by title
        $query = new WP_Query(array(
            'post_type' => 'page',
            'title'     => $page_title,
            'posts_per_page' => 1,
        ));

        if ($query->have_posts()) {
            $page_id = $query->post->ID;

            foreach ($fields as $field_key => $default_value) {
                if (strpos($field_key, 'image') !== false) {
                    $attachment_id = hwc_upload_image_from_theme($default_value);

                    if (is_wp_error($attachment_id)) {
                        error_log("Error with image field '$field_key': " . $attachment_id->get_error_message());
                    } else {
                        // Update image field with attachment ID
                        update_field($field_key, $attachment_id, $page_id);
                    }
                } else {
                    $current_value = get_field($field_key, $page_id);

                    // Update the field only if it's empty or unset
                    if (empty($current_value)) {
                        update_field($field_key, $default_value, $page_id);
                    }
                }
            }
        } else {
            error_log("Page '$page_title' not found.");
        }
    }

    // Set an option to indicate that defaults have been set
    update_option('acf_defaults_set', true);
}

/*--------------------------------------------------------------
	>>> Function to add dummy Content
	----------------------------------------------------------------*/
function hwc_create_image_from_plugin($filename, $post_id)
{
    // Define the paths
    $plugin_dir_url = plugin_dir_url(__FILE__);
    $plugin_images_dir = $plugin_dir_url . 'hwc-images/';
    $plugin_images_path = plugin_dir_path(__FILE__) . 'hwc-images/';

    // Construct the full image URL and file path
    $image_url = $plugin_images_dir . $filename;
    $file_path = $plugin_images_path . $filename;

    // Check if the file exists in the plugin directory
    if (!file_exists($file_path)) {
        return new WP_Error('image_not_found', __('Image file not found in plugin directory.'));
    }

    // Get the upload directory
    $upload_dir = wp_upload_dir();
    $new_file_path = $upload_dir['path'] . '/' . $filename;

    // Copy the file from the plugin directory to the uploads directory
    if (!copy($file_path, $new_file_path)) {
        return new WP_Error('file_copy_failed', __('Failed to copy image to uploads directory.'));
    }

    // Check the file type of the image
    $wp_filetype = wp_check_filetype($filename, null);

    // Prepare an array of post data for the attachment
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title'     => sanitize_file_name($filename),
        'post_content'   => '',
        'post_status'    => 'inherit'
    );

    // Insert the attachment into the WordPress media library
    $attach_id = wp_insert_attachment($attachment, $new_file_path, $post_id);

    // Include image.php to use wp_generate_attachment_metadata
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    // Generate metadata for the attachment
    $attach_data = wp_generate_attachment_metadata($attach_id, $new_file_path);

    // Update the attachment metadata
    wp_update_attachment_metadata($attach_id, $attach_data);

    // Return the attachment ID
    return $attach_id;
}



/*--------------------------------------------------------------
	>>> Function for Add ACF Fields
	----------------------------------------------------------------*/
function hwc_add_acf_fields()
{
    if (class_exists('ACF')) {

        // League Table ACF Fields
        if (function_exists('acf_add_local_field_group')):
            acf_add_local_field_group(array(
                'key' => 'group_league_table',
                'title' => 'League Table Details',
                'fields' => array(
                    array(
                        'key' => 'field_tournament',
                        'label' => 'Tournament',
                        'name' => 'tournament',
                        'type' => 'text',
                        'default_value' => 'Default Tournament',
                    ),
                    array(
                        'key' => 'field_position',
                        'label' => 'Position',
                        'name' => 'position',
                        'type' => 'number',
                        'default_value' => 1,
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'league_table',
                        ),
                    ),
                ),
            ));
        endif;
    }
}

// Populate Default Data only once
function hwc_populate_default_data()
{
    // Add default League Tables with unique featured image
    if (!get_posts(array('post_type' => 'league_table', 'posts_per_page' => 1))) {
        for ($i = 1; $i <= 5; $i++) {
            $league_id = wp_insert_post(array(
                'post_type' => 'league_table',
                'post_title' => 'Default League Table ' . $i,
                'post_content' => 'Description for default league table ' . $i,
                'post_status' => 'publish',
            ));
            update_field('tournament', 'Default Tournament', $league_id);
            update_field('position', 1, $league_id);

            // Set a unique Featured Image for each league table
            $image_filename = 'JD-Cymru-Premier.png'; // Different image for each league table
            $image_id = hwc_create_image_from_plugin($image_filename, $league_id);
            if ($image_id) {
                set_post_thumbnail($league_id, $image_id);
            }
        }
    }
}
?>