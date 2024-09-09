<?php include 'layouts/session.php'; ?>
<?php include 'layouts/head-main.php'; ?>

<head>
    <title>จัดการห้อง | Smart Mirror - C11 Team</title>
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
                            <h4 class="mb-sm-0 font-size-18">จัดการห้อง</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">หน้าหลัก</a></li>
                                    <li class="breadcrumb-item active">จัดการห้อง</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End page title -->

                <div class="table-responsive mb-4">
                    <table class="table align-middle datatable dt-responsive table-check nowrap" style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 50px;">ลำดับ</th>
                                <th scope="col">ชื่อห้อง</th>
                                <th scope="col">ชั้น</th>
                                <th scope="col">Remask</th>
                                <th scope="col">Path Image</th>
                                <th scope="col">Is Teacher</th>
                                <th style="width: 80px; min-width: 80px;">การกระทำ</th>
                            </tr>
                        </thead>
                        <tbody id="roomBody">
                            <!-- Dynamic room list will be loaded here -->
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

<!-- Edit Room Modal -->
<div class="modal fade" id="editRoomModal" tabindex="-1" aria-labelledby="editRoomModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRoomModalLabel">แก้ไขห้อง</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editRoomForm">
                    <div class="mb-3">
                        <label for="editRoomName" class="form-label">ชื่อห้อง</label>
                        <input type="text" class="form-control" id="editRoomName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editRemask" class="form-label">Remask</label>
                        <input type="text" class="form-control" id="editRemask" name="remask">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="editIsTeacher" name="is_teac" >
                        <label class="form-check-label" for="editIsTeacher">ห้องพักครู</label>
                    </div>
                    <input type="hidden" id="editRoomId" name="room_id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary" id="editRoomBtn">บันทึก</button>
            </div>
        </div>
    </div>
</div>
<!-- Add the modal for changing the image -->
<div class="modal fade" id="changeImageModal" tabindex="-1" aria-labelledby="changeImageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeImageModalLabel">Change Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="changeImageForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="newImage" class="form-label">New Image</label>
                        <input type="file" class="form-control" id="newImage" name="image" required>
                    </div>
                    <input type="hidden" id="roomIdForImage" name="room_id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="changeImageButton">Change</button>
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
        fetchRoomData();

        function fetchRoomData() {
            $.ajax({
                url: 'api_room.php?action=fetch',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#roomBody').empty(); // Clear existing rows
                    response.forEach(function(item, index) {
                        $('#roomBody').append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.name}</td>
                                <td>${item.floor_id}</td>
                                <td>${item.remask}</td>
                                <td>${item.path_image}</td>
                                <td>${item.is_teac == '1' ? 'Yes' : 'No'}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" onclick="openEditRoomModal(${item.room_id}, '${item.name}', '${item.floor_id}', '${item.remask}', '${item.path_image}', '${item.is_teac}')">แก้ไข</button>
                                    <button class="btn btn-secondary btn-sm" onclick="openChangeImageModal(${item.room_id})">Change Image</button>
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

        // Function to open edit room modal
        window.openEditRoomModal = function(room_id, name, floor_id, remask, path_image, is_teac) {
            $('#editRoomId').val(room_id);
            $('#editRoomName').val(name);
            $('#editFloorId').val(floor_id);
            $('#editRemask').val(remask);
            $('#editIsTeacher').prop('checked', is_teac == '1');
            $('#editRoomModal').modal('show');
        };

// Function to update room
$('#editRoomBtn').click(function() {
    // Serialize the form data
    let formData = $('#editRoomForm').serializeArray();

    // Convert the modified form data back to serialized format
    formData = $.param(formData);

    // Send the AJAX request
    $.ajax({
        url: 'api_room.php?action=update',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if ('error' in response) {
                // Show error message using SweetAlert
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.error
                });
            } else {
                // Show success message using SweetAlert
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Room updated successfully!'
                });
                
                fetchRoomData();
                $('#editRoomModal').modal('hide');
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
            // Show error message using SweetAlert
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to update room. Please try again later.'
            });
        }
    });
});




    });
</script>
<script>
    function openChangeImageModal(roomId) {
        $('#roomIdForImage').val(roomId);
        $('#changeImageModal').modal('show');
    }

    $('#changeImageButton').click(function() {
    let roomId = $('#roomIdForImage').val();
    let formData = new FormData($('#changeImageForm')[0]);

    $.ajax({
        url: 'upload_image.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            if (response.uploaded) {
                // Update the image URL in the database
                let imageUrl = response.url;

                updateImagePath(roomId, imageUrl);
                fetchRoomData();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.error ? response.error : 'Failed to change image. Please try again later.'
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Error changing image:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to change image. Please try again later.'
            });
        }
    });
});

function updateImagePath(roomId, imageUrl) {
    $.ajax({
        url: 'api_room.php?action=updateImage',
        type: 'POST',
        data: {
            room_id: roomId,
            path_image: imageUrl
        },
        dataType: 'json',
        success: function(response) {
            if ('success' in response) {
                // Update the image URL in the table
                $(`#imageCell_${roomId}`).html(`<a href="${imageUrl}" target="_blank">${imageUrl}</a>`);
                $('#changeImageModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Image changed successfully!'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.error ? response.error : 'Failed to update image path in the database.'
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Error updating image path:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to update image path in the database. Please try again later.'
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
