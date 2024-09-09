<?php include 'layouts/session.php'; ?>
<?php include 'layouts/head-main.php'; ?>

<head>
    <title>แก้ไขตารางเรียน | Smart Mirror - C11 Team</title>
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
                            <h4 class="mb-sm-0 font-size-18">แก้ไขตารางเรียน</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">หน้าหลัก</a></li>
                                    <li class="breadcrumb-item active">แก้ไขตารางเรียน</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End page title -->

                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h5 class="card-title">รายการตารางเรียน <span class="text-muted fw-normal ms-2">(จำนวน)</span></h5>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">

                          
                        </div>
                    </div>
                </div>
                <!-- End row -->

                <div class="table-responsive mb-4">
                    <table class="table align-middle datatable dt-responsive table-check nowrap" style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 50px;">
                                    <div class="form-check font-size-16">
                                        <input type="checkbox" class="form-check-input" id="checkAll">
                                        <label class="form-check-label" for="checkAll"></label>
                                    </div>
                                </th>
                                <th scope="col">เลขห้อง</th>
                                <th scope="col">ชั้น</th>
                                <th scope="col">url รูป</th>
                                <th style="width: 80px; min-width: 80px;">การกระทำ</th>
                            </tr>
                        </thead>
                        <tbody id="timetableBody">
                            <!-- Dynamic posts list will be loaded here -->
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

<!-- Add/update button and modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Path Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="pathImage" class="form-label">New Path Image</label>
                        <input type="file" class="form-control" id="imageUpload" name="image" required>
                        <!-- Display the current path image if needed -->
                        <!-- <img src="" id="currentPathImage" alt="Current Path Image" style="max-width: 100%; margin-top: 10px;"> -->
                    </div>
                    <input type="hidden" id="roomId" name="room_id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updateBtn">Update</button>
            </div>
        </div>
    </div>
</div>


<!-- Right Sidebar -->
<?php include 'layouts/right-sidebar.php'; ?>
<!-- /Right-bar -->

<!-- JAVASCRIPT -->
<?php include 'layouts/vendor-scripts.php'; ?>

<!-- Required datatable js -->
<script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

<!-- Responsive examples -->
<script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>



<script>
$(document).ready(function() {
        fetchTimetableData();

        function fetchTimetableData() {
    $.ajax({
        url: 'api_timetable.php?action=fetch',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            $('#timetableBody').empty(); // Clear existing rows
            response.forEach(function(item) {
                $('#timetableBody').append(`
                    <tr>
                        <td><input type="checkbox" class="form-check-input"></td>
                        <td>${item.room_name}</td>
                        <td>${item.floor_name}</td>
                        <td><a href="${item.path_image}" target="_blank">${item.path_image}</a></td>
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="openUpdateModal(${item.id}, '${item.path_image}')">Update</button>
                            <button class="btn btn-secondary btn-sm" onclick="clearImagePath(${item.id})">Clear Image</button>
                        </td>
                    </tr>
                `);
            });
        },
        error: function(xhr, status, error) {
            console.error(error);
            // Handle error
        }
    });
}


// Function to handle file upload
function uploadImage(formData) {
    return new Promise((resolve, reject) => {
        
        fetch('/upload_image.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(result => {
            if (result && result.uploaded) {
                resolve(result.url); // Resolve with the URL from the server response
            } else {
                reject(result.error ? result.error.message : 'Upload failed');
            }
        })
        .catch(error => {
            reject('Upload failed: ' + error.message);
        });
    });
}

// Function to update path image
function updatePathImage(id, imagePath) {
    let formData = new FormData($('#updateForm')[0]);
    formData.append('id', id); // Change 'room_id' to 'id'
    

    uploadImage(formData)
    .then(response => {

        let imageUrl = response;
        formData.append('path_image', response); // Include the path image URL in the form data
        // Check if imageUrl is null or empty
        if (!imageUrl) {
            console.error('Error: Image URL is null or empty');
            // Show error message using SweetAlert
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Image URL is null or empty. Please upload a valid image.',
            });
            return; // Stop execution
        }

        // Call your API to update the path image with imageUrl
        $.ajax({
            url: 'api_timetable.php?action=update', // Specify the action as 'update'
            type: 'POST',
            data: formData,
            processData: false, // Set processData to false to prevent jQuery from automatically transforming the data into a query string
            contentType: false, // Set contentType to false to prevent jQuery from setting the content type header
            dataType: 'json',
            success: function(response) {

                fetchTimetableData();
                // Clear the values in the modal
                $('#roomId').val('');
                $('#pathImage').val('');
                $('#imageUpload').val('');

                $('#updateModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Path image updated successfully!',
                });
            },
            error: function(xhr, status, error) {

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update path image. Please try again later.',
                });
            }
        });
    })
    .catch(error => {
        console.error('Error uploading image:', error);
        // Show error message using SweetAlert
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to upload image. Please try again later.',
        });
    });
}


// Event listener for update button
$('#updateBtn').click(function() {
    let roomId = $('#roomId').val();
    let pathImage = $('#pathImage').val();

    // Call updatePathImage function with roomId and pathImage
    updatePathImage(roomId, pathImage);
});






})
function fetchTimetableData() {
    $.ajax({
        url: 'api_timetable.php?action=fetch',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            $('#timetableBody').empty(); // Clear existing rows
            response.forEach(function(item) {
                $('#timetableBody').append(`
                    <tr>
                        <td><input type="checkbox" class="form-check-input"></td>
                        <td>${item.room_name}</td>
                        <td>${item.floor_name}</td>
                        <td><a href="${item.path_image}" target="_blank">${item.path_image}</a></td>
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="openUpdateModal(${item.id}, '${item.path_image}')">Update</button>
                            <button class="btn btn-secondary btn-sm" onclick="clearImagePath(${item.id})">Clear Image</button>
                        </td>
                    </tr>
                `);
            });
        },
        error: function(xhr, status, error) {
            console.error(error);
            // Handle error
        }
    });
}

function openUpdateModal(id, path_image) {
    // Set the ID and path image in the modal form
    $('#roomId').val(id);
    $('#pathImage').val(path_image);

    // Open the modal
    $('#updateModal').modal('show');
}

function clearImagePath(id) {
    // Display confirmation modal in Thai
    Swal.fire({
        title: 'คุณแน่ใจหรือไม่?',
        text: 'คุณกำลังจะลบที่อยู่รูปภาพไป การกระทำนี้ไม่สามารถย้อนกลับได้',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ใช่, ลบ!'
    }).then((result) => {
        if (result.isConfirmed) {
            // User confirmed, send AJAX request to delete the image path
            $.ajax({
                url: 'api_timetable.php?action=delete', // Use the delete action
                type: 'GET', // Use GET method to pass the id via query parameter
                data: { id: id },
                dataType: 'json',
                success: function(response) {
                    // Handle success response
                    fetchTimetableData(); // Reload the timetable table
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ',
                        text: 'ที่อยู่รูปภาพถูกลบเรียบร้อยแล้ว!'
                    });
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'ผิดพลาด',
                        text: 'เกิดข้อผิดพลาดในการลบที่อยู่รูปภาพ โปรดลองอีกครั้งในภายหลัง'
                    });
                }
            });
        }
    });
}


</script>

<!-- init js -->
<script src="assets/js/pages/datatable-pages.init.js"></script>

<script src="assets/js/app.js"></script>

</body>
</html>
