<?php

/**
 * Code For News Page.
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hwc
 */

/*--------------------------------------------------------------
	>>> Function for Add ACF Fields for results
----------------------------------------------------------------*/
function hwc_create_news_page()
{


    // Set variables for the news page
    // Check if the news page creation has already been run
    $news_page_created = get_option('hwc_news_page_created');

    // Set variables for the news page
    $page_title = 'News';
    $page_slug = 'news';
    $page_template = 'template-parts/template-news.php';

    if (!$news_page_created) {

        // Check if the news page exists
        $news_page = get_page_by_path($page_slug);

        if (!$news_page) {
            // Create the news page if it doesn't exist
            $page_data = array(
                'post_title'    => $page_title,
                'post_content'  => '',
                'post_status'   => 'publish',
                'post_type'     => 'page',
                'post_name'     => $page_slug,
            );
            $news_page_id = wp_insert_post($page_data);

            // Set the page template
            update_post_meta($news_page_id, '_wp_page_template', $page_template);
        } else {
            // If the page exists, get its ID
            $news_page_id = $news_page->ID;
        }

        // Set the flag to indicate the news page was created
        update_option('hwc_news_page_created', true);
    } else {
        // If the news page creation was already done, just get its ID
        $news_page = get_page_by_path($page_slug);
        if ($news_page) {
            $news_page_id = $news_page->ID;
        }
    }
}
