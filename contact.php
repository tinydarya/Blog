<?php include("PHP/session.php"); ?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Tiny Darya || Контакт</title>
    <link rel="stylesheet" href="CSS/foundation.css" />
    <link rel="stylesheet" href="CSS/style.css" />
    <link rel="stylesheet" href="CSS/contact_style.css" />
    <link href='http://fonts.googleapis.com/css?family=Poiret+One&subset=latin,cyrillic,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="Assets/favicon.ico"/>
    <script src="JS/functions.js"></script>
</head>
<body>

<?php include("header.php"); ?>

<!--MAIN SECTION-->

        <?php
        require_once 'PHP/dbCon.php';

        $user = mysqli_query($con, "SELECT * FROM user WHERE id = 1");

        if (!$user) {
            echo "Failed to fetch information";
        } else {
            $user = mysqli_fetch_assoc($user);

        ?>


    <div id="contact" class="small-12 columns">
        <div id="container">
            <h1 id="cont">Контакт:</h1>
                <p id="p-text">Пишите свои письма мне на емайл <a id="email" href="mailto:<?php echo $user['email']; ?>"><?php echo $user['email']; } ?></a> ^^ Буду очень рада! :)</p>
        </div>
    </div>

<?php include("footer.php"); ?>

</body>

</html>