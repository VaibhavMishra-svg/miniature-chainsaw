<?php
session_start();
include_once("helpers/db.php");
if(!isset($_SESSION['username'])){
        header("Location: login.php");
     }
$page_title = "View all patients";
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
            <th>Patient's name</th>
            <th>Mobile no.</th>
            <th>Sex</th>
            <th>Date of birth</th>
            <th>Blood group</th>
            <th>Added by</th>
        </tr>
        <?php
        $query = "SELECT * FROM patient";
        $query_run=mysqli_query($con,$query);
        while($data = mysqli_fetch_array($query_run)){
            $staff_id = $data['staff_id'];
            $staff_details = mysqli_fetch_array(mysqli_query($con, "SELECT staff_name from staff where id=$staff_id"));
            $staff_name = $staff_details['staff_name'];
            ?>
            <tr>
                <td><?php echo $data['name']?></td>
                <td><?php echo $data['phone'] ?></td>
                <td><?php echo $data['sex']?></td>
                <td><?php echo $data['dob']?></td>
                <td><?php echo $data['blood_group']?></td>
                <td><?php echo $staff_name?></td>
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
