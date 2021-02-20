<?php
session_start();
include_once("helpers/db.php");
if(!isset($_SESSION['username'])){
        header("Location: login.php");
     }
$page_title = "Admit details";
include("inc/header.php");

$admit_id = $_GET['admitid'];

if(isset($_POST['submit'])){
    $others = $_POST['others'];
    $room_query = mysqli_fetch_array(mysqli_query($con,"SELECT room_charges from billing where admit_id=$admit_id"));
    $roomcharges = $room_query['room_charges'];
    $total = $others + $roomcharges;
    
    
    $query = "UPDATE billing set total=$total where admit_id=$admit_id";
    
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
              <label for="others">Other dues</label>
              <input type="text" name="others" id="others" class="form-control" value="<?php echo $_GET['charges']?>" required>
              <br>
              <input type="submit" class="btn btn-primary" name="submit"> <a href="admit-billing.php" class="btn btn-dark">Back</a>
      </div>
          </form>

<?php
include_once("inc/bootstrap.php");
include_once("inc/footer.php");
?>
