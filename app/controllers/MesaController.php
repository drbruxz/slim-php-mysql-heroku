<?php
require_once './models/Mesa.php';
require_once './interfaces/IApiUsable.php';

class MesaController extends Mesa implements IApiUsable
{

    public function TraerUno($request, $response, $args)
    {
        $codigoMesa = $args['codigoMesa'];
        $mesa = Mesa::obtenerMesa($codigoMesa);
        $payload = json_encode($mesa);
        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista =  Mesa::ListarTodo();
        $payload = json_encode(array("listaMesas" => $lista));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $codigoMesa = $parametros['codigoMesa'];
        $cantIntegrantes = $parametros['cantIntegrantes'];
        $estado = $parametros['estado'];

        // Creamos la mesa
        $mesa = new Mesa();
        $mesa->codigoMesa = $codigoMesa;
        $mesa->cantIntegrantes = $cantIntegrantes;
        $mesa->estado = $estado;
        $mesa->CrearMesa();


        $payload = json_encode(array("mensaje" => "Mesa creada con exito"));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args)
    {
        $codigoMesa = $args['codigoMesa'];
        $parametros = $request->getParsedBody();
        // echo $parametros['estado'];
        // var_dump($parametros);

        $mesaToAlter = Mesa::obtenerMesa($codigoMesa);
        $mesaToAlter->cantIntegrantes = $parametros['cantIntegrantes'];
        $mesaToAlter->estado = $parametros['estado'];
        var_dump($mesaToAlter);
        $mesaToAlter->ModificarMesa();
        $payload = json_encode(array("mensaje" => "Mesa modificada con exito"));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $codigoMesa = $args['codigoMesa'];

        Mesa::EliminarMesa($codigoMesa);

        $payload = json_encode(array("mensaje" => "Mesa borrada con exito"));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }
}
