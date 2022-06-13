<?php

use GuzzleHttp\Psr7\ServerRequest;
use Laminas\Diactoros\Response\JsonResponse;

class Logger
{
    public static function LogOperacion($request, $handler)
    {
        $requestType = $request->getMethod();
        $response = $handler->handle($request);
        $response->getBody()->write('hola muchachos, petición:' . $requestType);
        return $response;
    }

    public static function Bienvenida($request, $handler)
    {
        $requestBody = $request->getParsedBody();
        $requestType = $request->getMethod();
        switch ($requestType) {
            case 'GET':
                $response = $handler->handle($request);
                break;
            case 'POST':
                echo 'verifico credenciales' . '<br>';
                if ($requestBody['perfil'] === 'administrador') {
                    echo ('hola ' . $requestBody['usuario'] . '<br>');
                    $response = $handler->handle($request);
                    $response->getBody();
                } else {
                    $response = new JsonResponse('no tiene credenciales');
                    $response->getBody();
                }
                break;
        }
        return $response;
    }
}
