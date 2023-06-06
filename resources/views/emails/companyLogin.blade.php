@component('mail::message')
Geachte gebruiker van Stagespeeddate,

Er is voor u een company account aangemaakt. U kunt nu inloggen met:

<b>Email:</b> {{$data['userEmail']}}<br>
<b>Wachtwoord:</b> {{$data['password']}}

Klik op onderstaande button om direct naar de inlogpagina te gaan
@component('mail::button', ['url' => $data['url'], 'color' => 'success'])
inloggen
@endcomponent

Met vriendelijke groet,

Uw Stagespeeddate beheerder

@if(isset($data['url']))
@component('mail::subcopy')
Als u problemen ondervindt bij het klikken op de knop 'inloggen', kopieert en plakt u de onderstaande URL in uw webbrowser: <a href="{{$data['url']}}" class="break-all">{{$data['url']}}</a>
@endcomponent
@endif

@endcomponent

