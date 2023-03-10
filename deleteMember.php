<?php
$pagename = 'Members';
include_once('session.php');
include_once('connection.php');
include_once('includes/templates/header.php');
include_once('navbar.php');
if (isset($_GET['id']) && isset($_GET['username'])) {
    $id = $_GET['id'];
    $membername = $_GET['username'];
    $imge = $_GET['imge'];
} else {
    header('Location: members.php');
    exit();
}

$member = $connection->query("SELECT * FROM users WHERE UserID=$id AND Username='$membername'");
if ($member->rowCount() > 0) {
    $connection->query("DELETE FROM `users` WHERE `UserID`=$id AND `Username`='$membername'");
    //Delete photo User
    unlink("includes/uploads/$imge");
    echo   "<div class='container py-5'>
                <div class='alert alert-success'>Successed Deleted Member  Name : $membername</div>
            </div>";
    header('Refresh:3;url=members.php');
    exit();
} else {
    echo    "<div class='container py-5'>
                <div class='alert alert-danger'>Member Is Not Exist</div>
            </div>";
    header('Refresh:3;url=members.php');
    exit();
}

if ($userDelete) {
}

?>
<?php
include_once('includes/templates/footer.php');
?>