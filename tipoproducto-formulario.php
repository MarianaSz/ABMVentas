<?php
include_once "config.php";
include_once "entidades/tipoproducto.php";
$pg = "Edición del tipo de producto";

$tipoProducto = new TipoProducto();
$tipoProducto->cargarFormulario($_REQUEST);

if($_POST){
    if(isset($_POST["btnGuardar"])){
        if(isset($_GET["id"]) && $_GET["id"]>0){
            $tipoProducto->actualizar();
        } else{
            $tipoProducto->insertar();
        }
    } else if(isset($_POST["btnBorrar"])){
        $tipoProducto->eliminar();
        header("Location: tipoproductos.php");
    }
}

if(isset($_GET["id"]) && $_GET["id"] > 0){
    $tipoProducto->obtenerPorId(); //el cliente ya está cargado desde que se cargó el formulario
}

include_once("header.php"); 
?>
       <!-- Begin Page Content -->
       <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Tipo de Producto</h1>
        <div class="row">
            <div class="col-12 mb-3">
                <a href="tipoproductos.php" class="btn btn-primary mr-2">Listado</a>
                <a href="tipoproducto-formulario.php" class="btn btn-primary mr-2">Nuevo</a>
                <button type="submit" class="btn btn-success mr-2" id="btnGuardar" name="btnGuardar">Guardar</button>
                <button type="submit" class="btn btn-danger" id="btnBorrar" name="btnBorrar">Borrar</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12 form-group">
                <label for="txtNombre">Nombre:</label>
                <input type="text" required class="form-control" name="txtNombre" id="txtNombre" value="<?php echo $tipoProducto->nombre ?>">
            </div>
        </div>
        <!-- /.container-fluid -->
        <!-- End of Main Content -->
        
<?php include_once("footer.php"); ?>