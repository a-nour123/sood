@component('mail::message')
# {{ __('third_party.Hello') }}, {{$contact['name']}}

{{ __('third_party.mail_content') }}

{{-- @if (isset($note))
    with some updates: <br>
    {!! $note !!}
@endif --}}



<a style="
    display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    text-decoration: none;
    background-color: #44225c;
    color: #fff;
    border: 2px solid #44225c;
    border-radius: 5px;" href="{{route('admin.viewAnswer',encrypt($data->id))}}">{{$data->name}}</a>

# {{ __('third_party.The access password') }}

{{ $contact['access_password'] }}

{{ __('third_party.Thanks') }},<br>
{{ config('app.name') }}
@endcomponent
