<?php 
 // required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
if (isset($_POST['submit']) && isset($_FILES['my_image'])) {
       include "db_conn.php";
      //  echo "<pre>";
      //  print_r($_FILES['my_image']);
      //  echo "</pre>";
       $img_name = $_FILES['my_image']['name'];
       $img_size = $_FILES['my_image']['size'];
       $tmp_name = $_FILES['my_image']['tmp_name'];
       $error = $_FILES['my_image']['error'];
       if ($error === 0) {
          if ($img_size > 12500000) {
             echo json_encode(array("message" => "Sorry, your file is too large."));
             // $em = "Sorry, your file is too large.";
             // header("Location: index.php?error=$em");
          }else {
             $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
             $img_ex_lc = strtolower($img_ex);
    
             $allowed_exs = array("jpg", "jpeg", "png"); 
    
             if (in_array($img_ex_lc, $allowed_exs)) {
                $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                $img_upload_path = 'uploads/'.$new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);
         
                // Insert into Database
                $email=$_POST['email'];
                $sql="UPDATE  users2 SET image_url='http://localhost/image-upload-php-and-mysql-main/uploads/$new_img_name'  where email='$email'";
                if(mysqli_query($conn, $sql)){
                   echo json_encode(array("message" => "image successfully updated"));}
                else{
                   echo json_encode(array("message" => "image not updated")); 
                }
             }else {
                echo json_encode(array("message" => "You can't upload files of this type"));
                // header("Location: index.php?error=$em");
             }
          }
       }else {
          echo json_encode(array("message" => "unknown error occurred!"));
          // header("Location: index.php?error=$em");
       }
    }else {
       echo json_encode(array("message" => "submit button name uncompleted"));
    }

// <form action="http://localhost/image-upload-php-and-mysql-main/upload-test.php" method='POST' enctype="multipart/form-data">
//  <input type="file" name="my_image"/>
//  <input type="email" name='email' />
//  <input type="submit" name="submit" value="Upload"/>
// </form>


?>



































<!-- <?php


if($_SERVER['REQUEST_METHOD']==='PUT'){
include "db_conn.php";
$data = json_decode(file_get_contents("php://input"));
if(
    !empty($data->email) 
){
   $sql="UPDATE  users2 SET image_url='$data->image_url'  where email='$data->email'";
if(mysqli_query($conn,$sql)){
    echo json_encode(array("message" => "image successfully updated"));
   }else {
      echo json_encode(array("message" => "image not updated")); 
   }
}else{
   echo json_encode(array("message" => "email missing for image update"));
}
}

?> -->



