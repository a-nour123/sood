@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.Hierarchy'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('fonts/font-awesome/css/font-awesome.min.css')) }}">
    {{-- <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/jstree.min.css')) }}"> --}}

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/katex.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/monokai-sublime.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.snow.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.bubble.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('fonts/font-awesome/css/font-awesome.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/jstree.min.css')) }}">
    <link rel="stylesheet" href="{{ asset('vendors/org/jquery-ui-1.10.4.custom.min.css') }}">

    <link rel="stylesheet" href="{{ asset('vendors/org/jHTree.css') }}">
    @endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-tree.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-quill-editor.css')) }}">
    <style>
        body {
            background-color: #fafafa;
            font-family: 'Roboto';
        }

        #themes {
            font-size: 1.2em;
        }

        #set {
            border: 2px solid #ddd;
            padding: 2px;
            background: #444;
            width: 350px;
            height: 30px;
        }

        #set a {
            margin: 2px;
            border: 1px solid #444;
            float: left;
        }

        #set a:hover {
            border-color: #fff;
        }

        .tree li .trcont {
            width: auto;
            display: inline-block;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            -moz-box-shadow: 5px 5px 5px #888;
            box-shadow: none;
            padding: 15px;
            border: 1px solid #3333334d;
        }

        #tree {
            color: white !important;
        }

        .tree ul {
            width: max-content;
        }

        .tree ul .trcont {
            color: #FFF;
        }

        .tree {
            zoom: 100% ;

        }


        .funcbtnb.ui-state-default.ui-corner-all {
            display: none !importat;
        }

        .funcbtna.ui-state-default.ui-corner-all {
            display: block !important;
            margin-top: 109px;
            margin-right: -12px;
            border-radius: 50%;
            width: 23px;
            height: 23px;
        }

        .funcbtna.ui-state-default.ui-corner-all.hide-collapse-element {
            display: none !important;
        }

        .funcbtna.ui-state-default.ui-corner-all .ui-icon-triangle-1-n {
            background-position: 3px -14px;
        }

        .funcbtna.ui-state-default.ui-corner-all .ui-icon-triangle-1-s {
            background-position: -62px -13px;
        }

        .trcont .ui-widget-header,
        .trcont .ui-widget-content {
            border: 0;
            color: #FFF;
            cursor: auto !important;
        }

        .tree_numbers {
            display: flex;
            place-content: space-between;
            margin-top: 10px;
        }

        .zomrval {
            border: 0;
            color: #33acb9;
            font-weight: bold;
            width: 35px;
            margin-bottom: 7px;
        }

        .grid-container {
  display: grid;
  min-height: 65vh; 
  place-items: center; 
}


        @foreach ($departments as $department)

            .tree ul li#id_{{ $department['id'] }} .trcont,
            .tree ul li#id_{{ $department['id'] }} .trcont .ui-widget-header,
            .tree ul li#id_{{ $department['id'] }} .trcont .ui-widget-content {
                background: {{ $department['department_color'] }} !important;
            }
        @endforeach
    </style>
    @endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-12 mb-2">

        <div class="row breadcrumbs-top  widget-grid">
            <div class="col-12">
                <div class="page-title mt-2">
                    <div class="row">
                        <div class="col-sm-12 ps-0">
                            @if (@isset($breadcrumbs))
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"
                                            style="display: flex;">
                                            <svg class="stroke-icon">
                                                <use href="{{ asset('fonts/icons/icon-sprite.svg#stroke-home') }}">
                                                </use>
                                            </svg></a></li>
                                    @foreach ($breadcrumbs as $breadcrumb)
                                        <li class="breadcrumb-item">
                                            @if (isset($breadcrumb['link']))
                                                <a
                                                    href="{{ $breadcrumb['link'] == 'javascript:void(0)' ? $breadcrumb['link'] : url($breadcrumb['link']) }}">
                                            @endif
                                            {{ $breadcrumb['name'] }}
                                            @if (isset($breadcrumb['link']))
                                                </a>
                                            @endif
                                        </li>
                                    @endforeach
                                </ol>
                            @endisset
                    </div>
                    
                </div>
            </div>
        </div>

    </div>
</div>
    <div id="event_result"></div>
    </div>
    <section class="context-drag-drop-tree">
      <div class="row">
      <div class="col-12 col-md-6">

<!-- Ajax Tree -->
<div >
    <div class="card mb-0">
        <div class="card-header">
            <h4 class="card-title">{{ __('hierarchy.Hierarchy') }}</h4>
        </div>
        <div class="card-body">
            <div id="jstree-ajax"></div>
        </div>
        <!--/ Ajax Tree -->
    </div>
</div>

<!-- Department details -->
<div class="col-12 col-md-6" style="display: none" id="department-details">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('hierarchy.Department') . ' ' . __('locale.Details') }}</h4>
        </div>
        <div class="card-body">
            <div style="padding-bottom: 10px;">
                <h5 class="d-inline">{{ __('locale.Name') }}:</h5>
                <div id="department-data-name" class="d-inline-block p-0"></div>
            </div>
            <div style="padding-bottom: 10px;">
                <h5 class="d-inline">{{ __('locale.Code') }}:</h5>
                <div id="department-data-code" class="d-inline-block p-0"></div>
            </div>
            <div style="padding-bottom: 10px;">
                <h5 class="d-inline">{{ __('hierarchy.DepartmentColor') }}:</h5>
                <div id="department-data-color" style="background-color: #f00div"
                    class="d-inline-block text-center rounded p-0">
                    </p>
                </div>
            </div>
            <div style="padding-bottom: 10px;">
                <h5 class="d-inline">{{ __('hierarchy.Manager') }}:</h5>
                <div id="department-data-manager" class="d-inline-block p-0"></div>
            </div>
            <div style="padding-bottom: 10px;">
                <h5 class="d-inline">{{ __('hierarchy.ParentDepartment') }}:
                </h5>
                <div id="department-data-parent" class="d-inline-block p-0"></div>
            </div>
            <div style="padding-bottom: 10px;">
                <h5 class="d-inline">
                    {{ __('locale.RequiredNumberOfEmplyees') }}:</h5>
                <div id="department-data-required-num-employee" class="d-inline-block p-0"></div>
            </div>
            <div style="padding-bottom: 10px;">
                <h5 class="d-inline">
                    {{ __('locale.ActualNumberOfEmplyees') }}:</h5>
                <div id="department-data-actual-num-employee" class="d-inline-block p-0"></div>
            </div>
            <div>
                <h5>{{ __('hierarchy.vision') }}:</h5>
                <div id="department-data-vision" class="ql-editor"></div>
            </div>
            <div>
                <h5>{{ __('hierarchy.message') }}:</h5>
                <div id="department-data-message" class="ql-editor"></div>
            </div>
            <div>
                <h5>{{ __('hierarchy.mission') }}:</h5>
                <div id="department-data-mission" class="ql-editor"></div>
            </div>
            <div>
                <h5>{{ __('hierarchy.objectives') }}:</h5>
                <div id="department-data-objectives" class="ql-editor"></div>
            </div>
            <div>
                <h5>{{ __('hierarchy.responsibilities') }}:</h5>
                <div id="department-data-responsibilities" class="ql-editor"></div>
            </div>
            <div>
                <h5 class="d-inline">{{ __('locale.CreatedDate') }}:</h5>
                <div class="d-inline-block" id="department-data-created-at"></div>
            </div>
        </div>
    </div>
    <!--/ Department details -->
</div>
</div>
<!-- Button trigger modal -->
<div class="col-12 col-md-6 ">
<div class="grid-container">
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    {{ __('locale.Organization Chart') }}</button>
</div>


</div>

      </div>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
 aria-labelledby="exampleModalLabel" aria-hidden="true" id="exampleModal">
    <div class="modal-dialog modal-fullscreen position-relative">

<!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog"> -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ __('locale.Organization Tree') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div id="tree" class="tree" style="overflow: auto;">

</div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>
    </section>
    <!--/ Tree section -->
    <div id="quill-content" class="d-none"></div>
@endsection

@section('vendor-script')

<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>

<script src="{{ asset(mix('vendors/js/editors/quill/katex.min.js')) }}"></script>
{{--  <script src="{{ asset(mix('vendors/js/editors/quill/highlight.min.js')) }}"></script>  --}}
<script src="{{ asset(mix('vendors/js/editors/quill/quill.min.js')) }}"></script>
@endsection


@section('page-script')

<script src="{{ asset('vendors/org/jquery-1.10.2.js') }}"></script>
<script src="{{ asset('cdn/html2canvas.js') }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/jstree.min.js')) }}"></script>
<script src="{{ asset('cdn/jspdf.min.js') }}"></script>

    
    <script src="{{ asset('vendors/org/jquery-ui-1.10.4.custom.min.js') }}"></script>
    <script src="{{ asset('vendors/org/jQuery.jHTree.js') }}"></script>
    {{--  <script src="{{ asset('js/scripts/html2pdf_v0.10.1_.bundle.min.js') }}"></script>  --}}



    <script>
        var tree = null;


        function ShowModalEditJob() {
            let url = "{{ route('admin.hierarchy.get_org_chart') }}";
            $.ajax({
                url: url,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    tree = generateDepartmentTree(response);
                    $("#tree").jHTree({
                        callType: 'obj',
                        structureObj: tree
                    });
                    $('.no-children').each(function() {
                        var className = $(this).attr('class');
                        var regex = /id_\d+/;

                        var matches = className.match(regex);
                        if (matches) {
                            $('#' + matches[0] + ' .after .funcbtna').addClass('hide-collapse-element');
                        }
                    });

                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                }
            });


        }
        ShowModalEditJob();

        function generateDepartmentTree(departments, parentId = null) {
            var tree = [];
            departments.forEach(function(department) {
                if (department.pid === parentId) {
                    var child = {
                        head: department.Name,
                        id: 'id_' + department.id,
                        contents: department.Manager + '<br> <div class="tree_numbers"> <span>' + ($.isNumeric(
                                department.RequiredNumber) ? department.RequiredNumber : '') +
                            '</span><span>  ' + department.ActualNumber +
                            '</span></div>',
                    };
                    var children = generateDepartmentTree(departments, department.id);
                    if (children.length > 0) {
                        child.children = children;
                    } else {
                        child.contents += ' <span class="no-children id_' + department.id + '"></span>';
                    }
                    tree.push(child);
                }
            });
            return tree;
        }



        $(document).ready(function() {
            $('.export-pdf-btn').click(function() {

                var filename = $(this).data('filename');
                treeWidth = $('#tremainul').width();
                getScreenshotOfElement(
                    $("div#tree").get(0),
                    0,
                    0,
                    treeWidth + 45,
                    $("#tree").height() + 30,
                    function(data) {
                        var pdf = new jsPDF("l", "pt", [
                            treeWidth,
                            $("#tree").height(),
                        ]);

                        pdf.addImage(
                            "data:image/png;base64," + data,
                            "PNG",
                            0,
                            0,
                            treeWidth,
                            $("#tree").height()
                        );
                        pdf.save(filename+".pdf");
                    }
                );
            });


            function getScreenshotOfElement(element, posX, posY, width, height, callback) {
                html2canvas(element, {
                    onrendered: function(canvas) {
                        var context = canvas.getContext("2d");
                        var imageData = context.getImageData(posX, posY, width, height).data;
                        var outputCanvas = document.createElement("canvas");
                        context.direction = "rtl";
                        context.font = "10px 'Arial Unicode MS'";
                        context.textAlign = "center";
                        var outputContext = outputCanvas.getContext("2d");
                        context.direction = "rtl";
                        context.font = "10px 'Arial Unicode MS'";
                        context.textAlign = "center";
                        outputCanvas.width = width;
                        outputCanvas.height = height;

                        console.log(outputContext);
                        var idata = outputContext.createImageData(width, height);
                        idata.data.set(imageData);
                        outputContext.putImageData(idata, 0, 0);
                        callback(outputCanvas.toDataURL().replace("data:image/png;base64,", ""));
                    },
                    width: width,
                    height: height,
                    useCORS: true,
                    taintTest: false,
                    allowTaint: false,
                    letterRendering:true,

                });
            }
        });

        /*  $(document).on('click', 'button.export-pdf-btn', function() {
              customExportOrgPDF($(this).data('filename'), $(this).data('tree'));
          });

          function customExportOrgPDF(fileName = "export", id_selector = 'tree') {
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
                      scale: 1,
                  },
                  jsPDF: {
                      unit: 'in',
                      format: 'A1',
                      orientation: 'landscape',
                  }
              };
              console.log(element);
              html2pdf().set(opt).from(element).outputImg().save();

          }*/
    </script>
    <script>
        const error = "{{ __('locale.Error') }}",
            success = "{{ __('locale.Success') }}",
            thisIsNotDraggable = "{{ __('locale.ThisIsNotDraggable') }}",
            url = "{{ route('admin.hierarchy.ajax.index') }}",
            updateUrl = "{{ route('admin.hierarchy.ajax.drag_and_drop') }}",
            getDepartmentURL = "{{ route('admin.hierarchy.department.ajax.show', ':id') }}";

        const quill = new Quill('#quill-content', {
            theme: 'bubble'
        });
        const obj = {
            "ops": [{
                "attributes": {
                    "color": "#5e5873",
                    "bold": true
                },
                "insert": "رسالة"
            }, {
                "attributes": {
                    "list": "bullet"
                },
                "insert": "\n"
            }, {
                "attributes": {
                    "color": "#5e5873"
                },
                "insert": "رسالة"
            }, {
                "attributes": {
                    "list": "bullet"
                },
                "insert": "\n"
            }, {
                "attributes": {
                    "color": "#5e5873"
                },
                "insert": "رسالة"
            }, {
                "attributes": {
                    "list": "bullet"
                },
                "insert": "\n"
            }, {
                "attributes": {
                    "color": "#5e5873"
                },
                "insert": "رسالة"
            }, {
                "attributes": {
                    "list": "bullet"
                },
                "insert": "\n"
            }, {
                "attributes": {
                    "color": "#5e5873"
                },
                "insert": "رسالة"
            }, {
                "attributes": {
                    "list": "bullet"
                },
                "insert": "\n"
            }]
        };
    </script>

    <script src="{{ asset('ajax-files/hierarchy/index.js') }}"></script>

    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>

@endsection
