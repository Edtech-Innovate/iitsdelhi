<?php



if($_POST['id']!='' && $_POST['amount']!='')
{
    require '../../includes/db-config.php';
    $amount = $_POST['amount'];
    $id = $_POST['id'];
    $query = "UPDATE Student_Ledgers set Fee=$amount where ID=$id";
    $run = $conn->query($query);
    if($run)
    {
        echo json_encode(['status' => 200, 'message' => "Payment updated succefully!!"]);
    }
    else
    {
        echo json_encode(['status' => 400, 'message' => "Something went wrong"]);
    }
}

?>