<?php

/**
 * Code For Youth Phase Page.
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hwc
 */

/*--------------------------------------------------------------
	>>> All Action and Filter Functions
----------------------------------------------------------------*/
add_action('acf/init', 'hwc_create_youth_phase_page_with_acf_fields');

/*--------------------------------------------------------------
	>>> Function for Add ACF Fields for results
----------------------------------------------------------------*/
function hwc_create_youth_phase_page_with_acf_fields()
{
    /*--------------------------------------------------------------
        >>> Add page with Template 
    ----------------------------------------------------------------*/
    // Set variables for the youth_phase page
    // Check if the youth_phase page creation has already been run
    $hwc_youth_phase_page_created = get_option('hwc_youth_phase_page_created');

    // Set variables for the youth_phase page
    $hwc_youth_phase_page_title = 'Youth Phase';
    $hwc_youth_phase_page_slug = 'youth-phase';
    $hwc_youth_phase_page_template = 'template-parts/template-youth-phase.php';

    if (!$hwc_youth_phase_page_created) {
        // Check if the youth_phase page exists
        $hwc_youth_phase_page = get_page_by_path($hwc_youth_phase_page_slug);

        if (!$hwc_youth_phase_page) {
            // Create the youth_phase page if it doesn't exist
            $hwc_youth_phase_page_data = array(
                'post_title'    => $hwc_youth_phase_page_title,
                'post_content'  => 'FIXTURES: Cymru Premier Development League South 2023-24',
                'post_status'   => 'publish',
                'post_type'     => 'page',
                'post_name'     => $hwc_youth_phase_page_slug,
            );
            $hwc_youth_phase_page_id = wp_insert_post($hwc_youth_phase_page_data);

            // Set the page template
            update_post_meta($hwc_youth_phase_page_id, '_wp_page_template', $hwc_youth_phase_page_template);
        } else {
            // If the page exists, get its ID
            $hwc_youth_phase_page_id = $hwc_youth_phase_page->ID;
        }

        // Set the flag to indicate the youth_phase page was created
        update_option('hwc_youth_phase_page_created', true);
    } else {
        // If the youth_phase page creation was already done, just get its ID
        $hwc_youth_phase_page = get_page_by_path($hwc_youth_phase_page_slug);
        if ($hwc_youth_phase_page) {
            $hwc_youth_phase_page_id = $hwc_youth_phase_page->ID;
        }
    }

    /*--------------------------------------------------------------
        >>> Add Fields data in youth_phase page. 
    ----------------------------------------------------------------*/
    if (get_page_by_path($hwc_youth_phase_page_slug)) {
        // Register ACF fields for the youth_phase page
        if (function_exists('acf_add_local_field_group')) {
            acf_add_local_field_group(array(
                'key' => 'group_hwc_youth_phase_page',
                'title' => 'Youth Phase Page Fields',
                'fields' => array(
                    // FAQ Repeater
                    array(
                        'key' => 'hwc_youth_phase_faq_repeater_cards',
                        'label' => 'Our Youth Phase FAQ',
                        'name' => 'hwc_youth_phase_faq_repeater_cards',
                        'type' => 'repeater',
                        'sub_fields' => array(
                            array(
                                'key' => 'hwc_our_youth_phase_faq_title',
                                'label' => 'Title',
                                'name' => 'hwc_our_youth_phase_faq_title',
                                'type' => 'text',
                                'required' => 0,
                            ),
                            array(
                                'key' => 'hwc_our_youth_phase_faq_text',
                                'label' => 'Text',
                                'name' => 'hwc_our_youth_phase_faq_text',
                                'type' => 'wysiwyg',
                                'required' => 0,
                                'toolbar' => 'basic', // You can customize the toolbar (optional)
                                'media_upload' => 1, // Allow media upload (optional)
                            ),
                        ),
                        'min' => 0,
                        'layout' => 'block', // You can change to 'row' if preferred
                        'button_label' => 'Add Card',
                    ),
                    array(
                        'key' => 'hwc_youth_phase_voap_section_title',
                        'label' => 'View our other Academy Phases Title',
                        'name' => 'hwc_youth_phase_voap_section_title',
                        'type' => 'text',
                        'required' => 0,
                    ),
                    // Repeater for Youth Phase Cards
                    array(
                        'key' => 'hwc_youth_phase_repeater_cards',
                        'label' => 'View our other Academy Phases Repeater',
                        'name' => 'hwc_repeater_youth_phase_cards',
                        'type' => 'repeater',
                        'sub_fields' => array(
                            array(
                                'key' => 'hwc_youth_phase_card_title',
                                'label' => 'Title',
                                'name' => 'hwc_youth_phase_card_title',
                                'type' => 'text',
                                'required' => 1,
                            ),
                            array(
                                'key' => 'hwc_youth_phase_card_image',
                                'label' => 'Card Image',
                                'name' => 'hwc_youth_phase_card_image',
                                'type' => 'image',
                                'required' => 1,
                            ),
                            array(
                                'key' => 'hwc_youth_phase_card_button_link',
                                'label' => 'Button Link',
                                'name' => 'hwc_youth_phase_card_button_link',
                                'type' => 'link',
                                'required' => 0,
                            ),
                        ),
                        'min' => 0,
                        'layout' => 'block', // You can change to 'row' if preferred
                        'button_label' => 'Add Card',
                    ),
                    array(
                        'key' => 'hwc_youth_phase_section_title',
                        'label' => 'Academy Online Shop Title',
                        'name' => 'hwc_youth_phase_section_title',
                        'type' => 'text',
                        'required' => 0,
                    ),
                    array(
                        'key' => 'hwc_youth_phase_aos_button_link',
                        'label' => 'Button Link',
                        'name' => 'hwc_youth_phase_aos_button_link',
                        'type' => 'link',
                        'required' => 0,
                    ),
                    array(
                        'key' => 'hwc_youth_phase_aos_image',
                        'label' => 'Image',
                        'name' => 'hwc_youth_phase_aos_image',
                        'type' => 'image',
                        'required' => 0,
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'page',
                            'operator' => '==',
                            'value' => $hwc_youth_phase_page_id, // Replace with your Youth Phase page template
                        ),
                    ),
                ),
            ));
        }
    }

    /*--------------------------------------------------------------
        >>> Store Data
    ----------------------------------------------------------------*/
    if (!get_option('hwc_youth_phase_data_added', false)) {

        // Define the section title for the Youth Phase page with hwc_youth_phase_ prefix
        $hwc_youth_phase_voap_section_title = 'View our other Academy Phases';
        $hwc_youth_phase_section_title = 'Academy Online Shop';
        // Update the big box button link as an ACF Link field
        $hwc_youth_phase_aos_button_link = array(
            'url' => 'https://example.com/bigbox', // URL for the link
            'title' => 'Click here to browse the full range!', // Title for the link
            'target' => '_self' // Optional target attribute
        );

        // Update the ACF field for the Youth Phase section title with hwc_youth_phase_ prefix
        update_field('hwc_youth_phase_voap_section_title', $hwc_youth_phase_voap_section_title, $hwc_youth_phase_page_id);
        update_field('hwc_youth_phase_section_title', $hwc_youth_phase_section_title, $hwc_youth_phase_page_id);
        update_field('hwc_youth_phase_aos_button_link', $hwc_youth_phase_aos_button_link, $hwc_youth_phase_page_id);


        // Upload the image and get the attachment ID
        $hwc_youth_phase_aos_image_image_id = hwc_create_image_from_plugin('Hwest-County-vs-Shkendija-372.jpg', $hwc_youth_phase_page_id);

        if (!is_wp_error($hwc_youth_phase_aos_image_image_id)) {
            update_field('hwc_youth_phase_aos_image', $hwc_youth_phase_aos_image_image_id, $hwc_youth_phase_page_id);
        } else {
            error_log('Failed to upload image: ' . $hwc_youth_phase_aos_image_image_id->get_error_message());
        }

        // Manually define the Youth Phase page repeater data with hwc_youth_phase_ prefix
        // Dummy data for HWC Youth Phase Repeater Cards
        $hwc_youth_phase_repeater_data = array(
            array(
                'hwc_youth_phase_card_image' => 'hcafc-social.jpg', // Placeholder for Card 1
                'hwc_youth_phase_card_title' => 'About The Youth Phase',
                'hwc_youth_phase_card_link' => array(
                    'url' => 'https://example.com/2wish',
                    'title' => 'Read More',
                    'target' => '_self', // '_blank' for new tab
                ),
            ),
            array(
                'hwc_youth_phase_card_image' => 'hcafc-social.jpg', // Placeholder for Card 2
                'hwc_youth_phase_card_title' => 'News stories',
                'hwc_youth_phase_card_link' => array(
                    'url' => 'https://example.com/business-in-focus',
                    'title' => 'Read More',
                    'target' => '_self',
                ),
            ),
        );

        // Prepare final HWC Youth Phase Repeater Data with uploaded image IDs
        $final_youth_phase_repeater_data = array();

        foreach ($hwc_youth_phase_repeater_data as $hwc_youth_phase_repeater_single_data) {
            // Upload the image and get the attachment ID
            $hwc_youth_phase_card_image_id = hwc_create_image_from_plugin($hwc_youth_phase_repeater_single_data['hwc_youth_phase_card_image'], $hwc_youth_phase_page_id);

            if (!is_wp_error($hwc_youth_phase_card_image_id)) {
                $final_youth_phase_repeater_data[] = array(
                    'hwc_youth_phase_card_image' => $hwc_youth_phase_card_image_id, // Use the uploaded image ID
                    'hwc_youth_phase_card_title' => $hwc_youth_phase_repeater_single_data['hwc_youth_phase_card_title'],
                    'hwc_youth_phase_card_button_link' => $hwc_youth_phase_repeater_single_data['hwc_youth_phase_card_link'], // Correct format for ACF link field
                );
            } else {
                error_log('Failed to upload image: ' . $hwc_youth_phase_card_image_id->get_error_message());
            }
        }

        // Dummy data for Our Youth Phase FAQ Repeater Cards
        $hwc_youth_phase_faq_data = array(
            array(
                'hwc_our_youth_phase_faq_title' => 'Under-12s Fixtures (2023-24)',
                'hwc_our_youth_phase_faq_text' => '<p>August 13 – Haverfordwest County 3-5 Barry Town United</p>
                                                <p>August 20 – Briton Ferry Llansawel 6-1 Haverfordwest County</p>
                                                <p>August 27 – Llanelli Town (home) – Postponed</p>
                                                <p>September 10 – Merthyr Town (away)</p>
                                                <p>September 17 – Carmarthen Town (home)</p>
                                                <p>October 1 – Pen-y-Bont (home)</p>
                                                <p>October 8 – Cardiff Metropolitan (away)</p>
                                                <p>October 15 – Pontypridd United (home)</p>
                                                <p>October 22 – Cambrian and Clydach Vale (away)</p>
                                                <p>October 29 – Cambrian and Clydach Vale (home)</p>
                                                <p>November 5 – Pontypridd United (away)</p>
                                                <p>November 12 – Cardiff Metropolitan (home)</p>
                                                <p>November 19 – Pen-y-Bont (away)</p>
                                                <p>December 3 – Carmarthen Town (away)</p>
                                                <p>December 10 – Merthyr Town (home)</p>
                                                <p>January 14 – Llanelli Town (away)</p>
                                                <p>January 21 – Briton Ferry Llansawel (home)</p>
                                                <p>January 28 – Barry Town United (away)</p>
                                                <p>February 4 – Barry Town United (home)</p>
                                                <p>February 18 – Briton Ferry Llansawel (away)</p>
                                                <p>February 25 – Llanelli Town (home)</p>
                                                <p>March 10 – Merthyr Town (away)</p>
                                                <p>March 17 – Carmarthen Town (home)</p>
                                                <p>April 7 – Pen-y-Bont (home)</p>
                                                <p>April 14 – Cardiff Metropolitan (away)</p>
                                                <p>April 21 – Pontypridd United (home)</p>
                                                <p>April 28 – Cambrian and Clydach Vale (away)</p>',
            ),
            array(
                'hwc_our_youth_phase_faq_title' => 'Under-13s Fixtures (2023-24)',
                'hwc_our_youth_phase_faq_text' => '<p>August 13 – Haverfordwest County 2-8 Barry Town United</p>
                                                <p>August 20 – Briton Ferry Llansawel 7-1 Haverfordwest County</p>
                                                <p>August 27 – Haverfordwest County 4-0 Llanelli Town</p>
                                                <p>September 10 – Pontardawe Town (away)</p>
                                                <p>September 17 – Carmarthen Town (home)</p>
                                                <p>October 1 – Pen-y-Bont (home)</p>
                                                <p>October 8 – Cardiff Metropolitan (away)</p>
                                                <p>October 15 – Pontypridd United (home)</p>
                                                <p>October 22 – Cambrian and Clydach Vale (away)</p>
                                                <p>October 29 – Cambrian and Clydach Vale (home)</p>
                                                <p>November 5 – Pontypridd United (away)</p>
                                                <p>November 12 – Cardiff Metropolitan (home)</p>
                                                <p>November 19 – Pen-y-Bont (away)</p>
                                                <p>December 3 – Carmarthen Town (away)</p>
                                                <p>December 10 – Pontardawe Town (home)</p>
                                                <p>January 14 – Llanelli Town (away)</p>
                                                <p>January 21 – Briton Ferry Llansawel (home)</p>
                                                <p>January 28 – Barry Town United (away)</p>
                                                <p>February 4 – Barry Town United (home)</p>
                                                <p>February 18 – Briton Ferry Llansawel (away)</p>
                                                <p>February 25 – Llanelli Town (home)</p>
                                                <p>March 10 – Pontardawe Town (away)</p>
                                                <p>March 17 – Carmarthen Town (home)</p>
                                                <p>April 7 – Pen-y-Bont (home)</p>
                                                <p>April 14 – Cardiff Metropolitan (away)</p>
                                                <p>April 21 – Pontypridd United (home)</p>
                                                <p>April 28 – Cambrian and Clydach Vale (away)</p>',
            ),
        );

        // Prepare final Our Youth Phase FAQ Repeater Data
        $final_youth_phase_faq_data = array();

        foreach ($hwc_youth_phase_faq_data as $hwc_youth_phase_faq_single_data) {
            $final_youth_phase_faq_data[] = array(
                'hwc_our_youth_phase_faq_title' => $hwc_youth_phase_faq_single_data['hwc_our_youth_phase_faq_title'],
                'hwc_our_youth_phase_faq_text' => $hwc_youth_phase_faq_single_data['hwc_our_youth_phase_faq_text'],
            );
        }

        // Now, you can update the ACF fields with the final prepared data
        update_field('hwc_repeater_youth_phase_cards', $final_youth_phase_repeater_data, $hwc_youth_phase_page_id);
        update_field('hwc_youth_phase_faq_repeater_cards', $final_youth_phase_faq_data, $hwc_youth_phase_page_id);

        // After the function has run, set the option to true
        update_option('hwc_youth_phase_data_added', true);
    }
}
//end