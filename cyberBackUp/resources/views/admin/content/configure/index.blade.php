@extends('admin/layouts/contentLayoutMaster')

@section('title', __('configure.Settings'))

@section('content')
<div class="row">
    <div class="col-12">
        <div class="alert alert-primary" role="alert">
            <div class="alert-body">
                Here in configure main route use this route in blade as <br><strong>route('admin.configure.index')</strong>
            </div>
        </div>
    </div>
</div>
@endsection
