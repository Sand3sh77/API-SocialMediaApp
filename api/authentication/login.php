<?php
include "../connection/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $method = $_POST['method'];

    if ($email !== '' and $password !== '') {

        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($con, $sql);
        $num = mysqli_num_rows($result);
        if ($num > 0) {
            $user = mysqli_fetch_array($result);
            if ($method === "normal") {
                if ($user['method'] === "normal") {
                    $isValid = password_verify($password, $user['password']);
                    if ($isValid) {

                        function generateUniqueToken($length = 32)
                        {
                            return bin2hex(random_bytes($length));
                        }

                        $id = $user['id'];
                        $token = generateUniqueToken();
                        $sql = "INSERT INTO user_tokens(token,user_id) VALUES ('$token','$id')";
                        $result = mysqli_query($con, $sql);

                        echo json_encode(
                            [
                                "status" => 200,
                                "token" => $token,
                                "message" => "Login Successful.",
                            ]
                        );
                    } else {
                        echo json_encode(
                            [
                                "status" => 550,
                                "message" => "Wrong Password."
                            ]
                        );
                    }
                } else {
                    echo json_encode(
                        [
                            "status" => 550,
                            "message" => "Please sign in with google"
                        ]
                    );
                }
            } else {
                function generateUniqueToken($length = 32)
                {
                    return bin2hex(random_bytes($length));
                }
                $id = $user['id'];
                $token = generateUniqueToken();
                $sql = "INSERT INTO user_tokens(token,user_id) VALUES ('$token','$id')";
                $result = mysqli_query($con, $sql);

                echo json_encode(
                    [
                        "status" => 200,
                        "token" => $token,
                        "message" => "Login by email successful.",
                    ]
                );
            }
        } else {
            echo json_encode(
                [
                    "status" => 500,
                    "message" => "User doesn't exist",
                ]
            );
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