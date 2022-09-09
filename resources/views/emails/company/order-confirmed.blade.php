@component('mail::message')
# Tack för er beställning

| Tjänst | Antal | Ord. Pris | Förhandlat Pris | Totalt
|:-------|:------|:----------|:---------------|:--------
@foreach ($plans['data'] as $row)
| {{ $row->name }} | {{ $row->plan_count }} | {{ $row->price }} | {{ $row->price_new }} | {{ number_format($row->price * $row->plan_count, 0) }}
@endforeach
|:-------|:------|:----------|:---------------|:--------
| Summa  | &nbsp;| &nbsp;    | &nbsp;         |  {{ number_format($plans['total'], 0) }} Kr

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

@if($company->extra)
## Övriga kommentarer
{{ $company->extra }}
@endif

Tack,<br>
Team {{ config('app.name') }}
@endcomponent
