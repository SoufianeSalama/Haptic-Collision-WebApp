<?php
if (isset($bAlert) && !empty($bAlert)){
    if ($bAlert){
        /*echo '<div class="row">
                <div class="col-md-12 alert alert-success alert-dismissable">
                    <strong>Success!</strong> User is modified/deleted.
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                </div>
            </div>';*/
        ?>
        <div class="row">
            <div class="col-md-12 alert alert-success" role="alert">
                <h4 class="alert-heading">Success!</h4>
                <p>User is modified/deleted</p>
            </div>
        </div>

        <script>
        </script>
        <?php
    }
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col col-xs-6">
                        <h3 class="panel-title">Users</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <input type="text" id="searchInput" onkeyup="search()" placeholder="Search for users.." style="background-image: url('<?php echo base_url() ?>/img/searchicon.png');">

                <div class="table-responsive">
                    <table class="table table-striped custab" id="usersTable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Surgical Experience</th>
                            <th>Function</th>
                            <th>Workplace</th>
                            <th>Country</th>
                            <th>Approved</th>
                            <th>Options</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <?php
                            foreach ($aUsers as $aUser){
                            ?>
                        <tr>
                            <td><?php echo $aUser->userid; ?>    </td>
                            <td><?php echo $aUser->firstname; ?> </td>
                            <td><?php echo $aUser->lastname; ?>  </td>
                            <td><?php echo $aUser->email; ?>  </td>
                            <?php
                            if ($aUser->surgical_experience == 0){
                                echo "<td>Beginner</td>";
                            }elseif ($aUser->surgical_experience == 1) {
                                echo "<td>Intermediate</td>";
                            }elseif ($aUser->surgical_experience == 2) {
                                echo "<td>Expert</td>";
                            }
                            ?>
                            <td><?php echo $aUser->function; ?>  </td>
                            <td><?php echo $aUser->workplace; ?> </td>
                            <td><?php echo $aUser->country; ?>   </td>
                            <?php
                            if ($aUser->approved){
                                echo "<td>Approved</td>";
                            }else {
                                echo "<td>Not approved</td>";
                            }
                            ?>
                            <td><button type="button" class="btn btn-warning btn-xs" onclick="modifyUserModal(<?php echo "'" . $aUser->userid . "','". $aUser->firstname . "','" .$aUser->lastname . "','" .$aUser->approved . "','" .$aUser->userlevel . "'"; ?>)">Modify</button></td>
                            <td><button type="button" class="btn btn-danger btn-xs"  onclick="deleteUserModal(<?php echo "'" . $aUser->userid . "','". $aUser->firstname . "','" .$aUser->lastname . "'"; ?>)">Delete</button></td>
                        </tr>
                        <?php
                        }

                        ?>
                        </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<script>

    function modifyUserModal(userid, firstname, lastname, approved, userlevel) {
        $('#modalUserModify').modal('show');
        $('#modalUserModifyHeader').text("Modify user: " + firstname + " " + lastname);

        $("#frmModifyUserId").val(userid);

        if (approved == 1){
            $('#frmModifyUserApproved').prop('checked', true);
        }else if (approved == 0){
            $('#frmModifyUserNotApproved').prop('checked', true);
        }

        if (userlevel == 0){
            $('#frmModifyUserLevelBasic').attr('checked', true);
        }else if(userlevel == 1){
            $('#frmModifyUserLevelGolden').attr('checked', true);
        }else if(userlevel == 2){
            $('#frmModifyUserLevelAdmin').attr('checked', true);
        };
    }

    function deleteUserModal(userid, firstname, lastname) {
        $('#modalUserDelete').modal('show');
        $('#modalUserDeleteHeader').text("Delete user: " + firstname + " " + lastname);
        $("#frmDeleteUserId").val(userid);
    }

    function search() {
        // Declare variables
        var input, filter, table, tr, td, i;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("usersTable");
        tr = table.getElementsByTagName("tr");
        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            userLastNameColumn = tr[i].getElementsByTagName("td")[2];
            userFirstNameColumn = tr[i].getElementsByTagName("td")[1];

            if (userLastNameColumn || userFirstNameColumn) {
                if ( (userLastNameColumn.innerHTML.toUpperCase().indexOf(filter) > -1) || (userFirstNameColumn.innerHTML.toUpperCase().indexOf(filter) > -1)) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>

<!-- Modal: Modify Userlevel -->
<div id="modalUserModify" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="modalUserModifyHeader"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php echo form_open('modifyuser'); ?>
                    <div class="col-sm-12 col-md-10  col-md-offset-1 ">
                        <h5>User Level</h5>
                        <div class="form-group" style="width: 100%; margin-top: 15px;">
                            <label class="radio-inline"><input type="radio" name="frmModifyUserLevel" id="frmModifyUserLevelBasic"    value="0">Basic user</label>
                            <label class="radio-inline"><input type="radio" name="frmModifyUserLevel" id="frmModifyUserLevelGolden"   value="1">Golden user</label>
                            <label class="radio-inline"><input type="radio" name="frmModifyUserLevel" id="frmModifyUserLevelAdmin"    value="2">Administrator</label>
                        </div>
                        <hr />
                        <div class="form-check" style="width: 100%; margin-top: 15px;">
                            <!--<input class="form-check-input" type="checkbox" name="frmModifyUserApproved" id="frmModifyUserApproved">
                            <label class="form-check-label" for="defaultCheck1">
                                Approved
                            </label>-->
                            <label class="radio-inline"><input type="radio" name="frmModifyUserApproved" id="frmModifyUserApproved" value="1">Approved</label>
                            <label class="radio-inline"><input type="radio" name="frmModifyUserApproved" id="frmModifyUserNotApproved" value="0">Not Approved</label>

                        </div>
                        <br />
                        <input type="hidden" name="frmModifyUserId" id="frmModifyUserId" />
                        <div class="form-group">
                            <input name="frmModifyUserSubmit" type="submit" class="btn btn-lg btn-primary btn-block" value="Save">
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal: Modify Userlevel -->
<div id="modalUserDelete" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="modalUserDeleteHeader"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php echo form_open('deleteuser'); ?>
                    <div class="col-sm-12 col-md-10  col-md-offset-1 ">
                        <h5>Are you sure you want to delete this user?</h5>

                        <input type="hidden" name="frmDeleteUserId" id="frmDeleteUserId" />
                        <div class="form-group">
                            <input name="frmDeleteUserSubmit" type="submit" class="btn btn-lg btn-danger btn-block" value="Delete">
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
</div>
