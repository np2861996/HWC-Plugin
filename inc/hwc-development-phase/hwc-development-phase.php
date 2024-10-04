<?php

/**
 * Code For Development Phase Page.
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hwc
 */

/*--------------------------------------------------------------
	>>> All Action and Filter Functions
----------------------------------------------------------------*/
add_action('acf/init', 'hwc_create_development_phase_page_with_acf_fields');

/*--------------------------------------------------------------
	>>> Function for Add ACF Fields for results
----------------------------------------------------------------*/
function hwc_create_development_phase_page_with_acf_fields()
{
    /*--------------------------------------------------------------
        >>> Add page with Template 
    ----------------------------------------------------------------*/
    // Set variables for the development_phase page
    $hwc_development_phase_page_title = 'Development Phase';
    $hwc_development_phase_page_slug = 'development_phase';
    $hwc_development_phase_page_template = 'template-parts/template-development-phase.php';

    // Check if the development_phase page exists
    $hwc_development_phase_page = get_page_by_path($hwc_development_phase_page_slug);

    if (!$hwc_development_phase_page) {
        // Create the development_phase page if it doesn't exist
        $hwc_development_phase_page_data = array(
            'post_title'    => $hwc_development_phase_page_title,
            'post_content'  => '<h5>FIXTURES: Cymru Premier Development League South 2023-24</h5>
            <p>August 20 – <a href="https://haverfordwestcountyafc.com/matches/2023-24/8757/haverfordwest-county-vs-briton-ferry-llansawel/">Haverfordwest County 1-2 Briton Ferry Llansawel</a></p>
            <p>August 27 – Llanelli Town 1-2 Haverfordwest County</p>
            <p>September 10 – Pontardawe Town (home)</p>
            <p>September 17 – Merthyr Town (away)</p>
            <p>September 24 – Carmarthen Town (home)</p>
            <p>October 1 – Pen-y-Bont (away)</p>
            <p>October 8 – Cardiff Metropolitan (home)</p>
            <p>October 15 – Pontypridd United (away)</p>
            <p>October 22 – Cambrian and Clydach Vale (home)</p>
            <p>October 29 – Cambrian and Clydach Vale (away)</p>
            <p>November 5 – Pontypridd United (away)</p>
            <p>November 12 – Cardiff Metropolitan (away)</p>
            <p>November 19 – Pen-y-Bont (home)</p>
            <p>November 26 – Carmarthen Town (away)</p>
            <p>December 3 – Merthyr Town (home)</p>
            <p>December 10 – Pontardawe Town (away)</p>
            <p>January 14 – Llanelli Town (home)</p>
            <p>January 21 – Briton Ferry Llansawel (away)</p>
            <p>January 28 – Barry Town United (home)</p>
            <p>February 4 -Barry Town United (away)</p>
            <p>February 18 – Briton Ferry Llansawel (home)</p>
            <p>February 25 – Llanelli Town (away)</p>
            <p>March 10 – Pontardawe Town (home)</p>
            <p>March 17 – Merthyr Town (away)</p>
            <p>March 24 – Carmarthen Town (home)</p>
            <p>April 7 – Pen-y-Bont (away)</p>
            <p>April 14 – Cardiff Metropolitan (home)</p>
            <p>April 21 – Pontypridd United (away)</p>
            <p>April 28 – Cambrian and Clydach Vale (home)</p>',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_name'     => $hwc_development_phase_page_slug,
            'page_template' => $hwc_development_phase_page_template
        );
        $hwc_development_phase_page_id = wp_insert_post($hwc_development_phase_page_data);

        // Set the page template
        update_post_meta($hwc_development_phase_page_id, '_wp_page_template', $hwc_development_phase_page_template);
    } else {
        // If the page exists, get its ID
        $hwc_development_phase_page_id = $hwc_development_phase_page->ID;
    }

    /*--------------------------------------------------------------
        >>> Add Fields data in development_phase page. 
    ----------------------------------------------------------------*/
    // Register ACF fields for the development_phase page
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_hwc_development_phase_page',
            'title' => 'Development Phase Page Fields',
            'fields' => array(
                // Player Repeater
                array(
                    'key' => 'hwc_development_phase_player_repeater_cards',
                    'label' => 'Our Development Phase Player',
                    'name' => 'hwc_development_phase_player_repeater_cards',
                    'type' => 'repeater',
                    'sub_fields' => array(
                        array(
                            'key' => 'hwc_our_development_phase_player_title',
                            'label' => 'Title',
                            'name' => 'hwc_our_development_phase_player_title',
                            'type' => 'text',
                            'required' => 0,
                        ),
                        array(
                            'key' => 'hwc_our_development_phase_player_image',
                            'label' => 'Image',
                            'name' => 'hwc_our_development_phase_player_image',
                            'type' => 'image',
                            'required' => 0,
                        ),
                    ),
                    'min' => 0,
                    'layout' => 'block', // You can change to 'row' if preferred
                    'button_label' => 'Add Card',
                ),
                array(
                    'key' => 'hwc_development_phase_voap_section_title',
                    'label' => 'View our other Academy Phases Title',
                    'name' => 'hwc_development_phase_voap_section_title',
                    'type' => 'text',
                    'required' => 0,
                ),
                // Repeater for Development Phase Cards
                array(
                    'key' => 'hwc_development_phase_repeater_cards',
                    'label' => 'View our other Academy Phases Repeater',
                    'name' => 'hwc_repeater_development_phase_cards',
                    'type' => 'repeater',
                    'sub_fields' => array(
                        array(
                            'key' => 'hwc_development_phase_card_title',
                            'label' => 'Title',
                            'name' => 'hwc_development_phase_card_title',
                            'type' => 'text',
                            'required' => 1,
                        ),
                        array(
                            'key' => 'hwc_development_phase_card_image',
                            'label' => 'Card Image',
                            'name' => 'hwc_development_phase_card_image',
                            'type' => 'image',
                            'required' => 1,
                        ),
                        array(
                            'key' => 'hwc_development_phase_card_button_link',
                            'label' => 'Button Link',
                            'name' => 'hwc_development_phase_card_button_link',
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
                        'value' => $hwc_development_phase_page_id, // Replace with your Development Phase page template
                    ),
                ),
            ),
        ));
    }

    /*--------------------------------------------------------------
        >>> Store Data
    ----------------------------------------------------------------*/
    if (!get_option('hwc_development_phase_data_added', false)) {

        // Define the section title for the Development Phase page with hwc_development_phase_ prefix
        $hwc_development_phase_voap_section_title = 'View our other Academy Phases';

        // Update the ACF field for the Development Phase section title with hwc_development_phase_ prefix
        update_field('hwc_development_phase_voap_section_title', $hwc_development_phase_voap_section_title, $hwc_development_phase_page_id);

        // Manually define the Development Phase page repeater data with hwc_development_phase_ prefix
        // Dummy data for HWC Development Phase Repeater Cards
        $hwc_development_phase_repeater_data = array(
            array(
                'hwc_development_phase_card_image' => 'hcafc-social.jpg', // Placeholder for Card 1
                'hwc_development_phase_card_title' => 'About The Development Phase',
                'hwc_development_phase_card_link' => array(
                    'url' => 'https://example.com/2wish',
                    'title' => 'Read More',
                    'target' => '_self', // '_blank' for new tab
                ),
            ),
            array(
                'hwc_development_phase_card_image' => 'hcafc-social.jpg', // Placeholder for Card 2
                'hwc_development_phase_card_title' => 'News stories',
                'hwc_development_phase_card_link' => array(
                    'url' => 'https://example.com/business-in-focus',
                    'title' => 'Read More',
                    'target' => '_self',
                ),
            ),
        );

        // Prepare final HWC Development Phase Repeater Data with uploaded image IDs
        $final_development_phase_repeater_data = array();

        foreach ($hwc_development_phase_repeater_data as $hwc_development_phase_repeater_single_data) {
            // Upload the image and get the attachment ID
            $hwc_development_phase_card_image_id = hwc_create_image_from_plugin($hwc_development_phase_repeater_single_data['hwc_development_phase_card_image'], $hwc_development_phase_page_id);

            if (!is_wp_error($hwc_development_phase_card_image_id)) {
                $final_development_phase_repeater_data[] = array(
                    'hwc_development_phase_card_image' => $hwc_development_phase_card_image_id, // Use the uploaded image ID
                    'hwc_development_phase_card_title' => $hwc_development_phase_repeater_single_data['hwc_development_phase_card_title'],
                    'hwc_development_phase_card_button_link' => $hwc_development_phase_repeater_single_data['hwc_development_phase_card_link'], // Correct format for ACF link field
                );
            } else {
                error_log('Failed to upload image: ' . $hwc_development_phase_card_image_id->get_error_message());
            }
        }

        // Dummy data for Our Development Phase FAQ Repeater Cards
        $hwc_development_phase_player_data = array(
            array(
                'hwc_our_development_phase_player_title' => 'Lucas Davies',
                'hwc_our_development_phase_player_image' => '32HFC0805_PlayerProfilesBlank.jpg',
            ),
            array(
                'hwc_our_development_phase_player_title' => 'Harri John',
                'hwc_our_development_phase_player_image' => '32HFC0805_PlayerProfilesBlank.jpg',
            ),
        );

        // Prepare final Our Development Phase FAQ Repeater Data
        $final_development_phase_player_data = array();

        foreach ($hwc_development_phase_player_data as $hwc_development_phase_player_single_data) {
            $hwc_our_development_phase_player_image_id = hwc_create_image_from_plugin($hwc_development_phase_player_single_data['hwc_our_development_phase_player_image'], $hwc_development_phase_page_id);
            $final_development_phase_player_data[] = array(
                'hwc_our_development_phase_player_title' => $hwc_development_phase_player_single_data['hwc_our_development_phase_player_title'],
                'hwc_our_development_phase_player_image' => $hwc_our_development_phase_player_image_id,
            );
        }

        // Now, you can update the ACF fields with the final prepared data
        update_field('hwc_repeater_development_phase_cards', $final_development_phase_repeater_data, $hwc_development_phase_page_id);
        update_field('hwc_development_phase_player_repeater_cards', $final_development_phase_player_data, $hwc_development_phase_page_id);

        // After the function has run, set the option to true
        update_option('hwc_development_phase_data_added', true);
    }
}
//end