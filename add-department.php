<?php
session_start();
include_once("helpers/db.php");
if(!isset($_SESSION['username'])){
        header("Location: login.php");
     }
$page_title = "Add Department";
include("inc/header.php");

if(isset($_POST['submit'])){
    $dept = $_POST['dept'];
    
    $query = "INSERT INTO `department` (`id`, `name`) VALUES ('NULL', '$dept')";
    
    if(mysqli_query($con,$query)){
        $msg="Added successfully!";
    }else{
        $msg="Some error occured!";
    }
}
?>

<link rel="stylesheet" href="assets/css/custom.css">

</head>
<body class="text-center">
<?php include("inc/menu.php"); ?>
<form class="form-signin" method="post">
<!--      <img class="mb-4" src="../../assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">-->
      <h1 class="h3 mb-3 font-weight-normal"><?php echo $page_title;?></h1>
      <?php
            if(isset($msg)){
               echo "<div class='alert alert-warning' role='alert'>".$msg."</div>";
            }
      ?>
      <div class="form-control">
              <label for="dept">Department name</label>
              <input type="text" name="dept" id="dept" class="form-control" required><br>
              <input type="submit" class="btn btn-primary" name="submit">
      </div>
          </form>
<?php
include_once("inc/bootstrap.php");
include_once("inc/footer.php");
?>
