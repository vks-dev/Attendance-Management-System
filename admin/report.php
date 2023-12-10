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
  <style>
    @media print{
      header,form,.b1,.reports{
        display:none;
      }

      *{
        margin-top: 20px;
      }
    }
  </style>
</head>
<body>
  <?php
    $dept_subjects = [];
    $stdcount = null;
  ?>
  <header>

  <h1>Attendance Management System</h1>
  <div class="navbar">
  <!-- <a href="signup.php" style="text-decoration:none; font-size: 17px;">Create Users</a> -->
  <a href="index.php" style="text-decoration:none; font-size: 17px;">Add Users</a>
  <a href="v-students.php" style="text-decoration:none; font-size: 17px;">View Students</a>
  <a href="v-teachers.php" style="text-decoration:none; font-size: 17px;">View Teachers</a>
  <a href="account.php" style="text-decoration:none; font-size: 17px;">Update Student</a>
  <a href="report.php" style="text-decoration:none; font-size: 17px;">Report</a>
  <a href="../logout.php" style="text-decoration:none; font-size: 17px;">Logout</a>

  </div>

  </header>
  <center>


    <form method="post">
      <label>Select Batch:</label>

      <?php
          $batch_query = mysqli_query($conn, "SELECT DISTINCT st_batch FROM `students`;");
          $rows = mysqli_num_rows($batch_query);
      ?>
      <select name="batch" id="">
        <?php  
          for($i = 1;$i <= $rows;$i++){
              $row = mysqli_fetch_array($batch_query, MYSQLI_ASSOC);
              print_r($row);
          }
        ?>
        <option value="<?php echo  $row["st_batch"]; ?>" >
          <?php 
            echo $row["st_batch"];
          ?>
        </option>
      </select>
      <br>
      <label>Enter Department</label>
      <select name="dept" id="dept">
        <option  value="CSE">CSE</option>
        <option  value="ECE">ECE</option>
        <option  value="Civil">Civil</option>
        <option  value="EEE">EEE</option>
        <option  value="Mechanical">Mechanical</option>
      </select>
      <br>

      <input type="Submit" value="Generate Reports" name="getReport" class="reports">
    </form>

    <?php
        if(isset($_POST['getReport'])){

          $sdept = $_POST['dept'];
          $batch = $_POST['batch'];

          ?>
          <span class="selection-choices">
            <?php
              print_r("<b> Department: </b>".$sdept."<br>");
              print_r("<b> Batch: </b>".$batch);
            ?>
          </span>

          <?php
          $query = mysqli_query($conn, "select st_id,st_name from students where st_dept= '$sdept' and st_batch='$batch';");
    
          $students = [];
          $dept_subjects=[];
          $stdcount = mysqli_num_rows($query);
          // print_r($stdcount);

          $getsubjects= mysqli_query($conn,"select tc_course from teachers where tc_dept='$sdept';");
          $subcount = mysqli_num_rows($getsubjects);
          //print_r($getsubjects);
          //print_r($subcount);
          //echo $stdcount."<br>".$subcount."<br>";
          for($i = 1; $i <= $stdcount; $i++) {
            $row = mysqli_fetch_array($query, MYSQLI_NUM);
            //print_r($row);
            $stdata = [];
            array_push($stdata, $row[0], $row[1]);// Need to be checked
            $allsub_present = 0;
            $allsub_total = 0;
            // $idary = array("Registration id",$sr_id);
            // array_push($stdata,$idary);
            
            for($j = 1; $j <= $subcount; $j++){
              $ro = mysqli_fetch_array($getsubjects,MYSQLI_NUM);
              $all_query = mysqli_query($conn, "select count(*) as countP from attendance where attendance.stat_id='$row[0]' and attendance.course = '$ro[0]' and attendance.st_status='Present';");
              $singleT= mysqli_query($conn, "select count(*) as countT from attendance where attendance.stat_id='$row[0]' and attendance.course = '$ro[0]';");
              $presentcountarray = mysqli_fetch_array($all_query,MYSQLI_NUM);
              $totalarray = mysqli_fetch_array($singleT,MYSQLI_NUM);
              $presentcount = $presentcountarray[0];
              $total = $totalarray[0];
              // print_r($presentcountarray);
              if($i == 1) {
                array_push($dept_subjects, $ro[0]);
              }
              // print_r($ro[0]);
               //print_r($presentcount);
                             
              $allsub_present = $allsub_present + $presentcount;
              $allsub_total = $allsub_total + $total;
              $setv = strval($presentcount) ."/". strval($total);
              array_push($stdata, $setv);
              // print_r($setv);
              //print_r($allsub_total);
            }
            array_push($stdata, round(($allsub_present / $allsub_total * 1.0) * 100,2)."%");

            array_push($students, $stdata);
            $getsubjects= mysqli_query($conn,"select tc_course from teachers where tc_dept='$sdept';");
          }
          //print_r($students);
         }
       //  print_r($students[0]);
    ?>

  </center>
  <div style="padding: 2%;">
    <table class="table table-hover table-bordered">
      <tbody>
        <tr>
          <th>Registration id</th>
          <th>Name</th>
          <?php 
            foreach($dept_subjects as $subj) {
              echo "<th>".
                $subj
              ."</th>";
            }
          ?>
          <th>Overall Percentage</th>
        </tr>
        <?php
          for($it = 0; $it < $stdcount; $it++){
            foreach($students[$it] as $stu){ 
              echo "<td>".$stu."</td>";
            }
            echo"<tr>"."</tr>";
          }
          
        ?>

        
      </tbody>
    </table>
</div>
<center><button class="b1 btn btn-primary" onclick="clicked()">Print</button></center>
<script>
  function clicked(){
    window.print();
  }
</script>
</body>
</html>
