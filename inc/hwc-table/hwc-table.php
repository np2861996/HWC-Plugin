<?php

/**
 * Code For Staff info, add data when install and activate the theme.
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hwc
 */

/*--------------------------------------------------------------
	>>> All Action and Filter Functions
----------------------------------------------------------------*/
add_action('init', 'hwc_register_custom_post_type_league_table');
add_action('acf/init', 'hwc_add_acf_fields_league_table');
add_action('acf/init', 'hwc_populate_default_data_league_table');


/*--------------------------------------------------------------
>>> Hook into theme activation Register Custom Post Types
----------------------------------------------------------------*/
function hwc_register_custom_post_type_league_table()
{
    // League Table
    register_post_type('league_table', array(
        'labels' => array(
            'name' => 'League Tables',
            'singular_name' => 'League Table',
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
    ));
}

/*--------------------------------------------------------------
	>>> Function for Add ACF Fields Table
	----------------------------------------------------------------*/
function hwc_add_acf_fields_league_table()
{
    if (class_exists('ACF')) {

        // League Table ACF Fields
        if (function_exists('acf_add_local_field_group')):
            acf_add_local_field_group(array(
                'key' => 'group_league_table',
                'title' => 'League Table Details',
                'fields' => array(
                    // Repeater for adding multiple teams
                    array(
                        'key' => 'field_league_table_repeater',
                        'label' => 'League Table',
                        'name' => 'league_table',
                        'type' => 'repeater',
                        'button_label' => 'Add Team',
                        'sub_fields' => array(
                            // Team (Post Object)
                            array(
                                'key' => 'field_league_table_team',
                                'label' => 'Team',
                                'name' => 'league_team',
                                'type' => 'post_object',
                                'post_type' => array('team'),
                                'return_format' => 'id',
                                'required' => 1,
                            ),
                            // Played Matches
                            array(
                                'key' => 'field_played_matches',
                                'label' => 'Played Matches',
                                'name' => 'played_matches',
                                'type' => 'number',
                                'default_value' => 0,
                                'min' => 0,
                            ),
                            // Wins
                            array(
                                'key' => 'field_wins',
                                'label' => 'Wins',
                                'name' => 'league_wins',
                                'type' => 'number',
                                'default_value' => 0,
                                'min' => 0,
                            ),
                            // Draws
                            array(
                                'key' => 'field_draws',
                                'label' => 'Draws',
                                'name' => 'league_draws',
                                'type' => 'number',
                                'default_value' => 0,
                                'min' => 0,
                            ),
                            // Losses
                            array(
                                'key' => 'field_losses',
                                'label' => 'Losses',
                                'name' => 'league_losses',
                                'type' => 'number',
                                'default_value' => 0,
                                'min' => 0,
                            ),
                            // Goals For
                            array(
                                'key' => 'field_goals_for',
                                'label' => 'Goals For',
                                'name' => 'league_goals_for',
                                'type' => 'number',
                                'default_value' => 0,
                                'min' => 0,
                            ),
                            // Goals Against
                            array(
                                'key' => 'field_goals_against',
                                'label' => 'Goals Against',
                                'name' => 'league_goals_against',
                                'type' => 'number',
                                'default_value' => 0,
                                'min' => 0,
                            ),
                            // Plus/Minus (Goals Difference)
                            array(
                                'key' => 'field_plus_minus',
                                'label' => 'Plus/Minus',
                                'name' => 'league_plus_minus',
                                'type' => 'number',
                                'default_value' => 0,
                                'min' => 0,
                            ),
                            // Points
                            array(
                                'key' => 'field_points',
                                'label' => 'Points',
                                'name' => 'league_points',
                                'type' => 'number',
                                'default_value' => 0,
                                'min' => 0,
                            ),
                            // Last 6 Games (Repeater for Win/Loss/Draw)
                            array(
                                'key' => 'field_last_6',
                                'label' => 'Last 6 Games',
                                'name' => 'league_last_6_games',
                                'type' => 'repeater',
                                'button_label' => 'Add Result',
                                'min' => 6,
                                'max' => 6, // Limiting it to 6 results
                                'sub_fields' => array(
                                    array(
                                        'key' => 'field_game_result',
                                        'label' => 'Result',
                                        'name' => 'league_game_result',
                                        'type' => 'select',
                                        'choices' => array(
                                            'W' => 'Win',
                                            'D' => 'Draw',
                                            'L' => 'Loss',
                                        ),
                                        'default_value' => 'W',
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'league_table',
                        ),
                    ),
                ),
            ));
        endif;
    }
}
add_action('acf/init', 'hwc_add_acf_fields_league_table');

/*--------------------------------------------------------------
	>>> Function to populate default data for league tables
	----------------------------------------------------------------*/
function hwc_populate_default_data_league_table()
{
    // Check if ACF exists
    if (function_exists('update_field')) {

        // Check if the function has already been run
        if (!get_option('hwc_default_data_league_table_created', false)) {
            // Define league titles and their corresponding league team data
            $leagues_data = array(
                array(
                    'league_title' => 'Premier League',
                    'league_featured_image' => 'JD-Cymru-Premier.png',
                    'league_teams' => array(
                        array(
                            'league_team' => 'Briton Ferry Llansawel',
                            'played_matches' => 7,
                            'league_wins' => 4,
                            'league_draws' => 1,
                            'league_losses' => 2,
                            'league_goals_for' => 20,
                            'goals_against' => 10,
                            'league_plus_minus' => 10,
                            'league_points' => 13,
                            'league_last_6_games' => array('W', 'D', 'W', 'W', 'L', 'W'),
                        ),
                        array(
                            'league_team' => 'Cardiff Met Uni',
                            'played_matches' => 10,
                            'league_wins' => 5,
                            'league_draws' => 3,
                            'league_losses' => 2,
                            'league_goals_for' => 18,
                            'goals_against' => 12,
                            'league_plus_minus' => 6,
                            'league_points' => 18,
                            'league_last_6_games' => array('W', 'D', 'W', 'L', 'D', 'W'),
                        ),
                        // Add more unique league teams as needed...
                    )
                ),
                array(
                    'league_title' => 'Euro Championship',
                    'league_featured_image' => 'JD-Cymru-Premier.png',
                    'league_teams' => array(
                        array(
                            'league_team' => 'Flint Town United',
                            'played_matches' => 10,
                            'league_wins' => 7,
                            'league_draws' => 1,
                            'league_losses' => 2,
                            'league_goals_for' => 22,
                            'goals_against' => 9,
                            'league_plus_minus' => 13,
                            'league_points' => 22,
                            'league_last_6_games' => array('W', 'W', 'W', 'L', 'W', 'W'),
                        ),
                        // Add more unique league teams as needed...
                    )
                ),
                array(
                    'league_title' => 'French League One',
                    'league_featured_image' => 'JD-Cymru-Premier.png',
                    'league_teams' => array(
                        array(
                            'league_team' => 'Caernarfon Town',
                            'played_matches' => 10,
                            'league_wins' => 4,
                            'league_draws' => 3,
                            'league_losses' => 3,
                            'league_goals_for' => 15,
                            'goals_against' => 15,
                            'league_plus_minus' => 0,
                            'league_points' => 15,
                            'league_last_6_games' => array('D', 'L', 'W', 'W', 'D', 'L'),
                        ),
                        // Add more unique league teams as needed...
                    )
                ),
                array(
                    'league_title' => 'Cota League',
                    'league_featured_image' => 'JD-Cymru-Premier.png',
                    'league_teams' => array(
                        array(
                            'league_team' => 'Barry Town United',
                            'played_matches' => 10,
                            'league_wins' => 3,
                            'league_draws' => 4,
                            'league_losses' => 3,
                            'league_goals_for' => 10,
                            'goals_against' => 12,
                            'league_plus_minus' => -2,
                            'league_points' => 13,
                            'league_last_6_games' => array('L', 'D', 'D', 'W', 'L', 'D'),
                        ),
                        // Add more unique league teams as needed...
                    )
                ),
                array(
                    'league_title' => 'National League',
                    'league_featured_image' => 'JD-Cymru-Premier.png',
                    'league_teams' => array(
                        array(
                            'league_team' => 'Bala Town',
                            'played_matches' => 10,
                            'league_wins' => 2,
                            'league_draws' => 2,
                            'league_losses' => 6,
                            'league_goals_for' => 8,
                            'goals_against' => 20,
                            'league_plus_minus' => -12,
                            'league_points' => 8,
                            'league_last_6_games' => array('L', 'L', 'W', 'L', 'D', 'L'),
                        ),
                        // Add more unique league teams as needed...
                    )
                ),
            );

            // Loop through each league and add the league table and league_teams
            foreach ($leagues_data as $league_data) {
                // Check if league title already exists
                $existing_leagues = get_posts(array(
                    'post_type' => 'league_table',
                    'post_status' => 'publish',
                    'title' => $league_data['league_title'],
                    'numberposts' => 1,
                ));



                // Only create the league if it does not exist
                if (empty($existing_leagues)) {
                    // Create league table post
                    $league_post_id = wp_insert_post(array(
                        'post_title' => $league_data['league_title'],
                        'post_type' => 'league_table',
                        'post_status' => 'publish',
                    ));

                    // Set featured image
                    if ($league_data['league_featured_image']) {

                        $league_image_filename = $league_data['league_featured_image'];

                        $league_data_image_id = hwc_create_image_from_plugin($league_image_filename, $league_post_id);
                        if ($league_data_image_id) {
                            set_post_thumbnail(
                                $league_post_id,
                                $league_data_image_id
                            );
                        } else {
                            error_log('Failed to set featured image for player ' . $league_data['league_title']);
                        }
                    }

                    // Check if the post was created successfully
                    if (!is_wp_error($league_post_id)) {
                        // Add league_teams to the league repeater field
                        foreach ($league_data['league_teams'] as $league_team_data) {
                            // Check if the team already exists in the ACF repeater field
                            $existing_teams = get_field('league_table', $league_post_id) ?: array();
                            $team_exists = false;

                            foreach ($existing_teams as $team) {
                                if ($team['league_team'] === $league_team_data['league_team']) {
                                    $team_exists = true;
                                    break;
                                }
                            }

                            $league_team_id = hwc_get_team_id_by_name($league_team_data['league_team']);

                            // Prepare last 6 games for the repeater field
                            $last_6_games = array();
                            foreach ($league_team_data['league_last_6_games'] as $result) {
                                $last_6_games[] = array(
                                    'league_game_result' => $result, // Match the sub-field name
                                );
                            }



                            // If the team does not exist, add it
                            if (!$team_exists) {
                                add_row('league_table', array(
                                    'league_team' => $league_team_id,
                                    'played_matches' => $league_team_data['played_matches'],
                                    'league_wins' => $league_team_data['league_wins'],
                                    'league_draws' => $league_team_data['league_draws'],
                                    'league_losses' => $league_team_data['league_losses'],
                                    'league_goals_for' => $league_team_data['league_goals_for'],
                                    'league_goals_against' => $league_team_data['goals_against'],
                                    'league_plus_minus' => $league_team_data['league_plus_minus'],
                                    'league_points' => $league_team_data['league_points'],
                                    'league_last_6_games' => $last_6_games,
                                ), $league_post_id);
                            }
                        }
                    }
                }
            }
            // After the function has run, set the option to true
            update_option('hwc_default_data_league_table_created', true);
        }
    }
}
