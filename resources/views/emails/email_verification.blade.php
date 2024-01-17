<x-mail::message>
# Email verification

<x-mail::button :url="''">
    Email verification
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
