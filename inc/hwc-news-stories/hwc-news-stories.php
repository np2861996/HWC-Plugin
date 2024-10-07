<?php

/**
 * Code For News Stories Page.
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hwc
 */

/*--------------------------------------------------------------
	>>> All Action and Filter Functions
----------------------------------------------------------------*/

function hwc_create_news_stories_page()
{
    /*--------------------------------------------------------------
        >>> Add page with Template 
    ----------------------------------------------------------------*/
    // Set variables for the news_stories page
    // Check if the news stories page creation has already been run
    $hwc_news_stories_page_created = get_option('hwc_news_stories_page_created');

    // Set variables for the news stories page
    $hwc_news_stories_page_title = 'News Stories';
    $hwc_news_stories_page_slug = 'news_stories';
    $hwc_news_stories_page_template = 'template-parts/template-news-stories.php';

    if (!$hwc_news_stories_page_created) {

        // Check if the news_stories page exists
        $hwc_news_stories_page = get_page_by_path($hwc_news_stories_page_slug);

        if (!$hwc_news_stories_page) {
            // Create the news_stories page if it doesn't exist
            $hwc_news_stories_page_data = array(
                'post_title'    => $hwc_news_stories_page_title,
                'post_content'  => '',
                'post_status'   => 'publish',
                'post_type'     => 'page',
                'post_name'     => $hwc_news_stories_page_slug,
            );
            $hwc_news_stories_page_id = wp_insert_post($hwc_news_stories_page_data);

            // Set the page template
            update_post_meta($hwc_news_stories_page_id, '_wp_page_template', $hwc_news_stories_page_template);
        } else {
            // If the page exists, get its ID
            $hwc_news_stories_page_id = $hwc_news_stories_page->ID;
        }

        // Set the flag to indicate the news stories page was created
        update_option('hwc_news_stories_page_created', true);
    } else {
        // If the news stories page creation was already done, just get its ID
        $hwc_news_stories_page = get_page_by_path($hwc_news_stories_page_slug);
        if ($hwc_news_stories_page) {
            $hwc_news_stories_page_id = $hwc_news_stories_page->ID;
        }
    }
}
//end