<?php if(!($_SESSION['role']=='admin')){
header("Location: viewer.php");
}?>
 <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="./dashboard.php">Healthcare Management System</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="./dashboard.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./appointment.php">Appointment</a>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="./admit.php">Admit</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Add
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="./add-patient.php">Patient</a>
          <a class="dropdown-item" href="./add-doctor.php">Doctor</a>
          <a class="dropdown-item" href="./add-department.php">Department</a>
          <a class="dropdown-item" href="./add-room.php">Room</a>
          <a class="dropdown-item" href="./add-staff.php">Staff</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          View
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="./view-admitted.php">Admitted</a>
          <a class="dropdown-item" href="./view-appointments.php">Appointments</a>
          <a class="dropdown-item" href="./view-room.php">Rooms</a>
          <a class="dropdown-item" href="./view-doctors.php">Doctors</a>
          <a class="dropdown-item" href="./view-patients.php">Patients</a>
          <a class="dropdown-item" href="./view-staff.php">Staff</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Billing
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="./admit-billing.php">Admitted</a>
          <a class="dropdown-item" href="./appointment-billing.php">Appointments</a>
        </div>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="./logout.php">Logout</a>
      </li>
    </ul>
  </div>
</nav>