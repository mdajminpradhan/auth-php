<?php
include 'includes/header.php';
include 'lib/user.php';
Session::checkSession();

$user = new user;
?>

<div class="container mt-5 mb-5 w-75">
<?php
$loginmsg = Session::get("loginmsg");
if(isset($loginmsg)){
    echo $loginmsg;
}
?>
    <div class="card">
        <div class="card-heading bg-dark">
            <div class="row p-2">
                <div class="col-sm-6"><h6 class="text-white">User list</h6></div>
                <div class="col-sm-6"><h6 class="text-white text-right">Welcome! 
                <?php 
                $name = Session::get("name");
                if(isset($name)){
                    echo $name;
                }
                ?></h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-dark">
            <thead>
                <tr>
                <th scope="col">Id</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
<?php
$userdata = $user->getUserList();
if($userdata){
    
    foreach($userdata as $userlist){
       
?>

                <tr>
                <th scope="row"><?php echo $userlist['id']; ?></th>
                <td><?php echo $userlist['name']; ?></td>
                <td><?php echo $userlist['email']; ?></td>
                <td><a href="profile.php?id=<?php echo $userlist['id']; ?>" class="btn btn-primary btn-sm">Update</a> <a href="" class="btn btn-danger btn-sm">Delete</a></td>
                </tr>

<?php } }else{ ?>
                <tr><td><h2>No User Data Found...</h2></td></tr>
<?php } ?>

            </tbody>
            </table>
        </div>
    </div>    
</div>

<?php include 'includes/footer.php'; ?>