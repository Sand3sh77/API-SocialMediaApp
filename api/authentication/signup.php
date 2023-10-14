<?php
include "../connection/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $method = $_POST['method'];
    $password = $_POST['password'];
    $profilePic = $_POST['profilePic'];

    if ($username !== '' and $password !== '' and $email !== '' and $name !== "") {

        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($con, $sql);

        if ($result) {
            $num = mysqli_num_rows($result);
            $row = mysqli_fetch_assoc($result);
            if ($num > 0) {
                if ($row['method'] === 'normal') {
                    echo json_encode(
                        [
                            "status" => 500,
                            "message" => "Email already registered"
                        ]
                    );
                } else {
                    echo json_encode([
                        "status" => 200,
                        "message" => "Redirect to login"
                    ]);
                }
            } else {
                if ($method === 'normal') {
                    $hased_password = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO users(username,email,password,name,method) VALUES('$username','$email','$hased_password','$name','normal')";
                    $result = mysqli_query($con, $sql);
                    if ($result) {
                        echo json_encode(
                            array(
                                "status" => 200,
                                "message" => "Signup Successful."
                            )
                        );
                    }
                } else {
                    $sql = "INSERT INTO users(username,email,name,method,profilePic) VALUES('$username','$email','$name','email','$profilePic')";
                    $result = mysqli_query($con, $sql);
                    if ($result) {
                        echo json_encode(
                            array(
                                "status" => 200,
                                "message" => "Signup by email Successful."
                            )
                        );
                    }
                }
            }
        }
    } else {
        echo json_encode(
            [
                "status" => "505",
                "message" => "Fill all the fields",
            ]
        );
    }

}
?>