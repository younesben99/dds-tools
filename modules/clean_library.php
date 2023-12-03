<?php
include(__DIR__."/../../../../wp-load.php");
?>
<?php
function get_media_info_for_autos() {
    $args = array(
        'post_type' => 'autos',
        'posts_per_page' => -1,
    );
    $query = new WP_Query($args);
    $media_names = array();
    $total_file_size = 0;
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $vdw_gallery_ids_serialized = get_post_meta($post_id, 'vdw_gallery_id', true);
            if ($vdw_gallery_ids_serialized) {
                $vdw_gallery_ids = unserialize($vdw_gallery_ids_serialized);
                foreach ($vdw_gallery_ids as $media_id) {
                    $media_post = get_post($media_id);
                    if ($media_post) {
                        $media_names[] = $media_post->post_name;
                        $file_path = get_attached_file($media_id);
                        $total_file_size += filesize($file_path);
                    }
                }
            }
        }
    }
    wp_reset_postdata();
    
    $result = array(
        'count' => count($media_names),
        'total_file_size' => $total_file_size,
        'media_names' => $media_names,
    );

    return json_encode($result);
}

$result = get_media_info_for_autos();
echo '<pre>'; print_r(json_decode($result, true)); echo '</pre>';