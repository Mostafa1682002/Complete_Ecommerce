<?php
$title = 'Edit Member';
$pagename = 'Members';
include_once('session.php');
include_once('connection.php');
include_once('includes/templates/header.php');
include_once('navbar.php');
if (isset($_GET['id']) && isset($_GET['username'])) {
    $userID = $_GET['id'];
    $membername = $_GET['username'];
} else {
    header('Location: members.php');
    exit();
}

$userEdit = $connection->query("SELECT * FROM users WHERE UserID=$userID AND Username='$membername'");
if ($userEdit->rowCount() > 0) {
    $userEdit = $userEdit->fetch(PDO::FETCH_ASSOC);
    $oldname = $userEdit['Username'];
    $oldpassword = $userEdit['Password'];
    $oldemail = $userEdit['Email'];
    $oldfullname = $userEdit['FullName'];
    $oldimge = $userEdit['ImgeUser'];
} else {
    echo "<div class='container py-5'>
    <div class='alert alert-danger'>Member Is Not Exist</div>
    </div>";
    header('Refresh:3;url=members.php');
    exit();
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newname = $_POST['username'];
    $newpassword = empty($_POST['password']) ? $oldpassword : sha1($_POST['password']);
    $newemail = $_POST['email'];
    $newfullname = ucwords(strtolower($_POST['fullname']));
    $Errors = [];


    //Validate Form
    //validate Username
    if (empty($newname)) {
        $Errors['username_required'] = "Username Can't Be Empty";
    } elseif (strlen($newname) < 5) {
        $Errors['username_less'] = "Username Can't Be less Than 5 char";
    }
    //validate Email
    if (empty($newemail)) {
        $Errors['email_required'] = "Email Can't Be Empty";
    }
    //validate Full Name
    if (empty($newfullname)) {
        $Errors['fullname_required'] = "Full Name Can't Be Empty";
    } elseif (strlen($newfullname) < 5) {
        $Errors['fullname_less'] = "Full Name Can't Be less Than 5 char";
    }
    //Validate Password
    if (strlen($_POST['password']) < 5 && !empty($_POST['password'])) {
        $Errors['password_less'] = "Password Can't Be less Than 5 char";
    }

    //Check If No Errors Update Profile
    if (empty($Errors)) {
        //Check if Select Photo OR Not
        if (isset($_FILES['photo']) && !empty($_FILES['photo']['name'])) {
            $from = $_FILES['photo']['tmp_name'];
            $newimge = $_FILES['photo']['name'];
            $to = "includes/uploads/$newimge";
            $connection->query("UPDATE users SET `Username`='$newname' , `Email`='$newemail',`Password`='$newpassword' , `FullName`='$newfullname' ,ImgeUser='$newimge' WHERE `UserID`='$userID';");
            unlink("includes/uploads/$oldimge");
            move_uploaded_file($from, $to);
        } else {
            $connection->query("UPDATE users SET `Username`='$newname' , `Email`='$newemail',`Password`='$newpassword' , `FullName`='$newfullname'  WHERE `UserID`='$userID';");
        }
    }
}


?>
<h1 class="text-center text-secondary mt-4">Edit Memeber</h1>
<div class="container">
    <form method="POST" class="formEdit" enctype="multipart/form-data">
        <?php
        if (empty($Errors) && isset($_POST['edite'])) {
            echo "<div class='alert alert-success'>Updated Date Member</div>";
            //Refresh Page To Update Data
            header('Refresh:3;url=members.php');
            exit();
        }
        ?>
        <!-- User name Filed -->
        <div class="form-group my-3">
            <label for="username" class="control-label col-2">Username</label>
            <div class="col-sm-9 col-12 input-required">
                <input type="text" id="username" name="username" value="<?php echo $oldname ?>" class="form-control " autocomplete="off">
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
                <input type="email" id="email" name="email" value="<?php echo $oldemail ?>" class="form-control ">
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
                <input type="text" id="fullname" name="fullname" value="<?php echo $oldfullname ?>" class="form-control ">
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
                <input type="password" id="password" name="password" class="form-control input-pass" placeholder="new password" autocomplete="new-password">
                <i class="fas fa-eye show-pass"></i>
            </div>
        </div>
        <?php
        if (isset($Errors['password_less'])) {
            echo "<div class='alert alert-danger col-sm-9 col-12 ml-auto'>" . $Errors['password_less'] . "</div>";
        }
        ?>
        <!-- Photo Filed -->
        <div class="form-group my-3">
            <label for="userPhoto" class="control-label col-2">Photo :</label>
            <div class="col-sm-9 col-12 file">
                <input type="file" name="photo" id="userPhoto" class="form-control input-file" accept="image/*">
                <span class="span-file">Select Photo</span>
            </div>
        </div>
        <img src="includes/uploads/<?php echo $oldimge ?>" id="photo" class="photo" alt="">
        <!-- Button Filed -->
        <div class="form-group my-3">
            <label for=""></label>
            <div class="col-offset-2 col-sm-9 col-12">
                <input type="submit" value="Edit" name="edite" class="btn btn-primary d-block w-100">
            </div>
        </div>
    </form>
</div>
<?php
include_once('includes/templates/footer.php');
?>