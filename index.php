<?php include "inc/header.php"; ?>
<?php Session::checkSession(); ?>

<?php
    $loginmsg = Session::get('loginmsg');  
    if(isset($loginmsg)){
       echo $loginmsg; 
    }
    Session::set('loginmsg', Null)
?>
<section id="body">
    <div class="list-head">
        <h2>User List</h2>
        <p>Welcome! <span><?php echo ucfirst(Session::get('username')); ?></span></p>
    </div>
    <div class="user-list">
        <div class="list-body">
            <table class="tblone">
                <tr>
                    <th>Serial</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email Address</th>
                    <th>Action</th>
                </tr>
                <?php
                    $userdata = $user->getUserData();
                    if($userdata){
                        $i = 0;
                        foreach($userdata as $data){
                            $i++
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $data['name']; ?></td>
                    <td><?php echo $data['username']; ?></td>
                    <td><?php echo $data['email']; ?></td>
                    <td><a class="view" href="profile.php?userId=<?php echo $data['userId']; ?>">View</a></td>
                </tr>
                <?php } } ?>
            </table>
        </div>
    </div>
</section>

<?php include "inc/footer.php"; ?>
