<?php
date_default_timezone_set ('America/Mexico_City');
@session_start();
require_once ('conexion.php');
class editaMedicamento_class {

function accionesMedicamentos() {
    //arreglo
    $datosCmb = $this->GETPOST();
    //llamar las funciones 
    if (array_key_exists('actualizaMedicamentos', $datosCmb)) {
         $resp= $this->actualizaMedicamentos();
    }
    if (array_key_exists('actualizaMedicamentosCoti', $datosCmb)) {
         $resp= $this->actualizaMedicamentosCoti();
    }
}

// funcion para dar de alta registro
function actualizaMedicamentos() {
$con=conexion();
$arrayDatos = $this->GETPOST();
// creo el numero de proveedor
$idUsuario=$_SESSION['idUsuario'];
$hoy=date('Y-m-d H:i:s');
$idServicio=$arrayDatos['idServicio'];
$idProveedor=$arrayDatos['proveedoranterior'];


            $number = count($_POST["idMedicamentoSolicitud"]);
            if($number >= 1)
            {
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["idMedicamentoSolicitud"][$i]!= ''))
            {
                $monto=$_POST["costo"][$i];
                $monto = str_replace( ',', '', $monto );
                $monto = str_replace( '$', '', $monto );
                $monto2=$_POST["costototal"][$i];
                $monto2 = str_replace( ',', '', $monto2 );
                $monto2 = str_replace( '$', '', $monto2 );

                $sqlUpdate = "UPDATE solicitudcotizacionesmedicamentos SET costo='".$monto."', costototal='".$monto2."', elegido='".$_POST["elegido"][$i]."' where idMedicamentoSolicitud='".$_POST["idMedicamentoSolicitud"][$i]."'";
                    mysqli_query($con, $sqlUpdate);
                $sqlMedicamento="SELECT * from solicitudcotizacionesmedicamentos where idMedicamentoSolicitud='".$_POST["idMedicamentoSolicitud"][$i]."'";
                $res=mysqli_query($con,$sqlMedicamento);
                $resultado=mysqli_fetch_array($res);
                $idMedicamento=$resultado['idProductoSolicitud'];

                // actualizo el medicamento
                $sqlUpdateMedicamento = "UPDATE medicamentossolicitados SET estatus='".$_POST["elegido"][$i]."' where idMedicamento='".$idMedicamento."'";
                mysqli_query($con,$sqlUpdateMedicamento);


            }
            }
            }

            $number = count($_POST["idMedicamento"]);
            if($number >= 1)
            {
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["idMedicamento"][$i]!= ''))
            {
                $sqlUpdate = "UPDATE medicamentossolicitados SET medicamento='".$_POST["nombre"][$i]."', gramaje='".$_POST["gramaje"][$i]."', presentacion='".$_POST["presentacion"][$i]."', cantidad='".$_POST["cantidad"][$i]."' where idMedicamento='".$_POST["idMedicamento"][$i]."'";
                    mysqli_query($con, $sqlUpdate);
            }
            }
            }

        // pasos para generar la asignacion del servicio de medicamentos en tabla servicioscerradosproveedor
        $array=$_POST["idMedicamentoSolicitud"];
        $separado = implode(',', $array);
        $sql11 = "SELECT s.folioEmpodera, sc.idProveedor,  sum(scm.costototal) total, sm.idServicio, sm.idBeneficiario FROM solicitudcotizacionesmedicamentos scm
                   INNER JOIN solicitudcotizaciones sc ON sc.idCotizacion=scm.idCotizacion
                   inner join solicitudmedicamentos sm ON sm.idSolicitudMedicamentos=sc.idSolicitudMedicamentos
                   inner join servicios s ON s.idServicio=sm.idServicio
                   where scm.idMedicamentoSolicitud in (".$separado.") GROUP BY sc.idProveedor order by total DESC";
        $ress=mysqli_query($con, $sql11);
        $registros1=mysqli_fetch_array($ress);
        $idProveedor=$registros1['idProveedor'];
        $servicioprincipal=$registros1['idServicio'];
        $idServicio=$registros1['idServicio'];
        $folioServicio=$registros1['folioEmpodera'];
        $idServiciop=$registros1['idServicio'];
        $idBeneficiario=$registros1['idBeneficiario'];
        $montoservicio=$registros1['total'];
        $mensaje='MEDICAMENTOS PRINCIPALES';

        // ACTUALIZO EL MONTO PARA EL SERVICIO PRINCIPAL
        $actualizaMontoServicio = "UPDATE servicios SET monto=$montoservicio where idServicio=$idServicio";
        $resactualizamontoservicio=mysqli_query($con, $actualizaMontoServicio);

if (!$crea) { ?>
<script type="text/javascript">
 window.location="asignarProveedorServicio?idBeneficiario=<?php echo $arrayDatos['idBeneficiario'] ?>&idServicio=<?php echo $arrayDatos['idServicio'] ?>&idCuenta=<?php echo $arrayDatos['idCuenta'] ?>&idSolicitudMedicamentos=<?php echo $arrayDatos['idSolicitudMedicamentos'] ?>&do=1";</script> 
<?php } else { ?>
<script type="text/javascript">
 window.location="asignarProveedorServicio?idBeneficiario=<?php echo $arrayDatos['idBeneficiario'] ?>&idServicio=<?php echo $arrayDatos['idServicio'] ?>&idCuenta=<?php echo $arrayDatos['idCuenta'] ?>&idSolicitudMedicamentos=<?php echo $arrayDatos['idSolicitudMedicamentos'] ?>&do=2";
</script>
<?php } }

// funcion para dar de alta registro
function actualizaMedicamentosCoti() {
$con=conexion();
$arrayDatos = $this->GETPOST();
// creo el numero de proveedor
$idUsuario=$_SESSION['idUsuario'];
$hoy=date('Y-m-d H:i:s');
$idServicio=$arrayDatos['idServicio'];
$idProveedor=$arrayDatos['proveedoranterior'];


            $number = count($_POST["idMedicamentoSolicitud"]);
            if($number >= 1)
            {
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["idMedicamentoSolicitud"][$i]!= ''))
            {
                $sqlUpdate = "UPDATE solicitudcotizacionesmedicamentos SET costo='".$_POST["costo"][$i]."', costototal='".$_POST["costototal"][$i]."', elegido='".$_POST["elegido"][$i]."' where idMedicamentoSolicitud='".$_POST["idMedicamentoSolicitud"][$i]."'";
                    mysqli_query($con, $sqlUpdate);
            }
            }
            }

            $number = count($_POST["idMedicamento"]);
            if($number >= 1)
            {
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["idMedicamento"][$i]!= ''))
            {
                $sqlUpdate = "UPDATE medicamentossolicitados SET medicamento='".$_POST["nombre"][$i]."', gramaje='".$_POST["gramaje"][$i]."', presentacion='".$_POST["presentacion"][$i]."', cantidad='".$_POST["cantidad"][$i]."' where idMedicamento='".$_POST["idMedicamento"][$i]."'";
                    mysqli_query($con, $sqlUpdate);
            }
            }
            }

if (!$crea) { ?>
<script type="text/javascript">
 window.location="editarCotizacioncostos?idServicio=242&idProveedor=61&do=1";</script> 
<?php } else { ?>
<script type="text/javascript">
  window.location="editarCotizacioncostos?idServicio=242&idProveedor=61&do=2";
</script>
<?php } }



function GETPOST() {
        $datos_getpost = array();
        if ($_POST) {
            if (array_key_exists('actualizaMedicamentos', $_POST)) {
                $datos_getpost['actualizaMedicamentos'] = $_POST['actualizaMedicamentos'];
            }
            if (array_key_exists('actualizaMedicamentosCoti', $_POST)) {
                $datos_getpost['actualizaMedicamentosCoti'] = $_POST['actualizaMedicamentosCoti'];
            }
            if (array_key_exists('idBeneficiario', $_POST)) {
                $datos_getpost['idBeneficiario'] =  $_POST['idBeneficiario'];
            }
            if (array_key_exists('idServicio', $_POST)) {
                $datos_getpost['idServicio'] =  $_POST['idServicio'];
            }
            if (array_key_exists('proveedoranterior', $_POST)) {
                $datos_getpost['proveedoranterior'] =  $_POST['proveedoranterior'];
            }
            if (array_key_exists('idSolicitudMedicamentos', $_POST)) {
                $datos_getpost['idSolicitudMedicamentos'] =  $_POST['idSolicitudMedicamentos'];
            }

        } else if ($_GET) {
            
        }
        return $datos_getpost;
}

}
?>