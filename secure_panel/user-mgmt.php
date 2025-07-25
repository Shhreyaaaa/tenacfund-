<?php
include_once("inc/header.php");
include_once("com/User.php");
include_once("com/PS_Pagination.php");
include_once("inc/checksession.inc.php");

// Handle status toggle
if (isset($_REQUEST["action"]) && $_REQUEST['action'] == 'status') {
    $temp = new User();
    if ($_REQUEST["st"] == 'Inactive') {
        $temp->checkActivate($_REQUEST);
    } else {
        $temp->checkDeactivate($_REQUEST);
    }
}

// Handle single delete
if (isset($_REQUEST["action"]) && $_REQUEST['action'] == 'delete') {
    $temp = new User();
    $temp->deletePhoto($_REQUEST); // Use $_REQUEST so ID is found
}

// Handle bulk deactivate
if (isset($_POST["deactivate"])) {
    $temp = new User();
    $temp->checkDeactivate($_POST);
}

// Handle bulk delete
if (isset($_POST["delete"])) {
    $temp = new User();
    $temp->deleteRecord($_POST);
}
?>

<div class="quick">
    <a href="add-edit-user.php?action=add" style="float:right; padding-right:10px;">
        <h3>Add New</h3>
    </a>
    <a href="download.php" style="float:right; padding-right:10px;">
        <h3>Download</h3>
    </a>
</div>

<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">User Management</div>

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
                                <th>Status</th>
                                <th>Referred By</th>
                                <th>User Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $select = $db->fetchAssoc($db->fireQuery("SELECT * FROM `user` ORDER BY id DESC")) ?: [];

                            for ($i = 0; $i < count($select); $i++) {
                                $sels = $db->fetchAssoc($db->fireQuery("
                                    SELECT m.name 
                                    FROM booking AS b 
                                    JOIN membership AS m ON b.serviceid = m.id 
                                    WHERE b.userid = '" . $select[$i]['id'] . "' 
                                    ORDER BY b.id DESC
                                "));
                                $dd = (!empty($sels) && isset($sels[0]['name'])) ? $sels[0]['name'] : '';
                            ?>
                                <tr class="odd gradeX">
                                    <td>
                                        <?php if (!empty($dd)) { ?>
                                            <img src="images/primu.png" style="height:20px;left:25px" />
                                        <?php } ?>
                                        <?php echo $i + 1; ?>
                                    </td>
                                    <td><?php echo $select[$i]['name']; ?></td>
                                    <td><?php echo $select[$i]['email']; ?></td>
                                    <td><?php echo $select[$i]['phone']; ?></td>
                                    <td><?php echo $select[$i]['status']; ?></td>
                                    <td><?php echo $select[$i]['refereal']; ?></td>
                                    <td><?php echo ($select[$i]['login_type'] == 'Partner') ? 'Partner' : 'Member'; ?></td>
                                    <td class="center">
                                        <a href="click.php?action=view&id=<?php echo siteEncrypt($select[$i]["id"]); ?>" style="float:left;">Clicks || </a>
                                        <a href="offers.php?action=view&id=<?php echo $select[$i]["id"]; ?>" style="float:left;">Offers || </a>
                                        <a href="add-edit-user.php?action=edit&id=<?php echo siteEncrypt($select[$i]["id"]); ?>" style="float:left;">
                                            <img src="images/edit_icon.png" alt="Edit" title="Edit" />
                                        </a>
                                        <?php if ($_SESSION['admin-type'] != 'Editor') { ?>
                                            <a href="#" id="cancel_<?php echo siteEncrypt($select[$i]["id"]); ?>" class="cancel" style="float:left;">
                                                <img src="images/delete_icon.png" alt="Delete" title="Delete" />
                                            </a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php if (empty($select)) {
                echo '<div class="total-rez" align="center" style="font-weight:bold;width:898px;float:right; color:#090;">No Records Found</div>';
            } ?>

            <div class="total-rez"><?php  ?></div>
        </div>
    </div>
</div>

<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.metisMenu.js"></script>
<script>
    $(document).ready(function () {
        $('#dataTables-example').dataTable();
    });

    $(document).on("click", '.cancel', function (e) {
        e.preventDefault();
        var id = $(this).attr('id').split('_')[1];
        if (confirm("Are you sure you want to delete this?")) {
            window.location.href = "user-mgmt.php?action=delete&id=" + id;
        }
    });
</script>
<script src="assets/js/custom.js"></script>
</body>
</html>
