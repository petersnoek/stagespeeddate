{{--  --}}
<div class="bg-body-light">
<div>Geachte gebruiker van StageSpeeddate,</div>

Er is voor u een company account aangemaakt. U kunt nu inloggen met:

<b>Email:</b> {{$data['userEmail']}}<br>
<b>Wachtwoord:</b> {{$data['password']}}

{{-- Klik op onderstaande knop om direct naar de inlogpagina te gaan --}}
{{-- @component('mail::button', ['url' => $data['url'], 'color' => 'success'])
inloggen
@endcomponent --}}

Met vriendelijke groet,

Uw StageSpeeddate beheerder

{{-- @if(isset($data['url']))
@component('mail::subcopy')
Als u problemen ondervindt bij het klikken op de knop 'inloggen', kopieert en plakt u de onderstaande URL in uw webbrowser: <a href="{{$mailInfo['url']}}" class="break-all">{{$mailInfo['url']}}</a>
@endcomponent
@endif --}}

{{-- @endcomponent --}}
</div>


