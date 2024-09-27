<?php

/**
 * Code For History Page.
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hwc
 */

/*--------------------------------------------------------------
	>>> All Action and Filter Functions
----------------------------------------------------------------*/
add_action('acf/init', 'hwc_create_history_page_with_acf_fields');

/*--------------------------------------------------------------
	>>> Function for Add ACF Fields for results
----------------------------------------------------------------*/
function hwc_create_history_page_with_acf_fields()
{
    /*--------------------------------------------------------------
        >>> Add page with Template 
    ----------------------------------------------------------------*/
    // Set variables for the history page
    $hwc_history_page_title = 'History';
    $hwc_history_page_slug = 'history';
    $hwc_history_page_template = 'template-parts/template-history.php';

    // Check if the history page exists
    $hwc_history_page = get_page_by_path($hwc_history_page_slug);

    if (!$hwc_history_page) {
        // Create the history page if it doesn't exist
        $hwc_history_page_data = array(
            'post_title'    => $hwc_history_page_title,
            'post_content'  => '<p class="x_ContentPasted0" data-ogsc="rgb(0, 0, 0)">Haverfordwest Football History was formed in 1899, and was quickly renamed Haverfordwest Town in 1901. In 1936, the name of Haverfordwest Athletic was adopted and the first team switched to the Welsh Football League, leaving a reserve side in the Pembrokeshire League. In 1956, they gained promotion to the Welsh League Premier Division, having won the First Division title. The present name of Haverfordwest County was adopted and the history embarked on a long stay in the top flight. Disaster struck in 1975–76 when the history won only four league matches and was relegated to the First Division. Promotion eluded them until 1980, and they went on to take the championship in their first season back, losing only five games.</p>
<p class="x_ContentPasted0" data-ogsc="rgb(0, 0, 0)">In 1983, the Welsh League was reorganised to create a form of “premiership” for the leading historys and Haverfordwest’s facilities, administration and playing record secured their admittance. In the nine years of existence of this National Division, Haverfordwest were out of the top six only once, but their way to the title was blocked by the powerful Barry Town side. Their opportunity to take the championship came in 1990, once Barry had decided to move to English non-league football.</p>
<p class="x_ContentPasted0" data-ogsc="rgb(0, 0, 0)">Haverfordwest County were founder members of the League of Wales in 1992–93 but their stay was brief. Having accepted an offer which involved the redevelopment of their Bridge Meadow ground, and unable to find a suitable alternative ground of League of Wales standard, they resigned from the League in 1994. The decision to take a long-term view was fully vindicated by their return to the League of Wales three years later. The league has since changed its name to the Welsh Premier League, and is now known as the Cymru Premier.</p>
<p class="x_ContentPasted0" data-ogsc="rgb(0, 0, 0)">In 2004, Haverfordwest County qualified for Europe via league position in the League of Wales, and played in the UEFA Cup, losing over two legs 4–1 to Fimleikafelag Hafnarfjardar of Iceland. In the 2010–11 season, Haverfordwest County were involuntarily relegated from the Welsh Premier League for the first time. On 5 May 2015, they were promoted back to the Welsh Premier League following an unlikely 5–0 victory against Aberdare Town. After an immediate relegation from the top-flight, the history secured its return for the 2020-21 season, and have just embarked on their fifth consecutive campaign in the top echelon of Welsh domestic football.</p>',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_name'     => $hwc_history_page_slug,
            'page_template' => $hwc_history_page_template
        );
        $hwc_history_page_id = wp_insert_post($hwc_history_page_data);

        // Set the page template
        update_post_meta($hwc_history_page_id, '_wp_page_template', $hwc_history_page_template);
    } else {
        // If the page exists, get its ID
        $hwc_history_page_id = $hwc_history_page->ID;
    }

    /*--------------------------------------------------------------
        >>> Add Fields data in history page. 
    ----------------------------------------------------------------*/
    // Register ACF fields for the history page
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_hwc_history_page',
            'title' => 'History Page Fields',
            'fields' => array(
                // Section Title for History Page
                array(
                    'key' => 'hwc_history_section_title_1',
                    'label' => 'HWC History Section Title 1',
                    'name' => 'hwc_history_section_title_1',
                    'type' => 'text',
                    'required' => 0,
                ),
                array(
                    'key' => 'hwc_history_section_title_2',
                    'label' => 'HWC History Section Title 2',
                    'name' => 'hwc_history_section_title_2',
                    'type' => 'text',
                    'required' => 0,
                ),
                array(
                    'key' => 'hwc_history_bg_image',
                    'label' => 'Background Image',
                    'name' => 'hwc_history_bg_image',
                    'type' => 'image',
                    'required' => 0,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'page',
                        'operator' => '==',
                        'value' => $hwc_history_page_id, // Replace with your History page template
                    ),
                ),
            ),
        ));
    }

    /*--------------------------------------------------------------
        >>> Store Data
    ----------------------------------------------------------------*/
    //if (!get_option('hwc_history_data_added', false)) {
    // Update the ACF field for the History section title with hwc_history_ prefix
    $hwc_history_section_title_1 = 'Haverfordwest County AFC - Since 1899';
    $hwc_history_section_title_2 = 'The long and storied history of the Bluebirds';
    update_field('hwc_history_section_title_1', $hwc_history_section_title_1, $hwc_history_page_id);
    update_field('hwc_history_section_title_2', $hwc_history_section_title_2, $hwc_history_page_id);
    $history_bg_image_id = hwc_create_image_from_plugin('BLUEBIRDS-TOGETHER-2023-0-12-screenshot.jpg', $hwc_history_page_id);
    update_field('hwc_history_bg_image', $history_bg_image_id, $hwc_history_page_id);

    // After the function has run, set the option to true
    //update_option('hwc_history_data_added', true);
    //}
}
//end