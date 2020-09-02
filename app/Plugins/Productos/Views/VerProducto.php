<?php require RUTA_APP . '/Views/inc/header.php'; ?>

<?php 
echo "<pre>";
print_r($datos['producto']);
echo "</pre>";
?>
<form>
    <input type="text" name="NombreProducto" value="<?php echo $datos['producto']->NombreProducto?>">
</form>
<?php require RUTA_APP . '/Views/inc/footer.php'; ?>