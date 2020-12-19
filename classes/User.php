<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath."/../lib/Session.php");
    include_once ($filepath."/../lib/Database.php");
    include_once ($filepath."/../helpers/Format.php");

    class User{
        private $db;
        private $fm;
        
        public function __construct(){
            $this->db = new Database();
            $this->fm = new Format();
        }
        
        public function userRegistration($data){
            $name     = $this->fm->validation($data['name']);
            $username = $this->fm->validation($data['username']);
            $email    = $this->fm->validation($data['email']);
            $password = $this->fm->validation($data['password']);
            
            $mailChk  = $this->mailCheck($email);
            
            if(empty($name) || empty($username) || empty($email) || empty($password)){
                $msg = '<span class="error"><strong>Error!</strong> Field must not be empty.</span>';
                return $msg;
            }elseif(strlen($username) < 3){
                $msg = '<span class="error"><strong>Error!</strong> Username cann\'t be less then 3 charecter</span>';
                return $msg;
            }elseif(preg_match('/[^a-z0-9_-]+/i' , $username)){
                $msg = '<span class="error"><strong>Error!</strong> Username contain alphanumerical, deshes and underscore only.</span>';
                return $msg;
            }elseif(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
                $msg = '<span class="error"><strong>Error!</strong> Please use a valid email.</span>';
                return $msg;
            }elseif($mailChk == true){
                $msg = '<span class="error"><strong>Error!</strong> Email adress already exist.</span>';
                return $msg;
            }elseif(strlen($password) < 6){
                $msg = '<span class="error"><strong>Error!</strong> Password cann\'t be less then 6 charecter.</span>';
                return $msg;
            }else{
                $password = md5($password);
                $sql      = "INSERT INTO tbl_user(name, username, email, password) VALUES(:name, :username, :email, :password)";
                $query = $this->db->pdo->prepare($sql);
                $query->bindValue(':name', $name);
                $query->bindValue(':username', $username);
                $query->bindValue(':email', $email);
                $query->bindValue(':password', $password);
                $result = $query->execute();
                if($result != false){
                    $msg = '<span class="success"><strong>Registration Success!</strong> You can login now.</span>';
                    return $msg;
                }else{
                    $msg = '<span class="error"><strong>Error!</strong> Some thing went wrong while inserting data.</span>';
                    return $msg;
                }
            }
        }
        
        public function mailCheck($email){
            $sql   = "SELECT email FROM tbl_user WHERE email = :email";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(':email', $email);
            $query->execute();
            if($query->rowCount() > 0){
                return true;
            }else{
                return false;
                
            }
        }
        
        public function userLogin($data){   
            $email    = $this->fm->validation($data['email']);
            $password = $this->fm->validation($data['password']);
 
            if(empty($email) || empty($password)){
                $msg = '<span class="error"><strong>Error!</strong> Field must not be empty.</span>';
                return $msg;
            }else{
                $password = md5($password);
                $sql   = "SELECT * FROM tbl_user WHERE email = :email AND password = :password";
                $query = $this->db->pdo->prepare($sql);
                $query->bindValue(':email', $email);
                $query->bindValue(':password', $password);
                $query->execute();
                $result = $query->fetch(PDO::FETCH_OBJ);
                if($result){
                    Session::init();
                    Session::set("login", true);
                    Session::set("id", $result->userId);
                    Session::set("name", $result->name);
                    Session::set("username", $result->username);
                    Session::set("loginmsg", '<span class="success"><strong>Success!</strong> You are LogedIn.</span>');
                    header("Location: index.php");
                }else{
                    $msg = '<span class="error"><strong>Error!</strong> Email or Password didn\'t matched.</span>';
                    return $msg;
                }
            }
        }
        
        public function getUserData(){
            $sql   = "SELECT * FROM tbl_user ORDER BY userId DESC";
            $query = $this->db->pdo->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        }
        
        public function getUserDataById($userId){
            $sql   = "SELECT * FROM tbl_user WHERE userId = :userId";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(':userId', $userId);
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        }
        
        public function updateUserProfile($data, $userId){
            $name     = $this->fm->validation($data['name']);
            $username = $this->fm->validation($data['username']);
            
            if(Session::get('id') != $userId){
                exit();
                echo "<script>window.location = 'index.php'</script>";
            }
            
            if(empty($name) || empty($username)){
                $msg = '<span class="error"><strong>Error!</strong> Field must not be empty.</span>';
                return $msg;
            }elseif(strlen($username) < 3){
                $msg = '<span class="error"><strong>Error!</strong> Username cann\'t be less then 3 charecter.</span>';
                return $msg;
            }else{
                $sql = "UPDATE tbl_user SET name = :name, username = :username WHERE userId = :userId";
                $query = $this->db->pdo->prepare($sql);
                $query->bindValue(':name', $name);
                $query->bindValue(':username', $username);
                $query->bindValue(':userId', $userId);
                $result = $query->execute();
                if($result != false){
                    $msg = '<span class="success"><strong>Success!</strong> User Data Updated Successfuly.</span>';
                    return $msg;
                }else{
                    $msg = '<span class="error"><strong>Error!</strong> User Not Data Updated.</span>';
                    return $msg;
                }
            }
        }
        
        public function updateUserPassword($data, $userId){
            $oldpassword = $this->fm->validation($data['oldpassword']);
            $password    = $this->fm->validation($data['password']);
            
            if(Session::get('id') != $userId){
                exit();
                echo "<script>window.location = 'index.php'</script>";
            }
            
            if(empty($oldpassword) || empty($password)){
                $msg = '<span class="error"><strong>Error!</strong> Field must not be empty.</span>';
                return $msg;
            }elseif(strlen($password) < 6){
                $msg = '<span class="error"><strong>Error!</strong> New Password is too short.</span>';
                return $msg;
            }else{
                $oldpassword = md5($oldpassword);
                $password    = md5($password);
                
                $chk_sql   = "SELECT * FROM tbl_user WHERE password = :oldpassword AND userId = :userId";
                $chk_query = $this->db->pdo->prepare($chk_sql);
                $chk_query->bindValue(':oldpassword', $oldpassword);
                $chk_query->bindValue(':userId', $userId);
                $chk_query->execute();
                if($chk_query->rowCount() == 0){
                    $msg = '<span class="error"><strong>Error!</strong> Old Password Didn\'t Matched.</span>';
                    return $msg;
                }else{
                    $sql = "UPDATE tbl_user SET password = :password WHERE userId = :userId";
                    $query = $this->db->pdo->prepare($sql);
                    $query->bindValue(':password', $password);
                    $query->bindValue(':userId', $userId);
                    $result = $query->execute();
                    if($result != false){
                        $msg = '<span class="success"><strong>Success!</strong> User Password Updated Successfuly.</span>';
                        return $msg;
                    }else{
                        $msg = '<span class="error"><strong>Error!</strong> User Not Password Updated.</span>';
                        return $msg;
                    }
                }
            }
        }
    }
?>
