<?php
session_start();
include_once("helpers/db.php");
if(!isset($_SESSION['username'])){
        header("Location: login.php");
     }
$page_title = "Appointment";
include("inc/header.php");

if(isset($_POST['submit'])){
    $patient = $_POST['patient'];
    $dept = $_POST['department'];
    $doctor = $_POST['doctor'];
    $problem = $_POST['problem'];
    $apdate = $_POST['appointmentdate'];
    $aptime = $_POST['appointmenttime'];
    $advance = $_POST['advance'];
    $query = "INSERT INTO `doc_appointment` (`id`, `symptom`, `date`, `time`, `patient_id`, `department_id`, `doctor_id`) VALUES (NULL, '$problem', '$apdate', '$aptime', '$patient', '$dept', '$doctor')";
    
    if(mysqli_query($con,$query)){
        $appointmentid = mysqli_insert_id($con);
        $billquery="INSERT INTO `billing` (`appointment_id`, `total`) VALUES ('$appointmentid', '$advance')";
        if(mysqli_query($con,$billquery)){
            $msg="Added successfully!";
        }else{
            $msg = "Billing error";
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
              <label for="appointmentdate">Appointment date</label>
              <input type="date" name="appointmentdate" id="appointmentdate" class="form-control" value="<?php echo date("Y-m-d");?>" max="<?php echo date("Y-m-d");?>"required>
              <label for="appointmenttime">Appointment time</label>
              <input type="text" name="appointmenttime" id="appointmenttime" class="form-control" required>    
            <label for="advance">Fees</label>
              <input type="text" name="advance" id="advance" class="form-control" required>
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
$("#doctor").bind("click", function(e){
    $url = "http://localhost/dbms/helpers/doctor_time_fetch.php?searchTerm=" + $("#doctor").val(),
    fetch($url).then(response => {
  return response.json();
}).then(data => {
        $('#appointmenttime').val(data[0]['free']);
}).catch(err => {
  //errors here
});
});
</script>
    <?php
include_once("inc/footer.php");
?>