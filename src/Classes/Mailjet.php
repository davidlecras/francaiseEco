<?php

namespace App\Classes;

use Mailjet\Client;
use Mailjet\Resources;

class Mailjet
{
    private $api_main="1a7e3ce4e608f2df0f78af7a864ce381";
    private $api_secret="8fc499b4200de7d5fb8f2619d80152d9";

    public function send($to_user_email, $to_user_name, $subject, $content)
    {
        $mj= new Client($this->api_main, $this->api_secret,true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "davidlecras@hotmail.com",
                        'Name' => "La Française Écolo-mode"
                    ],
                    'To' => [
                        [
                            'Email' => $to_user_email,
                            'Name' => $to_user_name
                        ]
                    ],
                    'TemplateID' => 2277932,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'content' => $content,
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }
}