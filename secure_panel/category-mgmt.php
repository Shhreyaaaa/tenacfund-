<?php 
include_once("inc/header.php");
include_once("com/Category.php");
include_once("inc/checksession.inc.php");

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

<div class="quick" style=""><a href="add-edit-category.php?action=add" style="float:right; padding-right:10px;"><h3>Add New</h3></a></div>

<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Category Management
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
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $select = $db->fetchAssoc($db->fireQuery("SELECT * FROM `category` ORDER BY id DESC"));
                            for ($i = 0; $i < count($select); $i++) {
                            ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i + 1; ?></td>
                                    <td><?php echo $select[$i]['category']; ?></td>
                                    <td class="center">
                                        <a href="add-edit-category.php?action=edit&&id=<?php echo siteEncrypt($select[$i]["id"]); ?>" style="background-image: none; float: left;">
                                            <img src="images/edit_icon.png" alt="Edit" title="Edit" />
                                        </a>
                                        <?php if ($_SESSION['admin-type'] != 'Editor') { ?>
                                            <a href="category-mgmt.php?action=delete&&id=<?php echo siteEncrypt($select[$i]["id"]); ?>" style="background-image: none; float: left;">
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
        </div>

        <!-- Delete confirmation script -->
        <script>
            $(document).ready(function () {
                $(".cancel").click(function () {
                    var id = $(this).attr('id');
                    var str = id.split('_');
                    if (confirm("Are you sure you want to delete this?")) {
                        $(".cancel").attr("href", window.location.origin + '/category-mgmt.php?action=delete&&id=' + str[1]);
                    } else {
                        return false;
                    }
                });

                $('#dataTables-example').dataTable();
            });
        </script>
    </div>
</div>
</div>

<!-- /. PAGE INNER  -->
</div>
<!-- /. PAGE WRAPPER  -->

<!-- /. WRAPPER  -->
<!-- SCRIPTS - AT THE BOTTOM TO REDUCE LOAD TIME -->
<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.metisMenu.js"></script>
<script src="assets/js/custom.js"></script>
