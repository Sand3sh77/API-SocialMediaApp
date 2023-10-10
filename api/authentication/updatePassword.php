<?php
include "../connection/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nPassword = $_POST['nPassword'];
    $coPassword = $_POST['coPassword'];
    $cuPassword = $_POST['cuPassword'];

    $sql = "SELECT password FROM users WHERE id=$id";
    $result = mysqli_query($con, $sql);
    $user = mysqli_fetch_array($result);
    $isValid = password_verify($cuPassword, $user['password']);

    if ($nPassword !== '' && $coPassword !== '' && $cuPassword !== '') {
        if ($coPassword === $nPassword) {
            if ($result) {
                if ($isValid) {
                    if ($cuPassword !== $nPassword) {
                        $hased_password = password_hash($nPassword, PASSWORD_DEFAULT);
                        $sql = "UPDATE users SET password='$hased_password' WHERE id=$id";
                        $result = mysqli_query($con, $sql);
                        if ($result) {
                            echo json_encode([
                                "status" => 200,
                                "message" => "Password changed succesfully"
                            ]);
                        } else {
                            echo json_encode([
                                "status" => 505,
                                "message" => "An error occured"
                            ]);
                        }
                    } else {
                        echo json_encode([
                            "status" => 504,
                            "message" => "Please choose a new password"
                        ]);
                    }
                } else {
                    echo json_encode([
                        "status" => 501,
                        "message" => "Incorrect Password"
                    ]);
                }
            } else {
                echo json_encode([
                    "status" => 500,
                    "message" => "An error occured"
                ]);
            }
        } else {
            echo json_encode([
                "status" => 503,
                "message" => "Passwords do not match"
            ]);
        }
    } else {
        echo json_encode([
            "status" => 502,
            "message" => "Fill all the fields"
        ]);

    }
}

?>