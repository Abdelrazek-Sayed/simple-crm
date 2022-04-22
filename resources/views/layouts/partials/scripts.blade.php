<!-- jQuery -->
<script src="{{ asset('backend/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('backend/dist/js/adminlte.min.js')}}"></script>
<script src="https://unpkg.com/moment"></script>
<script src="{{ asset('backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>

<script>
    window.addEventListener('show-form', event => {
        $('#form').modal('show');
    });

    window.addEventListener('show-delete-modal', event => {
        $('#cofirm_delete_modal').modal('show');
    });

    window.addEventListener('hide-delete-modal', event => {
        $('#cofirm_delete_modal').modal('hide');
    });

    window.addEventListener('hide-form', event => {
        $('#form').modal('hide');
    })
</script>


