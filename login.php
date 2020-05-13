<?php
include 'includes/header.php';
include 'lib/user.php';
Session::checkLogin();

$user = new user;
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])){
    $userlogin = $user->userLogin($_POST);
}
?>

<div class="w-50 myform mt-5 mb-5">
    <div class="card">
        <div class="card-header bg-dark">
            <h6 class="text-white">Login to your account</h6>
        </div>
        <div class="card-body">
<?php
if(isset($userlogin)){
    echo $userlogin;
}
?>
        <form action="" method="post">            
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" id="username" required="">

            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" required="">
            </div>
            <button type="submit" name="login" class="btn btn-primary mr-2">Login</button>
            <a href="" class="text-decoration-none">Don't have any account?</a>
        </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
