<div x-data x-init="$watch('open', value => { if (!value) return; })"
    @alert.window="
    const get_id = event.detail.get_id;

    Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $wire.delete(get_id).then(() => {
                Swal.fire({
                    title: 'Deleted!',
                    text: 'Your product has been deleted.',
                    icon: 'success'
                });
            });
        }
    });
">
</div>
