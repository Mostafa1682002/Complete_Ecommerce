<?php
$title = 'Members';
$pagename = 'Members';
include_once('session.php');
include_once('connection.php');
include_once('includes/templates/header.php');
include_once('navbar.php');
$allMembers = $connection->query("SELECT * FROM `users` WHERE GroupID=0");
$allMembers = $allMembers->fetchAll(PDO::FETCH_ASSOC);

?>
<style>
    .row-table th,
    .row-table td {
        text-align: center !important;
        vertical-align: middle;
    }

    .table-responsive {
        white-space: nowrap;
    }
</style>
<h1 class="text-center text-secondary my-4">Manage Member</h1>
<div class="px-2 py-3 container">
    <div class="table-responsive">
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr class="bg-dark text-light row-table">
                    <th>#ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Full Name</th>
                    <th>Register Date</th>
                    <th>Image</th>
                    <th>Control</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allMembers as $member) { ?>
                    <tr class='row-table'>
                        <td><?php echo $member['UserID'] ?></td>
                        <td><?php echo $member['Username'] ?></td>
                        <td><?php echo $member['Email'] ?></td>
                        <td><?php echo $member['FullName'] ?></td>
                        <td><?php echo $member['Date'] ?></td>
                        <td>
                            <img src="includes/uploads/<?php echo $member['ImgeUser'] ?>" alt="" class="img-table">
                        </td>
                        <td>
                            <a href="editeMember.php?id=<?php echo $member['UserID'] ?>&username=<?php echo $member['Username'] ?>" class=" btn btn-success btn-sm"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                            <a href="deleteMember.php?id=<?php echo $member['UserID'] ?>&username=<?php echo $member['Username'] ?>&imge=<?php echo $member['ImgeUser'] ?>" class="btn btn-danger btn-sm confirm"><i class="fa-sharp fa-solid fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                <?php } ?>
                <?php
                for ($i = 50; $i < 100; $i++) {
                    echo "
                    <tr class='row-table'>
                            <td>$i</td>
                            <td>System Architect</td>
                            <td>system@gmail.com</td>
                            <td>VVVVVVVVVVVVVVVV</td>
                            <td>2011-04-25</td>
                            <td>
                            <img src='includes/uploads/photo_2022-10-05_20-10-30.jpg' alt='' class='img-table'>
                            </td>
                            <td>
                            <a href='#' class=' btn btn-success btn-sm'>Edit</a>
                            <a href='#' class='btn btn-danger btn-sm confirm'>Delete</a>
                        </td>
                        </tr>
                    ";
                }
                ?>
            </tbody>
        </table>
        <a href="addMember.php" class="btn btn-primary my-4 btn-sm"><i class="fa-solid fa-plus"></i> Add New Member</a>
    </div>
</div>
<?php
include_once('includes/templates/footer.php');
?>