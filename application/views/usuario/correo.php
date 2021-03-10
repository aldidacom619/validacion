<div class="row">
  <div class="col-md-4">
    
  
  </div>
  <div class="col-md-4">
  <H3>Cambio de Contraseña</H3>
  <? if ($error != "")
     {?>
       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true"><?= $error?> &times;</span>
     <?} 
      

  ?>
  
</button><br>
      <?= form_open('usuarios/recuperar')?>
      <div class="form-group">
        <label for="exampleInputEmail1">Ingrese su Correo</label>
        <input  name = "email" class="form-control" id="exampleInputEmail1" placeholder="Correo">
      </div>
       <button type="submit" name = "guardar"class="btn btn-default">Enviar</button>
      <?= form_close()?>


    
  
  
  </div>

  <div class="col-md-4">
   
  </div>
</div>
