<?php

namespace App\Services;

use App\Mail\BaseMail;
use Illuminate\Support\Facades\Mail;

class MailService extends BaseService
{
    public function send(string $mail, string $view, array $attributes = [])
    {
        Mail::to($mail)->queue(new BaseMail($view, $attributes));
    }
}
