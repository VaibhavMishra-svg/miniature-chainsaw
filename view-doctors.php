<?php
session_start();
include_once("helpers/db.php");
if(!isset($_SESSION['username'])){
        header("Location: login.php");
     }
$page_title = "View doctors";
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
            <th>Doctors's name</th>
            <th>Mobile no.</th>
            <th>Depatment</th>
            <th>Work hours</th>
        </tr>
        <?php
        $query = "SELECT * FROM doctor";
        $query_run=mysqli_query($con,$query);
        while($data = mysqli_fetch_array($query_run)){
            $dept_id = $data['department_id'];
            $dept_details = mysqli_fetch_array(mysqli_query($con, "SELECT name from department where id=$dept_id"));
            $dept_name = $dept_details['name'];
            ?>
            <tr>
                <td><?php echo $data['name']?></td>
                <td><?php echo $data['phone_number'] ?></td>
                <td><?php echo $dept_name?></td>
                <td><?php echo $data['work_time']?></td>
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
