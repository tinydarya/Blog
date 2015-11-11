<?php include("PHP/only_authorised.php");
include("PHP/edit_post.php");?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Tiny Darya || Blog</title>
    <link rel="stylesheet" href="CSS/foundation.css" />
    <link rel="stylesheet" href="CSS/style.css" />
    <link rel="stylesheet" href="CSS/index_inside_style.css" />
    <link rel="stylesheet" href="CSS/new_post_style.css" />
    <link href='http://fonts.googleapis.com/css?family=Poiret+One&subset=latin,cyrillic,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="Assets/favicon.ico"/>
    <script src="http://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="JS/dropzone.js"></script>
    <script src="textboxio/textboxio.js"></script>
    <script src="JS/functions.js"></script>
</head>
<body onload="initPage();">

<?php include("header.php"); ?>

<!-- MAIN SECTION -->

<?php
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    require_once('PHP/dbCon.php');

    $result = mysqli_query($con, "SELECT * FROM post WHERE id = $post_id");

    if (!$result || mysqli_num_rows($result) == 0) { ?>
        <script>
            alert("Post does not exist.");
            window.location.href = "blog.php";
        </script>
    <?php } else {
    $post = mysqli_fetch_assoc($result);
    ?>

        <!-- Form-->
        <div id="input-form" class="small-12 columns">
            <form id="form" action="" method="post">

                <input type="hidden" name="id" value="<?php echo $post_id; ?>" />

                <!-- Paragraph -->
                <p id="heading">Edit post:</p>

                <!-- Title -->
                <div>
                    <label for="title">Title:</label>
                    <input id="title" class="input" name="title" type="text" value="<?php echo $post['title']; ?>"/>
                </div>

                <!-- Text -->
                <div>
                    <label for="text">Text:</label>
                    <textarea id="text_area" class="input" name="text" cols="45"
                              rows="20"><?php echo $post['text']; ?></textarea>
                </div>

                <!-- Images button -->
                <div id="images" >
                    <div id="image-preview-container" class="dropzone-previews">

                    </div>
                    <div class="dz-error-message"><span data-dz-errormessage></span></div>

                    <div id="hidden-images">
                    </div>
                    <!-- Add images-->
                    <div id="upload-pics">
                        <input id="pics-button" type="button" value="Upload images" />
                    </div>

                    <p>(The first image you upload will be the main image of the post.)</p>
                </div>

                <div>
                    <fieldset>
                        <p id="tags-title">Tags:</p>
                        <?php
                        $tags = mysqli_query($con, "SELECT * FROM tag");

                        if (!$tags) {
                            echo "Failed to fetch tags";
                        } else {
                            $post_tags = mysqli_query($con, "SELECT * FROM post_tag WHERE post_id = $post_id");
                            if (!$post_tags) {
                                echo "Failed to fetch post tags";
                            } else {
                                while ($tag = mysqli_fetch_assoc($post_tags)) {
                                    $tags_map[$tag['tag_id']] = $tag;
                                }
                                while ($tag = mysqli_fetch_assoc($tags)) { ?>
                                    <input type="checkbox" name="hashtags[<?php echo $tag['id']; ?>]"
                                           value="<?php echo $tag['id']; ?>" <?php if (isset($tags_map[$tag['id']])) {
                                        echo "checked";
                                    } ?> /><?php echo $tag['name']; ?><br/>
                                <?php }
                            }
                        }
                        ?>
                    </fieldset>
                </div>

                <!-- Delete post -->
                <div id="delete-post">
                    <input id="delete-btn" type="button" value="Delete post"
                           onclick="deletePost(<?php echo $post_id; ?>)"/>
                </div>

                <!-- Button -->
                <div id="container" class="small-12 columns">
                    <input id="save-button" type="submit" value="Save"/>
                </div>
            </form>
        </div>


        <script>
            function initPage() {
                var dropzone = new Dropzone("#image-preview-container",
                    {
                        url: "upload.php",
                        paramName: "fileToUpload",
                        previewContainer: '#image-preview-container',
                        previewTemplate: "<div class=\"image-preview dz-preview dz-file-preview\"><img id=\"image\" data-dz-thumbnail /></div>",
                        acceptedFiles: 'image/*',
                        clickable: '#pics-button',
                        addRemoveLinks: true,
                        dictRemoveFile: "Удалить",
                        maxFilesize: 5 // MB
                    });
                dropzone.on("addedfile", function (addedFile) {
                    var i = this.files.length;
                    while (i--) {
                        var file = this.files[i];
                        if (file.name == addedFile.name && file != addedFile) {
                            this.removeFile(addedFile);
                        }
                    }
                });
                dropzone.on("removedfile", function (removedFile) {
                    $('#post-image-' + removedFile.id).remove();
                });
                dropzone.on("success", function (file, response) {
                    if (response == -1) {
                        //error uploading
                    } else {
                        file.id = response;
                        var hiddenImagesContainer = $('#hidden-images');
                        var hiddenInput = "<input type=\"hidden\" id=\"post-image-" + response + "\" name=\"post_images[" + hiddenImagesContainer.children().length + "]\" value=\"" + response + "\" />";
                        hiddenImagesContainer.append(hiddenInput);
                    }
                });


                textboxio.replaceAll('textarea', {
                    paste: {
                        style: 'clean'
                    }
                });

                <?php

                    $result = mysqli_query($con, "SELECT i.id, i.name, i.path FROM image i LEFT JOIN post_image p ON i.id = p.image_id WHERE p.post_id = $post_id ORDER BY p.`order`");
                    if (!$result) {
                        echo "Failed to fetch images: ".mysqli_error($con);
                    } else if (mysqli_num_rows($result) > 0) { ?>

                var hiddenImagesContainer = $('#hidden-images');

                <?php while ($image = mysqli_fetch_assoc($result)) {?>

                var mockFile = {
                    id: <?= $image['id'] ?>,
                    name: '<?= $image['name'] ?>',
                    size: '<?= filesize($image['path']) ?>'
                };

                dropzone.options.addedfile.call(dropzone, mockFile);

                dropzone.options.thumbnail.call(dropzone, mockFile, "<?= $image['path'] ?>");

                var hiddenInput = "<input type=\"hidden\" id=\"post-image-<?= $image['id'] ?>\" name=\"post_images[" + hiddenImagesContainer.children().length + "]\" value=\"<?= $image['id'] ?>\" />";

                hiddenImagesContainer.append(hiddenInput);

                <?php }
                }?>

            }

            function deletePost(id) {
                jQuery.ajax('PHP/delete_post.php', {
                    data: {id: id},
                    success: function (data, status, jqXHR) {
                        window.location.href = "blog.php";
                    },
                    error: function (jqXHR, status, error) {
                        alert("Failed to delete post: " + error);
                    }
                });
            }
        </script>
    <?php }
}?>

<?php include("footer.php"); ?>

</body>
</html>