<?php
  if(isset($_GET['id'])){
    require '../../../includes/db-config.php';

    $id = intval($_GET['id']);

    $status = $conn->query("SELECT LE_Status FROM Admission_Sessions WHERE ID = $id");
    $status = mysqli_fetch_assoc($status);

    $status = $status['LE_Status']==1 ? 0 : 1;

    $update = $conn->query("UPDATE Admission_Sessions SET LE_Status = $status WHERE ID = $id");
    if($update){
      echo json_encode(['status'=>200, 'message'=>'LE Status updated successfully!']);
    }else{
      echo json_encode(['status'=>400, 'message'=>'Something went wrong!']);
    }
  }