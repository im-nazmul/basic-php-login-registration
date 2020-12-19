<?php include "inc/header.php"; ?>
<?php Session::checkLogin(); ?>

<style>
.submit {margin-bottom: 50px;}
</style>

<section id="body">
    <div class="list-head">
        <h2>User Registration</h2>
    </div>
    <div class="user-list">
        <div class="page-login">
            <?php
                if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])){
                    $regiUser = $user->userRegistration($_POST);  
                    if(isset($regiUser)){
                       echo $regiUser; 
                    }
                }
            ?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="name">Your Name</label>
                    <input type="text" name="name" placeholder="Enter Your Name" id="name" />
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" placeholder="Enter Username" id="username" />
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="text" name="email" placeholder="Enter Email Address" id="email" />
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" placeholder="Enter Password" id="password">
                </div>
                <button type="submit" name="register" class="submit">Login</button>
            </form>
        </div>
    </div>
</section>

<?php include "inc/footer.php"; ?>
