</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<!--    <script src="<?= base_url() ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->


<!-- Bootstrap Core JavaScript -->
<script src="<?= base_url() ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/vendor/bootstrap/js/bootstrap-toggle.min.js"></script>
<script src="<?= base_url() ?>assets/vendor/bootstrap/js/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url() ?>assets/vendor/bootstrap/js/bootstrap-datepicker.es.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="<?= base_url() ?>assets/vendor/metisMenu/metisMenu.min.js"></script>

<!-- Morris Charts JavaScript -->
<!--    <script src="<?= base_url() ?>assets/vendor/raphael/raphael.min.js"></script>
<script src="<?= base_url() ?>assets/vendor/morrisjs/morris.min.js"></script>
<script src="<?= base_url() ?>assets/data/morris-data.js"></script>-->

<!-- Custom Theme JavaScript -->
<script src="<?= base_url() ?>assets/dist/js/sb-admin-2.js"></script>

<script src="<?= base_url() ?>assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/vendor/datatables-responsive/dataTables.responsive.js"></script>


<script>
    function fecha()
    {
        $(".fecha-modal").datepicker({
            autoclose: true,
            language: 'es'
        });
    }
    $(function () {
        $('.dataTables-modal').DataTable({
            responsive: true,
            "language": {
                "lengthMenu": "Mostrar _MENU_ filas por pagina",
                "search": "Buscar:&nbsp;",
                "zeroRecords": "Sin datos encontrados",
                "sEmptyTable": "No se encontraron registros",
                "info": "Pagina _PAGE_ de _PAGES_",
                "infoEmpty": "Sin datos disponibles",
                "infoFiltered": "(filtered from _MAX_ total records)",
                paginate: {
                    first: "Primero",
                    previous: "Anterior",
                    next: "Siguiente",
                    last: "Ultimo"
                }
            }
        });
        $('.tableEight').DataTable({
            responsive: true,
            iDisplayLength: 20,
            aLengthMenu: [8,10, 20, 50],
            "language": {
                "lengthMenu": "Mostrar _MENU_ filas por pagina",
                "search": "Buscar:&nbsp;",
                "zeroRecords": "Sin datos encontrados",
                "sEmptyTable": "No se encontraron registros",
                "info": "Pagina _PAGE_ de _PAGES_",
                "infoEmpty": "Sin datos disponibles",
                "infoFiltered": "(filtered from _MAX_ total records)",
                paginate: {
                    first:      "Primero",
                    previous:   "Anterior",
                    next:       "Siguiente",
                    last:       "Ultimo"
                },
            }
        });
        $('.tableSix').DataTable({
            responsive: true,
            iDisplay: false,
            iDisplayLength: 6,
            aLengthMenu: [6,10,20],
            "language": {
                "lengthMenu": "Mostrar _MENU_ filas por pagina",
                "search": "Buscar:&nbsp;",
                "zeroRecords": "Sin datos encontrados",
                "sEmptyTable": "No se encontraron registros",
                "info": "Pagina _PAGE_ de _PAGES_",
                "infoEmpty": "Sin datos disponibles",
                "infoFiltered": "(filtered from _MAX_ total records)",
                paginate: {
                    first:      "Primero",
                    previous:   "Anterior",
                    next:       "Siguiente",
                    last:       "Ultimo"
                }
            }
        });
        $('.dataTables-example').DataTable({
            responsive: true,
            "language": {
                "lengthMenu": "Mostrar _MENU_ filas por pagina",
                "search": "Buscar:&nbsp;",
                "zeroRecords": "Sin datos encontrados",
                "sEmptyTable": "No se encontraron registros",
                "info": "Pagina _PAGE_ de _PAGES_",
                "infoEmpty": "Sin datos disponibles",
                "infoFiltered": "(filtered from _MAX_ total records)",
                paginate: {
                    first: "Primero",
                    previous: "Anterior",
                    next: "Siguiente",
                    last: "Ultimo"
                },
            }
        });
        $(".fecha").datepicker({ 
            autoclose: true,
            language: 'es',
            format: 'dd/mm/yyyy'
        });
    });
</script>
</body>
</html>
 