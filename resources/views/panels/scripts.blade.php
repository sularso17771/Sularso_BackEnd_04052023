<script src="{{ asset(mix('vendors/js/vendors.min.js')) }}"></script>
<script src="{{asset(mix('vendors/js/ui/jquery.sticky.js'))}}"></script>
@yield('vendor-script')
<script src="{{ asset(mix('js/core/app-menu.js')) }}"></script>
<script src="{{ asset(mix('js/core/app.js')) }}"></script>
<script src="{{ asset(mix('js/core/scripts.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/0.10.0/lodash.min.js"></script>

@yield('page-script')
<script type="text/javascript">
	$.ajaxSetup({
		headers: {
		  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});


	$( document ).ajaxError(function( event, x, settings, exception ) {
        if(x.status === 400)
        {
          toastr.error('The folder cannot be downloaded, because it doesnt have any files in it!', x.statusText);
        }
        
        if(x.status === 422)
        {
          // alert error
          Object.keys(x.responseJSON.errors).forEach(function(key) {
            toastr.error(x.responseJSON.errors[key][0], x.responseJSON.message);
          });
        }
        
        if(x.status === 403)
        {
          toastr.error(x.responseJSON.message, x.statusText);
        }
        
        if(x.status === 500)
        {
          toastr.error('Internal Server Error', x.statusText);
        }
	});

	feather.replace()
</script>
@stack('custom-script')