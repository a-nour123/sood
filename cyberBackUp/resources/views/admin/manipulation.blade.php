@php
$configData = Helper::applClasses();
@endphp
@extends('admin/layouts/fullLayoutMaster')

@section('title', 'Manipulation occurred')

@section('page-style')
<link rel="stylesheet" href="{{asset(mix('css/base/pages/page-misc.css'))}}">
@endsection

@section('content')
<!-- Not authorized-->
<div class="misc-wrapper">
  <a class="brand-logo" href="https://www.advancedcontrols.sa/">
    <h2 class="brand-text text-primary ms-1">Cyber Mode</h2>
  </a>
  <div class="misc-inner p-2 p-sm-3">
    <div class="w-100 text-center">
      <h2 class="mb-1">Some system manipulation occurred! 🔐</h2>
      <p class="mb-2">Please contact us as soon as possible. <a href="tel:00966114579181">📞</a> 📩</p>
      @if($configData['theme'] === 'dark')
      <img class="img-fluid" src="{{asset('images/pages/not-authorized-dark.svg')}}" alt="Not authorized page" />
      @else
      <img class="img-fluid" src="{{asset('images/pages/not-authorized.svg')}}" alt="Not authorized page" />
      @endif
    </div>
  </div>
</div>
<!-- / Not authorized-->
@endsection
