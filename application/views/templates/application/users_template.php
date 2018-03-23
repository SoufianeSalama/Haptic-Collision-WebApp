<?php echo validation_errors(
        '<div class="row"> 
                <div class="col-md-12 alert alert-danger alert-dismissable">', '
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                </div>
               </div>'); ?>

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
                            <th>Function</th>
                            <th>Workplace</th>
                            <th>Country</th>
                            <th>Approved</th>
                            <th>Options</th>
                        </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Soufiane</td>
                                <td>Salama</td>
                                <td>Engineer</td>
                                <td>UHasselt</td>
                                <td>Belgium</td>
                                <td>Not Approved</td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
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
