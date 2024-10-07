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
    
    // Controleer of het formulier is ingediend voor compressie
    if (isset($_POST['compress_images'])) {
        compress_uploads();
        // Redirect om te voorkomen dat het formulier opnieuw wordt verzonden bij herladen
        wp_redirect(admin_url('admin.php?page=dds-compress-settings'));
        exit;
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

// Voeg een actie toe die de cron job registreert
add_action('wp', 'dds_compress_cron_activation');
function dds_compress_cron_activation() {
    if (!wp_next_scheduled('dds_monthly_compression_hook')) {
        wp_schedule_event(time(), 'monthly', 'dds_monthly_compression_hook');
    }
}

// Voeg de compressie-functie toe aan de cron job
add_action('dds_monthly_compression_hook', 'compress_uploads_monthly');

// Schakel de cron job uit bij deactivering van de plugin of thema
register_deactivation_hook(__FILE__, 'dds_compress_cron_deactivation');
function dds_compress_cron_deactivation() {
    $timestamp = wp_next_scheduled('dds_monthly_compression_hook');
    wp_unschedule_event($timestamp, 'dds_monthly_compression_hook');
}

// Functie om de grootte van een map te berekenen
if (!function_exists('get_directory_size')) {
    function get_directory_size($dir) {
        $size = 0;
        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir)) as $file) {
            if ($file->isFile()) {
                $size += $file->getSize();
            }
        }
        return $size / (1024 * 1024 * 1024); // Omrekenen naar GB
    }
}

// Compressiefunctie voor maandelijkse cron job
if (!function_exists('compress_uploads_monthly')) {
    function compress_uploads_monthly() {
        $uploads_dir = wp_upload_dir();
        $current_year = date('Y');
        $yearly_uploads_path = $uploads_dir['basedir'] . '/' . $current_year . '/';
        $counter = 0;

        compress_images_recursive_larger($yearly_uploads_path, 60, $counter);

        // Optioneel: logging van de resultaten (alleen voor debugging)
        error_log("DDS Compressie Cron: Aantal gecomprimeerde afbeeldingen: " . $counter);
    }
}

// Handmatige compressiefunctie
if (!function_exists('compress_uploads')) {
    function compress_uploads($batch_size = 500) {
        $uploads_dir = wp_upload_dir();
        $current_year = date('Y');
        $yearly_uploads_path = $uploads_dir['basedir'] . '/' . $current_year . '/';
        $counter = 0;

        compress_images_recursive_larger($yearly_uploads_path, 60, $counter, $batch_size);
    }
}

// Aanpassen van de compress_images_recursive functie om alleen grote bestanden te comprimeren
if (!function_exists('compress_images_recursive_larger')) {
    function compress_images_recursive_larger($dir, $quality, &$counter, $batch_size = null) {
        if (!is_dir($dir)) {
            return;
        }

        $files = scandir($dir);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $file_path = $dir . '/' . $file;

            if (is_dir($file_path)) {
                compress_images_recursive_larger($file_path, $quality, $counter, $batch_size);
            } elseif (is_file($file_path) && preg_match('/\.(jpe?g|png|gif)$/i', $file)) {
                // Controleer of bestand groter is dan 1,5 MB (1.5 * 1024 * 1024 bytes)
                if (filesize($file_path) > 1.5 * 1024 * 1024) {
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

                        // Stop de verwerking als de batchgrootte is bereikt
                        if ($batch_size && $counter >= $batch_size) {
                            return;
                        }
                    }
                }
            }
        }
    }
}
?>