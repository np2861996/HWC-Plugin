<?php

/**
 * Code For Result info, add data when install and activate the theme.
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hwc
 */

/*--------------------------------------------------------------
	>>> All Action and Filter Functions
----------------------------------------------------------------*/
add_action('init', 'hwc_register_custom_post_types_result');
add_action('acf/init', 'hwc_add_acf_fields_results');
add_action('acf/init', 'hwc_populate_fixture_result_default_data');

/*--------------------------------------------------------------
	>>> Register Result Post Type
----------------------------------------------------------------*/
function hwc_register_custom_post_types_result()
{
    register_post_type('result', array(
        'labels' => array(
            'name' => 'Results',
            'singular_name' => 'Result',
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
    ));
}

/*--------------------------------------------------------------
	>>> Function for Add ACF Fields for results
	----------------------------------------------------------------*/
function hwc_add_acf_fields_results()
{
    // Results ACF Fields
    if (function_exists('acf_add_local_field_group')):
        acf_add_local_field_group(array(
            'key' => 'group_results',
            'title' => 'Result Details',
            'fields' => array(
                array(
                    'key' => 'field_select_result_match',
                    'label' => 'Select Match',
                    'name' => 'select_result_match',
                    'type' => 'relationship',
                    'post_type' => array('fixtures'), // Link to the 'Fixtures' CPT
                    'required' => 1,
                    'max' => 1,
                ),
                array(
                    'key' => 'field_results_team1',
                    'label' => 'Select Team1 Players',
                    'name' => 'select_result_team1_players',
                    'type' => 'relationship',
                    'post_type' => array('player'), // Link to the 'Fixtures' CPT
                    'required' => 1,
                ),
                array(
                    'key' => 'field_results_team1_substitutes_players',
                    'label' => 'Select Team1 Substitutes Players',
                    'name' => 'select_result_team1_substitutes_players',
                    'type' => 'relationship',
                    'post_type' => array('player'), // Link to the 'Fixtures' CPT
                    'required' => 1,
                ),
                array(
                    'key' => 'field_results_team2_players',
                    'label' => 'Select Team2 Players',
                    'name' => 'select_result_team2_players',
                    'type' => 'relationship',
                    'post_type' => array('player'), // Link to the 'Fixtures' CPT
                    'required' => 1,
                ),
                array(
                    'key' => 'field_results_team2_substitutes_players',
                    'label' => 'Select Team2 Substitutes Players',
                    'name' => 'select_result_team2_substitutes_players',
                    'type' => 'relationship',
                    'post_type' => array('player'), // Link to the 'Fixtures' CPT
                    'required' => 1,
                ),
                array(
                    'key' => 'field_result_total_goals_team_1',
                    'label' => 'Total Goals Team 1',
                    'name' => 'result_total_goals_team_1',
                    'type' => 'number',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_result_total_goals_team_2',
                    'label' => 'Total Goals Team 2',
                    'name' => 'result_total_goals_team_2',
                    'type' => 'number',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_result_goals_info_team_1',
                    'label' => 'Team1 Goals Info',
                    'name' => 'result_goals_info_team_1',
                    'type' => 'text',
                    'required' => 0,
                ),
                array(
                    'key' => 'field_result_goals_info_team_2',
                    'label' => 'Team1 Goals Info',
                    'name' => 'result_goals_info_team_2',
                    'type' => 'text',
                    'required' => 0,
                ),
                array(
                    'key' => 'field_result_report_link',
                    'label' => 'Report Link',
                    'name' => 'result_report_link',
                    'type' => 'link',
                    'required' => 0,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'result',
                    ),
                ),
            ),
        ));
    endif;
}

/*--------------------------------------------------------------
	>>> Function for Add ACF Fields for results
----------------------------------------------------------------*/
function hwc_populate_fixture_result_default_data()
{
    //if (!get_option('hwc_fixture_matches_created', false)) {
    $fixtures = array(
        array(
            'result_fixture_post_title'        => 'Result: Bala Town vs Haverfordwest County',
            'result_select_result_match'       => 'Bala Town vs Haverfordwest County',
            'result_fixture_background_image'  => 'Essity-Stadium-UK.jpg',
            'result_fixture_description'       => 'ABERYSTWYTH, WALES - MARCH 08 2020, FAW Youth Cup Semi Final...',
            'result_team1_players'             => array('Ricky Watts', 'Ifan Knott'),
            'result_team1_substitutes'         => array('Rhys Abbruzzese'),
            'result_team2_players'             => array('Ben Fawcett', 'Lee Jenkins'),
            'result_team2_substitutes'         => array('Zac Jones'),
            'result_total_goals_team_1'        => 2,
            'result_total_goals_team_2'        => 1,
            'result_goals_info_team_1'         => 'Watts (51\'), Knott (57\')',
            'result_goals_info_team_2'         => 'Jones (47\')',
            'result_report_link' => array('url' => '', 'title' => ''),
        ),
        array(
            'result_fixture_post_title'        => 'Result: Briton Ferry Llansawel vs Newtown',
            'result_select_result_match'       => 'Briton Ferry Llansawel vs Newtown',
            'result_fixture_background_image'  => 'Essity-Stadium-UK.jpg',
            'result_fixture_description'       => 'ABERYSTWYTH, WALES - MARCH 08 2020, FAW Youth Cup Semi Final...',
            'result_team1_players'             => array('Ben Fawcett', 'Dylan Rees', 'Dylan Rees', 'Ifan Knott'),
            'result_team1_substitutes'         => array('Rhys Abbruzzese', 'Ricky Watts'),
            'result_team2_players'             => array('Ben Fawcett', 'Lee Jenkins'),
            'result_team2_substitutes'         => array('Zac Jones', 'Ricky Watts'),
            'result_total_goals_team_1'        => 2,
            'result_total_goals_team_2'        => 1,
            'result_goals_info_team_1'         => 'Watts (51\'), Knott (57\')',
            'result_goals_info_team_2'         => 'Jones (47\')',
            'result_report_link' => array('url' => '2024/09/22/bluebirds-see-off-seagulls-to-set-up-thrilling-final-day-meeting-with-bont/', 'title' => 'Report'),
        ),
        array(
            'result_fixture_post_title'        => 'Result: Haverfordwest County vs Connah\'s Quay Nomads',
            'result_select_result_match'       => 'Haverfordwest County vs Connah\'s Quay Nomads',
            'result_fixture_background_image'  => 'Essity-Stadium-UK.jpg',
            'result_fixture_description'       => 'ABERYSTWYTH, WALES - MARCH 08 2020, FAW Youth Cup Semi Final...',
            'result_team1_players'             => array('Ben Fawcett', 'Dylan Rees', 'Dylan Rees', 'Ifan Knott'),
            'result_team1_substitutes'         => array('Rhys Abbruzzese', 'Ricky Watts'),
            'result_team2_players'             => array('Ben Fawcett', 'Lee Jenkins'),
            'result_team2_substitutes'         => array('Zac Jones', 'Ricky Watts'),
            'result_total_goals_team_1'        => 5,
            'result_total_goals_team_2'        => 0,
            'result_goals_info_team_1'         => 'Jones (50\'), Dylan (52\')',
            'result_goals_info_team_2'         => 'Fawcett (80\')',
            'result_report_link' => array('url' => '', 'title' => ''),
        ),
        array(
            'result_fixture_post_title'        => 'Result: Briton Ferry Llansawel vs Haverfordwest County',
            'result_select_result_match'       => 'Briton Ferry Llansawel vs Haverfordwest County',
            'result_fixture_background_image'  => 'Essity-Stadium-UK.jpg',
            'result_fixture_description'       => '',
            'result_team1_players'             => array('Dylan Rees', 'Ifan Knott'),
            'result_team1_substitutes'         => array('Rhys Abbruzzese',),
            'result_team2_players'             => array('Ben Fawcett'),
            'result_team2_substitutes'         => array('Zac Jones', 'Ricky Watts'),
            'result_total_goals_team_1'        => 4,
            'result_total_goals_team_2'        => 4,
            'result_goals_info_team_1'         => 'Rees (56\'), Knott (62\')',
            'result_goals_info_team_2'         => 'Abbruzzese (79\')',
            'result_report_link' => array('url' => '2024/09/22/keeper-jones-the-hero-as-bluebirds-reach-maiden-european-play-off-final/', 'title' => 'Report'),
        ),
        array(
            'result_fixture_post_title'        => 'Result: Haverfordwest County vs Caernarfon Town',
            'result_select_result_match'       => 'Haverfordwest County vs Caernarfon Town',
            'result_fixture_background_image'  => 'Essity-Stadium-UK.jpg',
            'result_fixture_description'       => '',
            'result_team1_players'             => array('Dylan Rees', 'Ifan Knott'),
            'result_team1_substitutes'         => array('Rhys Abbruzzese',),
            'result_team2_players'             => array('Ben Fawcett'),
            'result_team2_substitutes'         => array('Zac Jones', 'Ricky Watts'),
            'result_total_goals_team_1'        => 0,
            'result_total_goals_team_2'        => 1,
            'result_goals_info_team_1'         => 'Rees (56\'), Knott (62\')',
            'result_goals_info_team_2'         => 'Abbruzzese (79\')',
            'result_report_link' => array('url' => '2024/09/22/keeper-jones-the-hero-as-bluebirds-reach-maiden-european-play-off-final/', 'title' => 'Report'),
        ),
        array(
            'result_fixture_post_title'        => 'Result: The New Saints vs Bala Town',
            'result_select_result_match'       => 'The New Saints vs Bala Town',
            'result_fixture_background_image'  => 'Essity-Stadium-UK.jpg',
            'result_fixture_description'       => 'ABERYSTWYTH, WALES - MARCH 08 2020, FAW Youth Cup Semi Final...',
            'result_team1_players'             => array('Ben Fawcett', 'Dylan Rees', 'Dylan Rees', 'Ifan Knott'),
            'result_team1_substitutes'         => array('Rhys Abbruzzese', 'Ricky Watts'),
            'result_team2_players'             => array('Ben Fawcett', 'Lee Jenkins'),
            'result_team2_substitutes'         => array('Zac Jones', 'Ricky Watts'),
            'result_total_goals_team_1'        => 2,
            'result_total_goals_team_2'        => 1,
            'result_goals_info_team_1'         => 'Watts (51\'), Knott (57\')',
            'result_goals_info_team_2'         => 'Jones (47\')',
            'result_report_link' => array('url' => '2024/09/22/bluebirds-see-off-seagulls-to-set-up-thrilling-final-day-meeting-with-bont/', 'title' => 'Report'),
        ),
        // Add more fixtures as needed
    );

    foreach ($fixtures as $fixture) {
        // Check if the result post already exists based on the title
        $existing_post_query = new WP_Query(array(
            'post_type' => 'result',
            'title'     => $fixture['result_fixture_post_title'],
            'posts_per_page' => 1,
            'fields' => 'ids'
        ));

        // If a post with the same title already exists, skip this iteration
        if ($existing_post_query->have_posts()) {
            continue;
        }

        // Create a new fixture post
        $fixture_result_id = wp_insert_post(array(
            'post_title'   => $fixture['result_fixture_post_title'],
            'post_type'    => 'result',
            'post_status'  => 'publish',
            'post_content' => $fixture['result_fixture_description'],
        ));

        if (is_wp_error($fixture_result_id)) {
            error_log('Error inserting post: ' . $fixture_result_id->get_error_message());
            continue; // Skip to the next fixture on error
        }

        // Retrieve the match ID based on the title
        $match_query = new WP_Query(array(
            'post_type' => 'fixtures',
            'title'     => $fixture['result_select_result_match'],
            'posts_per_page' => 1,
        ));

        if ($match_query->have_posts()) {
            $match_query->the_post();
            $match_id = get_the_ID();
            update_field('select_result_match', $match_id, $fixture_result_id);
        }
        wp_reset_postdata();

        // Update custom fields for players and substitutes
        update_field('select_result_team1_players', get_player_ids($fixture['result_team1_players']), $fixture_result_id);
        update_field('select_result_team1_substitutes_players', get_player_ids($fixture['result_team1_substitutes']), $fixture_result_id);
        update_field('select_result_team2_players', get_player_ids($fixture['result_team2_players']), $fixture_result_id);
        update_field('select_result_team2_substitutes_players', get_player_ids($fixture['result_team2_substitutes']), $fixture_result_id);

        // Update the rest of the fields
        update_field('field_result_total_goals_team_1', $fixture['result_total_goals_team_1'], $fixture_result_id);
        update_field('field_result_total_goals_team_2', $fixture['result_total_goals_team_2'], $fixture_result_id);
        update_field('result_goals_info_team_1', $fixture['result_goals_info_team_1'], $fixture_result_id);
        update_field('result_goals_info_team_2', $fixture['result_goals_info_team_2'], $fixture_result_id);
        update_field('result_report_link', array(
            'url' => $fixture['result_report_link']['url'],
            'title' => $fixture['result_report_link']['title'],
        ), $fixture_result_id);

        // Set featured image
        if (!empty($fixture['result_fixture_background_image'])) {
            $result_image_id = hwc_create_image_from_plugin($fixture['result_fixture_background_image'], $fixture_result_id);
            if ($result_image_id) {
                set_post_thumbnail($fixture_result_id, $result_image_id);
            }
        }
    }
    // After the function has run, set the option to true
    //update_option('hwc_fixture_matches_created', true);
    //}
}

// Helper function to get player IDs
function get_player_ids($player_names)
{
    $player_ids = [];
    foreach ($player_names as $player_name) {
        $player_query = new WP_Query(array(
            'post_type' => 'player',
            'title'     => $player_name,
            'posts_per_page' => 1,
        ));
        if ($player_query->have_posts()) {
            $player_query->the_post();
            $player_ids[] = get_the_ID();
        }
        wp_reset_postdata();
    }
    return $player_ids;
}
