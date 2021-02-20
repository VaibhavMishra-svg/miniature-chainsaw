<?php
include_once("db.php");
if(!isset($_GET['searchTerm'])){ 
  $fetchData = mysqli_query($con,"select * from doctor order by department_id");
}
else{ 
  $search = $_GET['searchTerm'];   
  $fetchData = mysqli_query($con,"select * from doctor where department_id like '%".$search."%'");
} 

$data = array();
while ($row = mysqli_fetch_array($fetchData)) {    
  $data[] = array("id"=>$row['id'], "text"=>$row['name']);
}
echo json_encode($data);