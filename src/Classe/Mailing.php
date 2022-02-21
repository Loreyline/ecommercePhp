<?php

namespace App\Classe;

use Mailjet\Resources;

// use Mailjet\Client;



class Mailing
{
    private $apiKey = "a7d5d37ed8fa03c6281ba2e1dd026f4b";

    private $secreteKey = "eb9768ae1e2000194e8700d3c8a535fd";

    public function envois($emailDest, $nameDest, $sujet, $emailContent)
    {
        $mj = new \Mailjet\Client($this->apiKey, $this->secreteKey, true, ['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "karinemr@laposte.net",
                        'Name' => "Admin"
                    ],
                    'To' => [
                        [
                            'Email' => $emailDest,
                            'Name' => $nameDest
                        ]
                    ],
                    'TemplateID' => 3641487,
                    'TemplateLanguage' => true,
                    'Subject' => $sujet,
                    'Variables' => [
                        'emailContent' => $emailContent
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() && var_dump($response->getData());
    }
}
