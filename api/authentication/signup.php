<?php
include "../connection/config.php";

if($_SERVER['REQUEST_METHOD']==='POST'){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    // $city=$_POST['city'];
    // $website=$_POST['website'];

    if($username!=='' and $password!=='' and $email!=='' and $name!==""){
        $sql="SELECT * FROM users WHERE username='$username' or email='$email'";
        $result=mysqli_query($con,$sql);

        if($result){
            $num=mysqli_num_rows($result);
            if($num>0){
                echo json_encode([
                    "status"=>500,
                    "message"=>"User already exists"
                ]
            );
            }
            else{
                $hased_password=password_hash($password,PASSWORD_DEFAULT);
                $sql="INSERT INTO users(username,email,password,name) VALUES('$username','$email','$hased_password','$name')";
                $result=mysqli_query($con,$sql);
                if($result){
                    echo json_encode(array("status"=>200,
                    "message"=>"Signup Successful.")                        
                    );
                }
            }
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