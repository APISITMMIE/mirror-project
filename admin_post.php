<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Feed</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Add additional styling as needed */
        body {
            background-color: #000000; /* Bootstrap dark background */
            color: #ffffff; /* White text color for dark background */
        }
        .chat-message {
            background-color: #495057; /* Darker background for chat message */
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 10px;
            cursor: pointer; /* Change cursor to pointer when hovering over chat message */
        }
        .text-muted {
            color: #6c757d !important; /* Muted text color */
        }
        .chat-message-wrapper.active {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow-y: auto; /* Enable vertical scrolling if content exceeds screen height */
            padding: 20px; /* Adjust padding as needed */
            background-color: rgba(0, 0, 0, 0.8); /* Semi-transparent background */
            z-index: 9999; /* Ensure it appears above other content */
        }
        .chat-message-content {
            background-color: #495057; /* Darker background for chat message */
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 10px;
        }
        .chat-message-content img {
            max-width: 100%; /* Ensure images don't exceed parent container width */
            height: auto; /* Maintain aspect ratio */
        }
    </style>
</head>
<body>
<button class="btn btn-dark btn-block mb-4" style="font-size: 18px;" onclick="window.scrollTo(0, 0); location.reload();"><i class="fas fa-sync-alt"></i> Refresh Page</button>

<div class=" mt-5">
    <div class="row">
        <div class="col-md-10 offset-md-1"> <!-- Adjusted width to col-md-10 -->
            <div class="proof-of-concept">
                <h2>ComputerEngineer[CPE] (Admin)</h2>
            </div>
            <?php
            // API URL
            $api_url = 'https://admin.rmutt-c11.com/api_posts.php?action=fetch&_='.time(); // Added timestamp to prevent caching
            
            // Fetch data from API
            $response = file_get_contents($api_url);
            $news_data = json_decode($response);

            // Check if data is available
            if (!empty($news_data)) {
                $sorted_news = array(); // Initialize an array to store news articles with their formatted dates
                foreach ($news_data as $news) {
                    // Create a DateTime object from the ISO 8601 formatted date string
                    try {
                        $date = new DateTime($news->create_at);
                        $date->setTimezone(new DateTimeZone('Asia/Bangkok')); // Convert to Bangkok time
                        $formattedDate = $date->format('d/m/Y H:i:s'); // Format the date
                    } catch (Exception $e) {
                        // Handle exception if the date can't be parsed
                        error_log($e->getMessage());
                        $formattedDate = 'Invalid date format';
                    }

                    // Store the news article along with its formatted date
                    $sorted_news[] = array(
                        'date' => strtotime($news->create_at), // Convert the date to a timestamp for sorting
                        'article' => '<div class="chat-message"><h5><strong>' . htmlspecialchars($news->header) . '</strong> <span class="text-muted">' . $formattedDate . '</span></h5><div>' . $news->content . '</div><hr style="border-color: #6c757d;"><p>ผู้โพสต์ : <strong>' . htmlspecialchars($news->create_by) . '</strong></p></div>'
                    );
                }

                // Sort the news articles based on their dates in descending order
                usort($sorted_news, function($a, $b) {
                    return $b['date'] - $a['date'];
                });

// Display the sorted news articles
foreach ($sorted_news as $article) {
    // Add img-fluid class to img tags for responsive images
    $article['article'] = str_replace('<img ', '<img class="img-fluid" ', $article['article']);
    echo '<div class="chat-message-wrapper">' . $article['article'] . '</div>';
}

            } else {
                echo '<p>No news found.</p>';
            }
            ?>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS and its dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.5/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // JavaScript to open chat message in fullscreen when clicked
    document.addEventListener('click', function(event) {
        if (event.target.matches('.chat-message')) {
            event.target.closest('.chat-message-wrapper').classList.add('active');
        }
    });
    
    // JavaScript to close fullscreen chat message when clicked outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.chat-message')) {
            document.querySelectorAll('.chat-message-wrapper.active').forEach(function(wrapper) {
                wrapper.classList.remove('active');
            });
        }
    });
</script>
</body>
</html>
