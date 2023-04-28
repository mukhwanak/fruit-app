<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailService
{
    private $mailer;
//    private $fromEmail;
//    private $toEmail;

//    public function __construct(MailerInterface $mailer, string $fromEmail, string $toEmail)
//    {
//        $this->mailer = $mailer;
//        $this->fromEmail = $fromEmail;
//        $this->toEmail = $toEmail;
//    }

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;

    }

    public function sendEmail(string $subject, string $body): void
    {
        $email = (new Email())
            ->from('info@test.com')
            ->to('mukhwanak@gmail.com')
            ->subject($subject)
            ->text($body);

        $this->mailer->send($email);
    }
}

