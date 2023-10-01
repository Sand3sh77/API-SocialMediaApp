<?php
include "../connection/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_POST['userId'];

    $image = $_FILES['file'];
    $image_name = $image['name'];
    $image_ext = $image['type'];
    $image_tmp = $image['tmp_name'];
    $image_location = "../images/story/" . $image_name;
    move_uploaded_file($image_tmp, $image_location);
    $image_location_db = "api/images/story/" . $image_name;

    $sql = "INSERT INTO stories(img,createdAt,userId) VALUES ('$image_location_db',NOW(),'$userId')";
    $result = mysqli_query($con, $sql);

    if ($result) {
        echo json_encode([
            "status" => 200,
            "message" => "Story added succesfully"
        ]);
    } else {
        echo json_encode([
            "status" => 500,
            "message" => "Some error occured"
        ]);
    }


}
?>