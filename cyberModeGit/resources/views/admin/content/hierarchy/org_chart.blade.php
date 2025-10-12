@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.Organization Chart'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('fonts/font-awesome/css/font-awesome.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/jstree.min.css')) }}">

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/katex.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/monokai-sublime.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.snow.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.bubble.css')) }}">
    <link rel="stylesheet" href="{{ asset('vendors/org/jHTree.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/org/jquery-ui-1.10.4.custom.min.css') }}">

@endsection


@section('page-style')

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
            zoom: 100%;

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

    {{--  <button data-filename="{{ __('locale.Organization Chart') }} {{ __('locale.report') }}" type="button"
        class="btn btn-outline-primary export-pdf-btn">
        <i data-feather="file-text" class="me-25"></i>
        <span>{{ __('locale.Export') }} PDF</span>
    </button>  --}}
    <div id="tree" class="tree">

    </div>
 
@endsection

@section('page-script')
    <script src="{{ asset('vendors/org/jquery-1.10.2.js') }}"></script>
    <script src="{{ asset('cdn/html2canvas.js') }}"></script>
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
@endsection
