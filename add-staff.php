<?php
session_start();
include_once("helpers/db.php");
if(!isset($_SESSION['username'])){
        header("Location: login.php");
     }
$page_title = "Add staff";
include("inc/header.php");

if(isset($_POST['submit'])){
    $name = $_POST['fullname'];
    $type = $_POST['type'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $query = "INSERT INTO `staff` (`id`, `staff_name`, `username`, `password`, `mobile_number`, `address`, `type`, `dob`) VALUES (NULL, '$name', '$username', '$password', '$phone', '$address', '$type', '$dob')";
    
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
              <label for="username">Username</label>
              <input type="text" name="username" id="username" class="form-control" required>
              <label for="password">Password</label>
              <input type="password" name="password" id="password" class="form-control" required>
              <label for="type">Type</label>
              <select name="type" id="type" class="form-control p-2">
                  <option value="admin">Admin</option>
                  <option value="viewer">Viewer</option>
              </select>
              <label for="dob">Date of birth</label>
              <input type="date" name="dob" id="dob" class="form-control" max="2000-01-01" required>
              <label for="address">Address</label>
              <input type="text" name="address" id="address" class="form-control" required>
              <label for="phone">Phone Number</label>
              <input type="text" name="phone" id="phone" class="form-control" required maxlength="10" pattern="[1-9]{1}[0-9]{9}"><br>
              <input type="submit" class="btn btn-primary" name="submit">
      </div>
          </form>
<?php
include_once("inc/bootstrap.php");
include_once("inc/footer.php");
?>
