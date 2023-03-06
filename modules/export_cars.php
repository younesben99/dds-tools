<?php


include(__DIR__."/../../../../wp-load.php");

function download_image_sizes_json() {
    // Query all the WordPress posts of the "autos" custom post type
    $args = array(
      'post_type' => 'autos',
      'posts_per_page' => -1,
    );
    $posts = get_posts($args);
  
    // Extract the image IDs and sizes for each post's vdw gallery
    $images = array();
    $image_sizes = get_intermediate_image_sizes();
    foreach ($posts as $post) {
      $gallery_ids = get_post_meta($post->ID, 'vdw_gallery_id', true);
      if (is_array($gallery_ids)) {
        $images_by_size = array();
        foreach ($gallery_ids as $id) {
          foreach ($image_sizes as $size_name) {
            $url = wp_get_attachment_image_url($id, $size_name);
            if ($url) {
              $images_by_size[$size_name][] = $url;
            }
          }
        }
        $images[] = array(
          'car_id' => $post->ID,
          'image_sizes' => $images_by_size,
        );
      }
    }
  
    // Create a new JSON file that contains the image sizes by car
    $output = array('image_sizes_by_car' => $images);
    $json = json_encode($output, JSON_PRETTY_PRINT);
  
    // Send the new JSON file as a download to the user
    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename="image_sizes.json"');
    header('Content-Length: ' . strlen($json));
    echo $json;
    exit;
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
?>



<!-- Add button to download JSON file -->
<button onclick="window.location.href='<?php echo esc_url( home_url( '/wp-content/plugins/dds-tools/modules/export_cars.php?generate' ) ); ?>'">Download JSON File</button>
<button onclick="window.location.href='<?php echo esc_url( home_url( '/wp-content/plugins/dds-tools/modules/export_cars.php?imagenames' ) ); ?>'">Get image names of all cars</button>
