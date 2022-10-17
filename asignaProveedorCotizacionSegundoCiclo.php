<?php
session_start();
date_default_timezone_set ('America/Mexico_City');
include('class/conexion.php');
//funcion para llenar los modulos dependientes de estados

  $conn=conexion();
  $hoy=date('Y-m-d H:i:s');
  $idUsuario=$_SESSION['idUsuario'];
  $idServicio=$_POST['idServicio'];
  $idCierre=$_POST['idCierre'];
  $idProveedor=$_POST['idProveedor'];
  $idCotizacion=$_POST['idCotizacion'];
  $idCotizacionAnterior=$_POST['idCotizacionAnterior'];


  if ($idProveedor!=''){
  $query="UPDATE servicioscerradosproveedor SET proveedorname=$idProveedor where idcierre=$idCierre";
  $row=mysqli_query($conn,$query);
  }

  if ($idCotizacion!=''){
  $query="UPDATE solicitudcotizaciones SET fechaEleccion='$hoy', eleccionPor='Costo', idUsuarioEligio=$idUsuario where idCotizacion=$idCotizacion";
  $row=mysqli_query($conn,$query);
  }

  if ($idCotizacionAnterior!=''){
  $query="UPDATE solicitudcotizacionesmedicamentos SET elegido='0' where idCotizacion=$idCotizacionAnterior";
  $row=mysqli_query($conn,$query);
  }


            $number = count($_POST["idMedicamentoSolicitud"]);
            if($number >= 1)
            {
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["idMedicamentoSolicitud"][$i]!= ''))
            { 

                $sql11 = "UPDATE solicitudcotizacionesmedicamentos SET elegido=1, estatus=3 where idMedicamentoSolicitud=".$_POST["idMedicamentoSolicitud"][$i]."";
               $crea= mysqli_query($conn, $sql11);


            }
            }
            }


            // obtengo el rfc del proveedor
        $query="SELECT * FROM registros where idRegistro=$idProveedor";
        $res = mysqli_query($conn,$query);
        $registro = mysqli_fetch_array($res);
        $rfcCedula=$registro['rfcCedula'];
        $nombreComercial=$registro['nombreComercial'];
        $siglasProveedor=substr($rfcCedula,0,3);
        $folioUnico=$siglas.''.$folioServicio.'-'.$siglasProveedor;

        // creo la nota de solicitud de medicamentos
        $insertarNota="INSERT INTO notasautomaticas (idServicio,nota,fechaAlta,estatus) VALUES (".$idServicio.",'SE ASIGNA SERVICIO AL PROVEEDOR ".$nombreComercial." CON PROCESO DE SEGUNDO CICLO','".$hoy."',1)";
        mysqli_query($conn,$insertarNota);

        // pasos para generar la asignacion del servicio de medicamentos en tabla servicioscerradosproveedor
        $array=$_POST["activar"];
        $separado = implode(',', $array);
        $sql11 = "SELECT s.folioEmpodera, sc.idProveedor,  sum(scm.costototal) total, sm.idServicio, sm.idBeneficiario FROM solicitudcotizacionesmedicamentos scm
                   INNER JOIN solicitudcotizaciones sc ON sc.idCotizacion=scm.idCotizacion
                   inner join solicitudmedicamentos sm ON sm.idSolicitudMedicamentos=sc.idSolicitudMedicamentos
                   inner join servicios s ON s.idServicio=sm.idServicio
                   where scm.idMedicamentoSolicitud in (".$separado.") GROUP BY sc.idProveedor order by total DESC";
        $ress=mysqli_query($conn, $sql11);
        $registros1=mysqli_fetch_array($ress);
        $idServicio=$registros1['idServicio'];
        $montoservicio=$registros1['total'];


// ACTUALIZO EL MONTO PARA EL SERVICIO PRINCIPAL
$actualizaMontoServicio = "UPDATE servicios SET monto=$montoservicio where idServicio=$idServicio";
$resactualizamontoservicio=mysqli_query($conn, $actualizaMontoServicio);



?>
<script type="text/javascript">
  window.location="responderReCotizacionesExt?do=1";
</script>
