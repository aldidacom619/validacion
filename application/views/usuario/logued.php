<!--
ESTILO PARA LA VISTA LOGIN
/*autor:Wilmer Villca*/
-->
<div class="content">
		<h1>Sistema de Validación Documental - 2019 </h1>
		<div class="main ">
		   <!--vlcone-->
			<div class="alert-close"> </div>
			<div class="hotel-left">
				<div class="pay_form">
				  <?= form_open('usuarios/logued')?>
					<h2>Ingrese a su Cuenta</h2>
					  	<input  name="username" class="logo" type="text" id="exampleInputEmail1" placeholder="USUARIO" required="">
						<input name="pass" type="password" class="key" id="exampleInputPassword1" placeholder="CONTRASEÑA" required="">
						<?php echo form_submit(array('type'=>'submit','value'=>'INGRESAR','class'=>'btn btn-success btn-block'))?>
                    		  
				</div>
					 <?= form_close()?>
						<? if ($error != "")
						   {?>
							 <span  id="ocultar" class="alert alert-danger" aria-hidden="true"><?= $error?> </span>
						   <?}
						?>				
			</div>
			<!--<div class="hotel-right">
				
			</div>-->
			<div class="clear"></div>
		</div>
		
		<p class="footer">&copy;2020 Servicio Nacional de Patrimonio del Estado - SENAPE</a></p>
	</div>



 

</div>
  <!--<div class="col-md-3">
  </div>-->
</div>

<script type="text/javascript">
 var x = document.getElementById('ocultar');
 x.addEventListener('click', function () {
   x.style.display = 'none';
 });
</script>
