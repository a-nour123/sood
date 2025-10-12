{{--  <!-- BEGIN: Vendor JS-->
<script src="{{ asset(mix('vendors/js/vendors.min.js')) }}"></script>
<!-- BEGIN Vendor JS-->
<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset(mix('vendors/js/ui/jquery.sticky.js')) }}"></script>
@yield('vendor-script')
<script src="{{ asset(mix('vendors/js/editors/quill/quill.min.js')) }}"></script>
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="{{ asset(mix('js/core/app-menu.js')) }}"></script>
<script src="{{ asset(mix('js/core/app.js')) }}"></script>

<!-- custome scripts file for user -->
<script src="{{ asset(mix('js/core/scripts.js')) }}"></script>

@if ($configData['blankPage'] === false)
    <script src="{{ asset(mix('js/scripts/customizer.js')) }}"></script>
@endif



<!-- scrollbar js-->
<script src="{{ asset('new_d/js/scrollbar/simplebar.js')}}"></script>
<script src="{{ asset('new_d/js/scrollbar/custom.js')}}"></script>
<!-- Sidebar jquery-->
<script src="{{ asset('new_d/js/config.js')}}"></script>
<!-- Plugins JS start-->
<script src="{{ asset('new_d/js/sidebar-menu.js')}}"></script>
<script src="{{ asset('new_d/js/slick/slick.min.js')}}"></script>
<script src="{{ asset('new_d/js/slick/slick.js')}}"></script>
<script src="{{ asset('new_d/js/header-slick.js')}}"></script>
<script src="{{ asset('new_d/js/chart/apex-chart/apex-chart.js')}}"></script>
<script src="{{ asset('new_d/js/chart/apex-chart/stock-prices.js')}}"></script>
<script src="{{ asset('new_d/js/prism/prism.min.js')}}"></script>
<script src="{{ asset('new_d/js/clipboard/clipboard.min.js')}}"></script>
<script src="{{ asset('new_d/js/custom-card/custom-card.js')}}"></script>
<script src="{{ asset('new_d/js/notify/bootstrap-notify.min.js')}}"></script>
<script src="{{ asset('new_d/js/vector-map/jquery-jvectormap-2.0.2.min.js')}}"></script>
<script src="{{ asset('new_d/js/vector-map/map/jquery-jvectormap-world-mill-en.js')}}"></script>
<script src="{{ asset('new_d/js/vector-map/map/jquery-jvectormap-us-aea-en.js')}}"></script>
<script src="{{ asset('new_d/js/vector-map/map/jquery-jvectormap-uk-mill-en.js')}}"></script>
<script src="{{ asset('new_d/js/vector-map/map/jquery-jvectormap-au-mill.js')}}"></script>
<script src="{{ asset('new_d/js/vector-map/map/jquery-jvectormap-chicago-mill-en.js')}}"></script>
<script src="{{ asset('new_d/js/vector-map/map/jquery-jvectormap-in-mill.js')}}"></script>
<script src="{{ asset('new_d/js/vector-map/map/jquery-jvectormap-asia-mill.js')}}"></script>
<script src="{{ asset('new_d/js/dashboard/default.js')}}"></script>

<script src="{{ asset('new_d/js/typeahead/handlebars.js')}}"></script>
<script src="{{ asset('new_d/js/typeahead/typeahead.bundle.js')}}"></script>
<script src="{{ asset('new_d/js/typeahead/typeahead.custom.js')}}"></script>
<script src="{{ asset('new_d/js/typeahead-search/handlebars.js')}}"></script>
<script src="{{ asset('new_d/js/typeahead-search/typeahead-custom.js')}}"></script>
<script src="{{ asset('new_d/js/animation/wow/wow.min.js')}}"></script>
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="{{ asset('new_d/js/script.js')}}"></script>
<script>new WOW().init();</script>  --}}






<!-- Core Libraries -->
<script src="{{ asset(mix('vendors/js/vendors.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/ui/jquery.sticky.js')) }}"></script>

<!-- Page Vendor Scripts -->
@yield('vendor-script')
<script src="{{ asset(mix('vendors/js/editors/quill/quill.min.js')) }}"></script>

<!-- Theme Scripts -->
<script src="{{ asset(mix('js/core/app-menu.js')) }}"></script>
<script src="{{ asset(mix('js/core/app.js')) }}"></script>
<script src="{{ asset(mix('js/core/scripts.js')) }}"></script>
@if ($configData['blankPage'] === false)
    <script src="{{ asset(mix('js/scripts/customizer.js')) }}"></script>
@endif

<!-- Plugin Libraries -->
<script src="{{ asset('new_d/js/scrollbar/simplebar.js')}}"></script>
<script src="{{ asset('new_d/js/sidebar-menu.js')}}"></script>
<script src="{{ asset('new_d/js/slick/slick.min.js')}}"></script>
<script src="{{ asset('new_d/js/chart/apex-chart/apex-chart.js')}}"></script>
<script src="{{ asset('new_d/js/prism/prism.min.js')}}"></script>
<script src="{{ asset('new_d/js/clipboard/clipboard.min.js')}}"></script>
<script src="{{ asset('new_d/js/notify/bootstrap-notify.min.js')}}"></script>
<script src="{{ asset('new_d/js/vector-map/jquery-jvectormap-2.0.2.min.js')}}"></script>
<!-- Custom Scripts -->
<script src="{{ asset('new_d/js/config.js')}}"></script>
<script src="{{ asset('new_d/js/header-slick.js')}}"></script>
<script src="{{ asset('new_d/js/dashboard/default.js')}}"></script>
<script src="{{ asset('new_d/js/typeahead/typeahead.bundle.js')}}"></script>
<script src="{{ asset('new_d/js/animation/wow/wow.min.js')}}"></script>
<script>new WOW().init();</script>
<script src="{{ asset('new_d/js/script.js')}}"></script>




<script >


// $(document).on('hidden.bs.modal', function () {
//     if ($('.modal.show').length === 0) {
//         console.log('Modal hidden event triggered');
//         console.log('Number of modals still open:', $('.modal.show').length);
//         $('body').removeClass('modal-open');
//         $('.modal-backdrop').remove();
//     }
// });
// $(document).on('show.bs.modal', function () {
//     console.log('Modal hidden event triggered 11');
//     console.log('Number of modals still open 11:', $('.modal.show').length);
//     $('.modal-backdrop').remove();



// });

</script>








<!-- END: Theme JS-->
{{-- This scripts for drawing datatable --}}
<script>
    // When you want to use datatable with server side filter





    /* Handle datatable server side with its filter form */
    const datatableAdvancedSearchForm = $('form.dt_adv_search');
    if (datatableAdvancedSearchForm.length) {
        let changePage = false;
        /*
         * columnsData: This parameter can be used to read and write data to and from any data source property
         * columnDefinitions: This parameter allows you to assign specific options to columns in the table
         * detailsOfItem: This parameter is used to show the main title data of the modal in responsive
         * detailsOfItemKey: This parameter is used to show specific `column.data` that will be used in the title alongside the main title data of the modal in responsive
         */
        function drawDatatable(columnsData, columnDefinitions, detailsOfItem, detailsOfItemKey) {
            // Sort first records from 1 to n other than actual record is from database
            columnDefinitions.push({
                searchable: false,
                orderable: false,
                targets: 0,
                render: function(data, type, full, meta) {
                    return meta.settings._iDisplayStart + meta.row + 1;
                }
            });

            let table = $('table.dt-advanced-server-search').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: URLs['ajax_list'],
                    type: "POST",
                    data: function(data) {
                        data._token = $('meta[name="csrf-token"]').attr('content');
                    },
                    error: function(response, data) {
                        responseData = response.responseJSON;
                    }
                },
                columns: columnsData,

                columnDefs: columnDefinitions,

                dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                orderCellsTop: true,

                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function(row) {
                                var data = row.data();
                                return `${detailsOfItem} "${data[detailsOfItemKey]}"`;
                            }
                        }),
                        type: 'column',
                        renderer: function(api, rowIdx, columns) {
                            var data = $.map(columns, function(col, i) {
                                return col.title !== '' ?
                                    '<tr data-dt-row="' +
                                    col.rowIndex +
                                    '" data-dt-column="' +
                                    col.columnIndex +
                                    '">' +
                                    '<td>' +
                                    col.title +
                                    ':' +
                                    '</td> ' +
                                    '<td>' +
                                    col.data +
                                    '</td>' +
                                    '</tr>' :
                                    '';
                            }).join('');

                            return data ? $('<table class="table"/><tbody />').append(data) : false;
                        }
                    }
                },
                language: {
                    paginate: {
                        previous: '&nbsp;',
                        next: '&nbsp;'
                    },
                    emptyTable: "{{ __('locale.emptyTable') }}",
                    info: "{{ __('locale.info') }}",
                    infoEmpty: "{{ __('locale.infoEmpty') }}",
                    infoFiltered: "{{ __('locale.infoFiltered') }}",
                    lengthMenu: "{{ __('locale.lengthMenu') }}",
                    loadingRecords: "{{ __('locale.loadingRecords') }}",
                    search: "{{ __('locale.search') }}",
                    zeroRecords: "{{ __('locale.zeroRecords') }}",
                    aria: {
                        "sortAscending": "{{ __('locale.sortAscending') }}",
                        "sortDescending": "{{ __('locale.sortDescending') }}",
                    },
                    processing: "{{ __('locale.Processing') }}"
                },
                fnServerParams: function(data) {
                    // Map custom search value for each column (depengin on filter fields standard name)
                    columnsData.forEach((column, index) => {
                        data.columns[index].search.value = $(`[name="filter_${column.data}"]`)
                            .val() ?? '';
                    });
                }
            });

            datatableAdvancedSearchForm.find('select').on('change', function() {
                if(!$(this).attr('no_datatable_draw'))
                    table.draw();
            });

            datatableAdvancedSearchForm.find('input').on('keyup', function() {
                if(!$(this).attr('no_datatable_draw'))
                    table.draw();
            });

            datatableAdvancedSearchForm.on('submit', function(e) {
                if (changePage == 'current')
                    table.page(table.page.info().page).draw('page');
                else if (changePage == 'last')
                    table.page('last').draw('page');
                else if (changePage == 'first')
                    table.page('first').draw('page');
                else // set page as current page
                    table.page(table.page.info().page).draw('page');

                e.preventDefault();
            });
        }

        function redrawDatatable(changePageAction = 'current') {
            changePage = changePageAction;
            datatableAdvancedSearchForm.trigger('submit');
        }
    }
</script>

<!-- BEGIN: Page JS-->
@yield('page-script')
<script>
    if ($('#quill-service-content').length) {
        const serviceDescriptionContent = @json(session('serviceDescription')),
            quillContentServiceDescriptionModal = new Quill('#quill-service-content', {
                theme: 'bubble'
            });
        quillContentServiceDescriptionModal.setContents(JSON.parse(serviceDescriptionContent));

        $('#service-description-data').html(quillContentServiceDescriptionModal.root.innerHTML)
    }
</script>
<!-- END: Page JS-->
<script>
    function makeNotificationRead(id) {
        let url = "{{ route('notification-read', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url: url,
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                var link = $('#notification' + data).attr('link');
                if (link != '#') {
                    window.location.href = link;
                }
            }
        });
    }

    if ($('form.dt_adv_search').length) {
        $('form.dt_adv_search').on('submit', function(e) {
            e.preventDefault();
        })
    }
</script>
@if (App()->environment() === 'production')
    <script>
        // Disable right click context
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });

        // Disable buttons that may be used for reload page
        document.onkeydown = function(e) {
            // Event for Ctrl+r
            if (event.keyCode == 82 && event.ctrlKey) {
                return false;
            }
            // Event for F12
            if (event.keyCode == 123) {
                return false;
            }
            // Event for Ctrl+Shift+I to open inpect(network)
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
                return false;
            }
            // Event for Ctrl+Shift+C to open inpect(element)
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
                return false;
            }
            // Event for Ctrl+Shift+J to open inpect(console)
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
                return false;
            }
            // Event for Ctrl+U get source code
            if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
                return false;
            }
            // Event for Ctrl+F searching (as it may write ctrl+F and work with any of others disabled actions)
            if (e.ctrlKey && e.keyCode == 'F'.charCodeAt(0)) {
                return false;
            }
        }
    </script>
@endif

{{-- Hide the url of the browser's left-bottom corner when a link is hovered --}}
<script>
    window.addEventListener("load", function() {

        $('a[href^=http]:not([download])').each(function(indexInArray) {
            $(this).data('href', $(this).attr('href'));
            $(this).attr('href', 'javascript:');
        });

        $('a:not([download])').on('click', function(e) {
            // e.preventDefault();
            if ($(this).data('href'))
                window.location.href = $(this).data('href');
        });
    });
</script>

<script>
    // When you want to use export pdf for part of blade
    // 1. You must incluce this file (js/scripts/html2pdf_v0.10.1_.bundle.min.js) in your blade
    // 2. You have to add (export-pdf-btn) to your button to allow exports
    // 3. optional add to your export button data-id_selector = your container id if not set default id is ("exported-part-container")
    // 4. optional add to your export button data-filename = exported file name if not set default id is ("export")

    function customExportPDF(fileName = "export", id_selector = 'exported-part-container') {
        var element = document.querySelector(`#${id_selector}`);
        var opt = {
            margin: 0.1,
            padding: 0.1,
            filename: `${fileName}.pdf`,
            image: {
                type: 'jpeg',
                quality: 1
            },
            html2canvas: {
                scale: 3
            },
            jsPDF: {
                unit: 'in',
                format: 'letter',
                orientation: 'portrait'
            },
            pageBreak: {
                mode: ['avoid-all']
            },
            pagebreak: {
                mode: ['avoid-all', 'css', 'legacy']
            }
        };

        // New Promise-based usage:
        html2pdf().set(opt).from(element).to('img').save();
    }

    // Handle click export pdf button event
    $(document).on('click', 'button.export-pdf-btn', function() {
        customExportPDF($(this).data('filename'), $(this).data('id_selector'));
    });

    /* Handle import export container */
    const importExportContainer = $('#import-export-container');
    if (importExportContainer.length) {
        // Handle download template import file
        $(document).on('click', '.download-template', function(e) {
            e.preventDefault();
            // Download supporting documentation start
            const form = $('#download-import-template-file');
            form.trigger('submit');
        });

        // Handle import file
        $(document).on('click', '.submit-import', function(e) {
            e.preventDefault();
            var formData = new FormData(document.querySelector('#import-form'));

            e.preventDefault();
            $.ajax({
                url: $('#import-form').attr('action'),
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $.blockUI({
                        message: '<div class="d-flex justify-content-center align-items-center"><p class="me-50 mb-0">{{ __('locale.PleaseWaitAction', ['action' => __('importing')]) }}</p> <div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
                        css: {
                            backgroundColor: 'transparent',
                            color: '#fff',
                            border: '0'
                        },
                        overlayCSS: {
                            opacity: 0.5
                        }
                    });
                },
                complete: function() {
                    $.unblockUI();
                },
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
                        location.reload();
                    } else {
                        showError(data['errors']);
                        // List error
                        $('#import-errors-modal tbody').html('');
                        response.errors.forEach((error, index) => {
                            $('#import-errors-modal tbody').append(
                                `
                            <tr>
                            <td>${index}</td>
                            <td>${error.attribute}</td>
                            <td>${error.value}</td>
                            <td>${error.error}</td>
                            </tr>
                            `
                            );
                        });
                        $('#import-errors-modal').modal('show');
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                    // List error
                    $('#import-errors-modal tbody').html('');
                    for (const rowNumber in responseData.errors) {
                        let appendedRow = `
                            <tr>
                            <td rowspan="${responseData.errors[rowNumber].length}">${rowNumber}</td>`;
                        for (const errorIndex in responseData.errors[rowNumber]) {
                            appendedRow += `
                                <td><span class="badge rounded-pill badge-light-primary">${responseData.errors[rowNumber][errorIndex].attribute}</span></td>
                                <td>${responseData.errors[rowNumber][errorIndex].value}</td>
                                <td><span class="badge rounded-pill badge-light-danger">${responseData.errors[rowNumber][errorIndex].error}</span></td>
                                </tr>
                            `
                        }

                        $('#import-errors-modal tbody').append(
                            appendedRow
                        );
                    }
                    $('#import-errors-modal').modal('show');
                    showError(responseData.errors);
                }
            });

        });

        // Handle Export file
        $(document).on('click', '.submit-export', function() {
            $('#export-form').find('input[name="type"]').val($(this).data('type'));
            $('#export-form').submit();
        });

        // Handle Export types changes
        $(document).on('click', '.export-types .dropdown-item', function() {
            $('.submit-export').data('type', $(this).data('type'));
        });
    }
</script>

{{-- <script type="module">
    Echo.channel('chat')
    .listen('.message.sent', (e) => {
        console.log('listening event', e);
    });

    Echo.private(`chat`)
        .listen('message.sent', (e) => {
            console.log(e.message);
        });

</script> --}}








{{-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> --}}
{{-- <script src="//js.pusher.com/3.1/pusher.min.js"></script> --}}
{{-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> --}}


{{-- <script src="{{asset('js/pusher.min.js')}}"></script>
<script type="text/javascript">

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true; // don't include this in production

    var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
        cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
        encrypted: true
    });

    pusher.connection.bind('connected', function() {
        console.log('Connected to Pusher!');
    });

    pusher.connection.bind('error', function(err) {
        console.error('Pusher error:', err);
    });

    var channel = pusher.subscribe('notifications');
    channel.bind('notification-updated', function(data) {
        alert('Pusher is done !');

        fetch("{{ route('pusher.listAllNotification')}}")
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                const notificationDropdown = document.querySelector('.onhover-dropdown');
                notificationDropdown.innerHTML = response.html;
                feather.replace(); // Reinitialize feather icons if needed
            } else {
                console.error("Failed to fetch notifications:", response.message);
            }
        })
        .catch(error => {
            console.error("Error fetching notifications:", error);
        });

    });

</script> --}}

 <script src="{{ asset('js/app.js') }}"></script>


<script>
    window.Echo.channel('notifications')
        .listen('.notification-updated', (e) => {
            console.log('Notification received:', e.message);
            fetch("{{ route('pusher.listAllNotification')}}")
                .then(response => response.json())
                .then(response => {
                    if (response.success) {
                        const notificationDropdown = document.querySelector('.onhover-dropdown');
                        notificationDropdown.innerHTML = response.html;
                        feather.replace();
                    } else {
                        console.error("Failed to fetch notifications:", response.message);
                    }
                })
                .catch(error => {
                    console.error("Error fetching notifications:", error);
                });
        });
</script>

