<?php
include "../connection/config.php";

if($_SERVER["REQUEST_METHOD"]==='GET'){
    $id=$_GET['id'];

    $sql="SELECT * FROM users where id='$id'";
    $result=mysqli_query($con,$sql);
    $num=mysqli_num_rows($result);
    if($result){
        if($num>0){
            $users=[];
            while($row=mysqli_fetch_assoc($result)){
                $users[]=$row;
            }
            echo json_encode([
                "status"=>200,
                "message"=>"User data obtained succesfully",
                "data"=>$users
            ]);
        }
        else{
            echo json_encode([
                "status"=>500,
                "message"=>"No user found."
            ]);
        }
    }
    else{
        echo json_encode([
            "status"=>501,
            "message"=>"Failed to get data"
        ]);
    }
}
?>