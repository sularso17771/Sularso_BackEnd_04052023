<div class="modal fade" id="modal_edit" role="dialog" aria-labelledby="modal_edit" aria-hidden="true" data-keyboard="false" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-lg"
    role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Transaction</h5>
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
              <form method="POST" id="form_edit">
                <div class="row">

                  <div class="col-xl-12 col-md-12 col-12 mb-1">
                    <fieldset class="form-group">
                        <label>Account<span class="text-danger text-sm">*</span> </label>
                        <input name="id" id="id" type="hidden">
                        <select class="form-control form-select" name="customer_id_edit" id="customer_id_edit"></select>
                    </fieldset>
                  </div>
                  <div class="col-xl-12 col-md-12 col-12 mb-1">
                    <fieldset class="form-group">
                        <label>Data<span class="text-danger text-sm">*</span> </label>
                        <input type="text" name="TransactionDate_edit" class="form-control pickadate"  required placeholder="Input Date" required id="TransactionDate_edit">
                    </fieldset>
                  </div>
                  <div class="col-xl-12 col-md-12 col-12 mb-1">
                    <fieldset class="form-group">
                        <label>Amount<span class="text-danger text-sm">*</span> </label>
                        <input type="number" min="0" name="amount_edit" class="form-control"  required placeholder="Input Amount" required id="amount_edit">
                    </fieldset>
                  </div>
                  <div class="col-xl-12 col-md-12 col-12 mb-1">
                    <fieldset class="form-group">
                        <label>Desc<span class="text-danger text-sm">*</span> </label>
                        <select name="description_edit" id="description_edit" class="form-select">
                            <option value="">Select Desc</option>
                            <option value="Tarik Tunai">Tarik Tunai</option>
                            <option value="Setor Tunai">Setor Tunai</option>
                            <option value="Beli Pulsa">Beli Pulsa</option>
                            <option value="Bayar Listrik">Bayar Listrik</option>
                        </select>
                    </fieldset>
                  </div>

                  <div class="col-xl-12 col-md-12 col-12 mb-1">
                    <fieldset class="form-label-group">
                      <button class="btn btn-md btn-outline-primary float-right d-none" id="spinner_edit" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="visually-hidden">Loading...</span>
                      </button>

                      <button type="button" class="btn btn-md btn-primary float-right d-none" id="update">Simpan</button>
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
          var formAdd = document.forms['form_edit'];
          $("#form_edit #customer_id_edit").select2({
              width: '100%',
              containerCssClass: 'select-md',
              dropdownParent: $("#modal_edit"),
              ajax: {
                  url: "{{route('customer.toselect')}}",
                  dataType: 'json',
                  delay: 250,
                  data: function (params) {
                      return {
                        q: params.term, // search term
                        page: 1,
                        per_page: 10,
                      };
                  },
                  processResults: function (data, params) {
                      return {
                          results: $.map(data.result.data, function(obj) {
                              return { id: obj.id, text: obj.name };
                          })
                      };
                  },
                  cache: true
              },
              placeholder: 'Choose item',
              escapeMarkup: function (markup) { return markup; },
          });

          $("#update").click(function(e){
              e.preventDefault();
              $("#update").addClass('d-none');
              $("#spinner_edit").removeClass('d-none');

              var customer_id       = $('#customer_id_edit').val();
              var TransactionDate   = $('#TransactionDate_edit').val();
              var amount            = $('#amount_edit').val();
              var description       = $('#description_edit').val();
              var id                = $("#id").val();
              var url               = "{{ route('transactions.update',':id') }}";
                  url               = url.replace(":id",id);

              $.ajax({
                 type:'POST',
                 url:url,
                 data:{
                    customer_id:customer_id,
                    TransactionDate:TransactionDate,
                    amount:amount,
                    description:description
                 },
                 success:function(data) {
                    // reset form
                    $('#form_edit')[0].reset();
                    $('#form_edit #customer_id_edit').val('');
                    // alert
                    toastr.success(data.message, 'Success');

                    // close modal
                    $('#modal_edit').modal('toggle');

                    // spinner_edit
                    $("#update").removeClass('d-none');
                    $("#spinner_edit").addClass('d-none');

                    // reload datatable
                    var table = $('.customer').DataTable();
                    table.ajax.reload();
                 },
                 error:function(err) {
                    $("#update").removeClass('d-none');
                    $("#spinner_edit").addClass('d-none');
                    console.log(err)
                 }
              });
          });


          $("body").on('click','#edit',function(e) {
              e.preventDefault()
              var id  = $(this).data('id');
              var url = "{{ route('transactions.show',':id') }}";
                  url = url.replace(':id',id)


              $.ajax({
                 type:'GET',
                 url:url,
                 success:function(data) {
                  console.log(data.result)
                    $("#id").val(data.result.id)
                    $("#customer_id_edit").select2("trigger", "select", {data: { id: data.result.customer.id, text: data.result.customer.name}});
                    $("#TransactionDate_edit").val(data.result.TransactionDate)
                    $("#amount_edit").val(data.result.Amount)
                    $("#description_edit").val(data.result.description)
                 },
              });
              $("#modal_edit").modal('show')
              $("#update").removeClass('d-none');
          })

    </script>
@endpush