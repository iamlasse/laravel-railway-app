@component('mail::message')
# Låt oss börja!
## Välkommen till Telekomkollen! Nu kan du konfigurera tjänster, få transparenta offerter och hantera dina tjänster online via vår one-stop-plattform.

Logga in med din e-postadress för att:
- Se din teledata och ta del av insikter och trender för din organisation
- Budgetrapport
- Få förhandlade offerter baserade på er data och nuvarande kampanjer
- Ta del av löpande analyser och betala rätt för det ni faktiskt använder

Om du har några frågor, skicka ett [mail](mailto:help@telekomkollen.se) till oss eller [boka in ett möte](mailto:meeting@telekomkollen.se).


@component('mail::button', ['url' => route('login')])
Logga in
@endcomponent

**Lycka till**,<br>
Team {{ config('app.name') }}
@endcomponent
