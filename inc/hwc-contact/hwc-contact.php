<?php

/**
 * Code For Contact Page.
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hwc
 */

/*--------------------------------------------------------------
	>>> All Action and Filter Functions
----------------------------------------------------------------*/

function hwc_create_contact_page()
{
    /*--------------------------------------------------------------
        >>> Add page with Template 
    ----------------------------------------------------------------*/
    // Set variables for the contact page
    $hwc_contact_page_title = 'Contact';
    $hwc_contact_page_slug = 'contact';
    $hwc_contact_page_template = 'template-parts/template-contact.php';

    // Check if the contact page exists
    $hwc_contact_page = get_page_by_path($hwc_contact_page_slug);

    if (!$hwc_contact_page) {
        // Create the contact page if it doesn't exist
        $hwc_contact_page_data = array(
            'post_title'    => $hwc_contact_page_title,
            'post_content'  => '<blockquote>
<h2>How to find us</h2>
</blockquote>
<p>The Ogi Bridge Meadow Stadium,</p>
<p>Bridge Meadow Lane,</p>
<p>Sydney Rees Way,</p>
<p>Haverfordwest,</p>
<p>Pembrokeshire</p>
<p>SA61 2EX</p>
<p><strong>Phone:<br>
</strong>07446 199 594</p>
<h2>Club Contacts</h2>
<p class="p1">Enquiries – <a href="mailto:r.edwards@hcafc1899.football">r.edwards@hcafc1899.football</a></p>
<p class="p1">First Team Trials – <a href="mailto:t.pennock@hcafc1899.football">t.pennock@hcafc1899.football</a></p>
<p class="p1">Academy Trials –</p>
<p class="p2"><span class="s1">Commercial – <a href="mailto:d.oconnor@hcafc1899.football">d.oconnor@hcafc1899.football</a> /&nbsp;<a href="mailto:b.tyler@hcafc1899.football">b.tyler@hcafc1899.football</a></span></p>
<p class="p1">Media – <a href="mailto:t.pritchard@hcafc1899.football">t.pritchard@hcafc1899.football</a></p>
<h2>Club Officials</h2>
<p><strong><span style="text-decoration: underline;">Chairman</span></strong></p>
<p>Rob Edwards</p>
<p><span style="text-decoration: underline;"><strong>Vice-chairman</strong></span></p>
<p>Julian Furne</p>
<p><span style="text-decoration: underline;"><strong>Board Members</strong></span></p>
<p>Julian Furne</p>
<p>Mared Pemberton</p>
<p>Ben Tyler</p>
<p>Neil Thomas</p>
<h2>Club Staff</h2>
<p><span style="text-decoration: underline;"><strong>Chief Operating Officer</strong></span></p>
<p>Beccy Nuttall</p>
<p><span style="text-decoration: underline;"><strong>Commercial Manager</strong></span></p>
<p>Dennis O’Connor</p>
<p><strong><span style="text-decoration: underline;">Community Manager</span></strong></p>
<p>Harry Thomas</p>
<p><span style="text-decoration: underline;"><strong>Head of Women’s and Girls’ Football</strong></span></p>
<p>Mikey Loveridge</p>
<p><span style="text-decoration: underline;"><strong>Media Officer</strong></span></p>
<p>Tom Pritchard</p>
<p><span style="text-decoration: underline;"><strong>Operations and Partnerships Officer</strong></span></p>
<p>Alaric Jones</p>
<p><span style="text-decoration: underline;"><strong>Videographer</strong></span></p>
<p>Ryan Evans</p>',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_name'     => $hwc_contact_page_slug,
            'page_template' => $hwc_contact_page_template
        );
        $hwc_contact_page_id = wp_insert_post($hwc_contact_page_data);

        // Set the page template
        update_post_meta($hwc_contact_page_id, '_wp_page_template', $hwc_contact_page_template);
    } else {
        // If the page exists, get its ID
        $hwc_contact_page_id = $hwc_contact_page->ID;
    }

    $contact_page_image_id = hwc_create_image_from_plugin('K336021-scaled-1.jpg', $hwc_contact_page_id);
    if ($contact_page_image_id) {
        set_post_thumbnail($hwc_contact_page_id, $contact_page_image_id);
    } else {
        error_log('Failed to set featured image for Contact Page');
    }
}
//end