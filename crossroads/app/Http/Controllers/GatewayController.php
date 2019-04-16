<?php

namespace App\Http\Controllers;

use App\Services\RequestService;
use App\Http\Request;
use Illuminate\Http\Response;

class GatewayController extends Controller {

    /**
     * @var RequestService
     */
    private $requestService;

    /**
     * @var array
     */
    private $configuration;

    public function __construct(RequestService $requestService) {
        $this->requestService = $requestService;
        $this->configuration = app('config');
    }

    public function get(Request $request) {
        return $this->handler($request, "get");
    }

    public function post(Request $request){
        return $this->handler($request, "post");
    }

    public function put(Request $request){
        return $this->handler($request, "put");
    }

    public function delete(Request $request){
        return $this->handler($request, "delete");
    }

    public function options(Request $request){
        return $this->handler($request, "options");
    }

    public function handler(Request $request, string $method){
        $url = $request->getRouter()->domain."/".$request->path();
        $body = file_get_contents('php://input');
        $headers = $this->requestService->getHeaders($request);

        $response = $this->requestService->simpleRequest($method, $url, $body, $headers);

        $httpResponse = new Response($response->getBody()->getContents(), $response->getStatusCode());

        if(!$this->configuration["gateway"]["override_header"]) {
            foreach ($response->getHeaders() as $key => $header) {
                $httpResponse->header($key, $header);
            }
        }

        $httpResponse->header("Content-Type", $response->getHeader("Content-Type") ?? $this->configuration["gateway"]["default_content_type"]);

        return $httpResponse;
    }

}
