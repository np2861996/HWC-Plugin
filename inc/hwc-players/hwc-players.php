<?php

/**
 * Code For Players info, add data when install and activate the theme.
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hwc
 */

/*--------------------------------------------------------------
	>>> All Action and Filter Functions
	----------------------------------------------------------------*/
add_action('init', 'hwc_register_custom_post_type_Players');
add_action('init', 'hwc_register_player_role_taxonomy', 0);
add_action('init', 'hwc_add_default_player_roles');
add_action('acf/init', 'hwc_add_players_acf_fields');
add_action('acf/init', 'hwc_populate_players_data');


/*--------------------------------------------------------------
	>>> Register Players Post Type
	----------------------------------------------------------------*/
function hwc_register_custom_post_type_Players()
{
    $labels = array(
        'name'                  => _x('Players', 'Post type general name', 'textdomain'),
        'singular_name'         => _x('Player', 'Post type singular name', 'textdomain'),
        'menu_name'             => _x('Players', 'Admin Menu text', 'textdomain'),
        'name_admin_bar'        => _x('Player', 'Add New on Toolbar', 'textdomain'),
        'add_new'               => __('Add New', 'textdomain'),
        'add_new_item'          => __('Add New Player', 'textdomain'),
        'new_item'              => __('New Player', 'textdomain'),
        'edit_item'             => __('Edit Player', 'textdomain'),
        'view_item'             => __('View Player', 'textdomain'),
        'all_items'             => __('All Players', 'textdomain'),
        'search_items'          => __('Search Players', 'textdomain'),
        'parent_item_colon'     => __('Parent Players:', 'textdomain'),
        'not_found'             => __('No players found.', 'textdomain'),
        'not_found_in_trash'    => __('No players found in Trash.', 'textdomain'),
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'query_var'             => true,
        'rewrite'               => array('slug' => 'player'),
        'capability_type'       => 'post',
        'has_archive'           => true,
        'hierarchical'          => false,
        'menu_position'         => 5,
        'supports'              => array('title', 'editor', 'thumbnail'),
    );

    register_post_type('player', $args);
}

/*--------------------------------------------------------------
	>>> Register Players Post Type
----------------------------------------------------------------*/
function hwc_register_player_role_taxonomy()
{
    // Define the taxonomy labels
    $labels = array(
        'name'              => _x('Player Roles', 'taxonomy general name', 'textdomain'),
        'singular_name'     => _x('Player Role', 'taxonomy singular name', 'textdomain'),
        'search_items'      => __('Search Player Roles', 'textdomain'),
        'all_items'         => __('All Player Roles', 'textdomain'),
        'parent_item'       => __('Parent Player Role', 'textdomain'),
        'parent_item_colon' => __('Parent Player Role:', 'textdomain'),
        'edit_item'         => __('Edit Player Role', 'textdomain'),
        'update_item'       => __('Update Player Role', 'textdomain'),
        'add_new_item'      => __('Add New Player Role', 'textdomain'),
        'new_item_name'     => __('New Player Role Name', 'textdomain'),
        'menu_name'         => __('Player Roles', 'textdomain'),
    );

    // Register the taxonomy
    register_taxonomy(
        'player_role', // Taxonomy name
        'player',      // Post type name
        array(
            'hierarchical' => true, // Set to true to enable parent-child relationships
            'labels'        => $labels,
            'show_ui'       => true,
            'show_admin_column' => true,
            'query_var'     => true,
            'rewrite'       => array('slug' => 'player-role'),
        )
    );
}

/*--------------------------------------------------------------
	>>> Function for default_player_roles
----------------------------------------------------------------*/
function hwc_add_default_player_roles()
{
    // Check if the taxonomy exists
    if (taxonomy_exists('player_role')) {
        // Define the terms you want to add
        $terms = array(
            'goalkeepers' => 'Goalkeepers',
            'defenders'   => 'Defenders',
            'midfielders' => 'Midfielders',
            'forwards'    => 'Forwards',
        );

        foreach ($terms as $slug => $name) {
            // Add the term if it doesn't already exist
            if (!term_exists($slug, 'player_role')) {
                wp_insert_term(
                    $name, // Term name
                    'player_role', // Taxonomy
                    array(
                        'slug' => $slug // Term slug
                    )
                );
            }
        }
    }
}


/*--------------------------------------------------------------
	>>> Function for Add Players ACF Fields
	----------------------------------------------------------------*/
function hwc_add_players_acf_fields()
{
    if (class_exists('ACF')) {
        // Players ACF Fields
        if (function_exists('acf_add_local_field_group')):
            acf_add_local_field_group(array(
                'key' => 'group_players',
                'title' => 'Players Details',
                'fields' => array(
                    array(
                        'key' => 'field_team_selection',
                        'label' => 'Team Selection',
                        'name' => 'team_selection',
                        'type' => 'post_object',
                        'post_type' => array('team'),
                        'return_format' => 'id',
                        'multiple' => 0,
                        'required' => 1, // Set to 1 for required, 0 for not required
                        'default_value' => 1,
                    ),
                    array(
                        'key' => 'field_player_number',
                        'label' => 'Player Number',
                        'name' => 'player_number',
                        'type' => 'number',
                        'default_value' => 'Default Position',
                        'required' => 1, // Set to 1 for required, 0 for not required
                    ),
                    // Player Background Image
                    array(
                        'key' => 'field_player_background_image',
                        'label' => 'Player Background Image',
                        'name' => 'player_background_image',
                        'type' => 'image',
                        'return_format' => 'id',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'required' => 0,
                    ),
                    // Player First Name
                    array(
                        'key' => 'field_player_first_name',
                        'label' => 'Player First Name',
                        'name' => 'player_first_name',
                        'type' => 'text',
                        'required' => 1,
                    ),
                    // Player Last Name
                    array(
                        'key' => 'field_player_last_name',
                        'label' => 'Player Last Name',
                        'name' => 'player_last_name',
                        'type' => 'text',
                        'required' => 1,
                    ),
                    // Player Right Card Image
                    array(
                        'key' => 'field_player_right_card_image',
                        'label' => 'Player Right Card Image',
                        'name' => 'player_right_card_image',
                        'type' => 'image',
                        'return_format' => 'id',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'required' => 0,
                    ),
                    // Player Right Card Title
                    array(
                        'key' => 'field_player_right_card_title',
                        'label' => 'Player Right Card Title',
                        'name' => 'player_right_card_title',
                        'type' => 'text',
                        'required' => 0,
                    ),
                    // Player Right Card Title 2
                    array(
                        'key' => 'field_player_right_card_title_2',
                        'label' => 'Player Right Card Title 2',
                        'name' => 'player_right_card_title_2',
                        'type' => 'text',
                        'required' => 0,
                    ),
                    // Player Right Card Button
                    array(
                        'key' => 'field_player_right_card_button',
                        'label' => 'Player Right Card Button',
                        'name' => 'player_right_card_button',
                        'type' => 'link',
                        'required' => 0,
                        'return_format' => 'array', // You can use 'url', 'array', or 'both' depending on your needs
                    ),
                    // Player player_stats_title
                    array(
                        'key' => 'field_stats_title',
                        'label' => 'Player Stats Title',
                        'name' => 'player_stats_title',
                        'type' => 'text',
                        'required' => 0,
                    ),
                    // Player States Repeater
                    array(
                        'key' => 'field_player_stats_repeater',
                        'label' => 'Player Stats Repeater',
                        'name' => 'player_stats',
                        'type' => 'repeater',
                        'required' => 0,
                        'sub_fields' => array(
                            array(
                                'key' => 'field_player_stat_title_1',
                                'label' => 'Stat Title 1',
                                'name' => 'stat_title_1',
                                'type' => 'text',
                                'required' => 0,
                            ),
                            array(
                                'key' => 'field_player_stat_title_2',
                                'label' => 'Stat Title 2',
                                'name' => 'stat_title_2',
                                'type' => 'text',
                                'required' => 0,
                            ),
                        ),
                        'min' => 0,
                        'max' => 0,
                        'layout' => 'block',
                    ),
                    // Player Biography Title
                    array(
                        'key' => 'field_player_biography_title',
                        'label' => 'Player Biography Title',
                        'name' => 'player_biography_title',
                        'type' => 'text',
                        'required' => 0,
                    ),
                    // Player Big Image 1
                    array(
                        'key' => 'field_player_big_image_1',
                        'label' => 'Player Big Image 1',
                        'name' => 'player_big_image_1',
                        'type' => 'image',
                        'return_format' => 'id',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'required' => 0,
                    ),
                    // Player Big Image 2
                    array(
                        'key' => 'field_player_big_image_2',
                        'label' => 'Player Big Image 2',
                        'name' => 'player_big_image_2',
                        'type' => 'image',
                        'return_format' => 'id',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'required' => 0,
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'player',
                        ),
                    ),
                ),
            ));
        endif;
    }
}

/*--------------------------------------------------------------
	>>> Function for add players data
	----------------------------------------------------------------*/
// Populate Default Data only once
function hwc_populate_players_data()
{
    // Check if the function has already been run
    //  if (!get_option('hwc_players_data_posts_created', false)) {
    // Define player data array within the function
    $players_data = array(
        array(
            'background_image' => 'playerbg.jpg',
            'featured_image' => '51HFC290815_PlayerProfiles2425ZacJones.jpg',
            'title' => 'Zac Jones',
            'number' => 1,
            'first_name' => 'Zac',
            'last_name' => 'Jones',
            'role' => 'Goalkeepers',
            'right_card_image' => 'thatfootballdrawing.png',
            'right_card_title' => 'That Football Drawing',
            'right_card_title_2' => 'Player Sponsor',
            'button' => array('url' => 'https://example.com/', 'title' => 'Visit Website'),
            'player_stats_title' => '2024/25 Stats',
            'stats' => array(
                array('stat_title_1' => '5', 'stat_title_2' => 'Appearances'),
                array('stat_title_1' => '5', 'stat_title_2' => 'Starts'),
                array('stat_title_1' => '450\'', 'stat_title_2' => 'Mins'),
                array('stat_title_1' => '60%', 'stat_title_2' => 'Win %'),
                array('stat_title_1' => '2', 'stat_title_2' => 'Goals'),
                array('stat_title_1' => '1', 'stat_title_2' => 'Bookings'),
                array('stat_title_1' => '0', 'stat_title_2' => 'Sent Off')
            ),
            'biography_title' => 'Biography',
            'description' => 'Zac, who hails from Wellington in New Zealand, arrived at the club in January 2022 after playing for the likes of Team Wellington, Wellington Olympic, Wellington Phoenix and Miramar Rangers. The 23-year-old goalkeeper, who has represented his country at under-17 and under-20 level, achieved success in his native country, winning the New Zealand Football Championship in March 2021 and first instalment of the newly-created New Zealand National League in December 2021. The highlight of his time with the Bluebirds to date came in July 2023, when his penalty shoot-out save clinched victory over KF Shkëndija in the UEFA Europa Conference first qualifying round at the Cardiff City Stadium.',
            'big_image_1' => 'player-image1.jpg',
            'big_image_2' => 'player-image2.jpg',
        ),
        array(
            'background_image' => 'Hwest-County-vs-Cardiff-City-u21-151-scaled.jpg',
            'featured_image' => '51HFC290815_PlayerProfiles2425IfanKnott.jpg',
            'title' => 'Ifan Knott',
            'number' => 12,
            'first_name' => 'Ifan',
            'last_name' => 'Knott',
            'role' => 'Goalkeepers',
            'right_card_image' => '',
            'right_card_title' => 'Weston Geotech',
            'right_card_title_2' => 'Player Sponsor',
            'button' => array('url' => '', 'title' => ''),
            'player_stats_title' => '',
            'stats' => array(
                array('stat_title_1' => '', 'stat_title_2' => ''),
                array('stat_title_1' => '', 'stat_title_2' => ''),
                array('stat_title_1' => '', 'stat_title_2' => ''),
                array('stat_title_1' => '', 'stat_title_2' => ''),
                array('stat_title_1' => '', 'stat_title_2' => ''),
                array('stat_title_1' => '', 'stat_title_2' => ''),
                array('stat_title_1' => '', 'stat_title_2' => '')
            ),
            'biography_title' => 'Biography',
            'description' => '<p>The 18-year-old joined the Bluebirds this summer from Carmarthen Town, where he made 24 senior appearances in all competitions.</p><p>Knott, who joined County on a one-year deal, played 11 times in the JD Cymru South last season, and will now have the opportunity to experience top-flight football as he continues his development.</p><p>Having also featured in both the JD Welsh Cup and the Nathaniel MG Cup for the Old Gold, Knott has already gained a lot of experience in the early stages of his career, and follows Rio Dyer and Kai Whitmore in linking up with the Town for 2023-24.</p>',
            'big_image_1' => '230803_Haverfordwest-County-v-B36-Torshavn_164.jpg',
            'big_image_2' => '',
        ),
        array(
            'background_image' => '2023-05-13-Newtown-AFC-vs-Haverfordwest-County-AFC-248.jpg',
            'featured_image' => '51HFC290815_PlayerProfiles2425RhysAbu.jpg',
            'title' => 'Rhys Abbruzzese',
            'number' => 3,
            'first_name' => 'Rhys',
            'last_name' => 'Abbruzzese',
            'role' => 'Defenders',
            'right_card_image' => '',
            'right_card_title' => 'Player Sponsorship',
            'right_card_title_2' => 'Available',
            'button' => array('url' => 'https://example.com/', 'title' => 'Sponsor'),
            'player_stats_title' => '',
            'stats' => array(
                array('stat_title_1' => '', 'stat_title_2' => ''),
                array('stat_title_1' => '', 'stat_title_2' => ''),
                array('stat_title_1' => '', 'stat_title_2' => ''),
                array('stat_title_1' => '', 'stat_title_2' => ''),
                array('stat_title_1' => '', 'stat_title_2' => ''),
                array('stat_title_1' => '', 'stat_title_2' => ''),
                array('stat_title_1' => '', 'stat_title_2' => '')
            ),
            'biography_title' => 'Biography',
            'description' => '<p>Rhys linked up with the Bluebirds in the summer of 2022 after leaving Barry Town United. A former Wales age grade international, the left-back came through the academy ranks at Cardiff City before joining the Linnets in 2019. The 26-year-old made his debut in the 4-2 victory over Barry Town United in the second round of the Nathaniel MG Cup in August, and netted a goal against his former side. He was named in the JD Cymru Premier Team of the Season for 2023-24 after a very impressive campaign.</p>',
            'big_image_1' => 'Hwest-County-vs-Pontypridd-Utd-054-scaled.jpg',
            'big_image_2' => 'Bont-v-HWest_17.jpg',
        ),
        array(
            'background_image' => '2023-05-13-Newtown-AFC-vs-Haverfordwest-County-AFC-242.jpg',
            'featured_image' => '51HFC290815_PlayerProfiles2425DylanRees.jpg',
            'title' => 'Dylan Rees',
            'number' => 5,
            'first_name' => 'Dylan',
            'last_name' => 'Rees',
            'role' => 'Defenders',
            'right_card_image' => '',
            'right_card_title' => 'Rib & Oyster',
            'right_card_title_2' => 'Player Sponsor',
            'button' => array('url' => 'https://example.com/', 'title' => 'Visit Website'),
            'player_stats_title' => '',
            'stats' => array(
                array('stat_title_1' => '', 'stat_title_2' => ''),
                array('stat_title_1' => '', 'stat_title_2' => ''),
                array('stat_title_1' => '', 'stat_title_2' => ''),
                array('stat_title_1' => '', 'stat_title_2' => ''),
                array('stat_title_1' => '', 'stat_title_2' => ''),
                array('stat_title_1' => '', 'stat_title_2' => ''),
                array('stat_title_1' => '', 'stat_title_2' => '')
            ),
            'biography_title' => 'Biography',
            'description' => '<p>Dylan signed for Haverfordwest County ahead of the 2021-22 season, and was immediately handed the captain’s armband. Rees, 27, is a former member of the Cardiff City academy setup, and has also played football in Sweden with Karlstad BK. The majority of his senior football has been played at Cardiff Metropolitan, where he spent four years between 2017 and 2021. The defender achieved a great deal during his time in the capital, including playing – and scoring – in Europa League qualifying, winning the Nathaniel MG Cup and being selected for the Wales C international team, for whom he started in the 2-2 draw with England in Salford.</p>',
            'big_image_1' => 'Hwest-County-vs-Airbus-082-scaled.jpg',
            'big_image_2' => 'Hwest-County-vs-Airbus-124-scaled.jpg',
        ),
        array(
            'background_image' => '2023-07-20-Haverfordwest-County-v-KF-Shkendija-52-scaled.jpg',
            'featured_image' => '51HFC290815_PlayerProfiles2425LeeJenkins.jpg',
            'title' => 'Lee Jenkins',
            'number' => 6,
            'first_name' => 'Lee',
            'last_name' => 'Jenkins',
            'role' => 'Defenders',
            'right_card_image' => '',
            'right_card_title' => 'Player Sponsorship',
            'right_card_title_2' => 'Available',
            'button' => array('url' => 'https://example.com/', 'title' => 'Visit Website'),
            'player_stats_title' => '2024/25 Stats',
            'stats' => array(
                array('stat_title_1' => '8', 'stat_title_2' => 'Appearances'),
                array('stat_title_1' => '8', 'stat_title_2' => 'Starts'),
                array('stat_title_1' => '720\'', 'stat_title_2' => 'Mins'),
                array('stat_title_1' => '50%', 'stat_title_2' => 'Win %'),
                array('stat_title_1' => '1', 'stat_title_2' => 'Goals'),
                array('stat_title_1' => '0', 'stat_title_2' => 'Bookings'),
                array('stat_title_1' => '0', 'stat_title_2' => 'Sent Off')
            ),
            'biography_title' => 'Biography',
            'description' => '<p>Lee joined the club from Aberystwyth Town in the summer of 2022, having already played over 70 games in the JD Cymru Premier by the age of 20. A commanding presence in the air, Jenkins has demonstrated his ability to be a potent weapon in both boxes, whether it is defending or attacking set-pieces. The centre-back created history in the summer of 2023 when he became just the second Haverfordwest County AFC player to score in European competition when his 89th-minute goal levelled our UEFA Europa Conference League first qualifying round tie with KF Shkëndija of North Macedonia, before we went on to triumph on penalties.</p>',
            'big_image_1' => 'Hwest-County-vs-Pontypridd-Utd-128-scaled.jpg',
            'big_image_2' => 'Bont-v-HWest_43.jpg',
        ),
        array(
            'background_image' => '2023-07-20-Haverfordwest-County-v-KF-Shkendija-58.jpg',
            'featured_image' => '51HFC290815_PlayerProfiles2425RickyWatts.jpg',
            'title' => 'Ricky Watts',
            'number' => 24,
            'first_name' => 'Ricky',
            'last_name' => 'Watts',
            'role' => 'Midfielders',
            'right_card_image' => '',
            'right_card_title' => 'Cleddau Casuals',
            'right_card_title_2' => 'Player Sponsor',
            'button' => array('url' => '', 'title' => ''),
            'player_stats_title' => '2024/25 Stats',
            'stats' => array(
                array('stat_title_1' => '8', 'stat_title_2' => 'Appearances'),
                array('stat_title_1' => '8', 'stat_title_2' => 'Starts'),
                array('stat_title_1' => '720\'', 'stat_title_2' => 'Mins'),
                array('stat_title_1' => '50%', 'stat_title_2' => 'Win %'),
                array('stat_title_1' => '1', 'stat_title_2' => 'Goals'),
                array('stat_title_1' => '0', 'stat_title_2' => 'Bookings'),
                array('stat_title_1' => '0', 'stat_title_2' => 'Sent Off')
            ),
            'biography_title' => 'Biography',
            'description' => '<p>Ricky is the longest-serving member of the current squad, with the 2023-24 season being his 13th at the Ogi Bridge Meadow since making his debut in 2009, after coming through the academy setup. The midfielder, who serves as club captain, had a one-year stint with Aberystwyth Town between 2016 and 2017 before returning to his local club, where he has gone on to play an integral role over the last five seasons.</p>',
            'big_image_1' => '2023-07-20-Haverfordwest-County-v-KF-Shkendija-166.jpg',
            'big_image_2' => 'Bont-v-HWest_41.jpg',
        ),
        array(
            'background_image' => '230803_Haverfordwest-County-v-B36-Torshavn_89.jpg',
            'featured_image' => '51HFC290815_PlayerProfiles2425BenFawcett.jpg',
            'title' => 'Ben Fawcett',
            'number' => 9,
            'first_name' => 'Ben',
            'last_name' => 'Fawcett',
            'role' => 'Forwards',
            'right_card_image' => '',
            'right_card_title' => 'OG Barbers',
            'right_card_title_2' => 'Player Sponsor',
            'button' => array('url' => 'https://example.com/', 'title' => 'Visit Website'),
            'player_stats_title' => '2024/25 Stats',
            'stats' => array(
                array('stat_title_1' => '8', 'stat_title_2' => 'Appearances'),
                array('stat_title_1' => '8', 'stat_title_2' => 'Starts'),
                array('stat_title_1' => '720\'', 'stat_title_2' => 'Mins'),
                array('stat_title_1' => '50%', 'stat_title_2' => 'Win %'),
                array('stat_title_1' => '1', 'stat_title_2' => 'Goals'),
                array('stat_title_1' => '0', 'stat_title_2' => 'Bookings'),
                array('stat_title_1' => '0', 'stat_title_2' => 'Sent Off')
            ),
            'biography_title' => 'Biography',
            'description' => '<p>Ben is a product of the academy setup at Haverfordwest County AFC, and one of the most exciting young players in the league. After his 10 goals helped the Bluebirds to a second-placed finish in the JD Cymru South in 2019-20, he immediately settled into the top-flight with seven goals in his debut season. His performances in the 2022-23 season – which saw him net eight goals in the JD Cymru Premier – saw him rewarded with a call-up to the Wales C international team, who beat England C 4-0 in Caernarfon. In the summer of 2023, Ben became one of only four players to score in European competition when his goal against B36 Tórshavn at the Cardiff City Stadium levelled our UEFA Europa Conference League second qualifying round tie at 2-2, before we were edged out 3-2 after extra time.</p>',
            'big_image_1' => 'Hwest-County-vs-Pontypridd-Utd-058-scaled.jpg',
            'big_image_2' => '2020-12-16-Haverfordwest-v-Barry-Town-49.jpg',
        ),
        // Add more players as needed
    );

    // Fetch all team IDs dynamically
    $hwc_teams_query = new WP_Query(array(
        'post_type' => 'team',
        'posts_per_page' => -1,
        'fields' => 'ids' // Only fetch IDs
    ));

    $hwc_teams = $hwc_teams_query->posts;

    // Loop through each player in the players_data array
    foreach ($players_data as $player_data) {

        // Check if the player already exists by title or any unique identifier
        $existing_player = new WP_Query(array(
            'post_type' => 'player',
            'title' => sanitize_text_field($player_data['title']),
            'posts_per_page' => 1,
            'fields' => 'ids' // Only fetch IDs
        ));

        // If a player with the same title already exists, skip this iteration
        if ($existing_player->have_posts()) {
            error_log('Player with title ' . $player_data['title'] . ' already exists, skipping...');
            continue;
        }

        // Insert the player post
        $player_id = wp_insert_post(array(
            'post_type' => 'player',
            'post_title' => $player_data['title'],
            'post_content' => $player_data['description'],
            'post_status' => 'publish',
        ));

        // Check if the player post was created successfully
        if (!is_wp_error($player_id)) {
            // Retrieve terms from the 'player_role' taxonomy
            $taxonomy = 'player_role';
            $terms = get_terms(array(
                'taxonomy'   => $taxonomy,
                'hide_empty' => false,
            ));

            // Check if terms were retrieved successfully
            if (
                !is_wp_error($terms) && !empty($terms)
            ) {
                // Select a random term
                $random_term = $terms[array_rand($terms)]->term_id;

                // Assign the random term to the player post
                wp_set_post_terms($player_id, array($random_term), $taxonomy);
            }
        }

        if (is_wp_error($player_id)) {
            error_log('Failed to insert player post: ' . $player_id->get_error_message());
            continue; // Skip to the next player if this one fails
        }

        // Assign a random team to the player
        if (!empty($hwc_teams)) {
            $random_team_id = $hwc_teams[array_rand($hwc_teams)];
            update_field('team_selection', array($random_team_id), $player_id);
        }

        // Set ACF fields
        update_field(
            'player_number',
            $player_data['number'],
            $player_id
        );
        update_field('player_first_name', $player_data['first_name'], $player_id);
        update_field('player_last_name', $player_data['last_name'], $player_id);
        update_field('player_biography_title', $player_data['biography_title'], $player_id);
        update_field('player_stats_title', $player_data['player_stats_title'], $player_id);

        // Set player stats
        update_field(
            'player_stats',
            $player_data['stats'],
            $player_id
        );

        // Set player background image
        if ($player_data['background_image']) {

            $bg_image_id = hwc_create_image_from_plugin($player_data['background_image'], $player_id);

            if (!is_wp_error($bg_image_id)) {
                update_field('player_background_image', $bg_image_id, $player_id);
            } else {
                error_log('Failed to upload background image: ' . $bg_image_id->get_error_message());
            }
        }

        // Set big images
        if ($player_data['big_image_1']) {

            $big_image_1_id = hwc_create_image_from_plugin($player_data['big_image_1'], $player_id);

            if (!is_wp_error($big_image_1_id)) {
                update_field('player_big_image_1', $big_image_1_id, $player_id);
            } else {
                error_log('Failed to upload big image 1: ' . $big_image_1_id->get_error_message());
            }
        }

        if ($player_data['big_image_2']) {

            $big_image_2_id = hwc_create_image_from_plugin($player_data['big_image_2'], $player_id);

            if (!is_wp_error($big_image_2_id)) {
                update_field('player_big_image_2', $big_image_2_id, $player_id);
            } else {
                error_log('Failed to upload big image 2: ' . $big_image_2_id->get_error_message());
            }
        }

        // Set right card content
        if ($player_data['right_card_image']) {

            $right_card_image_id = hwc_create_image_from_plugin($player_data['right_card_image'], $player_id);

            if (!is_wp_error($right_card_image_id)) {
                update_field('player_right_card_image', $right_card_image_id, $player_id);
            } else {
                error_log('Failed to upload right card image: ' . $right_card_image_id->get_error_message());
            }
        }

        update_field('player_right_card_title', $player_data['right_card_title'], $player_id);
        update_field('player_right_card_title_2', $player_data['right_card_title_2'], $player_id);
        update_field('player_right_card_button', array(
            'url' => $player_data['button']['url'],
            'title' => $player_data['button']['title'],
        ), $player_id);

        // Set featured image
        if ($player_data['featured_image']) {

            $image_filename = $player_data['featured_image'];

            $image_id = hwc_create_image_from_plugin($image_filename, $player_id);
            if ($image_id) {
                set_post_thumbnail($player_id, $image_id);
            } else {
                error_log('Failed to set featured image for player ' . $player_data['title']);
            }
        }
    }
    // After the function has run, set the option to true
    //update_option('hwc_players_data_posts_created', true);
    //   }
}
//end