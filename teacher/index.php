<?php

ob_start();
session_start();

if($_SESSION['name']!='oasis')
{
  header('location: ../index.php');
}

include('connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Attendance Management System</title>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../css/main.css">
<link rel="stylesheet" href="../css/footerStyles.css">

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
<h3>Welcome teacher
	<?php
		$teacher = $_SESSION['teacherName'];
		$teacherNameQuery = mysqli_query($conn, "select tc_name from teachers where tc_uname = '$teacher';");
		$row = mysqli_fetch_array($teacherNameQuery, MYSQLI_NUM);
		echo $row[0];
		

?></h3>
<div class="row">
    <div class="content">
    <img src="../img/att.png" width="100px" />

  </div>

</div>

</center>

<footer>
  <div>© 2023 | Rise Krishna Sai Prakasam CSE Students.</div>
  <a href="feedback.html" style="text-decoration:none; color:white;">Feedback</a>
</footer>

</body>
</html>
