<?php
include(__DIR__."/../../../../../wp-load.php");

// Get the parameters from the URL
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Construct the directory path
$dir_path = "/wp-content/uploads/dds_dropzone/" . $query . "/";

// Full URL for display
$site_url = get_site_url();
$full_url = $site_url . $dir_path;

// Server path to directory
$server_path = $_SERVER['DOCUMENT_ROOT'] . $dir_path;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Slideshow</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide@3.4.1/dist/css/glide.core.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide@3.4.1/dist/css/glide.theme.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            margin: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        .glide {
            flex: 1;
            display: flex;
            flex-direction: column;
            max-width: 800px;
            margin: 0 auto;
        }
        .glide__slide img {
            width: 100%;
            height: auto;
            max-height: 466px;
            object-fit: cover;
            cursor: pointer;
        }
        ul.glide__slides {
            margin: 0;
        }
        .glide.glide--ltr.glide--slider.glide--swipeable {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .glide__arrow--left {
            left: 10px;
        }
        .glide__arrow--right {
            right: 10px;
        }
        .glide__bullets {
            display: block;
            padding: 0;
            overflow-x: auto;
            width: 100%;
            text-align: center;
        }
        .glide__bullet {
            flex: 0 0 auto;
            width: 75px;
            height: 75px;
            margin: 5px;
            background-size: cover;
            background-position: center;
            border-radius: 5px;
            cursor: pointer;
            border: 0px solid transparent;
        }
        .glide__bullet--active {
            border-color: #000;
        }
        .glide__arrow {
            background: none;
            border: none;
            font-size: 16px;
            color: #fff;
            cursor: pointer;
            position: absolute;
            top: 25%;
            transform: translateY(-50%);
            background: #ffffff17;
        }
        .fullscreen-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .fullscreen-modal img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .close-button {
            position: fixed;
    bottom: 54px;
    width: 61%;
    border: 2px solid #f37a7a;
    color: #f37a7a;
    text-align: center;
    padding: 13px;
    cursor: pointer;
    z-index: 10000;
    font-family: sans-serif;
    font-size: 21px;
    max-width: 300px;

        }
        @media (max-width: 500px) {
            .glide {
                max-width: 500px;
            }
            .glide__arrow {
                top: 50%;
            }
        }
        @media (min-width: 600px) {
            .glide__slide img {
    
    max-height: 748px;
   
}
        }
    </style>
</head>
<body>

<div style="text-align: center;
    margin: 0;
    background: #000000;
    padding: 10px 0;"><img style="width:100px;height:fit-content;" src="https://digiflow.be/wp-content/uploads//2020/09/Digiflowsvgwhite2-1-1.svg" alt=""></div>
<div class="glide">
    <div class="glide__track" data-glide-el="track">
        <ul class="glide__slides">
            <?php
            $images = [];
            // Check if directory exists
            if (is_dir($server_path)) {
                // Open directory
                if ($dh = opendir($server_path)) {
                    // Loop through directory contents
                    while (($file = readdir($dh)) !== false) {
                        // Check if file is an image
                        if (preg_match("/\.(jpg|jpeg|png|gif)$/i", $file)) {
                            echo "<li class='glide__slide'><img src='" . $full_url . $file . "' alt='" . $file . "' onclick='openFullscreenModal(\"" . $full_url . $file . "\")'></li>";
                            $images[] = $full_url . $file;
                        }
                    }
                    // Close directory
                    closedir($dh);
                } else {
                    echo "Slideshow could not be opened. Please contact info@digiflow.be for more information. Request: " . $_GET['query'];
                }
            } else {
                echo "These images no longer exist.";
            }
            ?>
        </ul>
    </div>

    <div class="glide__bullets" data-glide-el="controls[nav]">
        <?php
        foreach ($images as $index => $image) {
            echo "<button class='glide__bullet' data-glide-dir='=$index' style='background-image: url(\"$image\");'></button>";
        }
        ?>
    </div>
</div>

<div class="fullscreen-modal" id="fullscreenModal" onclick="closeFullscreenModal()">
    <img id="fullscreenImage" src="" alt="Fullscreen Image" onclick="event.stopPropagation()">
    <div class="close-button" onclick="closeFullscreenModal()">Sluiten</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@glidejs/glide@3.4.1/dist/glide.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Glide('.glide', {
            type: 'carousel',
            autoplay: false,
            hoverpause: true,
            animationDuration: 800,
            perView: 1,
            gap: 0
        }).mount();

        // Override the event listeners to be non-passive
        document.querySelectorAll('.glide__bullet').forEach(bullet => {
            bullet.addEventListener('click', function(event) {
                event.preventDefault(); // Ensure preventDefault is not being called on passive listeners
            }, { passive: false });
        });
    });

    function openFullscreenModal(imageUrl) {
        const modal = document.getElementById('fullscreenModal');
        const modalImage = document.getElementById('fullscreenImage');
        modalImage.src = imageUrl;
        modal.style.display = 'flex';
    }

    function closeFullscreenModal() {
        const modal = document.getElementById('fullscreenModal');
        modal.style.display = 'none';
    }
</script>

</body>
</html>
