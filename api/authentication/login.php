<?php
include "../connection/config.php";

if($_SERVER['REQUEST_METHOD']==='POST'){    
    $password=$_POST['password'];
    $username=$_POST['username'];

    if($username!=='' and $password!==''){

        $sql="SELECT * FROM users WHERE username='$username'";
        $result=mysqli_query($con,$sql);
        $num=mysqli_num_rows($result);
        if($num>0){
            $user=mysqli_fetch_array($result);
            $isValid=password_verify($password,$user['password']);
            if($isValid){

                function generateUniqueToken($length = 32) {
                    return bin2hex(random_bytes($length));
                }
                
                $id=$user['id'];
                $token = generateUniqueToken();
                $sql="INSERT INTO user_tokens(token,user_id) VALUES ('$token','$id')";
                $result=mysqli_query($con,$sql);
                
            echo json_encode(
                [
                    "status"=>200,
                    "token"=>$token,
                    "message"=>"Login Successful.",
                ]
                );
            }
            else{
                echo json_encode(
                    [
                        "status"=>550,
                        "message"=>"Wrong Password."
                    ]
                    );
            }
        }
        else{
            echo json_encode(
                [
                    "status"=>500,
                    "message"=>"User doesn't exist",
                ]
                );
        }
    }
    else{
        echo json_encode(
            [
                "status"=>"505",
                "message"=>"Fill all the fields",
            ]
            );
    }
}
?>