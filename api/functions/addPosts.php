<?php
include "../connection/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $desc = $_POST['desc'];
    $userId = $_POST['userId'];

    if (isset($_FILES['file'])) {
        $image = $_FILES['file'];
        $image_name = $image['name'];
        $image_ext = $image['type'];
        $image_tmp = $image['tmp_name'];
        $image_location = "../images/post/" . $image_name;
        move_uploaded_file($image_tmp, $image_location);
        $image_location_db = "api/images/post/" . $image_name;
    } else {
        $image_location_db = null;
    }

    if ($desc != '' or $image != '') {
        $sql = "INSERT INTO posts(description,img,userId,createdAt) VALUES( '$desc','$image_location_db','$userId',NOW())";
        $result = mysqli_query($con, $sql);
        if ($result) {
            echo json_encode([
                "status" => 200,
                "message" => "Post added sucessfully"
            ]);
        } else {
            echo json_encode([
                "status" => 500,
                "message" => "Some error occured"
            ]);

        }
    } else {
        echo json_encode([
            "status" => 501,
            "message" => "Post cannot be empty"
        ]);
    }
} else {
    echo json_encode([
        "status" => 502,
        "message" => "Invalid image type"
    ]);
}


?>