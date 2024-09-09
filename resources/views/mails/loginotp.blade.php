<x-mail::message>
# Login Otp

Dear {{$name}}, use <strong>{{$otp}}</strong> as your login code


Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
