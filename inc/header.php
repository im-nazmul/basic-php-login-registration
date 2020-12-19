<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath."/../lib/Session.php");
    Session::init();
    include "classes/User.php"; 
    $user = new User();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>User Login Register System</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
</head>

<body>
    <header id="header">
        <div class="brand">
            <a href="index.php">Login Register System PHP &amp; PDO</a>
        </div>
        <nav class="navbar">
            <?php
                if(isset($_GET['action']) && $_GET['action'] == 'destroy'){
                    Session::destroy();
                }
            ?>
            <ul>
                <?php if(Session::get('login') == true){?>
                <li><a href="profile.php?userId=<?php echo Session::get('id');?>">Profile</a></li>
                <li><a href="?action=destroy">Logout</a></li>
                <?php } ?>
                <?php if(Session::get('login') == false){?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
                <?php } ?>
            </ul>
        </nav>
    </header>