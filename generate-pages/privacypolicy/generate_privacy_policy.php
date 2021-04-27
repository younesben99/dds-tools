<?php

function policy_shortcode(){
    include(__DIR__ . "/policy_template.php");   
}

add_shortcode('dds_policy', 'policy_shortcode');

$check_page_exist = get_page_by_title('Privacy beleid', OBJECT, 'page');

if(empty($check_page_exist)) {
    $page_id = wp_insert_post(
        array(
        'comment_status' => 'close',
        'ping_status'    => 'close',
        'post_author'    => 1,
        'post_title'     => ucwords('Privacy beleid'),
        'post_name'      => strtolower(str_replace(' ', '', trim('Privacy beleid'))),
        'post_status'    => 'publish',
        'post_content'   => '[dds_policy]',
        'post_type'      => 'page'
        )
    );
}

?>