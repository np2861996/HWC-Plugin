<?php

/**
 * Code For Documents Page.
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hwc
 */

/*--------------------------------------------------------------
	>>> All Action and Filter Functions
----------------------------------------------------------------*/
add_action('acf/init', 'hwc_create_documents_page_with_acf_fields');

/*--------------------------------------------------------------
	>>> Function for Add ACF Fields for results
----------------------------------------------------------------*/
function hwc_create_documents_page_with_acf_fields()
{
    /*--------------------------------------------------------------
        >>> Add page with Template 
    ----------------------------------------------------------------*/
    // Set variables for the documents page
    $hwc_documents_page_title = 'Documents';
    $hwc_documents_page_slug = 'documents';
    $hwc_documents_page_template = 'template-parts/template-documents.php';

    // Check if the documents page exists
    $hwc_documents_page = get_page_by_path($hwc_documents_page_slug);

    if (!$hwc_documents_page) {
        // Create the documents page if it doesn't exist
        $hwc_documents_page_data = array(
            'post_title'    => $hwc_documents_page_title,
            'post_content'  => '',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_name'     => $hwc_documents_page_slug,
            'page_template' => $hwc_documents_page_template
        );
        $hwc_documents_page_id = wp_insert_post($hwc_documents_page_data);

        // Set the page template
        update_post_meta($hwc_documents_page_id, '_wp_page_template', $hwc_documents_page_template);
    } else {
        // If the page exists, get its ID
        $hwc_documents_page_id = $hwc_documents_page->ID;
    }

    /*--------------------------------------------------------------
        >>> Add Fields data in documents page. 
    ----------------------------------------------------------------*/
    // Register ACF fields for the documents page
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_hwc_documents_page',
            'title' => 'Documents Page Fields',
            'fields' => array(
                // Section Title for Documents Page
                array(
                    'key' => 'hwc_documents_section_title',
                    'label' => 'Documents Section Title',
                    'name' => 'hwc_documents_section_title',
                    'type' => 'text',
                    'required' => 0,
                ),
                // Repeater for Documents Cards
                array(
                    'key' => 'hwc_documents_repeater_cards',
                    'label' => 'Documents Cards Repeater',
                    'name' => 'hwc_repeater_documents_cards',
                    'type' => 'repeater',
                    'sub_fields' => array(
                        array(
                            'key' => 'hwc_documents_card_title',
                            'label' => 'Card Title',
                            'name' => 'hwc_documents_card_title',
                            'type' => 'text',
                            'required' => 0,
                        ),
                        array(
                            'key' => 'hwc_documents_card_button_link',
                            'label' => 'Document Link',
                            'name' => 'hwc_button_link',
                            'type' => 'link',
                            'required' => 0,
                        ),
                    ),
                    'min' => 0,
                    'layout' => 'block', // You can change to 'row' if preferred
                    'button_label' => 'Add Card',
                ),
                array(
                    'key' => 'hwc_documents_bottom_section_title',
                    'label' => 'Documents bottom Section Title',
                    'name' => 'hwc_documents_bottom_section_title',
                    'type' => 'text',
                    'required' => 0,
                ),
                array(
                    'key' => 'hwc_documents_bottom_section_textarea',
                    'label' => 'Documents bottom Section Textarea',
                    'name' => 'hwc_documents_bottom_section_textarea',
                    'type' => 'textarea',
                    'required' => 0,
                ),
                array(
                    'key' => 'hwc_documents_bottom_section_button',
                    'label' => 'Documents bottom Section Button',
                    'name' => 'hwc_documents_bottom_section_button',
                    'type' => 'link',
                    'required' => 0,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'page',
                        'operator' => '==',
                        'value' => $hwc_documents_page_id, // Replace with your Documents page template
                    ),
                ),
            ),
        ));
    }

    /*--------------------------------------------------------------
        >>> Store Data
    ----------------------------------------------------------------*/
    if (!get_option('hwc_documents_data_added', false)) {
        // Define the section title for the Documents page with hwc_documents_ prefix
        $hwc_documents_section_title = 'Click below to download the relevant club documents';
        $hwc_documents_bottom_section_title = 'Final Audited Accounts';
        $hwc_documents_bottom_section_textarea = 'Year ended 31 December 2023';
        // Update the ACF field for the Documents section title with hwc_documents_ prefix
        update_field('hwc_documents_section_title', $hwc_documents_section_title, $hwc_documents_page_id);
        update_field('hwc_documents_bottom_section_title', $hwc_documents_bottom_section_title, $hwc_documents_page_id);
        update_field('hwc_documents_bottom_section_textarea', $hwc_documents_bottom_section_textarea, $hwc_documents_page_id);
        $hwc_documents_bottom_section_button = array(
            'url'   => 'https://media.touchlinefc.co.uk/haverfordwestcounty/2024/04/10153641/HW-2023-word.rtf',     // The link URL
            'title' => 'Click here to view',            // The link text
            'target' => '_blank'                   // Optional: '_blank' to open in a new tab
        );
        update_field('hwc_documents_bottom_section_button', $hwc_documents_bottom_section_button, $hwc_documents_page_id);

        // Manually define the Documents page repeater data with hwc_documents_ prefix
        $hwc_documents_repeater_data = array(
            array(
                'hwc_documents_card_title' => 'FSRStategy',
                'hwc_documents_card_link' => array(
                    'url' => 'https://media.touchlinefc.co.uk/haverfordwestcounty/2023/03/FSRStategy.docx',
                    'title' => 'Download',
                    'target' => '_self', // '_blank' for new tab
                ),
            ),
            array(
                'hwc_documents_card_title' => 'Contact',
                'hwc_documents_card_link' => array(
                    'url' => 'https://media.touchlinefc.co.uk/haverfordwestcounty/2023/03/EnvironmentalCommitment.docx',
                    'title' => 'Download',
                    'target' => '_self',
                ),
            ),
            array(
                'hwc_documents_card_title' => 'About The Academy',
                'hwc_documents_card_link' => array(
                    'url' => 'https://media.touchlinefc.co.uk/haverfordwestcounty/2023/03/HumanRightsCommitment.docx',
                    'title' => 'Download',
                    'target' => '_self',
                ),
            ),
        );

        // Prepare the final repeater data with uploaded image IDs
        $final_documents_repeater_data = array();

        foreach ($hwc_documents_repeater_data as $card) {
            $final_documents_repeater_data[] = array(
                'hwc_documents_card_title' => $card['hwc_documents_card_title'],
                'hwc_button_link' => $card['hwc_documents_card_link'], // Correct format for ACF link field
            );
        }

        // Update the ACF repeater field for the Documents page with the structured array
        update_field('hwc_repeater_documents_cards', $final_documents_repeater_data, $hwc_documents_page_id);
        // After the function has run, set the option to true
        update_option('hwc_documents_data_added', true);
    }
}
//end