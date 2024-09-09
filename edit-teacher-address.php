<?php include 'layouts/session.php'; ?>
<?php include 'layouts/head-main.php'; ?>

<head>
    <title>แก้ไขที่อยู๋อาจารย์ | Smart Mirror - C11 Team</title>
    <?php include 'layouts/head.php'; ?>
    <!-- DataTables -->
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <?php include 'layouts/head-style.php'; ?>
    <script src="assets/libs/ckeditor5-build-classic/ckeditor.js"></script>
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
                            <h4 class="mb-sm-0 font-size-18">รายการประวัติอาจารย์</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">หน้าหลัก</a></li>
                                    <li class="breadcrumb-item active">รายการประวัติอาจารย์</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End page title -->

                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h5 class="card-title">รายการอาจารย์ <span class="text-muted fw-normal ms-2">(จำนวน)</span></h5>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                            <div>

                            </div>
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
                                <th scope="col">ชื่อ - สกุล</th>
                                <th scope="col">เบอร์โทรศัพท์</th>
                                <th scope="col">ห้อง</th>
                                <th style="width: 80px; min-width: 80px;">การกระทำ</th>
                            </tr>
                        </thead>
                        <tbody>

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

<!-- Add Post Modal -->
<div class="modal fade" id="addPostModal" tabindex="-1" role="dialog" aria-labelledby="addPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document"> <!-- Add modal-xl class here -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPostModalLabel">เพิ่มโพสต์ใหม่</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add your form fields for adding a post here -->
                <form id="addPostForm">
                    <div class="form-group">
                        <label for="header">หัวข้อ</label>
                        <input type="text" class="form-control" id="header" name="header">
                    </div>
                    <div class="form-group">
                        <label for="content">เนื้อหา</label>
                        <textarea class="form-control" id="content" name="content"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="create_by">ผู้เขียน</label>
                        <input type="text" class="form-control" id="create_by" name="create_by">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary" id="addPostBtn">บันทึก</button>
            </div>
        </div>
    </div>
</div>


<!-- Edit Post Modal -->
<div class="modal fade" id="editPostModal" tabindex="-1" role="dialog" aria-labelledby="editPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document"> <!-- Add modal-xl class here -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPostModalLabel">แก้ไขโพสต์</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add your form fields for editing a post here -->
                <form id="editPostForm">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="form-group">
                        <label for="edit_header">ชื่อ - สกุล</label>
                        <input type="text" class="form-control" id="edit_header" name="header">
                    </div>
                    <div class="form-group">
                        <label for="edit_content">ประวัติ</label>
                        <textarea class="form-control" id="edit_content" name="content"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_create_by">เบอร์โทรศัพท์</label>
                        <input type="text" class="form-control" id="edit_create_by" name="create_by">
                    </div>
                    <div class="form-group">
                        <label for="room" class="form-label">ห้อง</label>
                        <select class="form-control" id="edit_room_id" name="room">
                            <!-- Options for rooms will be dynamically populated here -->
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary" id="editPostBtn">บันทึกการแก้ไข</button>
            </div>
        </div>
    </div>
</div>




<!-- Your table and other content -->


<!-- Right Sidebar -->
<?php include 'layouts/right-sidebar.php'; ?>
<!-- /Right-bar -->

<!-- JAVASCRIPT -->
<?php include 'layouts/vendor-scripts.php'; ?>


<!-- Required datatable js -->
<script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>


<script>
$(document).ready(function() {

    let myEditor;

class UploadAdapter {
    constructor(loader) {
        this.loader = loader;
    }

    upload() {
        return this.loader.file.then(file => new Promise((resolve, reject) => {
            const formData = new FormData();
            formData.append('image', file); // Make sure 'image' matches the key expected by your server

            fetch('/upload_image.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(result => {
                if (result && result.uploaded) {
                    resolve({ default: result.url }); // Use the URL from the server response
                } else {
                    reject(result.error ? result.error.message : 'Upload failed');
                }
            })
            .catch(error => {
                reject('Upload failed: ' + error.message);
            });
        }));
    }

    // Implement the abort method if necessary
}

ClassicEditor
    .create(document.querySelector('#content'))
    .then(editor => {
        console.log(editor);
        myEditor = editor;

        // Set up the custom UploadAdapter
        editor.plugins.get('FileRepository').createUploadAdapter = loader => {
            return new UploadAdapter(loader);
        };
    })
    .catch(error => {
        console.error(error);
    });
    
    // Initialize DataTable
    var postTable = $('.datatable').DataTable({
        "processing": true,
        "serverSide": false, // Since you're fetching all posts at once
        "ajax": {
            "url": "api_teacher.php?action=fetch",
            "dataSrc": "" // This is important to handle the response properly
        },
        "destroy": true,
        "columns": [
            { "data": "id" }, // Assuming you have an 'id' field in your posts
            { "data": "name" },
            { "data": "phone" },
            { "data": "room_id" },
            {
                "data": null,
                "render": function (data, type, row) {
                    return `<button data-id="${row.id}" class="btn btn-primary btn-sm editBtn">Edit</button>
                            <button data-id="${row.id}" class="btn btn-danger btn-sm deleteBtn">Delete</button>`;
                },
                "orderable": false
            }
        ]
    });

// Initialize CKEditor for edit modal outside of the click event handler
var editEditor;

$(document).ready(function() {
    editEditor = ClassicEditor
        .create(document.querySelector('#edit_content'))
        .catch(error => {
            console.error(error);
        });

        $('#editPostModal').on('hidden.bs.modal', function () {
            // Reset input values when modal is dismissed
            $('#editPostForm')[0].reset();
        });

        $('#addPostModal').on('hidden.bs.modal', function(e) {
            // Reset all input fields and textarea in the modal
            $('#addPostModal input').val('');
            $('#addPostModal textarea').val('');
        });
});

// Open edit modal and populate data when clicking edit button
$(document).on('click', '.editBtn', function() {
    var postId = $(this).data('id');
    // Assuming you have an API endpoint to fetch post details by ID
    $.getJSON('api_teacher.php?action=fetchById&id=' + postId, function(data) {
        // Populate data in the edit modal
        $('#edit_id').val(data.id);
        $('#edit_header').val(data.name);
        $('#edit_create_by').val(data.phone);

        // Set data in CKEditor
        editEditor.then(editor => {
            editor.setData(data.content);
        });

        // Show the edit modal
        $('#editPostModal').modal('show');
    });
});


$('#editPostModal').on('show.bs.modal', function() {
    populateRoomDropdown();
});
function populateRoomDropdown() {
    $.ajax({
        url: 'api_room.php?action=fetch',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            // Clear existing options
            $('#room').empty();
            // Populate dropdown with fetched room names
            response.forEach(function(room) {
                $('#edit_room_id').append(`<option value="${room.room_id}">${room.name}</option>`);
            });
        },
        error: function(xhr, status, error) {
            console.error(error);
            // Handle error
        }
    });
}
// Edit post
$('#editPostBtn').click(function() {
    // Get the content from CKEditor
    editEditor.then(editor => {
        var content = editor.getData();
        
        // Assuming you have an API endpoint to update a post
        $.post('api_teacher.php?action=update', {
            id: $('#edit_id').val(),
            name: $('#edit_header').val(),
            content: content, // Include the content from CKEditor
            phone: $('#edit_create_by').val(),
            room_id: $('#edit_room_id').val()
        }, function(response) {
            // Check if the response contains a success message
            if (response.success) {
                // Show success message with SweetAlert2
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.success // Assuming the API returns a success message
                }).then((result) => {
                    // Close the modal after editing a post
                    $('#editPostModal').modal('hide');
                    // Reload the DataTable to reflect the changes
                    postTable.ajax.reload();
                });
            } else {
                // Show error message with SweetAlert2
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: response.error // Assuming the API returns an error message
                });
            }
        }).fail(function(xhr, status, error) {
            // Show error message with SweetAlert2 if the request fails
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Failed to update post. Please try again later.' // Custom error message
            });
        });
    });
});




      // Add new post
      $('#addPostBtn').click(function() {
        // Gather data from the modal form
        var header = $('#header').val();
        var create_by = $('#create_by').val();

        // Get content from CKEditor
        var editorData = myEditor.getData();

        // Check if any required field is missing
        if (!header || !editorData || !create_by) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Please fill in all required fields.' // Custom error message
            });
            return; // Stop further execution
        }

        // Create an object to hold the post data
        var postData = {
            header: header,
            content: editorData,
            create_by: create_by
        };

        // Send an AJAX request to the insertPost API endpoint
        $.ajax({
            url: 'api_posts.php?action=insert',
            type: 'POST',
            data: postData,
            dataType: 'json',
            success: function(response) {
                // Show success message with SweetAlert2
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.success // Assuming the API returns a success message
                }).then((result) => {
                    // Reload the DataTable to reflect the changes
                    postTable.ajax.reload();
                    // Close the modal after adding a post
                    $('#addPostModal').modal('hide');
                });
            },
            error: function(xhr, status, error) {
                // Show error message with SweetAlert2
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: xhr.responseJSON.error // Assuming the API returns an error message
                });
            }
        });
    });

// เพิ่มการฟังก์ชันสำหรับการคลิกที่ปุ่มลบ
$(document).on('click', '.deleteBtn', function() {
    var postId = $(this).data('id');
    // แสดงกล่องโต้ตอบการลบโพสต์โดยใช้ SweetAlert2
    Swal.fire({
        title: 'คุณแน่ใจหรือไม่?',
        text: 'คุณจะไม่สามารถย้อนกลับได้!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'ใช่, ลบ!'
    }).then((result) => {
        // หากผู้ใช้ยืนยันการลบ
        if (result.isConfirmed) {
            // ส่งคำขอ AJAX เพื่อลบโพสต์
            $.ajax({
                url: 'api_teacher.php?action=delete',
                type: 'POST',
                data: { id: postId },
                dataType: 'json',
                success: function(response) {
                    // แสดงข้อความสำเร็จด้วย SweetAlert2
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ!',
                        text: response.success // กำหนดว่า API จะคืนข้อความสำเร็จอย่างไร
                    }).then((result) => {
                        // รีโหลด DataTable เพื่อแสดงการเปลี่ยนแปลง
                        postTable.ajax.reload();
                    });
                },
                error: function(xhr, status, error) {
                    // แสดงข้อความผิดพลาดด้วย SweetAlert2
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด!',
                        text: xhr.responseJSON.error // กำหนดว่า API จะคืนข้อความผิดพลาดอย่างไร
                    });
                }
            });
        }
    });
});

});


function openAddPostModal() {
    $('#addPostModal').modal('show');
}


</script>

<!-- Responsive examples -->
<script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

<script src="assets/js/app.js"></script>

</body>
</html>
