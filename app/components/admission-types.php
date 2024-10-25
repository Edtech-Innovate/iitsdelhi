<div id="accordionDelivery" class="accordion">
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" aria-expanded="true" data-bs-target="#admissionType" aria-controls="admissionType"> Admission Types</button>
    </h2>
    <div id="admissionType" class="accordion-collapse collapse ">
      <div class="accordion-body">
        <div class="row p-b-20 mb-3">
          <div class="col-lg-12 text-end">
            <button type="button" class="btn btn-primary" onclick="addComponents('admission-types', 'md', '<?= $university_id ?>')"><i class="ri-apps-2-add-line"></i></button>
          </div>
        </div>
        <div class="card">
          <div class="card-datatable table-responsive">
            <div id="DataTables_Table_3_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
              <div class="row">
                <!-- <div class="col-sm-12 col-md-6">
                  <div class="dataTables_length" id="DataTables_Table_3_length">
                    <label>Show 
                      <select name="DataTables_Table_3_length" aria-controls="DataTables_Table_3" class="form-select form-select-sm">
                        <option value="7">7</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="75">75</option>
                        <option value="100">100</option>
                      </select> entries
                    </label>
                  </div>
                </div> -->
                <!-- <div class="col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end">
                  <div id="DataTables_Table_3_filter" class="dataTables_filter">
                    <label>Search:
                      <input type="search" class="form-control form-control-sm" placeholder="" aria-controls="DataTables_Table_3">
                    </label>
                  </div>
                </div> -->
              </div>
              <div class="table-responsive">
                <table class="dt-multilingual table table-bordered dataTable no-footer dtr-column ctable" id="tableAdmissionDatatable" aria-describedby="DataTables_Table_3_info">
                  <thead>
                    <tr>
                      <th class="sorting_disabled" style="width: 80%;">Name</th>
                      <th class="sorting_disabled" style="width: 20%;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  var table = $('#tableAdmissionDatatable');
  var settings = {
    processing: true,
    serverSide: true,
    serverMethod: 'post',
    ajax: {
      url: '/app/components/admission-types/server',
      type: 'POST',
      data: function(data) {
        data.university_id = '<?= $university_id ?>';
      },
    },
    columns: [
      { data: "Name" },
      { 
        data: "ID",
        className: "text-center",
        render: function(data, type, row) {
          return '<div >\
            <i class="ri-edit-box-fill text-success" onclick="editComponents(\'admission-types\', \'' + data + '\', \'md\');"></i>\
            <i class="ms-3 ri-delete-bin-5-line text-danger" onclick="destroyComponents(\'admission-types\', \'AdmissionDatatable\', \'' + data + '\');"></i>\
          </div>';
        }
      }
    ],
    columnDefs: [
      { width: "90%", targets: 0 }, // Column 1 width (Name)
      { width: "10%", targets: 1,className:'text-center' }, // Column 2 width (Action)
    ],
    sDom: "<t><'row'<p i>>",
    destroy: true,
    scrollCollapse: true,
    oLanguage: {
      sLengthMenu: "_MENU_ ",
      sInfo: "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
    },
    aaSorting: [],
    iDisplayLength: 5
  };

  table.dataTable(settings);
</script>
