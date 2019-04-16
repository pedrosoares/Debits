<?php

namespace App;

use App\Responses;

class Endpoint {

    public $domain = "";    // Domain of the Microservice
    public $uri = "";       // Request endpoint
    public $method = "";    // Request method
    public $whitelist = []; // List of IpAddress and Domains Allowed to request
    public $permission = [];// List of Permission required to request
    public $responses = null; // List of default response messages

    public function fullUrl() {
        return $this->domain . $this->uri;
    }

    /**
     * This is a trick to transform the Json Array into
     * a nice object list, you can change this to a more
     * polished way.
     *
     * @param string $json
     * @return mixed
     */
    public static function parse(string $json) {
        $stdobj = json_decode($json);  //JSON to stdClass
        $temp = serialize($stdobj);    //stdClass to serialized

        // Now we reach in and change the class of the serialized object
        $className = Endpoint::class;
        $responsesClass = Responses::class;
        $temp = str_replace('"responses";O:8:"stdClass":', '"responses";O:' . strlen($responsesClass) . ':"' . $responsesClass . '":', $temp);
        $temp = str_replace('O:8:"stdClass":', 'O:' . strlen($className) . ':"' . $className . '":', $temp);

        // Unserialize and walk away like nothing happened
        return unserialize($temp);
    }
}
