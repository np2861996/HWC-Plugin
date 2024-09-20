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
add_action('init', 'hwc_register_custom_post_type_Staff');
add_action('init', 'hwc_register_staff_role_taxonomy', 0);
add_action('init', 'hwc_add_default_staff_roles', 1);
add_action('acf/init', 'hwc_add_staff_acf_fields');
add_action('acf/init', 'hwc_populate_staff_data', 2);

/*--------------------------------------------------------------
	>>> Register Staff Post Type
----------------------------------------------------------------*/
function hwc_register_custom_post_type_Staff()
{
    $labels = array(
        'name'                  => _x('Staff', 'Post type general name', 'textdomain'),
        'singular_name'         => _x('Staff', 'Post type singular name', 'textdomain'),
        'menu_name'             => _x('Staff', 'Admin Menu text', 'textdomain'),
        'name_admin_bar'        => _x('Staff', 'Add New on Toolbar', 'textdomain'),
        'add_new'               => __('Add New', 'textdomain'),
        'add_new_item'          => __('Add New Staff', 'textdomain'),
        'new_item'              => __('New Staff', 'textdomain'),
        'edit_item'             => __('Edit Staff', 'textdomain'),
        'view_item'             => __('View Staff', 'textdomain'),
        'all_items'             => __('All Staff', 'textdomain'),
        'search_items'          => __('Search Staff', 'textdomain'),
        'parent_item_colon'     => __('Parent Staff:', 'textdomain'),
        'not_found'             => __('No staff found.', 'textdomain'),
        'not_found_in_trash'    => __('No staff found in Trash.', 'textdomain'),
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'query_var'             => true,
        'rewrite'               => array('slug' => 'staff'),
        'capability_type'       => 'post',
        'has_archive'           => true,
        'hierarchical'          => false,
        'menu_position'         => 5,
        'supports'              => array('title', 'editor', 'thumbnail'),
    );

    register_post_type('staff', $args);
}

/*--------------------------------------------------------------
	>>> Register Staff Post Type
----------------------------------------------------------------*/
function hwc_register_staff_role_taxonomy()
{
    // Define the taxonomy labels
    $labels = array(
        'name'              => _x('Staff Roles', 'taxonomy general name', 'textdomain'),
        'singular_name'     => _x('Staff Role', 'taxonomy singular name', 'textdomain'),
        'search_items'      => __('Search Staff Roles', 'textdomain'),
        'all_items'         => __('All Staff Roles', 'textdomain'),
        'parent_item'       => __('Parent Staff Role', 'textdomain'),
        'parent_item_colon' => __('Parent Staff Role:', 'textdomain'),
        'edit_item'         => __('Edit Staff Role', 'textdomain'),
        'update_item'       => __('Update Staff Role', 'textdomain'),
        'add_new_item'      => __('Add New Staff Role', 'textdomain'),
        'new_item_name'     => __('New Staff Role Name', 'textdomain'),
        'menu_name'         => __('Staff Roles', 'textdomain'),
    );

    // Register the taxonomy
    register_taxonomy(
        'staff_role', // Taxonomy name
        'staff',      // Post type name
        array(
            'hierarchical' => true, // Set to true to enable parent-child relationships
            'labels'        => $labels,
            'show_ui'       => true,
            'show_admin_column' => true,
            'query_var'     => true,
            'rewrite'       => array('slug' => 'staff-role'),
        )
    );
}

/*--------------------------------------------------------------
	>>> Function for default_staff_roles
----------------------------------------------------------------*/
function hwc_add_default_staff_roles()
{
    // Check if the taxonomy exists
    if (taxonomy_exists('staff_role')) {
        // Define the terms you want to add
        $terms = array(
            'manager' => 'Manager',
            'assistant-manager'   => 'Assistant Manager',
            'goalkeeping-coach' => 'Goalkeeping Coach',
            'doctor'    => 'Doctor',
            'sports-therapist'    => 'Sports Therapist',
            'kitman'    => 'Kitman',
        );

        foreach ($terms as $slug => $name) {
            // Add the term if it doesn't already exist
            if (!term_exists($slug, 'staff_role')) {
                wp_insert_term(
                    $name, // Term name
                    'staff_role', // Taxonomy
                    array(
                        'slug' => $slug // Term slug
                    )
                );
            }
        }
    }
}

/*--------------------------------------------------------------
	>>> Function for Add Staff ACF Fields
	----------------------------------------------------------------*/
function hwc_add_staff_acf_fields()
{
    if (class_exists('ACF')) {
        // Staff ACF Fields
        if (function_exists('acf_add_local_field_group')):
            acf_add_local_field_group(array(
                'key' => 'group_staff',
                'title' => 'Staff Details',
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
                        'key' => 'field_staff_number',
                        'label' => 'Staff Number',
                        'name' => 'staff_number',
                        'type' => 'number',
                        'default_value' => 'Default Position',
                        'required' => 1, // Set to 1 for required, 0 for not required
                    ),
                    // Staff Background Image
                    array(
                        'key' => 'field_staff_background_image',
                        'label' => 'Staff Background Image',
                        'name' => 'staff_background_image',
                        'type' => 'image',
                        'return_format' => 'id',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'required' => 0,
                    ),
                    // Staff First Name
                    array(
                        'key' => 'field_staff_first_name',
                        'label' => 'Staff First Name',
                        'name' => 'staff_first_name',
                        'type' => 'text',
                        'required' => 1,
                    ),
                    // Staff Last Name
                    array(
                        'key' => 'field_staff_last_name',
                        'label' => 'Staff Last Name',
                        'name' => 'staff_last_name',
                        'type' => 'text',
                        'required' => 1,
                    ),
                    // Staff Right Card Image
                    array(
                        'key' => 'field_staff_right_card_image',
                        'label' => 'Staff Right Card Image',
                        'name' => 'staff_right_card_image',
                        'type' => 'image',
                        'return_format' => 'id',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'required' => 0,
                    ),
                    // Staff Right Card Title
                    array(
                        'key' => 'field_staff_right_card_title',
                        'label' => 'Staff Right Card Title',
                        'name' => 'staff_right_card_title',
                        'type' => 'text',
                        'required' => 0,
                    ),
                    // Staff Right Card Title 2
                    array(
                        'key' => 'field_staff_right_card_title_2',
                        'label' => 'Staff Right Card Title 2',
                        'name' => 'staff_right_card_title_2',
                        'type' => 'text',
                        'required' => 0,
                    ),
                    // Staff Right Card Button
                    array(
                        'key' => 'field_staff_right_card_button',
                        'label' => 'Staff Right Card Button',
                        'name' => 'staff_right_card_button',
                        'type' => 'link',
                        'required' => 0,
                        'return_format' => 'array', // You can use 'url', 'array', or 'both' depending on your needs
                    ),
                    // Staff staff_stats_title
                    array(
                        'key' => 'field_stats_title',
                        'label' => 'Staff Stats Title',
                        'name' => 'staff_stats_title',
                        'type' => 'text',
                        'required' => 0,
                    ),
                    // Staff States Repeater
                    array(
                        'key' => 'field_staff_stats_repeater',
                        'label' => 'Staff Stats Repeater',
                        'name' => 'staff_stats',
                        'type' => 'repeater',
                        'required' => 0,
                        'sub_fields' => array(
                            array(
                                'key' => 'field_staff_stat_title_1',
                                'label' => 'Stat Title 1',
                                'name' => 'stat_title_1',
                                'type' => 'text',
                                'required' => 0,
                            ),
                            array(
                                'key' => 'field_staff_stat_title_2',
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
                    // Staff Biography Title
                    array(
                        'key' => 'field_staff_biography_title',
                        'label' => 'Staff Biography Title',
                        'name' => 'staff_biography_title',
                        'type' => 'text',
                        'required' => 0,
                    ),
                    // Staff Big Image 1
                    array(
                        'key' => 'field_staff_big_image_1',
                        'label' => 'Staff Big Image 1',
                        'name' => 'staff_big_image_1',
                        'type' => 'image',
                        'return_format' => 'id',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'required' => 0,
                    ),
                    // Staff Big Image 2
                    array(
                        'key' => 'field_staff_big_image_2',
                        'label' => 'Staff Big Image 2',
                        'name' => 'staff_big_image_2',
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
                            'value' => 'staff',
                        ),
                    ),
                ),
            ));
        endif;
    }
}

/*--------------------------------------------------------------
	>>> Function for add staff data
	----------------------------------------------------------------*/
// Populate Default Data only once
function hwc_populate_staff_data()
{
    // Check if the function has already been run
    //  if (!get_option('hwc_staff_data_posts_created', false)) {
    // Define staff data array within the function
    $staff_data = array(
        array(
            'background_image' => 'playerbg.jpg',
            'featured_image' => '32HFC0805_StaffProfilesBlank.jpg',
            'title' => 'Tony Pennock',
            'number' => 1,
            'first_name' => 'Tony',
            'last_name' => 'Pennock',
            'role_staff' => 'Manager',
            'right_card_image' => 'thatfootballdrawing.png',
            'right_card_title' => 'That Football Drawing',
            'right_card_title_2' => 'Staff Sponsor',
            'button' => array('url' => 'https://example.com/', 'title' => 'Visit Website'),
            'staff_stats_title' => '2024/25 Stats',
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
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'big_image_1' => 'staff-image1.jpg',
            'big_image_2' => 'staff-image2.jpg',
        ),
        array(
            'background_image' => 'Hwest-County-vs-Cardiff-City-u21-151-scaled.jpg',
            'featured_image' => '32HFC0805_StaffProfilesBlank.jpg',
            'title' => 'Gary Richards',
            'number' => 12,
            'first_name' => 'Gary',
            'last_name' => 'Richards',
            'role_staff' => 'Assistant Manager',
            'right_card_image' => '',
            'right_card_title' => 'Weston Geotech',
            'right_card_title_2' => 'Staff Sponsor',
            'button' => array('url' => '', 'title' => ''),
            'staff_stats_title' => '',
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
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'big_image_1' => '230803_Haverfordwest-County-v-B36-Torshavn_164.jpg',
            'big_image_2' => '',
        ),
        array(
            'background_image' => '2023-05-13-Newtown-AFC-vs-Haverfordwest-County-AFC-248.jpg',
            'featured_image' => '32HFC0805_StaffProfilesBlank.jpg',
            'title' => 'Rob Abbruzzese',
            'number' => 3,
            'first_name' => 'Rob',
            'last_name' => 'Abbruzzese',
            'role_staff' => 'Goalkeeping Coach',
            'right_card_image' => '',
            'right_card_title' => 'Staff Sponsorship',
            'right_card_title_2' => 'Available',
            'button' => array('url' => 'https://example.com/', 'title' => 'Sponsor'),
            'staff_stats_title' => '',
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
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'big_image_1' => 'Hwest-County-vs-Pontypridd-Utd-054-scaled.jpg',
            'big_image_2' => 'Bont-v-HWest_17.jpg',
        ),
        array(
            'background_image' => '2023-05-13-Newtown-AFC-vs-Haverfordwest-County-AFC-242.jpg',
            'featured_image' => '32HFC0805_StaffProfilesBlank.jpg',
            'title' => 'Dylan Rees',
            'number' => 5,
            'first_name' => 'Dylan',
            'last_name' => 'Rees',
            'role_staff' => 'Doctor',
            'right_card_image' => '',
            'right_card_title' => 'Rib & Oyster',
            'right_card_title_2' => 'Staff Sponsor',
            'button' => array('url' => 'https://example.com/', 'title' => 'Visit Website'),
            'staff_stats_title' => '',
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
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'big_image_1' => 'Hwest-County-vs-Airbus-082-scaled.jpg',
            'big_image_2' => 'Hwest-County-vs-Airbus-124-scaled.jpg',
        ),
        array(
            'background_image' => '2023-07-20-Haverfordwest-County-v-KF-Shkendija-52-scaled.jpg',
            'featured_image' => '32HFC0805_StaffProfilesBlank.jpg',
            'title' => 'Lee Jenkins',
            'number' => 6,
            'first_name' => 'Lee',
            'last_name' => 'Jenkins',
            'role_staff' => 'Sports Therapist',
            'right_card_image' => '',
            'right_card_title' => 'Staff Sponsorship',
            'right_card_title_2' => 'Available',
            'button' => array('url' => 'https://example.com/', 'title' => 'Visit Website'),
            'staff_stats_title' => '2024/25 Stats',
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
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'big_image_1' => 'Hwest-County-vs-Pontypridd-Utd-128-scaled.jpg',
            'big_image_2' => 'Bont-v-HWest_43.jpg',
        ),
        array(
            'background_image' => '2023-07-20-Haverfordwest-County-v-KF-Shkendija-58.jpg',
            'featured_image' => '32HFC0805_StaffProfilesBlank.jpg',
            'title' => 'Ricky Watts',
            'number' => 24,
            'first_name' => 'Ricky',
            'last_name' => 'Watts',
            'role_staff' => 'Kitman',
            'right_card_image' => '',
            'right_card_title' => 'Cleddau Casuals',
            'right_card_title_2' => 'Staff Sponsor',
            'button' => array('url' => '', 'title' => ''),
            'staff_stats_title' => '2024/25 Stats',
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
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'big_image_1' => '2023-07-20-Haverfordwest-County-v-KF-Shkendija-166.jpg',
            'big_image_2' => 'Bont-v-HWest_41.jpg',
        )
        // Add more staff as needed
    );

    // Fetch all team IDs dynamically
    $hwc_teams_query = new WP_Query(array(
        'post_type' => 'team',
        'posts_per_page' => -1,
        'fields' => 'ids' // Only fetch IDs
    ));

    if (!is_wp_error($hwc_teams_query)) {
        $hwc_teams = $hwc_teams_query->posts;

        // Loop through each staff in the staff_data array
        foreach ($staff_data as $staff_data_item) {
            // Check if the staff already exists
            $existing_staff = new WP_Query(array(
                'post_type' => 'staff',
                'title' => sanitize_text_field($staff_data_item['title']),
                'posts_per_page' => 1,
                'fields' => 'ids' // Only fetch IDs
            ));

            if ($existing_staff->have_posts()) {
                //error_log('Staff with title ' . $staff_data_item['title'] . ' already exists, skipping...');
                continue;
            }

            // Insert the staff post
            $staff_id = wp_insert_post(array(
                'post_type' => 'staff',
                'post_title' => $staff_data_item['title'],
                'post_content' => $staff_data_item['description'],
                'post_status' => 'publish',
            ));

            if (is_wp_error($staff_id)) {
                error_log('Failed to insert staff post: ' . $staff_id->get_error_message());
                continue;
            }

            // Check if the staff post was created successfully
            if (!is_wp_error($staff_id)) {
                // Retrieve terms from the 'player_role' taxonomy
                $taxonomy = 'staff_role';
                $terms = get_terms(array(
                    'taxonomy'   => $taxonomy,
                    'hide_empty' => false,
                ));

                // Check if terms were retrieved successfully
                if (!is_wp_error($terms) && !empty($terms)) {
                    // Find the term that matches the player's role
                    $role_term_id = null;
                    foreach ($terms as $term) {
                        if ($term->name === $staff_data_item['role_staff']) {
                            $role_term_id = $term->term_id;
                            break; // Exit loop once the matching term is found
                        }
                    }

                    // Assign the matching term to the player post if found
                    if ($role_term_id) {
                        wp_set_post_terms($staff_id, array($role_term_id), $taxonomy);
                    }
                }
            }


            // Assign a random team to the staff
            if (!empty($hwc_teams)) {
                $random_team_id = $hwc_teams[array_rand($hwc_teams)];
                update_field('team_selection', array($random_team_id), $staff_id);
            }

            // Set ACF fields
            update_field('staff_number', $staff_data_item['number'], $staff_id);
            update_field(
                'staff_first_name',
                $staff_data_item['first_name'],
                $staff_id
            );
            update_field('staff_last_name', $staff_data_item['last_name'], $staff_id);
            update_field(
                'staff_biography_title',
                $staff_data_item['biography_title'],
                $staff_id
            );
            update_field('staff_stats_title', $staff_data_item['staff_stats_title'], $staff_id);
            update_field('staff_stats', $staff_data_item['stats'], $staff_id);

            // Set staff background image
            if ($staff_data_item['background_image']) {
                $bg_image_id = hwc_create_image_from_plugin($staff_data_item['background_image'], $staff_id);
                if (!is_wp_error($bg_image_id)) {
                    update_field('staff_background_image', $bg_image_id, $staff_id);
                } else {
                    error_log('Failed to upload background image: ' . $bg_image_id->get_error_message());
                }
            }

            // Set big images
            if ($staff_data_item['big_image_1']) {
                $big_image_1_id = hwc_create_image_from_plugin($staff_data_item['big_image_1'], $staff_id);
                if (!is_wp_error($big_image_1_id)) {
                    update_field('staff_big_image_1', $big_image_1_id, $staff_id);
                } else {
                    error_log('Failed to upload big image 1: ' . $big_image_1_id->get_error_message());
                }
            }

            if ($staff_data_item['big_image_2']) {
                $big_image_2_id = hwc_create_image_from_plugin($staff_data_item['big_image_2'], $staff_id);
                if (!is_wp_error($big_image_2_id)) {
                    update_field('staff_big_image_2', $big_image_2_id, $staff_id);
                } else {
                    error_log('Failed to upload big image 2: ' . $big_image_2_id->get_error_message());
                }
            }

            // Set right card content
            if ($staff_data_item['right_card_image']) {
                $right_card_image_id = hwc_create_image_from_plugin($staff_data_item['right_card_image'], $staff_id);
                if (!is_wp_error($right_card_image_id)) {
                    update_field('staff_right_card_image', $right_card_image_id, $staff_id);
                } else {
                    error_log('Failed to upload right card image: ' . $right_card_image_id->get_error_message());
                }
            }

            update_field('staff_right_card_title', $staff_data_item['right_card_title'], $staff_id);
            update_field('staff_right_card_title_2', $staff_data_item['right_card_title_2'], $staff_id);
            update_field('staff_right_card_button', array(
                'url' => $staff_data_item['button']['url'],
                'title' => $staff_data_item['button']['title'],
            ), $staff_id);

            // Set featured image
            if ($staff_data_item['featured_image']) {

                $staff_image_filename = $staff_data_item['featured_image'];

                $staff_image_id = hwc_create_image_from_plugin($staff_image_filename, $staff_id);
                if ($staff_image_id) {
                    set_post_thumbnail($staff_id, $staff_image_id);
                } else {
                    error_log('Failed to set featured image for player ' . $staff_data_item['title']);
                }
            }
        }
    } else {
        error_log('Error retrieving teams: ' . $hwc_teams_query->get_error_message());
    }
    // After the function has run, set the option to true
    //update_option('hwc_staff_data_posts_created', true);
    //   }
}
//end