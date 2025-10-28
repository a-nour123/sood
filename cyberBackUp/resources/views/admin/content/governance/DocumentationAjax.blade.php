<script>
    // Function to initialize or reload the DataTable
    function initializeDataTable() {
        var categoryId = $('.sideNavBtn.active').data('tab'); // Updated selector

        // Destroy existing DataTable instance if it exists
        if ($.fn.DataTable.isDataTable('.DocTable')) {
            $('.DocTable').DataTable().destroy();
        }

        //Doc Datatable
        table = $('.DocTable').DataTable({
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
            ajax: {
                url: "{{ url('admin/governance/DocTable') }}",
                data: function(d) {
                    d.categoryId = categoryId; // Pass the categoryId as a parameter
                },
            },

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
                // { data: 'responsive_id', name: 'responsive_id' },
                // { data: 'responsive_id', name: 'responsive_id' },
                {
                    data: 'document_name',
                    name: 'document_name'
                },
                {
                    data: 'framework_name',
                    name: 'doframework_namecuments'
                },
                {
                    data: 'control',
                    name: 'control'
                },
                {
                    data: 'creation_date',
                    name: 'creation_date'
                },
                {
                    data: 'approval_date',
                    name: 'approval_date'
                },
                {
                    data: 'next_review_date',
                    name: 'next_review_date'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'actions',
                    name: 'actions'
                },

            ],

        });
    }

    // Initialize DataTable on page load
    initializeDataTable();

    // Event listener for tab clicks to reload the DataTable with the new categoryId
    $('.sideNavBtn').on('click', function() {
        // Update the active tab
        $('.sideNavBtn').removeClass('active');
        $(this).addClass('active');

        // Re-initialize the DataTable with the new categoryId
        initializeDataTable();
    });
</script>