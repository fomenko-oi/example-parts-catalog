<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BaseNotification extends Mailable
{
    use Queueable, SerializesModels;

    public string $header;
    public string $body;
    public string $customSubject;
    public array $link;

    public function __construct(string $header, string $body, array $link = [], string $subject = '')
    {
        $this->header = $header;
        $this->body = $body;
        $this->link = $link;
        $this->customSubject = $subject;
    }

    public function build()
    {
        return $this->markdown('emails.admin.detail.request_created')->subject($this->customSubject);
    }
}
