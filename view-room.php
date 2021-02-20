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
            <th>Room number</th>
            <th>Type</th>
            <th>Rent</th>
            <th>Status</th>
        </tr>
        <?php
        $query = "SELECT * FROM room";
        $query_run=mysqli_query($con,$query);
        while($data = mysqli_fetch_array($query_run)){
            $type_code = $data['type'];
            $status_code = $data['status'];
            if($type_code==1){
                $type = "General Ward";
            }elseif($type_code==2){
                $type = "ICU";
            }elseif($type_code==3){
                $type = "Emergency";
            }
            if($status_code == 1){
                $status = "<span class='text-success'><b>Vacant</b></span>";
            } else{
                $status = "<span class='text-danger'><b>Allocated</b></span>";
            }
            ?>
            <tr>
                <td><?php echo $data['number']?></td>
                <td><?php echo $type ?></td>
                <td><?php echo $data['rent'] ?></td>
                <td><?php echo $status ?></td>
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
