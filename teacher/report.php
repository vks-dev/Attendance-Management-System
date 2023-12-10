<?php

ob_start();
session_start();

if($_SESSION['name']!='oasis')
{
  header('location: login.php');
}
?>
<?php include('connect.php');?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Attendance Management System</title>
<meta charset="UTF-8">

  <link rel="stylesheet" type="text/css" href="../css/main.css">
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
  <a href="index.php" style="text-decoration:none; font-size: 17px;">Home</a>
  <a href="students.php" style="text-decoration:none; font-size: 17px;">Students</a>
  <a href="teachers.php" style="text-decoration:none; font-size: 17px;">Faculties</a>
  <a href="attendance.php" style="text-decoration:none; font-size: 17px;">Attendance</a>
  <a href="report.php" style="text-decoration:none; font-size: 17px;">Report</a>
  <a href="../logout.php" style="text-decoration:none; font-size: 17px;">Logout</a>

</div>

</header>

<center>

<div class="row">

  <div class="content">
    <h2>Individual Report</h2>
    <br>
    <form method="post" action="">
    <?php 
        // include("../index.php");
        $teacher = $_SESSION['teacherName'];
        $sql_query = mysqli_query($conn, "select tc_course from teachers where tc_uname = '$teacher';");
        $rows = mysqli_num_rows($sql_query);
    ?>
              
              <div class="form-group">

                  <label >Select Subject</label>
                      <select name="whichcourse" id="input1">
                        <?php  
                          for($i = 1; $i <= $rows; $i++)
                          {
                            $row = mysqli_fetch_array($sql_query, MYSQLI_ASSOC);
                            print_r($row);
                          }
                        ?>
                          <option value="<?php echo  $row["tc_course"]; ?>" >
                            <?php 
                              echo $row["tc_course"];
                            ?>
                          </option>
                        </select>

              </div>

      <p>  </p>
      <label>Student Reg. No.</label>
      <input type="text" name="sr_id">
      <input type="submit" name="sr_btn" value="GO!" class="btn btn-primary" >

    </form>


    <p>  </p>

      
      

    <br>

    <br>

   <?php

    if(isset($_POST['sr_btn'])){

     $sr_id = $_POST['sr_id'];
     $course = $_POST['whichcourse'];

     $single = mysqli_query($conn, "select stat_id,count(*) as countP from attendance where attendance.stat_id='$sr_id' and attendance.course = '$course' and attendance.st_status='Present'");
     $singleT= mysqli_query($conn, "select count(*) as countT from attendance where attendance.stat_id='$sr_id' and attendance.course = '$course'");
      //  $count_tot = mysqli_num_rows($singleT);
    } 

   ?>  
    



    <form method="post" action="" class="form-horizontal col-md-6 col-md-offset-3">
    <table class="table table-hover table-bordered">

    <?php


    if(isset($_POST['sr_btn'])){

       $count_pre = 0;
       $i= 0;
       $count_tot;
       if ($row=mysqli_fetch_row($singleT))
       {
       $count_tot=$row[0];
       }
       while ($data = mysqli_fetch_array($single)) {
       $i++;
       
       if($i <= 1){
     ?>


     <tbody>
      <tr>
          <td><b>Student Reg. No: </b></td>
          <td><b><?php echo $data['stat_id']; ?></b></td>
      </tr>

           <?php
         //}
        
        // }

      ?>
      
      <tr>
        <td><b>Total Class (Days): </b></td>
        <td><?php echo $count_tot; ?> </td>
      </tr>

      <tr>
        <td><b>Present (Days): </b></td>
        <td><?php echo $data[1]; ?> </td>
      </tr>

      <tr>
        <td><b>Absent (Days): </b></td>
        <td><?php echo $count_tot -  $data[1]; ?> </td>
      </tr>
      
      <tr>
        <td><b>Percentage: </b></td>
        <td>
          <?php 
            if ($data[1] == 0 or $count_tot == 0) {
              echo "0%";
            } else {
              echo round((($data[1]/($count_tot)*1.0)*100), 2)."%";
            }
          ?>
        </td>
      </tr>

    </tbody>

   <?php

     }  
    }}
     ?>
    </table>
  </form>

  </div>

</div>

</center>

</body>
</html>
