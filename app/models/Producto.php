<?php
class Producto
{
    public $nombreProducto;

    public function CrearProducto()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO productos(nombre_producto) VALUES('$this->nombreProducto'");
        $consulta->execute();
        $consulta->retornarUltimoId();
    }

    public static function obtenerProducto($idProducto)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT nombre_producto FROM productos WHERE id_producto = '$idProducto'");
        $consulta->execute();
        return $consulta->fetchObject('Producto');
    }

    public function ModificarProducto()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("UPDATE productos SET nombre_producto = '$this->nombre_producto'");
        $consulta->execute();
    }

    public function EliminarProducto($idProducto)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("UPDATE Productos set deleted_at = :fecha where id_producto = '$idProducto'");
        $consulta->bindValue(':fecha', date('Y-m-d H:i:s'));
        $consulta->execute();
    }
}
