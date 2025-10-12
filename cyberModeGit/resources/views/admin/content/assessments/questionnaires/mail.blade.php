@component('mail::message')
# Hello, {{$contact['name']}}

{{ __('assessment.Admin has asked you to complete the following risk assessment questionnaire') }}

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
    border-radius: 5px;" href="{{route('admin.questionnaires.view',encrypt($data->id))}}">{{$data->name}}</a>


{{ __('locale.Thanks') }},<br>
{{ config('app.name') }}
@endcomponent
