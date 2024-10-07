<?php

/**
 * Code For Our Sponsors Page.
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hwc
 */

/*--------------------------------------------------------------
	>>> All Action and Filter Functions
----------------------------------------------------------------*/
add_action('acf/init', 'hwc_create_our_sponsors_page_with_acf_fields');

/*--------------------------------------------------------------
	>>> Function for Add ACF Fields for results
----------------------------------------------------------------*/
function hwc_create_our_sponsors_page_with_acf_fields()
{
    /*--------------------------------------------------------------
        >>> Add page with Template 
    ----------------------------------------------------------------*/
    // Set variables for the our_sponsors page
    // Check if the our sponsors page creation has already been run
    $hwc_our_sponsors_page_created = get_option('hwc_our_sponsors_page_created');

    // Set variables for the our sponsors page
    $hwc_our_sponsors_page_title = 'Our Sponsors and Partners';
    $hwc_our_sponsors_page_slug = 'our-sponsors';
    $hwc_our_sponsors_page_template = 'template-parts/template-our-sponsors.php';

    if (!$hwc_our_sponsors_page_created) {
        // Check if the our_sponsors page exists
        $hwc_our_sponsors_page = get_page_by_path($hwc_our_sponsors_page_slug);

        if (!$hwc_our_sponsors_page) {
            // Create the our_sponsors page if it doesn't exist
            $hwc_our_sponsors_page_data = array(
                'post_title'    => $hwc_our_sponsors_page_title,
                'post_content'  => '',
                'post_status'   => 'publish',
                'post_type'     => 'page',
                'post_name'     => $hwc_our_sponsors_page_slug,
            );
            $hwc_our_sponsors_page_id = wp_insert_post($hwc_our_sponsors_page_data);

            // Set the page template
            update_post_meta($hwc_our_sponsors_page_id, '_wp_page_template', $hwc_our_sponsors_page_template);
        } else {
            // If the page exists, get its ID
            $hwc_our_sponsors_page_id = $hwc_our_sponsors_page->ID;
        }

        // Set the flag to indicate the our sponsors page was created
        update_option('hwc_our_sponsors_page_created', true);
    } else {
        // If the our sponsors page creation was already done, just get its ID
        $hwc_our_sponsors_page = get_page_by_path($hwc_our_sponsors_page_slug);
        if ($hwc_our_sponsors_page) {
            $hwc_our_sponsors_page_id = $hwc_our_sponsors_page->ID;
        }
    }


    /*--------------------------------------------------------------
        >>> Add Fields data in our_sponsors page. 
    ----------------------------------------------------------------*/
    if (get_page_by_path($hwc_our_sponsors_page_slug)) {
        // Register ACF fields for the our_sponsors page
        if (function_exists('acf_add_local_field_group')) {
            acf_add_local_field_group(array(
                'key' => 'group_hwc_our_sponsors_page',
                'title' => 'Our Sponsors Page Fields',
                'fields' => array(
                    // Repeater for Our Sponsors Cards
                    array(
                        'key' => 'hwc_main_repeater_sponsors',
                        'label' => 'HWC Main Repeater Sponsors',
                        'name' => 'hwc_repeater_main_sponsors',
                        'type' => 'repeater',
                        'sub_fields' => array(
                            // Main Repeater: Title field only
                            array(
                                'key' => 'hwc_main_sponsor_title',
                                'label' => 'Main Sponsor Title',
                                'name' => 'hwc_main_sponsor_title',
                                'type' => 'text',
                                'required' => 1,
                            ),

                            // Nested Repeater for Cards
                            array(
                                'key' => 'hwc_our_sponsors_repeater_cards',
                                'label' => 'HWC Our Sponsors Cards Repeater',
                                'name' => 'hwc_repeater_our_sponsors_cards',
                                'type' => 'repeater',
                                'sub_fields' => array(
                                    array(
                                        'key' => 'hwc_our_sponsors_card_title',
                                        'label' => 'Card Title',
                                        'name' => 'hwc_our_sponsors_card_title',
                                        'type' => 'text',
                                        'required' => 1,
                                    ),
                                    array(
                                        'key' => 'hwc_our_sponsors_card_title_2',
                                        'label' => 'Card Title 2',
                                        'name' => 'hwc_our_sponsors_card_title_2',
                                        'type' => 'text',
                                        'required' => 1,
                                    ),
                                    array(
                                        'key' => 'hwc_our_sponsors_card_image',
                                        'label' => 'Card Image',
                                        'name' => 'hwc_our_sponsors_card_image',
                                        'type' => 'image',
                                        'required' => 1,
                                    ),
                                    array(
                                        'key' => 'hwc_our_sponsors_card_button_link',
                                        'label' => 'Button Link',
                                        'name' => 'hwc_our_sponsors_card_button_link',
                                        'type' => 'link',
                                        'required' => 0,
                                    ),
                                ),
                            ),
                        ),
                    ),

                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'page',
                            'operator' => '==',
                            'value' => $hwc_our_sponsors_page_id, // Replace with your Our Sponsors page template
                        ),
                    ),
                ),
            ));
        }
    }

    /*--------------------------------------------------------------
    >>> Store Data into ACF Nested Repeater Field for "Our Sponsors"
--------------------------------------------------------------*/
    if (!get_option('hwc_our_sponsors_data_added', false)) {

        // Manually define the sponsors data
        $hwc_main_sponsors_data = array(
            array(
                'hwc_main_sponsor_title' => 'Main Sponsors',
                'hwc_repeater_our_sponsors_cards' => array(
                    array(
                        'hwc_our_sponsors_card_title' => 'Gelli Mor',
                        'hwc_our_sponsors_card_title_2' => 'Front of Shirt Partner',
                        'hwc_our_sponsors_card_image' => 'hcafc-social.jpg', // Placeholder for image
                        'hwc_our_sponsors_card_button_link' => array(
                            'url' => 'https://example.com',
                            'title' => 'Read More',
                            'target' => '_self',
                        ),
                    ),
                    array(
                        'hwc_our_sponsors_card_title' => 'Gelli Mor',
                        'hwc_our_sponsors_card_title_2' => '',
                        'hwc_our_sponsors_card_image' => 'hcafc-social.jpg', // Placeholder for image
                        'hwc_our_sponsors_card_button_link' => array(
                            'url' => 'https://example.com',
                            'title' => 'Read More',
                            'target' => '_self',
                        ),
                    ),
                    // Add more cards for this sponsor if needed
                ),
            ),
            array(
                'hwc_main_sponsor_title' => 'Community Partners',
                'hwc_repeater_our_sponsors_cards' => array(
                    array(
                        'hwc_our_sponsors_card_title' => '2wish',
                        'hwc_our_sponsors_card_title_2' => '',
                        'hwc_our_sponsors_card_image' => 'hcafc-social.jpg', // Placeholder for image
                        'hwc_our_sponsors_card_button_link' => array(
                            'url' => 'https://example.com',
                            'title' => 'Read More',
                            'target' => '_self',
                        ),
                    ),
                    array(
                        'hwc_our_sponsors_card_title' => 'Business in Focus',
                        'hwc_our_sponsors_card_title_2' => '',
                        'hwc_our_sponsors_card_image' => 'hcafc-social.jpg', // Placeholder for image
                        'hwc_our_sponsors_card_button_link' => array(
                            'url' => '',
                            'title' => '',
                            'target' => '',
                        ),
                    ),
                    // Add more cards for this sponsor if needed
                ),
            ),
            // You can add more main sponsors with their nested cards
        );

        // Prepare the final repeater data with uploaded image IDs
        $final_main_sponsors_data = array();

        foreach ($hwc_main_sponsors_data as $main_sponsor) {
            $nested_cards_data = array();

            foreach ($main_sponsor['hwc_repeater_our_sponsors_cards'] as $card) {
                // Upload the image and get the attachment ID (using a helper function)
                $hwc_our_sponsors_card_image_id = hwc_create_image_from_plugin($card['hwc_our_sponsors_card_image'], $hwc_our_sponsors_page_id);

                if (!is_wp_error($hwc_our_sponsors_card_image_id)) {
                    $nested_cards_data[] = array(
                        'hwc_our_sponsors_card_title' => $card['hwc_our_sponsors_card_title'],
                        'hwc_our_sponsors_card_title_2' => $card['hwc_our_sponsors_card_title_2'],
                        'hwc_our_sponsors_card_image' => $hwc_our_sponsors_card_image_id, // Use uploaded image ID
                        'hwc_our_sponsors_card_button_link' => $card['hwc_our_sponsors_card_button_link'], // Correct format for ACF link field
                    );
                } else {
                    error_log('Failed to upload image: ' . $hwc_our_sponsors_card_image_id->get_error_message());
                }
            }

            // Add main sponsor with its nested cards to the final data array
            $final_main_sponsors_data[] = array(
                'hwc_main_sponsor_title' => $main_sponsor['hwc_main_sponsor_title'],
                'hwc_repeater_our_sponsors_cards' => $nested_cards_data,
            );
        }

        // Update the ACF repeater field for the Our Sponsors page with the structured array
        update_field('hwc_repeater_main_sponsors', $final_main_sponsors_data, $hwc_our_sponsors_page_id);

        // After the function has run, set the option to true
        update_option('hwc_our_sponsors_data_added', true);
    }
}
//end