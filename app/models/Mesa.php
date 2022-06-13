<?php

class Mesa
{

    public $codigoMesa;
    public $cantIntegrantes;
    public $estado;


    public static function ListarTodo()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT codigo_mesa, cant_integrantes, estado FROM mesas");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Mesa');
    }

    public function CrearMesa()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO mesas(codigo_mesa, cant_integrantes, estado) VALUES('$this->codigoMesa', '$this->cantIntegrantes', '$this->estado')");

        $consulta->execute();

        $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerMesa($codigoMesa)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT codigo_mesa, cant_integrantes, estado FROM mesas WHERE codigo_mesa = '$codigoMesa'");
        $consulta->execute();
        return $consulta->fetchObject('Mesa');
    }

    public function ModificarMesa()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        echo 'estado:' . $this->estado;
        $consulta = $objAccesoDatos->prepararConsulta("UPDATE mesas SET cant_integrantes = '$this->cantIntegrantes', estado = '$this->estado' where codigo_mesa = '$this->codigo_mesa' ");
        $consulta->execute();
    }

    public static function EliminarMesa($codigoMesa)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("UPDATE mesas set deleted_at = :fecha where codigo_mesa = '$codigoMesa'");
        $consulta->bindValue(':fecha', date('Y-m-d H:i:s'));
        $consulta->execute();
    }
}
