@extends('layouts/contentLayoutMaster')

@section('title', $pageConfigs['title'])

@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
@endsection

@section('content')

      <section id="page-account-settings">
          <div class="row">
            <div class="col-md-12">
              <div class="card mb-0">
                <div class="card-content">
                  <div class="card-body">
                      <div class="alert alert-primary" role="alert">
                        <h4 class="alert-heading">
                          <i data-feather="info"></i> Information 
                        </h4>
                        <p class="mb-0 px-1 py-1">
                          <small>
                          1). Klik <i data-feather="refresh-cw"></i>  untuk mereset pencarian.<br>
                          </small>
                        </p>
                      </div>
                      <div class="row">
                          <div class="col-md-6 col-lg-1 col-sm-6 col-3 mb-1">
                              <select class="form-select form-select-sm" id="paginate">
                                  <option value="10">10</option>
                                  <option value="25">25</option>
                                  <option value="50">50</option>
                              </select>
                          </div>
                          <div class="col-md-12 col-lg-8 col-sm-12 col-12 mb-1">
                              <div class="float-right w-100 d-flex">
                                  <button type="button" class="btn btn-sm btn-outline-primary" id="refresh" data-bs-toggle="tooltip" data-bs-placement="top" title data-bs-original-title="Refresh">
                                      <i data-feather="refresh-cw"></i>
                                  </button>
                              </div>
                          </div>
                          <div class="col-md-12 col-lg-3 col-sm-12 col-12 mb-1">
                              <input type="text" class="flex-1 form-control form-control-sm float-right" id="search" placeholder="Please typing Name" />
                          </div>
                          {{-- Datatable --}}
                          <div class="col-12">
                            <div class="table-responsive">
                              <table class="table customer">
                                <thead>
                                    <tr>
                                        <th>AccountId</th>
                                        <th>Name</th>
                                        <th>Total Point</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
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
        </section>

@endsection
@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/jszip.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/vfs_fonts.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection
@push('custom-script')
    <script type="text/javascript">
          $("#search").on("keyup", _.debounce(function (e) {
              var minlength = 1;
              var value     = $(this).val();

              if (value.length > minlength ) 
              {
                t.ajax.reload();
              } else {
                t.ajax.reload();                
              }
          }, 500));

          $("#paginate").on("change", function(e) {
              t.ajax.reload();
          });

          $("#refresh").on("click", function(e) {
              e.preventDefault();
              $("#search").val('');
              t.ajax.reload();
          });

          var t = $('.customer').DataTable({
              processing: true,
              serverSide: true,
              searching: false,
              ajax: {
                  url: "{{ route('customer.tojson') }}",
                  type: 'GET',
                  "data": function (d) { 
                      d.search  = $("#search").val();
                      d.length  = $("#paginate").val();
                  }
              },
              columns: [
                  {data: 'id', name: 'id'},
                  {data: 'name', name: 'name'},
                  {data: 'total', name: 'total'}
              ],
              "columnDefs": [
                  { orderable: true, targets: 0}, 
                  { orderable: true, targets: 1}, 
                  { orderable: true, targets: 2}, 
              ],
              dom: 'frtip',
              deferRender: true,
          });

    </script>
@endpush