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

<!-- head started -->
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
<!-- head ended -->

<!-- body started -->
<body>
<?php 
$stdata = [];
$allsub_present=null;
$allsub_total=null;
$sr_id=null;
?>

<!-- Menus started-->
<header>

  <h1>Attendance Management System</h1>
  <div class="navbar">
  <a href="index.php" style="text-decoration:none; font-size: 17px;">Home</a>
  <a href="students.php" style="text-decoration:none; font-size: 17px;">Students</a>
  <a href="report.php" style="text-decoration:none; font-size: 17px;">Report Section</a>
  <!-- <a href="account.php" style="text-decoration:none; font-size: 17px;">My Account</a> -->
  <a href="../logout.php" style="text-decoration:none; font-size: 17px;">Logout</a>

</div>

</header>
<!-- Menus ended -->

<center>

<!-- Content, Tables, Forms, Texts, Images started -->
<div class="row">

  <div class="content">
    <h3>Student Report</h3>
    <br>
    <form method="post" action="" class="form-horizontal col-md-6 col-md-offset-3">

  <!-- <div class="form-group">

    <label  for="input1" class="col-sm-3 control-label">Select Subject</label>
      <div class="col-sm-4">
      <select name="whichcourse" id="input1">
         <option  value="algo">Analysis of Algorithms</option>
         <option  value="algolab">Analysis of Algorithms Lab</option>
        <option  value="dbms">Database Management System</option>
        <option  value="dbmslab">Database Management System Lab</option>
        <option  value="weblab">Web Programming Lab</option>
        <option  value="os">Operating System</option>
        <option  value="oslab">Operating System Lab</option>
        <option  value="obm">Object Based Modeling</option>
        <option  value="softcomp">Soft Computing</option>

      </select>
      </div>

  </div> -->


        <div class="form-group">
           <label for="input1" class="col-sm-3 control-label">Your Reg. No.</label>
              <div class="col-sm-7">
                  <input type="text" name="sr_id"  class="form-control" id="input1" placeholder="enter your reg. no." />
              </div>
        </div>
        <input type="submit" class="btn btn-danger col-md-3 col-md-offset-7" style="border-radius:0%" value="Find" name="sr_btn" />
    </form>
   

    <div class="content"><br></div>


    <?php
    if(isset($_POST['sr_btn'])){
      $sr_id = $_POST['sr_id'];
      $getdept = mysqli_query($conn,"select st_dept from students where st_id='$sr_id';");
      $res=mysqli_fetch_row($getdept);
      // print_r($res); displays the department of the registered number
      $getsubjects = mysqli_query($conn,"select tc_course from teachers where tc_dept='$res[0]';");
      $subcount = mysqli_num_rows($getsubjects);
      $stdata =[];
      $allsub_present=0;
      $allsub_total=0;
      // $idary = array("Registration id",$sr_id);
      // array_push($stdata,$idary);
      for($i = 1; $i <= $subcount; $i++) {
        $ro = mysqli_fetch_array($getsubjects, MYSQLI_NUM);
        // print_r($ro); displays the subjects from the concerned department
        $all_query = mysqli_query($conn, "select count(*) as countP from attendance where attendance.stat_id='$sr_id' and attendance.course = '$ro[0]' and attendance.st_status='Present';");
        $singleT= mysqli_query($conn, "select count(*) as countT from attendance where attendance.stat_id='$sr_id' and attendance.course = '$ro[0]';");
        $presentcount = mysqli_fetch_row($all_query);
        $total = mysqli_fetch_row($singleT);
        // print_r($ro[0]);
        // print_r($presentcount);
        // print_r($total);
        $setv = array($ro[0],$presentcount[0],$total[0]);
        $allsub_present=$allsub_present+$presentcount[0];
        $allsub_total=$allsub_total+$total[0];
        array_push($stdata,$setv);
      }

    }

    ?>
  </div>

</div>
<!-- Contents, Tables, Forms, Images ended -->
<div>
    <table class="table  table-hover table-bordered" style="width: fit-content;">
      <tbody>
        <tr>
          <th>Registration id</th>
          <th><?php echo $sr_id?></th>
        </tr>
        <tr>
          <td>Subject</td>
          <td>present</td>
          <td>Total</td>
          <td>percentage</td>
        </tr>
        <?php
        foreach($stdata as $subrecord){
          echo "<tr>".
            "<td>".$subrecord[0]."</td>".
            "<td>".$subrecord[1]."</td>".
            "<td>".$subrecord[2]."</td>".
            "<td>".round($subrecord[1]*100/$subrecord[2]*1.0, 2)."%"."</td>".
            "</tr>";
        }
        ?>
        <tr>
          <td>Overall Attendance</td>
          <td>
            <?php 
              if($allsub_total!=0){
                echo round($allsub_present*100/$allsub_total*1.0, 2)."%";
              }
              else{ 
                echo "0.00";
              }
            ?>
          </td>
        </tr>
      </tbody>
    </table>
</div>

<a href="lessPercentage.html"> Why attendance is important?</a>



</center>

</body>


</html>