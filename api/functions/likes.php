<?php
include "../connection/config.php";

if($_SERVER["REQUEST_METHOD"]==="POST"){
    $userId=$_POST['userId'];
    $postId=$_POST['postId'];
    $isLiked=$_POST['isLiked'];

    if($isLiked==='true'){
        $sql="DELETE FROM likes WHERE UserId='$userId'and PostId='$postId'";
        $result=mysqli_query($con,$sql);

        if($result){
            echo json_encode([
                "status"=>200,
                "message"=>"Unliked Succesfully"
            ]);
        }
        else{
            echo json_encode([
                "status"=>500,
                "message"=>"An error occured"
            ]);
        }
    }
    else{
        $sql="INSERT INTO likes(userId,postId) VALUES ('$userId','$postId')";
        $result=mysqli_query($con,$sql);

        if($result){
            echo json_encode([
                "status"=>200,
                "message"=>"Liked Succesfully"
            ]);
        }
        else{
            echo json_encode([
                "status"=>500,
                "message"=>"An error occured"
            ]);
        }
    }

}

?>