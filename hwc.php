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
add_action('acf/init', 'hwc_set_default_acf_field_values');


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
    hwc_populate_default_team_data();
    flush_rewrite_rules();
    hwc_create_news_page();
    hwc_create_contact_page();
    hwc_create_news_stories_page();
}


/*--------------------------------------------------------------
	>>> Include Function for create dummy posts from files
----------------------------------------------------------------*/
require_once plugin_dir_path(__FILE__) . '/inc/hwc-header/hwc-header.php';
require_once plugin_dir_path(__FILE__) .  '/inc/hwc-footer/hwc-footer.php';
require_once plugin_dir_path(__FILE__) . '/inc/hwc-table/hwc-table.php';
require_once plugin_dir_path(__FILE__) . 'inc/hwc-posts/categories_and_manual_posts.php';
require_once plugin_dir_path(__FILE__) . '/inc/hwc-players/hwc-players.php';
require_once plugin_dir_path(__FILE__) . '/inc/hwc-teams/hwc-teams.php';
require_once plugin_dir_path(__FILE__) . '/inc/hwc-staff/hwc-staff.php';
require_once plugin_dir_path(__FILE__) . '/inc/hwc-matches/hwc-matches.php';
require_once plugin_dir_path(__FILE__) . '/inc/hwc-results/hwc-results.php';
require_once plugin_dir_path(__FILE__) . '/inc/hwc-home/hwc-home.php';
require_once plugin_dir_path(__FILE__) . '/inc/hwc-news/hwc-news.php';
require_once plugin_dir_path(__FILE__) . '/inc/hwc-club/hwc-club.php';
require_once plugin_dir_path(__FILE__) . '/inc/hwc-club-officials/hwc-club-officials.php';
require_once plugin_dir_path(__FILE__) . '/inc/hwc-contact/hwc-contact.php';
require_once plugin_dir_path(__FILE__) . '/inc/hwc-about-the-academy/hwc-about-the-academy.php';
require_once plugin_dir_path(__FILE__) . '/inc/hwc-history/hwc-history.php';
require_once plugin_dir_path(__FILE__) . '/inc/hwc-social-media/hwc-social-media.php';
require_once plugin_dir_path(__FILE__) . '/inc/hwc-stadium/hwc-stadium.php';
require_once plugin_dir_path(__FILE__) . '/inc/hwc-directions-to-haverfordwest-county-afc/hwc-directions-to-haverfordwest-county-afc.php';
require_once plugin_dir_path(__FILE__) . '/inc/hwc-documents/hwc-documents.php';
require_once plugin_dir_path(__FILE__) . '/inc/hwc-commercial/hwc-commercial.php';
require_once plugin_dir_path(__FILE__) . '/inc/hwc-our-sponsors/hwc-our-sponsors.php';
require_once plugin_dir_path(__FILE__) . '/inc/hwc-community/hwc-community.php';
require_once plugin_dir_path(__FILE__) . '/inc/hwc-academy/hwc-academy.php';
require_once plugin_dir_path(__FILE__) . '/inc/hwc-news-stories/hwc-news-stories.php';
require_once plugin_dir_path(__FILE__) . '/inc/hwc-youth-phase/hwc-youth-phase.php';
require_once plugin_dir_path(__FILE__) . '/inc/hwc-development-phase/hwc-development-phase.php';

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
        hwc_create_page_with_template($page['title'], $page['template'], $page['slug']);
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
function hwc_create_image_from_plugin($filename, $post_id = null)
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
    $attach_id = wp_insert_attachment($attachment, $new_file_path, $post_id ? $post_id : 0);

    // Include image.php to use wp_generate_attachment_metadata
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    // Generate metadata for the attachment
    $attach_data = wp_generate_attachment_metadata($attach_id, $new_file_path);

    // Update the attachment metadata
    wp_update_attachment_metadata($attach_id, $attach_data);

    // Return the attachment ID
    return $attach_id;
}


?>