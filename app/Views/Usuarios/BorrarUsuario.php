<?php require(RUTA_APP.'/Views/inc/header.php');?>
                <!-- Modal -->
                 <div class="modal fade" id="mostrarmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog carde" role="document">
                        <div class="modal-content">
                           <div class="modal-header" align="center">
                              <i class="fas fa-question"></i>
                           </div>
                           <div class="modal-body" align="center">
                              <h3>Realmente desea eliminiar el usuario <b><?php echo $datos['usuario']->user_name;?></b></h3>
                           </div>
                           <div class="modal-footer">
                           	<form method="POST" action="<?php echo RUTA_URL;?>/usuarios/borrar/<?php echo $datos['usuario']->user_id;?>">
                           		<input type="hidden" name="user_id" value="<?php echo $datos['usuario']->user_id;?>">
                              <a class="btn btn-outline-warning" href="<?php echo RUTA_URL; ?>/usuarios" role="button"><i class="fas fa-times-circle"></i> Cancelar</a>
                              <button type="submit" class="btn btn-outline-danger"><i class="fas fa-trash-alt border-danger"></i> Eliminar</button>
                             </form>
                           </div>
                        </div>
                     </div>
                  </div>
                  <script> 
   $(document).ready(function()
   {
      $('#mostrarmodal').modal({backdrop: 'static', keyboard: false})
      $("#mostrarmodal").modal("show");
   
   });
</script>
<?php require(RUTA_APP.'/Views/inc/footer.php');?>