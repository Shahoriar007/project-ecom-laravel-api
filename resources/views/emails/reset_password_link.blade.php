<x-mail::message>
# Reset password



<x-mail::button :url="$url">
Reset password
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
