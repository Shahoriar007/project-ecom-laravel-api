@component('mail::message')
# New Requisition: `#{{$requisition->rq_number}}`

Dear Concern,

A new requisition has created by `{{$user->name}}`, please take a look. To view the requisition, click the below button.

@component('mail::button', ['url' => $url])
View Requisition
@endcomponent

Thank you
@endcomponent
