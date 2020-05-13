<?php
include 'includes/header.php';
include 'lib/user.php';
Session::checkSession();

$user = new User();



if(isset($_GET['id'])){
    $userid = $_GET['id'];
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])){
    $userupdate = $user->userUpdate($userid, $_POST);
}
?>

<?php
    $sessionid = Session::get("id");
    if($sessionid == $userid){ ?>

<div class="w-50 myform mt-5">
    <div class="card">
        <div class="card-header bg-dark">
            <h6 class="text-white">Update your profile</h6>
        </div>
        <div class="card-body">

<?php
if(isset($userupdate)){
    echo $userupdate;
}
?>

<?php
$userdata = $user->getUserById($userid);
if($userdata){ ?>


    
        <form action="" method="post">
        <?php foreach($userdata as $userlist){ ?>            
            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $userlist['name']; ?>" id="name"  >

            </div>            
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $userlist['username']; ?>" id="username"  >

            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" name="email" class="form-control" value="<?php echo $userlist['email']; ?>" id="email"  >

            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="text" name="password" class="form-control" value="<?php echo $userlist['password']; ?>" id="password"  >
            </div>
        <?php } ?>
            <button type="submit" name="update" class="btn btn-info">Update</button>
        </form>
<?php } ?>
        </div>
    </div>
</div>

        <?php }else{
            echo "<div class='container'><div class='alert alert-warning mt-5 w-75'>* You are not authorized to update someone else profile</div></div>";
        }
        ?>

<?php include 'includes/footer.php'; ?>