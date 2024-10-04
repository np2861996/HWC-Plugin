<?php

/**
 * Code For Footer Options Page.
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hwc
 */

/*--------------------------------------------------------------
	>>> All Action and Filter Functions
----------------------------------------------------------------*/
add_action('acf/init', 'hwc_initialize_footer_settings');

/*--------------------------------------------------------------
>>> Add options page
----------------------------------------------------------------*/
if (function_exists('acf_add_options_page')) {

    // Add footer options page
    acf_add_options_page(array(
        'page_title' => 'Footer Settings',
        'menu_title' => 'Footer Settings',
        'menu_slug' => 'footer-settings',
        'capability' => 'edit_posts',
        'redirect' => false
    ));
}

/*--------------------------------------------------------------
>>> Add Footer options page data
----------------------------------------------------------------*/
// Function to initialize footer settings
function hwc_initialize_footer_settings()
{
    // Check if the ACF function exists
    if (function_exists('acf_add_local_field_group')) {
        // Footer Settings Fields
        acf_add_local_field_group(array(
            'key' => 'group_footer_settings',
            'title' => 'Footer Settings',
            'fields' => array(
                // Official Partners Repeater
                array(
                    'key' => 'footer_official_partners',
                    'label' => 'Official Partners',
                    'name' => 'footer_official_partners',
                    'type' => 'repeater',
                    'sub_fields' => array(
                        array(
                            'key' => 'partner_image',
                            'label' => 'Partner Image',
                            'name' => 'partner_image',
                            'type' => 'image',
                            'return_format' => 'url',
                            'preview_size' => 'medium',
                            'library' => 'all',
                        ),
                        array(
                            'key' => 'partner_link',
                            'label' => 'Partner Link',
                            'name' => 'partner_link',
                            'type' => 'url',
                        ),
                    ),
                    'min' => 0,
                    'layout' => 'block',
                    'button_label' => 'Add Partner',
                ),
                // Address
                array(
                    'key' => 'footer_address',
                    'label' => 'Address',
                    'name' => 'footer_address',
                    'type' => 'textarea',
                    'required' => 0,
                ),
                // Link Button
                array(
                    'key' => 'footer_link_button',
                    'label' => 'Link Button',
                    'name' => 'footer_link_button',
                    'type' => 'link',
                    'required' => 0,
                ),
                // Bottom Text
                array(
                    'key' => 'footer_bottom_text',
                    'label' => 'Bottom Text',
                    'name' => 'footer_bottom_text',
                    'type' => 'text',
                    'required' => 0,
                ),
                // Social Media Links
                array(
                    'key' => 'footer_social_media',
                    'label' => 'Follow Us',
                    'name' => 'footer_social_media',
                    'type' => 'group',
                    'sub_fields' => array(
                        array(
                            'key' => 'footer_twitter',
                            'label' => 'Twitter/X URL',
                            'name' => 'footer_twitter',
                            'type' => 'url',
                            'required' => 0,
                        ),
                        array(
                            'key' => 'footer_facebook',
                            'label' => 'Facebook URL',
                            'name' => 'footer_facebook',
                            'type' => 'url',
                            'required' => 0,
                        ),
                        array(
                            'key' => 'footer_instagram',
                            'label' => 'Instagram URL',
                            'name' => 'footer_instagram',
                            'type' => 'url',
                            'required' => 0,
                        ),
                        array(
                            'key' => 'footer_youtube',
                            'label' => 'YouTube URL',
                            'name' => 'footer_youtube',
                            'type' => 'url',
                            'required' => 0,
                        ),
                        array(
                            'key' => 'footer_tiktok',
                            'label' => 'TikTok URL',
                            'name' => 'footer_tiktok',
                            'type' => 'url',
                            'required' => 0,
                        ),
                        array(
                            'key' => 'footer_linkedin',
                            'label' => 'LinkedIn URL',
                            'name' => 'footer_linkedin',
                            'type' => 'url',
                            'required' => 0,
                        ),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'footer-settings', // Slug of your footer settings options page
                    ),
                ),
            ),
        ));
    }

    // Check if footer data has already been added
    if (!get_option('hwc_footer_data_added', false)) {
        $hwc_footer_partners = array(
            array(
                'partner_image' => hwc_create_image_from_plugin('GELLI-MOR-PRINT_Colour.png'), // Replace with your image URL
                'partner_link' => 'https://example.com/partner1'
            ),
            array(
                'partner_image' => hwc_create_image_from_plugin('PembrokeshireCollege.png'),
                'partner_link' =>  'https://example.com/partner2'
            ),
        );

        // Update the repeater field with the footer partners
        update_field('footer_official_partners', $hwc_footer_partners, 'option');

        // Update the address
        update_field('footer_address', '<p class="address"><span itemprop="name" class="address-name">Ogi Bridge Meadow Stadium</span> <span itemprop="streetAddress" class="address-two">Bridge Meadow Lane</span> <span itemprop="addressLocality" class="address-locality">Haverfordwest</span> <span itemprop="addressRegion" class="address-region">Pembrokeshire</span> <span itemprop="postalCode" class="address-postcode">SA61 2EX</span></p>', 'option');

        // Update the link button
        $footer_link_button = array(
            'url' => 'https://example.com/button-link',
            'title' => 'Click Here',
            'target' => '_self',
        );
        update_field('footer_link_button', $footer_link_button, 'option');

        // Update the bottom text
        update_field('footer_bottom_text', 'HWC © 2024', 'option');

        // Update social media links
        // Update the social media fields under the group
        update_field('footer_social_media_footer_twitter', 'https://twitter.com/yourprofile', 'option');
        update_field('footer_social_media_footer_facebook', 'https://facebook.com/yourprofile', 'option');
        update_field('footer_social_media_footer_instagram', 'https://instagram.com/yourprofile', 'option');
        update_field('footer_social_media_footer_youtube', 'https://youtube.com/yourchannel', 'option');
        update_field('footer_social_media_footer_tiktok', 'https://tiktok.com/@yourprofile', 'option');
        update_field('footer_social_media_footer_linkedin', 'https://linkedin.com/in/yourprofile', 'option');

        // Mark that data has been added to avoid repetition
        update_option('hwc_footer_data_added', true);
    }
}
