<div class="modal fade" id="modal_add" role="dialog" aria-labelledby="modal_add" aria-hidden="true" data-keyboard="false" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-lg"
    role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_add">Add Customer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row px-1">
          <div class="col-12 pl-0">
              <div class="alert alert-primary ml-1" role="alert">
                <h4 class="alert-heading">
                    <i data-feather="info"></i> Information 
                </h4>
                <p class="mb-0 px-1 py-1">
                  <small>1). Label yang bertanda <span class="text-danger text-sm">*</span> wajib di isi.</small><br>
                </p>
              </div>
              <form method="POST" enctype="multipart/form-data" id="form_add">
                @csrf
                <div class="row">

                  <div class="col-xl-12 col-md-12 col-12 mb-1">
                    <fieldset class="form-group">
                        <label>Name<span class="text-danger text-sm">*</span> </label>
                        <input type="text" name="name" class="form-control"  required placeholder="A9999E" required id="name">
                    </fieldset>
                  </div>

                  <div class="col-xl-12 col-md-12 col-12 mb-1">
                    <fieldset class="form-label-group">
                      <button class="btn btn-md btn-outline-primary float-right d-none" id="spinner" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="visually-hidden">Loading...</span>
                      </button>

                      <button type="button" class="btn btn-md btn-primary float-right d-none" id="save">Simpan</button>
                    </fieldset>
                  </div>              

                </div>
              </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>        

@push('custom-script')
    <script type="text/javascript">
          var formAdd = document.forms['form_add'];

          $("#save").click(function(e){
              e.preventDefault();
              $("#save").addClass('d-none');
              $("#spinner").removeClass('d-none');

              var name   = formAdd['name'].value;

              $.ajax({
                 type:'POST',
                 url:"{{ route('customer.store') }}",
                 data:{
                    name:name
                 },
                 success:function(data) {
                    // reset form
                    $('#form_add')[0].reset();
                    // alert
                    toastr.success(data.message, 'Success');

                    // close modal
                    $('#modal_add').modal('toggle');

                    // spinner
                    $("#save").removeClass('d-none');
                    $("#spinner").addClass('d-none');

                    // reload datatable
                    var table = $('.customer').DataTable();
                    table.ajax.reload();
                 },
                 error:function(err) {
                    $("#save").removeClass('d-none');
                    $("#spinner").addClass('d-none');
                 }
              });
          });


          $("#add").click(function(e) {
              e.preventDefault()
              $("#modal_add").modal('show')
              $("#save").removeClass('d-none');
          })

    </script>
@endpush