@component('mail::message')
Geachte {{$data['application']->student->teacher->user->fullname()}},

De aanmelding van {{$data['application']->student->user->fullname()}} op de vacature {{$data['application']->vacancy->name}} bij {{$data['application']->vacancy->company->name}} is goedgekeurd.

{{$data['application']->vacancy->company->name}} zou graag ingesprek willen met {{$data['application']->student->user->fullname()}}.


Met vriendelijke groet,

Uw Stagespeeddate beheerder

@endcomponent

