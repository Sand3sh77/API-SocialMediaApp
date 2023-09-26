<?php
include "../connection/config.php";

if($_SERVER["REQUEST_METHOD"]==='GET'){
    $id=$_GET['id'];

    $sql="SELECT posts.id,userId,description,createdAt,img,profilePic,name FROM posts JOIN users ON posts.userId = users.id ORDER BY posts.id DESC";
    $result=mysqli_query($con,$sql);

    
    if($result){
        $posts=[];
        while($row=mysqli_fetch_assoc($result)){
            

            // THIS IS FOR CHECKING TOTAL NO OF LIKES
            $postId=$row['id'];
            $sqllike="SELECT * FROM likes WHERE postId='$postId'";
            $resultlike=mysqli_query($con,$sqllike);

            $total_likes=mysqli_num_rows($resultlike);

            $row['totalLikes'] = $total_likes;

            // THIS IS FOR CHECKING IF THE CURRENT USER HAS LIKED THE POST OR NOT
            $sqllike="SELECT * FROM likes WHERE userId='$id' and postId='$postId'";
            $resultlike=mysqli_query($con,$sqllike);

            $isLikedNum=mysqli_num_rows($resultlike);
                if($isLikedNum===1){
                    $row['isLiked']= true;
                }
                else{
                    $row['isLiked']=false;
                }


            $posts[]=$row;
        }

        echo json_encode([
            "status"=>200,
            "message"=>"Posts obtained succesfully",
            "data"=>$posts
        ]);
    }
    else{
        echo json_encode([
            "status"=>500,
            "message"=>"Request failed",
        ]);
    }
}

?>
