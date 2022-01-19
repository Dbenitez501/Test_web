<!--ventana para Update--->
<div class="modal fade" id="virtual<?php echo $idV?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="!important;">
        <h5 class="modal-title">
        <?php echo $dataV["titulo"]; ?>
        </h5>
        <button type="button" class="btn btn-danger" data-dismiss="modal">X</button>    
      </div>

        <input type="hidden" name="id" value="<?php echo $dataCliente['id']; ?>">
            <div class="modal-body" id="cont_modal">
                <div class="form-groupimg">
                <img src="img/expositor_img/<?php echo $dataV['imagen'] ?>">
                </div>
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Conferencia</label>
                  <p><?php echo $dataV["titulo"]; ?></p>
                </div>
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Tipo</label>
                  <p><?php echo "(" . $dataV["tipo"] . ")";?></p>
                </div>
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Expositor</label>
                  <p><?php echo $dataV["expositor"]; ?></p>
                </div>
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Descripción</label>
                  <p><?php echo $dataV["descripcion"]; ?></p>
                </div>
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Fecha</label>
                  <p><?php echo $dataV["fecha_inicio"]; ?></p>
                </div>
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Hora</label>
                  <p><?php echo $dataV["hora_inicio"]; ?></p>
                </div>
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Plataforma</label>
                  <p><?php echo $virtual->getPlataforma($idV);?></p>
                </div>
            </div>
            <div class="modal-footer">
              <a href="controlador_inscribirV.php?id=<?php echo $idV?>"><input type="submit" value="Inscribir" class="btn btn-success"></a>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>            
            </div>

    </div>
  </div>
</div>
<!---fin ventana Update --->