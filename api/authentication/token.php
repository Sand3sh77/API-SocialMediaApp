<?php
include "../connection/config.php";

if($_SERVER['REQUEST_METHOD']==='POST'){
    $token=$_POST['token'];

    $sql="SELECT * FROM user_tokens where token='$token'";
    $result=mysqli_query($con,$sql);

    $num=mysqli_num_rows($result);
    if($num>0){
        $data=mysqli_fetch_array($result);
        $userid=$data['user_id'];

        $sql="SELECT * FROM users WHERE id='$userid'";
        $result=mysqli_query($con,$sql);
        $products=[];
        while($row=mysqli_fetch_assoc($result)){
            $products[]=$row;
        }

        echo json_encode([
            "status"=>200,
            "message"=>"User data obtained succesfully",
            "data"=>$products
        ]);
    }
    else{
        echo json_encode([
            "status"=>501,
            "message"=>"Token does not exist.",
        ]);
    }

}
?>