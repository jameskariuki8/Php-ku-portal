<?php

namespace App\Mail;

use App\Models\Grade;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GradeNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $grade;
    public $message;

    public function __construct(Grade $grade, $message = null)
    {
        $this->grade = $grade;
        $this->message = $message;
    }

    public function build()
    {
        return $this->subject('Your Grade for ' . $this->grade->unit->name)
                    ->markdown('emails.grade-notification')
                    ->attach(storage_path('app/' . $this->grade->file_path), [
                        'as' => 'grade_' . $this->grade->unit->code . '.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}