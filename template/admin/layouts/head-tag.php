<!doctype html>
<html lang="en">

<head>
    <?php if (!isset($db)) {
        $db = new \DataBase\DataBase();
    }
    $setting = $db->select("SELECT * FROM `websetting`; ")->fetch();
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $setting['title'] ?></title>
    <link rel="shortcut icon" href="http://localhost/<?php echo $setting['icon'] ?>" type="image/x-icon" />

    <link rel="stylesheet" href="http://localhost/public/css/admin/bootstrap.min.css" type="text/css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.6/css/mdb.min.css" rel="stylesheet">

    <link href="http://localhost/public/css/admin/style.css" rel="stylesheet" type="text/css">

</head>

<body>

    <nav class="navbar  navbar-light bg-gradiant-green-blue nav-shadow">

        <a class="navbar-brand" href="http://localhost/admin"><?php echo $setting['title'] ?></a>
        <span class="">
            <?php
            $unseenComments = $db->select("SELECT COUNT(*) FROM `comments` WHERE `status` = 'unseen' ;")->fetch();
            $username = $db->select("SELECT * FROM `users` WHERE( `id` = '".$_SESSION['user']."') ;")->fetch();
            ?>
            <a class="text-decoration-none px-3 text-dark" href="http://localhost/comment"><i class="fas fa-comments"></i>
                <?php if ($unseenComments['COUNT(*)']) { ?><span class="badge badge-danger"><?php echo $unseenComments['COUNT(*)'] ?></span><?php } ?> </a>
                <i class="fas fa-user"></i>
                <?php echo $username['username'] ?>
                <a class="px-3 text-dark" href="http://localhost/log-out">logout</a>
            <!-- <span class="dropdown">
                <a class="dropdown-toggle text-decoration-none text-dark" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                </div>
            </span> -->
        </span>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block pt-3 bg-sidebar sidebar px-0">
                <a class="text-decoration-none d-block py-1 px-2 mt-1" href="http://localhost/admin"><i class="fas fa-home"></i> Home</a>
                <a class="text-decoration-none d-block py-1 px-2 mt-1" href="http://localhost/category"><i class="fas fa-clipboard-list"></i> Category</a>
                <a class="text-decoration-none d-block py-1 px-2 mt-1" href="http://localhost/article"><i class="fas fa-newspaper"></i> Article</a>
                <a class="text-decoration-none d-block py-1 px-2 mt-1" href="http://localhost/comment"><i class="fas fa-comments"></i> Comment</a>
                <a class="text-decoration-none d-block py-1 px-2 mt-1" href="http://localhost/menu"><i class="fas fa-bars"></i> Menus</a>
                <a class="text-decoration-none d-block py-1 px-2 mt-1" href="http://localhost/user"><i class="fas fa-users"></i> User</a>
                <a class="text-decoration-none d-block py-1 px-2 mt-1" href="http://localhost/web-setting"><i class="fas fa-tools"></i> Web Setting</a>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">