<?php 
include_once("inc/header.php");
include_once("com/Admin.php");
include_once("inc/checksession.inc.php");

$temp = new Admin();

//  Handle Delete (single)
if (isset($_REQUEST["action"]) && $_REQUEST['action'] == 'delete') {
    $temp->deleteAdmin(); // uses your deleteAdmin()
}

?>

<div class="quick">
    <a href="add-edit-admin.php?action=add" style="float:right; padding-right:10px;">
        <h3>Add New Admin</h3>
    </a>
</div>

<div class="row">
    <div class="col-md-12">
        <!-- Admin Management Table -->
        <div class="panel panel-default">
            <div class="panel-heading">Admin Management</div>

            <div class="errordiv">
                <?php
                if (!empty($_SESSION['msg'])) {
                    echo '<div class="msg" style="cursor:pointer">' . $_SESSION['msg'] . '</div>';
                    unset($_SESSION['msg']);
                }
                if (!empty($_SESSION['errormsg'])) {
                    echo '<div class="errormsg" style="cursor:pointer">' . $_SESSION['errormsg'] . '</div>';
                    unset($_SESSION['errormsg']);
                }
                ?>
            </div>

            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>S No.</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $select = $db->fetchAssoc($db->fireQuery("SELECT * FROM `admin` WHERE `category` = 0 ORDER BY id DESC")) ?: [];

                            foreach ($select as $i => $row) {
                                ?>
                                <tr>
                                    <td><?= $i + 1; ?></td>
                                    <td><?= $row['username']; ?></td>
                                    <td><?= $row['email']; ?></td>
                                    <td><?= $row['admin_type']; ?></td>
                                    <td><?= $row['status']; ?></td>
                                    <td>
                                        <a href="add-edit-admin.php?action=edit&id=<?= siteEncrypt($row['id']); ?>" style="float:left; margin-right:10px;">
                                            <img src="images/edit_icon.png" alt="Edit" title="Edit" />
                                        </a>
                                        <?php if ($_SESSION['admin-type'] != 'Editor') { ?>
                                            <a id="delete_<?= siteEncrypt($row['id']); ?>" class="deleteAdmin" style="float:left;">
                                                <img src="images/delete_icon.png" alt="Delete" title="Delete" />
                                            </a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php
            if (empty($select)) {
                echo '<div align="center" style="font-weight:bold; color:#090;">No Admins Found</div>';
            }
            ?>
        </div>
    </div>
</div>

<script>
    $(document).on("click", ".deleteAdmin", function() {
        var id = $(this).attr('id').split('_')[1];
        if (confirm("Are you sure you want to delete this admin?")) {
            window.location.href = "admin-mgmt.php?action=delete&id=" + id;
        } else {
            return false;
        }
    });

    $(document).ready(function () {
        $('#dataTables-example').DataTable();
    });
</script>

<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.metisMenu.js"></script>
<script src="assets/js/custom.js"></script>
</body>
</html>
