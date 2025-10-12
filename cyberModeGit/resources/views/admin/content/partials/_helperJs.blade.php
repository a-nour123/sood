<script>
    function makeAlert($status, message, title) {
        // On load Toast
        if (title == 'Success')
            title = '👋' + title;
        toastr[$status](message, title, {
            closeButton: true
            , tapToDismiss: false
        });
    };

    let swal_title = "{{ __('locale.AreYouSureToDeleteThisRecord') }}";
    let swal_text = '@lang('locale.YouWontBeAbleToRevertThis')';
    let swal_confirmButtonText = "{{ __('locale.ConfirmDelete') }}";
    let swal_cancelButtonText = "{{ __('locale.Cancel') }}";
    let swal_success = "{{ __('locale.Success') }}";

    function deleteRecord(url, callBack) {
        Swal.fire({
            title: swal_title,
            text: swal_text,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: swal_confirmButtonText,
            cancelButtonText: swal_cancelButtonText,
            customClass: {
                confirmButton: 'btn btn-relief-success ms-1',
                cancelButton: 'btn btn-outline-danger ms-1'
            },
            buttonsStyling: false
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    type: "DELETE",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': "{{csrf_token()}}"
                    },
                    success: function (response) {
                        callBack(response);
                    }, error: function (xhr) {
                        console.log(xhr.responseJSON)
                    }
                });
            }
        });
    }
</script>
