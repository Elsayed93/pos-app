{{-- <!-- Bootstrap 3.3.7 --> --}}
<script src="{{ asset('dashboard_files/js/bootstrap.min.js') }}"></script>

{{-- icheck --}}
<script src="{{ asset('dashboard_files/plugins/icheck/icheck.min.js') }}"></script>

{{-- <!-- FastClick --> --}}
<script src="{{ asset('dashboard_files/js/fastclick.js') }}"></script>

{{-- <!-- AdminLTE App --> --}}
<script src="{{ asset('dashboard_files/js/adminlte.min.js') }}"></script>

{{-- ckeditor standard --}}
<script src="{{ asset('dashboard_files/plugins/ckeditor/ckeditor.js') }}"></script>

{{-- jquery number --}}
<script src="{{ asset('dashboard_files/js/jquery.number.min.js') }}"></script>

{{-- print this --}}
<script src="{{ asset('dashboard_files/js/printThis.js') }}"></script>

{{-- morris --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="{{ asset('dashboard_files/plugins/morris/morris.min.js') }}"></script>

{{-- custom js --}}
{{-- <script src="{{ asset('dashboard_files/js/custom/image_preview.js') }}"></script> --}}
<script src="{{ asset('dashboard_files/js/custom/order.js') }}"></script>

<script>
    $(document).ready(function() {

        $('.sidebar-menu').tree();

        //icheck
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });

        //delete
        $('.delete').click(function(e) {

            var that = $(this)
            e.preventDefault();

            var n = new Noty({
                text: "@lang('site.confirm_delete')",
                type: "warning",
                killer: true,
                buttons: [
                    Noty.button("@lang('site.yes')", 'btn btn-success mr-2', function() {
                        that.closest('form').submit();
                    }),

                    Noty.button("@lang('site.no')", 'btn btn-primary mr-2', function() {
                        n.close();
                    })
                ]
            });

            n.show();

        }); //end of delete

        CKEDITOR.config.language = "{{ app()->getLocale() }}";


    }); //end of ready
</script>

{{-- image preview --}}
<script>
    let imgInp = document.getElementsByClassName('imgInp');

    if (imgInp[0]) {
        imgInp[0].onchange = evt => {
            const [file] = imgInp[0].files
            console.log('file', file);
            console.log('url: ', URL.createObjectURL(file));
            console.log('url: ', typeof(URL.createObjectURL(file)));

            if (file) {
                let image_preview = document.getElementsByClassName('image-show');
                image_preview[0].style.display = "inline-block";
                image_preview[0].src = URL.createObjectURL(file);
            }
        }
    }
</script>

@stack('scripts')
