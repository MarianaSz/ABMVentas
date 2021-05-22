<?php

class Producto{
    //los mismos campos que las columnas de la tabla de la BD
    private $idproducto;
    private $nombre;
    private $cantidad;
    private $precio;
    private $descripcion;
    private $imagen;
    private $fk_idtipoproducto;

    public function __construct(){
    }
    public function __get($atributo){
        return $this->$atributo;
    }
    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }

    public function obtenerPorId(){
        $mysql = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "SELECT 
            idproducto,
            nombre,
            cantidad,
            precio,
            descripcion,
            imagen,
            fk_idtipoproducto
            FROM productos
            WHERE idproducto=" . $this->idproducto;
        
        if (!$resultado = $mysql->query($sql)) {
            printf("error en query:%s\n", $mysql->error . " " . $sql);
        }

        if($fila = $resultado->fetch_assoc() ){
            $this->idproducto = $fila["idproducto"];
            $this->nombre= $fila["nombre"];
            $this->cantidad = $fila["cantidad"];
            $this->precio= $fila["precio"];
            $this->descripcion= $fila["descripcion"];
            $this->imagen= $fila["imagen"];
            $this->fk_idtipoproducto= $fila["fk_idtipoproducto"];
        }
        $mysql->close();
    }

    public function obtenerTodos(){
        $aProductos = array();
        $mysql = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "SELECT * FROM productos
                ORDER BY idproducto DESC";

        $resultado = $mysql->query($sql);
        if($resultado){
            while($fila=$resultado->fetch_assoc()){
                $obj = new Producto();
                $obj ->idproducto = $fila["idproducto"];
                $obj ->nombre = $fila["nombre"];
                $obj ->cantidad= $fila["cantidad"];
                $obj ->precio = $fila["precio"];
                $obj ->descripcion = $fila["descripcion"];
                $obj ->imagen = $fila["imagen"];
                $obj ->fk_idtipoproducto = $fila["fk_idtipoproducto"];
                $aProductos[] = $obj;
            }
        }
        $mysql->close();
        return $aProductos;
    }
    
    public function insertar(){
        $mysql = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "INSERT INTO productos(
            nombre, 
            cantidad,
            precio,
            descripcion,
            imagen,
            fk_idtipoproducto
            ) VALUE (
            '" . $this->nombre . "',
            '" . $this->cantidad . "',
            '" . $this->precio . "',
            '" . $this->descripcion . "',
            '" . $this->imagen . "',
            '" . $this->fk_idtiproducto . "'
            );";

        if(!$mysql->query($sql)){
            printf("Error en la query:%s\n", $mysql->error . " " . $sql);
        }

        $this->idproducto = $mysql->insert_id;
        $mysql->close();
    }

    public function actualizar(){
        $mysql = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "UPDATE productos SET
                nombre = '" . $this->nombre . "',
                cantidad = '" . $this->cantidad . "',
                precio = '" . $this->precio . "',
                descripcion = '" . $this->descripcion . "',
                fk_idtipoproducto ='" .$this->fk_idtipoproducto. "'
                WHERE idproducto =" . $this->idproducto;
        
        if(!$mysql->query($sql)){
            printf("Error en la query:%s\n", $mysql->error . " " . $sql);
        }
        $mysql->close();
    }

    public function eliminar(){
        $mysql = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "DELETE FROM productos WHERE idproducto =" . $this->idproducto;
        if(!$mysql->query($sql)){
            printf("Error en la query:%s\n", $mysql->error . " " . $sql);
        }
        $mysql->close();
    }

    public function cargarFormulario($request){
        $this->idproducto = isset($request["id"])? $request["id"] : "";
        $this->nombre = isset($request["txtNombre"])? $request["txtNombre"] : "";
        $this->precio = isset($request["txtPrecio"])? $request["txtPrecio"] : "";
        $this->cantidad = isset($request["txtCantidad"])? $request["txtCantidad"]: "";
        $this->descripcion = isset($request["txtDescripcion"])? $request["txtDescripcion"]: "";
        $this->fk_idtipoproducto = isset($request["lstTipoProducto"])? $request["lstTipoProducto"] : "";
    }
}
?>