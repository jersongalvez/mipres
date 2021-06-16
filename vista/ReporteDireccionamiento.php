<div class="container-fluid" style="margin-top:80px">



<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">Descargar</li>
    <li class="breadcrumb-item"><a  href="index.php?x=012">Direccionamientos por Fecha</a></li>
  </ol>
</nav>


<div class="container">

<div class="row">
  <div class="col-md-3 sm-12">
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
      <a class="btn btn-light" id="v-pills-profile-tab" href="index.php"><center>Volver al Inicio</center></a>
    </div>
    <br>
    <center><div id="barra" class="spinner-border text-success" style = 'display:none;'></div></center>
  </div>
  <div class="col-md-9 sm-12">
  <div class="tab-content" id="v-pills-tabContent">

<div class="card ">
  <div class="card-header">
    <H4>Direccionamientos por Fecha</H4>
  </div>
  <div class="card-body">      
      <form class="" action="index.php?x=014" method="post"  >
      <div class="form-row">
      <div class="col-md-6 sm-12">
      <label>Régimen</label>
      <select id="var_regimen" class="form-control" name="var_regimen" required>
      <option value="S">Subsidiado</option>
      <option value="C">Contributivo</option>
      </select>
      </div>
      <div class="col-md-6 sm-12">
      <label for="validationCustom02">Fecha</label>
      <input type="date" class="form-control" id="var_fecha" name="var_fecha" value="<?php echo date("Y-m-d");?>"  required>
      </div>
      </div>
        <br>
        <button class="btn btn-outline-success btn-block" type="submit" onclick="javascript:progreso('Consultando');">Consultar a MIPRES</button>  
      </form>
  </div>
</div>


    </div>
  </div>
</div>
</div>


</div>

