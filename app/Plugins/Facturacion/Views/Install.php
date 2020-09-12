<?php require RUTA_APP . '/Views/inc/header.php';?>
<br>
<div class="container-fluid">
	<div align="center">
		
		<div class="fa-3x">
		  <button class="btn btn-sm btn-warning"><i class="fas fa-cog fa-spin fa-4x"></i> <h2>Instalando Plugin Facturación</h2> </button>
		  <hr>
		  <h3>Por favor espere hasta que termine la instalación</h3>
        </div>
	</div>
</div>
<script type="text/javascript">
	 
	setTimeout("redireccionar()", 10000);
	function redireccionar (){
	var url = document.getElementById("ruta").value+"/Facturacion"; 
    $(location).attr('href',url);
  }
</script>
<?php require RUTA_APP . '/Views/inc/footer.php';?>