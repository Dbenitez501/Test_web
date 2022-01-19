<!--ventana para mostrar modal tarjeta presencial--->
<div class="modal fade" id="presencial<?php echo $idP?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="!important;">
        <h5 class="modal-title">
        <?php echo $dataP["titulo"]; ?>
        </h5>
        
        <button type="button" class="btn btn-danger" data-dismiss="modal">X</button>          
      </div>

        <input type="hidden" name="id" value="<?php echo $dataCliente['id']; ?>">
            <div class="modal-body" id="cont_modal">
                <div class="form-groupimg">
                  <img src="img/expositor_img/<?php echo $dataP['imagen'] ?>">
                </div>
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Conferencia:</label>
                  <p><?php echo $dataP["titulo"]; ?></p>
                </div>
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Tipo:</label>
                  <p><?php echo "(" . $dataP["tipo"] . ")";?></p>
                </div>
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Expositor:</label>
                  <p><?php echo $dataP["expositor"]; ?></p>
                </div>
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Descripción:</label>
                  <p><?php echo $dataP["descripcion"]; ?></p>
                </div>
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Fecha:</label>
                  <p><?php echo $dataP["fecha_inicio"]; ?></p>
                </div>
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Hora:</label>
                  <p><?php echo $dataP["hora_inicio"]; ?></p>
                </div>
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Lugar:</label>
                  <p><?php echo $presencial->getNombreLugarTabla($idP) . ", " .  $presencial->getUbicacionTabla($idP);?></p>
                </div>
                
            </div>
            <div class="modal-footer">
                <a href="controlador_inscribirP.php?id=<?php echo $idP?>"><input type="submit" value="Inscribir" class="btn btn-success"></a>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>            
            </div>

    </div>
  </div>
</div>
<!---fin ventana modal --->