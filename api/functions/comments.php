<?php
include "../connection/config.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $postId = $_GET['id'];

    // $sql = "SELECT comments.id,comments.desc,comments.createdAt,comments.userId,comments.postId,users.name,
    // users.profilePic FROM comments JOIN users ON comments.userId=users.id WHERE comments.postId='$postId'";

    $sql = "SELECT comments.id, comments.description, comments.createdAt, comments.userId, comments.postId, users.name, users.profilePic 
    FROM comments 
    INNER JOIN users ON comments.userId = users.id 
    WHERE comments.postId = '$postId'
    ORDER BY id DESC";


    $result = mysqli_query($con, $sql);
    $num = mysqli_num_rows($result);
    if ($result) {
        if ($num > 0) {
            $comments = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $comments[] = $row;
            }
            echo json_encode([
                "status" => 200,
                "message" => "Comments obtained succesfully",
                "data" => $comments,
            ]);
        } else {
            echo json_encode([
                "status" => 501,
                "message" => "No comments available"
            ]);
        }
    } else {
        echo json_encode([
            "status" => 500,
            "message" => "Some error occured"
        ]);
    }
}
?>