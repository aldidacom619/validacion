

<H3><?= $title?></H3>
<h4>USUARIO: <?= devol_persona($id)?></h4>
<div class="row">
  <div class="col-md-4">
   		
  
      <div class="errors"><?= $error ?></div>
		<br>
      <?=form_open("usuarios/cambiar_contra/$id")?>
    
      
      <div class="form-group">
        		<label for="exampleInputEmail1">Nueva Contraseña</label>
       			 <input name ="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="">               
        
      </div>
      <div class="form-group">
        		<label for="exampleInputEmail1">Confirmar Contraseña</label>
       			 <input name ="repassword" type="password" class="form-control" id="exampleInputPassword1" placeholder="">               
        
      </div>

         <button type="submit" name = "guardar"class="btn btn-default">ACEPTAR</button>
      <?= form_close()?>
  
  </div>

  <div class="col-md-4">
   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true"> <?php echo validation_errors('<div class="errors">','</div>'); ?> &times;</span>
  
</button><br> 
  </div>
</div>