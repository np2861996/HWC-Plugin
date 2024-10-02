<?php

/**
 * Code For Community Page.
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hwc
 */

/*--------------------------------------------------------------
	>>> All Action and Filter Functions
----------------------------------------------------------------*/
add_action('acf/init', 'hwc_create_community_page_with_acf_fields');

/*--------------------------------------------------------------
	>>> Function for Add ACF Fields for results
----------------------------------------------------------------*/
function hwc_create_community_page_with_acf_fields()
{
    /*--------------------------------------------------------------
        >>> Add page with Template 
    ----------------------------------------------------------------*/
    // Set variables for the community page
    $hwc_community_page_title = 'Community';
    $hwc_community_page_slug = 'community';
    $hwc_community_page_template = 'template-parts/template-community.php';

    // Check if the community page exists
    $hwc_community_page = get_page_by_path($hwc_community_page_slug);

    if (!$hwc_community_page) {
        // Create the community page if it doesn't exist
        $hwc_community_page_data = array(
            'post_title'    => $hwc_community_page_title,
            'post_content'  => 'More information on our upcoming community projects will be announced in due course.',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_name'     => $hwc_community_page_slug,
            'page_template' => $hwc_community_page_template
        );
        $hwc_community_page_id = wp_insert_post($hwc_community_page_data);

        // Set the page template
        update_post_meta($hwc_community_page_id, '_wp_page_template', $hwc_community_page_template);
    } else {
        // If the page exists, get its ID
        $hwc_community_page_id = $hwc_community_page->ID;
    }

    /*--------------------------------------------------------------
        >>> Add Fields data in community page. 
    ----------------------------------------------------------------*/
    // Register ACF fields for the community page
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_hwc_community_page',
            'title' => 'Community Page Fields',
            'fields' => array(
                // Section Title for Community Page
                array(
                    'key' => 'hwc_community_section_title_1',
                    'label' => 'HWC Community Section Title 1',
                    'name' => 'hwc_community_section_title_1',
                    'type' => 'text',
                    'required' => 0,
                ),
                array(
                    'key' => 'hwc_community_section_title_2',
                    'label' => 'HWC Community Section Title 2',
                    'name' => 'hwc_community_section_title_2',
                    'type' => 'text',
                    'required' => 0,
                ),
                // Repeater for Community Cards
                array(
                    'key' => 'hwc_community_repeater_cards',
                    'label' => 'Community Cards Repeater',
                    'name' => 'hwc_repeater_community_cards',
                    'type' => 'repeater',
                    'sub_fields' => array(
                        array(
                            'key' => 'hwc_community_card_title',
                            'label' => 'Title',
                            'name' => 'hwc_community_card_title',
                            'type' => 'text',
                            'required' => 1,
                        ),
                        array(
                            'key' => 'hwc_community_card_image',
                            'label' => 'Card Image',
                            'name' => 'hwc_community_card_image',
                            'type' => 'image',
                            'required' => 1,
                        ),
                        array(
                            'key' => 'hwc_community_card_button_link',
                            'label' => 'Button Link',
                            'name' => 'hwc_community_card_button_link',
                            'type' => 'link',
                            'required' => 0,
                        ),
                    ),
                    'min' => 0,
                    'layout' => 'block', // You can change to 'row' if preferred
                    'button_label' => 'Add Card',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'page',
                        'operator' => '==',
                        'value' => $hwc_community_page_id, // Replace with your Community page template
                    ),
                ),
            ),
        ));
    }

    /*--------------------------------------------------------------
        >>> Store Data
    ----------------------------------------------------------------*/
    if (!get_option('hwc_community_data_added', false)) {

        // Define the section title for the Community page with hwc_community_ prefix
        $hwc_community_section_title_1 = 'Community News'; // Adjust the title as needed
        $hwc_community_section_title_2 = 'Community Partners';

        // Update the ACF field for the Community section title with hwc_community_ prefix
        update_field('hwc_community_section_title_1', $hwc_community_section_title_1, $hwc_community_page_id);
        update_field('hwc_community_section_title_2', $hwc_community_section_title_2, $hwc_community_page_id);

        // Manually define the Community page repeater data with hwc_community_ prefix
        $hwc_community_repeater_data = array(
            array(
                'hwc_community_card_image' => 'fb_1695273515215_1695273522698.jpg', // Placeholder for Card 1
                'hwc_community_card_title' => '2wish',
                'hwc_community_card_link' => array(
                    'url' => 'https://example.com',
                    'title' => 'Read More',
                    'target' => '_self', // '_blank' for new tab
                ),
            ),
            array(
                'hwc_community_card_image' => 'ezgif.com-webp-to-jpg-3.jpg', // Placeholder for Card 2
                'hwc_community_card_title' => 'Business in Focus',
                'hwc_community_card_link' => array(
                    'url' => 'https://example.com',
                    'title' => 'Read More',
                    'target' => '_self',
                ),
            ),
        );

        // Prepare the final repeater data with uploaded image IDs
        $final_community_repeater_data = array();

        foreach ($hwc_community_repeater_data as $hwc_community_repeater_single_data) {
            // Upload the image and get the attachment ID
            $hwc_community_card_image_id = hwc_create_image_from_plugin($hwc_community_repeater_single_data['hwc_community_card_image'], $hwc_community_page_id);

            if (!is_wp_error($hwc_community_card_image_id)) {
                $final_community_repeater_data[] = array(
                    'hwc_community_card_image' => $hwc_community_card_image_id, // Use the uploaded image ID with hwc_community_ prefix
                    'hwc_community_card_title' => $hwc_community_repeater_single_data['hwc_community_card_title'],
                    'hwc_community_card_button_link' => $hwc_community_repeater_single_data['hwc_community_card_link'], // Correct format for ACF link field
                );
            } else {
                error_log('Failed to upload image: ' . $hwc_community_card_image_id->get_error_message());
            }
        }

        // Update the ACF repeater field for the Community page with the structured array
        update_field('hwc_repeater_community_cards', $final_community_repeater_data, $hwc_community_page_id);
        // After the function has run, set the option to true
        update_option('hwc_community_data_added', true);
    }
}
//end