<?php

if ($_FILES) {
    require_once 'PHP/dbCon.php';
    include("PHP/session.php");
    //Specifies the directory where the file is going to be placed
    $target_dir = "uploads/";
    $file_name = basename($_FILES["fileToUpload"]["name"]);
    //Specifies the path of the file to be uploaded
    $target_file = $target_dir . $file_name;

    $uploadOk = 1;

    //Holds the file extension of the file
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
//            echo "File is an image - " . $check["mime"] . ".<br/>";
            $uploadOk = 1;
        } else {
//            echo "File is not an image.<br/>";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if ($uploadOk == 1 && file_exists($target_file)) {
//        echo "File already exists. Looking for a db entry...<br/>";
        $result = mysqli_query($con, "SELECT * FROM image WHERE path = '$target_file'");
        if (!$result || mysqli_num_rows($result) == 0) {
//            echo "Db entry for file not found. Creating a new one...<br/>";
            echo createImageEntry($con, $target_file, $file_name);
        } else {
//            echo "Db entry found, setting image to user...<br/>";
            $result = mysqli_fetch_assoc($result);
            echo $result['id'];
        }
    } else {
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 5000000) {
//            echo "Sorry, your file is too large.<br/>";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
//            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br/>";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo -1;
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
//                echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.<br/>";

                echo createImageEntry($con, $target_file, $file_name);
            } else {
                echo "Sorry, there was an error";
                echo -1;
            }
        }
    }
}


function createImageEntry($con, $path, $name) {
    $result = mysqli_query($con, "INSERT INTO image (path, name) VALUES ('$path', '$name')");
    if ($result) {
//        echo "The image path has been successfully saved to db<br/>";
        $image_id = mysqli_insert_id($con); //gets an id of the image
        return $image_id;
    } else {
        echo "Sorry, there was an error inserting into db: " + mysqli_error($con) . "<br/>";
        return -1;
    }
}

function setImageToUser($con, $image_id, $user_id) {
    $result = mysqli_query($con, "UPDATE user SET image_id = $image_id WHERE id = $user_id");
    if ($result) {
//        echo "The user entry has been successfully updated with image_id<br/>";
        return true;
    } else {
        echo "Sorry, there was an error updating user db entry: " + mysqli_error($con) . "<br/>"; //update user row was unsuccessful
        return false;
    }
}


?>