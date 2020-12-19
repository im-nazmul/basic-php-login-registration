<?php include "inc/header.php"; ?>
<?php Session::checkSession(); ?>

<style>
    .submit {margin-bottom: 50px;}
.readonly{border: 1px solid red !important;}
</style>

<?php
    if(isset($_GET['userId']) && $_GET['userId'] != NULL){
        $userId = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['userId']);
    }else{
        echo "<script>window.location = 'index.php'</script>";
    }
?>

<section id="body">
    <div class="list-head">
        <h2>User Profile</h2>
        <p><a class="view" href="index.php">Back</a></p>
    </div>
    <div class="user-list">
        <div class="page-login">

                
            <?php
                if(Session::get('id') != $userId){
                    $userdata = $user->getUserDataById($userId);
                    if($userdata){
                        foreach($userdata as $data){
            ?>
            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" name="name" value="<?php echo $data['name']; ?>" id="name" readonly/>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" value="<?php echo $data['username']; ?>" id="username" readonly/>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="text" name="email" value="<?php echo $data['email']; ?>" id="email" readonly />
            </div>
            <?php } } } ?>


            <?php 
                if(Session::get('id') == $userId){
            ?>
            
            <?php
                if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])){
                    $updateUser = $user->updateUserProfile($_POST, $userId);  
                    if(isset($updateUser)){
                       echo $updateUser; 
                    }
                }
            ?>
            <form action="" method="post">
                <?php
                    $userdata = $user->getUserDataById($userId);
                    if($userdata){
                        foreach($userdata as $data){
                ?>
                <div class="form-group">
                    <label for="name">Your Name</label>
                    <input type="text" name="name" value="<?php echo $data['name']; ?>" id="name" />
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" value="<?php echo $data['username']; ?>" id="username">
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input class="readonly" type="text" name="email" value="<?php echo $data['email']; ?>" id="email" readonly />
                </div>
                <button type="submit" name="update" class="submit">Update</button>
                <a href="changepassword.php?userId=<?php echo $data['userId']; ?>" class="view">Change Password</a>   
                <?php } } ?>
                
                <?php } ?>
            </form>
        </div>
    </div>
</section>

<?php include "inc/footer.php"; ?>
