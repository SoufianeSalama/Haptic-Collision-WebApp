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
                        <h3 class="panel-title">My Patients</h3>
                    </div>
                    <div class="col col-xs-6 text-right">
                        <button type="button" class="btn btn-sm btn-primary btn-create btn-showform"  data-toggle="modal" data-target="#modalNewPatient">+ new patient</button>
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <input type="text" id="searchInput" onkeyup="search()" placeholder="Search for patients.." style="background-image: url('<?php echo base_url() ?>/img/searchicon.png');">

                <div class="table-responsive">
                    <table class="table table-striped custab" id="patientsTable">
                        <thead>
                            <tr>
                                <th>EAD</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Gender</th>
                                <th>Age</th>
                                <th>Radiograph Analyse data</th>
                                <th>Clinical Measurments data</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>123456789</td>
                                <td>Soufiane</td>
                                <td>Salama</td>
                                <td>m</td>
                                <td>21</td>
                                <td>Not Available</td>
                                <td>Available</td>
                                <td>Options</td>
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
        table = document.getElementById("patientsTable");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {

            patientEADColumn = tr[i].getElementsByTagName("td")[0];
            patientLastNameColumn = tr[i].getElementsByTagName("td")[2];
            patientFirstNameColumn = tr[i].getElementsByTagName("td")[1];

            if (patientLastNameColumn || patientEADColumn || patientFirstNameColumn) {
                if ( (patientEADColumn.innerHTML.toUpperCase().indexOf(filter) > -1) || (patientLastNameColumn.innerHTML.toUpperCase().indexOf(filter) > -1)
                    || (patientFirstNameColumn.innerHTML.toUpperCase().indexOf(filter) > -1)) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

</script>



<!-- Modal: New Patient -->
<div id="modalNewPatient" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">New Patient</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php echo form_open('newpatient'); ?>

                    <div class="col-sm-12 col-md-10  col-md-offset-1 ">
                        <div class="form-group" style="width: 100%; margin-top: 15px;">
                            <input type="number" name="frmNewPatientEAD" class="form-control" placeholder="EAD number" value="<?php echo set_value('frmNewPatientEAD'); ?>" required>
                        </div>

                        <div class="form-group" style="width: 100%; margin-top: 15px;">
                            <input type="text" name="frmNewPatientFirstName" class="form-control" placeholder="First name" value="<?php echo set_value('frmNewPatientFirstName'); ?>" required>
                        </div>

                        <div class="form-group" style="width: 100%; margin-top: 15px;">
                            <input type="text" name="frmNewPatientLastName" class="form-control" placeholder="Last name" value="<?php echo set_value('frmNewPatientLastName'); ?>" required>
                        </div>

                        <div class="form-group" style="width: 100%; margin-top: 15px;">
                            <input type="number" name="frmNewPatientAge" class="form-control" placeholder="Age" value="<?php echo set_value('frmNewPatientAge'); ?>" required>
                        </div>

                        <div class="form-group" style="width: 100%; margin-top: 15px;">
                            <label class="radio-inline"><input type="radio" name="frmNewPatientGender" value="m" checked>M</label>
                            <label class="radio-inline"><input type="radio" name="frmNewPatientGender" value="v">V</label>
                        </div>
                        <hr />
                        <?php echo validation_errors('<div class="row"><div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>', '</div></div>'); ?>

                        <div class="form-group">
                            <input name="frmRegisterSubmit" type="submit" class="btn btn-lg btn-primary btn-block" value="Add patient">
                        </div>

                    </div>
                    <?php echo form_close(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>