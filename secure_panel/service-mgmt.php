<?php 
include_once 'inc/header.php';
include_once("inc/checksession.inc.php");
include_once("com/Product.php");
include_once("com/PS_Pagination.php");

if (isset($_REQUEST["action"]) && $_REQUEST['action'] == 'status') {
    $temp = new Product();
    if ($_REQUEST["st"] == 'Inactive') {
        $temp->checkActivate($_POST);
    } else {
        $temp->checkDeactivate($_POST);
    }
}

if (isset($_REQUEST["action"]) && $_REQUEST['action'] == 'delete') {
    $temp = new Product();
    $temp->deletePhoto($_POST);
}

if (isset($_POST["deactivate"])) {
    $temp = new Product();
    $temp->checkDeactivate($_POST);
}

if (isset($_POST["delete"])) {
    $temp = new Product();
    $temp->deleteRecord($_POST);
}
?>

<div class="quick" style="">
    <a href="add-edit-service.php?action=add" style="float:right; padding-right:10px;">
        <h3>Add New</h3>
    </a>
</div>

<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">Service Management</div>

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
                            $select = $db->fetchAssoc($db->fireQuery("SELECT * FROM `product`"));
                            if (!is_array($select)) {
                                $select = [];
                            }

                            for ($i = 0; $i < count($select); $i++) {
                            ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i + 1; ?></td>
                                    <td class="center"><?php echo $select[$i]['name']; ?></td>
                                    <td class="center"><?php echo $select[$i]['url']; ?></td>
                                    <td class="center">
                                        <a href="add-edit-service.php?action=edit&&id=<?php echo siteEncrypt($select[$i]["id"]); ?>" style="background-image: none;float: left;">
                                            <img src="images/edit_icon.png" alt="Edit" title="Edit" />
                                        </a>
                                        <?php if ($_SESSION['admin-type'] != 'Editor') { ?>
                                            <a href="service-mgmt.php?action=delete&&id=<?php echo siteEncrypt($select[$i]["id"]); ?>" style="background-image: none;float: left;">
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
        <!-- End Advanced Tables -->

        <script>
            $(document).on("click", '.cancel', function () {
                var id = $(this).attr('id');
                var str = id.split('_');
                if (confirm("Are you sure you want to delete this?")) {
                    $(".cancel").attr("href", window.location.origin + '/cms/service-mgmt.php?action=delete&&id=' + str[1]);
                } else {
                    return false;
                }
            });
        </script>
    </div>
</div>

</div> <!-- PAGE INNER -->
</div> <!-- PAGE WRAPPER -->

<!-- SCRIPTS -->
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
