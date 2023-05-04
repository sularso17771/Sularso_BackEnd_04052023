<div class="modal fade" id="modal_edit" role="dialog" aria-labelledby="modal_edit" aria-hidden="true" data-keyboard="false" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-lg"
    role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_edit">Edit Customer</h5>
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
              <form method="POST" enctype="multipart/form-data" id="form_edit">
                @csrf
                <div class="row">

                  <div class="col-xl-12 col-md-12 col-12 mb-1">
                    <fieldset class="form-group">
                        <label>Name<span class="text-danger text-sm">*</span> </label>
                        <input type="hidden" name="id">
                        <input type="text" name="name" class="form-control"  required placeholder="A9999E" required id="name">
                    </fieldset>
                  </div> 

                  <div class="col-xl-12 col-md-12 col-12 mb-1">
                    <fieldset class="form-label-group">
                      <button class="btn btn-md btn-outline-primary float-right d-none" id="spinner_edit" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="visually-hidden">Loading...</span>
                      </button>

                      <button type="button" class="btn btn-md btn-primary float-right d-none" id="update">Update</button>
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
          var formEdit = document.forms['form_edit'];
          $("#update").click(function(e){
              e.preventDefault();
              $("#update").addClass('d-none');
              $("#spinner_edit").removeClass('d-none');

              var id      = formEdit['id'].value;
              var name    = formEdit['name'].value;
              var url     = "{{route('customer.update',':id')}}"
                  url     = url.replace(':id',id)

              $.ajax({
                 type:'POST',
                 url:url,
                 data:{
                    name:name,
                 },
                 success:function(data) {
                    // reset form
                    $('#form_edit')[0].reset();
                    // alert
                    toastr.success(data.message, 'Success');

                    // spinner
                    $("#update").removeClass('d-none');
                    $("#spinner_edit").addClass('d-none');

                    // close modal
                    $('#modal_edit').modal('toggle');

                    // reload datatable
                    var table = $('.customer').DataTable();
                    table.ajax.reload();
                 },
                 error:function(err) {
                    $("#update").removeClass('d-none');
                    $("#spinner_edit").addClass('d-none');
                 }
              });
          });

          $('body').on('click', '#edit', function (e) {
              e.preventDefault();
              var id  = $(this).attr("data-id") 
              var url = '{{ route("customer.show", ":id") }}';
              url     = url.replace(':id', id);
              $("#update").removeClass('d-none');

              $.ajax({
                  type:'GET',
                  url:url,
                  success:function(data) {
                      formEdit['id'].value        = data.result.id
                      formEdit['name'].value      = data.result.name

                      $("#modal_edit").modal('show') 
                  },
              });
          });

    </script>
@endpush