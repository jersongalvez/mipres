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

            buscar_prescripcion();
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


//Metodo que lista las autorizaciones de un afiliado
function buscar_prescripcion() {

    var prescripcion = $("#valor").val();
    if (prescripcion !== '') {

        tabla = $('#tbllistadoprescripcion').dataTable({

            "aProcessing": true, //Activamos el procesamiento del datatables
            "aServerSide": true, //Paginación y filtrado realizados por el servidor
            dom: 'Bfrtip', //Definimos los elementos del control de tabla
            buttons: [],
            columnDefs: [
                {className: "dt-body-center", "targets": [0, 1, 2, 3, 4, 5]},

                //Formateo el valor total de la factura
                {
                    "targets": [4],
                    "render": $.fn.dataTable.render.number('.', ',', 2, '$')
                }
            ],
            "ajax":
                    {
                        url: 'controlador/facturacion.php?op=buscar_prescripcion',
                        data: {prescripcion: prescripcion},
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
function buscar_direccionamiento(n_identificador, IDFacturacion, regimen) {

    var formData = new FormData();
    formData.append('valor', n_identificador);
    formData.append('IDFacturacion', IDFacturacion);
    $.ajax({
        url: "controlador/facturacion.php?op=consulta_factura",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {

            console.log('Consultando datos....');
        },
        success: function (datos) {

            //Ocultar el modal a la vista
            $("#listar_prescripcion").modal("hide");
            datos = JSON.parse(datos);
            if (datos !== null) {

                $('#valor').attr("disabled", "disabled");
                $('#btnBuscarDireccionamiento').attr("disabled", true);
                $('#btnLimpiar').attr("disabled", false);
                $("#identificador").val(n_identificador);
                $("#regimen").val((regimen === 'EPSIC6') ? "CONTRIBUTIVO" : "SUBSIDIADO");
                $("#id_facturacion").val(datos.IDFacturacion);
                $("#tip_servicio").val(tipo_tecnologia(datos.TipoTec));
                $("#consecutivo").val(datos.ConTec);
                $("#num_entrega").val(datos.NoEntrega);
                $("#num_Subentrega").val((datos.NoSubEntrega) ? datos.NoSubEntrega : "0");
                $("#num_factura").val(datos.NoFactura);
                $("#cod_servicio").val(datos.CodSerTecAEntregado);
                $("#unidades").val(datos.CantUnMinDis);
                $("#val_unitario").val(formatear_valor(datos.ValorUnitFacturado));
                $("#val_total").val(formatear_valor(datos.ValorTotFacturado));
                $("#cuo_moderadora").val(formatear_valor(datos.CuotaModer));
                $("#copago").val(formatear_valor(datos.Copago));

                $('#putDatosFacturados').attr("disabled", false);

            } else {

                $("#da_titulo").html("Búsqueda de facturas");
                $("#da_mensaje").html("El valor no se encuentra registrado.");
                $("#datos_facturados").modal("show");
            }

        },
        error: function (e) {
            console.log(e.responseText);
        }

    });
}


//Envio de datos al Web Service
function put_datosFacturados() {

    if ($("#CompAdm").val() !== '') {

        var formData = new FormData();
        formData.append('n_token', $("#regimen").val());
        formData.append('ID', $("#identificador").val());
        formData.append('CompAdm', $("#CompAdm").val());
        formData.append('CodCompAdm', $("#CodCompAdm").val());
        formData.append('CodHom', $("#CodHom").val());
        formData.append('UniCompAdm', $("#UniCompAdm").val());
        formData.append('UniDispHom', $("#UniDispHom").val());
        formData.append('ValUnMiCon', $("#ValUnMiCon").val());
        formData.append('CantTotEnt', $("#CantTotEnt").val());
        formData.append('ValTotCompAdm', $("#ValTotCompAdm").val());
        formData.append('ValTotHom', $("#ValTotHom").val());

        $.ajax({
            url: "controlador/facturacion.php?op=put_datosFacturados",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {

                $("#putDatosFacturados").html("Procesando...");
                $("#putDatosFacturados").attr("disabled", true);
            },
            success: function (datos) {


                $("#putDatosFacturados").removeAttr("disabled");
                $("#putDatosFacturados").html("Grabar Datos Facturados");

                var datosW = JSON.parse(datos);

                $("#resultadoWS").removeClass("hide-div");
                $("#resultadoWS").focus();
                $("#mensaje").html("<li> <strong>Mensaje: </strong>" + datosW.mensaje + "</li>");
                $("#codigo").html("<li> <strong>Código de respuesta: </strong>" + datosW.http_code + "</li>");
                $("#Tiempo").html("<li> <strong>Tiempo total: </strong>" + datosW.total_time + " ms </li>");
                $("#ip").html("<li> <strong>IP: </strong>" + datosW.local_ip + "</li>");

                if (datosW.http_code == 200) {

                    var mensaje = JSON.parse(datosW.mensaje);
                    actuallizar_datosFacturados(mensaje[0].Id, mensaje[0].IDDatosFacturado);
                }

            },
            error: function (e) {
                console.log(e.responseText);

                $("#putDatosFacturados").removeAttr("disabled");
                $("#putDatosFacturados").html("Grabar Datos Facturados");
            }

        });

    } else {

        $("#CompAdm").focus();
    }
}




//Actualiza los datos retornados en el WS
function actuallizar_datosFacturados(IdWS, IDDatosFacturadoWS) {

    var formData = new FormData();
    formData.append('Id_fac1', $("#identificador").val());
    formData.append('IDDatosFacturado1', $("#id_facturacion").val());
    formData.append('NoPrescripcion', $("#valor").val());
    formData.append('IdWS', IdWS);
    formData.append('IDDatosFacturadoWS', IDDatosFacturadoWS);


    $.ajax({
        url: "controlador/facturacion.php?op=actualizar_datosFacturados",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {

            $("#msjserver").html("<li> <strong>Estado: </strong> Procesando...</li>");
        },
        success: function (datos) {

            $("#msjserver").empty();
            $("#msjserver").html("<li> <strong>Estado: </strong> Datos grabados con éxito!!!</li>");

            limpiar_insert();
        },
        error: function (e) {
            console.log(e.responseText);

        }

    });


}



//Metodo que formatea un valor en pesos colombianos
function formatear_valor(valor) {

    var formateado = new Intl.NumberFormat("es-CO", {

        style: 'currency',
        currency: "COP",
        minimumFractionDigits: 2
    }).format(valor);
    return formateado;
}


//Metodo que retorna el nombre de la tecnologia
function tipo_tecnologia(parametro) {

    var retorno;
    switch (parametro) {

        case 'M':
            retorno = parametro + ' - Medicamento';
            break;
        case 'P':
            retorno = parametro + ' - Procedimiento';
            break;
        case 'D':
            retorno = parametro + ' - Dispositivo médico';
            break;
        case 'N':
            retorno = parametro + ' - Producto Nutricional';
            break;
        case 'S':
            retorno = parametro + ' - Servicio Complementario';
            break;
        default:
            retorno = 'No registrado';
            break;
    }

    return retorno;
}


//Metodo que valida el comparador admon.
function validar_compadm() {

    var opcion = $('#CompAdm').val();
    if (opcion === '1') {

        $("#CodCompAdm").removeAttr('readonly');
        $("#CodHom").attr('readonly', 'readonly');
        $("#UniCompAdm").attr("disabled", false);
        $("#UniDispHom").attr('readonly', 'readonly');
        $("#ValUnMiCon").removeAttr('readonly');
        $("#CantTotEnt").removeAttr('readonly');
        $("#ValTotCompAdm").removeAttr('readonly');
        $("#ValTotHom").attr('readonly', 'readonly');
    } else if (opcion === '2') {

        $("#CodCompAdm").attr('readonly', 'readonly');
        $("#CodHom").removeAttr('readonly');
        $("#UniCompAdm").attr("disabled", "disabled");
        $("#UniDispHom").removeAttr('readonly');
        $("#ValUnMiCon").removeAttr('readonly');
        $("#CantTotEnt").removeAttr('readonly');
        $("#ValTotCompAdm").attr('readonly', 'readonly');
        $("#ValTotHom").removeAttr('readonly');
    } else {

        $("#CodCompAdm").attr('readonly', 'readonly');
        $("#CodHom").attr('readonly', 'readonly');
        $("#UniCompAdm").attr("disabled", "disabled");
        $("#UniDispHom").attr('readonly', 'readonly');
        $("#ValUnMiCon").attr('readonly', 'readonly');
        $("#CantTotEnt").attr('readonly', 'readonly');
        $("#ValTotCompAdm").attr('readonly', 'readonly');
        $("#ValTotHom").attr('readonly', 'readonly');
    }
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

    //Datos informativo
    $("#id_facturacion").val('');
    $("#tip_servicio").val('');
    $("#consecutivo").val('');
    $("#num_entrega").val('');
    $("#num_Subentrega").val('');
    $("#num_factura").val('');
    $("#cod_servicio").val('');
    $("#unidades").val('');
    $("#val_unitario").val('');
    $("#val_total").val('');
    $("#cuo_moderadora").val('');
    $("#copago").val('');


    //Datos WebService
    $("#regimen").val('');
    $("#identificador").val('');
    $("#CompAdm").val('');
    $("#CodCompAdm").val('');
    $("#CodHom").val('');
    $('#UniCompAdm').val('');
    $("#UniDispHom").val('');
    $("#ValUnMiCon").val('');
    $("#CantTotEnt").val('');
    $("#ValTotCompAdm").val('');
    $("#ValTotHom").val('');

    $("#CodCompAdm").attr('readonly', 'readonly');
    $("#CodHom").attr('readonly', 'readonly');
    $("#UniCompAdm").attr("disabled", "disabled");
    $("#UniDispHom").attr('readonly', 'readonly');
    $("#ValUnMiCon").attr('readonly', 'readonly');
    $("#CantTotEnt").attr('readonly', 'readonly');
    $("#ValTotCompAdm").attr('readonly', 'readonly');
    $("#ValTotHom").attr('readonly', 'readonly');
    $('#putDatosFacturados').attr("disabled", true);


    $('#valor').removeAttr('disabled');
    $('#valor').focus();
    $('#btnBuscarDireccionamiento').attr("disabled", false);
    $('#btnLimpiar').attr("disabled", true);
}


//Metodo que limpia las cajas de texto del frm
function limpiar_insert() {

    //Datos informativo
    $("#id_facturacion").val('');
    $("#tip_servicio").val('');
    $("#consecutivo").val('');
    $("#num_entrega").val('');
    $("#num_Subentrega").val('');
    $("#num_factura").val('');
    $("#cod_servicio").val('');
    $("#unidades").val('');
    $("#val_unitario").val('');
    $("#val_total").val('');
    $("#cuo_moderadora").val('');
    $("#copago").val('');


    //Datos WebService
    $("#regimen").val('');
    $("#identificador").val('');
    $("#CompAdm").val('');
    $("#CodCompAdm").val('');
    $("#CodHom").val('');
    $('#UniCompAdm').val('');
    $("#UniDispHom").val('');
    $("#ValUnMiCon").val('');
    $("#CantTotEnt").val('');
    $("#ValTotCompAdm").val('');
    $("#ValTotHom").val('');

    $("#CodCompAdm").attr('readonly', 'readonly');
    $("#CodHom").attr('readonly', 'readonly');
    $("#UniCompAdm").attr("disabled", "disabled");
    $("#UniDispHom").attr('readonly', 'readonly');
    $("#ValUnMiCon").attr('readonly', 'readonly');
    $("#CantTotEnt").attr('readonly', 'readonly');
    $("#ValTotCompAdm").attr('readonly', 'readonly');
    $("#ValTotHom").attr('readonly', 'readonly');
    $('#putDatosFacturados').attr("disabled", true);

    $('#valor').removeAttr('disabled');
    $('#btnBuscarDireccionamiento').attr("disabled", false);
    $('#btnLimpiar').attr("disabled", true);
}


//Metodo que limpia el div con la respuesta del Web Service
function limpiar_response() {

    $("#mensaje").empty();
    $("#codigo").empty();
    $("#Tiempo").empty();
    $("#ip").empty();

    $("#resultadoWS").addClass("hide-div");

    $('#btnLimpiar').focus();
}



//Ejecuto la funcion al cargar el archivo
init();


