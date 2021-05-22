<?php

include_once "config.php";
include_once "entidades/venta.php";
include_once "entidades/producto.php";
include_once "entidades/cliente.php";
$pg = "Nueva Venta";

$venta = new Venta();
$venta->cargarFormulario($_REQUEST);

$producto = new Producto();
$aProductos = $producto->obtenerTodos();

$cliente = new Cliente();
$aClientes = $cliente->obtenerTodos();

if($_POST){
    if(isset($_POST["btnGuardar"])){
        if(isset($_GET["id"]) && $_GET["id"] > 0){
              $venta->actualizar();
        } else {
            $venta->insertar();
        }
    } else if(isset($_POST["btnBorrar"])){
        $venta->eliminar();
        header("Location: ventas.php");
    }
} 

if(isset($_GET["id"]) && $_GET["id"] > 0){
    $venta->obtenerPorId();
}

include_once("header.php");
?>
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Ventas</h1>
            <div class="row">
                <div class="col-12 mb-3">
                    <a href="ventas.php" class="btn btn-primary mr-2">Listado</a>
                    <a href="venta-formulario.php" class="btn btn-primary mr-2">Nuevo</a>
                    <button type="submit" class="btn btn-success mr-2" id="btnGuardar" name="btnGuardar">Guardar</button>
                    <button type="submit" class="btn btn-danger" id="btnBorrar" name="btnBorrar">Borrar</button>
                </div>
            </div>
            <div class="row">
            <div class="col-12 form-group">
                    <label for="txtFecha" class="d-block">Fecha:</label>
                    <select class="form-control d-inline"  name="txtDia" id="txtDia" style="width: 80px">
                        <option selected="" disabled="">DD</option>
                        <?php for($i=1; $i <= 31; $i++): ?>
                            <?php if($venta->fecha != "" && $i == date_format(date_create($venta->fecha), "d")): ?>
                            <option selected><?php echo $i; ?></option>
                            <?php else: ?>
                            <option><?php echo $i; ?></option>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </select>
                    <select class="form-control d-inline"  name="txtMes" id="txtMes" style="width: 80px">
                        <option selected="" disabled="">MM</option>
                        <?php for($i=1; $i <= 12; $i++): ?>
                            <?php if($venta->fecha != "" && $i == date_format(date_create($venta->fecha), "m")): ?>
                            <option selected><?php echo $i; ?></option>
                            <?php else: ?>
                            <option><?php echo $i; ?></option>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </select>
                    <select class="form-control d-inline"  name="txtAnio" id="txtAnio" style="width: 100px">
                        <option selected="" disabled="">YYYY</option>
                        <?php for($i=1900; $i <= date("Y"); $i++): ?>
                         <?php if($venta->fecha != "" && $i == date_format(date_create($venta->fecha), "Y")): ?>
                            <option selected><?php echo $i; ?></option>
                            <?php else: ?>
                            <option><?php echo $i; ?></option>
                            <?php endif; ?>
                        <?php endfor; ?> ?>
                    </select>
                    <input type="time" required="" class="form-control d-inline" style="width: 120px" name="txtHora" id="txtHora" value="00:00">
                </div>
                <div class="col-6 form-group">
                    <label for="lstCliente">Cliente:</label>
                    <select name="lstCliente" id="lstCliente" class="form-control selectpicker" data-live-search="true">
                        <option value="" disabled selected>Seleccionar</option>
                        <?php foreach($aClientes as $client): ?>
                            <?php if($client->idclientes == $venta->fk_idcliente): ?>
                                <option selected value="<?php echo $client->idclientes; ?>"><?php echo $client->nombre; ?></option>
                            <?php else: ?>
                                <option value="<?php echo $client->idclientes; ?>"><?php echo $client->nombre; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                 </div>
                <div class="col-6 form-group">
                    <label for="lstProducto">Producto:</label>
                    <select name="lstProducto" id="lstProducto" class="form-control selectpicker" data-live-search="true">
                        <option value="" disabled selected>Seleccionar</option>
                        <?php foreach($aProductos as $prod): ?>
                            <?php if($prod->idproducto == $venta->fk_idproducto): ?>
                                <option selected value="<?php echo $prod->idproducto; ?>"><?php echo $prod->nombre; ?></option>
                            <?php else: ?>
                                <option value="<?php echo $prod->idproducto; ?>"><?php echo $prod->nombre; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-6 form-group">
                    <label for="txtPrecioUnitario" >Precio unitario:</label>
                    <input type="text" class="form-control" name="txtPrecioUnitario" id="txtPrecioUnitario" required disabled value="<?php echo $producto->cantidad ?>">
                </div>
                <div class="col-6 form-group">
                    <label for="txtCantidad">Cantidad:</label>
                    <input type="text" class="form-control" name="txtCantidad" id="txtCantidad" value="<?php echo $venta->cantidad ?>">
                </div>
                <div class="col-6 form-group">
                    <label for="txtTotal">Total:</label></br>
                    <input type="text" class="form-control" name="txtTotal" id="txtTotal" value="<?php echo $venta->total ?>">
                </div>           
            </div>
        </div>
        <!-- /.container-fluid -->
      <!-- End of Main Content -->

<?php include_once("footer.php"); ?>