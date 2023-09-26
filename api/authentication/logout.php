<?php
include "../connection/config.php";

if($_SERVER["REQUEST_METHOD"]==='POST'){
    $token=$_POST['token'];

    $sql="SELECT * FROM user_tokens WHERE token='$token'";
    $result=mysqli_query($con,$sql);
    
    if($result){
        $num=mysqli_num_rows($result);
        if($num>0){
            $sql="DELETE FROM user_tokens WHERE token='$token'";
            $result=mysqli_query($con,$sql);
            echo json_encode([
            "status"=>200,
            "message"=>"Log out successful",
        ]);
    }
        else{
            echo json_encode([
                "status"=>501,
                "message"=>"Token does not exist"
            ]);
        }
    }
    else{
        echo json_encode([
            "status"=>500,
            "message"=>"Log out failed",
        ]);
    }
}
?>