<?php
include_once("inc/header.php");
include_once("com/Admin.php");
include_once("inc/checksession.inc.php");

$temp = new Admin();

// ✅ Delete single caller
if (isset($_REQUEST["action"]) && $_REQUEST['action'] == 'delete') {
    $temp->deleteCaller();
}

?>

<div class="quick">
    <a href="add-edit-caller.php?action=add" style="float:right; padding-right:10px;">
        <h3>Add New Caller</h3>
    </a>
</div>

<div class="row">
    <div class="col-md-12">
        <!-- Caller Management Table -->
        <div class="panel panel-default">
            <div class="panel-heading">Caller Management</div>

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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $callers = $db->fetchAssoc($db->fireQuery("SELECT * FROM `caller` ORDER BY id DESC")) ?: [];

                            foreach ($callers as $i => $row) {
                                ?>
                                <tr>
                                    <td><?= $i + 1; ?></td>
                                    <td><?= htmlspecialchars($row['name']); ?></td>
                                    <td><?= htmlspecialchars($row['email']); ?></td>
                                    <td><?= htmlspecialchars($row['phone']); ?></td>
                                    <td><?= htmlspecialchars($row['message']); ?></td>
                                    <td><?= htmlspecialchars($row['status']); ?></td>
                                    <td><?= htmlspecialchars($row['created_at']); ?></td>
                                    <td>
                                        <a href="add-edit-caller.php?action=edit&id=<?= siteEncrypt($row['id']); ?>" style="float:left; margin-right:10px;">
                                            <img src="images/edit_icon.png" alt="Edit" title="Edit" />
                                        </a>
                                        <a id="delete_<?= siteEncrypt($row['id']); ?>" class="deleteCaller" style="float:left;">
                                            <img src="images/delete_icon.png" alt="Delete" title="Delete" />
                                        </a>
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
            if (empty($callers)) {
                echo '<div align="center" style="font-weight:bold; color:#090;">No Callers Found</div>';
            }
            ?>
        </div>
    </div>
</div>

<script>
    $(document).on("click", ".deleteCaller", function() {
        var id = $(this).attr('id').split('_')[1];
        if (confirm("Are you sure you want to delete this caller?")) {
            window.location.href = "caller-mgmt.php?action=delete&id=" + id;
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
