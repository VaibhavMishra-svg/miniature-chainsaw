<?php
session_start();
include_once("helpers/db.php");
if(!isset($_SESSION['username'])){
        header("Location: login.php");
     }
$page_title = "View Appointments";
include("inc/header.php");


if(isset($_GET['markPaid'])){
    $paid_id = $_GET['markPaid'];
    if(mysqli_query($con,"UPDATE billing SET status=1 where appointment_id=$paid_id")){
        $msg = "Marked as paid";
    }else{
        $msg = "Error!";
    }
    
}

?>


<link rel="stylesheet" href="assets/css/custom.css">

</head>
<body class="text-center">
<?php include("inc/menu.php"); ?>
<div class="container">
 <br>
  <div class="btn-group" role="group">
  <a href="?viewunpaid=0" class="btn btn-primary">Unpaid</a>
  <a href="?viewunpaid=1" class="btn btn-primary">View all</a>
    </div><br><br>
    <?php
            if(isset($msg)){
               echo "<div class='alert alert-warning' role='alert'>".$msg."</div>";
            }
      ?>
    <table class="table">
        <tr>
            <th>Patient's name</th>
            <th>Problem</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
        <?php
            if(isset($_GET['viewunpaid']) and $_GET['viewunpaid']==0){
                $query = "SELECT * FROM billing where status=0 and appointment_id is not NULL"; //0 is unpaid, 1 is paid
            } else{
                $query = "SELECT * FROM billing where appointment_id is not NULL";
            }
        $query_run=mysqli_query($con,$query);
        while($data = mysqli_fetch_array($query_run)){
            $app_id = $data['appointment_id'];
//            $patient = "SELECT name FROM patient where id=(SELECT patient_id FROM admit where id=$admit_id)"
            $patient = mysqli_fetch_array(mysqli_query($con,"SELECT patient_id,symptom FROM doc_appointment where id=$app_id"));
            $patient_id = $patient['patient_id'];
            $total = $data['total'];
            $problem = $patient['symptom'];
            $status = $data['status'];
            $pquery = mysqli_query($con,"select name from patient where id=$patient_id");
//            echo $pquery;
            $patient_data = mysqli_fetch_array($pquery);
//            $dquery = mysqli_query($con,"select name from doctor where id=$doctor_id");
//            $doctor_data = mysqli_fetch_array($dquery);
            ?>
            <tr>
                <td><?php echo $patient_data['name'];?></td>
                <td><?php echo $problem; ?></td>
                <td><?php echo $total;?></td>
                <td><?php if($status==0){ echo "<span class='text-danger'><b>Unpaid</b></span> <a href='appointment-billing.php?markPaid=$app_id' class='btn btn-success btn-sm'>Mark paid</a>"; }else{ echo "<span class='text-success'><b>Paid</b></span>";} ?> </td>
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
