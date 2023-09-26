<?php
include "../connection/config.php";

if($_SERVER["REQUEST_METHOD"]==="POST"){
    $postId=$_POST['id'];

    // THE BELOW 2 LINES ARE TO REMOVE THE IAMGE FROM THE BACKEND 
    $file=$_POST['file_path'];
    $file_path = '../images/'.substr($file, strrpos($file, '/') + 1);

    $sql="DELETE FROM posts where id=$postId";
    $result=mysqli_query($con,$sql);
    if($result){
        if (file_exists($file_path)) {
        unlink($file_path);
        }
        echo json_encode([
            "status"=>200,
            "message"=>"Post removed succesfully"
        ]);
    }
    else{
        echo json_encode([
            "status"=>500,
            "message"=>"Some error occured"
        ]);
    }
}
?>