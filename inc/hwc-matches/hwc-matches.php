<?php

/**
 * Code For Matches info, add data when install and activate the theme.
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hwc
 */

/*--------------------------------------------------------------
	>>> All Action and Filter Functions
----------------------------------------------------------------*/
add_action('init', 'hwc_register_custom_post_type_match');
add_action('acf/init', 'hwc_add_acf_fields_match');
add_action('acf/init', 'hwc_populate_fixture_default_data');

/*--------------------------------------------------------------
	>>> All Action and Filter Functions
----------------------------------------------------------------*/
function hwc_register_custom_post_type_match()
{
    register_post_type('fixtures', array(
        'labels' => array(
            'name' => 'Matches',
            'singular_name' => 'Match',
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
    ));
}

/*--------------------------------------------------------------
	>>> Function for Add Matches ACF Fields
----------------------------------------------------------------*/
function hwc_add_acf_fields_match()
{
    if (function_exists('acf_add_local_field_group')):
        acf_add_local_field_group(array(
            'key' => 'group_fixtures',
            'title' => 'Fixtures Fields',
            'fields' => array(

                array(
                    'key' => 'field_fixture_team_1',
                    'label' => 'Team 1',
                    'name' => 'fixture_team_1',
                    'type' => 'post_object',
                    'post_type' => array('team'),
                    'return_format' => 'id',
                    'multiple' => 0,
                    'required' => 1, // Set to 1 for required, 0 for not required
                    'default_value' => 1,
                ),
                array(
                    'key' => 'field_fixture_team_2',
                    'label' => 'Team 2',
                    'name' => 'fixture_team_2',
                    'type' => 'post_object',
                    'post_type' => array('team'),
                    'return_format' => 'id',
                    'multiple' => 0,
                    'required' => 1, // Set to 1 for required, 0 for not required
                    'default_value' => 1,
                ),
                array(
                    'key' => 'field_fixture_match_date',
                    'label' => 'Match Date',
                    'name' => 'fixture_match_date',
                    'type' => 'date_picker',
                    'required' => 1,
                    'return_format' => 'Ymd',
                ),
                array(
                    'key' => 'field_fixture_match_time',
                    'label' => 'Match Time',
                    'name' => 'fixture_match_time',
                    'type' => 'time_picker',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_fixture_stadium_name',
                    'label' => 'Stadium Name',
                    'name' => 'fixture_stadium_name',
                    'type' => 'text',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_fixture_league',
                    'label' => 'League',
                    'name' => 'fixture_league',
                    'type' => 'post_object',
                    'post_type' => array('league_table'),
                    'return_format' => 'id',
                    'multiple' => 0,
                    'required' => 1, // Set to 1 for required, 0 for not required
                    'default_value' => 1,
                ),
                array(
                    'key' => 'field_fixture_background_image',
                    'label' => 'Background Image',
                    'name' => 'fixture_background_image',
                    'type' => 'image',
                    'return_format' => 'url',
                )
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'fixtures',
                    ),
                ),
            ),
        ));
    endif;
}

/*--------------------------------------------------------------
	>>> Populate Default Fixture Data only once 
----------------------------------------------------------------*/
function hwc_populate_fixture_default_data()
{
    if (!get_option('hwc_fixture_matches_created', false)) {
        $fixtures = array(
            array(
                'fixture_post_title'    => 'Haverfordwest County vs Barry Town United',
                'fixture_team_1'       => 'Haverfordwest County',
                'fixture_team_2'       => 'Barry Town United',
                'fixture_match_date'   => '2024-09-30',
                'fixture_match_time'   => '15:00',
                'fixture_stadium_name' => 'LHP Stadium',
                'fixture_league'       => 'Premier League',
                'fixture_background_image' => '2020-03-08-FAW-Youth-Cup-Semi-Final-35.jpg'
            ),
            array(
                'fixture_post_title'    => 'Haverfordwest County vs Cardiff Met Uni',
                'fixture_team_1'       => 'Haverfordwest County',
                'fixture_team_2'       => 'Cardiff Met Uni',
                'fixture_match_date'   => '2024-10-10',
                'fixture_match_time'   => '15:00',
                'fixture_stadium_name' => 'LHP Stadium',
                'fixture_league'       => 'Premier League',
                'fixture_background_image' => '2020-03-08-FAW-Youth-Cup-Semi-Final-35.jpg'
            ),
            array(
                'fixture_post_title'    => 'Bala Town vs Haverfordwest County',
                'fixture_team_1'       => 'Bala Town',
                'fixture_team_2'       => 'Haverfordwest County',
                'fixture_match_date'   => '2024-10-11',
                'fixture_match_time'   => '16:00',
                'fixture_stadium_name' => 'Maes Tegid',
                'fixture_league'       => 'Euro Championship',
                'fixture_background_image' => '2020-03-08-FAW-Youth-Cup-Semi-Final-35.jpg'
            ),
            array(
                'fixture_post_title'    => 'Haverfordwest County vs Connah\'s Quay Nomads',
                'fixture_team_1'       => 'Haverfordwest County',
                'fixture_team_2'       => 'Connah\'s Quay Nomads',
                'fixture_match_date'   => '2024-10-12',
                'fixture_match_time'   => '17:00',
                'fixture_stadium_name' => 'LHP Stadium',
                'fixture_league'       => 'French League One',
                'fixture_background_image' => '2020-03-08-FAW-Youth-Cup-Semi-Final-35.jpg'
            ),
            array(
                'fixture_post_title'    => 'Briton Ferry Llansawel vs Haverfordwest County',
                'fixture_team_1'       => 'Briton Ferry Llansawel',
                'fixture_team_2'       => 'Haverfordwest County',
                'fixture_match_date'   => '2024-11-13',
                'fixture_match_time'   => '11:00',
                'fixture_stadium_name' => 'LHP Stadium',
                'fixture_league'       => 'Cota League',
                'fixture_background_image' => '2020-03-08-FAW-Youth-Cup-Semi-Final-35.jpg'
            ),
            array(
                'fixture_post_title'    => 'Haverfordwest County vs Caernarfon Town',
                'fixture_team_1'       => 'Haverfordwest County',
                'fixture_team_2'       => 'Caernarfon Town',
                'fixture_match_date'   => '2024-12-13',
                'fixture_match_time'   => '12:00',
                'fixture_stadium_name' => 'LHP Stadium',
                'fixture_league'       => 'National League',
                'fixture_background_image' => '2020-03-08-FAW-Youth-Cup-Semi-Final-35.jpg'
            ),
            array(
                'fixture_post_title'    => 'Haverfordwest County vs Flint Town United',
                'fixture_team_1'       => 'Haverfordwest County',
                'fixture_team_2'       => 'Flint Town United',
                'fixture_match_date'   => '2024-12-14',
                'fixture_match_time'   => '13:00',
                'fixture_stadium_name' => 'LHP Stadium',
                'fixture_league'       => 'Premier League',
                'fixture_background_image' => '2020-03-08-FAW-Youth-Cup-Semi-Final-35.jpg'
            ),
            array(
                'fixture_post_title'    => 'The New Saints vs Bala Town',
                'fixture_team_1'       => 'The New Saints',
                'fixture_team_2'       => 'Bala Town',
                'fixture_match_date'   => '2024-12-15',
                'fixture_match_time'   => '14:00',
                'fixture_stadium_name' => 'Ogi Bridge Meadow Stadium',
                'fixture_league'       => 'Premier League',
                'fixture_background_image' => '2020-03-08-FAW-Youth-Cup-Semi-Final-35.jpg'
            ),
            array(
                'fixture_post_title'    => 'Briton Ferry Llansawel vs Newtown',
                'fixture_team_1'       => 'Briton Ferry Llansawel',
                'fixture_team_2'       => 'Newtown',
                'fixture_match_date'   => '2024-12-16',
                'fixture_match_time'   => '15:00',
                'fixture_stadium_name' => 'Ogi Bridge Meadow Stadium',
                'fixture_league'       => 'Premier League',
                'fixture_background_image' => '2020-03-08-FAW-Youth-Cup-Semi-Final-35.jpg'
            ),
            array(
                'fixture_post_title'    => 'Aberystwyth Town vs Barry Town United',
                'fixture_team_1'       => 'Aberystwyth Town',
                'fixture_team_2'       => 'Barry Town United',
                'fixture_match_date'   => '2025-01-01',
                'fixture_match_time'   => '16:00',
                'fixture_stadium_name' => 'Jenner Park',
                'fixture_league'       => 'Premier League',
                'fixture_background_image' => '2020-03-08-FAW-Youth-Cup-Semi-Final-35.jpg'
            ),
            array(
                'fixture_post_title'    => 'Cardiff Met Uni vs Bala Town',
                'fixture_team_1'       => 'Cardiff Met Uni',
                'fixture_team_2'       => 'Bala Town',
                'fixture_match_date'   => '2025-01-01',
                'fixture_match_time'   => '16:00',
                'fixture_stadium_name' => 'Jenner Park',
                'fixture_league'       => 'Premier League',
                'fixture_background_image' => '2020-03-08-FAW-Youth-Cup-Semi-Final-35.jpg'
            ),
            // Add more matches as needed
        );

        foreach ($fixtures as $fixture) {
            // Check if the post already exists
            $existing_posts = get_posts(array(
                'post_type'   => 'fixtures',
                'title'       => $fixture['fixture_post_title'],
                'post_status' => 'any', // Check all statuses, including trash
                'numberposts' => 1, // Limit to one post
            ));

            if (empty($existing_posts)) {
                // Prepare the post data
                $fixture_data = array(
                    'post_title'    => $fixture['fixture_post_title'],
                    'post_type'     => 'fixtures',
                    'post_status'   => 'publish', // or 'draft', 'pending', etc.
                );

                // Insert the post
                $fixture_id = wp_insert_post($fixture_data);

                if ($fixture_id) {
                    // Update ACF fields
                    $fixture_team_1_id = hwc_get_team_id_by_name($fixture['fixture_team_1']);
                    $fixture_team_2_id = hwc_get_team_id_by_name($fixture['fixture_team_2']);
                    update_field('fixture_team_1', $fixture_team_1_id, $fixture_id);
                    update_field('fixture_team_2', $fixture_team_2_id, $fixture_id);
                    update_field('fixture_match_date', $fixture['fixture_match_date'], $fixture_id);
                    update_field('fixture_match_time', $fixture['fixture_match_time'], $fixture_id);
                    update_field('fixture_stadium_name', $fixture['fixture_stadium_name'], $fixture_id);
                    $fixture_league_id = hwc_get_league_table_id_by_name($fixture['fixture_league']);
                    update_field('fixture_league', $fixture_league_id, $fixture_id);

                    // Set player background image
                    if ($fixture['fixture_background_image']) {

                        $fixture_bg_image_id = hwc_create_image_from_plugin($fixture['fixture_background_image'], $fixture_id);

                        if (!is_wp_error($fixture_bg_image_id)) {
                            update_field(
                                'fixture_background_image',
                                $fixture_bg_image_id,
                                $fixture_id
                            );
                        } else {
                            error_log('Failed to upload background image: ' . $fixture_bg_image_id->get_error_message());
                        }
                    }
                }
            } else {
                // Optionally log or handle duplicates
                error_log('Duplicate fixture found: ' . $fixture['fixture_post_title']);
            }
        }
        // After the function has run, set the option to true
        update_option('hwc_fixture_matches_created', true);
    }
}

/*--------------------------------------------------------------
	>>> Function to get team ID by name
----------------------------------------------------------------*/
/* Function to get team ID by name */
function hwc_get_team_id_by_name($team_name)
{
    $args = array(
        'post_type' => 'team',
        'title'     => $team_name,
        'posts_per_page' => 1, // Limit to one post
    );

    $teams = get_posts($args);

    return !empty($teams) ? $teams[0]->ID : 0; // Return 0 if not found
}

/*--------------------------------------------------------------
	>>> Function to get league_table ID by name
----------------------------------------------------------------*/
/* Function to get team ID by name */
function hwc_get_league_table_id_by_name($league_name)
{
    $args = array(
        'post_type' => 'league_table',
        'title'     => $league_name,
        'posts_per_page' => 1, // Limit to one post
    );

    $league_name = get_posts($args);

    return !empty($league_name) ? $league_name[0]->ID : 0; // Return 0 if not found
}
