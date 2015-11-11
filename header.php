<!-- NAVIGATION -->
<div id="navigation" class="small-12 columns">
    <!-- Secondary navigation with links-->
    <div id="secondary-navigation" class="row">
        <ul>
            <li class="nav-item"><a href="index.php" accesskey="H">Главная</a></li>
            <li class="nav-item"><a href="aboutme.php" accesskey="M">Обо мне</a></li>
            <li class="nav-item"><a href="blog.php" accesskey="B">Блог</a></li>
            <li class="nav-item"><a href="archive.php" accesskey="A">Архив</a></li>
            <li class="nav-item"><a href="browse.php" accesskey="W">Поиск</a></li>
            <li class="nav-item"><a href="contact.php" accesskey="C">Контакт</a></li>
        </ul>
    </div>

    <!-- Main navigation with big icons-->
    <div id="main-navigation" class="row">
        <div class="small-6 columns">
            <div id="name">
                    <span id="top-name"><a href="index.php">TINY DARYA</a></span>
            </div>
        </div>
        <div id="icons" class="small-6 columns">

            <?php if ($authorized) {?>
                <div class="nav-icon"><a href="?logout"><i class="fi-lock" title="Выйти"></i></a></div>
                <div class="nav-icon"><a href="new_post.php"><i class="fi-pencil" title="Новый пост"></i></a></div>
            <?php } ?>

            <div class="nav-icon"><a href="browse.php"><i class="fi-magnifying-glass" title="Поиск"></i></a></div>
            <div class="nav-icon" onclick="toggleNav()"><i class="fi-list" title="Раскрыть меню"></i></div>

        </div>
    </div>
</div>