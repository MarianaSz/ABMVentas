<?php

class TipoProducto{

    private $idtipoproductos;
    private $nombre;

    public function __construct(){
    }

    public function __get($atributo){
        return $this->$atributo;
    }
    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }

    public function insertar(){
        $mysql = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, config::BBDD_NOMBRE);
        $sql = "INSERT INTO tipo_productos (
            nombre
            ) VALUES (
                '" . $this->nombre ."'
            );";

        if (!$mysql->query($sql)) {
            printf("error en query: %s\n", $mysql->error . "" . $sql);
        }

        $this->idtipoproductos = $mysql->insert_id;
        $mysql->close();
    }

    public function actualizar()
    {
        $mysql = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, config::BBDD_NOMBRE);
        $sql = "UPDATE tipo_productos SET
                    nombre = '" . $this->nombre . "'
                    WHERE idtipoproducto = " . $this->idtipoproductos;

        if (!$mysql->query($sql)) {
            printf("error en query: %s\n", $mysql->error . "" . $sql);
        }
        $mysql->close();
    }

    public function obtenerPorId(){
        $mysql = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, config::BBDD_NOMBRE);
        $sql = "SELECT 
                idtipoproductos,
                nombre
                FROM tipo_productos 
                WHERE idtipoproductos =" . $this->idtipoproductos;
        
        if (!$resultado = $mysql->query($sql)) {
            printf("error en query:%s\n", $mysql->error . " " . $sql);
        }

        if($fila = $resultado->fetch_assoc()){
            $this->idtipoproductos = $fila["idtipoproductos"];
            $this->nombre = $fila["nombre"];
        }
        $mysql->close();
    }

    public function obtenerTodos(){
        $aTipoProductos = array();
        $mysql = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, config::BBDD_NOMBRE);
        $sql = "SELECT *
            FROM tipo_productos
            ORDER BY idtipoproductos DESC";

        $resultado = $mysql->query($sql);
        if($resultado){
            while($fila = $resultado->fetch_assoc()){
                $obj = new TipoProducto();
                $obj ->idtipoproductos = $fila["idtipoproductos"];
                $obj ->nombre = $fila["nombre"];
                $aTipoProductos[]= $obj;
            }
            return $aTipoProductos;
            $mysql->close();
        }
    }

    public function eliminar(){
        $mysql = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, config::BBDD_NOMBRE);
        $sql = "DELETE FROM tipo_productos WHERE idtipoproductos =" . $this->idtipoproductos;

        if (!$mysql->query($sql)) {
            printf("error en query:%s\n", $mysql->error . " " . $sql);
        }
        $mysql->close();
    }

    public function cargarFormulario($request){
        $this->idtipoproductos = isset($request["id"])? $request["id"] : "";
        $this->nombre = isset($request["txtNombre"])? $request["txtNombre"] : "";
    }
}
?>