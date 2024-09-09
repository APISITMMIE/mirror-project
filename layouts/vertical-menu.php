<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: auth-login.php");
    exit;
}

// Check if the user is a super admin
$isSuperAdmin = isset($_SESSION["superadmin"]) && $_SESSION["superadmin"] === 1;
?>

<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index.php" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="assets/images/rmutt pic.png" alt="" height="40">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/rmutt pic.png" alt="" height="40"> <span class="logo-txt">Smart Mirror</span>
                    </span>
                </a>

                <a href="index.php" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="assets/images/rmutt pic.png" alt="" height="40">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/rmutt pic.png" alt="" height="24"> <span class="logo-txt">Smart Mirror</span>
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

        </div>

        <div class="d-flex">




            <div class="dropdown d-none d-sm-inline-block">
                <button type="button" class="btn header-item" id="mode-setting-btn">
                    <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                    <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                </button>
            </div>


            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item bg-light-subtle border-start border-end" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-1.jpg"
                        alt="Header Avatar">
               
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">

                    <a class="dropdown-item" href="logout.php"><i class="mdi mdi-logout font-size-16 align-middle me-1"></i> <?php echo $language["Logout"]; ?></a>
                </div>
            </div>

        </div>
    </div>
</header>

<!-- ========== Left Sidebar Start ========== -->
<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">เมนู</li>

                <li>
                    <a href="index.php">
                        <i data-feather="home"></i>
                        <span>หน้าหลัก</span>
                    </a>
                </li>

                <li>
                    <a href="posts.php">
                        <i data-feather="edit"></i>
                        <span>โพสต์ข้อความ</span>
                    </a>
                </li>
                <?php if ($isSuperAdmin): ?>
                <li>
                    <a href="users-list.php">
                        <i data-feather="users"></i>
                        <span>จัดการผู้ใช้งาน</span>
                    </a>
                </li>
                <?php endif; ?>
                <li>
                    <a href="edit-teacher-address.php">
                        <i data-feather="user"></i>
                        <span>แก้ไขที่อยู่อาจารย์</span>
                    </a>
                </li>

                <li>
                    <a href="edit-schedule.php">
                        <i data-feather="calendar"></i>
                        <span>แก้ไขตารางเรียน</span>
                    </a>
                </li>

                <li>
                    <a href="room.php">
                        <i data-feather="folder"></i>
                        <span>ห้อง</span>
                    </a>
                </li>

                <li>
                    <a href="screen-settings.php">
                        <i data-feather="settings"></i>
                        <span>ตั้งค่าหน้าจอ</span>
                    </a>
                </li>
            </ul>

        </div>
        <!-- Sidebar -->
    </div>
</div>

<!-- Left Sidebar End -->