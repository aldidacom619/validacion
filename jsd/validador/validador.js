
var adiciono = 0;
function addValidador(idfuncionario,nombrefuncionario)
{
    $("#idFuncionario").val(idfuncionario);
    $("#nombreFuncionario").text(nombrefuncionario);
}
$( "#btnCancelar" ).click(function() {
    $("#idFuncionario").val('');
    // setTimeout(function() {
    //     $(".alert-warning").fadeIn(50);
    // },0);
    // setTimeout(function() {
    //     $(".alert-warning").fadeOut(1500);
    // },2000);
});

$( "#btnAgregar" ).click(function() {
    $.ajax({
        url: $("#baseUrl").val()+'validador/store',
        type: "POST",
        // data: 'idfuncionario='+$("#idFuncionario").val(),
        data: {'idfuncionario':$("#idFuncionario").val(),'item2':22},
        success: function(data) {
            var result = JSON.parse(data);
            if (result[0].id > 0){
                // console.log(result[0].nombre);
                // var tabla = document.getElementById("tableValidadores");
                // var fila = tabla.insertRow(-1);
                // fila.id = 'filaValidador'+result[0].id;
                // var celda1=fila.insertCell(0);
                // celda1.id = 'vNro'+result[0].id;
                // var celda2=fila.insertCell(1);
                // celda2.id = 'vNombre'+result[0].id;
                // var celda3=fila.insertCell(2);
                // celda3.id = 'vUsuario'+result[0].id;
                // var celda4=fila.insertCell(3);
                // celda4.id = 'vTEntidades'+result[0].id;
                // var celda5=fila.insertCell(4);
                // celda5.id = 'vTBienes'+result[0].id;
                // var celda6=fila.insertCell(5);
                // celda6.id = 'vTDocumentos'+result[0].id;
                // var celda7=fila.insertCell(6);
                // celda7.id = 'vActivo'+result[0].id;
                // var celda8=fila.insertCell(7);
                // celda8.id = 'vAdministrador'+result[0].id;
                // var celda9=fila.insertCell(8);
                // celda9.id = 'vEntidad'+result[0].id;
                // var celda10=fila.insertCell(9);
                // celda10.id = 'vSeguimiento'+result[0].id;
                // celda1.innerHTML =  $("#tableValidadores tr").length;
                // celda2.innerHTML = result[0].nombre;
                // celda2.align = "center";
                // celda3.innerHTML = result[0].usuario;
                // // <td id="vActivo<?=$lista->id?>" align="center"></td>
                // // <td id="vAdministrador<?=$lista->id?>" align="center"><input onchange="admin(<?=$lista->id?>)" type="checkbox" data-toggle="toggle" data-size="mini" <?=($lista->administrador=='t')?'checked ':''?>></td>
                // // <td id="vEntidad<?=$lista->id?>" align="center"><a href="#" data-toggle="modal" data-target="#addEntidad"><i class="fa fa-arrow-right"></i></a></td>
                // //     <td id="VSeguimiento<?=$lista->id?>" align="center"><a href="#" data-toggle="modal" data-target="#getSeguimiento"><i class="fa fa-arrow-right"></i></a></td>
                // var activo = '<input onchange="activo('+result[0].id+')" type="checkbox" data-toggle="toggle" data-size="mini" checked >';
                // celda4.innerHTML = result[0].totalentidades;
                // celda5.innerHTML = result[0].totalbienes;
                // celda6.innerHTML = result[0].totalentidades;
                // celda7.innerHTML = ""+activo;
                // celda8.innerHTML = result[0].usuario;
                // celda9.innerHTML = result[0].usuario;
                // celda10.innerHTML = result[0].usuario;
                // //
                // // var link = '<center>' +
                // //     '<a onclick="editarPecunaria('+idproceso+','+data+',\''+celda5.innerHTML+'\',\''+celda3.innerHTML+'\')" style="cursor:pointer;">' +
                // //     '<img border="0" width="20px" src="../vista/imagenes/iconosabm/editar-25x25.png" alt="Ver estadistica" title="Editar">' +
                // //     '</a>   ' +
                // //     '<a onclick=borrarPecunaria('+data+') style="cursor:pointer;">' +
                // //     '<img border="0" width="20px" src="../vista/imagenes/iconosabm/cancel_icon.png" alt="Ver estadistica" title="Borrar">' +
                // //     '</a>' +
                // //     '</center>';
                // // celda6.innerHTML= " " + link;

                $("#fila"+$("#idFuncionario").val()).remove();
//                                document.getElementById("tablapecunaria").rows[fila].hide();
                setTimeout(function() {
                    $(".alert-success").fadeIn(50);
                },0);
                setTimeout(function() {
                    $(".alert-success").fadeOut(1500);
                },2000);
                adiciono = 1;
            }
            else{
                setTimeout(function() {
                    $(".alert-warning").fadeIn(50);
                },0);
                setTimeout(function() {
                    $(".alert-warning").fadeOut(1500);
                },2500);
            }
        },
        error: function(){
            setTimeout(function() {
                $(".alert-danger").fadeIn(50);
            },0);
            setTimeout(function() {
                $(".alert-danger").fadeOut(1500);
            },2000);
        }
    });
});
$("#addValidador").on('hidden.bs.modal', function () {
    if (adiciono === 1)
    location.href= $("#baseUrl").val()+'AdminValidadores/validadores';
    // location.reload();
    // $("#page-wrapper").load($("#baseUrl").val()+'AdminValidadores/refrescarListaValidador');
    // $("#page-wrapper").html($("#baseUrl").val()+'application/views/administrador/validadores.php');
    // $("#page-wrapper").load($("#baseUrl").val()+"assets/vendor/datatables-plugins/dataTables.bootstrap.min.js");
    // location.reload($("#baseUrl").val()+"assets/vendor/datatables-plugins/dataTables.bootstrap.min.js");
    // $.ajaxSetup({ cache: false });
    // $("#page-wrapper").load(this.load);
    // e.preventDefault();

    // $.get({
    //     url: $("#baseUrl").val()+'adminvalidadores/refrescarListaValidador',
    //     cache: false,
    //     error: function(){
    //         setTimeout(function() {
    //             $(".alert-danger").fadeIn(50);
    //         },0);
    //         setTimeout(function() {
    //             $(".alert-danger").fadeOut(1500);
    //         },2000);
    //     }
    // });
});
// $("#confirmacion").on('shown.bs.modal', function () {
//     // $('#addValidador').modal('hide').fast();
//     $('<div class="modal-backdrop"></div>').appendTo(document.body);
//
// // Remove it (later)
// //     $(".modal-backdrop").remove();
// });
// $("#confirmacion").on('hidden.bs.modal', function () {
//     $('#addValidador').modal('show').fast();
// });


