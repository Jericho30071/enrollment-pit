<div class="container-fluid py-3">
    <div class="card shadow-lg rounded border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="fw-bold mb-0"><i class="fas fa-user-graduate me-2"></i> Student Enrollment List</h4>
            <button type="button" class="btn btn-success btn-md rounded px-3" id="new_student">
                <i class="fa fa-plus"></i> Enroll New Student
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center" id="student-tbl">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Level & Section</th>
                            <th>Adviser</th>
                            <th>Student Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be dynamically loaded here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Floating Button for Mobile -->
<button class="floating-add-btn shadow" id="new_student">
    <i class="fas fa-plus"></i>
</button>

<script>
    // Open large modal for enrollment form
    $('#new_student').click(function(){
        uni_modal('Enroll New Student', 'manage_enrollment.php', 'modal-xl'); // FIXED SIZE
    });

    function load_tbl(){
        $('#student-tbl').DataTable().destroy();
        $('#student-tbl tbody').html('<tr><td colspan="6" class="text-center text-muted">Loading...</td></tr>');

        $.ajax({
            url: 'ajax.php?action=load_student',
            method: 'GET',
            dataType: 'json',
            success: function(resp){
                $('#student-tbl tbody').empty();
                if (resp && Object.keys(resp).length > 0) {
                    let i = 1;
                    Object.keys(resp).forEach(k => {
                        let tr = $('<tr></tr>');
                        tr.append(`<td>${i++}</td>`);
                        tr.append(`<td class="fw-bold">${resp[k].name}</td>`);
                        tr.append(`<td>${resp[k].ls}</td>`);
                        tr.append(`<td>${resp[k].fname}</td>`);
                        tr.append(`<td><span class="badge bg-secondary">${resp[k].user_type}</span></td>`);
                        tr.append(`<td>
                            <button class="btn btn-outline-info btn-sm edit_student" data-id="${resp[k].id}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-outline-danger btn-sm remove_student" data-id="${resp[k].id}">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>`);
                        $('#student-tbl tbody').append(tr);
                    });
                } else {
                    $('#student-tbl tbody').html('<tr><td colspan="6" class="text-center text-muted">No Students Enrolled</td></tr>');
                }
            },
            complete: function(){
                $('#student-tbl').DataTable();
                manage_student();
            }
        });
    }

    function manage_student(){
        $('.edit_student').click(function(){
            uni_modal("Edit Enrollment", 'manage_enrollment.php?id=' + $(this).attr('data-id'), 'modal-xl');
        });

        $('.remove_student').click(function(){
            _conf("Are you sure you want to delete this student?", 'remove_student', [$(this).attr('data-id')]);
        });
    }

    function remove_student(id){
        start_load();
        $.ajax({
            url: 'ajax.php?action=remove_enroll',
            method: 'POST',
            data: { id: id },
            success: function(resp){
                if (resp == 1) {
                    alert_toast("Student removed successfully!", 'success');
                    $('.modal').modal('hide');
                    load_tbl();
                    end_load();
                }
            }
        });
    }

    $(document).ready(function(){
        load_tbl();
    });
</script>

<style>
    /* Large Modal Fix */
    .modal-xl {
        max-width: 90% !important; /* Ensure it takes up more space */
    }

    /* Modern Card Styling */
    .card {
        border-radius: 12px;
        background: white;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Buttons */
    .btn-success {
        font-size: 14px;
        padding: 8px 16px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .btn-sm {
        font-size: 13px;
        padding: 5px 10px;
    }

    /* Table Styling */
    .table {
        font-size: 14px;
        border-radius: 8px;
        overflow: hidden;
    }

    .table-hover tbody tr:hover {
        background: rgba(0, 123, 255, 0.1);
    }

    .table thead {
        background: #343a40;
        color: white;
    }

    /* Floating Add Button */
    .floating-add-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #007bff;
        color: white;
        border: none;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        cursor: pointer;
        transition: 0.3s;
    }

    .floating-add-btn:hover {
        background: #0056b3;
        transform: scale(1.1);
    }
</style>
