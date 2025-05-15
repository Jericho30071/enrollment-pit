<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login | Enrollment System</title>

  <?php include('./header.php'); ?>
  <?php 
  session_start();
  if(isset($_SESSION['login_id']))
  header("location:index.php?page=home");
  ?>

  <style>
    /* General Styles */
body {
  width: 100%;
  height: 100vh;
  background: url('assets/img/new.jpg') no-repeat center center/cover;
  display: flex;
  justify-content: center;
  align-items: center;
  font-family: "Poppins", sans-serif;
  position: relative;
}

body::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.1); /* Adjust opacity to lower intensity */
  z-index: -1;
}

/* Centered Login Box with Outline */
#login-right {
  background: white;
  width: 400px;
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0px 4px 20px rgba(25, 119, 204, 0.4);
  text-align: center;
  border: 2px solidrgb(0, 0, 0); /* Outline Border */
  transition: all 0.3s ease-in-out;
}

#login-right:hover {
  box-shadow: 0px 6px 25px rgba(25, 119, 204, 0.4); /* Glow Effect */
  transform: translateY(-5px); /* Subtle Lift */
}

/* Title Styling */
h4 {
  font-weight: 700;
  margin-bottom: 20px;
  color: #333;
}

/* Form Styling */
.form-group {
  margin-bottom: 15px;
  text-align: left;
}

.form-control {
  width: 100%;
  padding: 10px;
  border: 2px solid #ddd;
  border-radius: 5px;
  transition: all 0.3s ease-in-out;
}

.form-control:focus {
  border-color: #1977cc;
  box-shadow: 0px 0px 8px rgba(25, 119, 204, 0.5); /* Glow Effect */
  outline: none;
  transform: scale(1.02);
}

/* Button Styling */
.btn-primary {
  width: 100%;
  padding: 12px;
  border: none;
  border-radius: 5px;
  background: linear-gradient(135deg, #1977cc, #0056b3);
  color: white;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease-in-out;
}

.btn-primary:hover {
  background: linear-gradient(135deg, #0056b3, #1977cc);
  transform: scale(1.05);
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
}

  </style>
</head>

<body>

  <div id="login-right">
    <h4><strong>Dapitan National High School - Admin Login</strong></h4>
    
    <div class="card-body">
      <form id="login-form">
        <div class="form-group">
          <label for="username" class="control-label">Username</label>
          <input type="text" id="username" name="username" class="form-control" placeholder="Enter your username">
        </div>
        <div class="form-group">
          <label for="password" class="control-label">Password</label>
          <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password">
        </div>
        <button class="btn-primary">Login</button>
      </form>
    </div>
  </div>

</body>

<script>
  $('#login-form').submit(function(e){
    e.preventDefault();
    $('.btn-primary').attr('disabled',true).text('Logging in...');
    if($(this).find('.alert-danger').length > 0)
      $(this).find('.alert-danger').remove();
    
    $.ajax({
      url: 'ajax.php?action=login',
      method: 'POST',
      data: $(this).serialize(),
      error: err => {
        console.log(err);
        $('.btn-primary').removeAttr('disabled').text('Login');
      },
      success: function(resp) {
        if (resp == 1) {
          location.href = 'index.php?page=home';
        } else {
          $('#login-form').prepend('<div class="alert alert-danger">Invalid username or password.</div>');
          $('.btn-primary').removeAttr('disabled').text('Login');
        }
      }
    });
  });
</script>
</html>
