<?php

/**
 * Code For Teams info, add data when install and activate the theme.
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hwc
 */
/*--------------------------------------------------------------
	>>> All Action and Filter Functions
----------------------------------------------------------------*/
add_action('init', 'hwc_register_custom_post_type_team');
add_action('acf/init', 'hwc_populate_default_team_data');


/*--------------------------------------------------------------
	>>> Register Post Type Team
----------------------------------------------------------------*/
function hwc_register_custom_post_type_team()
{
    // Team
    register_post_type('team', array(
        'labels' => array(
            'name' => 'Teams',
            'singular_name' => 'Team',
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
    ));
}

/*--------------------------------------------------------------
	>>> Populate default team data with custom name, description, and image.
----------------------------------------------------------------*/
function hwc_populate_default_team_data()
{
    // Check if the function has already been run
    //if (!get_option('hwc_team_posts_created', false)) {
    // Array of default team details (name, description, image)
    $default_teams = array(
        array(
            'title' => 'Haverfordwest County',
            'description' => '',
            'image' => 'haverfordwest-county.png'
        ),
        array(
            'title' => 'Barry Town United',
            'description' => '',
            'image' => 'Barry-Town-United-crest.png'
        ),
        array(
            'title' => 'Cardiff Met Uni',
            'description' => '',
            'image' => 'cardiff-metropolitan-university.png'
        ),
        array(
            'title' => 'Bala Town',
            'description' => '',
            'image' => 'bala-town.png'
        ),
        array(
            'title' => 'Connah\'s Quay Nomads',
            'description' => '',
            'image' => 'connahs-quay-nomads.png'
        ),
        array(
            'title' => 'Briton Ferry Llansawel',
            'description' => '',
            'image' => 'Briton_Ferry_Llansawel_A.F.C.png'
        ),
        array(
            'title' => 'Caernarfon Town',
            'description' => '',
            'image' => 'caernarfon-town.png'
        ),
        array(
            'title' => 'Flint Town United',
            'description' => '',
            'image' => 'flint-town-united.png'
        ),
        array(
            'title' => 'The New Saints',
            'description' => '',
            'image' => 'the-new-saints.png'
        ),
        array(
            'title' => 'Penybont',
            'description' => '',
            'image' => 'penybont.png'
        ),
        array(
            'title' => 'Newtown',
            'description' => '',
            'image' => 'Newtown.png'
        ),
    );

    // Loop through each team
    foreach ($default_teams as $team) {

        // Check if the team already exists by title
        $existing_team_query = new WP_Query(array(
            'post_type' => 'team',
            'title' => sanitize_text_field($team['title']),
            'posts_per_page' => 1,
            'post_status' => 'any',
            'fields' => 'ids' // Only fetch IDs
        ));

        // If a team with the same title already exists, skip this iteration
        if ($existing_team_query->have_posts()) {
            //error_log('Team with title ' . sanitize_text_field($team['title']) . ' already exists, skipping...');
            wp_reset_postdata(); // Always reset the query to prevent conflicts
            continue;
        }

        // Insert the team post if it doesn't already exist
        $team_id = wp_insert_post(array(
            'post_type'    => 'team',
            'post_title'   => sanitize_text_field($team['title']),
            'post_content' => wp_kses_post($team['description']), // Sanitize the content
            'post_status'  => 'publish',
        ));

        if (is_wp_error($team_id)) {
            error_log('Failed to insert team ' . sanitize_text_field($team['title']) . ': ' . $team_id->get_error_message());
            continue;
        }

        // Set featured image
        if ($team['image']) {

            $image_filename = $team['image'];

            $image_id = hwc_create_image_from_plugin($image_filename, $team_id);
            if ($image_id) {
                set_post_thumbnail($team_id, $image_id);
            } else {
                error_log('Failed to set featured image for player ' . $team['title']);
            }
        }

        // Clear query data
        wp_reset_postdata();
    }
    // After the function has run, set the option to true
    //update_option('hwc_team_posts_created', true);
    //}
}
