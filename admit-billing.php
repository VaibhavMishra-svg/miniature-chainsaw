<?php
session_start();
include_once("helpers/db.php");
if(!isset($_SESSION['username'])){
        header("Location: login.php");
     }
$page_title = "View Admitted";
include("inc/header.php");

if(isset($_POST['submit'])){
    $name = $_POST['fullname'];
    $type = $_POST['type'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $query = "INSERT INTO `staff` (`id`, `staff_name`, `username`, `password`, `mobile_number`, `address`, `type`) VALUES (NULL, '$name', '$username', '$password', '$phone', '$address', '$type')";
    
    if(mysqli_query($con,$query)){
        $msg="Added successfully!";
    }else{
        $msg="Some error occured!";
    }
    
}

//if(isset($_GET['discharge'])){
//    $date=date("Y-m-d");
//    echo $date;
//    $dadmit_id = $_GET['discharge'];
//    echo $dadmit_id;
//    $details = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM admit where id=$dadmit_id"));
//    $discharge_date_query = "UPDATE admit SET discharge_date='$date' where id=$dadmit_id";//////
//    $room = $details['room_number'];
//    echo $room;
//    $room_free_query = "UPDATE room SET status=1 where number=$room";///////
//    $no_of_days = date_diff(date_create("2018-10-30"),date_create($date));
//    echo " -- ".$no_of_days->format("%a")."  --  ";
//    $room_rent = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM room where number=$room"));
//    $room_rent_amt = $room_rent['rent'] * $no_of_days->format("%a");
//    echo $room_rent_amt;
//    $add_room_charges = "UPDATE billing SET room_charges=$room_rent_amt where admit_id=$dadmit_id";////////
//    $discharge_status = "UPDATE admit SET status = 0 where id=$dadmit_id";/////// 0 means discharged, 1 means admitted
//    
//    // Running everything
//    
//    if(mysqli_query($con,$room_free_query) and mysqli_query($con,$discharge_status) and mysqli_query($con,$discharge_date_query) and mysqli_query($con,$add_room_charges)){
//        $msg = "Patient discharged successfully";
//    } else{
//        $msg = "Some error!";
//    }
//    
//}
if(isset($_GET['markPaid'])){
    $paid_id = $_GET['markPaid'];
    if(mysqli_query($con,"UPDATE billing SET status=1 where admit_id=$paid_id")){
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
            <th>Room charges</th>
            <th>Advance</th>
            <th>Other charges</th>
            <th>Total</th>
            <th>Due</th>
            <th>Status</th>
<!--            <th>Other amount</th>-->
        </tr>
        <?php
            if(isset($_GET['viewunpaid']) and $_GET['viewunpaid']==0){
                $query = "SELECT * FROM billing where status=0 and admit_id is not NULL"; //0 is unpaid, 1 is paid
            } else{
                $query = "SELECT * FROM billing where admit_id is not NULL";
            }
        $query_run=mysqli_query($con,$query);
        while($data = mysqli_fetch_array($query_run)){
            $admit_id = $data['admit_id'];
//            $patient = "SELECT name FROM patient where id=(SELECT patient_id FROM admit where id=$admit_id)"
            $patient = mysqli_fetch_array(mysqli_query($con,"SELECT patient_id FROM admit where id=$admit_id"));
            $patient_id = $patient['patient_id'];
            $room_charges = $data['room_charges'];
            $advance = $data['advance'];
            $total = $data['total'];
            $due = $total - $advance;
            if(isset($total)){
                $other_charges = $total - $room_charges;
                $due = $total - $advance;
            }else{
                $other_charges = 0;
                $due = $room_charges - $advance;
            }
            $status = $data['status'];
            $pquery = mysqli_query($con,"select name from patient where id=$patient_id");
//            echo $pquery;
            $patient_data = mysqli_fetch_array($pquery);
//            $dquery = mysqli_query($con,"select name from doctor where id=$doctor_id");
//            $doctor_data = mysqli_fetch_array($dquery);
            ?>
            <tr>
                <td><?php echo $patient_data['name'];?></td>
                <td><?php echo $room_charges;?></td>
                <td><?php echo $advance;?></td>
                <td><?php echo $other_charges."  "; if($status==0){ echo "<a href='admit-bill.php?admitid=$admit_id&charges=$other_charges' class='btn btn-dark btn-sm'>Edit</a>";}?></td>
                <td><?php echo $total;?></td>
                <td><?php if($status==0){echo $due;} else {echo "0";}?></td>
                <td><?php if($status==0){ echo "<span class='text-danger'><b>Unpaid</b></span> <a href='admit-billing.php?markPaid=$admit_id' class='btn btn-success btn-sm'>Mark paid</a>"; }else{ echo "<span class='text-success'><b>Paid</b></span>";} ?> </td>
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
