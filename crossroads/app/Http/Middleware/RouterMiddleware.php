<?php

namespace App\Http\Middleware;

use App\Services\GatewayService;
use App\Services\RequestService;
use Closure;
use App\Http\Request;

class RouterMiddleware {

    /**
     * @var RequestService
     */
    private $requestService;

    public function __construct(RequestService $requestService) {
        $this->requestService = $requestService;
    }

    /**
     * Handle an incoming request and Validate Authorization
     *
     * @param  \App\Http\Request $request
     * @param  \Closure $next
     * @param  int $id
     * @return mixed
     */
    public function handle(Request $request, Closure $next, int $id) {
        $route = routes($id);

        $request->addRouter($route);

        if(isset($route->whitelist) && count($route->whitelist) > 0) {
            if(!in_array($request->getClientIp(), $route->whitelist)){
                return response('Unauthorized.', 401);
            }
        }

        if(isset($route->permission) && count($route->permission) > 0) {
            $authRouter = GatewayService::findRoute(
                app("config")["gateway"]["permission_endpoint"]
            );
            $body = [
                "permissions" => $route->permission
            ];
            $headers = $this->requestService->getHeaders($request, $authRouter->domain, [
                "content-type" => "text/json"
            ]);
            $response = $this->requestService
                ->request("POST", $authRouter->fullUrl(), json_encode($body), $headers);
            if(!(is_object($response) && $response->message === "Authorized")){
                return response('Unauthorized.', 401);
            }
        }

        $response = $next($request);

        if(isset($route->responses) && count($route->responses) > 0) {
            foreach($route->responses as $key => $value){
                if($response->getStatusCode() == $key){
                    return response($value, $key);
                }
            }
        }

        return $response;
    }

}
