<?php

/**
 * Code For Club Page.
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hwc
 */

/*--------------------------------------------------------------
	>>> All Action and Filter Functions
----------------------------------------------------------------*/
add_action('acf/init', 'hwc_create_club_page_with_acf_fields');

/*--------------------------------------------------------------
	>>> Function for Add ACF Fields for results
----------------------------------------------------------------*/
function hwc_create_club_page_with_acf_fields()
{
    /*--------------------------------------------------------------
        >>> Add page with Template 
    ----------------------------------------------------------------*/
    // Check if the Club page creation has already been run
    $club_page_created = get_option('hwc_club_page_created');

    // Set variables for the club page
    $hwc_club_page_title = 'Club';
    $hwc_club_page_slug = 'club';
    $hwc_club_page_template = 'template-parts/template-club.php';

    if (!$club_page_created) {
        // Check if the club page exists
        $hwc_club_page = get_page_by_path($hwc_club_page_slug);

        if (!$hwc_club_page) {
            // Create the club page if it doesn't exist
            $hwc_club_page_data = array(
                'post_title'    => $hwc_club_page_title,
                'post_content'  => '',
                'post_status'   => 'publish',
                'post_type'     => 'page',
                'post_name'     => $hwc_club_page_slug,
                'page_template' => $hwc_club_page_template
            );
            $hwc_club_page_id = wp_insert_post($hwc_club_page_data);

            // Set the page template
            update_post_meta($hwc_club_page_id, '_wp_page_template', $hwc_club_page_template);
        } else {
            // If the page exists, get its ID
            $hwc_club_page_id = $hwc_club_page->ID;
        }

        // Set the flag to indicate the Club page was created
        update_option('hwc_club_page_created', true);
    } else {
        // If the Club page creation was already done, just get its ID
        $hwc_club_page = get_page_by_path($hwc_club_page_slug);
        if ($hwc_club_page) {
            $hwc_club_page_id = $hwc_club_page->ID;
        }
    }


    /*--------------------------------------------------------------
        >>> Add Fields data in club page. 
    ----------------------------------------------------------------*/
    if (get_page_by_path($hwc_club_page_slug)) {
        // Register ACF fields for the club page
        if (function_exists('acf_add_local_field_group')) {
            acf_add_local_field_group(array(
                'key' => 'group_hwc_club_page',
                'title' => 'Club Page Fields',
                'fields' => array(
                    // Section Title for Club Page
                    array(
                        'key' => 'hwc_club_section_title',
                        'label' => 'HWC Club Section Title',
                        'name' => 'hwc_club_section_title',
                        'type' => 'text',
                        'required' => 1,
                    ),
                    // Repeater for Club Cards
                    array(
                        'key' => 'hwc_club_repeater_cards',
                        'label' => 'HWC Club Cards Repeater',
                        'name' => 'hwc_repeater_club_cards',
                        'type' => 'repeater',
                        'sub_fields' => array(
                            array(
                                'key' => 'hwc_club_card_title',
                                'label' => 'HWC Card Title',
                                'name' => 'hwc_club_card_title',
                                'type' => 'text',
                                'required' => 1,
                            ),
                            array(
                                'key' => 'hwc_club_card_image',
                                'label' => 'HWC Card Image',
                                'name' => 'hwc_club_card_image',
                                'type' => 'image',
                                'required' => 1,
                            ),
                            array(
                                'key' => 'hwc_club_card_button_link',
                                'label' => 'HWC Button Link',
                                'name' => 'hwc_button_link',
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
                            'value' => $hwc_club_page_id, // Replace with your Club page template
                        ),
                    ),
                ),
            ));
        }
    }

    /*--------------------------------------------------------------
        >>> Store Data
    ----------------------------------------------------------------*/
    if (!get_option('hwc_club_data_added', false)) {
        // Define the section title for the Club page with hwc_club_ prefix
        $hwc_club_section_title = 'Club'; // Adjust the title as needed

        // Update the ACF field for the Club section title with hwc_club_ prefix
        update_field('hwc_club_section_title', $hwc_club_section_title, $hwc_club_page_id);

        // Manually define the Club page repeater data with hwc_club_ prefix
        $hwc_club_repeater_data = array(
            array(
                'hwc_club_card_image' => 'hcafc-social.jpg', // Placeholder for Card 1
                'hwc_club_card_title' => 'Club Officials',
                'hwc_club_card_link' => array(
                    'url' => site_url('club-officials'),
                    'title' => 'Read More',
                    'target' => '_self', // '_blank' for new tab
                ),
            ),
            array(
                'hwc_club_card_image' => 'K336021-scaled-1.jpg', // Placeholder for Card 2
                'hwc_club_card_title' => 'Contact',
                'hwc_club_card_link' => array(
                    'url' => site_url('Contact'),
                    'title' => 'Read More',
                    'target' => '_self',
                ),
            ),
            array(
                'hwc_club_card_image' => 'hcafc-social.jpg', // Placeholder for Card 3
                'hwc_club_card_title' => 'About The Academy',
                'hwc_club_card_link' => array(
                    'url' => site_url('about-the-academy'),
                    'title' => 'Read More',
                    'target' => '_self',
                ),
            ),

            array(
                'hwc_club_card_image' => 'hcafc-social.jpg', // Placeholder for Card 3
                'hwc_club_card_title' => 'History',
                'hwc_club_card_link' => array(
                    'url' => site_url('history'),
                    'title' => 'Read More',
                    'target' => '_self',
                ),
            ),
            array(
                'hwc_club_card_image' => 'hcafc-social.jpg', // Placeholder for Card 3
                'hwc_club_card_title' => 'Stadium',
                'hwc_club_card_link' => array(
                    'url' => site_url('stadium'),
                    'title' => 'Read More',
                    'target' => '_self',
                ),
            ),
            array(
                'hwc_club_card_image' => 'hcafc-social.jpg', // Placeholder for Card 3
                'hwc_club_card_title' => 'Social Media',
                'hwc_club_card_link' => array(
                    'url' => site_url('social-media'),
                    'title' => 'Read More',
                    'target' => '_self',
                ),
            ),
        );

        // Prepare the final repeater data with uploaded image IDs
        $final_club_repeater_data = array();

        foreach ($hwc_club_repeater_data as $card) {
            // Upload the image and get the attachment ID
            $card_image_id = hwc_create_image_from_plugin($card['hwc_club_card_image'], $hwc_club_page_id);

            if (!is_wp_error($card_image_id)) {
                $final_club_repeater_data[] = array(
                    'hwc_club_card_image' => $card_image_id, // Use the uploaded image ID with hwc_club_ prefix
                    'hwc_club_card_title' => $card['hwc_club_card_title'],
                    'hwc_button_link' => $card['hwc_club_card_link'], // Correct format for ACF link field
                );
            } else {
                error_log('Failed to upload image: ' . $card_image_id->get_error_message());
            }
        }

        // Update the ACF repeater field for the Club page with the structured array
        update_field('hwc_repeater_club_cards', $final_club_repeater_data, $hwc_club_page_id);
        // After the function has run, set the option to true
        update_option('hwc_club_data_added', true);
    }
}
//end