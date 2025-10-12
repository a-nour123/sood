<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script>

    let swal_title = "{{ __('locale.AreYouSureToDeleteThisRecord') }}";
    let swal_text = '@lang('locale.YouWontBeAbleToRevertThis')';
    let swal_confirmButtonText = "{{ __('locale.ConfirmDelete') }}";
    let swal_cancelButtonText = "{{ __('locale.Cancel') }}";
    let swal_success = "{{ __('locale.Success') }}";

    $(document).on('click', '#NexFramePage', function (event) {
        event.preventDefault();
        var currentPage = $('#currentPage').val();
        var lastPage = $('#lastPage').val();
        var page = parseInt(currentPage) + 1;
        if (page <= lastPage) {
            $('#PrevFramePage').attr('disabled', false);

            $.ajax({
                url: '{{url('admin/governance/next-frame-work-page')}}',
                method: "get",
                data: {page: page},
                success: function (data) {
                    if (data[2] != 0) {
                        $('.CategoryList').html(data[0]);
                        $('#lastPage').val(data[1]);
                        $('#currentPage').val(page);
                    } else {
                        $('#NexFramePage').attr('disabled', true);
                    }
                },
            })
        } else {
            $('#NexFramePage').attr('disabled', true);
        }
    });

    $(document).on('click', '#PrevFramePage', function (event) {
        event.preventDefault();
        var currentPage = $('#currentPage').val();
        var lastPage = $('#lastPage').val();
        var page = parseInt(currentPage) > 1 ? parseInt(currentPage) - 1 : 1;

        if (currentPage > 1) {
            $('#NexFramePage').attr('disabled', false);
            $.ajax({
                url: '{{url('admin/governance/prev-frame-work-page')}}',
                method: "get",
                data: {page: page},
                success: function (data) {
                    $('.CategoryList').html(data[0]);
                    $('#lastPage').val(data[1]);
                    $('#currentPage').val(page);
                },
            })
        } else {
            $('#PrevFramePage').attr('disabled', true);
        }
    });

    //Start Right Side
    $(document).on('click', '.sideNavBtn', function (event) {
        event.preventDefault();
        var id = $(this).attr('id');
        $.ajax({
            url: '{{url('admin/governance/frame-details')}}',
            method: "get",
            data: {id: id},
            success: function (data) {
                $('.FrameName').html(data[0]);
                $('.FrameDesc').html(data[1]);

                //btns
                $('.copyItem').attr('data-bs-target', '#copy-modal' + id.substring(4));
                $('.updateItem').attr('data-bs-target', '#edit-modal' + id.substring(4));
                $('.deleteItem').attr('alt', 'item' + id.substring(4));

                $('.EditModal').attr('id', 'edit-modal' + id.substring(4));
                $('#form-edit').attr('action', data[2]);

                $('.copyForm').attr('id', 'copy-modal' + id.substring(4));
                $('#form-copy').attr('action', data[3]);

                //Edit Modal Input
                $('.FrameNameInput').val(data[0]);
                $('.framework_domain_select').html(data[4]);
                $('.framework_subdomain_select').html(data[5]);
                $('.framework_subdomain_select').attr('data-subdomains', data[6]);
                $('.IconsSelect').html(data[7]);
                $('.FrameDescription').val(data[8]);

                //Add Control
                $('.AddControl').attr('id', 'add_control' + id.substring(4));
                $('#form-add_control').attr('action', data[9]);

                $(".select2-selection__rendered").html("");

                //active item on sidebar
                $('.list-group-item').removeClass('activeItemTab');
                $('#item' + id.substring(4)).addClass('activeItemTab');

                //Relaod Datatable
                table.ajax.reload();
            },
        })

    });

    $(document).on('click', '.deleteItem', function (event) {
        event.preventDefault();
        var id = $(this).attr('alt').substring(4);

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
                    url: '{{url('admin/governance/frame-delete')}}',
                    method: "get",
                    data: {id: id},
                    success: function (data) {
                        location.reload();
                    },
                    error: function (response) {
                        makeAlert('error', response.responseJSON, 'Error')
                    }
                })
            }
        });


    });

    //Families Datatable
    table = $('.FrameFamiliesTable').DataTable({
        processing: true,
        searching: false,
        render: true,
        serverSide: true,
        dom: 'lBfrtip',
        aLengthMenu: [
            [25, 50, 100, 200, 500, 1000, -1],
            [25, 50, 100, 200, 500, 1000, "All"]
        ],
        buttons: [],
        ajax: "{{url('admin/governance/FrameFamiliesTable')}}",
        language: {
                "sProcessing": "{{ __('locale.Processing') }}",
                "sSearch": "{{ __('locale.Search') }}",
                "sLengthMenu": "{{ __('locale.lengthMenu') }}",
                "sInfo": "{{ __('locale.info') }}",
                "sInfoEmpty": "{{ __('locale.infoEmpty') }}",
                "sInfoFiltered": "{{ __('locale.infoFiltered') }}",
                "sInfoPostFix": "",
                "sSearchPlaceholder": "",
                "sZeroRecords": "{{ __('locale.emptyTable') }}",
                "sEmptyTable": "{{ __('locale.NoDataAvailable') }}",
                "oPaginate": {
                    "sFirst": "",
                    "sPrevious": "{{ __('locale.Previous') }}",
                    "sNext": "{{ __('locale.NextStep') }}",
                    "sLast": ""
                },
                "oAria": {
                    "sSortAscending": "{{ __('locale.sortAscending') }}",
                    "sSortDescending": "{{ __('locale.sortDescending') }}"
                }
            },
        columns: [
            {data: 'families', name: 'families'},
            {data: 'sub_families', name: 'sub_families'},
        ],
        // "language": {
        //     "sSearch": "Search...",
        // }
    });


    ////////////////////////////////////////////////////

    // status [warning, success, error]
    function makeAlert($status, message, title) {
        // On load Toast
        if (title == 'Success')
            title = '👋' + title;
        toastr[$status](message, title, {
            closeButton: true,
            tapToDismiss: false,
        });
    }

</script>
