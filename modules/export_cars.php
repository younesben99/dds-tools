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
            $vdw_gallery_ids = get_post_meta($post_id, 'vdw_gallery_id', true);
            
            if (is_array($vdw_gallery_ids)) {
                foreach ($vdw_gallery_ids as $media_id) {
                    $media_post = get_post($media_id);
                    if ($media_post) {
                        $media_names[] = $media_post->post_name;
                        $file_path = get_attached_file($media_id);
                        if (file_exists($file_path)) {
                            $total_file_size += filesize($file_path);
                        }
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
    
$wp_media_args = array(
    'post_type' => 'attachment',
    'post_status' => 'inherit',
    'posts_per_page' => -1,
);

$media_query = new WP_Query($wp_media_args);

if ($media_query->have_posts()) {
    while ($media_query->have_posts()) {
        $media_query->the_post();
        $media_id = get_the_ID();
        $media_name = get_post($media_id)->post_name;

        // Check if the media name contains a uniqid pattern (hexadecimal string)
        if (preg_match('/[a-f0-9]{13}/', $media_name) && !in_array($media_name, $media_names)) {
            // Delete the media file
            wp_delete_attachment($media_id, true);
        }
    }
}

wp_reset_postdata();
    return json_encode($result);
}



function compress_images_recursive($path_to_dir, $quality = 70, &$counter = 0) {
    // Create a recursive directory iterator for the directory and its subdirectories
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($path_to_dir)
    );

    // Loop through each file in the directory and its subdirectories
    foreach ($iterator as $file) {
        if ($file->isDir()) {
            // Ignore directories
            continue;
        }

        $file_path = $file->getPathname();

        // Get the file extension
        $extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));

        if ($extension === 'jpg' || $extension === 'jpeg' || $extension === 'png') {
            // Get the file size in bytes
            $file_size = filesize($file_path);

            if ($file_size > 350000) {
                // Load the image using the appropriate function
                if ($extension === 'jpg' || $extension === 'jpeg') {
                    $image = imagecreatefromjpeg($file_path);
                } else {
                    $image = imagecreatefrompng($file_path);
                }

                // Get the width and height of the image using the imagesx and imagesy functions
                $width = imagesx($image);
                $height = imagesy($image);

                // Calculate the new height based on the maximum width of 750 pixels
                $new_width = min($width, 750);
                $new_height = (int) ($new_width * $height / $width);

                // Create a new image using the imagecreatetruecolor function with the new width and height
                $new_image = imagecreatetruecolor($new_width, $new_height);

                // Copy the original image onto the new image using the appropriate function
                if ($extension === 'jpg' || $extension === 'jpeg') {
                    imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                } else {
                    imagealphablending($new_image, false);
                    imagesavealpha($new_image, true);
                    imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                }

                // Save the new image using the appropriate function with the specified quality
                if ($extension === 'jpg' || $extension === 'jpeg') {
                    if (imagejpeg($new_image, $file_path, $quality)) {
                        $counter++;
                    }
                } else {
                    if (imagepng($new_image, $file_path, floor($quality / 100 * 9))) {
                        $counter++;
                    }
                }

                // Free up memory by destroying the images
                imagedestroy($image);
                imagedestroy($new_image);
            }
        }
    }
}




function compress_dds_dropzone() {
    // Call the function to compress all JPEG images in /uploads/dds_dropzone/ and its subdirectories
    $uploads_dir = wp_upload_dir();
    $dds_dropzone_path = $uploads_dir['basedir'] . '/dds_dropzone/';
    $counter = 0;
    compress_images_recursive($dds_dropzone_path, 60, $counter);
    echo 'Number of images successfully compressed: ' . $counter;
}




function create_media_file_info_json($download = true) {
    // Get all media files
    $args = array(
        'post_type' => 'attachment',
        'post_status' => 'inherit',
        'posts_per_page' => -1
    );
    $query = new WP_Query($args);

    // Create an array to store the media file information
    $media_files = array();

    while ($query->have_posts()) {
        $query->the_post();
        $filename = basename(get_attached_file(get_the_ID()));
        $attachment_id = get_the_ID();
        $attachment_metadata = wp_get_attachment_metadata($attachment_id);
        if (!empty($attachment_metadata['sizes'])) {
            foreach ($attachment_metadata['sizes'] as $size) {
                $media_files[] = $size['file'];
            }
        }
        $media_files[] = $filename;
    }

    // Remove any duplicate filenames
    $media_files = array_unique($media_files);

    // Encode the media file information as JSON
    $json_data = json_encode($media_files);

    // Save the JSON to a file
    $json_file_path = WP_CONTENT_DIR . '/media_files.json';
    file_put_contents($json_file_path, $json_data);

    // Download the JSON file if the download parameter is set to true
    if ($download) {
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename=media_files.json');
        readfile($json_file_path);
        exit();
    }
}

// Call the function to create the JSON file and download it if the download parameter is set to true
create_media_file_info_json(false);

function delete_unused_images_from_upload_folders() {
   // Get the JSON file containing the media file information
   $json_file_path = WP_CONTENT_DIR . '/media_files.json';
   $json_file_contents = file_get_contents($json_file_path);
   $media_files = json_decode($json_file_contents, true);

   // Loop through the year-based subdirectories in the uploads folder
   $uploads_dir = wp_upload_dir();
   $uploads_path = $uploads_dir['basedir'];
   $year_dirs = array_filter(scandir($uploads_path), function($dir) {
       return is_dir($dir) && preg_match('/^[0-9]{4}$/', $dir);
   });

   foreach ($year_dirs as $year_dir) {
       // Loop through the month-based subdirectories in the current year directory
       $month_dirs = array_filter(scandir("$uploads_path/$year_dir"), function($dir) {
           return is_dir("$uploads_path/$year_dir/$dir");
       });

       foreach ($month_dirs as $month_dir) {
           // Get all files in the current directory
           $files = glob("$uploads_path/$year_dir/$month_dir/*.*");

           foreach ($files as $file) {
               // Check if the file is in the media_files array
               $filename = basename($file);
               if (!in_array($filename, $media_files)) {
                   // If the file is not in the media_files array, delete it
                   unlink($file);
               }
           }
       }
   }
}



function delete_dds_dropzone() {
    $uploads_dir = wp_upload_dir();
    $dds_dropzone_path = $uploads_dir['basedir'] . '/dds_dropzone/';

    // Get the current time and subtract 4 months
    $four_months_ago = strtotime('-4 months');

    // Get all subdirectories in the /uploads/dds_dropzone/ directory
    $subdirs = glob($dds_dropzone_path . '/*', GLOB_ONLYDIR);

    foreach ($subdirs as $subdir) {
        // Get the creation time of the subdirectory
        $created_time = filectime($subdir);

        // If the subdirectory was created more than 4 months ago, delete it
        if ($created_time < $four_months_ago) {
            // Delete the subdirectory and all its contents recursively
            $files = glob($subdir . '/*');
            foreach ($files as $file) {
                if (is_dir($file)) {
                    // If the file is a directory, delete it and all its contents recursively
                    $this->rrmdir($file);
                } else {
                    // If the file is a regular file, delete it
                    unlink($file);
                }
            }
            rmdir($subdir);
        }
    }
}

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
if(isset($_GET["medialibrary"])){
    create_media_file_info_json();
}
if(isset($_GET["deletenotinmedia"])){
    delete_unused_images_from_upload_folders();
}
if(isset($_GET["dropzone"])){
    compress_dds_dropzone();
}
if(isset($_GET["notused"])){
    get_media_info_for_autos();
}
?>

<!-- Add button to download JSON file -->
<button onclick="window.location.href='<?php echo esc_url( home_url( '/wp-content/plugins/dds-tools/modules/export_cars.php?generate' ) ); ?>'">Download JSON File</button>
<button onclick="window.location.href='<?php echo esc_url( home_url( '/wp-content/plugins/dds-tools/modules/export_cars.php?imagenames' ) ); ?>'">Get image names of all cars</button>
<button onclick="window.location.href='<?php echo esc_url( home_url( '/wp-content/plugins/dds-tools/modules/export_cars.php?medialibrary' ) ); ?>'">Media library JSON</button>
<button onclick="window.location.href='<?php echo esc_url( home_url( '/wp-content/plugins/dds-tools/modules/export_cars.php?delete' ) ); ?>'">DELETE MEDIA FILES</button>
<button onclick="window.location.href='<?php echo esc_url( home_url( '/wp-content/plugins/dds-tools/modules/export_cars.php?deletenotinmedia' ) ); ?>'">DELETE UPLOADS FOLDER NOT FOUND IN MEDIA LIBRARY</button>
<button onclick="window.location.href='<?php echo esc_url( home_url( '/wp-content/plugins/dds-tools/modules/export_cars.php?dropzone' ) ); ?>'">COMPRESS DDS DROPZONE</button>
<br><br>
<button onclick="window.location.href='<?php echo esc_url( home_url( '/wp-content/plugins/dds-tools/modules/export_cars.php?notused' ) ); ?>'">DELETE ALL IMAGES THAT HAVE UNIQID BUT THEY ARE NOT USED</button>




<hr>
