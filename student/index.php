<?php

ob_start();
session_start();

if($_SESSION['name']!='oasis')
{
  header('location: ../index.php');
}

include("connect.php");
?>

<!DOCTYPE html>
<html lang="en">

<!-- head started -->
<head>
<title>Attendance Management System</title>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../css/main.css">

  <style>
		footer{
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
			height: 100px;
			width: 100%;
			color: white;
			background-color: black;
			position: fixed;
			bottom: 0;
			line-height: 30px;
		}
	</style>

</head>
<!-- head ended -->

<!-- body started -->
<body>

<!-- Menus started-->
<header>

  <h1>Attendance Management System</h1>
  <div class="navbar">
  <a href="index.php" style="text-decoration:none; font-size: 17px;">Home</a>
  <a href="students.php" style="text-decoration:none; font-size: 17px;">Students</a>
  <a href="report.php" style="text-decoration:none; font-size: 17px;">Report Section</a>
  <a href="../logout.php" style="text-decoration:none; font-size: 17px;">Logout</a>

</div>

</header>
<!-- Menus ended -->

<center>
<h3>Welcome 
	<?php
		$student = $_SESSION['studentName'];
		$studentNameQuery = mysqli_query($conn, "select st_name from students where st_uname = '$student';");
		$row = mysqli_fetch_array($studentNameQuery, MYSQLI_NUM);
		echo $row[0];
		

?></h3>
<!-- Content, Tables, Forms, Texts, Images started -->
<div class="row">
    <div class="content">
    
    <img src="../img/att.png" width="100px" />

  </div>

</div>
<!-- Contents, Tables, Forms, Images ended -->

</center>

<footer>
  <div>© 2023 | Rise Krishna Sai Prakasam CSE Students.</div>
  <a href="feedback.html" style="text-decoration:none; color:white;">Feedback</a>
</footer>

</body>
<!-- Body ended  -->

</html>
