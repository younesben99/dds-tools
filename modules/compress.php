<?php
// Voeg een menu-item toe aan het WordPress-dashboard
add_action('admin_menu', 'dds_compress_menu');

function dds_compress_menu() {
    add_menu_page(
        'DDS Compressie Instellingen', // Pagina titel
        'DDS Compressie',               // Menu titel
        'manage_options',               // Toegangsniveau
        'dds-compress-settings',        // Menu slug
        'dds_compress_settings_page'    // Functie die de instellingenpagina weergeeft
    );
}

// Instellingenpagina functie
function dds_compress_settings_page() {
    // Controleer of de gebruiker de juiste bevoegdheden heeft
    if (!current_user_can('manage_options')) {
        return;
    }

    // Bereken de huidige grootte van de uploads-map
    $uploads_dir = wp_upload_dir();
    $uploads_size_before = get_directory_size($uploads_dir['basedir']);
    
    // Voeg een formulier toe voor compressie
    if (isset($_POST['compress_images'])) {
        compress_dds_dropzone();
    }

    // Herbereken de grootte na compressie
    $uploads_size_after = get_directory_size($uploads_dir['basedir']);

    ?>
    <div class="wrap">
        <h1>DDS Compressie Instellingen</h1>
        <p>Huidige grootte van de uploads-map: <?php echo round($uploads_size_before, 2); ?> GB (voor compressie)</p>
        <p>Huidige grootte van de uploads-map: <?php echo round($uploads_size_after, 2); ?> GB (na compressie)</p>
        <form method="post">
            <input type="submit" name="compress_images" class="button button-primary" value="Afbeeldingen comprimeren">
        </form>
    </div>
    <?php
}

// Functie om de grootte van een map te berekenen
function get_directory_size($dir) {
    $size = 0;
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir)) as $file) {
        $size += $file->getSize();
    }
    return $size / (1024 * 1024 * 1024); // Omrekenen naar GB
}

// Compressiefunctie (zoals eerder gedefinieerd)
function compress_dds_dropzone() {
    // Verkrijg het uploads pad
    $uploads_dir = wp_upload_dir();
    $current_year = date('Y');
    $yearly_uploads_path = $uploads_dir['basedir'] . '/' . $current_year . '/';
    $counter = 0;
    compress_images_recursive($yearly_uploads_path, 60, $counter);
    
    echo 'Aantal gecomprimeerde afbeeldingen: ' . $counter;
}

// De bestaande compress_images_recursive functie hier kopiëren
function compress_images_recursive($dir, $quality, &$counter) {
    if (!is_dir($dir)) {
        return;
    }

    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }

        $file_path = $dir . $file;

        if (is_dir($file_path)) {
            compress_images_recursive($file_path, $quality, $counter);
        } elseif (is_file($file_path) && preg_match('/\.(jpe?g|png|gif)$/i', $file)) {
            $image_info = getimagesize($file_path);
            if ($image_info) {
                $mime_type = $image_info['mime'];
                
                if ($mime_type === 'image/jpeg' || $mime_type === 'image/jpg') {
                    $image = imagecreatefromjpeg($file_path);
                    imagejpeg($image, $file_path, $quality);
                    imagedestroy($image);
                } elseif ($mime_type === 'image/png') {
                    $image = imagecreatefrompng($file_path);
                    imagealphablending($image, false);
                    imagesavealpha($image, true);
                    imagepng($image, $file_path, floor($quality / 10));
                    imagedestroy($image);
                } elseif ($mime_type === 'image/gif') {
                    $image = imagecreatefromgif($file_path);
                    imagegif($image, $file_path);
                    imagedestroy($image);
                }

                $counter++;
            }
        }
    }
}
