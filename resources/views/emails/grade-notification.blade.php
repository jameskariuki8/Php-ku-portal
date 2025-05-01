@component('mail::message')
# Grade Notification

Dear {{ $grade->student->name }},

Your grade for the unit **{{ $grade->unit->name }}** ({{ $grade->unit->code }}) has been uploaded by your teacher.

@if($message)
**Message from your teacher:**  
{{ $message }}
@endif

You can view this grade in your student dashboard or download the attached PDF file.

@component('mail::button', ['url' => url('/student/dashboard')])
View in Dashboard
@endcomponent

Thanks,  
{{ config('app.name') }} Team
@endcomponent