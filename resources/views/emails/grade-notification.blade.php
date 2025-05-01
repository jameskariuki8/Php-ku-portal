

{{-- resources/views/emails/grade-notification.blade.php --}}
@component('mail::message')
# Grade Notification for {{ $grade->unit->title }}

Hello {{ $grade->student->name }},

Your grade for **{{ $grade->unit->title }}** has been recorded:

- CAT Marks: {{ $grade->cat_marks ?? 'N/A' }}
- Exam Marks: {{ $grade->exam_marks ?? 'N/A' }}
- Final Grade: **{{ $grade->grade }}**

@if($message)
**Teacher's Note:**  
{{ $message }}
@endif

@component('mail::button', ['url' => route('student.grades.view')])
View All Grades
@endcomponent

Thanks,  
{{ config('app.name') }} Team
@endcomponent
