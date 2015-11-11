<?php
if($_POST) {
    if (isset($_POST['name'])) {
        if (isset($_POST['location'])) {
            if (isset($_POST['dob'])) {
                if (isset($_POST['email'])) {
                    if (isset($_POST['bio'])) {
                        if (isset($_POST['id'])) {

                            require_once 'dbCon.php';

                            $name = $_POST['name'];
                            $location = $_POST['location'];
                            $dob = $_POST['dob'];
                            $email = $_POST['email'];
                            $bio = $_POST['bio'];
                            $id = $_POST['id'];
                            if (isset($_POST['image_id'])) {
                                $image_id = $_POST['image_id'];
                            }


                            $result = mysqli_query($con, "UPDATE user SET name = '$name', location = '$location',
                                                    dob = '$dob', email = '$email', bio = '$bio'".(isset($image_id) ? ", image_id = $image_id" : "")." WHERE id = '$id'");

                            if ($result) {
//                                echo "Information successfully updated";
                            } else {
                                echo "Failed to update information: " . mysqli_error($con);
                            }

                        } else {
                            echo "Missing id";
                        }
                    } else {
                        echo "Missing bio";
                    }
                } else {
                    echo "Missing email";
                }
            } else {
                echo "Missing date of birth";
            }
        } else {
            echo "Missing location";
        }
    } else {
        echo "Missing name";
    }
}