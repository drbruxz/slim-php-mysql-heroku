<?php
require_once './models/Pedido.php';
require_once './interfaces/IApiUsable.php';

class PedidoController extends Pedido implements IApiUsable
{

    public function TraerUno($request, $response, $args)
    {
        $codigoPedido = $args['codigoPedido'];
        $pedido = Pedido::obtenerPedido($codigoPedido);
        $payload = json_encode($pedido);
        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista =  Pedido::ListarTodo();
        $payload = json_encode(array("listaPedidos" => $lista));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function CargarUno($request, $response, $args)
    {

        $parametros = $request->getParsedBody();

        $codigoPedido = $parametros['codigoPedido'];
        $codigoMesa = $parametros['codigoMesa'];
        $destino = $parametros['destino'];
        $estado = $parametros['estado'];
        // $tiempoEstFinalizacion = $parametros['tiempoEstFinalizacion'];
        $pedidos = $parametros['pedidos'];
        // $fechaEntrega = $parametros['fechaEntrega'];

        // Creamos la Pedido
        $pedido = new Pedido();
        $pedido->codigoPedido = $codigoPedido;
        $pedido->codigoMesa = $codigoMesa;
        $pedido->destino = $destino;
        $pedido->estado = $estado;
        $pedido->tiempoEstFinalizacion = time();
        $pedido->fechaCreacion = date('Y-m-d H:i:s');
        $pedido->pedidos = $pedidos;
        $pedido->fechaEntrega = date('Y-m-d H:i:s');
        $pedido->CrearPedido();


        $payload = json_encode(array("mensaje" => "Pedido creado con exito"));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args)
    {
        $codigoPedido = $args['codigoPedido'];
        $parametros = $request->getParsedBody();
        /* public $codigoPedido;
    public $codigoMesa;
    public $destino;
    public $estado;
    public $tiempoEstFinalizacion;
    public $fechaCreacion;
    public $pedidos;
    public $fechaEntrega; */

        $pedidoToAlter = Pedido::obtenerPedido($codigoPedido);
        $pedidoToAlter->codigoMesa = $parametros['codigoMesa'];
        $pedidoToAlter->destino = $parametros['destino'];
        $pedidoToAlter->estado = $parametros['estado'];
        $pedidoToAlter->tiempoEstFinalizacion = $parametros['tiempoEstFinalizacion'];
        $pedidoToAlter->fechaCreacion = $parametros['fechaCreacion'];
        $pedidoToAlter->pedidos = $parametros['pedidos'];
        $pedidoToAlter->fechaEntrega = $parametros['fechaEntrega'];
        $pedidoToAlter->ModificarPedido();
        $payload = json_encode(array("mensaje" => "Pedido modificado con exito"));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $codigoPedido = $args['codigoPedido'];

        Pedido::EliminarPedido($codigoPedido);

        $payload = json_encode(array("mensaje" => "Pedido borrado con exito"));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }
}
