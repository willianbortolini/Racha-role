<?php

namespace app\controllers;

use app\core\Controller;

class WhatswebhookController extends Controller
{

    public function index()
    {

        // === CONFIGURAÇÕES ===
        $verify_token = '2aA@93*dsL1!kjshdA'; // usado no GET para validar webhook
        $access_token = 'EAATUEkbDcR4BOZCKLZCZAWJD44ci4nZCMSWZBrLXvTuJutR4PASaxST0ZA9AZCjF41DdMnNd6G6xyuF5kPlRcwh2VLPtadxJMIdrb6TzUZCOCDZAuROMNhoPARCqzBWKVixl10h9qa8ZCahRtaKraG5IMfrOCZCAMlJ7eDL6i8QuWGNFZB5033UApvxeXoMdmuYfcZBTx04YZCJe4TraPW2hXayaVSUWKRkYKZAhyYeg3PrJw6S3eEZD';      // token de acesso da API do WhatsApp
        $phone_number_id = '1359074868556062'; // ID do número, algo tipo 123456789012345

        // === VERIFICAÇÃO DO WEBHOOK ===
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $mode = $_GET['hub_mode'] ?? '';
            $token = $_GET['hub_verify_token'] ?? '';
            $challenge = $_GET['hub_challenge'] ?? '';

            if ($mode === 'subscribe' && $token === $verify_token) {
                echo $challenge;
            } else {
                http_response_code(403);
                echo 'Forbidden';
            }
            exit;
        }

        // === TRATAMENTO DE MENSAGENS RECEBIDAS ===
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $body = file_get_contents("php://input");
            $data = json_decode($body, true);

            // Log para debug
            file_put_contents('webhook_log.txt', print_r($data, true), FILE_APPEND);

            $message = $data['entry'][0]['changes'][0]['value']['messages'][0] ?? null;

            if ($message) {
                $from = $message['from']; // número do remetente
                $reply = "Eu recebi sua mensagem! 👍";

                // === ENVIO DE RESPOSTA ===
                $url = "https://graph.facebook.com/v19.0/{$phone_number_id}/messages";
                $payload = [
                    'messaging_product' => 'whatsapp',
                    'to' => $from,
                    'type' => 'text',
                    'text' => ['body' => $reply]
                ];

                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    "Authorization: Bearer $access_token"
                ]);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $response = curl_exec($ch);

                if (curl_errno($ch)) {
                    error_log("Erro cURL: " . curl_error($ch));
                } else {
                    file_put_contents('resposta_log.txt', $response, FILE_APPEND);
                }

                curl_close($ch);
            }

            // Sempre responder 200 OK
            http_response_code(200);
            echo "EVENT_RECEIVED";
            exit;
        }
    }
}
