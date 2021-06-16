<?php
set_time_limit(1000);
//ERROR0004
  if (!empty($_SESSION['NIT_EPS'])){   


    $sql = "SELECT * FROM PRS_URL_SERVICES WHERE COD_URL = '2'";
    $params = array();
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $stmt = sqlsrv_query( $conn, $sql, $params, $options);
    $row_count = sqlsrv_num_rows( $stmt );
	    if ($row_count === false){
	    echo "<div class='alert alert-danger alert-dismissible'>";
	    echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
	    echo "<strong>Error!</strong> No se encuentra el recurso solicitado, error: ERROR0004</div>";
	    }  
	    else{
	          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))  
	          {  
				if ($var_regimen === 'Subsidiado') {
			    $url = $row['DES_URL'].$_SESSION['NIT_EPS'].'/'.$var_fecha.'/'.$_SESSION['PRETOCKENSUB'];
				}
				elseif ($var_regimen === 'Contributivo') {
				$url = $row['DES_URL'].$_SESSION['NIT_EPS'].'/'.$var_fecha.'/'.$_SESSION['PRETOCKEN'];
				}
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json; charset=utf-8'));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
				$result = curl_exec($ch);
	          }  
	        }
    sqlsrv_free_stmt($stmt); 
  }else{
	    echo "<div class='alert alert-danger alert-dismissible'>";
	    echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
	    echo "<strong>Error!</strong> No se ha logrado autenticar los datos de la compañia, error: ERROR0004</div>";
  }

?>
