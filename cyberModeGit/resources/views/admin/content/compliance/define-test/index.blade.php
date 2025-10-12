@extends('admin/layouts/contentLayoutMaster')

@section('title', __('compliance.Define Tests'))

@section('vendor-style')
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">

  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">

  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">

  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
<link rel="stylesheet" type="text/css" href="{{asset('css/base/plugins/forms/pickers/form-flat-pickr.css')}}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
<link rel="stylesheet" href="{{asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css'))}}">
@endsection
@section('content')

<!-- Advanced Search -->
<section id="advanced-search-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card">

        <div class="card-header border-bottom p-1">
          <div class="head-label">
          <h4 class="card-title">{{ __('compliance.Define Tests') }}</h4></div>
            <div class="dt-action-buttons text-end">
              <div class="dt-buttons d-inline-flex">
                 <!-- <button class="dt-button  btn btn-primary  me-2" type="button" data-bs-toggle="modal" data-bs-target="#add-new-test">
                 {{ __('compliance.add-new-test') }}
                </button>  -->
                 <button class="dt-button  btn btn-info  me-2" type="button" onclick="CreateAuditSellectAll()">
                 {{ __('compliance.Initiate Audits') }}
                </button>
              </div>
            </div>
        </div>
        <!--Search Form -->
        <div class="card-body mt-2">
          <form class="dt_adv_search" method="POST">
            <div class="row g-1 mb-md-1">
            <div class="col-md-4">
                <label class="form-label">{{ __('compliance.control-name:') }}</label>
                <select class="form-control dt-input dt-select select2 " id="control" data-column="2" data-column-index="1" >
                  <option value="">{{ __('locale.select-option') }}</option>
                  @foreach($controls as $control)
                    <option value="{{$control->short_name}}">{{$control->short_name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4">
                <label class="form-label">{{ __('compliance.control-framework:') }}</label>
                <select class="form-control dt-input dt-select select2 " id="framework" data-column="3" data-column-index="2" >
                  <option value="">{{ __('locale.select-option') }}</option>
                  @foreach($frameworks as $framework)
                    <option value="{{$framework->name}}" data-id="{{$framework->id}}">{{$framework->name}}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-4">
                <label class="form-label">{{ __('compliance.control-family:') }}</label>
                <select class="form-control dt-input dt-select select2 "  data-column="4" data-column-index="3" >
                  <option value="">{{ __('locale.select-option') }}</option>
                  @foreach($families as $family)
                    <option value="{{$family->name}}" >{{$family->name}}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-4">
                <label class="form-label">{{ __('compliance.control-name:') }}</label>
                <select class="form-control dt-input dt-select select2 " id="control" data-column="4" data-column-index="3" >
                  <option value="">{{ __('locale.select-option') }}</option>
                  @foreach($controls as $control)
                    <option value="{{$control->short_name}}">{{$control->short_name}}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-4">
                <label class="form-label">Name:</label>
                <input class="form-control dt-input " data-column="5" data-column-index="4" type="text">

              </div>

            </div>

          </form>
        </div>
        <hr class="my-0" />

        <div class="card-datatable">
          <table class="dt-advanced-search table">
            <thead>
              <tr>
                <th></th>
                <th></th>
                <th>{{ __('compliance.control') }}</th>
                <th>{{ __('compliance.framework') }}</th>
                <th>Domain</th>
                <th>{{ __('locale.tester') }}</th>
                <th>{{ __('locale.TestFrequency') }}</th>
                <th>{{ __('locale.last-test') }}</th>
                <th>{{ __('locale.next-test') }}</th>
                <th>{{ __('locale.Actions') }}</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th></th>
                <th></th>
                <th>{{ __('compliance.control') }}</th>
                <th>{{ __('compliance.framework') }}</th>
                <th>Domain</th>
                <th>{{ __('locale.tester') }}</th>
                <th>{{ __('locale.TestFrequency') }}</th>
                <th>{{ __('locale.last-test') }}</th>
                <th>{{ __('locale.next-test') }}</th>
                <th>{{ __('locale.Actions') }}</th>

              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
<!--/ Advanced Search -->

<!-- modal add new test -->
<!-- @include('admin.content.compliance.define-test.add_test'); -->


<!-- modal edit test -->
@include('admin.content.compliance.define-test.edit_test');
<!-- modal edit test -->



@endsection
@section('vendor-script')
<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>

  <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js')) }}"></script>

<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>


<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-script')
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset('ajax-files/compliance/define-test.js') }}"></script>

<script>

  //  ajax to call tests list and call create datatable
  function loadDatatable(){

    $.ajax({
          url: "{{ route('admin.compliance.ajax.get-list-test') }}",
          type:"GET",
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          data:{},
              success: function (data) {
                  createDatatable(data);
              },
              error: function() {
                  //
              }
    });
  }

  loadDatatable();



    // filter on control change framework
    $('#framework').change(function(){
      var frameworkID=$(this).find(':selected').attr('data-id');
      let url="{{ route('admin.compliance.ajax.get-control-framework', ':id') }}";
      url = url.replace(':id', frameworkID);
      //  ajax to call tests list and call create datatable
      $.ajax({
            url: url,
            type:"GET",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:{},
                success: function (data){
                    $('#control').empty();
                    $('#control').html(data);

                }
      });
    });


    //function to show edit test modal
    function ShowModalEditTest(id){


      let url="{{ route('admin.compliance.test.edit',':id') }}";
      url = url.replace(':id', id);

      $.ajax({
            url: url,
            type:"GET",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:{},
                success: function (data){
                  var test=data['test'];
                  var teams=data['teams'];
                    $('#edit-test input[name="test_id"]').val(test['id']);
                    $('#edit-test input[name="test_frequency"]').val(test['test_frequency']);
                    $('#edit-test input[name="name"]').val(test['name']);
                    $('#edit-test input[name="last_date"]').val(test['last_date']);
                    $('#edit-test textarea[name="test_steps"]').val(test['test_steps']);
                    $('#edit-test input[name="approximate_time"]').val(test['approximate_time']);
                    $('#edit-test textarea[name="expected_results"]').val(test['expected_results']);

                    $('#edit-test select[name="tester"]').val(test['tester']).trigger('change');
                    $('#edit-test select[name="framework_control_id"]').val(test['framework_control_id']).trigger('change');
                    $('#edit-test select[name="teams[]"]').val(teams).trigger('change');
                    $('#edit-test select[name="additional_stakeholders[]"]').val(test['additional_stakeholders'].split(',')).trigger('change');
                    // $('#edit-test select[name="tester"]').val(1).trigger('change');
                    $('#edit-test').modal('show');
                    // alert(1);
                }
      });
    }

    // function to edit test by ajax
    $('#edit-test form').submit(function(e){
      e.preventDefault();
      var id=$('#edit-test input[name="test_id"]').val();
      let url="{{ route('admin.compliance.test.update',':id') }}";
      url = url.replace(':id', id);

      $.ajax({
              url: url,
              type: "PUT",
              data: $(this).serialize(),
                  success: function (data) {
                    if(data['status']){
                      makeAlert('success',  'You have successfully added new value!', ' Created!');
                      $('form#edit-record').trigger("reset");
                      $('#edit-test').modal('hide');
                      $("#advanced-search-datatable").load(location.href+" #advanced-search-datatable>*","");
                      loadDatatable();
                    }else{
                      showError(data['errors'] ,'edit-record');
                    }
                    // alert(data);

                  }
      });
    });

    function ShowModalDeleteTest(id){
      Swal.fire({
        title: "{{ __('locale.AreYouSureYouWantToDeleteThisTest') }}",
        text: "{{ __('locale.YouWontBeAbleToRevertThis') }}",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        customClass: {
          confirmButton: 'btn btn-relief-success ms-1',
          cancelButton: 'btn btn-outline-danger ms-1'
        },
        buttonsStyling: false
      }).then(function (result) {

        if (result.value) {
          DeleteTest(id);
          Swal.fire({
            icon: "{{ __('locale.Success') }}",
            title: "{{ __('locale.Delete') }}",
            text: "{{ __('locale.SuccessTestDeleted') }}",
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        }
      });
    }

    function DeleteTest(id){
      let url="{{ route('admin.compliance.test.destroy',':id') }}";
      url = url.replace(':id', id);
      $.ajax({
              url: url,
              type: "DELETE",
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              data: $(this).serialize(),
              success: function (data) {
                $("#advanced-search-datatable").load(location.href+" #advanced-search-datatable>*","");
                loadDatatable();
              }
      });
    }

    function showModalCreateAudit(id){
      Swal.fire({
        title: "{{ __('compliance.InitiateTest') }}",
        text: "{{ __('locale.YouWillConfrimInitiateTest') }}",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: "{{ __('locale.Confrim') }}",
        customClass: {
          confirmButton: 'btn btn-relief-success ms-1',
          cancelButton: 'btn btn-outline-danger ms-1'
        },
        buttonsStyling: false
      }).then(function (result) {

        if (result.value) {
          CreateAuditTest(id);
          Swal.fire({
            icon: "{{ __('locale.Success') }}",
            title: "{{ __('compliance.InitiateTest') }}",
            text: "{{ __('compliance.InitiateTestSuccessfully') }}",
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        }
      });
    }
    function CreateAuditSellectAll(){
      var groupTestIds=$('input[name="audits[]"]:checked');
      if(groupTestIds.length<=0){
        makeAlert('error',"{{ __('locale.PleaseSelectOneTestAtLeast') }}", ' Error!');
      }else{
        var groupTestIdsString='';
        groupTestIds.each(function(){
          if($(this).is(':checked'))
          {
            groupTestIdsString=$(this).val()+','+groupTestIdsString;
          }
        });
        //
        showModalCreateAudit(groupTestIdsString);
      }

      //
    }
    // create  Audit for list of tests
    function CreateAuditTest(id){

      let url="{{ route('admin.compliance.audit.store') }}";
      $.ajax({
        url: url,
        type: "POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {
          id:id
        },success: function (data) {
              //
        }
      });
    }
</script>




@endsection
