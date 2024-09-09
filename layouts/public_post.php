<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Carousel</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
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

<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-lg-10 offset-md-1"> <!-- Adjusted width to col-md-10 -->
            <div class="proof-of-concept">
                <h2>ComputerEngineer[CPE] (Admin)</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-10 offset-lg-1"> <!-- Adjusted width to col-md-10 -->
            <div id="carouselAdmin" class="carousel slide swiper-container" > <!-- Set interval to 10 seconds -->
                <div class="swiper-wrapper carousel-inner">

                <?php
                    // API URL
                    $api_url = 'https://admin.rmutt-c11.com/api_posts.php?action=fetch&_='.time(); // Added timestamp to prevent caching
                    
                    // Fetch data from API
                    $response = file_get_contents($api_url);
                    $news_data = json_decode($response);
                    
                    // Check if data is available
                    if (!empty($news_data)) {
                        foreach ($news_data as $index => $news) {
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
                    
                            // Display the news article
                            echo '<div class="carousel-item' . ($index == 0 ? ' active' : '') . '">';
                            echo '<div class="chat-message">';
                            echo '<h5><strong>' . htmlspecialchars($news->header) . '</strong> <span class="text-muted">' . $formattedDate . '</span></h5>';
                            echo '<div>' . str_replace('<img ', '<img class="img-fluid" ', $news->content) . '</div>';
                            echo '<hr style="border-color: #6c757d;">';
                            echo '<p>ผู้โพสต์ : <strong>' . htmlspecialchars($news->create_by) . '</strong></p>';
                            echo '</div></div>';
                        }
                    } else {
                        echo '<p>No news found.</p>';
                    }
                    ?>

                </div>
                <a class="carousel-control-prev swiper-button-prev" href="#carouselAdmin" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next swiper-button-next" href="#carouselAdmin" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
                <!-- Add pagination -->
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</div>


<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-lg-10 offset-lg-1"> <!-- Adjusted width to col-md-10 -->
            <div class="proof-of-concept">
                <h2>ComputerEngineer[CPE] (MS Team)</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-10 offset-lg-1"> <!-- Adjusted width to col-md-10 -->
            <div id="carouselMsTeam" class="carousel slide swiper-container" > <!-- Set interval to 10 seconds -->
                <div class="swiper-wrapper carousel-inner">


                <?php
date_default_timezone_set('Asia/Bangkok'); // Set the timezone to Bangkok or your preferred timezone

// Function to format a news article
// Function to format a news article for the carousel
function formatNewsArticle($news, $index) {
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

    // Format the news article for the carousel
    $formattedArticle = '<div class="carousel-item' . ($index == 0 ? ' active' : '') . '">';
    $formattedArticle .= '<div class="chat-message">';
    $formattedArticle .= '<h5><strong>' . htmlspecialchars($news->subject) . '</strong> <span class="text-muted">' . $formattedDate . '</span></h5>';
    $formattedArticle .= '<div>' . $news->bodyContent . '</div>';
    $formattedArticle .= '<hr style="border-color: #6c757d;">';
    $formattedArticle .= '<p>ผู้โพสต์ : <strong>' . htmlspecialchars($news->userName) . '</strong> </p>';
    $formattedArticle .= '</div></div>';

    return $formattedArticle;
}


// API URL
$api_url = 'https://news.rmutt-c11.com/news.php?api=news';

// Fetch data from API
$response = file_get_contents($api_url);
$news_data = json_decode($response);

// Check if data is available
if (!empty($news_data)) {
    $sorted_news = array(); // Initialize an array to store news articles with their formatted dates
    $cnt = 0;
    foreach ($news_data as $news) {

        // Filter out only the news items where the messageType is "message"
        if ($news->messageType === "message") {
            // Store the news article along with its formatted date
            $sorted_news[] = array(
                'date' => strtotime($news->createdDateTime), // Convert the date to a timestamp for sorting
                'article' => formatNewsArticle($news,$cnt)
            );
            $cnt++;
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
                <a class="carousel-control-prev swiper-button-prev" href="#carouselMsTeam" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next swiper-button-next" href="#carouselMsTeam" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
                <!-- Add pagination -->
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</div>


<!-- Include Bootstrap JS and its dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.5/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Include Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    // Function to programmatically trigger click on next button
    function clickNextButton(carouselId) {
        var nextButton = document.querySelector(carouselId + ' .swiper-button-next');
        if (nextButton) {
            nextButton.click();
        }
    }

    // Initialize Swiper instances and trigger click on "Next" button once when the page loads
    document.addEventListener('DOMContentLoaded', function () {
        var adminSwiper = new Swiper('#carouselAdmin.swiper-container', {
            direction: 'horizontal',
            loop: true,
            autoplay: {
                delay: 1000, // Adjust delay time in milliseconds (1 second in this example)
                disableOnInteraction: false, // Allow user interaction to not disable autoplay
            },
            slidesPerView: 1,
            slidesPerGroup: 1,
            centeredSlides: true,
            grabCursor: true,
            pagination: {
                el: '.swiper-pagination',
            },
        });

        var msTeamSwiper = new Swiper('#carouselMsTeam.swiper-container', {
            direction: 'horizontal',
            loop: true,
            autoplay: {
                delay: 1000, // Adjust delay time in milliseconds (1 second in this example)
                disableOnInteraction: false, // Allow user interaction to not disable autoplay
            },
            slidesPerView: 1,
            slidesPerGroup: 1,
            centeredSlides: true,
            grabCursor: true,
            pagination: {
                el: '.swiper-pagination',
            },
        });

// Function to click "Next" button of both carousels every 5 seconds
function clickNextButtons() {
        clickNextButton('#carouselAdmin');
        clickNextButton('#carouselMsTeam');
    }

    // Trigger click on "Next" button every 5 seconds
    setInterval(clickNextButtons, 5000); // 5000 milliseconds = 5 seconds
    });


    setTimeout(function() {
            location.reload();
        }, 300000); // 300,000 milliseconds = 5 minutes
</script>

</body>
</html>
