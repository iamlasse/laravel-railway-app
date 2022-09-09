@component('mail::message')
# Fortfarande på jakt efter telekomtjänster?
Hej {{$contact->name}},


Vi förstår att det är bland det tråkigaste som finns att upphandla telekomtjänster. 
Om du fortfarande är på jakt efter leverantörer för mobila tjänster, fasta tjänster, växeltjänster eller hårdvara, vänligen bekräfta nedan så uppdaterar vi mer än gärna giltighetstiden på dina offerter. 

Om du inte längre är intresserad så kan du ladda upp nuvarande avtal så skickar vi dig en benchmark när tiden för omförhandling är inne. Helt gratis.
Om du har några frågor kan du boka ett möte med oss här.

@component('mail::button', ['url' => $company->signedCtaUrl('update')])
Förlänga avtalets gilitghetstid
@endcomponent

@component('mail::button', ['url' => $company->signedCtaUrl('upload')])
Ladda upp avtal
@endcomponent

Tack,<br>
Team {{ config('app.name') }}
@endcomponent
