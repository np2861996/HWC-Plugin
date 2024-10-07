<?php

/**
 * Code For Academy Page.
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hwc
 */

/*--------------------------------------------------------------
	>>> All Action and Filter Functions
----------------------------------------------------------------*/
add_action('acf/init', 'hwc_create_academy_page_with_acf_fields');

/*--------------------------------------------------------------
	>>> Function for Add ACF Fields for results
----------------------------------------------------------------*/
function hwc_create_academy_page_with_acf_fields()
{
    /*--------------------------------------------------------------
        >>> Add page with Template 
    ----------------------------------------------------------------*/
    // Check if the Academy page creation has already been run
    $academy_page_created = get_option('hwc_academy_page_created');

    // Set variables for the academy page
    $hwc_academy_page_title = 'Haverfordwest County AFC Academy';
    $hwc_academy_page_slug = 'academy';
    $hwc_academy_page_template = 'template-parts/template-academy.php';

    if (!$academy_page_created) {
        // Check if the academy page exists
        $hwc_academy_page = get_page_by_path($hwc_academy_page_slug);

        if (!$hwc_academy_page) {
            // Create the academy page if it doesn't exist
            $hwc_academy_page_data = array(
                'post_title'    => $hwc_academy_page_title,
                'post_content'  => 'Providing the best possible environment for young players to develop and flourish in Pembrokeshire.',
                'post_status'   => 'publish',
                'post_type'     => 'page',
                'post_name'     => $hwc_academy_page_slug,
                'page_template' => $hwc_academy_page_template
            );
            $hwc_academy_page_id = wp_insert_post($hwc_academy_page_data);

            // Set the page template
            update_post_meta($hwc_academy_page_id, '_wp_page_template', $hwc_academy_page_template);
        } else {
            // If the page exists, get its ID
            $hwc_academy_page_id = $hwc_academy_page->ID;
        }

        // Set the flag to indicate the Academy page was created
        update_option('hwc_academy_page_created', true);
    } else {
        // If the Academy page creation was already done, just get its ID
        $hwc_academy_page = get_page_by_path($hwc_academy_page_slug);
        if ($hwc_academy_page) {
            $hwc_academy_page_id = $hwc_academy_page->ID;
        }
    }


    /*--------------------------------------------------------------
        >>> Add Fields data in academy page. 
    ----------------------------------------------------------------*/
    if (get_page_by_path($hwc_academy_page_slug)) {
        // Register ACF fields for the academy page
        if (function_exists('acf_add_local_field_group')) {
            acf_add_local_field_group(array(
                'key' => 'group_hwc_academy_page',
                'title' => 'Academy Page Fields',
                'fields' => array(
                    // Section Title for Academy Page
                    // Repeater for Academy Cards
                    array(
                        'key' => 'hwc_academy_repeater_cards',
                        'label' => 'Academy Cards Repeater',
                        'name' => 'hwc_repeater_academy_cards',
                        'type' => 'repeater',
                        'sub_fields' => array(
                            array(
                                'key' => 'hwc_academy_card_title',
                                'label' => 'Title',
                                'name' => 'hwc_academy_card_title',
                                'type' => 'text',
                                'required' => 1,
                            ),
                            array(
                                'key' => 'hwc_academy_card_image',
                                'label' => 'Card Image',
                                'name' => 'hwc_academy_card_image',
                                'type' => 'image',
                                'required' => 1,
                            ),
                            array(
                                'key' => 'hwc_academy_card_button_link',
                                'label' => 'Button Link',
                                'name' => 'hwc_academy_card_button_link',
                                'type' => 'link',
                                'required' => 0,
                            ),
                        ),
                        'min' => 0,
                        'layout' => 'block', // You can change to 'row' if preferred
                        'button_label' => 'Add Card',
                    ),
                    array(
                        'key' => 'hwc_academy_section_title_1',
                        'label' => 'HWC Academy Section Title 1',
                        'name' => 'hwc_academy_section_title_1',
                        'type' => 'text',
                        'required' => 0,
                    ),
                    array(
                        'key' => 'hwc_our_academy_phases_repeater_cards',
                        'label' => 'Our Academy Phases Repeater',
                        'name' => 'hwc_repeater_our_academy_phases_cards',
                        'type' => 'repeater',
                        'sub_fields' => array(
                            array(
                                'key' => 'hwc_our_academy_phases_card_title',
                                'label' => 'Title',
                                'name' => 'hwc_our_academy_phases_card_title',
                                'type' => 'text',
                                'required' => 1,
                            ),
                            array(
                                'key' => 'hwc_our_academy_phases_card_image',
                                'label' => 'Card Image',
                                'name' => 'hwc_our_academy_phases_card_image',
                                'type' => 'image',
                                'required' => 1,
                            ),
                            array(
                                'key' => 'hwc_our_academy_phases_card_button_link',
                                'label' => 'Button Link',
                                'name' => 'hwc_our_academy_phases_card_button_link',
                                'type' => 'link',
                                'required' => 0,
                            ),
                        ),
                        'min' => 0,
                        'layout' => 'block', // You can change to 'row' if preferred
                        'button_label' => 'Add Card',
                    ),
                    array(
                        'key' => 'hwc_academy_section_youtube_url',
                        'label' => 'Youtube URL',
                        'name' => 'hwc_academy_section_youtube_url',
                        'type' => 'url',
                        'required' => 0,
                    ),
                    array(
                        'key' => 'hwc_academy_select_team',
                        'label' => 'Select Team',
                        'name' => 'hwc_academy_select_team',
                        'type' => 'post_object',
                        'post_type' => array('team'),
                        'return_format' => 'id',
                        'multiple' => 0,
                        'required' => 0,
                    ),
                    array(
                        'key' => 'hwc_academy_faq_repeater_cards',
                        'label' => 'Our Academy FAQ',
                        'name' => 'hwc_academy_faq_repeater_cards',
                        'type' => 'repeater',
                        'sub_fields' => array(
                            array(
                                'key' => 'hwc_our_academy_faq_title',
                                'label' => 'Title',
                                'name' => 'hwc_our_academy_faq_title',
                                'type' => 'text',
                                'required' => 0,
                            ),
                            array(
                                'key' => 'hwc_our_academy_faq_text',
                                'label' => 'Text',
                                'name' => 'hwc_our_academy_faq_text',
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
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'page',
                            'operator' => '==',
                            'value' => $hwc_academy_page_id, // Replace with your Academy page template
                        ),
                    ),
                ),
            ));
        }
    }

    /*--------------------------------------------------------------
        >>> Store Data
    ----------------------------------------------------------------*/
    if (!get_option('hwc_academy_data_added', false)) {

        $academy_page_image_id = hwc_create_image_from_plugin('K336021-scaled-1.jpg', $hwc_academy_page_id);
        if ($academy_page_image_id) {
            set_post_thumbnail($hwc_academy_page_id, $academy_page_image_id);
        } else {
            error_log('Failed to set featured image for Contact Page');
        }

        // Define the section title for the Academy page with hwc_academy_ prefix
        $hwc_academy_section_title_1 = 'Academy News';
        $hwc_academy_section_youtube_url = 'https://www.youtube.com/embed/14cougZx09s'; // Adjust the title as needed

        // Update the ACF field for the Academy section title with hwc_academy_ prefix
        update_field('hwc_academy_section_title_1', $hwc_academy_section_title_1, $hwc_academy_page_id);
        update_field('hwc_academy_section_youtube_url', $hwc_academy_section_youtube_url, $hwc_academy_page_id);
        update_field('hwc_academy_select_team', hwc_get_team_id_by_name('Haverfordwest County'), $hwc_academy_page_id);

        // Manually define the Academy page repeater data with hwc_academy_ prefix
        // Dummy data for HWC Academy Repeater Cards
        $hwc_academy_repeater_data = array(
            array(
                'hwc_academy_card_image' => 'hcafc-social.jpg', // Placeholder for Card 1
                'hwc_academy_card_title' => 'About The Academy',
                'hwc_academy_card_link' => array(
                    'url' => 'https://example.com/2wish',
                    'title' => 'Read More',
                    'target' => '_self', // '_blank' for new tab
                ),
            ),
            array(
                'hwc_academy_card_image' => 'hcafc-social.jpg', // Placeholder for Card 2
                'hwc_academy_card_title' => 'News stories',
                'hwc_academy_card_link' => array(
                    'url' => 'https://example.com/business-in-focus',
                    'title' => 'Read More',
                    'target' => '_self',
                ),
            ),
        );

        // Prepare final HWC Academy Repeater Data with uploaded image IDs
        $final_academy_repeater_data = array();

        foreach ($hwc_academy_repeater_data as $hwc_academy_repeater_single_data) {
            // Upload the image and get the attachment ID
            $hwc_academy_card_image_id = hwc_create_image_from_plugin($hwc_academy_repeater_single_data['hwc_academy_card_image'], $hwc_academy_page_id);

            if (!is_wp_error($hwc_academy_card_image_id)) {
                $final_academy_repeater_data[] = array(
                    'hwc_academy_card_image' => $hwc_academy_card_image_id, // Use the uploaded image ID
                    'hwc_academy_card_title' => $hwc_academy_repeater_single_data['hwc_academy_card_title'],
                    'hwc_academy_card_button_link' => $hwc_academy_repeater_single_data['hwc_academy_card_link'], // Correct format for ACF link field
                );
            } else {
                error_log('Failed to upload image: ' . $hwc_academy_card_image_id->get_error_message());
            }
        }

        // Dummy data for Our Academy Phases Repeater Cards
        $hwc_our_academy_phases_data = array(
            array(
                'hwc_our_academy_phases_card_image' => 'hcafc-social.jpg', // Placeholder for Phase 1
                'hwc_our_academy_phases_card_title' => 'Foundation Phase',
                'hwc_our_academy_phases_card_button_link' => array(
                    'url' => 'https://example.com/phase1',
                    'title' => 'Join Now',
                    'target' => '_self',
                ),
            ),
            array(
                'hwc_our_academy_phases_card_image' => 'hcafc-social.jpg', // Placeholder for Phase 2
                'hwc_our_academy_phases_card_title' => 'Youth Phase',
                'hwc_our_academy_phases_card_button_link' => array(
                    'url' => 'https://example.com/phase2',
                    'title' => 'Join Now',
                    'target' => '_self',
                ),
            ),
        );

        // Prepare final Our Academy Phases Repeater Data with uploaded image IDs
        $final_our_academy_phases_data = array();

        foreach ($hwc_our_academy_phases_data as $hwc_our_academy_phases_single_data) {
            // Upload the image and get the attachment ID
            $hwc_our_academy_phases_image_id = hwc_create_image_from_plugin($hwc_our_academy_phases_single_data['hwc_our_academy_phases_card_image'], $hwc_academy_page_id);

            if (!is_wp_error($hwc_our_academy_phases_image_id)) {
                $final_our_academy_phases_data[] = array(
                    'hwc_our_academy_phases_card_image' => $hwc_our_academy_phases_image_id, // Use the uploaded image ID
                    'hwc_our_academy_phases_card_title' => $hwc_our_academy_phases_single_data['hwc_our_academy_phases_card_title'],
                    'hwc_our_academy_phases_card_button_link' => $hwc_our_academy_phases_single_data['hwc_our_academy_phases_card_button_link'], // Correct format for ACF link field
                );
            } else {
                error_log('Failed to upload image: ' . $hwc_our_academy_phases_image_id->get_error_message());
            }
        }

        // Dummy data for Our Academy FAQ Repeater Cards
        $hwc_academy_faq_data = array(
            array(
                'hwc_our_academy_faq_title' => 'Haverfordwest County AFC Academy Graduates',
                'hwc_our_academy_faq_text' => '<p>Alfie Stotter (<strong>Debut: </strong>Carmarthen Town – March 19, 2016)</p>
                                            <p>Leon Luby (<strong>Debut: </strong>Pen-y-Bont – September 18, 2016)</p>
                                            <p>Nicolas Jones (<strong>Debut: </strong>Caldicot Town – April 15, 2017)</p>
                                            <p>Charlie Davies (<strong>Debut: </strong>Port Talbot Town – August 13, 2017)</p>
                                            <p>Alaric Jones (<strong>Debut: </strong>Port Talbot Town – August 13, 2017)</p>
                                            <p>Luke Raymond (<strong>Debut: </strong>Tredegar Town – August 17, 2017)</p>
                                            <p>Paul Miller (<strong>Debut:&nbsp;</strong>Undy Athletic – September 9, 2017)</p>
                                            <p>Fraser Finlay (<strong>Debut:&nbsp;</strong>Caerau Ely – November 18, 2017)</p>
                                            <p>Jimmy Wilkes (<strong>Debut:&nbsp;</strong>Pontypridd Town – December 2, 2017)</p>
                                            <p>Curtis Hicks (<strong>Debut:&nbsp;</strong>Llanelli Town – August 29, 2018)</p>
                                            <p>Joe Pritchard (<strong>Debut:&nbsp;</strong>Pen-y-Bont – February 20, 2018)</p>
                                            <p>Ben Fawcett (<strong>Debut:&nbsp;</strong>Llantwit Major – August 11, 2018)</p>
                                            <p>Jack Wilson (<strong>Debut:&nbsp;</strong>Llantwit Major – August 11, 2018)</p>
                                            <p>Jake Merry (<strong>Debut:&nbsp;</strong>Bala Town – January 27, 2019)</p>
                                            <p>Gareth Finnegan (<strong>Debut:&nbsp;</strong>Bala Town – January 27, 2019)</p>
                                            <p>Seamus Drake (<strong>Debut:&nbsp;</strong>Taff’s Well – April 16, 2019)</p>
                                            <p>Max Howells (<strong>Debut:&nbsp;</strong>Taff’s Well – April 16, 2019)</p>
                                            <p>Ryan Hughes (<strong>Debut:&nbsp;</strong>STM Sports – October 1, 2019)</p>
                                            <p>Daniel James (<strong>Debut:&nbsp;</strong>Newtown – April 17, 2021)</p>
                                            <p>Iori Humphreys (<strong>Debut:&nbsp;</strong>Undy Athletic – September 21, 2021)</p>
                                            <p>Lucas Davies (<strong>Debut:&nbsp;</strong>Flint Town United – December 4, 2021)</p>
                                            <p>Harri John (<strong>Debut:&nbsp;</strong>Caernarfon Town – September 17, 2022)</p>
                                            <p>John Chesters (<strong>Debut:&nbsp;</strong>Airbus UK Broughton – April 22, 2023)</p>
                                            <p>Seth Woodhouse (<strong>Debut:&nbsp;</strong>Airbus UK Broughton – April 22, 2023)</p>',
            ),
        );

        // Prepare final Our Academy FAQ Repeater Data
        $final_academy_faq_data = array();

        foreach ($hwc_academy_faq_data as $hwc_academy_faq_single_data) {
            $final_academy_faq_data[] = array(
                'hwc_our_academy_faq_title' => $hwc_academy_faq_single_data['hwc_our_academy_faq_title'],
                'hwc_our_academy_faq_text' => $hwc_academy_faq_single_data['hwc_our_academy_faq_text'],
            );
        }

        // Now, you can update the ACF fields with the final prepared data
        update_field('hwc_repeater_academy_cards', $final_academy_repeater_data, $hwc_academy_page_id);
        update_field('hwc_repeater_our_academy_phases_cards', $final_our_academy_phases_data, $hwc_academy_page_id);
        update_field('hwc_academy_faq_repeater_cards', $final_academy_faq_data, $hwc_academy_page_id);

        // After the function has run, set the option to true
        update_option('hwc_academy_data_added', true);
    }
}
//end