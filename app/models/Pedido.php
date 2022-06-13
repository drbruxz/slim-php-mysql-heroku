<?php

use Psr7Middlewares\Middleware\AccessLog;

class Pedido
{

    public $codigoPedido;
    public $codigoMesa;
    public $destino;
    public $estado;
    public $tiempoEstFinalizacion;
    public $fechaCreacion;
    public $pedidos;
    public $fechaEntrega;


    public static function ListarTodo()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT codigo_pedido, codigo_mesa, destino, estado, tiempo_est_finalizacion, fecha_creacion, pedidos, fecha_entrega FROM pedidos");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
    }


    public function CrearPedido()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO pedidos(codigo_pedido, codigo_mesa, destino, estado, tiempo_est_finalizacion, fecha_creacion, pedidos, fecha_entrega) VALUES(:codigoPedido, :codigoMesa, :destino, :estado, :tiempoEstFinalizacion, :fechaCreacion, :pedidos, :fechaEntrega)");
        $consulta->bindValue(':codigoPedido', $this->codigoMesa);
        $consulta->bindValue(':codigoMesa', $this->codigoMesa);
        $consulta->bindValue(':destino', $this->destino);
        $consulta->bindValue(':estado', $this->estado);
        $consulta->bindValue(':tiempoEstFinalizacion', $this->tiempoEstFinalizacion);
        $consulta->bindValue(':fechaCreacion', $this->fechaCreacion);
        $consulta->bindValue(':pedidos', $this->pedidos);
        $consulta->bindValue(':fechaEntrega', $this->fechaEntrega);
        $consulta->execute();
        $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerPedido($codigoPedido)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT codigo_pedido, codigo_mesa, destino, estado, tiempo_est_finalizacion, fecha_creacion, pedidos, fecha_entrega FROM pedidos WHERE codigo_pedido = '$codigoPedido'");
        $consulta->execute();
        return $consulta->fetchObject('Pedido');
    }

    public function ModificarPedido()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("UPDATE pedidos SET codigo_pedido = '$this->codigoPedido', codigo_mesa = '$this->codigoMesa', destino = '$this->destino', estado = '$this->estado', tiempo_est_finalizacion = '$this->tiempoEstFinalizacion', fecha_creacion = $this->fechaCreacion, pedidos = '$this->pedidos', fecha_ntrega = '$this->fechaEntrega' where codigo_pedido = '$this->codigoPedido' ");
        $consulta->execute();
    }

    public function EliminarPedido()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("UPDATE pedidos set deleted_at = :fecha where codigo_pedido = '$this->codigoPedido'");
        $consulta->bindValue(':fecha', date('Y-m-d H:i:s'));
        $consulta->execute();
    }
}
