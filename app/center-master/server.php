<?php
## Database configuration
include '../../includes/db-config.php';
session_start();
## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
if(isset($_POST['order'])){
  $columnIndex = $_POST['order'][0]['column']; // Column index
  $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
  $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
}
$searchValue = mysqli_real_escape_string($conn,$_POST['search']['value']); // Search value

if(isset($columnSortOrder)){
  $orderby = "ORDER BY $columnName $columnSortOrder";
}else{
  $orderby = "ORDER BY Users.ID DESC";
}

$center_query = "";
if($_SESSION['Role']!="Administrator"){
  $check_has_unique_center_code = $conn->query("SELECT Center_Suffix FROM Universities WHERE ID IN (".$_SESSION['university_ids'].") AND Has_Unique_Center = 1");
  if($check_has_unique_center_code->num_rows>0){
    $center_suffix = mysqli_fetch_assoc($check_has_unique_center_code);
    $center_suffix = $center_suffix['Center_Suffix'];
    $center_query = " AND Code LIKE '$center_suffix%' AND Is_Unique = 1";
  }else{
    $center_query = " AND Is_Unique = 0";
  }
}


## Search 
$searchQuery = " ";
if($searchValue != ''){
  $searchQuery = " AND (Users.Name like '%".$searchValue."%' OR Users.Code like '%".$searchValue."%' OR Users.Email like '%".$searchValue."%' OR Users.Mobile like '%".$searchValue."%')";
}

## Total number of records without filtering
$all_count=$conn->query("SELECT COUNT(ID) as allcount FROM Users WHERE Role = 'Center' $center_query");
$records = mysqli_fetch_assoc($all_count);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$filter_count = $conn->query("SELECT COUNT(ID) as filtered FROM Users WHERE Role = 'Center' $center_query $searchQuery");

$records = mysqli_fetch_assoc($filter_count);
$totalRecordwithFilter = $records['filtered'];

## Fetch records
$result_record = "SELECT Users.*,Users.ID as center_id, University_ID,Universities.Name as university_name, CAST(AES_DECRYPT(Password, '60ZpqkOnqn0UQQ2MYTlJ') AS CHAR(50)) password FROM Users LEFT JOIN Universities ON Universities.ID=Users.University_ID WHERE Role = 'Center' $center_query $searchQuery $orderby LIMIT ".$row.",".$rowperpage;
$empRecords = mysqli_query($conn, $result_record);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {

  $uni_name = [];
  $get_uni = $conn->query("SELECT u.Name FROM Alloted_Center_To_Counsellor AS ac LEFT JOIN Universities AS u ON ac.University_ID = u.ID WHERE ac.Code = '".$row['center_id']."'");

  if ($get_uni->num_rows > 0) {
    while ($uni_data = $get_uni->fetch_assoc()) {
      $uni_name[] = $uni_data['Name'];
    }
  }

 
    $data[] = array( 
      "Photo"=> $row['Photo'],
      "Name" => $row['Name'],
      "Email" => $row['Email'],
      "Code" => $row['Code'],
      "Password" => $row['password'],
      "CanCreateSubCenter" => $row['CanCreateSubCenter'],
      "Status"  => $row["Status"],
      "ID"      => $row["ID"],
      "University_ID" => $row["University_ID"],
      "university_name" =>implode(', ', $uni_name),
    );
}

## Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);

echo json_encode($response);
