<?php
date_default_timezone_set ('America/Mexico_City');
@session_start();
//creo la conexion
require_once ('class/conexion.php');
$con=conexion();

//recibo los datos por POST
$idSolicitudMedicamentos=$_POST['idSolicitudMedicamentos2'];
$idServicio=$_POST['idServicio'];
$idProveedor=$_POST['proveedor2'];
// post para direccionar
// $idProveedor=$_POST['idProveedor'];
$idUsuario=$_SESSION['idUsuario'];
$hoy=date('Y-m-d H:i:s');

//creo la inserción de solicitud de cotización
$queryInsertaCotizacion="INSERT INTO solicitudcotizaciones (idSolicitudMedicamentos, idProveedor, idUsuario, fechaSolicitud, estatus)
values 
(". $idSolicitudMedicamentos.", ". $idProveedor.", ".$idUsuario.", '" . $hoy ."', 14)";
$creaCotizacion=mysqli_query($con,$queryInsertaCotizacion);

            // obtengo el rfc del proveedor
        $query="SELECT * FROM registros where idRegistro=$idProveedor";
        $res = mysqli_query($con,$query);
        $registro = mysqli_fetch_array($res);
        $rfcCedula=$registro['rfcCedula'];
        $nombreComercial=$registro['nombreComercial'];
        $siglasProveedor=substr($rfcCedula,0,3);
        $folioUnico=$siglas.''.$folioServicio.'-'.$siglasProveedor;

        // creo la nota de solicitud de medicamentos
        $insertarNota="INSERT INTO notasautomaticas (idServicio,nota,fechaAlta,estatus) VALUES (".$idServicio.",'SE SOLICTA COTIZACION AL PROVEEDOR ".$nombreComercial." CON PROCESO DE SEGUNDO CICLO','".$hoy."',1)";
        mysqli_query($con,$insertarNota);



?>
<script type="text/javascript">
              window.location="detalleDeServicio?idBeneficiario=1406&idServicio=290&idCuenta=134&do=1";
</script>

