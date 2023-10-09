<?php
include "../../connection/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $city = $_POST['city'];
    $website = $_POST['website'];
    $dob = $_POST['dob'];

    $sql = "UPDATE users SET name='$name',email='$email',city='$city',website='$website',dateofBirth='$dob' where id='$id'";
    $result = mysqli_query($con, $sql);

    if ($result) {
        echo json_encode([
            "status" => 200,
            "message" => "Details updated successfully"
        ]);
    } else {
        echo json_encode([
            "status" => 500,
            "message" => "An error occured"
        ]);
    }

}

?>