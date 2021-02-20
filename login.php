<?php
session_start();
ob_start();
include_once("helpers/db.php");
$page_title = "Login";
include("inc/header.php");
    if(isset($_SESSION['username'])){
        header("Location: dashboard.php");
    }
if(isset($_POST['username'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $query = "SELECT * FROM staff WHERE username = '$username' and password = '$password'";
        $query_run = mysqli_query($con,$query);
        // $num = mysqli_num_rows($query_run);
        $num = mysqli_num_rows($query_run);
    if($num>0){
            $row = mysqli_fetch_array($query_run);
            $db_username = $row['username'];
            $db_id = $row['id'];
            $db_role = $row['type'];
            $_SESSION['username'] = $db_username;
            $_SESSION['id'] = $db_id;
            $_SESSION['role'] = $db_role;
        if($db_role=='viewer'){
            header("Location: viewer.php");
        }else{
           header("Location: dashboard.php");
            }
    }
    else{
            $error_msg = "Wrong credentials";
        //echo "Some error!";
        }
}
?>

<style>
html,


body {
  /* display: -ms-flexbox; */
  /* display: flex; */
  -ms-flex-align: center;
  align-items: center;
  padding-top: 40px;
  padding-bottom: 40px;
  background-image: linear-gradient(180deg,pink 49%,white 99%);
  height:100%;
}

.form-signin {
  width:auto;
  max-width: 330px;
  padding: 15px;
  margin: auto; background-color: white;
  color:black;
  box-shadow:1px 10px 10px 10px white;
}
.form-signin .checkbox {
  font-weight: 400; background-color: blue;
}
.form-signin .form-control {
  position: relative;
  box-sizing: border-box;
  height: auto;
  padding: 10px;
  font-size: 16px;
  background-color: blue;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
</style>
<link rel="stylesheet" href="assets/css/bootstrap.min.css">

</head>
<body class="text-center">
<form class="form-signin" method="post" action="">
<!--      <img class="mb-4" src="../../assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">-->
      <h1 class="h3 mb-3 font-weight-normal"><?php echo $page_title;?></h1>
      <?php
            if(isset($error_msg)){
               echo "<div class='alert alert-danger' role='alert'>".$error_msg."</div>";
            }
      ?>
      <label for="inputEmail" class="sr-only">Username</label>
      <input type="text" id="inputEmail" class="form-control" placeholder="Username" name="username" required autofocus>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required>
      <input class="btn btn-lg btn-primary btn-block" type="submit" name="login" value="Login">
      <p class="mt-5 mb-3 text-muted">&copy; 2018</p>
    </form>
<?php
include_once("inc/bootstrap.php");
include_once("inc/footer.php");
?>