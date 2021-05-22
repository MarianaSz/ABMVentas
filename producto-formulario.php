<?php

include_once "config.php";
include_once "entidades/producto.php";
include_once "entidades/tipoproducto.php";
$pg = "Formulario Productos";

$producto = new Producto();
$producto->cargarFormulario($_REQUEST);

$tipoProducto = new TipoProducto();
$aTipoProductos = $tipoProducto->obtenerTodos();

if($_POST){
    if(isset($_POST["btnGuardar"])){
        if(isset($_GET["id"]) && $_GET["id"] > 0){
              $producto->actualizar();
        } else {
            $producto->insertar();
        }
    } else if(isset($_POST["btnBorrar"])){
        $producto->eliminar();
        header("Location: productos.php");
    }
} 

if(isset($_GET["id"]) && $_GET["id"] > 0){
    $producto->obtenerPorId(); //el cliente ya está cargado desde que se cargó el formulario
}

include_once("header.php");
?>
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Productos</h1>
            <div class="row">
                <div class="col-12 mb-3">
                    <a href="productos.php" class="btn btn-primary mr-2">Listado</a>
                    <a href="producto-formulario.php" class="btn btn-primary mr-2">Nuevo</a>
                    <button type="submit" class="btn btn-success mr-2" id="btnGuardar" name="btnGuardar">Guardar</button>
                    <button type="submit" class="btn btn-danger" id="btnBorrar" name="btnBorrar">Borrar</button>
                </div>
            </div>
            <div class="row">
                <div class="col-6 form-group">
                    <label for="txtNombre">Nombre:</label>
                    <input type="text" required class="form-control" name="txtNombre" id="txtNombre" value="<?php echo $producto->nombre ?>">
                </div>
                <div class="col-6 form-group">
                    <label for="lstTipoProducto">Tipo de producto:</label>
                    <select name="lstTipoProducto" id="lstTipoProducto" class="form-control selectpicker" data-live-search="true">
                        <option value="" disabled selected>Seleccionar</option>
                        <?php foreach($aTipoProductos as $tipo): ?>
                            <?php if($tipo->idtipoproductos == $producto->fk_idtipoproducto): ?>
                                <option selected value="<?php echo $tipo->idtipoproductos; ?>"><?php echo $tipo->nombre; ?></option>
                            <?php else: ?>
                                <option value="<?php echo $tipo->idtipoproductos; ?>"><?php echo $tipo->nombre; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-6 form-group">
                    <label for="txtCantidad">Cantidad:</label>
                    <input type="text" class="form-control" name="txtCantidad" id="txtCantidad" required value="<?php echo $producto->cantidad ?>">
                </div>
                <div class="col-6 form-group">
                    <label for="txtPrecio">Precio:</label>
                    <input type="text" class="form-control" name="txtTelefono" id="txtTelefono" value="<?php echo $producto->precio ?>">
                </div>
                <div class="col-12 form-group">
                    <label for="txtDescripcion">Descripción:</label></br>
                    <textarea type="text" name="txtDescripcion" id="txtDescripcion" width="400px"><?php echo $producto->descripcion ?></textarea>
                </div>           
            </div>
            <div class="col-6 form-group">
                <label for="fileImagen">Imagen:</label>
                <input type="file" class="form-control-file" name="imagen" id="imagen">
                <img src="" class="img-thumbnail">
            </div>
        </div>
        <!-- /.container-fluid -->
      <!-- End of Main Content -->
<!-- Javascript: librería para el editor de texto -->     
<script>
ClassicEditor
    .create( document.querySelector( '#txtDescripcion' ) )
    .catch( error => {
    console.error( error );
    } );
</script>

<?php include_once("footer.php"); ?>