<?php

if ($_POST) {
    if (isset($_POST['title'])) {
        if (isset($_POST['text'])) {
            if (isset($_POST['hashtags'])) {
                require_once 'dbCon.php';

                $title = $_POST['title'];
                $text = $_POST['text'];
                $hashtags = $_POST['hashtags'];

                //create a new row in post table in db
                $result = mysqli_query($con, "INSERT INTO post (title, text, user_id) VALUES ('$title', '$text', 1)");

                if ($result) { //checks if post is successfully created

                    $post_id = mysqli_insert_id($con); //gets an id of the post

                    foreach ($hashtags as $tag_id) { //for each hashtag
                        $tag = mysqli_query($con, "SELECT * FROM tag WHERE id = $tag_id"); //finds a tag with this specific id

                        if (!$tag) { //on error (false)
                            echo "Failed to get tag ".mysqli_error($con);
                        } else if (mysqli_num_rows($tag) == 0) { //if tag doesn't exist
                            echo "Tag id $tag_id doesn't exist";
                        } else {
                            //link post with this tag
                            $result = mysqli_query($con, "INSERT INTO post_tag (post_id, tag_id) VALUES ($post_id, $tag_id)");

                            if (!$result) {
                                echo "Failed to add hashtag id $tag_id to post: " . mysqli_error($con);
                            }
                        }
                    }

                    if (isset($_POST['post_images'])) {
                        $images = $_POST['post_images'];

                        $i = 0;
                        foreach ($images as $image_id) {  //for each image
                            $result = mysqli_query($con, "SELECT * FROM image WHERE id = $image_id"); //finds an image with this specific id


                            if (!$result) { //on error (false)
                                echo "Failed to get image ".mysqli_error($con);
                            } else if (mysqli_num_rows($result) == 0) { //if image doesn't exist
                                echo "Image id $image_id doesn't exist";
                            } else {
                                //link post with this image
                                $result = mysqli_query($con, "INSERT INTO post_image (post_id, image_id, `order`) VALUES ($post_id, $image_id, $i)");
                                $i++;
                                if (!$result) {
                                    echo "Failed to add image id $image_id to post: " . mysqli_error($con);
                                }
                            }
                        }
                    }
                    header("Location: post.php?id=$post_id");
//                    echo "Post successfully created";
                } else {
                    echo "Post failed to create: " . mysqli_error($con);
                }
            } else {
                echo "Missing hashtags";
            }
        } else {
            echo "Missing text";
        }
    } else {
        echo "Missing title";
    }
}
