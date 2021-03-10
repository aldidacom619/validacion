

		</div>
	</div>
</div>

<footer>
		
		<script src="<?php echo  base_url() ?>tables/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="<?php echo  base_url() ?>tables/bower_components/bootstrap/dist/js/bootstrap-multiselect.js"></script>
		<script src="<?php echo  base_url() ?>tables/bower_components/bootstrap/dist/js/datepicker.min.js"></script>
		<script src="<?php echo  base_url() ?>tables/bower_components/bootstrap/dist/js/datepicker.es.min.js"></script>
		<script src="<?php echo  base_url() ?>tables/bower_components/metisMenu/dist/metisMenu.min.js"></script>
		<script src="<?php echo  base_url() ?>tables/dist/js/sb-admin-2.js"></script>
		<script src="<?php echo  base_url() ?>tables/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo  base_url() ?>tables/bower_components/datatables/media/js/jquery.dataTables.js"></script>
		<script src="<?php echo  base_url() ?>tables/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
		<script src="<?php echo  base_url() ?>tables/bower_components/datatables-responsive/js/dataTables.responsive.js"></script>
	</footer>
</body>
	 <script type="text/javascript">
         $(document).ready(function() {
			console.log('PIE php');
			// paginacion
			$('#dataTables-example').DataTable({
				"stateSave": true,
	            "language": {
	                "zeroRecords": "Sin datos encontrados",
	                "sEmptyTable": "No se encontraron registros",
	                "infoEmpty": "Sin datos disponibles",
	                "infoFiltered": "(filtrados de _MAX_ registros)"
	            }
			});

			
			/*script para manupilacion navegacion de los imputs*/
	        $(':input').on('keydown', function(e) {
	            if (e.keyCode == 9) {
	                var pos = $(this).attr("position");
	                if(pos)
	                {
		                e.preventDefault();
		                next = ++pos;
		                if($(":input[position="+next+"]").is(":visible"))
		                {
		                    if($(":input[position="+next+"]").attr('readonly'))
		                    {
		                        next = ++pos;
		                        if($(":input[position="+next+"]").is(":visible"))
		                        {}
		                        else
		                        {
		                            $('input:text, textarea').focus();
		                        }
		                    }
		                    $(":input[position="+next+"]").focus();
		                }
		                else
		                {
		                    $('input:text, textarea').focus();
		                }  
		            }                              
	            }
	        });

	        $(".fecha").datepicker({ 
            autoclose: true,
            language: 'es',
            format: 'dd/mm/yyyy'
        });
		});

    </script>
</html>
