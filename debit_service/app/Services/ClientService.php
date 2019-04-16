<?php

namespace App\Services;

use GuzzleHttp\Client;

class ClientService {

    /**
     * @var Client
     */
    protected $client;

    /**
     * Microservice Endpoint
     */
    private $endpoint = "http://nginx/api/users";

    public function __construct(Client $client) {
        $this->client = $client;
    }

    public function findClient(int $id){
        $response = $this->client->request("GET", "{$this->endpoint}/{$id}", [
            "headers" => [
                "Content-Type" => "application/json"
            ],
            "http_errors" => false
        ]);
        if($response->getStatusCode() >= 200 && $response->getStatusCode() <= 299) {
            $responseBody = $response->getBody()->getContents();
            return json_decode($responseBody, false);
        }
        return null;
    }

}
