<?php

/**
 * Code For Commercial Page.
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hwc
 */

/*--------------------------------------------------------------
	>>> All Action and Filter Functions
----------------------------------------------------------------*/
add_action('acf/init', 'hwc_create_commercial_page_with_acf_fields');

/*--------------------------------------------------------------
	>>> Function for Add ACF Fields for results
----------------------------------------------------------------*/
function hwc_create_commercial_page_with_acf_fields()
{
    /*--------------------------------------------------------------
        >>> Add page with Template 
    ----------------------------------------------------------------*/
    // Set variables for the commercial page
    $hwc_commercial_page_title = 'Commercial';
    $hwc_commercial_page_slug = 'commercial';
    $hwc_commercial_page_template = 'template-parts/template-commercial.php';

    // Check if the commercial page exists
    $hwc_commercial_page = get_page_by_path($hwc_commercial_page_slug);

    if (!$hwc_commercial_page) {
        // Create the commercial page if it doesn't exist
        $hwc_commercial_page_data = array(
            'post_title'    => $hwc_commercial_page_title,
            'post_content'  => '',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_name'     => $hwc_commercial_page_slug,
            'page_template' => $hwc_commercial_page_template
        );
        $hwc_commercial_page_id = wp_insert_post($hwc_commercial_page_data);

        // Set the page template
        update_post_meta($hwc_commercial_page_id, '_wp_page_template', $hwc_commercial_page_template);
    } else {
        // If the page exists, get its ID
        $hwc_commercial_page_id = $hwc_commercial_page->ID;
    }

    /*--------------------------------------------------------------
        >>> Add Fields data in commercial page. 
    ----------------------------------------------------------------*/
    // Register ACF fields for the commercial page
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_hwc_commercial_page',
            'title' => 'Commercial Page Fields',
            'fields' => array(
                // Repeater for Commercial Cards
                array(
                    'key' => 'hwc_commercial_repeater_cards',
                    'label' => 'HWC Commercial Cards Repeater',
                    'name' => 'hwc_repeater_commercial_cards',
                    'type' => 'repeater',
                    'sub_fields' => array(
                        array(
                            'key' => 'hwc_commercial_card_title',
                            'label' => 'Card Title',
                            'name' => 'hwc_commercial_card_title',
                            'type' => 'text',
                            'required' => 1,
                        ),
                        array(
                            'key' => 'hwc_commercial_card_image',
                            'label' => 'Card Image',
                            'name' => 'hwc_commercial_card_image',
                            'type' => 'image',
                            'required' => 1,
                        ),
                        array(
                            'key' => 'hwc_commercial_card_button_link',
                            'label' => 'Button Link',
                            'name' => 'hwc_commercial_card_button_link',
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
                        'value' => $hwc_commercial_page_id, // Replace with your Commercial page template
                    ),
                ),
            ),
        ));
    }

    /*--------------------------------------------------------------
        >>> Store Data
    ----------------------------------------------------------------*/
    if (!get_option('hwc_commercial_data_added', false)) {
        // Manually define the Commercial page repeater data with hwc_commercial_ prefix
        $hwc_commercial_repeater_data = array(
            array(
                'hwc_commercial_card_image' => 'hcafc-social.jpg', // Placeholder for Card 1
                'hwc_commercial_card_title' => 'Our Sponsors and Partners',
                'hwc_commercial_card_link' => array(
                    'url' => 'https://example.com',
                    'title' => 'Read More',
                    'target' => '_self', // '_blank' for new tab
                ),
            ),
        );

        // Prepare the final repeater data with uploaded image IDs
        $final_commercial_repeater_data = array();

        foreach ($hwc_commercial_repeater_data as $hwc_commercial_repeater_single_data) {
            // Upload the image and get the attachment ID
            $hwc_commercial_card_image_id = hwc_create_image_from_plugin($hwc_commercial_repeater_single_data['hwc_commercial_card_image'], $hwc_commercial_page_id);

            if (!is_wp_error($hwc_commercial_card_image_id)) {
                $final_commercial_repeater_data[] = array(
                    'hwc_commercial_card_image' => $hwc_commercial_card_image_id, // Use the uploaded image ID with hwc_commercial_ prefix
                    'hwc_commercial_card_title' => $hwc_commercial_repeater_single_data['hwc_commercial_card_title'],
                    'hwc_commercial_card_button_link' => $hwc_commercial_repeater_single_data['hwc_commercial_card_link'], // Correct format for ACF link field
                );
            } else {
                error_log('Failed to upload image: ' . $hwc_commercial_card_image_id->get_error_message());
            }
        }

        // Update the ACF repeater field for the Commercial page with the structured array
        update_field('hwc_repeater_commercial_cards', $final_commercial_repeater_data, $hwc_commercial_page_id);
        // After the function has run, set the option to true
        update_option('hwc_commercial_data_added', true);
    }
}
//end