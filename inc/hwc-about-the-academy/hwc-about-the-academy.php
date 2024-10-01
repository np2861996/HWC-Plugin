<?php

/**
 * Code For About The Academy Page.
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hwc
 */

/*--------------------------------------------------------------
	>>> All Action and Filter Functions
----------------------------------------------------------------*/
add_action('acf/init', 'hwc_create_about_the_academy_page_with_acf_fields');

/*--------------------------------------------------------------
	>>> Function for Add ACF Fields for results
----------------------------------------------------------------*/
function hwc_create_about_the_academy_page_with_acf_fields()
{
    /*--------------------------------------------------------------
        >>> Add page with Template 
    ----------------------------------------------------------------*/
    // Set variables for the about-the-academy page
    $hwc_about_the_academy_page_title = 'About The Academy';
    $hwc_about_the_academy_page_slug = 'about-the-academy';
    $hwc_about_the_academy_page_template = 'template-parts/template-about-the-academy.php';

    // Check if the about-the-academy page exists
    $hwc_about_the_academy_page = get_page_by_path($hwc_about_the_academy_page_slug);

    if (!$hwc_about_the_academy_page) {
        // Create the about-the-academy page if it doesn't exist
        $hwc_about_the_academy_page_data = array(
            'post_title'    => $hwc_about_the_academy_page_title,
            'post_content'  => '<p>Our thriving academy, which encompasses 10 teams ranging from under-8s to under-19s, promotes and provides the best possible environment for young players to develop and flourish. We also recently established both a Pre-Academy age group and an FAW Girls Development Centre.</p>
<p>All of our academy coaches, who oversee the development of up to 160 players, hold the necessary FAW and UEFA coaching qualifications, as well as meeting child protection and first aid legislations.</p>
<p>As well as priding itself on being a family-run academy which strives to develop good people as well as good players, it also has strong evidence to show that the club has a proven track record of providing a clear pathway for players to progress through to our first team.</p>',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_name'     => $hwc_about_the_academy_page_slug,
            'page_template' => $hwc_about_the_academy_page_template
        );
        $hwc_about_the_academy_page_id = wp_insert_post($hwc_about_the_academy_page_data);

        // Set the page template
        update_post_meta($hwc_about_the_academy_page_id, '_wp_page_template', $hwc_about_the_academy_page_template);
    } else {
        // If the page exists, get its ID
        $hwc_about_the_academy_page_id = $hwc_about_the_academy_page->ID;
    }

    /*--------------------------------------------------------------
        >>> Add Fields data in about-the-academy page. 
    ----------------------------------------------------------------*/
    // Register ACF fields for the about-the-academy page
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_hwc_about_the_academy_page',
            'title' => 'About The Academy Page Fields',
            'fields' => array(
                // Section Title for About The Academy Page
                array(
                    'key' => 'hwc_about_the_academy_section_title',
                    'label' => 'HWC About The Academy Section Title',
                    'name' => 'hwc_about_the_academy_section_title',
                    'type' => 'text',
                    'required' => 0,
                ),
                array(
                    'key' => 'hwc_about_the_academy_card_button_link',
                    'label' => 'HWC Button Link',
                    'name' => 'hwc_about_the_academy_button_link',
                    'type' => 'link',
                    'required' => 0,
                ),
                array(
                    'key' => 'hwc_about_the_academy_card_image',
                    'label' => 'HWC Card Image',
                    'name' => 'hwc_about_the_academy_card_image',
                    'type' => 'image',
                    'required' => 1,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'page',
                        'operator' => '==',
                        'value' => $hwc_about_the_academy_page_id, // Replace with your About The Academy page template
                    ),
                ),
            ),
        ));
    }

    /*--------------------------------------------------------------
        >>> Store Data
    ----------------------------------------------------------------*/
    if (!get_option('hwc_about_the_academy_data_added', false)) {
        // Define the section title for the About The Academy page with hwc_about_the_academy_ prefix
        $hwc_about_the_academy_section_title = 'Academy Online Shop'; // Adjust the title as needed

        // Update the ACF field for the About The Academy section title with hwc_about_the_academy_ prefix
        update_field('hwc_about_the_academy_section_title', $hwc_about_the_academy_section_title, $hwc_about_the_academy_page_id);
        $about_the_academy_image_id = hwc_create_image_from_plugin('48HFC290605_PartnershipAnnouncement_TorSports1920x1080.jpg', $hwc_about_the_academy_page_id);
        update_field('hwc_about_the_academy_card_image', $about_the_academy_image_id, $hwc_about_the_academy_page_id);

        // Define the link data
        $link_data = array(
            'url'   => 'https://example.com',     // The link URL
            'title' => 'Visit Example',            // The link text
            'target' => '_blank'                   // Optional: '_blank' to open in a new tab
        );
        update_field('hwc_about_the_academy_button_link', $link_data, $hwc_about_the_academy_page_id);

        update_option('hwc_about_the_academy_data_added', true);
    }
}
//end