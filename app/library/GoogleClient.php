<?php

namespace app\library;

use Google\Client;
use Google\Service\Oauth2 as ServiceOauth2;
use GuzzleHttp\Client as GuzzleClient;
use Google\Service\Oauth2\Userinfo;

class GoogleClient
{
    public readonly Client $client;

    public function __construct()
    {
        $this->client = new Client;
    }

    public function init()
    {
        $guzzleClient = new GuzzleClient(['curl' => [CURLOPT_SSL_VERIFYPEER => false]]);
        $this->client->setHttpClient($guzzleClient);
        $this->client->setAuthConfig('credentials_google.json');
        $this->client->setRedirectUri('http://localhost:80/login/google');
        $this->client->addScope('email');
        $this->client->addScope('profile');
    }

    public function loginGoogle($token)
    {
        i($token);
    }
    public function generateAuthLink()
    {
        return $this->client->createAuthUrl();
    }
}