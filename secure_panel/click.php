<?php
include_once("inc/header.php");
include_once("com/Category.php");
include_once("com/PS_Pagination.php");
include_once("inc/checksession.inc.php");

$rec_id = '';
if (isset($_REQUEST["action"]) && $_REQUEST["action"] == 'view') {
    $rec_id = siteDecrypt($_REQUEST["id"]);
}

if (isset($_REQUEST["action"]) && $_REQUEST['action'] == 'status') {
    $temp = new Category();
    if ($_REQUEST["st"] == 'Inactive') {
        $temp->checkActivate($_POST);
    } else {
        $temp->checkDeactivate($_POST);
    }
}

if (isset($_REQUEST["action"]) && $_REQUEST['action'] == 'delete') {
    $temp = new Category();
    $temp->deletePhoto($_POST);
}

if (isset($_POST["deactivate"])) {
    $temp = new Category();
    $temp->checkDeactivate($_POST);
}

if (isset($_POST["delete"])) {
    $temp = new Category();
    $temp->deleteRecord($_POST);
}
?>
<div class="quick" style=""><a href="downloadclick.php" style="float:right; padding-right:10px;"><h3>Download</h3></a></div>

<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">Clicks Management</div>

            <div class="errordiv">
                <?php
                if (isset($_SESSION['msg']) && $_SESSION['msg']) {
                    echo '<div class="msg" style="cursor:pointer">' . $_SESSION['msg'] . '</div>';
                    $_SESSION['msg'] = '';
                    unset($_SESSION['msg']);
                }
                if (isset($_SESSION['errormsg']) && $_SESSION['errormsg']) {
                    echo '<div class="errormsg" style="cursor:pointer">' . $_SESSION['errormsg'] . '</div>';
                    $_SESSION['errormsg'] = '';
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
                                <th>Service Detail</th>
                                <th>User Detail</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($_SESSION['admin-type'] == 'Admin' && $rec_id == '') {
                                $select = $db->fetchAssoc($db->fireQuery("SELECT * FROM `clicks` ORDER BY id DESC"));
                            } elseif ($_SESSION['admin-type'] == 'Admin' && $rec_id != '') {
                                $select = $db->fetchAssoc($db->fireQuery("SELECT * FROM `clicks` WHERE `user_id`='$rec_id' ORDER BY id DESC"));
                            } else {
                                $cat = $_SESSION['category'];
                                $sel = $db->fetchAssoc($db->fireQuery("SELECT id FROM `product` WHERE `category`='$cat' ORDER BY id DESC"));
                                $sid = '';
                                for ($j = 0; $j < count($sel); $j++) {
                                    $sid .= $sel[$j]['id'] . ',';
                                }
                                $sid = rtrim($sid, ',');
                                $select = $db->fetchAssoc($db->fireQuery("SELECT * FROM `clicks` WHERE service_id IN ($sid) ORDER BY id DESC"));
                            }

                            if (!empty($select) && is_array($select)) {
                                for ($i = 0; $i < count($select); $i++) {
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $i + 1; ?></td>
                                        <td>
                                            <?php
                                            $si = $select[$i]['service_id'];
                                            $sel = $db->fetchAssoc($db->fireQuery("SELECT * FROM `product` WHERE `id`='$si'"));
                                            echo $sel[0]['name'];
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $ui = $select[$i]['user_id'];
                                            $sel = $db->fetchAssoc($db->fireQuery("SELECT * FROM `user` WHERE `id`='$ui'"));
                                            echo $sel[0]['name'] . "<br/>" . $sel[0]['email'] . "<br/>" . $sel[0]['phone'];
                                            ?>
                                        </td>
                                        <td><?php echo $select[$i]['date']; ?></td>
                                        <td>
                                            <form method="post">
                                                <select name="status<?php echo $select[$i]['id']; ?>" style="width:40%;float:left;display:inline-block;" id="status<?php echo $select[$i]['id']; ?>" class="form-control status">
                                                    <option value="">Select</option>
                                                    <option value="new" <?php if ($select[$i]['status'] == 'new') echo "selected"; ?>>New</option>
                                                    <option value="follow up" <?php if ($select[$i]['status'] == 'follow up') echo "selected"; ?>>Follow Up</option>
                                                    <option value="wrong no" <?php if ($select[$i]['status'] == 'wrong no') echo "selected"; ?>>Wrong No</option>
                                                    <option value="not interested" <?php if ($select[$i]['status'] == 'not interested') echo "selected"; ?>>Not Interested</option>
                                                    <option value="callback" <?php if ($select[$i]['status'] == 'callback') echo "selected"; ?>>Call back</option>
                                                    <option value="notpicked" <?php if ($select[$i]['status'] == 'notpicked') echo "selected"; ?>>Not Picked</option>
                                                </select>
                                                <input type="text" id="remark<?php echo $select[$i]['id']; ?>" value="<?php echo $select[$i]['remark']; ?>" class="form-control" style="width:40%;float:left;display:inline-block;" />
                                                <input type="hidden" id="id<?php echo $select[$i]['id']; ?>" value="<?php echo $select[$i]['id']; ?>" />
                                                <input type="hidden" id="userid<?php echo $_SESSION['user_id']; ?>" value="<?php echo $_SESSION['user_id']; ?>" />
                                                <input type="button" id="submit-<?php echo $select[$i]['id']; ?>" value="submit" class="btn btn-primary submit" style="width:15%;float:left;display:inline-block;" />
                                            </form>
                                        </td>
                                    </tr>
                                <?php }
                            } else {
                                echo '<tr><td colspan="5" align="center"><strong>No records found</strong></td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <script>
                    $(document).ready(function () {
                        $(".submit").click(function () {
                            var id = $(this).attr('id');
                            var pid = id.split('-');
                            var status = $("#status" + pid[1]).val();
                            var remark = $("#remark" + pid[1]).val();
                            var cid = $("#id" + pid[1]).val();
                            var userid = $("#userid" + pid[1]).val();

                            $.ajax({
                                type: "POST",
                                url: "status.php",
                                data: { status: status, remark: remark, cid: cid, userid: userid },
                                success: function (data) {
                                    console.log(data);
                                    location.reload();
                                }
                            });
                        });
                    });
                </script>
                <div class="total-rez">
                    <?php
                    // Render pagination only if $pager exists and has method
                    if (isset($pager) && method_exists($pager, 'renderFullNav')) {
                        echo $pager->renderFullNav();
                    }
                    ?>
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
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
