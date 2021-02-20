<?php
session_start();
include_once("helpers/db.php");
if(!isset($_SESSION['username'])){
        header("Location: login.php");
     }
$page_title = "View Appointments";
include("inc/header.php");

?>


<link rel="stylesheet" href="assets/css/custom.css">

</head>
<body class="text-center">
<?php include("inc/menu.php"); ?>
<div class="container">
 <br><br>
    <?php
            if(isset($msg)){
               echo "<div class='alert alert-warning' role='alert'>".$msg."</div>";
            }
      ?>
    <table class="table">
        <tr>
            <th>Patient's name</th>
            <th>Mobile no.</th>
            <th>Doctor</th>
            <th>Problem</th>
            <th>Appointment date</th>
            <th>Time</th>
        </tr>
        <?php
        $query = "SELECT * FROM doc_appointment";
        $query_run=mysqli_query($con,$query);
        while($data = mysqli_fetch_array($query_run)){
            $patient_id = $data['patient_id'];
            $doctor_id = $data['doctor_id'];
            $pquery = mysqli_query($con,"select name,phone from patient where id=$patient_id");
//            echo $pquery;
            $patient_data = mysqli_fetch_array($pquery);
            $dquery = mysqli_query($con,"select name from doctor where id=$doctor_id");
            $doctor_data = mysqli_fetch_array($dquery);
            ?>
            <tr>
                <td><?php echo $patient_data['name']?></td>
                <td><?php echo $patient_data['phone']?></td>
                <td><?php echo $doctor_data['name']?></td>
                <td><?php echo $data['symptom']?></td>
                <td><?php echo $data['date']?></td>
                <td><?php echo $data['time']?></td>
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
