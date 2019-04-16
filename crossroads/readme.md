# Crossroads
> Do you know the way?

Gateway made in Lumen to control Microservices endpoints.

## Auth Microservice

This project uses a microservice to control the authentication and authorization.

https://github.com/pedrosoares/AuthService

## Router File

/storage/app/router.json
``` 
[
  {
    "domain": "http://localhost:8080",
    "uri": "/help",
    "method": "get",
    "permission": []
  },{
    "domain": "http://localhost:8080",
    "uri": "/home/{id}",
    "method": "post",
    "permission": [
      "home"
    ],
    "responses": {
      "400": "Invalid ID supplied",
      "404": "Resource not found",
      "405": "Validation exception"
    }
  }
]
```
