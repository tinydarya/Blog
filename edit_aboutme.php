<?php include("PHP/only_authorised.php"); ?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Tiny Darya || About me</title>
    <link rel="stylesheet" href="CSS/foundation.css" />
    <link rel="stylesheet" href="CSS/style.css" />
    <link rel="stylesheet" href="CSS/index_inside_style.css" />
    <link rel="stylesheet" href="CSS/edit_aboutme_style.css" />
    <link rel="stylesheet" href="CSS/classic.css" />
    <link rel="stylesheet" href="CSS/classic.date.css" />
    <link href='http://fonts.googleapis.com/css?family=Poiret+One&subset=latin,cyrillic,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="Assets/favicon.ico"/>
    <script src="http://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="JS/dropzone.js"></script>
    <script src="textboxio/textboxio.js"></script>
    <script src="JS/functions.js"></script>
</head>
<body onload="initPage();">


<?php
include("PHP/edit_aboutme.php");
include("header.php"); ?>

<!-- MAIN SECTION -->

        <?php
        require_once 'PHP/dbCon.php';

        $user_id = $_SESSION['user_id'];
        $user = mysqli_query($con, "SELECT * FROM user WHERE id = $user_id");

        if (!$user) {
            echo "Failed to fetch information";
        } else {
            $user = mysqli_fetch_assoc($user);

            $date = getdate(strtotime($user['dob']));
        ?>

<!-- Form-->
<form id="form" action="" method="post">
<div id="input-form" class="small-6 columns">

        <!-- Paragraph -->
        <p>Information will be published on your "About me" page.</p>

        <input type="hidden" name="id" value="<?php echo $user['id']; ?>" />

        <!-- Name -->
        <div>
            <label for="username">Name:</label>
            <input id="username" class="input" name="name" type="text" value="<?php echo $user['name']; ?>"/>
        </div>

        <!-- Location -->
        <div>
            <label for="location">Location:</label>
            <input  id="location" class="input" name="location" type="text" value="<?php echo $user['location']; ?>"/>
        </div>

        <!-- Birthday -->
        <div>
            <label for="dob">Birthday:</label>
            <input  id="dob" class="input" name="dob" type="text"/>
        </div>

        <!-- Email -->
        <div>
            <label for="email">Email: (changes on "Contact" page)</label>
            <input  id="email" class="input" name="email" type="text" value="<?php echo $user['email']; ?>"/>
        </div>

        <!-- Bio -->
        <div>
            <label for="bio">Bio:</label>
            <textarea id="bio" class="input" name="bio" cols="45" rows="20"><?php echo $user['bio']; ?></textarea>
        </div>

        <input type="hidden" id="user-image-id" name="image_id" <?php if (isset($user['image_id'])) { echo "value=\"".$user['image_id']."\""; } ?> />


</div>

<!-- Change profile picture -->
<div id="picture" class="small-6 columns">
    <div id="image-preview-container" class="dropzone-previews">
        <div id="image-preview" class="dz-preview dz-file-preview">
            <img id="image" data-dz-thumbnail />
            <div class="dz-error-message"><span data-dz-errormessage></span></div>
        </div>
    </div>

    <!-- Button -->
    <div id="upload">
        <input id="upload-button" type="button" value="Upload new picture" />
    </div>
<!--    </form>-->

</div>
<!-- Save button -->
<div id="container" class="small-12 columns">
    <input id="save-button" type="submit" value="Save" />
</div>
</form>



<?php include("footer.php"); ?>

<script src="JS/picker.js" language="JavaScript"></script>
<script src="JS/picker.date.js" language="JavaScript"></script>
<script src="JS/pickadate_ru_RU.js" language="JavaScript"></script>

<script>
    function initPage() {
        $('#dob').pickadate({
            formatSubmit: 'yyyy-mm-dd',
            hiddenName: true,
            max: true,
            selectYears: 100
        }).pickadate('picker').set('select', '<?php echo $user['dob']; ?>', {format: 'yyyy-mm-dd'});
        var dropzone = new Dropzone("#image-preview-container",
            {
                url: "upload.php",
                paramName: "fileToUpload",
                previewContainer: '#image-preview-container',
                previewTemplate: document.querySelector('#image-preview-container').innerHTML,
                acceptedFiles: 'image/*',
                clickable: '#upload-button',
                maxFilesize: 5 // MB
            });
        dropzone.on("addedfile", function (file) {
            $('#image-preview').remove();
        });
        dropzone.on("success", function (event, response) {
            if (response == -1) {
                //error uploading
            } else {
                $('#user-image-id').val(response);
            }
        });
        <?php $image_id = $user['image_id'];
                $result = mysqli_query($con, "SELECT * FROM image WHERE id = $image_id");
                if (!$result) {
                } else {
                    $result = mysqli_fetch_assoc($result);?>
        $('#image').attr('src', "<?php echo $result['path']; ?>");
        <?php }?>

        textboxio.replaceAll('textarea', {
            paste: {
                style: 'clean'
            }
        });
    }
</script>
<?php } ?>
</body>
</html>