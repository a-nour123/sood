<div>
    <div class="todo-app-list">

        <!-- control List starts -->
        <div class="todo-task-list-wrapper list-group">
            <ul class="todo-task-list media-list" id="todo-task-list">




    <!--<div id="firstTab{{ $item->id }}" class="tabcontent">-->
    <div  class="tabcontent" >

        <!-- Dark Tables start -->
        <div class="row" id="dark-table" >
            <div class="col-12">

                <div class="card2" >
                    <div class="card">
                        <div class="card-body" >
                            <div class="frame">
                                <h4 class="card-title"> {{ __('locale.Name') }} : </h4>
                                <h5 class="card-desc"> {{ $item->name}} </h5>
                            </div>

                            <!-- <a href="#" class="card-link">Another link</a> -->
                            @if (auth()->user()->hasPermission('category.update'))
                            <button type="button" class="card-link btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#edit-modal{{ $item->id}}">
                                {{ __('locale.Edit') }}
                            </button>
                            @endif
                            @if (auth()->user()->hasPermission('category.delete'))
                            <form class="category_del" action="{{route('admin.governance.category.destroy',  $item->id )}}" style="display: inline-block;" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="card-link btn btn-outline-danger update-btn">{{ __('locale.Delete') }}</button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('admin.content.governance.modals.update_document')

        @include('admin.content.governance.modals.create_document')

        <li class="todo-item" >

            <!-- Advanced Search -->
            <section id="advanced-search-datatable" >
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header border-bottom p-1">
                                <div class="head-label">
                                    <h4 class="card-title">{{ __('locale.Documents') }}</h4>
                                </div>
                                @if (auth()->user()->hasPermission('document.create'))
                                <div class="dt-action-buttons text-end">
                                    <div class="dt-buttons d-inline-flex">
                                        <button class="dt-button  btn btn-primary  me-2" type="button" data-bs-toggle="modal" data-bs-target="#add_control{{$item->id}}">
                                            {{ __('locale.AddANewDocument') }}
                                        </button>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!--Search Form -->

                            <hr class="my-0" />
                            <div class="card-datatable table-responsive mx-1" style="min-height: 300px">
                                <table class=" table">
                                    <!--                            <table class="dt-advanced-search{{ $item->id }} table">-->
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th class="all">{{ __('locale.Name') }}</th>
                                        <th class="all">{{ __('locale.Frameworks') }}</th>
                                        <th class="all">{{ __('locale.Controls') }}</th>
                                        <th class="all">{{ __('locale.CreationDate') }}</th>
                                        <th class="all">{{ __('locale.ApprovalDate') }}</th>
                                        <th class="all">{{ __('locale.Status') }}</th>
                                        <th class="all">{{ __('locale.Actions') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($frameworks as $document)
                                    <tr>
                                        <td></td>
                                     {{--   <td>{{$document->document_name}}</td>
                                        <td>
                                            @foreach($document->Frameworks as $frame)
                                            {{$frame->name}}
                                            @endforeach
                                        </td> --}}
                                        <td>{{$document->id}}</td>
                                        <td>{{$document->id}}</td>
                                        <td>{{$document->id}}</td>
                                        <td>{{$document->id}}</td>
                                        <td>{{$document->id}}</td>
                                    </tr>
                                    @endforeach

                                    </tbody>

                                </table>
                                <div style="text-align: right">

                                @for($page=1;$page<=$pagesCount;$page++)
                                <a style="width: 20px;height: 20px;border-radius: 20%;text-align: center;padding: 2px;"
                                   class="btn btn-info   "   @if($page==request('page') )  id="activePage" @endif
                                   href="{{url('/admin/governance/category?page='.$page)}}">{{$page}}</a>
                                @endfor
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </section>
            <!--/ Advanced Search -->
        </li>
    </div>



</div>
        </ul>
    </div>
    <style>
        #activePage{
            border: 1px solid black !important;
            background-color: #1a252f !important;
        }
    </style>
</div>
