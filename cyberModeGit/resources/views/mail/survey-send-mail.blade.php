@component('mail::message')
# Introduction

the survey available check it now 
<br>
<br>
<a style="
    display: inline-block;
    padding: 5px 20px;
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    text-decoration: none;
    background-color: #44225c;
    color: #fff;
    border: 2px solid #44225c;
    border-radius: 5px;" href="{{route('admin.awarness_survey.GetSurveyFromMail',$survey->id)}}">Show Survey</a>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
