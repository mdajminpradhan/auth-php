<?php
include 'database.php';
include_once 'session.php';

class user{
    private $db;
    public function __construct(){
        $this->db = new database;
    }


    //user registration mechanism started from here

    // User account registration codes are written here

    public function createAccount($data){

        //variable dicliaration

        $name       = $data['name'];
        $username   = $data['username'];
        $email      = $data['email'];
        $password   = md5($data['password']);
        $emailcheck = $this->emailCheck($email);

        //field validation

        //empty value check
        if($name == "" OR $username == "" OR $email == "" OR $password == ""){
            $msg = "<div class='alert alert-danger'><strong>Error! </strong>Field must not be empty</div>";
            return $msg;
        }

        //name length validation
        if(strlen($name) < 3){
            $msg = "<div class='alert alert-danger'><strong>Error! </strong>Name is too short</div>";
            return $msg;
        }elseif(strlen($name) > 30){
            $msg = "<div class='alert alert-danger'><strong>Error! </strong>Name is too long</div>";
            return $msg;
        }elseif(preg_match('/^[a-z\d_]{2,20}$/i', $name)){
            $msg = "<div class='alert alert-danger'><strong>Error! </strong>Name should contain alphanumerical value only</div>";
            return $msg;
        }

        //username length validation
        if(strlen($username) < 3){
            $msg = "<div class='alert alert-danger'><strong>Error! </strong>Username is too short</div>";
            return $msg;
        }elseif(strlen($username) > 30){
            $msg = "<div class='alert alert-danger'><strong>Error! </strong>Username is too long</div>";
            return $msg;
        }


        //email validation
        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            $msg = "<div class='alert alert-danger'><strong>Error! </strong>Email is not valid</div>";
            return $msg;
        }


        //email existence validation
        if($emailcheck == true){
            $msg = "<div class='alert alert-danger'><strong>Error! </strong>Email already exist</div>";
            return $msg;
        }

        
        //password validation
        if(strlen($password) < 5){
            $msg = "<div class='alert alert-danger'><strong>Error! </strong>Password is too short</div>";
            return $msg;
        }elseif(strlen($password) > 50){
            $msg = "<div class='alert alert-danger'><strong>Error! </strong>Password is too long</div>";
            return $msg;
        }


        //inserting data into database
        $sql = "insert into user (name, username, email, password) values (:name, :username, :email, :password)";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':name', $name);
        $query->bindValue(':username', $username);
        $query->bindValue(':email', $email);
        $query->bindValue(':password', $password);
        $result = $query->execute();
        if($result){
            $msg = "<div class='alert alert-success'><strong>Success! </strong>Your account is created</div>";
            return $msg;
        }else{
            $msg = "<div class='alert alert-danger'><strong>Error! </strong>Something went wrong. Please try again later</div>";
            return $msg;
        }

    }


    //email existence check

    public function emailCheck($email){
        
        $sql = "select email from user where email=:email";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':email', $email);
        $query->execute();
        
        if($query->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }


    //user registration mechanism end here


    //user login mechanism started from here

    public function userLogin($data){
        $username = $data['username'];
        $password = md5($data['password']);

        if($username == "" OR $password == ""){
            $msg = "<div class='alert alert-danger'><strong>Error! </strong>Field must not be empty</div>";
            return $msg;
        }

        //username length validation
        if(strlen($username) < 3){
            $msg = "<div class='alert alert-danger'><strong>Error! </strong>Username is too short</div>";
            return $msg;
        }elseif(strlen($username) > 30){
            $msg = "<div class='alert alert-danger'><strong>Error! </strong>Username is too long</div>";
            return $msg;
        }

        //password validation
        if(strlen($password) < 5){
            $msg = "<div class='alert alert-danger'><strong>Error! </strong>Password is too short</div>";
            return $msg;
        }elseif(strlen($password) > 50){
            $msg = "<div class='alert alert-danger'><strong>Error! </strong>Password is too long</div>";
            return $msg;
        }

        $result = $this->getLoginUser($username, $password);
        if($result){
            Session::init();
            Session::set("login",true);
            Session::set("id",$result->id);
            Session::set("name",$result->name);
            Session::set("username",$result->username);
            Session::set("loginmsg","<div class='alert alert-success'><strong>Success! </strong>You are logged in</div>");
            header("Location: index.php");
        }else{
            $msg = "<div class='alert alert-danger'><strong>Error! </strong>Data not found</div>";
            return $msg;
        }

    }

    public function getLoginUser($username, $password){
        $sql = "select * from user where username=:username AND password=:password limit 1";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':username', $username);
        $query->bindValue(':password', $password);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    

    //read data

    public function getUserList(){
        $sql = "select * from user order by id desc";
        $query = $this->db->pdo->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    
    //update data

    public function getUserById($id){
        $sql = "select * from user where id=:id limit 1";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':id', $id);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    public function userUpdate($userid, $data){

        //variable dicliaration

        $name       = $data['name'];
        $username   = $data['username'];
        $email      = $data['email'];
        $password   = md5($data['password']);

        //field validation

        //empty value check
        if($name == "" OR $username == "" OR $email == "" OR $password == ""){
            $msg = "<div class='alert alert-danger'><strong>Error! </strong>Field must not be empty</div>";
            return $msg;
        }

        //updating data on database
        $sql = "UPDATE `user` SET 
                            `name`      =:name,
                            `username`  =:username,
                            `email`     =:email,
                            `password`  =:password
                            WHERE id    =:id";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':name', $name);
        $query->bindValue(':username', $username);
        $query->bindValue(':email', $email);
        $query->bindValue(':password', $password);
        $query->bindValue(':id', $userid);
        $result = $query->execute();
        if($result){
            $msg = "<div class='alert alert-success'><strong>Success! </strong>Your profile is updated</div>";
            return $msg;
        }else{
            $msg = "<div class='alert alert-danger'><strong>Error! </strong>Something went wrong. Please try again later</div>";
            return $msg;
        }

    }

}