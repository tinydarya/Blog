<?php

if ($_POST) {
    if (isset($_POST['id'])) {
        if (isset($_POST['title'])) {
            if (isset($_POST['text'])) {
                if (isset($_POST['hashtags'])) {

                    require_once 'dbCon.php';

                    $post_id = $_POST['id'];
                    $title = $_POST['title'];
                    $text = $_POST['text'];
                    $hashtags = $_POST['hashtags'];

                    //update row in post table in db
                    $result = mysqli_query($con, "UPDATE post SET title = '$title', text = '$text' WHERE id = $post_id");

                    if ($result) { //checks if post is successfully updated

                        $result = mysqli_query($con, "DELETE FROM post_tag WHERE post_id = $post_id");
                        if ($result) {
                            foreach ($hashtags as $tag_id) { //for each hashtag
                                $tag = mysqli_query($con, "SELECT * FROM tag WHERE id = $tag_id"); //find if this tag exists

                                if (!$tag) { //if tag exists
                                    echo "Tag id $tag_id doesn't exist";
                                } else {
                                    //link post with this tag
                                    $result = mysqli_query($con, "INSERT INTO post_tag (post_id, tag_id) VALUES ($post_id, $tag_id)");

                                    if (!$result) {
                                        echo "Failed to add hashtag id $tag_id to post";
                                    }
                                }
                            }

                            if (isset($_POST['post_images'])) {
                                $images = $_POST['post_images'];

                                $result = mysqli_query($con, "DELETE FROM post_image WHERE post_id = $post_id");
                                if ($result) {
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
                                } else {
                                    echo "Failed to remove all images from post";
                                }
                            }
                        } else {
                            echo "Failed to remove all tags from post";
                        }
                    } else {
                        echo "Post failed to update: " . mysqli_error($con);
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
    } else {
        echo "Missing id";
    }
}
