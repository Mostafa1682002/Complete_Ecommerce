<?php
$pagename = 'Members';
include_once('session.php');
include_once('connection.php');
include_once('includes/templates/header.php');
include_once('navbar.php');

if (isset($_POST['addmember'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashpassword = sha1($password);
    $email = $_POST['email'];
    $fullname = ucwords(strtolower(filter_var($_POST['fullname'], FILTER_SANITIZE_STRING)));
    $photo = isset($_FILES['photo']) ? $_FILES['photo']['name'] : '';
    $Errors = [];

    // Validate Form
    // validate Username
    if (empty($username)) {
        $Errors['username_required'] = "Username Can't Be Empty";
    } elseif (strlen($username) < 5) {
        $Errors['username_less'] = "Username Can't Be less Than 5 char";
    }
    //validate Email
    if (empty($email)) {
        $Errors['email_required'] = "Email Can't Be Empty";
    }
    //validate Full Name
    if (empty($fullname)) {
        $Errors['fullname_required'] = "Full Name Can't Be Empty";
    } elseif (strlen($fullname) < 5) {
        $Errors['fullname_less'] = "Full Name Can't Be less Than 5 char";
    }
    //Validate Password
    if (empty($password)) {
        $Errors['password_required'] = "Password Can't Be Empty";
    } elseif (strlen($password) < 5) {
        $Errors['password_less'] = "Password Can't Be less Than 5 char";
    }
    //Validate Photo
    if (empty($photo)) {
        $Errors['photo_required'] = "Photo Can't Be Empty";
    }

    //Check If No Errors Update Profile
    if (empty($Errors)) {
        $from = $_FILES['photo']['tmp_name'];
        $imge = $_FILES['photo']['name'];
        $to = "includes/uploads/$imge";
        move_uploaded_file($from, $to);
        $connection->query("INSERT INTO `users` ( `UserID`,`Username`, `Email`,`Password` , `FullName`,`Date`,`ImgeUser`) VALUES(NULL,'$username','$email','$hashpassword','$fullname',now(),'$photo')");
    }
}


?>
<h1 class="text-center text-secondary mt-4">Add New Member</h1>
<div class="container">
    <form method="POST" class="formEdit" enctype="multipart/form-data">
        <?php
        if (empty($Errors) && isset($_POST['addmember'])) {
            echo "<div class='alert alert-success'>Successed Added Member</div>";
            //Refresh Page To Update Data
            header('Refresh:3;url=members.php');
            exit();
        }
        ?>
        <!-- User name Filed -->
        <div class="form-group my-3">
            <label for="username" class="control-label col-2">Username</label>
            <div class="col-sm-9 col-12 input-required">
                <input type="text" id="username" name="username" class="form-control" value="<?php echo isset($_POST['addmember']) && !empty($Errors) ? $username : ''; ?>" placeholder="Username To Login" autocomplete="off">
            </div>
        </div>
        <?php
        if (isset($Errors['username_required'])) {
            echo "<div class='alert alert-danger col-sm-9 col-12 ml-auto'>" . $Errors['username_required'] . "</div>";
        } elseif (isset($Errors['username_less'])) {
            echo "<div class='alert alert-danger col-sm-9 col-12 ml-auto'>" . $Errors['username_less'] . "</div>";
        }
        ?>
        <!-- Email Filed -->
        <div class="form-group my-3">
            <label for="email" class="control-label col-2">Email</label>
            <div class="col-sm-9 col-12 input-required">
                <input type="email" id="email" name="email" class="form-control" value="<?php echo isset($_POST['addmember']) && !empty($Errors) ? $email : ''; ?>" placeholder="Email">
            </div>
        </div>
        <?php
        if (isset($Errors['email_required'])) {
            echo "<div class='alert alert-danger col-sm-9 col-12 ml-auto'>" . $Errors['email_required'] . "</div>";
        }
        ?>
        <!-- FullName Filed -->
        <div class="form-group my-3">
            <label for="fullname" class="control-label col-2">Full Name</label>
            <div class="col-sm-9 col-12 input-required">
                <input type="text" id="fullname" name="fullname" class="form-control" value="<?php echo isset($_POST['addmember']) && !empty($Errors) ? $fullname : ''; ?>" placeholder="Full Name ">
            </div>
        </div>
        <?php
        if (isset($Errors['fullname_required'])) {
            echo "<div class='alert alert-danger col-sm-9 col-12 ml-auto'>" . $Errors['fullname_required'] . "</div>";
        } elseif (isset($Errors['fullname_less'])) {
            echo "<div class='alert alert-danger col-sm-9 col-12 ml-auto'>" . $Errors['fullname_less'] . "</div>";
        }
        ?>
        <!-- Password Filed -->
        <div class="form-group my-3">
            <label for="password" class="control-label col-2">Password</label>
            <div class="col-sm-9 col-12 input-required">
                <input type="password" id="password" name="password" class="form-control input-pass" value="<?php echo isset($_POST['addmember']) && !empty($Errors) ? $password : ''; ?>" placeholder="Password" autocomplete="new-password">
                <i class="fas fa-eye show-pass"></i>
            </div>
        </div>
        <?php
        if (isset($Errors['password_required'])) {
            echo "<div class='alert alert-danger col-sm-9 col-12 ml-auto'>" . $Errors['password_required'] . "</div>";
        } elseif (isset($Errors['password_less'])) {
            echo "<div class='alert alert-danger col-sm-9 col-12 ml-auto'>" . $Errors['password_less'] . "</div>";
        }
        ?>
        <!-- Photo Filed -->
        <div class="form-group my-3">
            <label for="userPhoto" class="control-label col-2">Photo :</label>
            <div class="col-sm-9 col-12 file input-required">
                <input type="file" name="photo" id="userPhoto" class="form-control input-file" accept="image/*">
                <span class="span-file">Select Photo</span>
            </div>
        </div>
        <?php
        if (isset($Errors['photo_required'])) {
            echo "<div class='alert alert-danger col-sm-9 col-12 ml-auto'>" . $Errors['photo_required'] . "</div>";
        }
        ?>
        <img src="" id="photo" class="photo" alt="">
        <!-- Button Filed -->
        <div class="form-group my-3">
            <label for=""></label>
            <div class=" col-sm-9 col-12 ">
                <input type="submit" value="Add Member" name="addmember" class="btn btn-primary d-block w-100">
            </div>
        </div>
    </form>
</div>
<?php
include_once('includes/templates/footer.php');
?>