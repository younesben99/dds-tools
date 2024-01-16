<?php

function policy_shortcode(){
    include(__DIR__ . "/policy_template.php");   
}

add_shortcode('dds_policy', 'policy_shortcode');


function policy_generator(){
$policy_page_query = new WP_Query(array(
    'post_type' => 'page',
    'post_title' => 'Privacy beleid',
));

if (empty($policy_page_query->posts)) {
    $page_id = wp_insert_post(
        array(
            'comment_status' => 'closed',
            'ping_status'    => 'closed',
            'post_author'    => 1,
            'post_title'     => ucwords('Privacy beleid'),
            'post_name'      => strtolower(str_replace(' ', '', trim('Privacy beleid'))),
            'post_status'    => 'publish',
            'post_content'   => '[dds_policy]',
            'post_type'      => 'page'
        )
    );
}
}

?>