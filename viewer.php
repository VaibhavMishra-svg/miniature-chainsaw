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

if(isset($_GET['discharge'])){
    $date=date("Y-m-d");
    echo $date;
    $dadmit_id = $_GET['discharge'];
    echo $dadmit_id;
    $details = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM admit where id=$dadmit_id"));
    $discharge_date_query = "UPDATE admit SET discharge_date='$date' where id=$dadmit_id";//////
    $room = $details['room_number'];
    echo $room;
    $room_free_query = "UPDATE room SET status=1 where number=$room";///////
    $no_of_days = date_diff(date_create("2018-10-30"),date_create($date));
    echo " -- ".$no_of_days->format("%a")."  --  ";
    $room_rent = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM room where number=$room"));
    $room_rent_amt = $room_rent['rent'] * $no_of_days->format("%a");
    echo $room_rent_amt;
    $add_room_charges = "UPDATE billing SET room_charges=$room_rent_amt where admit_id=$dadmit_id";////////
    $discharge_status = "UPDATE admit SET status = 0 where id=$dadmit_id";/////// 0 means discharged, 1 means admitted
    
    // Running everything
    
    if(mysqli_query($con,$room_free_query) and mysqli_query($con,$discharge_status) and mysqli_query($con,$discharge_date_query) and mysqli_query($con,$add_room_charges)){
        $msg = "Patient discharged successfully";
    } else{
        $msg = "Some error!";
    }
    
    
}

?>


<link rel="stylesheet" href="assets/css/custom.css">

</head>
<body class="text-center">
<div class="container">
 <br>
  <div class="btn-group" role="group">
  <a href="?viewadmit=1" class="btn btn-primary">Admitted</a>
  <a href="?viewadmit=0" class="btn btn-primary">View all</a>
  <a href="logout.php" class="btn btn-primary">Logout</a>
    </div><br><br>
    <?php $view_admit_query = "SELECT * FROM admit where status=1";
        $view_all_query = "SELECT * FROM admit";
    ?> <br>
    <?php
            if(isset($msg)){
               echo "<div class='alert alert-warning' role='alert'>".$msg."</div>";
            }
      ?>
    <table class="table">
        <tr>
            <th>Patient's name</th>
            <th>Mobile no.</th>
            <th>Room</th>
            <th>Doctor</th>
            <th>Admit date</th>
            <?php if(isset($_GET['viewadmit']) and $_GET['viewadmit']==1){ ?><th>Discharge</th><?php } elseif(isset($_GET['viewadmit']) and $_GET['viewadmit']==0){ ?><th>Discharge date</th><?php } ?>
        </tr>
        <?php
            if(isset($_GET['viewadmit']) and $_GET['viewadmit']==1){
                $query = "SELECT * FROM admit where status=1";
            } else{
                $query = "SELECT * FROM admit";
            }
        $query_run=mysqli_query($con,$query);
        while($data = mysqli_fetch_array($query_run)){
            $patient_id = $data['patient_id'];
            $room_number = $data['room_number'];
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
                <td><?php echo $room_number?></td>
                <td><?php echo $doctor_data['name']?></td>
                <td><?php echo $data['admit_date']?></td>
                <?php if(isset($_GET['viewadmit']) and $_GET['viewadmit']==1){ ?><td><a href="?discharge=<?php echo $data['id'];?>" class="btn btn-danger btn-sm">Discharge</a></td><?php } elseif(isset($_GET['viewadmit']) and $_GET['viewadmit']==0) { ?><td><?php echo $data['discharge_date'];?></td><?php } ?>
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
