<?php

class Venta{
    private $idventa;
    private $fecha;
    private $cantidad;
    private $preciounitario;
    private $fk_idcliente;
    private $fk_idproducto;
    private $total;

    public function __construct(){
    }
    public function __get($atributo){
        return $this->$atributo;
    }
    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }

    public function insertar(){
        $mysql = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "INSERT INTO ventas(
            fecha,
            cantidad,
            preciounitario,
            total,
            fk_idcliente,
            fk_idproducto
            ) VALUES (
            '" . $this->fecha . "',
            '" . $this->cantidad . "',
            '" . $this->preciounitario . "',
            '" . $this->fk_idcliente . "',
            '" . $this->fk_idproducto . "',
            '" . $this->total . "'
            );";

        if(!$mysql->query($sql)){
            printf("Error en la query:%s\n", $mysql->error . " " . $sql);
        }
         //Obtiene el id generado por la inserción
        $this->idventa = $mysql->insert_id;
        $mysql->close();
    }

    public function actualizar(){
        $mysql = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "UPDATE ventas SET
                    fecha = '" . $this->fecha . "',
                    cantidad = '" . $this->cantidad . "',
                    preciounitario = '" . $this->preciounitario . "',
                    total = '" . $this->total . "',
                    fk_idcliente = '" . $this->fk_idcliente . "',
                    fk_idproducto = '" . $this->fk_idproducto . "'
                    WHERE idventa = " . $this->idventa;

        if(!$mysql->query($sql)){
            printf("Error en la query:%s\n", $mysql->error . " " . $sql);
        }
        $mysql->close();
    }

    public function obtenerPorId(){
        $mysql = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "SELECT
            idventa,
            fecha,
            cantidad,
            preciounitario,
            total,
            fk_idcliente,
            fk_idproducto
            FROM ventas
            WHERE idventa =" .$this->idventa;
        
        if (!$resultado = $mysql->query($sql)) {
            printf("error en query:%s\n", $mysql->error . " " . $sql);
        }

        if($fila = $resultado->fetch_assoc() ){
            $this->idventa= $fila["idventa"];
            $this->cantidad= $fila["cantidad"];
            $this->preciounitario = $fila["preciounitario"];
            $this->total= $fila["total"];
            $this->fk_idcliente= $fila["fk_idcliente"];
            $this->fk_idproducto= $fila["fk_idproducto"];
        }
        $mysql->close();
    }

    public function obtenerTodos(){
        $aVentas = array();
        $mysql = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "SELECT 
            idventa,
            fecha,
            cantidad,
            preciounitario,
            fk_idcliente,
            fk_idproducto,
            total
            FROM ventas
            ORDER BY idventa DESC";

        $resultado = $mysql->query($sql);
        if($resultado){
            while($fila = $resultado->fetch_assoc()){
                $obj= new Venta();
                $obj->idventa = $fila["idventa"];
                $obj->fecha = $fila["fecha"];
                $obj->cantidad = $fila["cantidad"];
                $obj->preciounitario = $fila["preciounitario"];
                $obj->total = $fila["total"];
                $obj->fk_idcliente = $fila["fk_idcliente"];
                $obj->fk_idproducto = $fila["fk_idproducto"];
                $aVentas[] = $obj;
            }
        }
        $mysql->close();
        return $aVentas;    
    }

    public function eliminar(){
        $mysql = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "DELETE FROM ventas WHERE idventa = " . $this->idventa;
        if(!$mysql->query($sql)){
            printf("Error en la query:%s\n", $mysql->error . " " . $sql);
        }
        $mysql->close();
    }

    public function cargarFormulario($request){
        $this->idventa = isset($request["id"])? $request["id"] : "";
        $this->fecha = isset($request["txtNombre"])? $request["txtNombre"] : "";
        $this->preciounitario = isset($request["txtPrecioUnitario"])? $request["txtPrecioUnitario"] : "";
        $this->cantidad = isset($request["txtCantidad"])? $request["txtCantidad"]: "";
        $this->total = isset($request["txtTotal"])? $request["txtTotal"] : "";
        $this->fk_idcliente = isset($request["txtFkCliente"])? $request["txtFkCliente"]: "";
        $this->fk_idproducto = isset($request["txtProducto"])? $request["txtProducto"] : "";
        if(isset($request["txtAnio"]) && isset($request["txtMes"]) && isset($request["txtDia"]) && isset($request["txtHora"])){
            $this->fecha = $request["txtAnio"] . "-" .  $request["txtMes"] . "-" .  $request["txtDia"] . "-" . $request["txtHora"];
        }
    }

    public function obtenerFacturacionMensual($mes){
        $mysql = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "SELECT 
                SUM(total) AS total
                FROM ventas 
                WHERE MONTH(fecha)=" . $mes;
        $resultado = $mysql->query($sql);
        $mysql->close();
        if(!$resultado){
            printf("Error en la query:%s\n", $mysql->error . " " . $sql);
        }
        else{
            $fila = $resultado->fetch_assoc();
            return $fila["total"];
        }
    }

    public function obtenerFacturacionAnual($anio){
        $mysql = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "SELECT 
                SUM(total) AS total
                FROM ventas 
                WHERE YEAR(fecha)=" . $anio;
        $resultado = $mysql->query($sql);
        $mysql->close();
        if(!$resultado){
            printf("Error en la query:%s\n", $mysql->error . " " . $sql);
        }
        else{
            $fila = $resultado->fetch_assoc();
            return $fila["total"];
        }
    }

    public function obtenerTotal(){

    }
}
?>
