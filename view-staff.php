<?php
session_start();
include_once("helpers/db.php");
if(!isset($_SESSION['username'])){
        header("Location: login.php");
     }
$page_title = "View all staff";
include("inc/header.php");

?>


<link rel="stylesheet" href="assets/css/custom.css">

</head>
<body class="text-center">
<?php include("inc/menu.php"); ?>
<div class="container">
 <br><br>
    <table class="table">
        <tr>
            <th>Name</th>
            <th>Username</th>
            <th>Type</th>
            <th>Date of birth</th>
            <th>Address</th>
            <th>Phone number</th>
        </tr>
        <?php
        $query = "SELECT * FROM staff";
        $query_run=mysqli_query($con,$query);
        while($data = mysqli_fetch_array($query_run)){
            ?>
            <tr>
                <td><?php echo $data['staff_name']?></td>
                <td><?php echo $data['username'] ?></td>
                <td><?php echo $data['type']?></td>
                <td><?php echo $data['dob']?></td>
                <td><?php echo $data['address']?></td>
                <td><?php echo $data['mobile_number']?></td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>
<?php
include_once("inc/bootstrap.php");
include_once("inc/footer.php");
?>
