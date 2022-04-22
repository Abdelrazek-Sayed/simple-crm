@push('js')
<script>
    window.addEventListener('appointment_delete_confirmation', event => {
        Swal.fire({
            title: event.detail.message
            , text: "You won't be able to revert this!"
            , icon: 'warning'
            , showCancelButton: true
            , confirmButtonColor: '#3085d6'
            , cancelButtonColor: '#d33'
            , confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                livewire.emit('delete_appointment');
            }
        })
    });


    window.addEventListener('appointment_deleted', event => {
        // Swal.fire(
        //     'Deleted!'
        //     , event.detail.message
        //     , 'success'
        // )
        const Toast = Swal.mixin({
            toast: true
            , position: 'top-end'
            , showConfirmButton: false
            , timer: 3000
            , timerProgressBar: true
            , didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        Toast.fire({
            icon: 'success'
            , title: event.detail.message
        })
    });

</script>
@endpush
