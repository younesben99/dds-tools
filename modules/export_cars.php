<?php
include(__DIR__."/../../../../wp-load.php");
?>
<?php



function delete_unused_images($delete = true) {
    download_image_sizes_json(false);
    // Get the contents of the image_sizes.json file
    $json_file_path = WP_CONTENT_DIR . '/image_sizes.json';
    $json_file_contents = file_get_contents($json_file_path);
    $json_data = json_decode($json_file_contents, true);
    $image_sizes = $json_data['image_sizes'];

    $args = array(
        'post_type' => 'attachment',
        'post_status' => 'inherit',
        'posts_per_page' => -1
    );
    $query = new WP_Query($args);

    // Count the total number of media files and total size of files being deleted
    $total_count = $query->found_posts;
    $total_size = 0;
    $used_count = 0;
    $used_size = 0;
    $unused_count = 0;
    $unused_size = 0;
    $no_uniqid_count = 0;
    $no_uniqid_size = 0;

    $attachments_to_delete = array();

    while ($query->have_posts()) {
        $query->the_post();
        $filename = basename(get_attached_file(get_the_ID()));
        if (preg_match('/_[0-9a-f]{13,}/', $filename)) {
            if (in_array(wp_get_attachment_url(get_the_ID()), $image_sizes)) {
                // If the media file has a uniqid() and is in the image_sizes array, increment the used count and size
                $used_count++;
                $used_size += filesize(get_attached_file(get_the_ID()));
            } else {
                // If the media file has a uniqid() and is not in the image_sizes array, increment the unused count and size
                $attachments_to_delete[] = get_the_ID();
                $unused_count++;
                $unused_size += filesize(get_attached_file(get_the_ID()));
            }
        } else {
            // If the media file has no uniqid() in the filename, increment the no_uniqid count and size
            $no_uniqid_count++;
            $no_uniqid_size += filesize(get_attached_file(get_the_ID()));
        }
    }
    
    // Delete the unused attachments
    if($delete == true){
        foreach ($attachments_to_delete as $attachment_id) {
            wp_delete_attachment($attachment_id, true);
        }
    }

    // Output the results
    echo "Total number of media files: " . $total_count . " (" . size_format($no_uniqid_size + $used_size + $unused_size) . ")" . "<br>";
    echo "Number of media files with a uniqid() IN JSON FILE: " . $used_count . " (" . size_format($used_size) . ")" . "<br>";
    echo "Number of media files with a uniqid() NOT IN JSON FILE: " . $unused_count . " (" . size_format($unused_size) . ")" . "<br>";
    echo "Number of media files with NO uniqid(): " . $no_uniqid_count . " (" . size_format($no_uniqid_size) . ")" . "<br>";
    if($delete == true){
        echo "Total size of files being deleted: " . size_format($unused_size) . "<br>";
    }

    echo "<hr>";
}

delete_unused_images(false);

function download_image_sizes_json($download = true) {
    
 
        // Query all the WordPress posts of the "autos" custom post type
        $args = array(
          'post_type' => 'autos',
          'posts_per_page' => -1,
        );
        $posts = get_posts($args);
      
        // Extract the image IDs and sizes for each post's vdw gallery
        $image_sizes = get_intermediate_image_sizes();
        $images_by_size = array();
        foreach ($posts as $post) {
          $gallery_ids = get_post_meta($post->ID, 'vdw_gallery_id', true);
          if (is_array($gallery_ids)) {
            foreach ($gallery_ids as $id) {
              foreach ($image_sizes as $size_name) {
                $url = wp_get_attachment_image_url($id, $size_name);
                if ($url) {
                  $images_by_size[] = $url;
                }
              }
            }
          }
        }
      
        // Remove duplicates
        $images = array_values(array_unique($images_by_size));
      
        // Create a new JSON file that contains the image sizes by car
        $output = array('image_sizes' => $images);
        $json = json_encode($output, JSON_PRETTY_PRINT);
      
        // Save the new JSON file in the wp-content folder
        $file_path = WP_CONTENT_DIR . '/image_sizes.json';
        $file = fopen($file_path, 'w');
        fwrite($file, $json);
        fclose($file);
      
        if($download == true){
        // Send the new JSON file as a download to the user
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="image_sizes.json"');
        header('Content-Length: ' . strlen($json));
        echo $json;
        exit;
        }
       
      }
      
      

  
  
/**
 * Function to generate the JSON file and download it
 */
function generate_and_download_json() {
    // Replace 'your_custom_post_type' with the name of your custom post type
$custom_post_type = 'autos';
    // Get all posts of the custom post type
    $args = array(
        'post_type' => $custom_post_type,
        'posts_per_page' => -1,
    );

    $query = new WP_Query( $args );
    $posts = $query->get_posts();

    // Create array to store post data
    $post_data = array();

    // Loop through each post and add its data to the array
    foreach ( $posts as $post ) {
        // Get post data
        $post_id = $post->ID;
        $post_title = $post->post_title;
        $post_content = $post->post_content;
        $post_date = $post->post_date;
        $post_modified = $post->post_modified;

        // Get custom fields
        $custom_fields = get_post_custom( $post_id );

        // Add any additional data you want to include
        $additional_data = additional_data( $post_id );

        // Create array for this post's data
        $post_array = array(
            'ID' => $post_id,
            'post_title' => $post_title,
            'post_content' => $post_content,
            'post_date' => $post_date,
            'post_modified' => $post_modified,
            'custom_fields' => $custom_fields,
            'additional_data' => $additional_data,
        );

        // Add post array to the post data array
        array_push( $post_data, $post_array );
    }

    // Convert post data array to JSON
    $post_data_json = json_encode( $post_data );

    // Set file name and type
    $file_name = $custom_post_type . '.json';
    $content_type = 'application/json';

    // Set headers to force download
    header( 'Content-Description: File Transfer' );
    header( 'Content-Disposition: attachment; filename=' . $file_name );
    header( 'Content-Type: ' . $content_type );
    header( 'Content-Transfer-Encoding: binary' );
    header( 'Content-Length: ' . strlen( $post_data_json ) );

    // Output file contents
    echo $post_data_json;

    // Exit script to prevent any other output
    exit;
}

/**
 * Function to add any additional data you want to include in the JSON file
 * @param int $post_id The ID of the post
 * @return array Array of additional data
 */
function additional_data( $post_id ) {
    // Add any additional data you want to include in the JSON file
    return array();
}


if(isset($_GET["generate"])){
    generate_and_download_json();
}

if(isset($_GET["imagenames"])){
    download_image_sizes_json();
}

if(isset($_GET["delete"])){
    delete_unused_images();
}

?>

<!-- Add button to download JSON file -->
<button onclick="window.location.href='<?php echo esc_url( home_url( '/wp-content/plugins/dds-tools/modules/export_cars.php?generate' ) ); ?>'">Download JSON File</button>
<button onclick="window.location.href='<?php echo esc_url( home_url( '/wp-content/plugins/dds-tools/modules/export_cars.php?imagenames' ) ); ?>'">Get image names of all cars</button>
<button onclick="window.location.href='<?php echo esc_url( home_url( '/wp-content/plugins/dds-tools/modules/export_cars.php?delete' ) ); ?>'">DELETE MEDIA FILES</button>




<hr>
