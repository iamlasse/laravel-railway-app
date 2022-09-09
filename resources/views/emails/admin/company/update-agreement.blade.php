@component('mail::message')
# {{$company->name}} vill förlänga avtalet



@component('mail::button', ['url' => route('admin.company.edit', $company->id)])
Uppdatera nu
@endcomponent

Tack,<br>
{{ config('app.name') }}
@endcomponent
