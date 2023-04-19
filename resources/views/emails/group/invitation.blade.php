<x-mail::message>
# Invitation

Hallo {{$data->user_name}}, you have been invited by {{$data->sender}} to join {{$data->group_name}}

<x-mail::button :url="''">
JOIN
</x-mail::button>

Thanks,<br>
COMUNEETAS
</x-mail::message>
