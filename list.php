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
        }
        .text-muted {
            color: #6c757d !important; /* Muted text color */
        }
    </style>
</head>
<body>
<button class="btn btn-dark btn-block mb-4" style="font-size: 18px;" onclick="window.scrollTo(0, 0); location.reload();"><i class="fas fa-sync-alt"></i> Refresh Page</button>

<div class=" mt-5">
    <div class="row">
        <div class="col-md-10 offset-md-1"> <!-- Adjusted width to col-md-10 -->
            <div class="proof-of-concept">
                <h2>ComputerEngineer[CPE] (MS Team)</h2>
            </div>
            <?php
            date_default_timezone_set('Asia/Bangkok'); // Set the timezone to Bangkok or your preferred timezone
            // API URL
            $api_url = 'https://news.rmutt-c11.com/news.php?api=news';
            
            // Fetch data from API
            $response = file_get_contents($api_url);
            $news_data = json_decode($response);


// Check if data is available
if (!empty($news_data)) {
    $sorted_news = array(); // Initialize an array to store news articles with their formatted dates
    foreach ($news_data as $news) {
        // Filter out only the news items where the messageType is "message"
        if ($news->messageType === "message") {
            // Create a DateTime object from the ISO 8601 formatted date string
            try {
                $date = new DateTime($news->createdDateTime);
                $date->setTimezone(new DateTimeZone('Asia/Bangkok')); // Convert to Bangkok time
                $formattedDate = $date->format('d/m/Y H:i:s'); // Format the date
            } catch (Exception $e) {
                // Handle exception if the date can't be parsed
                error_log($e->getMessage());
                $formattedDate = 'Invalid date format';
            }

            // Store the news article along with its formatted date
            $sorted_news[] = array(
                'date' => strtotime($news->createdDateTime), // Convert the date to a timestamp for sorting
                'article' => '<div class="chat-message"><h5><strong>' . htmlspecialchars($news->subject) . '</strong> <span class="text-muted">' . $formattedDate . '</span></h5><div>' . $news->bodyContent . '</div><hr style="border-color: #6c757d;"><p>ผู้โพสต์ : <strong>' . htmlspecialchars($news->userName) . '</strong> </p><p>ห้อง : <strong>' . htmlspecialchars($news->displayName) . '</strong> ทีม : <strong >' . htmlspecialchars($news->description) . '</strong></p></div>'
            );
        }
    }

    // Sort the news articles based on their dates in descending order
    usort($sorted_news, function($a, $b) {
        return $b['date'] - $a['date'];
    });

    // Display the sorted news articles
    foreach ($sorted_news as $article) {
        echo $article['article'];
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
    // Function to refresh the page every 10 seconds
    setInterval(function(){
        location.reload();
    }, 10000); // 10000 milliseconds = 10 seconds
</script>
</body>
</html>
