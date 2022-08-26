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
            <th class="text-center">ID facturación</th>
            <th class="text-center">Factura</th>
            <th class="text-center">Estado</th>
            <th class="text-center">Fec. actualización</th>
          </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
          <tr>
            <th class="text-center">Seleccionar</th>
            <th class="text-center">Identificador</th>
            <th class="text-center">ID facturación</th>
            <th class="text-center">Factura</th>
            <th class="text-center">Estado</th>
            <th class="text-center">Fec. actualización</th>
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
      <h4>Anular Datos Facturados</h4>
    </div>
    <div class="card-body">
      <div class="form-row">
        <div class="col-md-3 sm-12">
          <label>Número de prescripción (*):</label>
          <div class="input-group">
            <input
              type="number"
              class="form-control"
              id="valor"
              name="valor"
              placeholder="Prescripción"
              autofocus="true"
              autocomplete="off"
            >
          </div>
        </div>
        <div class="col-md-3 sm-12">
          <label>Identificador:</label>
          <div class="input-group">
            <input type="text" class="form-control" id="identificador" name="identificador" readonly>
          </div>
        </div>
        <div class="col-md-3 sm-12">
          <label>ID Facturación:</label>
          <div class="input-group">
            <input type="text" class="form-control" id="id_factura" name="id_factura" readonly>
          </div>
        </div>
        <div class="col-md-3 sm-12">
          <label>Nº factura:</label>
          <div class="input-group">
            <input type="text" class="form-control" id="factura" name="factura" readonly>
          </div>
        </div>
      </div>
      <div class="form-row" style="margin-top: 15px;">
        <div class="col-md-4 sm-12" style="margin-top: 32px;">
          <button
            class="btn btn-outline-dark btn-block"
            type="button"
            id="btnBuscarDireccionamiento"
            onclick="buscar_prescripcionAn()">
            Buscar
          </button>
        </div>
        <div class="col-md-4 sm-12" style="margin-top: 32px;">
          <button
            class="btn btn-outline-primary btn-block"
            type="button"
            id="btnAnular"
            onclick="put_AnulardatosFacturados()"
            disabled="true">
            Anular
          </button>
        </div>
        <div class="col-md-4 sm-12" style="margin-top: 32px;">
          <button
            class="btn btn-outline-danger btn-block"
            type="button"
            id="btnLimpiar"
            onclick="limpiar_frm()"
            disabled="true"
          >
            Limpiar
          </button>
        </div>
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
    <button class="btn btn-primary" onclick="limpiar_response()">
      Aceptar
    </button>
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
<script type="text/javascript" src="vista/scripts/anular_datos_facturados.js?v=<?php echo microtime(); ?>"></script>