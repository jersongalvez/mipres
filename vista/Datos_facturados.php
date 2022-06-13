<style type="text/css">
    /*Oculta elementos de los frm*/
    .hide-div{
        display:none;
    }
</style>

<div class="modal fade" id="datos_facturados" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="da_titulo"></h5>
            </div>
            <div class="modal-body" id="da_mensaje">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="listar_prescripcion" data-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Prescripciones encontradas </h5>
            </div>
            <div class="modal-body">

                <table id="tbllistadoprescripcion" class="table" style="width: 100%">
                    <thead>
                        <tr>
                            <th class="text-center">Seleccionar</th>
                            <th class="text-center">Identificador</th>
                            <th class="text-center">Factura</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-center">Valor</th>
                            <th class="text-center">Estado</th>
                        </tr>
                    </thead>

                    <tbody> </tbody>

                    <tfoot>
                        <tr>
                            <th class="text-center">Seleccionar</th>
                            <th class="text-center">Identificador</th>
                            <th class="text-center">Factura</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-center">Valor</th>
                            <th class="text-center">Estado</th>
                        </tr>
                    </tfoot>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiar_modal()">Aceptar</button>
            </div>
        </div>
    </div>
</div>


<div class="col-md-12 sm-12">
    <div class="card shadow">
        <div class="card-header">
            <h4>Datos Facturados</h4>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="col-md-8 sm-12">
                    <label>Número de prescripción (*):</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="valor" name="valor" placeholder="Valor" autofocus="true" autocomplete="off">
                    </div> 
                </div>

                <div class="col-md-2 sm-12" style="margin-top: 32px;">
                    <button class="btn btn-outline-dark btn-block" type="button" id="btnBuscarDireccionamiento" onclick="buscar_prescripcion()">Buscar</button> 
                </div>

                <div class="col-md-2 sm-12" style="margin-top: 32px;">
                    <button class="btn btn-outline-dark btn-block" type="button" id="btnLimpiar" onclick="limpiar_frm()" disabled="true">Limpiar</button> 
                </div>
            </div>  
        </div>
    </div>
</div>

<br>

<div class="col-md-12 sm-12">
    <div class="card shadow">
        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#home">Encabezado factura</a>
                </li>
            </ul>

            <div class="form-row" style="margin-top: 20px">
                <div class="col-md-3 sm-12">
                    <label>Identificador facturación:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="id_facturacion" name="id_facturacion" disabled="true">
                    </div> 
                </div>

                <div class="col-md-3 sm-12">
                    <label>Servicio o Tecnología:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="tip_servicio" name="tip_servicio" disabled="true">
                    </div> 
                </div>

                <div class="col-md-2 sm-12">
                    <label>Consecutivo:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="consecutivo" name="consecutivo" disabled="true">
                    </div> 
                </div>

                <div class="col-md-2 sm-12">
                    <label>Número Entrega:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="num_entrega" name="num_entrega" disabled="true">
                    </div> 
                </div>
                
                <div class="col-md-2 sm-12">
                    <label>Número Sub-entrega:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="num_Subentrega" name="num_Subentrega" disabled="true">
                    </div> 
                </div>
            </div> 

            <div class="form-row" style="margin-top: 10px">
                <div class="col-md-3 sm-12">
                    <label>Número de Factura:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="num_factura" name="num_factura" disabled="true">
                    </div> 
                </div>

                <div class="col-md-3 sm-12">
                    <label>Código servicio:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="cod_servicio" name="cod_servicio" disabled="true">
                    </div> 
                </div>

                <div class="col-md-2 sm-12">
                    <label>Unidades:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="unidades" name="unidades" disabled="true">
                    </div> 
                </div>

                <div class="col-md-4 sm-12">
                    <label>Valor unitario facturado :</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="val_unitario" name="val_unitario" disabled="true">
                    </div> 
                </div>
            </div> 

            <div class="form-row" style="margin-top: 10px">
                <div class="col-md-4 sm-12">
                    <label>Valor total facturado:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="val_total" name="val_total" disabled="true">
                    </div> 
                </div>

                <div class="col-md-4 sm-12">
                    <label>Cuota moderadora:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="cuo_moderadora" name="cuo_moderadora" disabled="true">
                    </div> 
                </div>

                <div class="col-md-4 sm-12">
                    <label>Copago:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="copago" name="copago" disabled="true">
                    </div> 
                </div>
            </div> 
        </div>
    </div>
</div>

<br>

<div class="col-md-12 sm-12">
    <div class="card shadow">
        <div class="card-body">

            <div class="form-row">
                <div class="col-md-4 sm-12">
                    <label>Identificador:</label>
                </div>
                <div class="col-md-8 sm-12">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="identificador" name="identificador" readonly>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-4 sm-12">
                    <label>Token Cargue:</label>
                </div>
                <div class="col-md-8 sm-12">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="regimen" name="regimen" readonly>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-4 sm-12">
                    <label>Comparador Administrativo u Homólogo:</label>
                </div>
                <div class="col-md-8 sm-12">
                    <div class="input-group mb-3">
                        <select class="form-control" id="CompAdm" name="CompAdm" onchange="validar_compadm()">
                            <option value="" selected="selected">Elije una opción</option>
                            <option value="1">Comparador Administrativo</option>
                            <option value="2">Homólogo</option>
                            <option value="3">No aplica</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-4 sm-12">
                    <label>Código Comparador Administrativo:</label>
                </div>
                <div class="col-md-8 sm-12">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="CodCompAdm" name="CodCompAdm" maxlength="3" readonly>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-4 sm-12">
                    <label>Código Homólogo:</label>
                </div>
                <div class="col-md-8 sm-12">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="CodHom" name="CodHom" maxlength="5" readonly>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-4 sm-12">
                    <label>Unidad de Concentración Comparador Administrativo:</label>
                </div>
                <div class="col-md-8 sm-12">
                    <div class="input-group mb-3">
                        <select class="form-control" id="UniCompAdm" name="UniCompAdm" disabled>
                            <option value="" selected>Elije una opción</option>
                            <option value="0072">UI</option>
                            <option value="0137">mcg</option>
                            <option value="0168">mg</option>
                            <option value="0187">MUI</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-4 sm-12">
                    <label>Unidad de Dispensación Homólogo:</label>
                </div>
                <div class="col-md-8 sm-12">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="UniDispHom" name="UniDispHom" maxlength="2" readonly>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-4 sm-12">
                    <label>Valor Unidad Mínima:</label>
                </div>
                <div class="col-md-8 sm-12">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="ValUnMiCon" name="ValUnMiCon" maxlength="16" readonly>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-4 sm-12">
                    <label>Cantidad Total:</label>
                </div>
                <div class="col-md-8 sm-12">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="CantTotEnt" name="CantTotEnt" maxlength="16" readonly>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-4 sm-12">
                    <label>Valor Total Comp. Adm.:</label>
                </div>
                <div class="col-md-8 sm-12">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="ValTotCompAdm" name="ValTotCompAdm" maxlength="19" readonly>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-4 sm-12">
                    <label>Valor Total Homólogo:</label>
                </div>
                <div class="col-md-8 sm-12">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="ValTotHom" name="ValTotHom" maxlength="19" readonly>
                    </div>
                </div>
            </div>

            <div class="form-row" style="margin-top: 10px">
                <div class="col-md-3 sm-3"></div>
                <div class="col-md-6 sm-6">
                    <button  class="btn btn-outline-dark btn-block" type="button" id="putDatosFacturados" onclick="put_datosFacturados()" disabled>Grabar Datos Facturados</button> 
                </div>
                <div class="col-md-3 sm-3"></div>
            </div>

        </div>
    </div>
</div>

<br>

<div class="col-md-12 sm-12 hide-div" id="resultadoWS">
    <div class="card border-dark mb-3">
        <div class="card-header text-center">
            <strong>Resultados de la operación</strong>
        </div>
        <div class="card-body">
            <ul>
                <p class="card-text" id="mensaje"></p>
                <p class="card-text" id="codigo"></p>
                <p class="card-text" id="Tiempo"></p>
                <p class="card-text" id="ip"></p>
                <p class="card-text" id="msjserver"></p>
            </ul>
        </div>
        <div class="card-footer text-center">
            <button class="btn btn-primary" onclick="limpiar_response()">Aceptar</button>
        </div>
    </div>
</div>

<br>

<script type="text/javascript" src="public/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="public/datatables/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="public/datatables/buttons.html5.min.js"></script>
<script type="text/javascript" src="public/datatables/buttons.colVis.min.js"></script>
<script type="text/javascript" src="public/datatables/jszip.min.js"></script>
<script type="text/javascript" src="public/datatables/vfs_fonts.js"></script>
<script type="text/javascript" src="vista/scripts/datos_facturados.js?v=<?php echo microtime(); ?>"></script>