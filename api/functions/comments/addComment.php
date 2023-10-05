<?php
include "../../connection/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $postId = $_POST['postId'];
    $userId = $_POST['userId'];
    $desc = $_POST['desc'];

    $sql = "INSERT INTO comments(description,createdAt,userId,postId) VALUES ('$desc',NOW(),$userId,$postId)";
    $result = mysqli_query($con, $sql);

    if ($result) {
        echo json_encode([
            "status" => 200,
            "message" => "Comment added succesfully",
        ]);

    } else {
        echo json_encode([
            "status" => 500,
            "message" => "Some error occured"
        ]);
    }
}
?>