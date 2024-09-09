<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centered and Responsive Image</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .image-container {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden; /* Ensure image is clipped to container */
        }
        img {
            max-width: 100%;
            height: auto;
            display: block;
            transition: transform 0.3s; /* Add transition for smoother zooming */
        }

    </style>
</head>
<body>
    <div class="image-container">
        <?php
        // Check if image path parameter is passed
        if(isset($_GET['image'])) {
            // Image path
            $imagePath = $_GET['image'];

            // Check if the file exists
            if (file_exists($imagePath)) {
                echo '<img id="uploadedImage" src="' . $imagePath . '" alt="Uploaded Image">';
            } else {
                echo '<h1 style="color:white;">Image not found.</h1>';
            }
        } else {
            echo '<h1 style="color:white;>No image specified.</h1>';
        }
        ?>
    </div>

    <!-- Include panzoom.js library -->
    <script src='https://unpkg.com/panzoom@9.4.0/dist/panzoom.min.js'></script>

    <script>
        let currentScale = 1;
        let panzoomInstance;

        window.onload = function() {
            const image = document.getElementById('uploadedImage');
            panzoomInstance = panzoom(image, {
                minScale: 1,
                maxScale: 5, // You can adjust the maximum scale as needed
                contain: 'invert',
                cursor: 'move',
            });
        }

    </script>
</body>
</html>
