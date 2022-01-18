<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
if($_SERVER['REQUEST_METHOD']='POST'){
include "db_conn.php";
$data = json_decode(file_get_contents("php://input"));
if(
!empty($data->email) 
){$sql="SELECT image_url FROM users2 WHERE email='$data->email'";
   $result=mysqli_query($conn,$sql);
   if(mysqli_num_rows($result)>0){
       $rows=array();
   while ($r = mysqli_fetch_assoc($result)) {
    $rows["result"][]=$r;
   }
   echo json_encode($rows);
   }else {
      echo json_encode(array("message" => "data incomplete"));
   }
}
echo json_encode(array("message" => "data incomplete"));
}
?>




<!-- <?php 
// include "db_conn.php";

// $sql = "SELECT image_url FROM users2 ORDER BY id DESC LIMIT 1";
// $res = mysqli_query($conn,  $sql);
//    if(mysqli_num_rows($res)>0){
    //    $rows=array();

//    while ($r = mysqli_fetch_assoc($res)) {
//     $rows["result"][]=$r;

//    }

//    echo json_encode($rows);

// }
?> -->

