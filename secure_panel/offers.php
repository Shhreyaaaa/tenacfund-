<?php
include_once 'inc/header.php';
include_once("inc/checksession.inc.php");
include_once("com/Offers.php");
include_once("com/PS_Pagination.php");

$rec_id = '';
$sel_adm = [];

if (isset($_REQUEST["action"]) && $_REQUEST["action"] == 'view') {
    $rec_id = $_REQUEST["id"];
    $sel_adm = $db->fetchAssoc($db->fireQuery("SELECT * FROM `user` WHERE id='$rec_id'"));
}

if (isset($_REQUEST["action"]) && $_REQUEST['action'] == 'status') {
    $temp = new Offers();
    ($_REQUEST["st"] == 'Inactive') ? $temp->checkActivate($_POST) : $temp->checkDeactivate($_POST);
}

if (isset($_REQUEST["action"]) && $_REQUEST['action'] == 'delete') {
    $temp = new Offers();
    $temp->deletePhoto($_POST);
}

if (isset($_POST["deactivate"])) {
    $temp = new Offers();
    $temp->checkDeactivate($_POST);
}

if (isset($_POST["delete"])) {
    $temp = new Offers();
    $temp->deleteRecord($_POST);
}

// Assign Offer
if (isset($_REQUEST["action"]) && $_REQUEST["action"] == 'assign') {
    $id = $_REQUEST['offerid'];
    $userid = $_REQUEST['userid'];

    $insert = $db->fireQuery("INSERT INTO assign_offer (`offerid`, `userid`, `date`) VALUES ('$id', '$userid', NOW())");

    if ($insert) {
        $_SESSION['msg'] = "Record(s) assigned successfully!";
    } else {
        $_SESSION['errormsg'] = "Record(s) not assigned!";
    }
    header("Location: offers.php?action=view&id=$userid");
    exit;
}

// Unassign Offer
if (isset($_REQUEST["action"]) && $_REQUEST["action"] == 'unassign') {
    $id = $_REQUEST['offerid'];
    $userid = $_REQUEST['userid'];

    $qry = $db->fireQuery("DELETE FROM `assign_offer` WHERE offerid = '$id' AND `userid`='$userid'");

    if ($qry) {
        $_SESSION['msg'] = "Record(s) unassigned successfully!";
    } else {
        $_SESSION['errormsg'] = "Record(s) not unassigned!";
    }
    header("Location: offers.php?action=view&id=$userid");
    exit;
}
?>

<div class="quick" style="">
    <a href="add-edit-offers.php?action=add" style="float:right; padding-right:10px;"><h3>Add New</h3></a>
</div>

<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Offers Management For (<?php echo isset($sel_adm[0]['name']) ? htmlspecialchars($sel_adm[0]['name']) : 'Unknown User'; ?>)
            </div>

            <div class="errordiv">
                <?php
                if (isset($_SESSION['msg']) && $_SESSION['msg']) {
                    echo '<div class="msg" style="cursor:pointer">' . $_SESSION['msg'] . '</div>';
                    unset($_SESSION['msg']);
                }
                if (isset($_SESSION['errormsg']) && $_SESSION['errormsg']) {
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
                                <th>URL</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $select = $db->fetchAssoc($db->fireQuery("SELECT * FROM `offers` WHERE `offertype`='exclusive' ORDER BY id DESC"));

                            if (!empty($select)) {
                                foreach ($select as $i => $offer) {
                                    $assigned = $db->fetchAssoc($db->fireQuery("SELECT * FROM `assign_offer` WHERE `offerid`='" . $offer['id'] . "' AND `userid`='" . $rec_id . "'"));
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $i + 1; ?></td>
                                        <td class="center"><?php echo htmlspecialchars($offer['name']); ?></td>
                                        <td class="center"><?php echo htmlspecialchars($offer['url']); ?></td>
                                        <td class="center">
                                            <?php if (!empty($assigned)) { ?>
                                                <a href="offers.php?action=unassign&offerid=<?php echo $offer["id"]; ?>&userid=<?php echo $rec_id; ?>" style="float: left;">Unassign Offer</a>
                                            <?php } else { ?>
                                                <a href="offers.php?action=assign&offerid=<?php echo $offer["id"]; ?>&userid=<?php echo $rec_id; ?>" style="float: left;">Assign Offer</a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr><td colspan="4" align="center"><strong>No Records Found</strong></td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="total-rez">
                <?php // echo $pager->renderFullNav(); ?>
            </div>
        </div>

        <!--End Advanced Tables -->
        <script>
            $(document).on("click", '.cancel', function () {
                var id = $(this).attr('id');
                var str = id.split('_');
                if (confirm("Are you sure you want to delete this?")) {
                    $(".cancel").attr("href", window.location.origin + '/cms/service-mgmt.php?action=delete&id=' + str[1]);
                } else {
                    return false;
                }
            });
        </script>
    </div>
</div>

<!-- Scripts -->
<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.metisMenu.js"></script>
<script>
    $(document).ready(function () {
        $('#dataTables-example').dataTable();
    });
</script>
<script src="assets/js/custom.js"></script>
</body>
</html>
