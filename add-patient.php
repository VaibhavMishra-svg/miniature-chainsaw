<?php
session_start();
include_once("helpers/db.php");
if(!isset($_SESSION['username'])){
        header("Location: login.php");
     }
$page_title = "Add patient";
include("inc/header.php");


if(isset($_POST['submit'])){
    $name = $_POST['fullname'];
    $sex = $_POST['sex'];
    $dob = $_POST['dob'];
    $bgroup = $_POST['bgroup'];
    $phone = $_POST['phone'];
    $staff_id = $_SESSION['id'];
    $query = "INSERT INTO `patient` (`id`, `name`, `sex`, `dob`, `phone`, `blood_group`, `staff_id`) VALUES (NULL, '$name', '$sex', '$dob', '$phone', '$bgroup', '$staff_id')";
    
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
              <label for="fullname">Fullname</label>
              <input type="text" name="fullname" id="fullname" class="form-control" required>
              <label for="sex">Sex</label>
              <select name="sex" id="sex" class="form-control p-2">
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
              </select>
              <label for="dob">Date of birth</label>
              <input type="date" name="dob" id="dob" class="form-control" required>
              <label for="bgroup">Blood Group</label>
              <select name="bgroup" id="bgroup" class="form-control p-2">
                  <option value="A+">A+</option>
                  <option value="A-">A-</option>
                  <option value="B+">B+</option>
                  <option value="B-">B-</option>
                  <option value="AB+">AB+</option>
                  <option value="AB-">AB-</option>
                  <option value="O+">O+</option>
                  <option value="O-">O-</option>
              </select>
              <label for="phone">Phone Number</label>
              <input type="text" name="phone" id="phone" class="form-control" maxlength="10" pattern="[1-9]{1}[0-9]{9}" required><br>
              <input type="submit" class="btn btn-primary" name="submit">
      </div>
          </form>
<?php
include_once("inc/bootstrap.php");
include_once("inc/footer.php");
?>
