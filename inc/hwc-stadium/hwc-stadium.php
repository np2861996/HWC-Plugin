<?php

/**
 * Code For Stadium Page.
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hwc
 */

/*--------------------------------------------------------------
	>>> All Action and Filter Functions
----------------------------------------------------------------*/
add_action('acf/init', 'hwc_create_stadium_page_with_acf_fields');

/*--------------------------------------------------------------
	>>> Function for Add ACF Fields for results
----------------------------------------------------------------*/
function hwc_create_stadium_page_with_acf_fields()
{
    /*--------------------------------------------------------------
        >>> Add page with Template 
    ----------------------------------------------------------------*/
    // Set variables for the stadium page
    $hwc_stadium_page_title = 'Stadium';
    $hwc_stadium_page_slug = 'stadium';
    $hwc_stadium_page_template = 'template-parts/template-stadium.php';

    // Check if the stadium page exists
    $hwc_stadium_page = get_page_by_path($hwc_stadium_page_slug);

    if (!$hwc_stadium_page) {
        // Create the stadium page if it doesn't exist
        $hwc_stadium_page_data = array(
            'post_title'    => $hwc_stadium_page_title,
            'post_content'  => 'Everything you need to know for your visit to the Ogi Bridge Meadow Stadium.',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_name'     => $hwc_stadium_page_slug,
            'page_template' => $hwc_stadium_page_template
        );
        $hwc_stadium_page_id = wp_insert_post($hwc_stadium_page_data);

        // Set the page template
        update_post_meta($hwc_stadium_page_id, '_wp_page_template', $hwc_stadium_page_template);
    } else {
        // If the page exists, get its ID
        $hwc_stadium_page_id = $hwc_stadium_page->ID;
    }

    /*--------------------------------------------------------------
        >>> Add Fields data in stadium page. 
    ----------------------------------------------------------------*/
    // Register ACF fields for the stadium page
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_hwc_stadium_page',
            'title' => 'Stadium Page Fields',
            'fields' => array(
                // Repeater for Stadium Cards
                array(
                    'key' => 'hwc_stadium_repeater_cards',
                    'label' => 'HWC Stadium Cards Repeater',
                    'name' => 'hwc_repeater_stadium_cards',
                    'type' => 'repeater',
                    'sub_fields' => array(
                        array(
                            'key' => 'hwc_stadium_card_title',
                            'label' => 'Card Title',
                            'name' => 'hwc_stadium_card_title',
                            'type' => 'text',
                            'required' => 1,
                        ),
                        array(
                            'key' => 'hwc_stadium_card_image',
                            'label' => 'Card Image',
                            'name' => 'hwc_stadium_card_image',
                            'type' => 'image',
                            'required' => 1,
                        ),
                        array(
                            'key' => 'hwc_stadium_card_button_link',
                            'label' => 'Button Link',
                            'name' => 'hwc_stadium_card_button_link',
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
                        'value' => $hwc_stadium_page_id, // Replace with your Stadium page template
                    ),
                ),
            ),
        ));
    }

    /*--------------------------------------------------------------
        >>> Store Data
    ----------------------------------------------------------------*/
    if (!get_option('hwc_stadium_data_added', false)) {
        // Manually define the Stadium page repeater data with hwc_stadium_ prefix
        $hwc_stadium_repeater_data = array(
            array(
                'hwc_stadium_card_image' => 'hcafc-social.jpg', // Placeholder for Card 1
                'hwc_stadium_card_title' => 'Directions to Haverfordwest County AFC',
                'hwc_stadium_card_link' => array(
                    'url' => 'https://example.com',
                    'title' => 'Read More',
                    'target' => '_self', // '_blank' for new tab
                ),
            ),
            array(
                'hwc_stadium_card_image' => 'hcafc-social.jpg', // Placeholder for Card 2
                'hwc_stadium_card_title' => 'Admission Prices',
                'hwc_stadium_card_link' => array(
                    'url' => 'https://example.com',
                    'title' => 'Read More',
                    'target' => '_self',
                ),
            ),
        );

        // Prepare the final repeater data with uploaded image IDs
        $final_stadium_repeater_data = array();

        foreach ($hwc_stadium_repeater_data as $hwc_stadium_repeater_single_data) {
            // Upload the image and get the attachment ID
            $hwc_stadium_card_image_id = hwc_create_image_from_plugin($hwc_stadium_repeater_single_data['hwc_stadium_card_image'], $hwc_stadium_page_id);

            if (!is_wp_error($hwc_stadium_card_image_id)) {
                $final_stadium_repeater_data[] = array(
                    'hwc_stadium_card_image' => $hwc_stadium_card_image_id, // Use the uploaded image ID with hwc_stadium_ prefix
                    'hwc_stadium_card_title' => $hwc_stadium_repeater_single_data['hwc_stadium_card_title'],
                    'hwc_stadium_card_button_link' => $hwc_stadium_repeater_single_data['hwc_stadium_card_link'], // Correct format for ACF link field
                );
            } else {
                error_log('Failed to upload image: ' . $hwc_stadium_card_image_id->get_error_message());
            }
        }

        // Update the ACF repeater field for the Stadium page with the structured array
        update_field('hwc_repeater_stadium_cards', $final_stadium_repeater_data, $hwc_stadium_page_id);
        // After the function has run, set the option to true
        update_option('hwc_stadium_data_added', true);
    }
}
//end