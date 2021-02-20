<?php
include_once("db.php");
if(!isset($_GET['searchTerm'])){ 
  $fetchData = mysqli_query($con,"select * from doctor");
}else{ 
  $search = $_GET['searchTerm'];   
  $fetchData = mysqli_query($con,"select * from doctor where id=".$search."");
} 

$data = array();
while ($row = mysqli_fetch_array($fetchData)) {    
  $data[] = array("id"=>$row['id'], "text"=>$row['name'], "free"=>$row['work_time']);
}
echo json_encode($data);