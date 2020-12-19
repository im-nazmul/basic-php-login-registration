<?php include "inc/header.php"; ?>
<?php Session::checkSession(); ?>

<style>
.submit {margin-bottom: 50px;}
</style>

<?php
    if(isset($_GET['userId']) && $_GET['userId'] != NULL){
        $userId = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['userId']);
    }else{
        echo "<script>window.location = 'index.php'</script>";
    }
    
    if(Session::get('id') != $userId){
        echo "<script>window.location = 'index.php'</script>";
    }
    
?>

<section id="body">
    <div class="list-head">
        <h2>Change Password</h2>
        <p><a class="view" href="profile.php?userId=<?php echo $userId; ?>">Back</a></p>
    </div>
    <div class="user-list">
        <div class="page-login">        
            <?php
                if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['changepassword'])){
                    $updatePass = $user->updateUserPassword($_POST, $userId);  
                    if(isset($updatePass)){
                       echo $updatePass; 
                    }
                }
            ?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="oldpassword">Old Password</label>
                    <input type="password" name="oldpassword" placeholder="Enter Your Old Password" id="oldpassword">
                </div>
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" name="password" placeholder="Enter Your New Password" id="password"/>
                </div>
                <button type="submit" name="changepassword" class="submit">Change Password</button>
            </form>
        </div>
    </div>
</section>

<?php include "inc/footer.php"; ?>
