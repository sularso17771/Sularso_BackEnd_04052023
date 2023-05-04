@extends('layouts/contentLayoutMaster')

@section('title', $pageConfigs['title'])

@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
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
                          1). Klik <i data-feather="plus"></i> untuk menambah data.<br>
                          2). Klik <i data-feather="refresh-cw"></i>  untuk mereset pencarian.<br>
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
                                  <button type="button" class="btn btn-sm btn-outline-primary me-1" id="add" data-bs-toggle="tooltip" data-bs-placement="top" title data-bs-original-title="Tambah Item">
                                      <i data-feather="plus"></i>
                                  </button>
                                  <button type="button" class="btn btn-sm btn-outline-primary" id="refresh" data-bs-toggle="tooltip" data-bs-placement="top" title data-bs-original-title="Refresh">
                                      <i data-feather="refresh-cw"></i>
                                  </button>
                              </div>
                          </div>
                          <div class="col-md-12 col-lg-3 col-sm-12 col-12 mb-1">
                              <input type="text" class="flex-1 form-control form-control-sm float-right" id="search" placeholder="Please typing AccountID or Desc" />
                          </div>
                          {{-- Datatable --}}
                          <div class="col-12">
                            <div class="table-responsive">
                              <table class="table customer">
                                <thead>
                                    <tr>
                                        <th>AccountId</th>
                                        <th>Transaction Date</th>
                                        <th>Description</th>
                                        <th>Debit/Credit</th>
                                        <th>Amount</th>
                                        <th>Actions</th>
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
      @include('content.transaction.modals.add')
      @include('content.transaction.modals.edit')

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
          $('.pickadate').flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",            
          });
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
                  url: "{{ route('transactions.tojson') }}",
                  type: 'GET',
                  "data": function (d) { 
                      d.search  = $("#search").val();
                      d.length  = $("#paginate").val();
                  }
              },
              columns: [
                  {data: 'customer_id', name: 'customer_id'},
                  {data: 'TransactionDate', name: 'TransactionDate'},
                  {data: 'description', name: 'description'},
                  {data: 'DebitCreditStatus', name: 'DebitCreditStatus'},
                  {data: 'nominal', name: 'nominal'},
                  {data: 'action', name: 'action'}
              ],
              "columnDefs": [
                  { orderable: true, targets: 0}, 
                  { orderable: true, targets: 1}, 
                  {
                      'targets': 5,
                      'defaultContent': '-',
                      'searchable': false,
                      'orderable': false,
                      'width': '10%',
                      'className': 'dt-body-center',
                      'render': function (data, type, full, meta) {
                        var action = '<div class="btn-group">'+
                          '<button class="btn btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">'+
                            feather.icons.settings.toSvg()+
                          '</button>'+
                          '<div class="dropdown-menu">'+
                            '<a class="dropdown-item d-flex align-items-center" data-id="'+ full.id +'" id="edit">'+feather.icons['edit'].toSvg({ class: 'cursor-pointer'})+' &nbsp;Edit</a>'+
                          '</div>'+
                        '</div>';

                        return '<div class="d-flex">'+action+'</div>';
                      }

                  }
              ],
              dom: 'frtip',
              deferRender: true,
          });

    </script>
@endpush