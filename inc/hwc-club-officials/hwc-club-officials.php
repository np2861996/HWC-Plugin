<?php

/**
 * Code For Club Officials.
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hwc
 */
/*--------------------------------------------------------------
	>>> All Action and Filter Functions
----------------------------------------------------------------*/
add_action('acf/init', 'hwc_create_club_officials_page_with_acf_fields');

/*--------------------------------------------------------------
	>>> Function for Add ACF Fields for results
----------------------------------------------------------------*/
function hwc_create_club_officials_page_with_acf_fields()
{
    /*--------------------------------------------------------------
        >>> Add page with Template 
    ----------------------------------------------------------------*/
    // Set variables for the club page
    $hwc_club_officials_page_title = 'Club Officials';
    $hwc_club_officials_page_slug = 'club officials';
    $hwc_club_officials_page_template = 'template-parts/template-club-officials.php';

    // Check if the club officials page exists
    $hwc_club_officials_page = get_page_by_path($hwc_club_officials_page_slug);

    if (!$hwc_club_officials_page) {
        // Create the club page if it doesn't exist
        $hwc_club_officials_page_data = array(
            'post_title'    => $hwc_club_officials_page_title,
            'post_content'  => '',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_name'     => $hwc_club_officials_page_slug,
            'page_template' => $hwc_club_officials_page_template
        );
        $hwc_club_officials_page_id = wp_insert_post($hwc_club_officials_page_data);

        // Set the page template
        update_post_meta($hwc_club_officials_page_id, '_wp_page_template', $hwc_club_officials_page_template);
    } else {
        // If the page exists, get its ID
        $hwc_club_officials_page_id = $hwc_club_officials_page->ID;
    }

    /*--------------------------------------------------------------
        >>> Add Fields data in club officials page. 
    ----------------------------------------------------------------*/
    // Register ACF fields for the club officials page
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_hwc_club_officials_page',
            'title' => 'Club Officials Page Fields',
            'fields' => array(
                // Section Title for Club officials Page
                array(
                    'key' => 'hwc_club_officials_section_title',
                    'label' => 'Title',
                    'name' => 'hwc_club_officials_section_title',
                    'type' => 'text',
                    'required' => 1,
                ),
                // Repeater for Club officials Cards
                array(
                    'key' => 'hwc_club_officials_repeater_cards',
                    'label' => 'Club Officials Repeater',
                    'name' => 'hwc_repeater_club_officials_cards',
                    'type' => 'repeater',
                    'sub_fields' => array(
                        array(
                            'key' => 'hwc_club_officials_card_title_1',
                            'label' => 'Card Title 1',
                            'name' => 'hwc_club_officials_card_title_1',
                            'type' => 'text',
                            'required' => 1,
                        ),
                        array(
                            'key' => 'hwc_club_officials_card_title_2',
                            'label' => 'Title 2',
                            'name' => 'hwc_club_officials_card_title_2',
                            'type' => 'text',
                            'required' => 1,
                        ),
                        array(
                            'key' => 'hwc_club_officials_card_image',
                            'label' => 'Image',
                            'name' => 'hwc_club_officials_card_image',
                            'type' => 'image',
                            'required' => 1,
                        ),
                        array(
                            'key' => 'hwc_club_officials_card_button_link',
                            'label' => 'Button Link',
                            'name' => 'hwc_club_officials_button_link',
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
                        'value' => $hwc_club_officials_page_id, // Replace with your Club officials page template
                    ),
                ),
            ),
        ));
    }

    /*--------------------------------------------------------------
        >>> Store Data
    ----------------------------------------------------------------*/
    if (!get_option('hwc_club_officials_data_added', false)) {
        // Define the section title for the Club page with hwc_club_officials_ prefix
        $hwc_club_officials_section_title = 'The Board'; // Adjust the title as needed

        // Update the ACF field for the Club section title with hwc_club_officials_ prefix
        update_field('hwc_club_officials_section_title', $hwc_club_officials_section_title, $hwc_club_officials_page_id);

        // Manually define the Club officials page repeater data with hwc_club_officials_ prefix
        $hwc_club_officials_repeater_data = array(
            array(
                'hwc_club_officials_card_image' => 'hcafc-social.jpg', // Placeholder for Card 1
                'hwc_club_officials_card_title_1' => 'Rob Edwards',
                'hwc_club_officials_card_title_2' => 'Chairman',
                'hwc_club_officials_card_link' => array(
                    'url' => 'mailto:r.edwards@hcafc1899.football',
                    'title' => 'Email Rob',
                    'target' => '_self', // '_blank' for new tab
                ),
            ),
            array(
                'hwc_club_officials_card_image' => 'K336021-scaled-1.jpg', // Placeholder for Card 2
                'hwc_club_officials_card_title_1' => 'Julian Furne',
                'hwc_club_officials_card_title_2' => 'Board Member',
                'hwc_club_officials_card_link' => array(
                    'url' => '',
                    'title' => 'Read More',
                    'target' => '_self',
                ),
            ),
            array(
                'hwc_club_officials_card_image' => 'hcafc-social.jpg', // Placeholder for Card 3
                'hwc_club_officials_card_title_1' => 'Mared Pemberton',
                'hwc_club_officials_card_title_2' => 'Board Member',
                'hwc_club_officials_card_link' => array(
                    'url' => '',
                    'title' => 'Read More',
                    'target' => '_self',
                ),
            ),

            array(
                'hwc_club_officials_card_image' => 'hcafc-social.jpg', // Placeholder for Card 3
                'hwc_club_officials_card_title_1' => 'Daniel Walters',
                'hwc_club_officials_card_title_2' => 'Board Member',
                'hwc_club_officials_card_link' => array(
                    'url' => '',
                    'title' => 'Read More',
                    'target' => '_self',
                ),
            ),
            array(
                'hwc_club_officials_card_image' => 'hcafc-social.jpg', // Placeholder for Card 3
                'hwc_club_officials_card_title_1' => 'Ben Tyler',
                'hwc_club_officials_card_title_2' => 'Board Member',
                'hwc_club_officials_card_link' => array(
                    'url' => '',
                    'title' => 'Read More',
                    'target' => '_self',
                ),
            ),
        );

        // Prepare the final repeater data with uploaded image IDs
        $final_club_officials_repeater_data = array();

        foreach ($hwc_club_officials_repeater_data as $card) {
            // Upload the image and get the attachment ID
            $card_image_id = hwc_create_image_from_plugin($card['hwc_club_officials_card_image'], $hwc_club_officials_page_id);

            if (!is_wp_error($card_image_id)) {
                $final_club_officials_repeater_data[] = array(
                    'hwc_club_officials_card_image' => $card_image_id, // Use the uploaded image ID with hwc_club_officials_ prefix
                    'hwc_club_officials_card_title_1' => $card['hwc_club_officials_card_title_1'],
                    'hwc_club_officials_card_title_2' => $card['hwc_club_officials_card_title_2'],
                    'hwc_club_officials_button_link' => $card['hwc_club_officials_card_link'], // Correct format for ACF link field
                );
            } else {
                error_log('Failed to upload image: ' . $card_image_id->get_error_message());
            }
        }

        // Update the ACF repeater field for the Club page with the structured array
        update_field('hwc_repeater_club_officials_cards', $final_club_officials_repeater_data, $hwc_club_officials_page_id);
        // After the function has run, set the option to true
        update_option('hwc_club_officials_data_added', true);
    }
}
