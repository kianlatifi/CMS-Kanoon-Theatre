<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $setting['title']; ?></title>
    <link rel="shortcut icon" href="http://localhost/<?php echo $setting['icon'] ?>" type="image/x-icon" />

    <link href="http://localhost/public/css/app/style.php" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

</head>

<body>
    <section class="app">
        <header>
            <nav class="header">
                <?php if (!isset($_SESSION) or $_SESSION == null) { ?>
                    <a role="button" class="login" href="http://localhost/login">ورود</a>
                    <a role="button" class="register" href="http://localhost/register">عضویت</a>
                <?php } else { ?>
                    <a role="button" class="logout" href="http://localhost/log-out">خروج از حساب</a>
                    <?php

                    ?>
                <?php } ?>
                <a href="http://localhost">
                    <img class="header-logo" src="http://localhost/<?php echo $setting['logo']; ?>" alt="">
                </a>
                <button class="header-menu-burger" onclick="showMenu()" type="button"><i class="fas fa-bars"></i></button>
                <ul class="header-menu" id="menu">
                    <?php foreach ($menus as $menu) { ?>
                        <li class="header-menu-item"><?php if ($menu['parent_id'] == null) { ?>
                                <a class="header-menu-item-link" href="<?php echo $menu['url'] ?>">
                                    <?php echo $menu['name'] ?>
                                </a> <?php } ?>
                            <?php if ($menu['submenu_count'] > 0) { ?>
                                <span>
                                    <?php foreach ($submenus as $submenu) {
                                        if ($submenu['parent_id'] == $menu['id']) { ?>
                                            <a href="<?php echo $submenu['url'] ?>"><?php echo $submenu['name'] ?></a>
                                    <?php }
                                    } ?>
                                </span>
                            <?php } ?>
                        </li>
                    <?php } ?>
                </ul>
                <section class="clear-fix"></section>
            </nav>
            <!--end of navbar-->
        </header>
        <!--end of header-->