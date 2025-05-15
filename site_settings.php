<?php
include 'db_connect.php';
$qry = $conn->query("SELECT * FROM settings LIMIT 1");
if ($qry->num_rows > 0) {
    foreach ($qry->fetch_array() as $k => $val) {
        $meta[$k] = $val;
    }
}
?>

<div class="container-fluid">
    <div class="card col-lg-12 shadow-sm p-4">
        <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0">Site Settings</h4>
        </div>
        <div class="card-body">
            <form action="" id="manage-settings">
                <div class="form-group">
                    <label for="name" class="control-label font-weight-bold">School Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($meta['name']) ? $meta['name'] : '' ?>" required>
                </div>
                <div class="form-group">
                    <label for="address" class="control-label font-weight-bold">School Address</label>
                    <textarea name="address" class="form-control" rows="3"><?php echo isset($meta['address']) ? $meta['address'] : '' ?></textarea>
                </div>
                <div class="form-group">
                    <label class="control-label font-weight-bold">School Logo</label>
                    <div class="text-center">
                        <img src="assets/img/<?php echo isset($meta['img_path']) ? $meta['img_path'] : '' ?>" alt="School Logo" class="img-preview rounded border">
                    </div>
                    <div class="input-group mt-3">
                        <div class="custom-file">
                            <input type="file" name="img" class="custom-file-input" id="img" accept="image/*" onchange="displayImg(this, $(this))">
                            <label class="custom-file-label" for="img">Choose file</label>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button class="btn btn-primary btn-lg">Save Settings</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#manage-settings').submit(function(e){
        e.preventDefault();
        start_load();
        $.ajax({
            url: 'ajax.php?action=save_settings',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            error: function(err){
                console.log(err);
            },
            success: function(resp){
                if (resp == 1) {
                    alert_toast('Data successfully saved.', 'success');
                    end_load();
                }
            }
        });
    });

    function displayImg(input, _this) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                _this.closest('.form-group').find('.img-preview').attr('src', e.target.result);
                _this.siblings('label').html(input.files[0]['name']);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<style>
    .img-preview {
        max-width: 150px;
        max-height: 100px;
        object-fit: cover;
    }
    .card {
        border-radius: 10px;
    }
</style>
