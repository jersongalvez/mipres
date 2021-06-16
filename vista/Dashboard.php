

<?php
    
$sql = "
SELECT REPORTMIPRES, FORMAT(FPRESCRIPCION,'yyyy') ANIO, FORMAT(FPRESCRIPCION,'MM') MES, COUNT(*) RECUENTO
FROM [MIPRES_PRESCRIPCION ] MP
WHERE FPRESCRIPCION BETWEEN DATEADD(MONTH, -11, FORMAT(GETDATE(),'01/MM/yyyy'))  AND GETDATE()
GROUP BY FORMAT(FPRESCRIPCION,'yyyy'), FORMAT(FPRESCRIPCION,'MM'), REPORTMIPRES
ORDER BY 1 DESC, 2 DESC, 3  ASC";
    $stmt2 = sqlsrv_query($conn, $sql, array());
    
    if ($stmt2 !== NULL) {
        $rows2 = sqlsrv_has_rows($stmt2);
        
        if ($rows2 === true) {

$Titulos = array();
$Recuento = array();
while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_NUMERIC) ) {
      array_push($Recuento, $row2[3]);
      array_push($Titulos, $row2[1]."/".$row2[2]);
}


        } 
    }

?>


<?php
    
$sql = "
SELECT REPORTMIPRES, COUNT(*) RECUENTO
FROM [MIPRES_PRESCRIPCION ] MP
WHERE FPRESCRIPCION BETWEEN FORMAT(GETDATE(),'01/01/yyyy')  AND GETDATE()
GROUP BY REPORTMIPRES
ORDER BY 1 DESC";
    $stmt3 = sqlsrv_query($conn, $sql, array());
    
    if ($stmt3 !== NULL) {
        $rows3 = sqlsrv_has_rows($stmt3);
        
        if ($rows3 === true) {

$Recuento3 = array();
while( $row3 = sqlsrv_fetch_array( $stmt3, SQLSRV_FETCH_NUMERIC) ) {
      array_push($Recuento3, $row3[1]);
}
        } 
    }

?>



<div class="row">
   <div class="col-sm-6" >
      <div class="card shadow" >
         <div class="card-header" id="PrsTutXTiempo">
            <center><h4 class="m-0 font-weight-bold text-primary">Prescripciones y Tutelas por los ultimos 12 meses</h4></center>
         </div>
         <div class="card-body" >
               <canvas id="myChart"></canvas>
         </div>
      </div>
   </div>
   <div class="col-sm-6" >
      <div class="card shadow" >
         <div class="card-header" id="PrsTutXTiempo">
            <center><h4 class="m-0 font-weight-bold text-primary">Total Prescripciones y Tutelas en el año</h4></center>
         </div>
         <div class="card-body" >
               <canvas id="myChart2"></canvas>
         </div>
      </div>
   </div>
</div>


  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>




<script type="text/javascript">
var Titulos = [];
var Recuento = [];

</script>
<?php

$longitud = count($Titulos);
for($i=0; $i<$longitud; $i++)
      {
     echo "<script>Titulos.push('".$Titulos[$i]."');</script>";
     echo "<script>Recuento.push('".$Recuento[$i]."');</script>";
      }
?>

<script>
var ctx = document.getElementById('myChart');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {datasets: [{
            label: 'Prescripciones',
            data: [Recuento[12],Recuento[13],Recuento[14],Recuento[15],Recuento[16],Recuento[17],Recuento[18],Recuento[19],Recuento[20],Recuento[21],Recuento[22],Recuento[23]],
         
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)'
            ],
            borderWidth: 3,
            order: 1
        }, {
            label: 'Tutelas',
            data: [Recuento[0],Recuento[1],Recuento[2],Recuento[3],Recuento[4],Recuento[5],Recuento[6],Recuento[7],Recuento[8],Recuento[9],Recuento[10],Recuento[11]],
            backgroundColor: [
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)'
            ],
            borderWidth: 3,
            type: 'bar',
            order: 2
        }],
        labels: [Titulos[0],Titulos[1],Titulos[2],Titulos[3],Titulos[4],Titulos[5],Titulos[6],Titulos[7],Titulos[8],Titulos[9],Titulos[10],Titulos[11]]},
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>







<script type="text/javascript">
var Recuento3 = [];
</script>
<?php

$longitud = count($Recuento3);
for($i=0; $i<$longitud; $i++)
      {
     echo "<script>Recuento3.push('".$Recuento3[$i]."');</script>";
      }
?>


<script>
var ctx = document.getElementById('myChart2');

var myChart2 = new Chart(ctx, {
    type: 'doughnut',
    data: {datasets: [{
            data: [Recuento3[1],Recuento3[0]],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)'
            ],
            borderWidth: 3,
            order: 1
        }],
        labels: ['Prescripciones '+Recuento3[1],'Tutelas '+Recuento3[0]]},
    options: {}
});
</script>
