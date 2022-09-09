@component('mail::message')
# {{ $company->name }} vill ladda upp sitt avtal



@component('mail::button', ['url' => route('admin.company.edit', $company->id)])
Ladda upp...
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
