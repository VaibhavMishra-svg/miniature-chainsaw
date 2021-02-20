<?php
session_start();
include_once("helpers/db.php");
if(!isset($_SESSION['username'])){
        header("Location: login.php");
     }
$page_title = "Admit";
include("inc/header.php");

if(isset($_POST['submit'])){
    $patient = $_POST['patient'];
    $dept = $_POST['department'];
    $doctor = $_POST['doctor'];
    $problem = $_POST['problem'];
    $addate = $_POST['admitdate'];
    //$disdate = $_POST['dischargedate'];
    $advance = $_POST['advance'];
    $roomnum = $_POST['roomno'];
    $query = "INSERT INTO `admit` (`id`, `problem`, `admit_date`, `patient_id`, `department_id`, `doctor_id`, `room_number`) VALUES (NULL, '$problem', '$addate', '$patient', '$dept', '$doctor','$roomnum')";
    $room_status = "update room set status = 0 where number=$roomnum";
    
    if(mysqli_query($con,$query)){
        $admitid = mysqli_insert_id($con);
        $billquery="INSERT INTO `billing` (`admit_id`, `advance`) VALUES ($admitid, $advance)";
        if(mysqli_query($con,$billquery) and mysqli_query($con,$room_status)){
            $msg="Added successfully!";
        }else{
            $msg = "Billing or room allocation error";
        }
    }else{
        $msg="Some error occured!";
    }
}

?>

<link rel="stylesheet" href="assets/css/custom.css">

</head>
<body class="text-center">
<?php include("inc/menu.php"); ?>
<form class="container" method="post">
<!--      <img class="mb-4" src="../../assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">-->
      <h1 class="h3 mb-3 font-weight-normal"><?php echo $page_title;?></h1>
      <?php
            if(isset($msg)){
               echo "<div class='alert alert-warning' role='alert'>".$msg."</div>";
            }
      ?>
      <div class="form-control">
             <div class="row">
             <div class="col-md-6">
              <label for="patient">Patient name</label>
              <select name="patient" id="patient" class="form-control p-2">
                  <?php
                    $patient_query = "SELECT * from patient";
                    $query_run = mysqli_query($con,$patient_query);
                    while($patient_data = mysqli_fetch_array($query_run)){
                        ?>
                        <option value="<?php echo $patient_data['id']?>"><?php echo $patient_data['name']?></option>
                        <?php
                    }
                  ?>
              </select>
              <label for="department">Department</label>
              <select name="department" id="department" class="form-control p-2">
                  <?php
                    $dept_query = "SELECT * from department";
                    $query_run = mysqli_query($con,$dept_query);
                    while($dept_data = mysqli_fetch_array($query_run)){
                        ?>
                        <option value="<?php echo $dept_data['id'];?>"><?php echo $dept_data['name']?></option>
                        <?php
                    }
                  ?>
              </select>
              <label for="doctor">Doctor</label>
                <select name="doctor" id="doctor" class="form-control">
                    
                </select>
<!--              <input type="text" name="doctor" id="doctor" class="form-control" required>-->
              <label for="problem">Problem</label>
              <input type="text" name="problem" id="problem" class="form-control" required>
              </div>
              <div class="col-md-6">
              <label for="admitdate">Admit date</label>
              <input type="date" name="admitdate" id="admitdate" class="form-control" value="<?php echo date("Y-m-d");?>" max="<?php echo date("Y-m-d");?>" required>
<!--
              <label for="dischargedate">Discharge date</label>
              <input type="date" name="dischargedate" id="dischargedate" class="form-control" required>    
-->
            <label for="advance">Advance amount</label>
              <input type="text" name="advance" id="advance" class="form-control" required>
            <div class="row">
                <div class="col-md-6">
                    <label for="roomtype">Room type</label>
              <select name="roomtype" id="roomtype" class="form-control p-2">
                  <?php
                    $room_query = "SELECT distinct type from room";
                    $query_run = mysqli_query($con,$room_query);
                    while($room_data = mysqli_fetch_array($query_run)){
                        ?>
                        <option value="<?php echo $room_data['type'];?>"><?php if($room_data['type']==1){
                            echo "General";}elseif($room_data['type']==2){echo "ICU";}elseif($room_data['type']==3){echo "Emergency";} ?></option>
                        <?php
                    }
                  ?>
              </select>
                </div>
                <div class="col-md-6">
                    <label for="roomno">Room no.</label>
              <select name="roomno" id="roomno" class="form-control">
                    
                </select>
                </div>
            </div>
             </div>
             </div><br>
              <input type="submit" class="btn btn-primary" name="submit">
      </div>
          </form>


<?php
include_once("inc/bootstrap.php");
    ?>
<script>
$("#department").bind("click", function(e){
    $url = "http://localhost/dbms/helpers/doctor_fetch.php?searchTerm=" + $("#department").val(),
    fetch($url).then(response => {
  return response.json();
}).then(data => {
  //$("#doctor").val(data[0]['text'].toUpperCase());
        var row=0;
        $('#doctor').html("");
        while(row < data.length){
            
            $('#doctor').append('<option value="'+data[row]["id"]+'">'+data[row]["text"]+'</option>');
            row+=1;
        }
}).catch(err => {
  //errors here
});
});
$("#roomtype").bind("click", function(e){
    $url = "http://localhost/dbms/helpers/free_room_fetch.php?searchTerm=" + $("#roomtype").val(),
    fetch($url).then(response => {
  return response.json();
}).then(data => {
  //$("#doctor").val(data[0]['text'].toUpperCase());
        var row=0;
        $('#roomno').html("");
        while(row < data.length){
            $('#roomno').append('<option value="'+data[row]["roomno"]+'">'+data[row]["roomno"]+'</option>');
            row+=1;
        }
}).catch(err => {
  //errors here
});
});
</script>
    <?php
include_once("inc/footer.php");
?>