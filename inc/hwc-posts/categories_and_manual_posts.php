<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hwc
 */


/*--------------------------------------------------------------
	>>> Functions Action/Filter Calls
	----------------------------------------------------------------*/
add_action('acf/init', 'hwc_register_acf_fields');
add_action('acf/init', 'hwc_create_categories_and_manual_posts');


/*--------------------------------------------------------------
	>>> Function for add acf custom fields to posts
	----------------------------------------------------------------*/
function hwc_register_acf_fields()
{

    if (!is_acf_pro_plugin_installed()) {
        // Return back if ACF Pro is not available
        return;
    }

    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_sidebar_card',
            'title' => 'Sidebar Card',
            'fields' => array(
                array(
                    'key' => 'field_sidebar_image',
                    'label' => 'Sidebar Card Image',
                    'name' => 'sidebar_card_image',
                    'type' => 'image',
                    'return_format' => 'id', // or 'array' if you need more details
                    'preview_size' => 'medium',
                ),
                array(
                    'key' => 'field_sidebar_title',
                    'label' => 'Title',
                    'name' => 'sidebar_card_title',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_sidebar_button',
                    'label' => 'Button',
                    'name' => 'sidebar_card_button',
                    'type' => 'link',
                    'instructions' => 'Enter URL for the button',
                ),
                array(
                    'key' => 'field_post_banner_video',
                    'label' => 'Banner Video',
                    'name' => 'post_banner_video',
                    'type' => 'url',
                    'instructions' => 'Enter URL for the Banner Video',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'post', // Adjust this for your custom post type
                    ),
                ),
            ),
        ));
    }
}

/*--------------------------------------------------------------
>>> Function for create dummy posts
----------------------------------------------------------------*/
function hwc_create_categories_and_manual_posts()
{

    //Check if the function has already been run
    //if (!get_option('hwc_categories_and_posts_created', false)) {
    if (!is_acf_pro_plugin_installed()) {
        // Return back if ACF Pro is not available
        return;
    }

    // Define the categories
    $categories = array(
        'club-news' => 'Latest Club News',
        'match-report' => 'Match Reports',
        'match-preview' => 'Match Previews',
        'transfer-news' => 'Transfer News',
        'ticket-news' => 'Ticket News',
        'interview' => 'Interviews',
        'you-can-have-it-all' => 'You Can Have It All',
        'the-bluebirds-nest' => 'The Bluebirds Nest',
        'community-news' => 'Community News',
        'video' => 'Video',
        'the-bluebirds-nest' => '#TheBluebirdsNest',
        'academy-news' => 'Academy News',
        'commercial' => 'Commercial',
        'you-can-have-it-all' => '#YouCanHaveItAll
'
    );

    // Loop through each category and create if it doesn't exist
    foreach ($categories as $slug => $name) {
        if (!term_exists($slug, 'category')) {
            wp_insert_term($name, 'category', array('slug' => $slug));
        }
    }

    // Base URL for the images in the 'hwc-images' folder
    $image_base_url = plugin_dir_path(__FILE__) . 'hwc-images';

    // Define post details
    $posts = array(
        // Example Post 1
        array(
            'title' => 'Zac Jones agrees new one-year deal with the Bluebirds',
            'content' => '<p><strong>Haverfordwest County AFC are delighted to confirm that Zac Jones has signed a new one-year contract with the club.</strong></p>
<p>The goalkeeper arrived at the Ogi Bridge Meadow in January 2022, and has gone on to establish himself as one of the most important players in recent times.</p>
<p>After making his haverfordwest county debut in the 3-0 victory over Airbus UK Broughton in August 2022, Zac has gone on to make a total of 53 appearances in all competitions for the Town, and has been involved in plenty of big moments during that time.</p>
<p>The New Zealander played a vital role in helping to end our 19-year wait to return to Europe, as his penalty save in normal time of the play-off semi-final victory at Cardiff Metropolitan, followed by two more saves in the shoot-out, were backed up by yet another spot-kick save in the final at Newtown – a day never to be forgotten by those who were in attendance.</p>
<blockquote><p>“I’ve really enjoyed my time here, I feel I’ve gained a lot of experience.”</p></blockquote>
<figure class="post-content-image post-content-image-has-caption alignnone">
    <img decoding="async" class="wp-image-9561" src="' . plugins_url('/hwc/hwc-images/2023-07-20-Haverfordwest-County-v-KF-Shkendija-67-1.jpg') . '?class=large" alt="" width="600" height="400">
    <figcaption class="caption">Zac celebrates saving a penalty against KF Shkëndija in the UEFA Europa Conference League qualifier at the Cardiff City Stadium. (Pic by John Smith/FAW)</figcaption>
</figure>
<p>A new deal was penned shortly after our European qualification, taking him up until the end of the current campaign.</p>
<p>His heroics didn’t end there, though, as he came up trumps once more in the UEFA Europa Conference League first qualifying round victory over European regulars KF Shkëndija, as he pulled off two more penalty saves – including the match-winner – on what was undoubtedly the greatest night in the club’s 125-year history.</p>
<div class="nwVKo">
<div class="loJjTe">His strong displays between the posts continued into the 2023-24 campaign, where he has been one of our most consistent performers across the season to date, and Bluebirds fans can now look forward to having him at the Ogi Bridge Meadow for another year to come.</div>
<div>
<figure class="post-content-image post-content-image-has-caption alignnone">
    <img decoding="async" class="wp-image-9562" src="' . plugins_url('/hwc/hwc-images/2023-07-20-Haverfordwest-County-v-KF-Shkendija-11.jpg') . '?class=large" alt="" width="600" height="400">
    <figcaption class="caption">Zac walks out of the Cardiff City Stadium tunnel alongside fellow goalkeeper, Ifan Knott. (Pic by John Smith/FAW)</figcaption>
</figure>
</div>
</div>
<p><strong>Upon signing his new contract, Zac said: </strong>“I’m pleased to have signed on for another year here at the club.</p>
<p>“I’ve really enjoyed my time here, I feel I’ve gained a lot of experience. The European qualifiers were definitely a highlight, but speaking on behalf of all the boys, we want to experience that again.</p>
<p>“The next few months are really important. I think it’s clear we are not in the position we want to be as a club, but we need to make sure we secure this play-off spot.</p>
<p>“I’m excited for next season, I’m sure we’ll be competing right at the top of the table.”</p>
<p><strong>Commenting on the news, manager Tony Pennock said:&nbsp;</strong>“We’re delighted that Zac has agreed a new deal with the club.</p>
<p>“He’s been fantastic for us since joining, particularly his performances last season and this season in Europe, he’s been exceptional for us.</p>
<p>“He’s a great goalkeeper who has a fantastic future ahead of him, so it’s great that we can continue to build on what we’ve achieved so far with him.”</p>
<p><strong>The club would like to wish Zac all the best for the new season, and we look forward to seeing him in action again soon!</strong></p>',
            'excerpt' => 'Super Zac extends his stay at the Ogi Bridge Meadow!',
            'category' => 'club-news',
            'tags' => array('Haverfordwest County', 'Zac Jones'),
            'image' => 'zaccontractFI.jpg',
            'acf' => array(
                'sidebar_card_image_name' => 'maxresdefault.jpg',
                'sidebar_card_title' => 'Watch our club documentary series!',
                'sidebar_card_button' => array(
                    'url' => 'https://www.youtube.com/playlist?list=PL0hgLwiLgTW3BfrWwI8hYydy8RZzprmjX',
                    'title' => 'Click here for full playlist! '
                ),
                'post_banner_video' => '',
            )
        ),
        // Add more posts here with similar structure
        array(
            'title' => 'Zac Jones agrees new one-year deal with Haverfordwest County',
            'content' => '<p><strong>Haverfordwest County AFC are delighted to confirm that goalkeeper Zac Jones has agreed a new one-year deal with the club, which takes him through to the end of the 2023-24 season!</strong></p>
<p>Hailing from Wellington, Jones arrived at the Ogi Bridge Meadow in January 2022 and has since made 25 appearances for the Bluebirds, keeping eight clean sheets along the way.</p>
<p>The New Zealander’s performances in 2022-23, and in particular during the European play-offs – where he played a major role in the club qualifying for continental football for the first time since 2004 – have seen him become a hugely popular figure amongst the club’s supporters.</p>
<p>The 22-year-old’s penalty save from Eliot Evans in normal time in the semi-final, which was followed by two more in a dramatic 4-3 shoot-out victory over Cardiff Metropolitan, were the defining moments of a remarkable goalkeeping display in the capital.</p>
<p>On the crest of a wave, he was able to carry this momentum into the final against Newtown at Latham Park, where he made a couple of important stops inside the 90 minutes, before saving the opening spot-kick from Aaron Williams and winning the psychological battle with Henry Cowans, who dragged his effort wide of Jones’ right post.</p>

<figure class="post-content-image post-content-image-has-caption alignnone">
	<img decoding="async" class="wp-image-8362" src="' . plugins_url('/hwc/hwc-images/2023-05-13-Newtown-AFC-vs-Haverfordwest-County-AFC-253.jpg') . '" alt="" >
	<figcaption class="caption">NEWTOWN, POWYS, WALES – 13th MAY 2023 – Haverfordwest celebrate winning the penalty shoot-out during Newtown AFC vs Haverfordwest County AFC in the JD Cymru Premier European Play-Off final at Latham Park, Newtown (Pic by Sam Eaden/FAW)</figcaption>
</figure>

<p>Having admitted that he needed time to adapt to the physicality of the JD Cymru Premier, Jones visibly grew in confidence as the season progressed to become a commanding presence in between the sticks – and he can now look forward to competing on the European stage for the first time, and continuing to help Haverfordwest County in their push for a top six finish next term.</p>
<p><strong>Speaking after putting pen to paper, Jones said</strong>: “I’m delighted to stay on for another year with the club. After last week it was made a very easy decision for me.</p>
<p>“[On the European challenge ahead] It’s really exciting, I’m still on a bit of a high now and I don’t think that will wear off any time soon. I’m looking forward to next season where we will certainly be pushing towards the top end of the table. I think we’ve done enough to prove that to everyone over the last five months or so.</p>
<p>“The fans have been brilliant all of last season, and I can’t wait to get back out there in front of them soon.”</p>',
            'excerpt' => 'Super Zac signs on for another year with the Bluebirds!',
            'category' => 'club-news',
            'tags' => array('Haverfordwest County', 'Zac Jones'),
            'image' => '2023-05-13-Newtown-AFC-vs-Haverfordwest-County-AFC-247.jpg',
            'acf' => array(
                'sidebar_card_image_name' => '',
                'sidebar_card_title' => '',
                'sidebar_card_button' => array(
                    'url' => '',
                    'title' => ''
                ),
                'post_banner_video' => '',
            )
        ),
        // Example for additional posts...
        array(
            'title' => 'Keeper Jones the hero as Bluebirds reach maiden European play-off final',
            'content' => '<p><strong>Zac Jones produced a remarkable goalkeeping display as Haverfordwest County defeated Cardiff Metropolitan 4-3 on penalties at Cyncoed Campus to reach the JD Cymru Premier European play-off final.</strong></p>
<p>The inspired New Zealand stopper saved Eliot Evans’ penalty in normal time and thwarted Sam Jones late in extra time before denying the Students twice more in the shoot-out to help the Bluebirds to a dramatic victory in the capital.</p>
<p>There was nothing to separate the teams in normal time, as they largely cancelled one another out. There were a couple of opportunities for both sides to take the initiative in normal time, but the game always seemed destined to be decided by penalties.</p>
<p>With the tense shoot-out tied at 3-3, substitute Elliott Dugan converted what was ultimately the decisive spot-kick to send the travelling supporters – who arrived in Cardiff in great numbers – into delirium, and giving them one more away day in what was been a rollercoaster season.</p>
<p>Following their maiden play-off victory, County will now face Newtown – who saw off Bala Town 4-2 on Friday night – for a place in the first qualifying round of the UEFA Europa Conference League. The game will take place at Latham Park on Saturday May 13 (Kick-off: 5.15pm), <a href="https://haverfordwestcountyafc.com/2023/05/free-entry-to-european-play-off-final-at-latham-park/">with entry free for all spectators</a>.</p>
<p>Manager Tony Pennock made five changes to the team that ended the regular season with a 4-1 victory at Airbus UK Broughton, with Rhys Abbruzzese, Corey Shephard, Jamie Veale and Dan Hawkins coming into the side, while Dylan Rees returned to skipper the Town.</p>

<figure class="post-content-image post-content-image-has-caption alignnone">
	<img loading="lazy" decoding="async" class="wp-image-8311" src="' . plugins_url('/hwc/hwc-images//060522_Cardiff-Met-v-Haverfordwest-County_44.jpg') . '" alt="" >
	<figcaption class="caption">Cardiff, Wales – 6th May 2023:<br>Jordan Davies of Haverfordwest County in action against Emlyn Lewis of Cardiff Met.<br>Cardiff Metropolitan University v Haverfordwest County in the JD Cymru Premier Playoff Semi Final at Cyncoed Campus on the 6th May 2023. (Pic by Lewis Mitchell/FAW)</figcaption>
</figure>

<p>Although County had started the game well, the first opportunity fell to the hosts as Tom Price’s effort from 25 yards was palmed away by Jones, with Dylan Rees seeing his shot from the same distance also pushed to safety by Alex Lang four minutes later.</p>
<p>The Bluebirds came agonisingly close to taking the lead just a minute later when a pinpoint ball into the area from Jack Wilson picked out Jordan Davies, who saw his looping header go just over the crossbar with Lang stranded well off his line.</p>
<p>Pennock’s men were in control for large periods of the first half, and they came close to going ahead with half-time approaching when Davies’ attempted cross was blocked, before the ball returned to his path and he sent a curling effort agonisingly over the bar from the right side of the area.</p>

<figure class="post-content-image post-content-image-has-caption alignnone">
	<img loading="lazy" decoding="async" class="wp-image-8312" src="' . plugins_url('/hwc/hwc-images/060522_Cardiff-Met-v-Haverfordwest-County_164.jpg') . '" alt="" >
	<figcaption class="caption">Cardiff, Wales – 6th May 2023:<br>Haverfordwest County supporters during the first half.<br>Cardiff Metropolitan University v Haverfordwest County in the JD Cymru Premier Playoff Semi Final at Cyncoed Campus on the 6th May 2023. (Pic by Lewis Mitchell/FAW)</figcaption>
</figure>

<p>Keen to continue where they left off as the second-half began, Veale had a free-kick from just outside the area saved by the diving Lang six minutes after the restart.</p>
<p>Christian Edwards’ side were certainly much-improved after the restart, as they began to get more of a foothold in the game, however the Bluebirds defence was standing tall against their physical threat from set-pieces.</p>
<p>With goalmouth action few and far between, the Archers were given the chance to go ahead with 20 minutes left on the clock when Henry Jones was penalised for a foul on Price inside the area, however Jones produced an outstanding save to deny Evans and keep the score at 0-0.</p>

<figure class="post-content-image post-content-image-has-caption alignnone">
	<img loading="lazy" decoding="async" class="wp-image-8313" src="' . plugins_url('/hwc/hwc-images/060522_Cardiff-Met-v-Haverfordwest-County_166.jpg') . '" alt="" >
	<figcaption class="caption">Cardiff, Wales – 6th May 2023:<br>Dylan Rees of Haverfordwest County in action.<br>Cardiff Metropolitan University v Haverfordwest County in the JD Cymru Premier Playoff Semi Final at Cyncoed Campus on the 6th May 2023. (Pic by Lewis Mitchell/FAW)</figcaption>
</figure>

<p>The remainder of normal time was rather cagey, with neither side wanting to make a costly error, and, Wilson’s first-time effort which crept through a wall of bodies before being gathered by Lang aside, there were no further opportunities as the match moved into extra time.</p>
<p>The hosts had the first chance of the additional 30 minutes when, in the 98th minute, Sam Jones headed just wide from a cross. Then, in the final minute of the first-half, Price’s effort from way out hit the bar and went over, much to the relief of the Town.</p>
<p>There was only one moment of note in the second half of extra time, and it proved to be a decisive one as Sam Jones was played through one-on-one with namesake Jones, but the Kiwi made another brilliant save to deny the striker’s effort from inside the area and ensure the game would be decided by penalty kicks.</p>
<p>The tension inside the ground was palpable, and the pressure was cranked up another notch as the shoot-out began. Kyle McCarthy was first up, but his spot-kick was saved by the legs of Jones to give Haverfordwest County the ideal start, before Dylan Rees made no mistake by firing into the left-hand corner to give the Bluebirds a 1-0 lead.</p>

<figure class="post-content-image post-content-image-has-caption alignnone">
	<img loading="lazy" decoding="async" class="wp-image-8314" src="' . plugins_url('/hwc/hwc-images/060522_Cardiff-Met-v-Haverfordwest-County_62.jpg') . '" alt="" >
	<figcaption class="caption">Cardiff, Wales – 6th May 2023:<br>Haverfordwest goalkeeper Zac Jones saves a penalty.<br>Cardiff Metropolitan University v Haverfordwest County in the JD Cymru Premier Playoff Semi Final at Cyncoed Campus on the 6th May 2023. (Pic by Lewis Mitchell/FAW)</figcaption>
</figure>

<p>Things got even better when Lewis Rees was denied by the seemingly-unbeatable Jones, who dived low to his left to make the save. Jack Leahy, who had earlier come on as a substitute, sent his penalty in off the crossbar to make it 2-0 and strengthen the Town’s advantage.</p>
<p>CJ Craven got the Students off the mark at the third time of asking, but the margin of County’s lead was maintained when Davies slotted home from 12 yards.</p>
<p>Sam Jones found the left corner to keep the Archers’ hopes alive, and the drama continued as Henry Jones missed the chance to end the shoot-out when Lang denied the midfielder.</p>
<p>Jack Veale then found the net to send the shoot-out to a 10th spot-kick, and Dugan cooly sent Lang the wrong way to spark jubilant scenes from the ecstatic Haverfordwest County fans behind the goal and around the ground, as the Town celebrated reaching the play-off final for the first time in the club’s history.</p>

<figure class="post-content-image post-content-image-has-caption alignnone">
	<img loading="lazy" decoding="async" class="wp-image-8315" src="' . plugins_url('/hwc/hwc-images/060522_Cardiff-Met-v-Haverfordwest-County_70-1.jpg') . '" alt="" >
	<figcaption class="caption">Cardiff, Wales – 6th May 2023:<br>Haverfordwest County celebrate at full time.<br>Cardiff Metropolitan University v Haverfordwest County in the JD Cymru Premier Playoff Semi Final at Cyncoed Campus on the 6th May 2023. (Pic by Lewis Mitchell/FAW)</figcaption>
</figure>

<p><strong>Cardiff Metropolitan: </strong>Lang, Chubb (Veale 119′), McCarthy, Lewis, Price, Evans (Rees 73′), Baker (C), Corsby (Kabongo 89′), Owen, Craven, Jones</p>
<p><strong>Substitutes not used: </strong>Manson, Davies, Roberts, Humphries</p>
<p><strong>Yellow cards: </strong>Price 110′, Craven 118′</p>
<p><strong>Haverfordwest County: </strong>Z. Jones, Wilson (Leahy 91′), Rees (C), Jenkins, Borg (Dugan 105′), Abbruzzese, Shephard (Watts 100′), Veale (Evans 91′), H. Jones, J. Davies, Hawkins (Humphreys 115′)</p>
<p><strong>Substitutes not used: </strong>Idzi, H. John</p>
<p><strong>Yellow card: </strong>Veale 52′</p>
<p><strong>Attendance: </strong>561</p>
<p><span style="text-decoration: underline;"><strong>Penalty shoot-out</strong></span></p>
<p>Kyle McCarthy misses (<strong>0-0</strong>); Dylan Rees scores (<strong>0-1</strong>); Lewis Rees misses (<strong>0-1</strong>); Jack Leahy scores (<strong>0-2</strong>); CJ Craven scores (<strong>1-2</strong>); Jordan Davies scores (<strong>1-3</strong>); Sam Jones scores (<strong>2-3</strong>); Henry Jones misses (<strong>2-3</strong>); Jack Veale scores (<strong>3-3</strong>); Elliott Dugan scores (<strong>3-4</strong>)</p>',
            'excerpt' => 'Our report of Haverfordwest County\'s 4-3 penalty shoot-out victory over Cardiff Metropolitan in the JD Cymru Premier European play-off semi-finals.',
            'category' => 'match-report',
            'tags' => array('Haverfordwest County', 'Zac Jones', 'Cardiff Met Uni vs Haverfordwest County'),
            'image' => 'MetAwayReportFI.jpg',
            'acf' => array(
                'sidebar_card_image_name' => '',
                'sidebar_card_title' => '',
                'sidebar_card_button' => array(
                    'url' => '',
                    'title' => ''
                ),
                'post_banner_video' => '',
            )
        ),
        // Add more posts up to 10+...
        array(
            'title' => '#TheBluebirdsNest Episode 6 – Zac Jones',
            'content' => '',
            'excerpt' => 'Watch Episode 6 of #TheBluebirdsNest, our vodcast and podcast series, with goalkeeper Zac Jones.',
            'category' => 'the-bluebirds-nest',
            'tags' => array('Haverfordwest County', 'Zac Jones'),
            'image' => 'maxresdefault.jpg',

            'acf' => array(
                'sidebar_card_image_name' => '',
                'sidebar_card_title' => '',
                'sidebar_card_button' => array(
                    'url' => '',
                    'title' => ''
                ),
                'post_banner_video' => 'https://www.youtube.com/embed/IiMkZbA5tgk?feature=oembed',
            )
        ),
        array(
            'title' => 'Ifan Knott signs new two-year deal with the Bluebirds',
            'content' => '<p><strong>Haverfordwest County AFC are delighted to announce that goalkeeper Ifan Knott has agreed a new two-year contract with the club.</strong></p>
<p>Ifan joined the Bluebirds from Carmarthen Town back in May 2023, and this new deal will take him through until the end of the 2025-26 season.</p>
<p>The 19-year-old was part of the squad throughout our memorable European journey last summer, as he gained valuable experience during an unforgettable few weeks which saw us create club history.</p>
<p>Ifan has made six senior appearances in all competitions so far this season, having made his first competitive start for the Town against Cardiff City under-21s in the Nathaniel MG Cup at the start of August. He also appeared in this season’s JD Welsh Cup, as he kept a clean sheet in the 2-0 victory over Ammanford in November.</p>
<div class="twitter-tweet twitter-tweet-rendered" style="display: flex; max-width: 500px; width: 100%; margin-top: 10px; margin-bottom: 10px;"><iframe id="twitter-widget-0" scrolling="no" frameborder="0" allowtransparency="true" allowfullscreen="true" class="" title="X Post" src="https://platform.twitter.com/embed/Tweet.html?dnt=true&amp;embedId=twitter-widget-0&amp;features=eyJ0ZndfdGltZWxpbmVfbGlzdCI6eyJidWNrZXQiOltdLCJ2ZXJzaW9uIjpudWxsfSwidGZ3X2ZvbGxvd2VyX2NvdW50X3N1bnNldCI6eyJidWNrZXQiOnRydWUsInZlcnNpb24iOm51bGx9LCJ0ZndfdHdlZXRfZWRpdF9iYWNrZW5kIjp7ImJ1Y2tldCI6Im9uIiwidmVyc2lvbiI6bnVsbH0sInRmd19yZWZzcmNfc2Vzc2lvbiI6eyJidWNrZXQiOiJvbiIsInZlcnNpb24iOm51bGx9LCJ0ZndfZm9zbnJfc29mdF9pbnRlcnZlbnRpb25zX2VuYWJsZWQiOnsiYnVja2V0Ijoib24iLCJ2ZXJzaW9uIjpudWxsfSwidGZ3X21peGVkX21lZGlhXzE1ODk3Ijp7ImJ1Y2tldCI6InRyZWF0bWVudCIsInZlcnNpb24iOm51bGx9LCJ0ZndfZXhwZXJpbWVudHNfY29va2llX2V4cGlyYXRpb24iOnsiYnVja2V0IjoxMjA5NjAwLCJ2ZXJzaW9uIjpudWxsfSwidGZ3X3Nob3dfYmlyZHdhdGNoX3Bpdm90c19lbmFibGVkIjp7ImJ1Y2tldCI6Im9uIiwidmVyc2lvbiI6bnVsbH0sInRmd19kdXBsaWNhdGVfc2NyaWJlc190b19zZXR0aW5ncyI6eyJidWNrZXQiOiJvbiIsInZlcnNpb24iOm51bGx9LCJ0ZndfdXNlX3Byb2ZpbGVfaW1hZ2Vfc2hhcGVfZW5hYmxlZCI6eyJidWNrZXQiOiJvbiIsInZlcnNpb24iOm51bGx9LCJ0ZndfdmlkZW9faGxzX2R5bmFtaWNfbWFuaWZlc3RzXzE1MDgyIjp7ImJ1Y2tldCI6InRydWVfYml0cmF0ZSIsInZlcnNpb24iOm51bGx9LCJ0ZndfbGVnYWN5X3RpbWVsaW5lX3N1bnNldCI6eyJidWNrZXQiOnRydWUsInZlcnNpb24iOm51bGx9LCJ0ZndfdHdlZXRfZWRpdF9mcm9udGVuZCI6eyJidWNrZXQiOiJvbiIsInZlcnNpb24iOm51bGx9fQ%3D%3D&amp;frame=false&amp;hideCard=false&amp;hideThread=false&amp;id=1706775708301685013&amp;lang=en-gb&amp;origin=https%3A%2F%2Fhaverfordwestcountyafc.com%2F2024%2F01%2Fifan-knott-signs-new-two-year-deal-with-the-bluebirds%2F&amp;sessionId=60d4926f9ab710aaa50775480d707e3ac4485312&amp;siteScreenName=HaverfordwestFC&amp;theme=light&amp;widgetsVersion=2615f7e52b7e0%3A1702314776716&amp;width=500px" style="position: static; visibility: visible; width: 500px; height: 621px; display: block; flex-grow: 1;" data-tweet-id="1706775708301685013"></iframe></div>
<p><script async="" src="https://platform.twitter.com/widgets.js" charset="utf-8"></script></p>
<p>The youngster was handed his JD Cymru Premier debut against Connah’s Quay Nomads on September 23, and four days later he pulled off a last-gasp penalty save in the 1-1 draw away at Cardiff Metropolitan in what is undoubtedly the high point of his Bluebirds career to date, as he denied Lewis Rees from the spot to ensure County took a point home with them.</p>
<p>Ifan has also appeared for the club’s Development side this season, making four appearances to date in the Cymru Premier Development League South.</p>
<p><strong>Upon signing his new contract, Ifan said:&nbsp;</strong>“I’ve really enjoyed my time here over the past six months, and I’m over the moon to extend my stay here for another two years.</p>
<p>“I’m grateful to all of the players, staff and fans for making me feel so welcome here at the club, and i’m very excited to see what the future holds here at Haverfordwest County.”</p>
<p><strong>Commenting on the news, manager Tony Pennock said:&nbsp;</strong>“Ifan has shown in a short period of time what a talented young goalkeeper he is. He works very hard and is always looking to improve.</p>
<p>“Ifan has great potential, and signing a long-term contract gives him the platform to develop further. I look forward to seeing his progress.”</p>
<p><em>Ifan is kindly sponsored by <a href="https://www.clayshawbutler.com/">Clay Shaw Butler</a>, a unique, innovative firm of Chartered Accountants who aim to deliver the highest possible standard of expertise through their hard-working and dedicated team.</em></p>',
            'excerpt' => 'The young goalkeeper extends his stay at the Ogi Bridge Meadow!',
            'category' => 'club-news',
            'tags' => array('Haverfordwest County', 'Ifan Knott'),
            'image' => 'ifancontractFI.jpg',

            'acf' => array(
                'sidebar_card_image_name' => 'maxresdefault.jpg',
                'sidebar_card_title' => 'Watch our club documentary series!',
                'sidebar_card_button' => array(
                    'url' => 'https://www.youtube.com/playlist?list=PL0hgLwiLgTW3BfrWwI8hYydy8RZzprmjX',
                    'title' => 'Click here for full playlist!'
                ),
                'post_banner_video' => '',
            )
        ),
        array(
            'title' => '#TheBluebirdsNest Episode 35 – Ifan Knott',
            'content' => '<p><strong>Haverfordwest County AFC are delighted to announce that goalkeeper Ifan Knott has agreed a new two-year contract with the club.</strong></p>
<p>Ifan joined the Bluebirds from Carmarthen Town back in May 2023, and this new deal will take him through until the end of the 2025-26 season.</p>
<p>The 19-year-old was part of the squad throughout our memorable European journey last summer, as he gained valuable experience during an unforgettable few weeks which saw us create club history.</p>
<p>Ifan has made six senior appearances in all competitions so far this season, having made his first competitive start for the Town against Cardiff City under-21s in the Nathaniel MG Cup at the start of August. He also appeared in this season’s JD Welsh Cup, as he kept a clean sheet in the 2-0 victory over Ammanford in November.</p>
<div class="twitter-tweet twitter-tweet-rendered" style="display: flex; max-width: 500px; width: 100%; margin-top: 10px; margin-bottom: 10px;"><iframe id="twitter-widget-0" scrolling="no" frameborder="0" allowtransparency="true" allowfullscreen="true" class="" title="X Post" src="https://platform.twitter.com/embed/Tweet.html?dnt=true&amp;embedId=twitter-widget-0&amp;features=eyJ0ZndfdGltZWxpbmVfbGlzdCI6eyJidWNrZXQiOltdLCJ2ZXJzaW9uIjpudWxsfSwidGZ3X2ZvbGxvd2VyX2NvdW50X3N1bnNldCI6eyJidWNrZXQiOnRydWUsInZlcnNpb24iOm51bGx9LCJ0ZndfdHdlZXRfZWRpdF9iYWNrZW5kIjp7ImJ1Y2tldCI6Im9uIiwidmVyc2lvbiI6bnVsbH0sInRmd19yZWZzcmNfc2Vzc2lvbiI6eyJidWNrZXQiOiJvbiIsInZlcnNpb24iOm51bGx9LCJ0ZndfZm9zbnJfc29mdF9pbnRlcnZlbnRpb25zX2VuYWJsZWQiOnsiYnVja2V0Ijoib24iLCJ2ZXJzaW9uIjpudWxsfSwidGZ3X21peGVkX21lZGlhXzE1ODk3Ijp7ImJ1Y2tldCI6InRyZWF0bWVudCIsInZlcnNpb24iOm51bGx9LCJ0ZndfZXhwZXJpbWVudHNfY29va2llX2V4cGlyYXRpb24iOnsiYnVja2V0IjoxMjA5NjAwLCJ2ZXJzaW9uIjpudWxsfSwidGZ3X3Nob3dfYmlyZHdhdGNoX3Bpdm90c19lbmFibGVkIjp7ImJ1Y2tldCI6Im9uIiwidmVyc2lvbiI6bnVsbH0sInRmd19kdXBsaWNhdGVfc2NyaWJlc190b19zZXR0aW5ncyI6eyJidWNrZXQiOiJvbiIsInZlcnNpb24iOm51bGx9LCJ0ZndfdXNlX3Byb2ZpbGVfaW1hZ2Vfc2hhcGVfZW5hYmxlZCI6eyJidWNrZXQiOiJvbiIsInZlcnNpb24iOm51bGx9LCJ0ZndfdmlkZW9faGxzX2R5bmFtaWNfbWFuaWZlc3RzXzE1MDgyIjp7ImJ1Y2tldCI6InRydWVfYml0cmF0ZSIsInZlcnNpb24iOm51bGx9LCJ0ZndfbGVnYWN5X3RpbWVsaW5lX3N1bnNldCI6eyJidWNrZXQiOnRydWUsInZlcnNpb24iOm51bGx9LCJ0ZndfdHdlZXRfZWRpdF9mcm9udGVuZCI6eyJidWNrZXQiOiJvbiIsInZlcnNpb24iOm51bGx9fQ%3D%3D&amp;frame=false&amp;hideCard=false&amp;hideThread=false&amp;id=1706775708301685013&amp;lang=en-gb&amp;origin=https%3A%2F%2Fhaverfordwestcountyafc.com%2F2024%2F01%2Fifan-knott-signs-new-two-year-deal-with-the-bluebirds%2F&amp;sessionId=60d4926f9ab710aaa50775480d707e3ac4485312&amp;siteScreenName=HaverfordwestFC&amp;theme=light&amp;widgetsVersion=2615f7e52b7e0%3A1702314776716&amp;width=500px" style="position: static; visibility: visible; width: 500px; height: 621px; display: block; flex-grow: 1;" data-tweet-id="1706775708301685013"></iframe></div>
<p><script async="" src="https://platform.twitter.com/widgets.js" charset="utf-8"></script></p>
<p>The youngster was handed his JD Cymru Premier debut against Connah’s Quay Nomads on September 23, and four days later he pulled off a last-gasp penalty save in the 1-1 draw away at Cardiff Metropolitan in what is undoubtedly the high point of his Bluebirds career to date, as he denied Lewis Rees from the spot to ensure County took a point home with them.</p>
<p>Ifan has also appeared for the club’s Development side this season, making four appearances to date in the Cymru Premier Development League South.</p>
<p><strong>Upon signing his new contract, Ifan said:&nbsp;</strong>“I’ve really enjoyed my time here over the past six months, and I’m over the moon to extend my stay here for another two years.</p>
<p>“I’m grateful to all of the players, staff and fans for making me feel so welcome here at the club, and i’m very excited to see what the future holds here at Haverfordwest County.”</p>
<p><strong>Commenting on the news, manager Tony Pennock said:&nbsp;</strong>“Ifan has shown in a short period of time what a talented young goalkeeper he is. He works very hard and is always looking to improve.</p>
<p>“Ifan has great potential, and signing a long-term contract gives him the platform to develop further. I look forward to seeing his progress.”</p>
<p><em>Ifan is kindly sponsored by <a href="https://www.clayshawbutler.com/">Clay Shaw Butler</a>, a unique, innovative firm of Chartered Accountants who aim to deliver the highest possible standard of expertise through their hard-working and dedicated team.</em></p>',
            'excerpt' => 'Watch Episode 35 of #TheBluebirdsNest, our vodcast and podcast series, with goalkeeper Ifan Knott!',
            'category' => 'the-bluebirds-nest',
            'tags' => array('Haverfordwest County', 'Ifan Knott'),
            'image' => 'maxresdefault.jpg',

            'acf' => array(
                'sidebar_card_image_name' => 'BluebirdsNestSeries.jpg',
                'sidebar_card_title' => 'Listen to our club podcast series!',
                'sidebar_card_button' => array(
                    'url' => 'https://www.youtube.com/playlist?list=PL0hgLwiLgTW17WmG0wp2c82tOIB5PkG7K',
                    'title' => 'Click here for full playlist!'
                ),
                'post_banner_video' => 'https://www.youtube.com/embed/FiVtni2ktTM?feature=oembed',
            )
        ),
        array(
            'title' => '#TheBluebirdsNest | Episode 60 – Deryn Brace and Tim Hicks',
            'content' => '',
            'excerpt' => 'Watch Episode 60 of #TheBluebirdsNest, our vodcast and podcast series, with former Haverfordwest County AFC manager, Deryn Brace, and ex-striker, Tim Hicks!',
            'category' => 'the-bluebirds-nest',
            'tags' => array('Haverfordwest County'),
            'image' => 'maxresdefault.jpg',

            'acf' => array(
                'sidebar_card_image_name' => 'BluebirdsNestSeries.jpg',
                'sidebar_card_title' => 'Listen to our club podcast series!',
                'sidebar_card_button' => array(
                    'url' => 'https://www.youtube.com/playlist?list=PL0hgLwiLgTW17WmG0wp2c82tOIB5PkG7K',
                    'title' => 'Click here for full playlist!'
                ),
                'post_banner_video' => 'https://www.youtube.com/embed/FiVtni2ktTM?feature=oembed',
            )
        ),
        array(
            'title' => 'Chaotic conclusion sees Bluebirds share the spoils with Archers in the capital',
            'content' => '<p><strong>Haverfordwest County ended their three-game losing run with a 1-1 draw away at Cardiff Metropolitan last night, as a frantic ending saw all three results possible right up to the final whistle.</strong></p>
<p>The Bluebirds had taken the lead through Kai Whitmore’s second-half penalty, and were a matter of minutes away from taking all three points back home, but Lewis Rees drew the Students level late on. Then, in added time, the hosts were awarded a penalty, but much to the relief of the visitors, goalkeeper Ifan Knott denied Rees to ensure the game ended level at Cyncoed Campus.</p>
<p>Tony Pennock’s men had battled hard throughout the night against an Archers team who don’t often lose at home, but will ultimately look back with a sense of frustration at not quite being able to see the job through.</p>
<p>The result sees the Town climb one place to 10th after Barry Town United went down 1-0 at Pen-y-Bont, with the Bluebirds’ focus now shifting to a significant game on Saturday when we host Aberystwyth Town at the Ogi Bridge Meadow.</p>
<h5>Team news</h5>
<p>Manager Pennock made three changes to the team from last Saturday, with Aidan MacNamara, who recently joined on a deal until the end of the season, coming straight in for his full debut, while Jack Wilson was handed a start and Whitmore returned after serving a one-game suspension. Meanwhile, there was a welcome return to the squad for Rio Dyer, who had not featured for the haverfordwest county since the Nathaniel MG Cup meeting with Cardiff City under-21s at the start of August.</p>
<p>Striker Martell Taylor-Crossdale was serving the first of his three-game suspension after the straight red card he was shown against Connah’s Quay Nomads, while fellow forward Ben Fawcett was unavailable after sustaining an injury in the same game.</p>
<p><strong>Haverfordwest County:</strong> Knott, MacNamara, Tabone, Jenkins, Borg (Williams-Lowe 45′), Abbruzzese, Watts (C), T. Owen, Whitmore, Hawkins, Wilson (Dyer 81′)</p>
<p><strong>Substitutes not used:</strong> Jones, Humphreys, J. Owen, H. John, D. John</p>
<h5>First half</h5>
<p>The opening stages of the game were keenly-contested, as both sides seeked to find their feet and get into a rhythm. The first opportunity of note fell the way of Cardiff Metropolitan when a shot from inside the area was deflected into the side netting.</p>
<p>It wasn’t until eight minutes before the break that the Bluebirds fashioned a goal-scoring opportunity, and it proved to be the best chance of the half as the ball was kept alive from Wilson’s long throw and Luke Tabone was able to head it into the path of Dan Hawkins, but his shot on the turn flew just wide.</p>
<p>County ended the first half the stronger, and were beginning to grow in confidence from an attacking perspective. Two minutes before the interval, they had a second opportunity to take the lead when Rhys Abbruzzese won a free-kick just outside the area, which Wilson stepped up to take and directed agonisingly wide of the left post.</p>
<h5>Second half</h5>
<p>In truth, Pennock’s men didn’t want the half-time whistle to come, however they came back out for the second half with the same intent, and were able to fashion the first opportunity after the restart when Lee Jenkins rose highest to meet Hawkins’ corner, with his header going just wide of the right post.</p>
<p>On the hour mark, Wilson fashioned some space to shoot from 25 yards out, with his low effort rolling wide of the right post as the Bluebirds continued to press for the opening goal.</p>
<p>Then, just a minute later, they were handed a golden opportunity to take the lead when referee Richard Wright awarded County a penalty when Abbruzzese was adjudged to have been pushed in the back by defender Joe Evans as he attempted to meet a cross from the right side.</p>
<p>Whitmore was given the responsibility from 12 yards and, just as he had done in our shoot-out victory over KF Shkëndija, he slotted cooly past Alex Lang to make it 1-0. This was the first time in the league this season that the Bluebirds have taken the lead.</p>
<p>As expected, Ryan Jenkins’ side began to step up the tempo as they searched for an equaliser, and they had an opportunity to draw level with 20 minutes remaining when they won a free-kick just outside the area, however Harry Owen’s effort was blocked by the Haverfordwest County wall.</p>
<p>The Town weren’t resting on their one-goal advantage, and five minutes later they had a chance to double their lead when the ball was kept alive from a free-kick into the area, before falling into the path of Whitmore, however there was just enough pressure from the nearby defenders to ensure that his goal-bound effort could be gathered by Lang.</p>
<p>With just under 10 minutes to go in normal time, Dyer was introduced from the bench to replace Wilson and make his JD Cymru Premier debut for the Bluebirds, and shortly after he nearly saw his team make it 2-0 when Jenkins headed Hawkins’ free-kick into the path of Tabone, however the ball wouldn’t sit down in time for the defender and he sent his looping effort from close range over the crossbar.</p>
<p>Despite having withstood plenty of Archers pressure in the closing stages, County were looking relatively comfortable, however with just two minutes of normal time remaining they found themselves level when a ball into the area was headed into the ground by substitute Finley Skiverton before looping over Tabone and kindly into the path of Rees, who had the simple task of directing it home from a matter of yards.</p>
<p>The task for Pennock’s men had quickly shifted to ensuring they took something home for their efforts, however just three minutes later that appeared to be in real jeopardy as the Archers were awarded a spot kick when MacNamara – who had performed well on his first start – was adjudged to have brought Matt Chubb down inside the area. With the travelling Bluebirds supporters unable to watch, Rees stepped up and sent his spot-kick towards the left corner, but he was denied by a fantastic save from Knott, one which provoked memories of Zac Jones’ penalty heroics in last season’s European play-off semi-final.</p>
<p>A point was the least the Bluebirds deserved for their overall performance, which saw them create the better opportunities on the night, and they will now be hoping to replicate those levels on Saturday afternoon when we host the Seasiders (2.30pm kick-off).</p>',
            'excerpt' => 'Our take on the 1-1 draw with Cardiff Metropolitan on JD Cymru Premier MD9...',
            'category' => 'match-report',
            'tags' => array('Haverfordwest County', 'Ifan Knott', 'Kai Whitmore', 'Cardiff Met Uni vs Haverfordwest County'),
            'image' => 'maxresdefault2.jpg',

            'acf' => array(
                'sidebar_card_image_name' => 'BluebirdsNestSeries.jpg',
                'sidebar_card_title' => 'Listen to our club podcast series!',
                'sidebar_card_button' => array(
                    'url' => 'https://www.youtube.com/playlist?list=PL0hgLwiLgTW17WmG0wp2c82tOIB5PkG7K',
                    'title' => 'Click here for full playlist!'
                ),
                'post_banner_video' => 'https://www.youtube.com/embed/iYdGY7kk0MI?feature=oembed',
            )
        ),
        array(
            'title' => 'Bluebirds see off Seagulls to set up thrilling final-day meeting with Bont',
            'content' => '<p><strong>Haverfordwest County made it four consecutive victories in the JD Cymru Premier Playoff Conference with a 3-1 success against Colwyn Bay at the Ogi Bridge Meadow on Saturday.</strong></p>
<p>The game, which was played in front of the live Sgorio cameras, saw the Bluebirds 2-0 to the good after only 10 minutes as Rhys Abbruzzese’s perfectly placed free-kick from 20 yards made it 1-0, before the wing-back’s free-kick from the half way line was glanced in by Lee Jenkins.</p>
<p>Ben Fawcett put the result beyond doubt with just under 20 minutes remaining, before Seagulls captain Tom McCready netted a consolation goal with the last kick of the game.</p>
<p>The result means County maintain their three-point lead at the top of the Playoff Conference, after nearest rivals Penybont won 3-0 at Pontypridd United later in the day to set up a mouthwatering final-day clash at the SDM Glass Stadium where the winner will clinch the fourth and final spot in the end-of-season European playoffs.</p>

<figure class="post-content-image post-content-image-has-caption alignnone">
	<img loading="lazy" decoding="async" class="wp-image-9680" src="' . plugins_url('/hwc/hwc-images/Hwest-County-vs-Colwyn-Bay-2-061-High-Res.jpg') . '?class=large" alt="" width="600" height="400">
	<figcaption class="caption">© RawPhotography</figcaption>
</figure>

<h5>Team news</h5>
<p>Manager Tony Pennock made two changes to the side that beat Barry Town United, as Ricky Watts returned from suspension to be joined in the midfield by Declan Carroll, who made his first start since returning to the club in January. Having signed for the club a day prior, Ioan Evans was included on the bench, where he was joined by four Academy products in Lucas Davies, Harri John, Callum Shirt and Fletcher Picton. Martell Taylor-Crossdale served a one-game suspension after receiving his fifth booking of the season in the win over the Dragons.</p>
<p><strong>Haverfordwest County:</strong> Jones, Humphreys (J. Owen 79′), Jenkins, Tabone, Borg, Abbruzzese, Watts (C), Carroll (Evans 57′), Whitmore, Dyer (John 74′), Fawcett (Picton 79′)</p>
<p><strong>Substitutes not used:</strong> Knott, Davies, Shirt</p>
<h5>First half</h5>
<p>The Bluebirds made a bright start, and created their first opening after five minutes when some good interplay freed Rio Dyer and allowed him to break into the area, before his cross was diverted just wide of the left post.</p>
<p>County were ahead just three minutes later after Sam Hart’s foul on Carroll gave Abbruzzese a set-piece opportunity from just outside the area, and he duly obliged by curling his left-footed effort around the wall and into the top left-hand corner to make it 1-0.</p>
<p>The visitors barely had the chance to reset before they found themselves 2-0 down as Abbruzzese sent a fizzing free-kick into the area which was skimmed off the head of Jenkins and flew into the bottom right-hand corner, giving goalkeeper Reece Trueman no chance of saving it and the Town a dream start.</p>

<figure class="post-content-image post-content-image-has-caption alignnone">
	<img loading="lazy" decoding="async" class="wp-image-9681" src="' . plugins_url('/hwc/hwc-images/Hwest-County-vs-Colwyn-Bay-2-133-High-Res-1.jpg') . '?class=large" alt="" width="600" height="400">
	<figcaption class="caption">© RawPhotography</figcaption>
</figure>

<p>This early cushion gave County something to defend, and the remainder of the first half was relatively low key as Pennock’s side allowed Colwyn Bay to have the lions share of possession whilst looking strong in defence and snuffing out any dangerous moments.</p>
<p>Seagulls striker Jamie Cumming had a rare shot on goal with the half-hour mark approaching when his effort from just outside the area went wide of the left post.</p>
<h5>Second half</h5>
<p>The Bluebirds came out for the second half in a similar vein to how they had started the contest, with Kai Whitmore going close four minutes after the restart when he jinked and weaved his way into the area in trademark fashion before flashing his effort across the face of goal.</p>
<p>Four minutes later Haverfordwest County regained possession in midfield and broke up the pitch before Whitmore’s through ball played Fawcett in, however the striker’s effort went wide of the right post.</p>
<p>County were limiting the visitors to very little in the way of clear-cut opportunities, however Zac Jones did have to be alert with the hour mark approaching when striker Udi Akpan sent a powerful first-time volley on goal, which was tipped over the crossbar by the Kiwi.</p>

<figure class="post-content-image post-content-image-has-caption alignnone">
	<img loading="lazy" decoding="async" class="wp-image-9682" src="' . plugins_url('/hwc/hwc-images/Hwest-County-vs-Colwyn-Bay-2-406-High-Res.jpg') . '?class=large" alt="" width="600" height="400">
	<figcaption class="caption">© RawPhotography</figcaption>
</figure>

<p>Evans was introduced shortly after for his first minutes since rejoining the club, as he came on to replace Carroll.</p>
<p>Pennock’s side were managing the game professionally as the closing stages drew nearer, with the defence keeping the Seagulls at Bay, and with 17 minutes left on the clock the 523-strong crowd in attendance were able to celebrate a third goal when Trueman’s misdirected clearance landed at the feet of Fawcett, who took a touch before curling into the net from the edge of the area for 3-0.</p>
<p>Shortly after the fourth official had signalled three minutes of added time, Evans had an opportunity to get in on the act when Whitmore’s pass picked him out unmarked inside the area, but his goalbound effort was blocked.</p>
<p>Jones was then forced into a save as he got down well to push substitute Tom Creamer’s header behind, before McCready’s effort from 20 yards found the net to give the Seagull something to cheer about, as the Bluebirds collected another three points to ensure they head into next Sunday’s crunch meeting with Penybont with plenty of momentum behind them.</p>
<p><em><strong>Attendance</strong></em><em>: 523</em></p>
<h5>Highlights</h5>
<p></p><figure class="ratio-16x9"><iframe loading="lazy" title="Uchafbwyntiau | Highlights | Hwlffordd 3-1 Bae Colwyn | JD Cymru Premier" width="500" height="281" src="https://www.youtube.com/embed/Hx558auJWto?feature=oembed" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen=""></iframe></figure><p></p>',
            'excerpt' => 'Our take on the 3-1 victory over Colwyn Bay on JD Cymru Premier MD31…',
            'category' => 'match-report',
            'tags' => array('Haverfordwest County', 'Rhys Abbruzzese', 'Lee Jenkins', 'Ben Fawcett', 'Haverfordwest County vs Colwyn Bay'),
            'image' => 'maxresdefault2.jpg',

            'acf' => array(
                'sidebar_card_image_name' => 'BluebirdsNestSeries.jpg',
                'sidebar_card_title' => 'Listen to our club podcast series!',
                'sidebar_card_button' => array(
                    'url' => 'https://www.youtube.com/playlist?list=PL0hgLwiLgTW17WmG0wp2c82tOIB5PkG7K',
                    'title' => 'Click here for full playlist!'
                ),
                'post_banner_video' => 'https://www.youtube.com/embed/iYdGY7kk0MI?feature=oembed',
            )
        ),
        array(
            'title' => 'Bluebirds make swift return to Essity for meeting with Silkmen',
            'content' => '<p><strong>Haverfordwest County AFC make their second visit of the season to Essity Stadium on Saturday as we take on Flint Town United, hoping to extend our good recent record in north Wales.</strong></p>
<p>The Bluebirds tasted defeat for the first time in 2024-25 last weekend as reigning champions and first-time UEFA Conference League qualifers The New Saints recorded a narrow 1-0 victory at LHP Stadium.</p>
<p>The Silkmen, meanwhile, notched their first victory of the campaign on MD6 as a brace from striker Elliott Reeves earned them a 2-0 win over Aberystwyth Town in front of the live Sgorio cameras at Park Avenue.</p>
<p>You have to go back to April 2023 for the most recent meeting betweent the sides. On that occasion, the Town ran out 2-0 winners at Essity Stadium thanks to goals from Corey Shephard and Jordan Davies.</p>
<p>County currently find themselves third in the standings after six rounds of action, and a victory tomorrow could see Tony Pennock’s side finish the weekend joint-top of the table.</p>
<h5>Flint Town United – At a glance</h5>
<p>Founded – 1886</p>
<p>Ground – The Essity Stadium</p>
<p>Manager – Lee Fowler</p>
<p>Captain – Harry Owen</p>

<figure class="post-content-image post-content-image-has-caption alignnone">
	<img loading="lazy" decoding="async" class="wp-image-10122" src="' . plugins_url('/hwc/hwc-images/2024-09-07-Aberystwyth-Town-vs-Flint-Town-United-58.jpg') . '?class=large" alt="" width="600" height="400" >
	<figcaption class="caption">Flint Town United manager, Lee Fowler. (Pic by Sam Eaden/FAW)</figcaption>
</figure>

<h5>Last five meetings</h5>
<p>April 1, 2023: Flint Town United 0-2 Haverfordwest County</p>
<p>February 18, 2023: Haverfordwest County 3-1 Flint Town United</p>
<p>November 5, 2022: Flint Town United 0-1 Haverfordwest County</p>
<p>September 24, 2022: Haverfordwest County 1-1 Flint Town United</p>
<p>December 4, 2021: Flint Town United 4-1 Haverfordwest County</p>
<h5>Form guide</h5>
<p><strong>Flint Town United</strong></p>
<p>L L L L W</p>
<p><strong>Haverfordwest County</strong></p>
<p>W D D W L</p>
<h5>Key player</h5>
<p><strong>Elliott Reeves</strong></p>

<figure class="post-content-image post-content-image-has-caption alignnone">
	<img loading="lazy" decoding="async" class="wp-image-10123" src="' . plugins_url('/hwc/hwc-images/2024-8-31_Barry-Town-United-v-Flint-Town-United_69.jpg') . '?class=large" alt="" width="600" height="400">
	<figcaption class="caption">Flint Town United striker, Elliott Reeves. (Pic by Lewis Mitchell/FAW)</figcaption>
</figure>

<h5>Officials</h5>
<p><strong>Referee: </strong>Rob Jenkins</p>
<p><strong>Assistants:&nbsp;</strong>Daniel Beckett and James Young</p>
<p><strong>Fourth official:&nbsp;</strong>Nick Pratt</p>
<p><strong>Observer:&nbsp;</strong>Michael Jones</p>
<h5>How to follow</h5>
<p>If you’re not able to join us in Flint, you can still keep up to date with all of the action by tuning into The Bluebirds Nest Live, which will be available on our YouTube channel, as well as our Facebook and X pages, from 2:25pm!</p>
<p>We will also have live, play-by-play updates on X.</p>
<p></p><figure class="ratio-16x9"><iframe loading="lazy" title="#TheBluebirdsNest Live | Flint Town United vs Haverfordwest County (13/09/24)" width="500" height="281" src="https://www.youtube.com/embed/B4oTUOLq4CY?feature=oembed" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen=""></iframe></figure><p></p>
<h5>JD Cymru Premier MD7 fixtures</h5>
<p><em>Kick-off times are 14:30 unless stated</em></p>
<p><span style="text-decoration: underline;">Friday September 13</span></p>
<p>Newtown vs. Cardiff Metropolitan (19:45 – Live on Sgorio)</p>
<p>Bala Town vs. Aberystwyth Town (19:45)</p>
<p><span style="text-decoration: underline;">Saturday September 14</span></p>
<p><em>Flint Town United vs. Haverfordwest County</em></p>
<p>Caernarfon Town vs. Briton Ferry Llansawel</p>
<p>The New Saints vs. Barry Town United</p>
<p><span style="text-decoration: underline;">Sunday September 15</span></p>
<p>Connah’s Quay Nomads vs. Penybont</p>
<h5>Previous meeting</h5>
<p></p><figure class="ratio-16x9"><iframe loading="lazy" title="Uchafbwyntiau / Highlights | Y Fflint 0-2 Hwlffordd" width="500" height="281" src="https://www.youtube.com/embed/cyiFZqKhNlE?feature=oembed" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen=""></iframe></figure><p></p>',
            'excerpt' => 'A look ahead to tomorrow\'s JD Cymru Premier MD7 encounter with Flint Town United!',
            'category' => 'match-preview',
            'tags' => array('Haverfordwest County', 'Flint Town United vs Haverfordwest County'),
            'image' => 'MatchPreview.jpg',

            'acf' => array(
                'sidebar_card_image_name' => 'BluebirdsNestSeries.jpg',
                'sidebar_card_title' => 'Listen to our club podcast series!',
                'sidebar_card_button' => array(
                    'url' => 'https://www.youtube.com/playlist?list=PL0hgLwiLgTW17WmG0wp2c82tOIB5PkG7K',
                    'title' => 'Click here for full playlist!'
                ),
                'post_banner_video' => '',
            )
        ),
        array(
            'title' => 'Haverfordwest County AFC announce signing of defender Kyle McCarthy',
            'content' => '<p><strong>Haverfordwest County AFC are delighted to announce the signing of Kyle McCarthy, who will link up with the Bluebirds for the 2024-25 season.</strong></p>
    <p>The defender, who has played over 200 times in the JD Cymru Premier, joins the club after 13 seasons in the capital with Cardiff Metropolitan.</p>
    <p>The 31-year-old, who is a former teammate of captain Dylan Rees, Alaric Jones and Elliot Scotcher, was an integral part of the Archers’ success in the last decade and more, having gone right the way from the old Welsh Football League Division Three to the top-flight.</p>
    <p>Kyle has been a member of the Cymru C setup in two of the last three seasons, featuring in the squad for the 4-0 victory over England C in 2022 before coming off the bench during the narrow 1-0 defeat to the same opposition in Altrincham a year later.</p>
    <p>He also has experience of playing in European competition, having been part of the team that competed against <span class="mw-page-title-main">Progrès Niederkorn of Luxembourg in the 2019-20 UEFA Europa League preliminary round.</span></p>
    
    <figure class="post-content-image post-content-image-has-caption alignnone">
    	<img decoding="async" class="wp-image-9898" src="' . plugins_url('/hwc/hwc-images/2023-03-20_Cymru_C_Training_NCM-0008.jpg') . '?class=large" alt="" width="600" height="400" >
    	<figcaption class="caption">Kyle pictured alongside new teammate, Lee Jenkins ahead of Cymru C training in March 2023. (Photo: Nik Mesney/FAW)</figcaption>
    </figure>
    
    <p>Kyle captained the Students last season, as they secured a fourth place finish in Phase One before going on to compete in the end-of-season European play-offs for a second consecutive campaign.</p>
    <p>Bluebirds supporters will remember the goal Kyle scored at the Ogi Bridge Meadow in the final game of the 2021-22 season, as his first-time effort from 25 yards flew into the top left hand corner of the net for what proved to be the winning goal.</p>
    <p><strong>Commenting on the news, manager Tony Pennock said: </strong>“Signing someone of Kyle’s experience and quality is very exciting for our club. His versatility enhances the squad, and being left-footed he adds to our options on that side of the pitch.</p>
    <p>“He has shown for several years what an excellent player he is, and we are all looking forward to welcoming him to the group.”</p>
    <p><strong>Upon signing for the club, Kyle said:&nbsp;</strong>“I’m very excited and looking forward to joining Haverfordwest County AFC this season.</p>
    <p>“After having some conversations with Tony, this seems like a very ambitious club that I wanted to be part of, and I can’t wait to get started.”</p>
    <div class="post-body prose">
    <div class="post-body prose">
    <p><em><strong>If you are interested in sponsoring Kyle for the 2024-25 season, please do not hesitate to get in touch with our Commercial Manager, Dennis O’Connor, on <a href="mailto:d.oconnor@hcafc1899.football">d.oconnor@hcafc1899.football</a>!</strong></em></p>
    </div>
    </div>',
            'excerpt' => 'An experienced addition to our squad ahead of the new season!',
            'category' => 'transfer-news',
            'tags' => array('Haverfordwest County', 'Kyle McCarthy'),
            'image' => '48HFC290605_NewSigning_KyleMcCarthy1920x1080.jpg',

            'acf' => array(
                'sidebar_card_image_name' => 'BluebirdsNestSeries.jpg',
                'sidebar_card_title' => 'Listen to our club podcast series!',
                'sidebar_card_button' => array(
                    'url' => 'https://www.youtube.com/playlist?list=PL0hgLwiLgTW17WmG0wp2c82tOIB5PkG7K',
                    'title' => 'Click here for full playlist!'
                ),
                'post_banner_video' => '',
            )
        ),
        array(
            'title' => '2024-25 Season Tickets now on sale!',
            'content' => '<p><strong>Haverfordwest County AFC are delighted to announce the launch of our season tickets for the upcoming 2024-25 campaign!</strong></p>
<p>We are pleased to inform supporters that prices for adult and concession season tickets will remain at £75 and £50 respectively, as we continue to provide excellent value for Bluebirds fans to enjoy JD Cymru Premier football.</p>
<p>The support we have received in the last few years has been nothing short of remarkable, with average attendances at the Ogi Bridge Meadow almost doubling since our first full season in front of crowds after returning to Wales’ top-flight league. Last season, we were placed&nbsp;third in the top-flight for average attendances, behind only Caernarfon Town and Colwyn Bay.</p>

<figure class="post-content-image post-content-image-has-caption alignnone">
	<img decoding="async" class="wp-image-9789" src="' . plugins_url('/hwc/hwc-images/Hwest-County-vs-Colwyn-Bay-2-393-High-Res.jpg') . '?class=large" alt="" width="600" height="400">
	<figcaption class="caption">© RawPhotography</figcaption>
</figure>

<p>We have made a conscious effort in recent times to improve the matchday experience at the Ogi Bridge Meadow, and Bluebirds supporters can look forward to plenty more exciting initiatives in 2024-25!</p>
<p>Our unforgettable European journey last summer undoubtedly helped to build excitement around the club, and although the 2023-24 domestic campaign didn’t end in the way we would have hoped, the team – led once more by manager Tony Pennock – will be as motivated as ever to taste success again in 2024-25.</p>
<p>Our domestic season will get under way on the weekend of 2-4 August, when we enter the second round of the Nathaniel MG Cup. The 2024-25 JD Cymru Premier season kicks off a week later, with the fixtures for Phase One to be announced next Friday, 20 June at 10am!</p>
<p>The season ticket covers all 16 home matches in the JD Cymru Premier.</p>
<p><em><strong>To purchase your 2024-25 season tickets, <a href="https://haverfordwestcountyafc.com/club/season-tickets/">please follow this link</a>.</strong></em></p>',
            'excerpt' => 'Back the Bluebirds on our journey!',
            'category' => 'ticket-news',
            'tags' => array('Haverfordwest County'),
            'image' => '1920x1080-copy-2.jpg',

            'acf' => array(
                'sidebar_card_image_name' => 'BluebirdsNestSeries.jpg',
                'sidebar_card_title' => 'Listen to our club podcast series!',
                'sidebar_card_button' => array(
                    'url' => 'https://www.youtube.com/playlist?list=PL0hgLwiLgTW17WmG0wp2c82tOIB5PkG7K',
                    'title' => 'Click here for full playlist!'
                ),
                'post_banner_video' => '',
            )
        ),
        array(
            'title' => 'Pennock: Our disappointment shows how far we’ve come as a team',
            'content' => '<p><strong>Haverfordwest County AFC manager Tony Pennock believes the disappointment we felt at not taking something from the 1-0 defeat to JD Cymru Premier champions The New Saints yesterday shows how far we have come as a team.</strong></p>
<div class="QpPSMb">
<div class="DoxwDb">
<div class="PZPZlf ssJ7i B5dxMb" role="heading" aria-level="2" data-attrid="title">Adrian Cieślewicz’s first-half goal secured the victory for the Oswestry side, who will compete in the league phase of the UEFA Conference League for the first time this season.</div>
</div>
</div>
<p>The Bluebirds showed their battling qualities to stay in the contest right until the final whistle, and had opportunities of their own to find the net.</p>
<p>The Town remain third in the standings, and will be looking to build on the positives from this display when they visit Flint Town United next Saturday.</p>
<p>Here’s what the manager had to say in full after the game:</p>
<p><strong>On the result</strong></p>
<p>I think the boys gave a good account of themselves. Against TNS, we’re always going to have long spells without the ball, and they are going to have opportunities. I think they’ve had two shots on target. We limited them to a few half chances, not many clear-cut chances, and we were always in the game. We’ve had our chances ourselves, without testing the keeper, but I think it shows how far we’ve come as a group that we’re disappointed we didn’t get something out of the game. But at the same time, there’s still areas that we need to be better at, and today showed that against the best team in the league. So we’re disappointed, the [unbeaten] run has ended, but now it’s important that we bounce back as quick as we can and start the run again as soon as we can.</p>
<p><strong>On the performance</strong></p>
<p>There’s lots of positives. I thought there were some really good performances against, like I said, the best team in the league. I saw TNS play Aberystwyth on Tuesday, and I think only four of the ones who played Tuesday started today. It shows the strength and depth they’ve got. I think it shows that the team Craig [Harrison] picked on Tuesday against the team he picked today, obviously I think they saw us as a threat. I’m sure they see everybody as a threat, and I’m sure they thought they’d have a tough game here today and I think we have given them a good game. Like I said, we’ll learn a lot from those games. We know where we need to be better against the best teams and hopefully we take that into the rest of the season.</p>
<p></p><div class="post-embed post-embed-post">
<div class="card card-post card-lg card-w-link">

	
			<div class="card-image">
			<a href="https://haverfordwestcountyafc.com/2024/09/bluebirds-defeated-for-first-time-in-2024-25-as-champions-saints-claim-narrow-win/" aria-label="Bluebirds defeated for first time in 2024-25 as champions Saints claim narrow win">
							<div class="image-container ratio-16x9">
					<img width="480" height="270" src="' . plugins_url('/hwc/hwc-images/MatchReport.jpg') . '?class=16x9sm" class="fill" alt="Read the full article - Bluebirds defeated for first time in 2024-25 as champions Saints claim narrow win" >				</div>
			
			</a>		</div>
	
	
		<div class="card-content">

								
							<span class="card-title">Bluebirds defeated for first time in 2024-25 as champions Saints claim narrow win</span>
			
			
							<div class="card-meta">
					<span class="cat">Match Reports</span><span class="timestamp">6 days ago</span>				</div>
			
			
		</div>

	
</div>
</div><p></p>
<p>At times we gave the ball back to them far too cheaply. The boys know that, we talked about it after the game, and against somebody with that quality, you can’t keep giving them the ball. But in saying that, I thought we were in the game for the full 90 minutes, and when it’s only 1-0 you can always get something from the game. I thought the boys, they were great, it was exceptional as it always has been, and we’ll learn a lot from today. Like I said, to say we’re disappointed we’re losing to somebody who’s playing in the league phase of the UEFA Conference League, it says a lot about how far we’ve come as a group.</p>
<p><strong>On our start to the season</strong></p>
<p>The start has been excellent. The team’s we’ve played against, most of last year’s top six, only Bala from last year’s top six we haven’t played against, and Penybont – I say it again – I think will finish second this year. I think they’re a very strong team, and we gave them a good game here a couple of weeks ago. We dust ourselves down and we prepare really hard now for a game against Flint away next week. I’ve watched Flint twice this season and Fowls [Lee Fowler] has got them playing really good football. They’re a young side who are brave with the ball and it’ll be a really tough test away to Flint next week because I know how hard they work for each other.</p>
<p><strong>On next week’s challenge.</strong></p>
<p>They [Flint Town United] haven’t had the start that they’d have wanted, but in saying that they’re a team that don’t change how they play and they’re a very good footballing team. I saw them play their first game of the season against Cardiff Met, they lost that one 2-1 after being 1-0 ahead, and they had opportunities to get back in the game. Then last week away at Barry I was there and they were 2-0 up half time, had chances to score and maybe put the game to bed, they didn’t do that and then Barry came out second half, made a few changes and Barry were dominant in fairness to Jenks [Steve Jenkins] and his team. Sam Snaith came on and made a big difference for them, and once they got back to 2-1 so early in the game, you thought that Barry’s experience would help them and it certainly did. They went on to win the game 3-2, but it didn’t stop Flint battling away and playing the football as they know they can, and that’s what got them promoted up from the Cymru North, and that’s why they’re still playing it with the group of players they’ve got, so it’ll be a tough test. It always is at Flint.</p>
<p></p><div class="post-embed post-embed-post">
<div class="card card-post card-lg card-w-link">

	
			<div class="card-image">
			<a href="https://haverfordwestcountyafc.com/2024/09/haverfordwest-county-afc-welcome-troo-as-back-of-shirt-partner-for-2024-25/" aria-label="Haverfordwest County AFC welcome Troo as back-of-shirt partner for 2024-25">
							<div class="image-container ratio-16x9">
					<img width="480" height="270" src="' . plugins_url('/hwc/hwc-images/48HFC290605_PartnershipAnnouncement_Troo1920x1080.jpg') . '?class=16x9sm" class="fill" alt="Read the full article - Haverfordwest County AFC welcome Troo as back-of-shirt partner for 2024-25">				</div>
			
			</a>		</div>
	
	
		<div class="card-content">

								
							<span class="card-title">Haverfordwest County AFC welcome Troo as back-of-shirt partner for 2024-25</span>
			
			
							<div class="card-meta">
					<span class="cat">Commercial</span><span class="timestamp">1 week ago</span>				</div>
			
			
		</div>

	
</div>
</div><p></p>
<p><strong>On our strong defensive displays</strong></p>
<p>It’s something that we haven’t done in my previous two seasons, keep clean sheets. It was good today that we didn’t concede straight after they scored their first goal. Sometimes that’s something that we’ve done against TNS in the past. They’ve scored one, then they’ve scored two and three. We stayed in the game, we got to half time and regrouped, then we made a couple of changes after 10 minutes which gave us some fresh legs and it’s important that we do that as a side. The boys who start on the bench are as important as the boys who are starting from the first whistle, and Ben [Fawcett] and Harri [John] have come on and worked extremely well and given us some quality as well.</p>
<p>So as a group, we’ve moved forward from last season. We don’t concede goals as easily as we have in the past, and it’s an obvious statement but, if we don’t concede, we’ve got more chance of winning, and that’s the way we’re looking to play this year. We still want to play and have as much possession as we possibly can, but we need to be sensible in our own third, defend our goal, and the boys are certainly doing that – it’s pleasing to see.</p>',
            'excerpt' => 'The manager\'s reaction to our 1-0 defeat at home to The New Saints on MD6.',
            'category' => 'interview',
            'tags' => array('Haverfordwest County', 'Haverfordwest County vs The New Saints'),
            'image' => 'tonyTNSFI.jpg',

            'acf' => array(
                'sidebar_card_image_name' => 'BluebirdsNestSeries.jpg',
                'sidebar_card_title' => 'Listen to our club podcast series!',
                'sidebar_card_button' => array(
                    'url' => 'https://www.youtube.com/playlist?list=PL0hgLwiLgTW17WmG0wp2c82tOIB5PkG7K',
                    'title' => 'Click here for full playlist!'
                ),
                'post_banner_video' => '',
            )
        ),
        array(
            'title' => 'Haverfordwest County Summer Football Camp',
            'content' => '<p>We are delighted to announce the Haverfordwest County Summer Football Camp is available for Boys and Girls of the ages 5 – 13 to attend.</p>
<p>The camp will run from August 14th, 15th and 16th, 10:30am – 2.30pm on the Lower Pitches of the Ogi Bridge Meadow Stadium.</p>
<p>All sessions are carried out by UEFA Qualified, DBS checked and First Aid trained Coaches.</p>
<p><strong>The sessions cost £15 per day or £40 for the 3 days.</strong></p>',
            'excerpt' => 'The Haverfordwest County Summer Football Camp is available to attend from August 14th - 16th for ages 5-13',
            'category' => 'academy-news',
            'tags' => array('Haverfordwest County', 'Academy'),
            'image' => '14HFC0809_WebsiteAssets1920x1080-copy-4.jpg',
            'acf' => array(
                'sidebar_card_image_name' => '',
                'sidebar_card_title' => '',
                'sidebar_card_button' => array(
                    'url' => '',
                    'title' => ''
                ),
                'post_banner_video' => '',
            )
        ),
        array(
            'title' => 'Bluebirds Academy setup praised following Euro success',
            'content' => '<p><strong>When Haverfordwest County recorded the greatest night in their history by defeating </strong><strong>KF Shkëndija </strong><strong>of North Macedonia in the UEFA Europa Conference League first qualifying round last month, it was not only a proud night for the first team – but the Academy too.</strong></p>
<p>When the referee’s whistle blew to signal the end of extra time, after the tie had ended 1-1 on aggregate, there were no fewer than five players who have come through the Academy system on the pitch, while another – Ricky Watts, the longest-serving member of the current squad – had earlier been substituted.</p>
<p>Striker Ben Fawcett was joined by Jack Wilson, Iori Humphreys, Harri John and Lucas Davies, who had all come off the bench to play important roles, while John Chesters and Callum Shirt were also involved in the matchday squad.</p>
<p>Fawcett and Wilson, who have been teammates right the way through from junior to senior football, have been key members of the Bluebirds setup for a number of years, with both contributing plenty of goals on County’s remarkable journey from the JD Cymru South to the European stage.</p>
<p>Fawcett played the entire 120 minutes in the capital, as well as featuring for 90 minutes in the away leg, and put in two tireless shifts for his team. Wilson also started out in Skopje, before playing a crucial role in deciding the tie with his successful spot-kick giving County a 2-1 lead at the time.</p>
<p>Humphreys, meanwhile, is another Academy success story, having captained the under-19s development side in recent seasons, as well as being a regular part of the matchday squad in the JD Cymru Premier and cup competitions. The young defender helped to keep the visitors at bay as they looked for a late goal, with his energy and commitment proving crucial.</p>
<p>Humphreys recently passed on the mantle of development team captain to Davies, who has also been a part of the first team squad for the last two seasons, travelling around the country and gaining valuable senior experience in Wales’ top-flight league. He has also played for the Welsh Colleges, and was a member of the Welsh Schools’ side which retained the coveted Centenary Shield recently.</p>
<p>And then there is young midfielder John, who burst onto the scene last season at the age of just 16. After his talents had been noticed by the first team staff, he was soon awarded his first professional contract and was immediately integrated into the group, featuring a number of times across the campaign and impressing many with his mature displays.</p>
<p>Head of Coaching, Ashleigh Hopkins, has made clear his pride in the fact that Haverfordwest County are one of the leading lights when it comes to promoting young players into the first team, and is keen to continue this trend in the seasons ahead.</p>
<p>“We take great pride in the fact that the majority of the squad are current Academy players or have been Academy graduates from recent seasons,” he said. “This is down to all of the Academy staff that have helped develop these young players, and made them ready to experience both the Cymru Premier and the Europa Conference League.</p>
<p>“We are working extremely hard to continue to keep this development going, to support Tony Pennock (Manager), Gary Richards (Assistant Manager) and Rob Edwards (Chairman) with this process.</p>
<p>“I would like to thank the Academy coaches, who are doing a fantastic job, and we are ready to produce more players over the next few seasons. We certainly have some exciting prospects coming through.”</p>
<p>Chairman, Rob Edwards, was as delighted as anyone with this achievement, and commented: “I was extremely proud to see a number of academy players in the squad for our first European tie, and those that came on didn’t let us down.</p>
<p>“More importantly, the way all of them conducted themselves in both legs, in what was no doubt a daunting experience, was first class. They showed maturity and respect across the last few weeks, which is a credit to them, their families and the dedicated coaches in our academy.”</p>
<p>Hopkins continued: “The experience these players have had over the past two weeks, travelling to North Macedonia and playing at the Cardiff City Stadium against KF Shkëndija, was such a great learning curve, and this will stand them in good stead as they continue to develop in the early stages of their football careers.</p>
<p>“They are learning so much form the senior players and staff, with regards to match preparation, nutrition, planning and execution of game plans, a process which has been led exceptionally by all of the staff involved in the Europa Conference League planning.”</p>',
            'excerpt' => 'There were no fewer than five academy graduates on the pitch when the final whistle blew!',
            'category' => 'academy-news',
            'tags' => array('Haverfordwest County', 'Academy'),
            'image' => 'academyeuroFI.jpg',
            'acf' => array(
                'sidebar_card_image_name' => '',
                'sidebar_card_title' => '',
                'sidebar_card_button' => array(
                    'url' => '',
                    'title' => ''
                ),
                'post_banner_video' => '',
            )
        ),
        array(
            'title' => 'Successful Academy season marked with caps for First Team debuts',
            'content' => '<p><strong>After what was a fantastic season for Haverfordwest County Academy, we are pleased to confirm that, having achieved Category B status, we will be able to continue providing a high-quality level of support to our young players from our local communities and surrounding areas.</strong></p>
<p>The audit process, which resulted in our accreditation, signified 12 months of hard work from within the club, and congratulations must go to all of the staff that have supported this process.</p>
<p>Head of Coaching, Ashleigh Hopkins, would especially like to thank all of our part-time members of staff for their professionalism and commitment over the course of the season. As well as this, our thanks must also go to all parents for their support with the players’ fixtures across the whole of south Wales, especially early on a Sunday morning, and those players that have fully supported the FAW ‘1 Player 1 Club’ rule from ages 12-19.</p>
<p>We can say that we are one of only a handful of Category B Academies in Wales, and we will strive to give players an elite environment where they can develop and reach their potential through constant Player Assessments and Individual Action Plans.</p>
<p>The cream of the crop was undoubtedly the players who made their First Team debuts in the 2022-23 season. This amazing achievement was made possible by Manager, Tony Pennock, Assistant Manager, Gary Richards, and Head of Goalkeeping, James Devonald, who have all had parts to play in the continuing development of the young players.</p>
<p>We have also had several players trial with Swansea City Academy, and one player has signed for the club on a full-time basis.</p>
<p>We would like to thank all of the clubs that have helped the following Academy graduates by providing support in the early stages of their development, helping to ensure that they could take the next steps in their footballing careers.</p>',
            'excerpt' => 'We recognise our Academy graduates who featured in the First Team in the 2022-23 season!',
            'category' => 'academy-news',
            'tags' => array('Haverfordwest County', 'Academy'),
            'image' => 'debutcapsFI.jpg',
            'acf' => array(
                'sidebar_card_image_name' => '',
                'sidebar_card_title' => '',
                'sidebar_card_button' => array(
                    'url' => '',
                    'title' => ''
                ),
                'post_banner_video' => '',
            )
        ),
        array(
            'title' => 'Haverfordwest County AFC to continue partnership with The Turmeric Co. for 2024-25',
            'content' => '<p><strong>Haverfordwest County AFC are delighted to confirm we have renewed our partnership agreement with The Turmeric Co. for the 2024-25 season.</strong></p>
<p>The functional nutrition brand, which was founded by former Cymru international Thomas ‘Hal’ Robson-Kanu, has been our Official Turmeric Supplier for the last two seasons, after initially coming on board in August 2022.</p>
<p>Developed over 15 years, their powerful formula contains only raw and fresh turmeric root (35 grams), carefully extracted and delivered in what they know to be a bioavailable form.</p>
<p>Our partnership enables the Bluebirds first team squad to take advantage of the fantastic range of products on offer, which help support them with their health and wellbeing through nutrition, enhancing performance and recovery with their natural raw turmeric shots.</p>

<figure class="post-content-image post-content-image-has-caption alignnone">
	<img decoding="async" class="wp-image-10214" src="https://media.touchlinefc.co.uk/haverfordwestcounty/2024/09/20133744/IMG_7004.jpeg?class=large" alt="" width="600" height="600" srcset="https://media.touchlinefc.co.uk/haverfordwestcounty/2024/09/20133744/IMG_7004.jpeg 3024w, https://media.touchlinefc.co.uk/haverfordwestcounty/2024/09/20133744/IMG_7004.jpeg?class=thumbnail 300w, https://media.touchlinefc.co.uk/haverfordwestcounty/2024/09/20133744/IMG_7004.jpeg?class=1x1md 900w, https://media.touchlinefc.co.uk/haverfordwestcounty/2024/09/20133744/IMG_7004.jpeg?class=large 1200w, https://media.touchlinefc.co.uk/haverfordwestcounty/2024/09/20133744/IMG_7004.jpeg?class=1536x1536 1536w, https://media.touchlinefc.co.uk/haverfordwestcounty/2024/09/20133744/IMG_7004.jpeg?class=2048x2048 2048w, https://media.touchlinefc.co.uk/haverfordwestcounty/2024/09/20133744/IMG_7004.jpeg?class=1x1xs 150w, https://media.touchlinefc.co.uk/haverfordwestcounty/2024/09/20133744/IMG_7004.jpeg?class=1x1sm 400w" sizes="(max-width: 600px) 100vw, 600px">
	<figcaption class="caption">Zac Jones and Alaric Jones with The Turmeric Co’s shot bottles.</figcaption>
</figure>

<p>The brand, which is partnered with numerous elite sporting organisations including Swansea City, Leicester Tigers, Brentford FC, British Gymnastics, Everton FC and Sale Sharks, has a wide range of products to choose from, including Original Raw Turmeric, Raw Turmeric &amp; Ginger, Raw Turmeric &amp; Beetroot, and the world’s first all-in-one Raw Turmeric Vitamin C &amp; D3</p>
<p><strong>Commenting on our partnership renewal, Commercial and Marketing Director, Ben Tyler said: </strong>“We are delighted to be continuing our partnership with The Turmeric Co. for a third season. Their products have proved to be very popular with members of the first team, who take advantage of them on a regular basis to aid their performance and recovery. We are very grateful for The Turmeric Co’s ongoing support of Haverfordwest County AFC.”</p>
<div class="article-body">
<div class="widget-wrapper js-widget js-widget--desktop is-visible--desktop js-widget--tablet is-visible--tablet js-widget--mobile is-visible--mobile" data-widget-id="20bd9d9752508a8544f60cb412008584">
<div class="widget widget--text">
<div class="content-center content-center--small prose">
<p><em>To learn more about The Turmeric Co., visit&nbsp;<a href="https://theturmeric.co/" target="_blank" rel="noopener">theturmericco.co</a> or follow on Instagram at: @theturmericco, on Facebook and X at: @TheTurmericCo</em></p>
</div>
</div>
</div>
</div>',
            'excerpt' => 'Haverfordwest County AFC are delighted to confirm we have renewed our partnership',
            'category' => 'commercial',
            'tags' => array('Haverfordwest County', 'Commercial'),
            'image' => 'debutcapsFI.jpg',
            'acf' => array(
                'sidebar_card_image_name' => '',
                'sidebar_card_title' => '',
                'sidebar_card_button' => array(
                    'url' => '',
                    'title' => ''
                ),
                'post_banner_video' => '',
            )
        ),
        array(
            'title' => '#YouCanHaveItAll | Bluebirds In Europe – Episode 1',
            'content' => '',
            'excerpt' => 'The third and final instalment of our three-part series is available to watch right now!',
            'category' => 'you-can-have-it-all',
            'tags' => array('Haverfordwest County', 'Commercial'),
            'image' => 'debutcapsFI.jpg',
            'acf' => array(
                'sidebar_card_image_name' => '',
                'sidebar_card_title' => '',
                'sidebar_card_button' => array(
                    'url' => '',
                    'title' => ''
                ),
                'post_banner_video' => 'https://www.youtube.com/embed/_eVdLzPaxW0',
            )
        ),
    );
    if (!get_option('hwc_categories_and_posts_created', false)) {

        foreach ($posts as $post_data) {
            // Check if the post with the title already exists
            $existing_posts = get_posts(array(
                'title' => $post_data['title'],
                'post_type' => 'post',
                'post_status' => 'any', // Check for any status including trash
                'numberposts' => 1
            ));

            if (!$existing_posts) {
                // Post does not exist, create it
                $category = get_term_by('slug', $post_data['category'], 'category');
                $post_id = wp_insert_post(array(
                    'post_title'   => $post_data['title'],
                    'post_content' => $post_data['content'],
                    'post_excerpt' => $post_data['excerpt'],
                    'post_status'  => 'publish',
                    'post_author'  => 1, // Replace with the desired author ID
                    'post_category' => array($category->term_id),
                ));

                if ($post_id && !is_wp_error($post_id)) {
                    // Set post tags
                    wp_set_post_tags($post_id, $post_data['tags'], true);

                    // Define the filename of the image you want to use
                    $image_filename = $post_data['image']; // Replace with your actual image filename

                    // Ensure $post_id is defined and valid
                    if (!empty($image_filename) && !empty($post_id)) {
                        // Call the function to create the image from the plugin directory
                        $image_id = hwc_create_image_from_plugin($image_filename, $post_id);

                        // Check if there was an error creating the image
                        if (!is_wp_error($image_id)) {
                            // Set the post thumbnail with the new image
                            set_post_thumbnail($post_id, $image_id);
                        } else {
                            // Handle the error appropriately
                            echo $image_id->get_error_message(); // Display error message
                        }
                    }


                    // Update tags and ACF fields
                    wp_set_post_tags($post_id, $post_data['tags'], true);

                    if ($post_data['acf']['sidebar_card_image_name']) {
                        $hwc_right_card_image_id = hwc_create_image_from_plugin($post_data['acf']['sidebar_card_image_name'], $post_id);

                        if (!is_wp_error($hwc_right_card_image_id)) {
                            // Update the ACF field with the attachment ID
                            update_field('sidebar_card_image', $hwc_right_card_image_id, $post_id);
                        } else {
                            // Log the error message
                            error_log('Failed to upload background image: ' . $hwc_right_card_image_id->get_error_message());
                        }
                    }

                    if ($post_data['acf']['sidebar_card_title']) {
                        update_field('sidebar_card_title', $post_data['acf']['sidebar_card_title'], $post_id);
                    }

                    if ($post_data['acf']['post_banner_video']) {
                        update_field('post_banner_video', $post_data['acf']['post_banner_video'], $post_id);
                    }

                    if ($post_data['acf']['sidebar_card_button']['url']) {
                        update_field('sidebar_card_button', array(
                            'url' => $post_data['acf']['sidebar_card_button']['url'],
                            'title' => $post_data['acf']['sidebar_card_button']['title'],
                        ), $post_id);
                    }
                }
            }
        }

        // After the function has run, set the option to true
        update_option('hwc_categories_and_posts_created', true);
    }
}
//end