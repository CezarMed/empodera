<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporteFacturasPaquetePagos.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html>
<html>
<head>
    <title>contenido</title>
    <meta charset="UTF-8">
    <style type='text/css'>
    body {
    margin: 0;
    padding: 0;
    background-color: #fff;
    font: 12pt 'Calibri';
    color: rgb(0, 0, 0);
    font-size: 12px;
    }
</style>
</head>
<body>
<?php 
error_reporting(0);
@session_start();
//creo la conexion
require_once ('class/conexion.php');
$con=conexion();
$grupo=$_GET['grupo'];
$idGrupo=$_GET['idGrupo'];
function Convertir($Fecha){ 
    $fecha_de_nacimiento = $Fecha; 
    $fecha_actual = date ("Y-m-d"); 
    // separamos en partes las fechas 
    $array_nacimiento=explode("-", $fecha_de_nacimiento ); 
    $array_actual=explode("-", $fecha_actual ); 
    $anos =  $array_actual[0] - $array_nacimiento[0]; // calculamos años 
    $meses = $array_actual[1] - $array_nacimiento[1]; // calculamos meses 
    $dias =  $array_actual[2] - $array_nacimiento[2]; // calculamos días 
    //ajuste de posible negativo en $días 
    if ($dias < 0) 
    { 
        --$meses; 
        //ahora hay que sumar a $dias los dias que tiene el mes anterior de la fecha actual 
        switch ($array_actual[1]) { 
               case 1:     $dias_mes_anterior=31; break; 
               case 2:     $dias_mes_anterior=31; break; 
               case 3:  
                    if (bisiesto($array_actual[0])) 
                    { 
                        $dias_mes_anterior=29; break; 
                    } else { 
                        $dias_mes_anterior=28; break; 
                    } 
               case 4:     $dias_mes_anterior=31; break; 
               case 5:     $dias_mes_anterior=30; break; 
               case 6:     $dias_mes_anterior=31; break; 
               case 7:     $dias_mes_anterior=30; break; 
               case 8:     $dias_mes_anterior=31; break; 
               case 9:     $dias_mes_anterior=31; break; 
               case 10:     $dias_mes_anterior=30; break; 
               case 11:     $dias_mes_anterior=31; break; 
               case 12:     $dias_mes_anterior=30; break; 
        } 
        $dias=$dias + $dias_mes_anterior; 
    } 
    //ajuste de posible negativo en $meses 
    if ($meses < 0) 
    { 
        --$anos; 
        $meses=$meses + 12; 
    } 
    return($anos."*-*".$meses."*-*".$dias); 
}
?>
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th>ID Factura</th>
                      <th>Folio CFDI</th>
                      <th>RFC Emisor</th>
                      <th>Nombre Emisor</th>
                      <th>Emitido</th>
                      <th>Timbrado</th>
                      <th>Importe Factura</th>
                      <th>Estatus</th>
                      <th>Días Timbrado</th>
                      <th>Días Carga</th>
                      <th>No. Servicio</th>
                      <th>ID Proveedor</th>
                      <th>UUID</th>
                      <th>Imp. Trasladados</th>
                      <th>Imp. Retenidos</th>
                      <th>Otros. Retenidos</th>
                      <th>Paquete</th>
                      <th>Fecha de Pago</th>
                      <th>Referencia de Pago</th>
                      <th>Fecha de carga</th>
                      
                      
                  </tr>
              </thead>
              <tbody>
                <?php 
                  $query="SELECT gf.idGruposFacturas, gf.idFactura, s.folioEmpodera, b.nombreBeneficiario, fxml.tipoPagoFactura, s.servicio, tef.nombreEstatus, u.usuario, s.monto, fxml.nombreEmisor, fxml.rfcEmisor, fxml.FechaFactura, fxml.Folio, fxml.UUID, fxml.moneda, fxml.Total, imp.TotalImpuestosTrasladados, isr.TotalImpuestosRetenidos, reg.idBanco, reg.cuentaBancaria, reg.cuentaClabe, reg.idRegistro, gf.grupo, gf.idGrupoConsecutivo, fxml.fechaTimbrado, fxml.fechaSubeFactura from gruposfacturas gf 
                  inner join facturasdatosxml fxml on fxml.idFacturas=gf.idFactura
                  inner join serviciosfacturasproveedor sfp on sfp.idFactura=fxml.idFacturas
                  inner join servicios s on s.idServicio=sfp.idServicio
                  inner join beneficiarios b on b.idBenefeciario=s.idBeneficiario
                  inner join tipoestatusfacturas tef on tef.idEstatus=gf.estatus
                  inner join usuarios u on u.idUsuario=s.idUsuario
                  left join facturasdatosxmlimpuestostotales imp on imp.UUID=fxml.UUID
                  left join facturasdatosxmlretencionestotales isr on isr.UUID=fxml.UUID
                  left join registros reg on reg.rfcCedula=fxml.rfcEmisor
                  where gf.grupo='$grupo' and gf.idGrupoConsecutivo=$idGrupo and gf.estatus=7";
                  $res = mysqli_query($con,$query);
                      while ($registro = mysqli_fetch_array($res)) {
                        $verdatos=$registro[0]."|".
                                  $registro[1];
                                  $fechaentrega=$registro['fechaTimbrado'];
                              $rest = substr($fechaentrega,0,10);
                              $datos2=Convertir($rest);
                              $datoss=explode('*-*',$datos2);
                              // tiempo desde que se subio
                              $fechaentrega2=$registro['fechaSubeFactura'];
                              $rest2 = substr($fechaentrega2,0,10);                              
                              $datos22=Convertir($rest2);
                              $datoss2=explode('*-*',$datos22);
                  ?>
                      <tr>
                      <td><?php echo $registro['idFactura'] ?></td>
                      <td><?php echo $registro['Folio'] ?></td>
                      <td><?php echo $registro['rfcEmisor'] ?></td>
                      <td><?php echo $registro['nombreEmisor'] ?></td>
                      <td><?php echo $registro['FechaFactura'] ?></td>
                      <td><?php echo $registro['fechaTimbrado'] ?></td>
                      <td>$<?php echo $registro['Total'] ?></td>
                      <td><?php echo $registro['nombreEstatus'] ?></td>
                      <td><?php echo $datoss[0] ?>años <?php echo $datoss[1] ?>meses <?php echo $datoss[2] ?>dias</td>
                      <td><?php echo $datoss2[0] ?>años <?php echo $datoss2[1] ?>meses <?php echo $datoss2[2] ?>dias</td>

                      <td><?php echo $registro['folioEmpodera'] ?></td>
                      <td><?php echo $registro['idRegistro'] ?></td>
                      <td><?php echo $registro['UUID'] ?></td>
                      <td>$<?php echo $registro['TotalImpuestosTrasladados'] ?></td>
                      <td>$<?php echo $registro['TotalImpuestosRetenidos'] ?></td>
                      <td></td>
                      <td><?php echo $registro['grupo'] ?>_<?php echo $registro['idGrupoConsecutivo'] ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                  </tr>
                <?php } ?>
                  
              </tbody>
          </table>
</head>
<body>
