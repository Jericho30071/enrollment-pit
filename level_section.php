<div class="container-fluid">
    <div class="card shadow-lg rounded bg-light">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Level and Section Management</h4>
            <button type="button" class="btn btn-success btn-lg" id="new_level_section">
                <i class="fa fa-plus"></i> Add Level & Section
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered text-center" id="level_section-tbl">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Level</th>
                            <th>Section</th>
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
    $('#new_level_section').click(function(){
        uni_modal('New Level and Section', 'manage_level_section.php');
    });

    window.load_tbl = function(){
        $('#level_section-tbl').dataTable().fnDestroy();
        $('#level_section-tbl tbody').html('<tr><td colspan="4" class="text-center">Loading...</td></tr>');

        $.ajax({
            url: 'ajax.php?action=load_level_section',
            success: function(resp){
                if (typeof resp !== 'undefined') {
                    resp = JSON.parse(resp);
                    $('#level_section-tbl tbody').html('');
                    if (Object.keys(resp).length > 0) {
                        let i = 1;
                        Object.keys(resp).forEach(k => {
                            let tr = $('<tr></tr>');
                            tr.append(`<td>${i++}</td>`);
                            tr.append(`<td>${resp[k].level}</td>`);
                            tr.append(`<td>${resp[k].section}</td>`);
                            tr.append(`<td>
                                <center>
                                    <button class="btn btn-info btn-sm edit_level_section" data-id="${resp[k].id}">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-danger btn-sm remove_level_section" data-id="${resp[k].id}">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </center>
                            </td>`);

                            $('#level_section-tbl tbody').append(tr);
                        });
                    } else {
                        $('#level_section-tbl tbody').html('<tr><td colspan="4" class="text-center">No Data Available</td></tr>');
                    }
                }
            },
            complete: function(){
                $('#level_section-tbl').dataTable();
                manage_level_section();
            }
        });
    };

    function manage_level_section(){
        $('.edit_level_section').click(function(){
            uni_modal("Edit Level and Section", 'manage_level_section.php?id=' + $(this).attr('data-id'));
        });

        $('.remove_level_section').click(function(){
            _conf("Are you sure you want to delete this record?", 'remove_level_section', [$(this).attr('data-id')]);
        });
    }

    function remove_level_section(id){
        start_load();
        $.ajax({
            url: 'ajax.php?action=remove_level_section',
            method: 'POST',
            data: { id: id },
            success: function(resp){
                if (resp == 1) {
                    alert_toast("Level and Section removed successfully!", 'success');
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
</style>
