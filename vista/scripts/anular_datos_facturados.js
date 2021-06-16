////////////////////////////////////////////////////////////////////////////////
/////////////////////////         SISTEMA RIPS         /////////////////////////
/////////////////////////      PIJAOS SALUD EPSI      //////////////////////////
///////////////////          JS BUSCAR AUTORIZACION          ///////////////////
/////////////////////////  DEPARTAMENTO DE DESARROLLO  /////////////////////////
////////////////////  AMBITO: PROCESAMIENTO AUTORIZACIONES  ////////////////////
////////          METODOS JS PARA EL PROCESAMIENTO DE INFORMACION        ///////
////////////////////////////////////////////////////////////////////////////////

//Variable global datatables
var tabla;
//Metodo que se ejecuta al inicio
function init() {

    //Cargo el metodo de consulta para abrir la conexion ajax
    carga_vacia();
    //Busqueda de resultados cuando se presiona Enter
    $("#valor").keypress(function (e) {

        if (e.which === 13) {

            buscar_prescripcionAn();
        }
    });
}


//Metodo que carga el datatables en null
function carga_vacia() {

    tabla = $('#tbllistadoprescripcion').dataTable({

        dom: 'Bfrtip', //Definimos los elementos del control de tabla
        buttons: [],
        columnDefs: [
            {className: "dt-body-center", "targets": [0, 1, 2, 3, 4]}
        ]

    }).DataTable();
}


//Metodo que lista las autorizaciones para anularlas
function buscar_prescripcionAn() {

    var prescripcion = $("#valor").val();
    if (prescripcion !== '') {

        tabla = $('#tbllistadoprescripcion').dataTable({

            "aProcessing": true, //Activamos el procesamiento del datatables
            "aServerSide": true, //Paginación y filtrado realizados por el servidor
            dom: 'Bfrtip', //Definimos los elementos del control de tabla
            buttons: [],
            columnDefs: [
                {className: "dt-body-center", "targets": [0, 1, 2, 3, 4]}
            ],
            "ajax":
                    {
                        url: 'controlador/facturacion.php?op=buscar_datoFacturado',
                        data: {prescripcion_facturada: prescripcion},
                        type: "get",
                        dataType: "json",
                        error: function (e) {
                            console.log(e.responseText);
                        }

                    },
            "initComplete": function (settings, json) {

                //Cargar el modal a la vista
                $("#listar_prescripcion").modal("show");
            },
            "bDestroy": true,
            "iDisplayLength": 10, //Paginación
            "order": [[1, "asc"]]//Ordenar (columna,orden)

        }).DataTable();
    } else {

        $("#valor").focus();
    }

}


//Metodo que busca un direcionamiento
function asignar_valorAn(id_facturado, id, factura) {

    //Ocultar el modal a la vista
    $("#listar_prescripcion").modal("hide");

    $("#identificador").val(id);
    $("#id_factura").val(id_facturado);
    $("#factura").val(factura);
    $('#valor').attr("disabled", true);

    $('#btnBuscarDireccionamiento').attr("disabled", true);
    $('#btnAnular').attr("disabled", false);
    $('#btnLimpiar').attr("disabled", false);
}


//Envio de datos al Web Service
function put_AnulardatosFacturados() {


    var formData = new FormData();
    formData.append('IDDatosFacturado', $("#id_factura").val());
 
 
    $.ajax({
        url: "controlador/facturacion.php?op=put_anularDatosFacturados",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {

            $("#btnAnular").html("Procesando...");
            $("#btnAnular").attr("disabled", true);
        },
        success: function (datos) {

            $("#btnAnular").removeAttr("disabled");
            $("#btnAnular").html("Anular");

            datos = JSON.parse(datos);

            $("#resultadoWS").removeClass("hide-div");
            $("#resultadoWS").focus();
            $("#mensaje").html("<li> <strong>Mensaje: </strong>" + datos.mensaje + "</li>");
            $("#codigo").html("<li> <strong>Código de respuesta: </strong>" + datos.http_code + "</li>");
            $("#Tiempo").html("<li> <strong>Tiempo total: </strong>" + datos.total_time + " ms </li>");
            $("#ip").html("<li> <strong>IP: </strong>" + datos.local_ip + "</li>");

            if (datos.http_code == 200) {

                anular_datosFacturadosBD();
            }
               
        },
        error: function (e) {
            console.log(e.responseText);

            $("#btnAnular").removeAttr("disabled");
            $("#btnAnular").html("Anular");
        }

    });


}




//Actualiza los datos retornados en el WS
function anular_datosFacturadosBD() {

    var formData = new FormData();
    formData.append('Id', $("#identificador").val());
    formData.append('IDDatosFacturado', $("#id_factura").val());
    formData.append('NoPrescripcion', $("#valor").val());
    formData.append('factura', $("#factura").val());
   
    $.ajax({
        url: "controlador/facturacion.php?op=anular_datosFacturados",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {

            $("#msjserver").html("<li> <strong>Estado: </strong> Procesando...</li>");
        },
        success: function (datos) {
            
            console.log(datos);
            $("#msjserver").empty();
            $("#msjserver").html("<li> <strong>Estado: </strong> Datos grabados con éxito!!!</li>");
        },
        error: function (e) {
            console.log(e.responseText);

        }

    });


}



//Metodo que limpia el tbody en el datatables
function limpiar_modal() {

    //Limpio el input de busqueda del datatables
    $('#tbllistadoprescripcion').dataTable().fnFilter('');
    //Limpio el tbody del datatables
    $('#tbllistadoprescripcion').dataTable().fnClearTable();
}



//Metodo que limpia las cajas de texto del frm
function limpiar_frm() {

    $("#id_factura").val('');
    $("#identificador").val('');
    $("#factura").val('');
    $('#valor').attr("disabled", false);
    $('#valor').focus();

    $('#btnBuscarDireccionamiento').attr("disabled", false);
    $('#btnAnular').attr("disabled", true);
    $('#btnLimpiar').attr("disabled", true);
    $('#btnLimpiar').focus();
    
    limpiar_response();
}



//Metodo que limpia el div con la respuesta del Web Service
function limpiar_response() {

    $("#mensaje").empty();
    $("#codigo").empty();
    $("#Tiempo").empty();
    $("#ip").empty();

    $("#resultadoWS").addClass("hide-div");

    limpiar_frm();
    
}



//Ejecuto la funcion al cargar el archivo
init();


