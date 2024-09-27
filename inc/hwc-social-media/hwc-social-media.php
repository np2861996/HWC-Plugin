<?php

/**
 * Code For Social Media Page.
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hwc
 */

/*--------------------------------------------------------------
	>>> All Action and Filter Functions
----------------------------------------------------------------*/
add_action('acf/init', 'hwc_create_social_media_page_with_acf_fields');

/*--------------------------------------------------------------
	>>> Function for Add ACF Fields for results
----------------------------------------------------------------*/
function hwc_create_social_media_page_with_acf_fields()
{
    /*--------------------------------------------------------------
        >>> Add page with Template 
    ----------------------------------------------------------------*/
    // Set variables for the social-media page
    $hwc_social_media_page_title = 'Social Media';
    $hwc_social_media_page_slug = 'social-media';
    $hwc_social_media_page_template = 'template-parts/template-social-media.php';

    // Check if the social-media page exists
    $hwc_social_media_page = get_page_by_path($hwc_social_media_page_slug);

    if (!$hwc_social_media_page) {
        // Create the social-media page if it doesn't exist
        $hwc_social_media_page_data = array(
            'post_title'    => $hwc_social_media_page_title,
            'post_content'  => '<p><strong>Haverfordwest County AFC’s official social media channels are the best place to go if you want to keep up to date with all the goings on at the Ogi Bridge Meadow Stadium.</strong></p>
<p>Make sure you’re following us for all of the latest news, interviews, match highlights, behind-the-scenes and feature content, which includes our club documentary and club podcast series, You Can Have It All and The Bluebirds Nest.</p>
<p>Please click on the various social media links below to be directed to the respective platforms:</p>',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_name'     => $hwc_social_media_page_slug,
            'page_template' => $hwc_social_media_page_template
        );
        $hwc_social_media_page_id = wp_insert_post($hwc_social_media_page_data);

        // Set the page template
        update_post_meta($hwc_social_media_page_id, '_wp_page_template', $hwc_social_media_page_template);
    } else {
        // If the page exists, get its ID
        $hwc_social_media_page_id = $hwc_social_media_page->ID;
    }

    /*--------------------------------------------------------------
        >>> Add Fields data in social-media page. 
    ----------------------------------------------------------------*/
    // Register ACF fields for the social-media page
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_hwc_social_media_page',
            'title' => 'Social Media Page Fields',
            'fields' => array(
                // Section Title for Social Media Page
                array(
                    'key' => 'hwc_social_media_section_title_1',
                    'label' => 'HWC Social Media Section Title 1',
                    'name' => 'hwc_social_media_section_title_1',
                    'type' => 'text',
                    'required' => 0,
                ),
                array(
                    'key' => 'hwc_social_media_section_title_2',
                    'label' => 'HWC Social Media Section Title 2',
                    'name' => 'hwc_social_media_section_title_2',
                    'type' => 'text',
                    'required' => 0,
                ),
                array(
                    'key' => 'hwc_social_media_button_link',
                    'label' => 'Button Link',
                    'name' => 'hwc_social_media_button_link',
                    'type' => 'link',
                    'required' => 0,
                ),
                array(
                    'key' => 'hwc_social_media_bg_image',
                    'label' => 'Background Image',
                    'name' => 'hwc_social_media_bg_image',
                    'type' => 'image',
                    'required' => 0,
                ),
                // Repeater for Social Media Cards
                array(
                    'key' => 'hwc_social_media_repeater_cards',
                    'label' => 'HWC Social Media Cards Repeater',
                    'name' => 'hwc_repeater_social_media_cards',
                    'type' => 'repeater',
                    'sub_fields' => array(
                        array(
                            'key' => 'hwc_social_media_card_title',
                            'label' => 'HWC Card Title',
                            'name' => 'hwc_social_media_card_title',
                            'type' => 'text',
                            'required' => 1,
                        ),
                        array(
                            'key' => 'hwc_social_media_card_image',
                            'label' => 'HWC Card Image',
                            'name' => 'hwc_social_media_card_image',
                            'type' => 'image',
                            'required' => 1,
                        ),
                        array(
                            'key' => 'hwc_social_media_card_button_link',
                            'label' => 'HWC Button Link',
                            'name' => 'hwc_social_media_card_button_link',
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
                        'value' => $hwc_social_media_page_id, // Replace with your Social Media page template
                    ),
                ),
            ),
        ));
    }

    /*--------------------------------------------------------------
        >>> Store Data
    ----------------------------------------------------------------*/
    //if (!get_option('hwc_social_media_data_added', false)) {
    // Define the section title for the Social Media page with hwc_social_media_ prefix
    $hwc_social_media_section_title_1 = 'Social Media'; // Adjust the title as needed
    $hwc_social_media_section_title_2 = 'Keep up to date by following us across all of our social media platforms!';
    // Define the link data
    $hwc_social_media_link_data = array(
        'url'   => 'https://example.com',     // The link URL
        'title' => 'Visit Example',            // The link text
        'target' => '_blank'                   // Optional: '_blank' to open in a new tab
    );
    $social_media_image_id = hwc_create_image_from_plugin('48HFC290605_PartnershipAnnouncement_TorSports1920x1080.jpg', $hwc_social_media_page_id);
    update_field('hwc_social_media_bg_image', $social_media_image_id, $hwc_social_media_page_id);

    // Update the ACF field for the Social Media section title with hwc_social_media_ prefix
    update_field('hwc_social_media_section_title_1', $hwc_social_media_section_title_1, $hwc_social_media_page_id);
    update_field('hwc_social_media_section_title_2', $hwc_social_media_section_title_2, $hwc_social_media_page_id);
    update_field('hwc_social_media_button_link', $hwc_social_media_link_data, $hwc_social_media_page_id);

    // Manually define the Social Media page repeater data with hwc_social_media_ prefix
    $hwc_social_media_repeater_data = array(
        array(
            'hwc_social_media_card_image' => 'fb_1695273515215_1695273522698.jpg', // Placeholder for Card 1
            'hwc_social_media_card_title' => 'Facebook',
            'hwc_social_media_card_link' => array(
                'url' => 'https://example.com',
                'title' => 'Read More',
                'target' => '_self', // '_blank' for new tab
            ),
        ),
        array(
            'hwc_social_media_card_image' => 'ezgif.com-webp-to-jpg-3.jpg', // Placeholder for Card 2
            'hwc_social_media_card_title' => 'X (formerly Twitter)',
            'hwc_social_media_card_link' => array(
                'url' => 'https://example.com',
                'title' => 'Read More',
                'target' => '_self',
            ),
        ),
        array(
            'hwc_social_media_card_image' => '1200x630wa.jpg', // Placeholder for Card 3
            'hwc_social_media_card_title' => 'Instagram',
            'hwc_social_media_card_link' => array(
                'url' => 'https://example.com',
                'title' => 'Read More',
                'target' => '_self',
            ),
        ),

        array(
            'hwc_social_media_card_image' => 'H2x1_NSwitchDS_YouTube.jpg', // Placeholder for Card 3
            'hwc_social_media_card_title' => 'YouTube',
            'hwc_social_media_card_link' => array(
                'url' => 'https://example.com',
                'title' => 'Read More',
                'target' => '_self',
            ),
        ),
        array(
            'hwc_social_media_card_image' => 'tiktoklogo.jpg', // Placeholder for Card 3
            'hwc_social_media_card_title' => 'TikTok',
            'hwc_social_media_card_link' => array(
                'url' => 'https://example.com',
                'title' => 'Read More',
                'target' => '_self',
            ),
        ),
        array(
            'hwc_social_media_card_image' => 'linkedinlogo.jpg', // Placeholder for Card 3
            'hwc_social_media_card_title' => 'LinkedIn',
            'hwc_social_media_card_link' => array(
                'url' => 'https://example.com',
                'title' => 'Read More',
                'target' => '_self',
            ),
        ),
    );

    // Prepare the final repeater data with uploaded image IDs
    $final_social_media_repeater_data = array();

    foreach ($hwc_social_media_repeater_data as $hwc_social_media_repeater_single_data) {
        // Upload the image and get the attachment ID
        $hwc_social_media_card_image_id = hwc_create_image_from_plugin($hwc_social_media_repeater_single_data['hwc_social_media_card_image'], $hwc_social_media_page_id);

        if (!is_wp_error($hwc_social_media_card_image_id)) {
            $final_social_media_repeater_data[] = array(
                'hwc_social_media_card_image' => $hwc_social_media_card_image_id, // Use the uploaded image ID with hwc_social_media_ prefix
                'hwc_social_media_card_title' => $hwc_social_media_repeater_single_data['hwc_social_media_card_title'],
                'hwc_social_media_card_button_link' => $hwc_social_media_repeater_single_data['hwc_social_media_card_link'], // Correct format for ACF link field
            );
        } else {
            error_log('Failed to upload image: ' . $hwc_social_media_card_image_id->get_error_message());
        }
    }

    // Update the ACF repeater field for the Social Media page with the structured array
    update_field('hwc_repeater_social_media_cards', $final_social_media_repeater_data, $hwc_social_media_page_id);
    // After the function has run, set the option to true
    //update_option('hwc_social_media_data_added', true);
    //}
}
//end