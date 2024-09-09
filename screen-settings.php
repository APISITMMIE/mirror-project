<?php include 'layouts/session.php'; ?>
<?php include 'layouts/head-main.php'; ?>

<?php
include 'layouts/config.php'; // Make sure this path is correct

// Initialize variables
$screenMirrorModeText = "โหมดปกติ"; // Default value
$screenOnOffText = "ปิดจอ"; // Default value
$screenOnOffIconColor = "red"; // Default color

// Query database for settings
$query = "SELECT `name`, `value_bool` FROM `config_app` WHERE `name`='SCREEN_MIRRORMODE' OR `name`='SCREEN_ONOFF'";
$result = mysqli_query($link, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['name'] == 'SCREEN_MIRRORMODE') {
            $screenMirrorModeText = $row['value_bool'] ? "โหมดกระจก" : "โหมดปกติ";
        } elseif ($row['name'] == 'SCREEN_ONOFF') {
            if ($row['value_bool'] == 1) {
                $screenOnOffText = "เปิดจอ";
                $screenOnOffIconColor = "green"; // Change icon color to green
            } else {
                $screenOnOffText = "ปิดจอ";
                $screenOnOffIconColor = "red"; // Keep or set icon color to red
            }
        }
    }
}
?>

<head>
    <title>ตั้งค่าหน้าจอ | Smart Mirror - C11 Team</title>

    <?php include 'layouts/head.php'; ?>

    <link href="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    
    <!-- FontAwesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    
    <?php include 'layouts/head-style.php'; ?>

    <style>
        .centered-content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 50vh;
            text-align: center;
        }

        .icon-container {
            margin: 0 20px; /* Increase gap between icons */
        }

        .icon-clickable {
            cursor: pointer;
            font-size: 4rem; /* Adjust icon size here */
            margin-bottom: 10px; /* Gap between icon and text */
        }

        .icon-text {
            font-size: 1.2rem; /* Adjust text size here */
        }
    </style>
</head>

<?php include 'layouts/body.php'; ?>

<!-- Begin page -->
<div id="layout-wrapper">

    <?php include 'layouts/menu.php'; ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <div class="centered-content">
                <div class="icon-container">
    <i class="fas fa-tv icon-clickable" id="toggleScreenIcon" onclick="toggleScreen()" style="color: <?php echo $screenOnOffIconColor; ?>;"></i>
        <div class="icon-text" id="screenOnOffText"><?php echo $screenOnOffText; ?></div>
</div>
<div class="icon-container">
    <i class="fas fa-magic icon-clickable" id="toggleFeatureIcon" onclick="toggleFeature()"></i>
    <div class="icon-text" id="mirrorModeText"><?php echo $screenMirrorModeText; ?></div>
</div>
                </div>
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <?php include 'layouts/footer.php'; ?>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<!-- Right Sidebar -->
<?php include 'layouts/right-sidebar.php'; ?>
<!-- /Right-bar -->

<!-- JAVASCRIPT -->
<?php include 'layouts/vendor-scripts.php'; ?>

<!-- apexcharts -->
<script src="assets/libs/apexcharts/apexcharts.min.js"></script>

<!-- Plugins js-->
<script src="assets/libs/admin-resources/jquery.vectormap/jquery-jectormap-1.2.2.min.js"></script>
<script src="assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js"></script>

<!-- dashboard init -->
<script src="assets/js/pages/dashboard.init.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>

<script>
function toggleScreen() {
    fetch('update_settings.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=toggleScreen'
    })
    .then(response => response.json())
    .then(data => {
        var icon = document.getElementById("toggleScreenIcon");
        var text = document.querySelector("#toggleScreenIcon + .icon-text");
        if(data.screenOn) {
            icon.className = "fas fa-tv icon-clickable";
            icon.style.color = "green";
            text.textContent = "เปิดจอ";
            Swal.fire({
              title: 'Success!',
              text: 'Screen turned on.',
              icon: 'success',
              confirmButtonText: 'Cool'
            });
        } else {
            icon.className = "fas fa-power-off icon-clickable";
            icon.style.color = "red";
            text.textContent = "ปิดจอ";
            Swal.fire({
              title: 'Success!',
              text: 'Screen turned off.',
              icon: 'success',
              confirmButtonText: 'Cool'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
          title: 'Error!',
          text: 'Something went wrong.',
          icon: 'error',
          confirmButtonText: 'OK'
        });
    });
}

function toggleFeature() {
    fetch('update_settings.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=toggleFeature'
    })
    .then(response => response.json())
    .then(data => {
        var icon = document.getElementById("toggleFeatureIcon");
        var text = document.querySelector("#toggleFeatureIcon + .icon-text");
        if(data.featureOn) {
            icon.className = "fas fa-magic icon-clickable";
            text.textContent = "โหมดกระจก";
            Swal.fire({
              title: 'Success!',
              text: 'Feature mode enabled.',
              icon: 'success',
              confirmButtonText: 'Cool'
            });
        } else {
            icon.className = "fas fa-magic icon-clickable";
            text.textContent = "โหมดปกติ";
            Swal.fire({
              title: 'Success!',
              text: 'Normal mode enabled.',
              icon: 'success',
              confirmButtonText: 'Cool'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
          title: 'Error!',
          text: 'Something went wrong.',
          icon: 'error',
          confirmButtonText: 'OK'
        });
    });
}

</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Polling function to check for changes every 1 second
    setInterval(function() {
        // Assuming 'update_settings.php' can return the current state of the screen and feature settings
        fetch('get_settings_state.php') // You might need to create this PHP file or modify an existing endpoint
        .then(response => response.json())
        .then(data => {
            // Update screen settings
            var screenIcon = document.getElementById("toggleScreenIcon");
            var screenText = document.getElementById("screenOnOffText");
            if(data.screenOn) { // Assuming 'screenOn' is a boolean returned by your API
                screenIcon.style.color = "green";
                screenText.textContent = "เปิดจอ";
            } else {
                screenIcon.style.color = "red";
                screenText.textContent = "ปิดจอ";
            }

            // Update feature settings
            var featureIcon = document.getElementById("toggleFeatureIcon");
            var featureText = document.getElementById("mirrorModeText");
            featureText.textContent = data.featureOn ? "โหมดกระจก" : "โหมดปกติ"; // Assuming 'featureOn' is a boolean
        })
        .catch(error => console.error('Polling error:', error));
    }, 1000); // 1000 milliseconds interval for 1 second
});
</script>
</body>

</html>
