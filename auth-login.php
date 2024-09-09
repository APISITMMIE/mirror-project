<?php
date_default_timezone_set('Asia/Bangkok');

// Initialize the session
session_start();

// Include config file
require_once "layouts/config.php";

// Check if the user is already logged in, if yes then redirect him to index page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, username, password, superadmin FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $superadmin);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["superadmin"] = $superadmin;

                            // Redirect user to welcome page
                            header("location: index.php");
                            exit;
                        } else {
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $username_err = "ไม่พบชื่อผู้ใช้นี้ในระบบ.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>
<?php include 'layouts/head-main.php'; ?>

<head>

    <title>Login | C11 - Admin SMR</title>
    <?php include 'layouts/head.php'; ?>

    <?php include 'layouts/head-style.php'; ?>

</head>

<?php include 'layouts/body.php'; ?>
<div class="auth-page">
    <div class="container-fluid p-0">
        <div class="row g-0">
             <!-- end col -->
             <div class="col-xxl-9 col-lg-8 col-md-7">
                <div class="auth-bg pt-md-5 p-4 d-flex">
                    <div class="bg-overlay bg-primary"></div>
                    <ul class="bg-bubbles">
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                    <!-- end bubble effect -->
                   
                </div>
            </div>
            <!-- end col -->
            <div class="col-xxl-3 col-lg-4 col-md-5">
                <div class="auth-full-page-content d-flex p-sm-5 p-4">
                    <div class="w-100">
                        <div class="d-flex flex-column h-100">
                            <div class="mb-4 mb-md-5 text-center">
                                <a href="index.php" class="d-block auth-logo">
                                    <img src="assets/images/rmutt pic.png" alt="" height="100"> 
                                </a>
                            </div>
                            
                            <div class="auth-content my-auto">
                                <div class="text-center">
                                            <h5 class="mb-0">Smart Mirror - กระจกอัจฉริยะ</h5>
                                            <p class="text-muted mt-2">ระบบหลังบ้าน โดย C11 Team</p>
                                </div>
                                <form class="mt-4 pt-2" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <div class="mb-3 <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                                        <label class="form-label" for="username">ชื่อผู้ใช้งาน</label>
                                        <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" >
                                        <span class="text-danger"><?php echo $username_err; ?></span>
                                    </div>
                                    <div class="mb-3 <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-grow-1">
                                                <label class="form-label" for="password">รหัสผ่าน</label>
                                            </div>
                                        </div>

                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" class="form-control" placeholder="Enter password" name="password" aria-label="Password" aria-describedby="password-addon">
                                            <button class="btn btn-light ms-0" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                            <span class="text-danger"><?php echo $password_err; ?></span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">เข้าสู่ระบบ</button>
                                    </div>
                                </form>

                            </div>
                            <div class="mt-4 mt-md-5 text-center">
                                <p class="mb-0">© <script>
                                        document.write(new Date().getFullYear())
                                    </script> SmartMirror Crafted with <i class="mdi mdi-heart text-danger"></i> by C11 RMUTT</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end auth full page content -->
            </div>
           
        </div>
        <!-- end row -->
    </div>
    <!-- end container fluid -->
</div>


<!-- JAVASCRIPT -->

<?php include 'layouts/vendor-scripts.php'; ?>
<!-- password addon init -->
<script src="assets/js/pages/pass-addon.init.js"></script>

</body>

</html>
