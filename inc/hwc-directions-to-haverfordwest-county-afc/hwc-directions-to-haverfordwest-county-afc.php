<?php

/**
 * Code For Directions to Haverfordwest County AFC Page.
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hwc
 */

/*--------------------------------------------------------------
	>>> All Action and Filter Functions
----------------------------------------------------------------*/
add_action('acf/init', 'hwc_create_directions_to_haverfordwest_county_afc_page_with_acf_fields');

/*--------------------------------------------------------------
	>>> Function for Add ACF Fields for results
----------------------------------------------------------------*/
function hwc_create_directions_to_haverfordwest_county_afc_page_with_acf_fields()
{
    /*--------------------------------------------------------------
        >>> Add page with Template 
    ----------------------------------------------------------------*/
    // Set variables for the directions-to-haverfordwest-county-afc page
    $hwc_directions_to_haverfordwest_county_afc_page_title = 'Directions to Haverfordwest County AFC';
    $hwc_directions_to_haverfordwest_county_afc_page_slug = 'directions-to-haverfordwest-county-afc';
    $hwc_directions_to_haverfordwest_county_afc_page_template = 'template-parts/template-directions-to-haverfordwest-county-afc.php';

    // Check if the directions-to-haverfordwest-county-afc page exists
    $hwc_directions_to_haverfordwest_county_afc_page = get_page_by_path($hwc_directions_to_haverfordwest_county_afc_page_slug);

    if (!$hwc_directions_to_haverfordwest_county_afc_page) {
        // Create the directions-to-haverfordwest-county-afc page if it doesn't exist
        $hwc_directions_to_haverfordwest_county_afc_page_data = array(
            'post_title'    => $hwc_directions_to_haverfordwest_county_afc_page_title,
            'post_content'  => '<p>The Ogi Bridge Meadow Stadium,</p>
                                <p>Bridge Meadow Lane,</p>
                                <p>Sydney Rees Way,</p>
                                <p>Haverfordwest,</p>
                                <p>Pembrokeshire</p>
                                <p>SA61 2EX</p>
                                <h3>Getting here</h3>
                                <h4>On foot</h4>
                                <p>Supporters who live within a reasonable distance of the stadium should – providing they are able to – walk to the ground, in order to leave as many car parking spaces available as possible to those who are travelling from further afield.</p>
                                <h4>By car</h4>
                                <p><a href="https://www.google.com/maps/dir//Haverfordwest+County+AFC,+Bridge+Meadow+Lane,+Sydney+Rees+Way,+Haverfordwest+SA61+2EX/@51.8091555,-4.9697375,17z/data=!4m16!1m6!3m5!1s0x48692f67ce12d759:0xf09afd8da0c1b424!2sHaverfordwest+County+AFC!8m2!3d51.8091522!4d-4.9675488!4m8!1m0!1m5!1m1!1s0x48692f67ce12d759:0xf09afd8da0c1b424!2m2!1d-4.9675488!2d51.8091522!3e2" target="_blank" rel="noopener">Click here</a> for directions to the Ogi Bridge Meadow Stadium</p>
                                <h4>Parking</h4>
                                <p>The main car park is situated adjacent to the stadium, providing easy access both before and after matches.</p>
                                <h4>Train</h4>
                                <p>Haverfordwest Station is just a 14-minute walk from the Ogi Bridge Meadow Stadium.</p>
                                <p><strong>From Haverfordwest Station </strong>– From the main entrance, turn left and walk down the hill towards the town centre. Just before you reach the roundabout, bear right and cross the road to head towards the flyover bridge. Then, cross the road to reach the pavement adjacent to the County Hotel, before baring right to follow the pavement which leads you underneath the flyover bridge and towards the next roundabout.</p>
                                <p>Follow the pavement until just before the next roundabout, where you bare left slightly to join another pavement which heads in the direction of Morrisons on the other side of the roundabout. Head down the slope, where you will then see two tunnels, take the left tunnel which has the sign ‘Bridge Meadow’ on it, and then follow the path forwards. You will need to bare left slightly just before reaching the stadium, however, at this point, you will be able to see the car park and the stadium in the background.</p>
                                <p>&nbsp;</p>',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_name'     => $hwc_directions_to_haverfordwest_county_afc_page_slug,
            'page_template' => $hwc_directions_to_haverfordwest_county_afc_page_template
        );
        $hwc_directions_to_haverfordwest_county_afc_page_id = wp_insert_post($hwc_directions_to_haverfordwest_county_afc_page_data);

        // Set the page template
        update_post_meta($hwc_directions_to_haverfordwest_county_afc_page_id, '_wp_page_template', $hwc_directions_to_haverfordwest_county_afc_page_template);
    } else {
        // If the page exists, get its ID
        $hwc_directions_to_haverfordwest_county_afc_page_id = $hwc_directions_to_haverfordwest_county_afc_page->ID;
    }


    /*--------------------------------------------------------------
        >>> Store Data
    ----------------------------------------------------------------*/
    if (!get_option('hwc_directions_to_haverfordwest_county_afc_data_added', false)) {

        $hwc_directions_to_haverfordwest_county_afc_image_filename = 'K3A8222-Edit-©-RawPhotography-scaled-1.jpg';

        $hwc_directions_to_haverfordwest_county_afc_image_id = hwc_create_image_from_plugin($hwc_directions_to_haverfordwest_county_afc_image_filename, $hwc_directions_to_haverfordwest_county_afc_page_id);
        if ($hwc_directions_to_haverfordwest_county_afc_image_id) {
            set_post_thumbnail($hwc_directions_to_haverfordwest_county_afc_page_id, $hwc_directions_to_haverfordwest_county_afc_image_id);
        } else {
            error_log('Failed to set featured image.');
        }

        // After the function has run, set the option to true
        update_option('hwc_directions_to_haverfordwest_county_afc_data_added', true);
    }
}
//end