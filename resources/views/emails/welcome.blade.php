@component('mail::message')

{{ $data['announcement'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
