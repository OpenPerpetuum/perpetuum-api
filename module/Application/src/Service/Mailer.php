<?php

namespace Application\Service;

use Application\Entity\Token\EmailConfirmation as EmailConfirmationToken;

class Mailer
{
    private $sparkPost;

    public function __construct($sparkPost)
    {
        $this->sparkPost = $sparkPost;
    }

    public function sendActivationMail(EmailConfirmationToken $token)
    {
        return $this->sparkPost->transmissions->post([
            'content' => [
                'from' => [
                    'name' => 'Open Perpetuum Team',
                    'email' => 'no-reply@mail.openperpetuum.com',
                ],
                'subject' => 'Activate your Open Perpetuum account',
                'html' => '<html><body><p>Hi there!</p><p>You have recently registered an account to Open Perpetuum at this email address.</p><p>Please <a href="http://register.openperpetuum.com/verify/{{token}}">click here</a> to verify your email address, or copy and paste the following link in your browser:</p><p>http://register.openperpetuum.com/verify/{{token}}</p><p>Welcome to Perpetuum, Agent!</p></body></html>',
            ],
            'substitution_data' => [
                'token' => $token->getHash(),
            ],
            'recipients' => [
                [
                    'address' => [
                        // 'name' => '',
                        'email' => $token->getAccount()->getEmail(),
                    ],
                ],
            ],
        ]);
    }
}
