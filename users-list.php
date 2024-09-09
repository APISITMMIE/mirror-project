<?php include 'layouts/session.php'; ?>
<?php include 'layouts/head-main.php'; ?>

<?php

// Check if the user is logged in and if they are a super admin
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || !isset($_SESSION["superadmin"]) || $_SESSION["superadmin"] !== 1){
    // Redirect the user to another page or display an error message
    header("location: index.php"); // Redirect to dashboard.php or any other appropriate page
    exit;
}


?>
<head>
    <title>จัดการผู้ใช้งาน | Smart Mirror - C11 Team</title>
    <?php include 'layouts/head.php'; ?>
    <!-- DataTables -->
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <?php include 'layouts/head-style.php'; ?>
</head>

<?php include 'layouts/body.php'; ?>

<!-- Begin page -->
<div id="layout-wrapper">

    <?php include 'layouts/menu.php'; ?>

    <!-- Start right Content here -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- Start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">จัดการผู้ใช้งาน</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">หน้าหลัก</a></li>
                                    <li class="breadcrumb-item active">จัดการผู้ใช้งาน</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End page title -->

                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h5 class="card-title">รายการผู้ใช้งาน <span class="text-muted fw-normal ms-2">(จำนวน)</span></h5>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                        <div>
    <a href="#" class="btn btn-light" id="btnAddUser"><i class="bx bx-plus me-1"></i> เพิ่มผู้ใช้งานใหม่</a>
</div>

                        </div>
                    </div>
                </div>
                <!-- End row -->

                <div class="table-responsive mb-4">
                    <table class="table align-middle datatable dt-responsive table-check nowrap" style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                        <thead>
                            <tr>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Token</th>
                                <th>Created At</th>
                                <th style="width: 120px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dynamic user list will be loaded here via DataTables script -->
                        </tbody>
                    </table>
                    <!-- End table -->
                </div>
                <!-- End table responsive -->

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <?php include 'layouts/footer.php'; ?>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<!-- User Modal -->
<div id="userModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="userForm">
                <div class="modal-header">
                    <h4 class="modal-title">Edit User</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="userId" name="id">
                    <!-- Display the current email and username -->
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" id="userEmail" name="useremail" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Username:</label>
                        <input type="text" id="userName" name="username" class="form-control" readonly>
                    </div>
                    <!-- Allow changing the password -->
                    <div class="form-group">
                        <label>New Password:</label>
                        <input type="password" id="userPassword" name="password" class="form-control">
                    </div>
                    <!-- Confirm the new password -->
                    <div class="form-group">
                        <label>Confirm Password:</label>
                        <input type="password" id="confirmPassword" name="confirm_password" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="addUserForm">
                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputEmail">Email address</label>
                        <input type="email" class="form-control" id="inputEmail" aria-describedby="emailHelp" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="inputUsername">Username</label>
                        <input type="text" class="form-control" id="inputUsername" placeholder="Enter username">
                    </div>
                    <div class="form-group">
                        <label for="inputPassword">Password</label>
                        <input type="password" class="form-control" id="inputPassword" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="inputConfirmPassword">Confirm Password</label>
                        <input type="password" class="form-control" id="inputConfirmPassword" placeholder="Confirm Password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Right Sidebar -->
<?php include 'layouts/right-sidebar.php'; ?>
<!-- /Right-bar -->

<!-- JAVASCRIPT -->
<?php include 'layouts/vendor-scripts.php'; ?>


<script>
    $(document).ready(function() {
        // Check if the DataTable instance exists and destroy it if it does.
        if ($.fn.DataTable.isDataTable('.datatable')) {
            $('.datatable').DataTable().clear().destroy();
        }
        var userTable = $('.datatable').DataTable({
    "processing": true,
    "serverSide": false,
    "ajax": {
        "url": "api.php?action=fetch",
        "dataSrc": "" // This is important to handle the response properly
    },
    "destroy": true,
    "columns": [
        { "data": "useremail" },
        { "data": "username" },
        { "data": "token" },
        { "data": "created_at" },
        {
            "data": null,
            "render": function (data, type, row) {
                return `<button onclick="editUser('${row.id}')" class="btn btn-primary btn-sm">Edit</button>
                        <button onclick="deleteUser('${row.id}')" class="btn btn-danger btn-sm">Delete</button>`;
            },
            "orderable": false
        }
    ]
});


  // Add event listener for the "Add User" button
  $('#btnAddUser').click(function(event) {
        event.preventDefault(); // Prevent the default behavior of the link
        $('#addUserModal').modal('show'); // Show the modal for adding a new user
    });

    // Handle form submission for adding a new user
    $('#addUserForm').submit(function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Retrieve the form data
        var email = $('#inputEmail').val();
        var username = $('#inputUsername').val();
        var password = $('#inputPassword').val();
        var confirmPassword = $('#inputConfirmPassword').val();

        // Validate password and confirm password
        if (password !== confirmPassword) {
            Swal.fire('Error!', 'Password and Confirm Password do not match', 'error');
            return;
        }

        // Example AJAX request to send the form data to the server
        $.ajax({
            type: 'POST',
            url: 'api.php?action=insert', // Assuming your API endpoint for adding users is 'api.php' with action 'insert'
            data: {
                useremail: email,
                username: username,
                password: password
            },
            success: function(response) {
                // Handle the response from the server
                if (response.hasOwnProperty('success')) {
                    Swal.fire('Success!', response.success, 'success');
                    $('#addUserModal').modal('hide'); // Hide the modal after successful submission
                    // Optionally, you can reload or update the user list after adding a new user
                    // fetchAndRefreshUserList();
                    userTable.ajax.reload();
                } else if (response.hasOwnProperty('error')) {
                    Swal.fire('Error!', response.error, 'error');
                } else {
                    Swal.fire('Error!', 'Unknown error occurred', 'error');
                }
            },
            error: function(xhr, status, error) {
                // Handle AJAX errors
                Swal.fire('Error!', 'Failed to add user. Please try again later.', 'error');
                console.error('Error adding user:', error);
            }
        });
    });

// Add/Edit user form submission
$('#userForm').on('submit', function(e) {
    e.preventDefault();

    // Validate new password and confirm password
    var newPassword = $('#userPassword').val();
    var confirmPassword = $('#confirmPassword').val();
    if (newPassword !== confirmPassword) {
        Swal.fire('Error!', 'Passwords do not match', 'error');
        return;
    }

    var formData = $(this).serialize();
    var actionUrl = $('#userId').val() ? 'api.php?action=update' : 'api.php?action=insert';

    $.ajax({
        type: "POST",
        url: actionUrl,
        data: formData,
        success: function(response) {
            $('#userModal').modal('hide');
            userTable.ajax.reload(null, false); // Reload table data without resetting the paging
            Swal.fire('Success!', 'User data saved successfully', 'success');
            // Clear form fields
            $('#userForm')[0].reset();
        },
        error: function(xhr, status, error) {
            // Show error message if AJAX request fails
            Swal.fire('Error!', 'Failed to save user data', 'error');
        }
    });
});


    });


    function editUser(id) {
    // Fetch user data and populate the form for editing
    $.ajax({
        url: `api.php?action=getUser&id=${id}`,
        type: 'GET',
        success: function(response) {
            // Assuming response is the user data. Adjust according to your API response structure
            $('#userId').val(response.id);
            $('#userEmail').val(response.useremail);
            $('#userName').val(response.username);
            $('#userModal').modal('show');
        }
    });
}

function deleteUser(id) {
    // Use SweetAlert2 for user deletion confirmation
    Swal.fire({
        title: 'คุณแน่ใจหรือไม่?',
        text: "คุณจะไม่สามารถย้อนกลับได้!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ใช่, ลบ!'
    }).then((result) => {
        if (result.isConfirmed) {
            // User confirmed deletion, proceed with AJAX request
            $.ajax({
                type: "POST",
                url: "api.php?action=delete",
                data: {
                    id: id
                },
                success: function(response) {
                    if (response.hasOwnProperty('error')) {
                        // Show error message if 'error' key is present in response
                        Swal.fire(
                            'ผิดพลาด!',
                            response.error,
                            'error'
                        );
                    } else {
                        // Show success message if deletion is successful
                        Swal.fire(
                            'ลบแล้ว!',
                            'ผู้ใช้งานถูกลบแล้ว',
                            'success'
                        );
                        // Reload DataTable after deletion
                        userTable.ajax.reload();
                    }
                },
                error: function(xhr, status, error) {
                    // Show error message if AJAX request fails
                    Swal.fire(
                        'ผิดพลาด!',
                        'ลบผู้ใช้งานไม่สำเร็จ',
                        'error'
                    );
                }
            });
        }
    });
}



</script>

<!-- Required datatable js -->
<script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

<!-- Responsive examples -->
<script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

<script src="assets/js/app.js"></script>

</body>

</html>
