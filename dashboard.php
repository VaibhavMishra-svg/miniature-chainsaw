<?php
session_start();
include_once("helpers/db.php");
$page_title = "Dashboard";
include("inc/header.php");
if(!isset($_SESSION['username'])){
        header("Location: login.php");
     }
?>

<link rel="stylesheet" href="assets/css/custom.css">

</head>
<body class="text-center">
<?php include("inc/menu.php"); ?>
<br>
<div class="container">
<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">Healthcare Management System</h4>
    <p>This is our DBMS project which is a healthcare management system. The group members are:</p>
  <p>Akshat Bhanchawat | Sarthak Surana | Chinmay Kalvade | Aarthi | Swetasri</p>
  <hr>
    <p class="mb-0">Sincere thanks to <b>Prof. P. Gayathri</b> for her guidance and suggestions.</p>
</div></div>
<?php
include_once("inc/bootstrap.php");
include_once("inc/footer.php");
?>
