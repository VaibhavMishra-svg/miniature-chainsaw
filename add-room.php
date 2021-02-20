<?php

/* Definitions
Rooms:
    1: General Ward
    2: ICU
    3: Emergency
*/


$page_title = "Add room";
include("inc/header.php");
session_start();
include_once("helpers/db.php");
if(!isset($_SESSION['username'])){
        header("Location: login.php");
     }

if(isset($_POST['submit'])){
    $number = $_POST['number'];
    $type = $_POST['type'];
    $rent = $_POST['rent'];
    
    $query = "INSERT INTO `room` (`number`, `type`, `rent`) VALUES ('$number', '$type', '$rent')";
    
    if(mysqli_query($con,$query)){
        $msg="Added successfully!";
    }else{
        $msg="Some error occured!";
    }
}

?>

<link rel="stylesheet" href="assets/css/custom.css">

</head>
<body>
<div class="row">
<div class="col-md-12">
<?php include("inc/menu.php"); ?>
</div></div>
<div class="row">
<form class="form-signin text-center" method="post">
<!--      <img class="mb-4" src="../../assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">-->
      <h1 class="h3 mb-3 font-weight-normal"><?php echo $page_title;?></h1>
      <?php
            if(isset($msg)){
               echo "<div class='alert alert-warning' role='alert'>".$msg."</div>";
            }
      ?>
      <div class="form-control">
              <label for="number">Room no.</label>
              <input type="text" name="number" id="number" class="form-control" required autofocus>
<!--
              <label for="type">Type</label>
              <input type="text" name="type" id="type" class="form-control" required>
-->
              <label for="">Room type</label>
              <select class="form-control p-2" name="type">
        <option value="1">General Ward</option>
        <option value="2">ICU</option>
        <option value="3">Emergency</option>
        
      </select>
             <label for="rent">Rent</label>
              <input type="text" name="rent" id="rent" class="form-control" required>
             <br>
              <input type="submit" class="btn btn-primary" name="submit">
      </div>
          </form>
          </div>
<?php
include_once("inc/bootstrap.php");
include_once("inc/footer.php");
?>
