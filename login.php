<?php include("PHP/loginProcess.php"); ?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Tiny Darya || Login</title>
    <link rel="stylesheet" href="CSS/foundation.css" />
    <link rel="stylesheet" href="CSS/login_style.css" />
    <link href='http://fonts.googleapis.com/css?family=Poiret+One&subset=latin,cyrillic,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="Assets/favicon.ico"/>
</head>
<body>

<!-- Log in -->
<div id="login">
    <!-- Title -->
    <div id="title">
        <p id="lily"><a id="home" href="index.php">TINY DARYA</a></p>
    </div>

    <!-- Form -->

    <form id="form" action="" method="post">

        <!-- Email -->
        <div class="field">
            <label for="email" class="field-name">Email:</label>

            <div>
                <?php if (isset($errmsg_email)) echo $errmsg_email; ?>
                <input id="email" class="input" name="email" type="text"/>
            </div>
        </div>

        <!-- Password -->
        <div class="field">

            <label for="password" class="field-name">Password:</label>

            <div>
                <?php if (isset($errmsg_password)) echo $errmsg_password; ?>
                <input id="password" class="input" name="password" type="password"/>
            </div>

        </div>

        <!-- Button -->
        <div id="btn">
            <input id="button" type="submit" value="Log in" />
            <?php if (isset($noUser)) echo $noUser;?>
        </div>

        <!-- Text -->
        <div id="paragraph">

            <!-- Reminder -->
<!--            <p id="reminder">Lost your password?</p>-->

            <!-- Back to website -->
            <div id="icon">
                <i class="fi-arrow-left"></i>
                <span><a id="back" href="index.php">Back to website</a></span>
            </div>

        </div>

    </div>

</div>
</div>
</body>
</html>