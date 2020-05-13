<?php
include 'includes/header.php';
include 'lib/user.php';

$user = new user;
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['createaccount'])){
    $createaccount = $user->createAccount($_POST);
}
?>

<div class="w-50 myform mt-5">
    <div class="card">
        <div class="card-header bg-dark">
            <h6 class="text-white">Create a new account</h6>
        </div>
        <div class="card-body">

<?php
if(isset($createaccount)){
    echo $createaccount;
}
?>

        <form action="" method="post">            
            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" name="name" class="form-control" id="name"  >

            </div>            
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" id="username"  >

            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" name="email" class="form-control" id="email"  >

            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password"  >
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="terms">
                <label class="form-check-label" for="terms">I agree to all <a href="#" class="text-decoration-none">terms and condtions</a></label>
            </div>
            <button type="submit" name="createaccount" class="btn btn-primary mr-2">Submit</button>
            <a href="" class="text-decoration-none">Already have an account?</a>
        </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>