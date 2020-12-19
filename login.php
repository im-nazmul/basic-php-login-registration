<?php include "inc/header.php"; ?>
<?php Session::checkLogin(); ?>

<section id="body">
    <div class="list-head">
        <h2>User Login</h2>
    </div>
    <div class="user-list">
        <div class="page-login">
            <?php
                if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])){
                    $userLogin = $user->userLogin($_POST);  
                    if(isset($userLogin)){
                       echo $userLogin; 
                    }
                }
            ?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="text" name="email" placeholder="Enter Email Address" id="email" />
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" placeholder="Enter Password" id="password">
                </div>
                <button type="submit" name="login" class="submit">Login</button>
            </form>
        </div>
    </div>
</section>

<?php include "inc/footer.php"; ?>
