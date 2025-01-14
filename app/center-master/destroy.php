<?php
  if($_SERVER['REQUEST_METHOD'] == 'DELETE' && isset($_GET['id'])){
    require '../../includes/db-config.php';
    session_start();
    
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // $students = $conn->query("SELECT ID FROM Alloted_Center_To_Counsellor WHERE Code = $id");
    // if ($students->num_rows > 0) {
    //   echo json_encode(['status' => 302, 'message' => 'This center alloted to University exists!']);
    //   exit();
    // }


    $course = $conn->query("SELECT User_ID FROM Center_Sub_Courses WHERE User_ID = $id");
    if ($course->num_rows > 0) {
      echo json_encode(['status' => 302, 'message' => 'Courses alloted to Center exists!']);
      exit();
    }

    $check = $conn->query("SELECT ID FROM Users WHERE ID = $id");
    if($check->num_rows>0){
      $delete = $conn->query("DELETE FROM Users WHERE ID = $id");
      if($delete){
        echo json_encode(['status'=>200, 'message'=>'Center deleted successfully!']);
      }else{
        echo json_encode(['status'=>302, 'message'=>'Please remove alloted Courses!']);
      }
    }else{
      echo json_encode(['status'=>302, 'message'=>'Center not exists!']);
    }
  }
