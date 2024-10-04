<?php

/**
 * Code For Header Options Page.
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hwc
 */


/*--------------------------------------------------------------
	>>> All Action and Filter Functions
----------------------------------------------------------------*/
add_action('acf/init', 'hwc_initialize_header_settings');

/*--------------------------------------------------------------
>>> Add options page
----------------------------------------------------------------*/
if (function_exists('acf_add_options_page')) {

    // Add header options page
    acf_add_options_page(array(
        'page_title' => 'Header Settings',
        'menu_title' => 'Header Settings',
        'menu_slug' => 'header-settings',
        'capability' => 'edit_posts',
        'redirect' => false
    ));
}

/*--------------------------------------------------------------
>>> Add options page data
----------------------------------------------------------------*/
// Function to initialize header settings
function hwc_initialize_header_settings()
{
    // Check if the ACF function exists
    if (function_exists('acf_add_local_field_group')) {
        // Header Settings Fields
        acf_add_local_field_group(array(
            'key' => 'group_header_settings',
            'title' => 'Header Settings',
            'fields' => array(
                // Link Repeater
                array(
                    'key' => 'header_link_repeater',
                    'label' => 'Header Links',
                    'name' => 'header_link_repeater',
                    'type' => 'repeater',
                    'sub_fields' => array(
                        array(
                            'key' => 'header_link_url',
                            'label' => 'Link URL',
                            'name' => 'header_link',
                            'type' => 'link',
                            'required' => 0,
                        ),
                    ),
                    'min' => 0,
                    'layout' => 'block',
                    'button_label' => 'Add Link',
                ),

                // Image 1
                array(
                    'key' => 'header_image_1',
                    'label' => 'Header Image 1',
                    'name' => 'header_image_1',
                    'type' => 'image',
                    'required' => 0,
                    'return_format' => 'url',
                    'preview_size' => 'medium',
                    'library' => 'all',
                ),
                array(
                    'key' => 'header_image_1_link',
                    'label' => 'Header Image 1 Link',
                    'name' => 'header_image_1_link',
                    'type' => 'link',
                    'required' => 0,
                ),

                // Image 2
                array(
                    'key' => 'header_image_2',
                    'label' => 'Header Image 2',
                    'name' => 'header_image_2',
                    'type' => 'image',
                    'required' => 0,
                    'return_format' => 'url',
                    'preview_size' => 'medium',
                    'library' => 'all',
                ),
                array(
                    'key' => 'header_image_2_link',
                    'label' => 'Header Image 2 Link',
                    'name' => 'header_image_2_link',
                    'type' => 'link',
                    'required' => 0,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'header-settings', // Slug of your header settings options page
                    ),
                ),
            ),
        ));
    }

    // Check if header data has already been added
    if (!get_option('hwc_header_data_added', false)) {
        $hwc_header_links = array(
            array(
                'header_link' => array(
                    'url' => '/commercial/',
                    'title' => 'Commercial',
                    'target' => '_self'
                ),
            ),
            array(
                'header_link' => array(
                    'url' => '/category/you-can-have-it-all/',
                    'title' => 'Watch #YouCanHaveItAll!',
                    'target' => '_self'
                ),
            ),
        );

        // Upload the images and get the attachment IDs for Image 1 and Image 2
        $hwc_header_image_1_id = hwc_create_image_from_plugin('JD-Cymru-Premier.png');
        $hwc_header_image_2_id = hwc_create_image_from_plugin('GELLI-MOR-PRINT_WHT.png');

        // Check if the images uploaded successfully
        if (!is_wp_error($hwc_header_image_1_id)) {
            // Update the option for Image 1
            update_field('header_image_1', $hwc_header_image_1_id, 'option');
            // Update the link for Image 1
            $header_image_1_link = array(
                'url' => 'https://example.com/image1', // Set your desired link here
                'title' => 'Visit Image 1',
                'target' => '_self'
            );
            update_field('header_image_1_link', $header_image_1_link, 'option');
        } else {
            error_log('Failed to upload Image 1: ' . $hwc_header_image_1_id->get_error_message());
        }

        if (!is_wp_error($hwc_header_image_2_id)) {
            // Update the option for Image 2
            update_field('header_image_2', $hwc_header_image_2_id, 'option');
            // Update the link for Image 2
            $header_image_2_link = array(
                'url' => 'https://example.com/image2', // Set your desired link here
                'title' => 'Visit Image 2',
                'target' => '_self'
            );
            update_field('header_image_2_link', $header_image_2_link, 'option');
        } else {
            error_log('Failed to upload Image 2: ' . $hwc_header_image_2_id->get_error_message());
        }

        // Update the repeater field with the header links
        // Make sure to use the correct field key for the repeater field
        update_field('header_link_repeater', $hwc_header_links, 'option');

        // Mark that data has been added to avoid repetition
        update_option('hwc_header_data_added', true);
    }
}

// Hook the function into the init action
add_action('init', 'hwc_initialize_header_settings');
