<?php
include "../../connection/config.php";

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $id = $_POST['id'];
    $location = $_POST['location'];
    $profileUserId = $_POST['paramsId'];

    if ($location === "profile") {
        $sql = "SELECT posts.id,userId,description,createdAt,img,profilePic,name,method FROM posts JOIN users ON posts.userId = users.id WHERE userId='$profileUserId' ORDER BY posts.id DESC";
    } else {
        $sql = "SELECT DISTINCT posts.id, userId, description, createdAt, img, profilePic, name ,method
        FROM posts 
        JOIN users ON posts.userId = users.id 
        LEFT JOIN relationships ON posts.userId = relationships.followedUserId 
        WHERE relationships.followerUserId = $id OR posts.userId = $id 
        ORDER BY posts.id DESC";
    }
    $result = mysqli_query($con, $sql);

    if ($result) {
        $posts = [];
        while ($row = mysqli_fetch_assoc($result)) {

            // THIS IS FOR CHECKING TOTAL NO OF LIKES
            $postId = $row['id'];
            $sqllike = "SELECT * FROM likes WHERE postId='$postId'";
            $resultlike = mysqli_query($con, $sqllike);

            $total_likes = mysqli_num_rows($resultlike);

            $row['totalLikes'] = $total_likes;




            // THIS IS FOR CHECKING TOTAL NO OF COMMENTS
            $postId = $row['id'];
            $sqlcomment = "SELECT * FROM comments WHERE postId='$postId'";
            $resultcomment = mysqli_query($con, $sqlcomment);

            $total_comments = mysqli_num_rows($resultcomment);

            $row['totalComments'] = $total_comments;




            // THIS IS FOR CHECKING IF THE CURRENT USER HAS LIKED THE POST OR NOT
            $sqllike = "SELECT * FROM likes WHERE userId='$id' and postId='$postId'";
            $resultlike = mysqli_query($con, $sqllike);

            $isLikedNum = mysqli_num_rows($resultlike);
            if ($isLikedNum === 1) {
                $row['isLiked'] = true;
            } else {
                $row['isLiked'] = false;
            }




            $posts[] = $row;
        }

        echo json_encode([
            "status" => 200,
            "message" => "Posts obtained succesfully",
            "data" => $posts
        ]);
    } else {
        echo json_encode([
            "status" => 500,
            "message" => "Request failed",
        ]);
    }
}

?>