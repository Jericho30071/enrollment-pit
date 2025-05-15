<div class="container-fluid">
    <div class="card shadow-lg rounded bg-light">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Academic Year Management</h4>
            <button type="button" class="btn btn-success btn-lg" id="new_school_year">
                <i class="fa fa-plus"></i> Add Academic Year
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered text-center" id="school_year-tbl">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Academic Year</th>
                            <th>Default</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data loads dynamically -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $('#new_school_year').click(function(){
        uni_modal('New Academic Year', 'manage_school_year.php');
    });

    window.load_tbl = function(){
        $('#school_year-tbl').dataTable().fnDestroy();
        $('#school_year-tbl tbody').html('<tr><td colspan="4" class="text-center">Loading...</td></tr>');

        $.ajax({
            url: 'ajax.php?action=load_school_year',
            success: function(resp){
                if (typeof resp !== 'undefined') {
                    resp = JSON.parse(resp);
                    $('#school_year-tbl tbody').html('');
                    if (Object.keys(resp).length > 0) {
                        let i = 1;
                        Object.keys(resp).forEach(k => {
                            let tr = $('<tr></tr>');
                            tr.append(`<td>${i++}</td>`);
                            tr.append(`<td>${resp[k].school_year}</td>`);

                            if (resp[k].is_on == 1) {
                                tr.append(`<td><span class="badge badge-success p-2">Active</span></td>`);
                            } else {
                                tr.append(`<td><span class="badge badge-secondary switch p-2" data-id="${resp[k].id}">Set as Default</span></td>`);
                            }

                            tr.append(`<td>
                                <center>
                                    <button class="btn btn-info btn-sm edit_school_year" data-id="${resp[k].id}">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-danger btn-sm remove_school_year" data-id="${resp[k].id}">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </center>
                            </td>`);

                            $('#school_year-tbl tbody').append(tr);
                        });
                    } else {
                        $('#school_year-tbl tbody').html('<tr><td colspan="4" class="text-center">No Data Available</td></tr>');
                    }
                }
            },
            complete: function(){
                $('#school_year-tbl').dataTable();
                manage_school_year();
            }
        });
    };

    function manage_school_year(){
        $('.edit_school_year').click(function(){
            uni_modal("Edit Academic Year", 'manage_school_year.php?id=' + $(this).attr('data-id'));
        });

        $('.remove_school_year').click(function(){
            _conf("Are you sure you want to delete this record?", 'remove_school_year', [$(this).attr('data-id')]);
        });

        $('.switch').click(function(){
            _conf("Are you sure you want to set this as the default Academic Year?", 'switch_year', [$(this).attr('data-id')]);
        });
    }

    function remove_school_year(id){
        start_load();
        $.ajax({
            url: 'ajax.php?action=remove_school_year',
            method: 'POST',
            data: { id: id },
            success: function(resp){
                if (resp == 1) {
                    alert_toast("Academic Year removed successfully!", 'success');
                    $('.modal').modal('hide');
                    load_tbl();
                    end_load();
                }
            }
        });
    }

    function switch_year(id){
        start_load();
        $.ajax({
            url: 'ajax.php?action=switch_year',
            method: 'POST',
            data: { id: id },
            success: function(resp){
                if (resp == 1) {
                    alert_toast("Academic Year updated successfully!", 'success');
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
    .card {
        border-radius: 12px;
        background-color: #f8f9fa;
    }
    .btn-success {
        font-size: 16px;
        padding: 10px 20px;
        border-radius: 8px;
    }
    .table {
        font-size: 14px;
        border-radius: 10px;
        overflow: hidden;
    }
    .table thead {
        background: #007bff;
        color: white;
    }
    .btn-sm {
        font-size: 14px;
        padding: 5px 10px;
    }
    .badge {
        font-size: 14px;
        padding: 6px 12px;
        border-radius: 12px;
    }
    .switch {
        cursor: pointer;
    }
</style>
