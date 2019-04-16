<?php
/**
 * Created by PhpStorm.
 * User: pedrosoares
 * Date: 10/6/18
 * Time: 4:15 PM
 */

namespace App\Services;


use App\Http\Request;
use GuzzleHttp\Client;

class RequestService {

    /**
     * @var Client
     */
    protected $client;

    public function __construct(Client $client) {
        $this->client = $client;
    }

    public function request($method, $url, $body = "", $headers = []){
        $res = $this->simpleRequest($method, $url, $body, $headers);
        $bodyContent = $res->getBody()->getContents();
        $contentType = $res->getHeader("Content-Type");
        if(count($contentType) > 0 && $contentType[0] === "application/json"){
            return json_decode($bodyContent, false);
        }
        return $bodyContent;
    }

    public function simpleRequest($method, $url, $body = "", $headers = []){
        $requestHeaders = $this->cleanHeaders($headers);
        return $this->client->request(strtoupper($method), $url, [
            "headers" => $requestHeaders,
            "body" => $body,
            'http_errors' => false
        ]);
    }

    /**
     * This functions is used to parse the request header in a way that the
     * Nginx will work properly.
     *
     * @param Request $request
     * @param string $domain
     * @param array $extraHeaders
     * @return array
     */
    public function getHeaders(Request $request, $domain = "", array $extraHeaders = []){
        $headers = $request->headers->all();
        $domain = $domain ?? $request->getRouter()->domain;
        $headers = $this->cleanHeaders($headers);
        $headers["host"] = str_replace(["http://", "https://"], "", $domain);
        $headers["content-type"] = $headers["content-type"] ?? app("config")["gateway"]["default_content_type"];

        foreach ($extraHeaders as $key => $value) {
            $headers[$key] = $value;
        }

        return $headers;
    }

    private function cleanHeaders($headers) {
        foreach ($headers as $key => $header) {
            if((is_array($header) && count($header) == 1 && $header[0] == "") || (is_string($header) && $header == "")) {
                unset($headers[$key]);
            }
        }
        return $headers;
    }

}