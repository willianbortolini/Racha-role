<?php

namespace app\models\service;

use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Auth\HttpHandler\HttpHandlerFactory;

class PushService
{
    public static function push($to, $titulo, $conteudo)
    {
        // Carregar as credenciais do serviço
        $credential = new ServiceAccountCredentials(
            "https://www.googleapis.com/auth/firebase.messaging",
            json_decode(SERVICE_ACCOUNT_KEY, true)
        );

        // Obter o token de autenticação
        $token = $credential->fetchAuthToken(HttpHandlerFactory::build());

        if (!isset($token['access_token'])) {
            echo 'Erro ao obter o token de autenticação';
            return;
        }

        $url = "https://fcm.googleapis.com/v1/projects/racha-role/messages:send";

        $data = [
            "message" => [
                "token" => $to,
                "notification" => [
                    "title" => $titulo,
                    "body" => $conteudo,
                    "image" => URL_BASE . "logoApp.png"
                ],
                "webpush" => [
                    "fcm_options" => [
                        "link" => "https://racharole.site"
                    ]
                ]
            ]
        ];
        
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token['access_token']
        ]);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if ($response === false) {
            echo 'Erro cURL: ' . curl_error($ch);
        } else {
            echo 'Resposta da API: ' . $response;
        }

        curl_close($ch);
    }
}