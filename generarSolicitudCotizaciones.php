<?php
date_default_timezone_set ('America/Mexico_City');
@session_start();
//creo la conexion
require_once ('class/conexion.php');
$con=conexion();

//recibo los datos por POST
$idSolicitudMedicamentos=$_POST['idSolicitudMedicamentos'];
$idServicio=$_POST['idServicio'];
$idUsuario=$_SESSION['idUsuario'];
$hoy=date('Y-m-d H:i:s');

//actualizo el estatus del servicio
$queryActualizaServicio = "UPDATE servicios SET estatus=7 where idServicio=$idServicio";
mysqli_query($con,$queryActualizaServicio);

$number = count($_POST["idProveedor"]);
if($number >= 1)
{
for($i=0; $i<$number; $i++)
{
if(trim($_POST["idProveedor"][$i]!= ''))
{ 

$nombreComercial.='';
//creo la inserción de solicitud de cotización
$queryInsertaCotizacion="INSERT INTO solicitudcotizaciones (idSolicitudMedicamentos, idProveedor, idUsuario, fechaSolicitud, estatus)
values 
(". $idSolicitudMedicamentos.", ". $_POST["idProveedor"][$i].", ".$idUsuario.", '" . $hoy ."', 1)";
$creaCotizacion=mysqli_query($con,$queryInsertaCotizacion);

$query3 = "SELECT * from solicitudcotizaciones where idProveedor=". $_POST["idProveedor"][$i]." and idSolicitudMedicamentos=$idSolicitudMedicamentos";
$res3=mysqli_query($con,$query3);
$extraido4=mysqli_fetch_array($res3);
$idCotizacion[]=$extraido4['idCotizacion'];

$queryProveedor="SELECT * from registros where idRegistro=". $_POST["idProveedor"][$i]." ";
$resProveedor=mysqli_query($con,$queryProveedor);
$extraidoProveedor=mysqli_fetch_array($resProveedor);
$nombreComercial.=$extraidoProveedor['nombreComercial']." || ";

}
}
}

// creo la nota de solicitud de medicamentos
$insertarNota="INSERT INTO notasautomaticas (idServicio,idUsuario,nota,fechaAlta,estatus) VALUES (".$idServicio.",".$idUsuario.",'SE SOLICITAN COTIZACIONES A PROVEEDORES: ".strtoupper($nombreComercial)."','".$hoy."',1)";
mysqli_query($con,$insertarNota);

?>
<script type="text/javascript">
   window.location="impresionArchivosCotizaciones?idSolicitudMedicamentos=<?php echo $idSolicitudMedicamentos ?>";
</script>

