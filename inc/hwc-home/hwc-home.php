<?php

/**
 * Code For Home Page.
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hwc
 */
/*--------------------------------------------------------------
	>>> All Action and Filter Functions
----------------------------------------------------------------*/
add_action('acf/init', 'hwc_create_home_page_with_acf_fields');

/*--------------------------------------------------------------
	>>> Function for Add ACF Fields for results
----------------------------------------------------------------*/
function hwc_create_home_page_with_acf_fields()
{
    // Check if the homepage creation has already been run
    $homepage_created = get_option('hwc_homepage_created');

    // Set variables for the home page
    $page_title = 'Home';
    $page_slug = 'home';
    $page_template = 'template-parts/template-home.php';

    if (!$homepage_created) {


        // Check if the home page exists
        $home_page = get_page_by_path($page_slug);

        if (!$home_page) {
            // Create the home page if it doesn't exist
            $page_data = array(
                'post_title'    => $page_title,
                'post_content'  => '',
                'post_status'   => 'publish',
                'post_type'     => 'page',
                'post_name'     => $page_slug,
                'page_template' => $page_template
            );
            $home_page_id = wp_insert_post($page_data);

            // Set the page template
            update_post_meta($home_page_id, '_wp_page_template', $page_template);

            // Set the home page as the front page
            update_option('show_on_front', 'page');
            update_option('page_on_front', $home_page_id);
        } else {
            // If the page exists, get its ID
            $home_page_id = $home_page->ID;
        }
        // Set the flag to indicate homepage was created
        update_option('hwc_homepage_created', true);
    } else {
        // If the home page creation was already done, just get its ID
        $home_page = get_page_by_path($page_slug);
        if ($home_page) {
            $home_page_id = $home_page->ID;
        }
    }

    if (get_page_by_path($page_slug)) {
        // Register ACF fields for the home page
        if (function_exists('acf_add_local_field_group')) {
            acf_add_local_field_group(array(
                'key' => 'group_hwc_home_page',
                'title' => 'Home Page Fields',
                'fields' => array(
                    // Section Title for Cards
                    array(
                        'key' => 'hwc_home_section_cards_title',
                        'label' => 'Cards Section',
                        'name' => 'cards_section_title',
                        'type' => 'message',
                        'new_lines' => 'wpautop',
                    ),
                    // Repeater for Cards
                    array(
                        'key' => 'hwc_home_repeater_cards',
                        'label' => 'Cards Repeater',
                        'name' => 'repeater_cards',
                        'type' => 'repeater',
                        'sub_fields' => array(
                            array(
                                'key' => 'hwc_home_card_image',
                                'label' => 'Card Image',
                                'name' => 'card_image',
                                'type' => 'image',
                                'required' => 1,
                            ),
                            array(
                                'key' => 'hwc_home_card_title',
                                'label' => 'Card Title',
                                'name' => 'card_title',
                                'type' => 'text',
                                'required' => 1,
                            ),
                            array(
                                'key' => 'hwc_home_card_link',
                                'label' => 'Card Link',
                                'name' => 'card_link',
                                'type' => 'link',
                                'required' => 0,
                            ),
                        ),
                    ),
                    // Big Blue Box Section
                    array(
                        'key' => 'hwc_home_section_big_box_separator',
                        'label' => 'Big Blue Box Section',
                        'name' => 'big_box_section_title',
                        'type' => 'message',
                        'new_lines' => 'wpautop',
                    ),
                    array(
                        'key' => 'hwc_home_big_box_image',
                        'label' => 'Big Box Image',
                        'name' => 'big_box_image',
                        'type' => 'image',
                    ),
                    array(
                        'key' => 'hwc_home_big_box_title',
                        'label' => 'Big Box Title',
                        'name' => 'big_box_title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'hwc_home_big_box_description',
                        'label' => 'Big Box Description',
                        'name' => 'big_box_description',
                        'type' => 'textarea',
                    ),
                    array(
                        'key' => 'hwc_home_big_box_button_link',
                        'label' => 'Big Box Button Link',
                        'name' => 'big_box_button_link',
                        'type' => 'link',
                    ),
                    // Team Info Section
                    array(
                        'key' => 'hwc_home_section_team_info_separator',
                        'label' => 'Team Info Section',
                        'name' => 'team_info_section_title',
                        'type' => 'message',
                        'new_lines' => 'wpautop',
                    ),
                    array(
                        'key' => 'hwc_home_select_team',
                        'label' => 'Select Team',
                        'name' => 'hwc_home_select_team',
                        'type' => 'post_object',
                        'post_type' => array('team'),
                        'return_format' => 'id',
                        'multiple' => 0,
                        'required' => 0,
                    ),
                    // Newsletter Section
                    array(
                        'key' => 'hwc_home_section_newsletter_separator',
                        'label' => 'Newsletter Section',
                        'name' => 'newsletter_section_title',
                        'type' => 'message',
                        'new_lines' => 'wpautop',
                    ),
                    array(
                        'key' => 'hwc_home_newsletter_background_image',
                        'label' => 'Newsletter Background Image',
                        'name' => 'newsletter_background_image',
                        'type' => 'image',
                        'required' => 0,
                    ),
                    array(
                        'key' => 'hwc_home_newsletter_title',
                        'label' => 'Newsletter Title',
                        'name' => 'newsletter_title',
                        'type' => 'text',
                        'required' => 0,
                    ),
                    array(
                        'key' => 'hwc_home_newsletter_description',
                        'label' => 'Newsletter Description',
                        'name' => 'newsletter_description',
                        'type' => 'textarea',
                        'required' => 0,
                    ),
                    array(
                        'key' => 'hwc_home_newsletter_html_box',
                        'label' => 'Newsletter Form HTML Box',
                        'name' => 'newsletter_html_box',
                        'type' => 'textarea',
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'page',
                            'operator' => '==',
                            'value' => $home_page_id,
                        ),
                    ),
                ),
            ));
        }
    }



    if (!get_option('hwc_home_data_added', false)) {
        // Get the ID of the front page
        // Get the ID of the front page
        $front_page_id = $home_page_id;

        // Check if the front page ID is valid
        if ($front_page_id) {

            // Manually define the repeater data
            $repeater_data = array(
                array(
                    'card_image' => 'WebsiteGraphicsClubShop.jpg', // Placeholder for Card 1
                    'card_title' => 'Browse the Latest Merchandise',
                    'card_button_title' => 'Read More',
                    'card_link' => 'https://example.com/card1',
                ),
                array(
                    'card_image' => 'WebsiteGraphicsMatchTickets.jpg', // Placeholder for Card 2
                    'card_title' => 'Sample Card Title 2',
                    'card_button_title' => 'Read More',
                    'card_link' => 'https://example.com/card2',
                ),
                array(
                    'card_image' => 'WebsiteGraphicsCommercial.jpg', // Placeholder for Card 3
                    'card_title' => 'Sample Card Title 3',
                    'card_button_title' => 'Read More',
                    'card_link' => 'https://example.com/card3',
                ),
            );

            // Manually define the repeater data
            $repeater_data = array(
                array(
                    'card_image' => 'WebsiteGraphicsClubShop.jpg', // Placeholder for Card 1
                    'card_title' => 'Browse the Latest Merchandise',
                    'card_button_title' => 'Read More',
                    'card_link' => array(
                        'url' => 'https://example.com/card1',
                        'title' => 'Read More',
                        'target' => '_self', // or '_blank' if you want the link to open in a new tab
                    ),
                ),
                array(
                    'card_image' => 'WebsiteGraphicsMatchTickets.jpg', // Placeholder for Card 2
                    'card_title' => 'Match Tickets',
                    'card_button_title' => 'Buy Now',
                    'card_link' => array(
                        'url' => 'https://example.com/card2',
                        'title' => 'Read More',
                        'target' => '_self',
                    ),
                ),
                array(
                    'card_image' => 'WebsiteGraphicsCommercial.jpg', // Placeholder for Card 3
                    'card_title' => 'Commercial Opportunities',
                    'card_button_title' => 'Read More',
                    'card_link' => array(
                        'url' => 'https://example.com/card3',
                        'title' => 'Support the Bluebirds',
                        'target' => '_self',
                    ),
                ),
            );

            // Prepare the final repeater data with uploaded image IDs
            $final_repeater_data = array();

            foreach ($repeater_data as $card) {
                // Upload the image and get the attachment ID
                $card_image_id = hwc_create_image_from_plugin($card['card_image'], $front_page_id);

                if (!is_wp_error($card_image_id)) {
                    $final_repeater_data[] = array(
                        'card_image' => $card_image_id, // Use the uploaded image ID
                        'card_title' => $card['card_title'],
                        'card_link' => $card['card_link'], // This is now the correct format for a link field
                    );
                } else {
                    error_log('Failed to upload image: ' . $card_image_id->get_error_message());
                }
            }

            // Update the ACF repeater field with the structured array
            update_field('repeater_cards', $final_repeater_data, $front_page_id);


            // Upload the image and get the attachment ID
            $big_box_image_id = hwc_create_image_from_plugin('Hwest-County-vs-Shkendija-372.jpg', $front_page_id);

            if (!is_wp_error($big_box_image_id)) {
                update_field('big_box_image', $big_box_image_id, $front_page_id);
            } else {
                error_log('Failed to upload image: ' . $big_box_image_id->get_error_message());
            }

            update_field('big_box_description', 'Watch every episode of our club documentary series!', $front_page_id);
            update_field('big_box_title', '#YouCanHaveItAll', $front_page_id);
            // Update the big box button link as an ACF Link field
            $big_box_button_link = array(
                'url' => 'https://example.com/bigbox', // URL for the link
                'title' => 'Tune in now!', // Title for the link
                'target' => '_self' // Optional target attribute
            );
            update_field('big_box_button_link', $big_box_button_link, $front_page_id);
            update_field('hwc_home_select_team', hwc_get_team_id_by_name('Haverfordwest County'), $front_page_id); // Change this based on your teams' choice values

            // Upload the image and get the attachment ID
            $newsletter_background_image_id = hwc_create_image_from_plugin('Hwest-County-vs-Shkendija-213-scaled.jpg', $front_page_id);

            if (!is_wp_error($newsletter_background_image_id)) {
                update_field('newsletter_background_image', $newsletter_background_image_id, $front_page_id);
            } else {
                error_log('Failed to upload image : ' . $newsletter_background_image_id->get_error_message());
            }

            update_field('newsletter_title', 'Sign up to our newsletter', $front_page_id);
            update_field('newsletter_description', 'Receive all the latest news and updates from the Club straight to your inbox', $front_page_id);
            update_field('newsletter_html_box', '<form method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate="">
				<div id="mc_embed_signup_scroll">
					<div class="mc-field-group">
						<label class="screen-reader-text" for="mce-EMAIL">Your email address</label>
						<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="Your email address">
					</div>
					<div id="mce-responses">
						<div class="response" id="mce-error-response" style="display:none"></div>
						<div class="response" id="mce-success-response" style="display:none"></div>
					</div>
					<div style="position: absolute; left: -5000px;" aria-hidden="true">
						<input type="text" name="b_53df85d4bc72ebf18f39431f7_89fa7b8e38" tabindex="-1" value="">
					</div>
					<div>
						<button type="submit" name="subscribe" id="mc-embedded-subscribe" class="btn btn-theme"><span>Sign Up</span></button>
					</div>
				</div>
			</form>', $front_page_id);
        }
        // After the function has run, set the option to true
        update_option('hwc_home_data_added', true);
    }
}
