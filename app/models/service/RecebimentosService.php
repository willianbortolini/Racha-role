<?php

namespace app\models\service;

use app\models\validacao\RecebimentosValidacao;
use app\models\dao\RecebimentosDao;
use app\util\UtilService;

class RecebimentosService
{

    public static function salvar($recebimentos, $campo, $tabela)
    {
        $validacao = RecebimentosValidacao::salvar($recebimentos);

        return Service::salvar($recebimentos, $campo, $validacao->listaErros(), $tabela);

    }

    public static function atualizaStatus($recebimentos, $campo, $tabela)
    {
            return Service::editar(objToArray($recebimentos), $campo, $tabela);

    }

    public static function aprove($body)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.mercadopago.com/v1/payments',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "description": "Payment for product",
                "installments": ' . $body->installments . ',
                "payer": {
                "email": "' . $body->payer->email . '",
                "identification": {
                    "type": "' . $body->payer->identification->type . '",
                    "number": "' . $body->payer->identification->number . '"
                }
                },
                "issuer_id": "' . $body->issuer_id . '",
                "external_reference": "' . $body->external_reference . '",
                "payment_method_id": "' . $body->payment_method_id . '",
                "token": "' . $body->token . '",
                "transaction_amount": ' . $body->transaction_amount . '
              }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'X-Idempotency-Key: 0d5020ed-1af6-469c-ae06-c3bec19954bb',
                'Authorization: Bearer ' . TOKEM_MP_TESTE,
            ),
        )
        );

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;




    }

    public static function preferences($preferences)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.mercadopago.com/checkout/preferences',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "back_urls": {
                    "success": "' . URL_BASE . 'recebimento/success",
                    "pending": "' . URL_BASE . 'recebimento/pending",
                    "failure": "' . URL_BASE . 'recebimento/failure"
                },
                "external_reference": ' . $preferences->external_reference . ',
                "notification_url": "' . URL_BASE . 'recebimento/notify",
                "auto_return": "approved",
                "items": [
                    {
                    "title": "Curso Will",
                    "description": "",
                    "category_id": "curso",
                    "quantity": 1,
                    "currency_id": "BRL",
                    "unit_price": ' . $preferences->amount . '
                    }
                ],
                "payment_methods": {
                    "excluded_payment_methods": [
                    {"id": "bolbradesco"}
                    ],
                    "excluded_payment_types": [
                    {"id": "ticket"}
                    ]
                }
                }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . TOKEM_MP_TESTE
            ),
        )
        );

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response);

    }

    public static function excluir($tabela, $campo, $id)
    {
        Service::excluir($tabela, $campo, $id);
    }
}