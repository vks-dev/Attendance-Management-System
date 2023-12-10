


<?php 
  
  include('connect.php');


 ?>


<!DOCTYPE html>
<html lang="en">
<head>
<title>Attendance Management System</title>
<meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
   
  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >
   
  <link rel="stylesheet" href="styles.css" >
   
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>

<header>

  <h1>Attendance Management System</h1>
  <div class="navbar">
  <a href="index.php">Login</a>

</div>

</header>

<center>

<div class="content">
    <div class="row">

    <form method="post" class="form-horizontal col-md-6 col-md-offset-3">
    <h3>Recover your password</h3>

      <div class="form-group">

        <label for="input1" class="col-sm-2 control-label">Email</label>
          <div class="col-sm-10">
            <input type="email" name="email"  class="form-control" id="input1" placeholder="your email" />
          </div>
      </div>

      <div class="form-group" class="radio">
					<label for="input1" class="col-sm-3 control-label">Verify As:</label>
					<div class="col-sm-6">
					<label>
						<input type="radio" name="type" id="optionsRadios1" value="student" checked> Student
					</label>
					<label>
						<input type="radio" name="type" id="optionsRadios1" value="teacher"> Teacher
					</label>
					<label>
						<input type="radio" name="type" id="optionsRadios1" value="admin"> Admin
					</label>
				</div>

      <input type="submit" class="btn btn-primary col-md-2 col-md-offset-10" value="Go" name="reset" />
    </form>

      <br>

      <?php

          if(isset($_POST['reset'])){

            $test = $_POST['email'];
            $row = 0;
            if ($_POST['type'] == 'Student') {
              $query = mysqli_query($conn,"select st_password from students where st_email = '$test';");
              $row = mysqli_num_rows($query);
            }

            else if ($_POST['type'] == "Teacher") {
              $query = mysqli_query($conn,"select tc_password from teachers where tc_email = '$test';");
              $row = mysqli_num_rows($query);
            }
            else if ($_POST['type'] == "Admin") {
              $query = mysqli_query($conn,"select password from admininfo where email = '$test';");
              $row = mysqli_num_rows($query);
            }
          

            if($row == 0){
          ?>
            <div  class="content"><p>Email is not associated with any account. Create a new account</p></div>

          <?php
          }

          else{
            if ($_POST['type'] == "Student") {
              $query = mysqli_query($conn,"select st_password from students where st_email = '$test';");
              $i =0;
              while($dat = mysqli_fetch_array($query)){
                  $i++;
                ?>
                <strong>
                  <p style="text-align: left;">Hi there!<br>You requested for a password recovery. You may <a href="index.php">Login here</a> and enter this key as your password to login. Recovery key: <mark><?php echo $dat['password']; ?></mark><br>Regards,<br>Attendance Management System</p></strong>

                <?php
              }
            }
            
            else if($_POST['type'] == "Teacher") {
              $query = mysqli_query($conn,"select st_password from students where st_email = '$test';");
              $i =0;
              while($dat = mysqli_fetch_array($query)){
                  $i++;
                ?>
                <strong>
                  <p style="text-align: left;">Hi there!<br>You requested for a password recovery. You may <a href="index.php">Login here</a> and enter this key as your password to login. Recovery key: <mark><?php echo $dat['password']; ?></mark><br>Regards,<br>Attendance Management System</p></strong>

                <?php
              }
            
            }

            else if ($_POST['type'] == "Admin"){

              $query = mysqli_query($conn,"select password from admininfo where email = '$test';");
              $i =0;
              while($dat = mysqli_fetch_array($query)){
                  $i++;
                ?>
                <strong>
                <p style="text-align: left;">Hi there!<br>You requested for a password recovery. You may <a href="index.php">Login here</a> and enter this key as your password to login. Recovery key: <mark><?php echo $dat['password']; ?></mark><br>Regards,<br>Attendance Management System</p></strong>
                <?php
              }
            }
          }
        }
        ?>

  </div>

</div>

</center>

</body>
</html>
