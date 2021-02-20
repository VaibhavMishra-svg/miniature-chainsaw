<?php
include_once("db.php");
if(!isset($_GET['searchTerm'])){ 
  $fetchData = mysqli_query($con,"select distinct * from room");
}else{ 
  $search = $_GET['searchTerm'];   
  $fetchData = mysqli_query($con,"select distinct * from room where type='".$search."' and status=1");
} 

$data = array();
while ($row = mysqli_fetch_array($fetchData)) {    
  $data[] = array("roomno"=>$row['number']);
}
echo json_encode($data);