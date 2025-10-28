<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script>
    var permission = [];
    permission['edit'] = {{ auth()->user()->hasPermission('control.update')? 1: 0 }};
    permission['delete'] = {{ auth()->user()->hasPermission('control.delete')? 1: 0 }};

    $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
    //datepicker start

    var $input = $('.js-datepicker').pickadate({
    format: 'yyyy-mm-dd',
    firstDay: 1,
    formatSubmit: 'yyyy-mm-dd',
    hiddenName: true,
    editable: true
});

    var picker = {};

    //datepicker end

});
</script>

<script>
    $('.multiple-select2').select2();

    // //tab
    function openTab(evt, cityName, id) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
}
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
}
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";

    // $( "#todo-item" ).empty();

    var url = "{{ route('admin.governance.ajax.get-list-test', '') }}" + "/" + id;
    var unmap_url = "{{ route('admin.governance.unmap.control', '') }}" + "/" + id;
    var myobj = document.getElementsByClassName('dt-advanced-search' + id);
    $(this).remove();
    $.ajax({
    url: url,
    type: "GET",
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
},
    data: {},
    success: function(data) {
    var isRtl = $('html').attr('data-textdirection') === 'rtl';
    var dt_ajax_table = $('.datatables-ajax'),
    dt_filter_table = $('.dt-column-search'),
    dt_adv_filter_table = $('.dt-advanced-search' + id),
    dt_responsive_table = $('.dt-responsive'),
    assetPath = '../../../app-assets/';
    if ($('body').attr('data-framework') === 'laravel') {
    assetPath = $('body').attr('data-asset-path');
}
    if (dt_adv_filter_table.length) {
    dt_adv_filter_table.DataTable().clear().destroy();
    var dt_adv_filter = dt_adv_filter_table.DataTable({
    data: data,
    lengthMenu: [
    [10, 25, 50, -1],
    [10, 25, 50, "All"]
    ],

    columns: [{
    data: 'responsive_id'
},
    // { data: 'framework' },
    // { data: 'map_id' },
{
    data: 'control'
},
{
    data: 'description'
},
{
    data: 'parent_family_name'
},
{
    data: 'family_name'
},

    // { data: 'map_id' },

{
    data: "map_id",
    render: function(data, type, row, meta) {
    return type === 'display' ?
    '<a  href="javascript:;" onclick="unmap(' + data +
    ')" class="item-edit">' +
    feather.icons['git-merge'].toSvg({
    class: 'font-small-4'
}) +
    '</a>' :
    data;
}
},

{
    data: 'id'
},

    ],
    columnDefs: [
{ width: '35%', targets: 2 },
{
    title: '#',
    className: 'index',
    orderable: false,
    responsivePriority: 2,
    targets: 0
}, {
    // Actions
    targets: -1,
    title: 'Actions',
    orderable: false,
    render: function(data, type, full, meta) {
    let returnedString = '';
    if (permission['edit']) {
    returnedString +=
    '<a  href="javascript:;" onclick="editControl(' +
    data + ')" class="item-edit dropdown-item ">' +
    feather.icons['edit'].toSvg({
    class: 'me-50 font-small-4'
}) +
    'Edit</a>';
}

    if (permission['delete']) {
    returnedString +=
    '<a  href="javascript:;" onclick="deleteControl(' +
    data +
    ')" class="dropdown-item  btn-flat-danger">' +
    feather.icons['trash-2'].toSvg({
    class: 'me-50 font-small-4'
}) +
    'Delete</a>';
}


    if (returnedString == '')
    return ('------');
    else
    return (
    '<div class="d-inline-flex">' +
    '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
    feather.icons['more-vertical'].toSvg({
    class: 'font-small-4'
}) +
    '</a>' +
    '<div class="dropdown-menu dropdown-menu-end">' +
    returnedString +
    '</div>' +
    '</div>'
    );
}
}],
    dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    orderCellsTop: true,
    responsive: {
    details: {
    display: $.fn.dataTable.Responsive.display.modal({
    header: function(row) {
    var data = row.data();
    return 'Details of ' + data['name'];
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
    return data ? $('<table class="table"/><tbody />').append(
    data) : false;
}
}
},
    language: {
    paginate: {
    previous: '&nbsp;',
    next: '&nbsp;'
}
}
});
    dt_adv_filter.on('order.dt search.dt', function() {
    dt_adv_filter.column(0, {
    search: 'applied',
    order: 'applied'
}).nodes().each(function(cell, i) {
    cell.innerHTML = i + 1;
});
}).draw();
}
    $('input.dt-input').on('keyup', function() {
    filterColumn($(this).attr('data-column'), $(this).val());
});
    $('select.dt-select').on('change', function() {
    filterColumn($(this).attr('data-column'), $(this).val());
});
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm').removeClass(
    'form-control-sm');
},
    error: function() {
    //
}
});

    function filterColumn(i, val) {
    $('.dt-advanced-search').DataTable().column(i).search(val, false, true).draw();
}

}

    // @if (count($categoryList))
    // document.getElementById("defaultOpen").click();
    // @endif

    // // mapping using ajax
    $('.userinfo').click(function() {

    var userid = $(this).data('id');
    var url = "{{ route('admin.governance.ajax.get-list-map', '') }}" + "/" + userid;

    // AJAX request
    $.ajax({
    url: url,
    type: "GET",
    data: {},
    success: function(response) {
    $('#empModal').modal('show');
    $('#form-modal-map').html(response);

}
});
});


    // unmap
    // // mapping using ajax
    function unmap(data) {

    var unmap_url = "{{ route('admin.governance.unmap.control', '') }}" + "/" + data;
    // AJAX request
    $.ajax({
    url: unmap_url,
    type: "GET",
    data: {},
    success: function(response) {
    makeAlert('success', data.message, "{{ __('locale.Success') }}");
    location.reload();
}
});
};


    // edit control
    function editControl(data) {

    var url = "{{ route('admin.governance.ajax.edit_control', '') }}" + "/" + data;
    // AJAX request
    $.ajax({
    url: url,
    type: "GET",
    data: {},
    success: function(response) {

    $('#edit_contModal').modal('show');
    $('#form-modal-edit').html(response);

    $('#form-modal-edit').find('.select2').select2();
}

});
};



    $(".frame_del").submit(function(event) {
    event.preventDefault();
    $.ajax({
    url: $(this).attr('action'),
    type: "POST",
    data: $(this).serialize(),
    success: function(data) {
    if (data.status) {
    makeAlert('success', data.message, "{{ __('locale.Success') }}");
    if (data.reload)
    location.reload();
} else {
    makeAlert('error', data.message, "{{ __('locale.Error') }}");
}
},
    error: function(response, data) {
    responseData = response.responseJSON;
    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
    showError(responseData.errors);
}
});
});



    $('.form-edit').submit(function(e) {
    e.preventDefault();
    $.ajax({
    url: $(this).attr('action'),
    type: 'POST',
    data: $(this).serialize(),
    success: function(data) {
    if (data.status) {
    makeAlert('success', data.message, "{{ __('locale.Success') }}");
    if (data.reload)
    location.reload();
} else {
    showError(data['errors']);
}
},
    error: function(response, data) {
    responseData = response.responseJSON;
    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
    showError(responseData.errors);
}
});

});


    $('.form-copy').submit(function(e) {
    e.preventDefault();
    $.ajax({
    url: $(this).attr('action'),
    type: 'POST',
    data: $(this).serialize(),
    success: function(data) {
    if (data.status) {
    makeAlert('success', data.message, "{{ __('locale.Success') }}");
    if (data.reload)
    location.reload();
} else {
    showError(data['errors']);
}
},
    error: function(response, data) {
    responseData = response.responseJSON;
    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
    showError(responseData.errors);
}


});

});

    $('.add_frame').submit(function(e) {
    e.preventDefault();
    $.ajax({
    url: $(this).attr('action'),
    type: 'POST',
    data: $(this).serialize(),
    success: function(data) {
    if (data.status) {
    makeAlert('success', data.message, "{{ __('locale.Success') }}");
    if (data.reload)
    location.reload();
} else {
    showError(data['errors']);
}
},
    error: function(response, data) {
    responseData = response.responseJSON;
    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
    showError(responseData.errors);
}


});

});

    $('.form-add_control').submit(function(e) {
    e.preventDefault();

    $('.error').empty();
    $.ajax({
    url: $(this).attr('action'),
    type: 'POST',
    data: $(this).serialize(),
    success: function(data) {
    if (data.status) {
    makeAlert('success', data.message, "{{ __('locale.Success') }}");
    if (data.reload)
    location.reload();
} else {
    showError(data['errors']);
}
},
    error: function(response, data) {
    responseData = response.responseJSON;
    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
    showError(responseData.errors);
}


});

});


    $('#form-update_control').submit(function(e) {
    e.preventDefault();
    $('.error').empty();
    $.ajax({
    url: $('#form-update_control').attr('action'),
    type: 'POST',
    data: $('#form-update_control').serialize(),
    success: function(data) {
    if (data.status) {
    makeAlert('success', data.message, "{{ __('locale.Success') }}");
    if (data.reload)
    location.reload();
} else {
    showError(data['errors']);
}
},
    error: function(response, data) {
    responseData = response.responseJSON;
    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
    showError(responseData.errors);
}


});

});


    function showError(data) {
    $('.error').empty();
    $.each(data, function(key, value) {
    $('.error-' + key).empty();
    $('.error-' + key).append(value);
});
}

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



    // $(document).ready(function() {


    //     'use strict'

    //     // Fetch all the forms we want to apply custom Bootstrap validation styles to
    //     var forms = document.querySelectorAll('.needs-validation')
    //     // Loop over them and prevent submission
    //     Array.prototype.slice.call(forms)
    //         .forEach(function(form) {
    //             form.addEventListener('submit', function(event) {
    //                 if (!form.checkValidity()) {
    //                     event.preventDefault()
    //                     event.stopPropagation()
    //                 } else if (form.checkValidity() == true) {
    //                     // makeAlert('success', "created successfuly", "{{ __('locale.Success') }}");
    //                     // location.reload();

    //                     // stop form submit only for demo
    //                     // event.preventDefault();
    //                 }

    //                 form.classList.add('was-validated')


    //             }, false)
    //         })
    // });


    function deleteControl(data) {
        var url = "{{ route('admin.governance.control.destroy', '') }}" + "/" + data;
        // AJAX request
        $.ajax({
            url: url,
            type: "GET",
            data: {},
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $("#advanced-search-datatable").load(location.href + " #advanced-search-datatable>*",
                        "");
                    location.reload();
                }
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }

    // Load subdomains of domain
    $(document).on('change', '.domain_select', function() {
    const subDomains = $(this).find('option:selected').data('families');
    const subDomainSelect = $(this).parents('.family-container').next().find('select');
    subDomainSelect.find('option:not(:first)').remove();
    subDomainSelect.find('option:first').attr('selected', true)
    if (subDomains)
    subDomains.forEach(subDomains => {
    subDomainSelect.append(
    `<option value="${subDomains.id}">${subDomains.name}</option>`
    );
});
});

    // Load subdomains of framework domain
    $(document).on('change', '.framework_domain_select', function() {
    const oldDomains = $(this).data("prev"),
    currentDomains = $(this).val();
    let deletedDomains = oldDomains.filter(x => !currentDomains.includes(x));
    let addedDomains = currentDomains.filter(x => !oldDomains.includes(x));
    const subDomainSelect = $(this).parents('.family-container').next().find('select');

    addedDomains.forEach(domain => {
    const subDomains = $(this).find(`[value="${domain}"]`).data('families');
    if (subDomains)
    subDomains.forEach(subDomains => {
    subDomainSelect.append(
    `<option data-parent="${domain}" value="${subDomains.id}">${subDomains.name}</option>`
    );
});
});

    deletedDomains.forEach(domain => {
    subDomainSelect.find('option[data-parent="' + domain + '"]').remove();
});

    subDomainSelect.trigger('change');
    $(this).data("prev",$(this).val());
});

    $(document).on('change', '[name="parent_id"]', function() {
    if ($(this).val()) {
    $('[name="family"]').val('').trigger('change').prop('disabled', true);
    $('[name="sub_family"]').val('').trigger('change').prop('disabled', true);
} else {
    $('[name="family"]').prop('disabled', false);
    $('[name="sub_family"]').prop('disabled', false);
}
});

    $(document).ready(function () {
    $('.framework_domain_select').trigger('change');
    setTimeout(() => {
    const subDomainsSelect = $('.framework_domain_select').parents('.family-container').next().find('select[data-subdomains]');
    subDomainsSelect.each((index, subDomainSelect) => {
    const sobDomains = $(subDomainSelect).data('subdomains');
    sobDomains.forEach(domain => {
    $(subDomainSelect).find('option[value="' + domain + '"]').attr('selected', true).trigger('change');
});
});

}, 1000);
});
    </script>


    <script src="{{ asset('js/scripts/pages/app-chat-framework.js') }}"></script>
