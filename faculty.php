<div class="container-fluid">
    <div class="card shadow-sm rounded">
        <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0">Faculty Management</h4>
        </div>
        <div class="card-body">
            <div class="text-right mb-3">
                <button type="button" class="btn btn-success btn-lg" id="new_faculty">
                    <i class="fa fa-plus"></i> Add Faculty
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-bordered text-center" id="faculty-tbl">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Advisory</th>
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
    $('#new_faculty').click(function(){
        uni_modal('New Faculty', 'manage_faculty.php');
    });

    window.load_tbl = function(){
        $('#faculty-tbl').dataTable().fnDestroy();
        $('#faculty-tbl tbody').html('<tr><td colspan="4" class="text-center">Loading...</td></tr>');
        $.ajax({
            url: 'ajax.php?action=load_faculty',
            success: function(resp){
                if (typeof resp != 'undefined'){
                    resp = JSON.parse(resp);
                    $('#faculty-tbl tbody').html('');
                    if(Object.keys(resp).length > 0){
                        let i = 1;
                        Object.keys(resp).forEach(k => {
                            let tr = $('<tr></tr>');
                            tr.append(`<td>${i++}</td>`);
                            tr.append(`<td>${resp[k].firstname} ${resp[k].middlename} ${resp[k].lastname}</td>`);
                            tr.append(`<td>${resp[k].advisory}</td>`);
                            tr.append(`<td>
                                <center>
                                    <button class="btn btn-info btn-sm edit_faculty" data-id="${resp[k].id}">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-danger btn-sm remove_faculty" data-id="${resp[k].id}">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </center>
                            </td>`);
                            $('#faculty-tbl tbody').append(tr);
                        });
                    } else {
                        $('#faculty-tbl tbody').html('<tr><td colspan="4" class="text-center">No Data Available</td></tr>');
                    }
                }
            },
            complete: function(){
                $('#faculty-tbl').dataTable();
                manage_faculty();
            }
        });
    };

    function manage_faculty(){
        $('.edit_faculty').click(function(){
            uni_modal("Edit Faculty", 'manage_faculty.php?id=' + $(this).attr('data-id'));
        });

        $('.remove_faculty').click(function(){
            _conf("Are you sure you want to delete this record?", 'remove_faculty', [$(this).attr('data-id')]);
        });
    }

    function remove_faculty(id){
        start_load();
        $.ajax({
            url: 'ajax.php?action=remove_faculty',
            method: 'POST',
            data: { id: id },
            success: function(resp){
                if (resp == 1) {
                    alert_toast("Faculty removed successfully!", 'success');
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
</style>
