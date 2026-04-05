<?php

namespace App\Mail;

use App\Models\File;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FileApprovalRequest extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public File $file
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Yêu cầu phê duyệt tệp mới: '.$this->file->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.file-approval-request',
        );
    }
}
