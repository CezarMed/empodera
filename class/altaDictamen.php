<?php
date_default_timezone_set ('America/Mexico_City');
@session_start();
require_once ('conexion.php');
class Altadictamen_class {

function accionesDictamen() {
    //arreglo
    $datosCmb = $this->GETPOST();
    //llamar las funciones 
    if (array_key_exists('altaDictamen', $datosCmb)) {
         $resp= $this->altaDictamen();
    }
}

// funcion para dar de alta registro
function altaDictamen() {
$con=conexion();
$arrayDatos = $this->GETPOST();
// print_r($_POST);
// creo el numero de proveedor
$idUsuaio=$_SESSION['idUsuario'];
// OBTENGO EL NOMBRE DEL USUARIO
$queryUsuario="SELECT * FROM usuarios where idUsuario=$idUsuaio";
$res=mysqli_query($con, $queryUsuario);
$extraidoUsuario=mysqli_fetch_array($res);
$nombreUsuario=$extraidoUsuario['usuario'];
$idServicio=$arrayDatos['idServicio'];
// OBTENGO EL TIPO DE SERVICIO
$queryServicio="SELECT * FROM servicios where idServicio=$idServicio";
$resServicio=mysqli_query($con, $queryServicio);
$extraidoServicio=mysqli_fetch_array($resServicio);
$tipoServicio=$extraidoServicio['servicio'];
$hoy=date('Y-m-d H:i:s');


// agrego la nota automatica para la carga de factura
$insertarNota2="INSERT INTO notasautomaticas (idServicio,nota,fechaAlta,estatus) VALUES (".$arrayDatos['idServicio'].",'SE GENERA DICTAMEN POR ".$nombreUsuario."','".$hoy."',1)";
mysqli_query($con,$insertarNota2);

$query2="UPDATE servicios SET montoFacturable=".$arrayDatos['totalFacturar']." where idServicio=$idServicio";
mysqli_query($con,$query2);

if ($tipoServicio!='MEDICAMENTOS') {
  $query3="UPDATE servicios SET estatus=9 where idServicio=$idServicio";
  mysqli_query($con,$query3);
}

// creo el registro del dictamen
$queryDictamen="INSERT INTO dictamenesgenerados (idServicio, observaciones, idUsuarioGeneraDictamen, fechaGeneraDictamen, estatus)
        values 
        (" . $arrayDatos['idServicio'] .", '" . $arrayDatos['observaciones'] ."', ". $idUsuaio .",'" . $hoy ."',1)";
$crea=mysqli_query($con,$queryDictamen);

        if (!$crea) { ?>
        <script type="text/javascript">
             window.location = "detalleDeServicio?do=2&idBeneficiario=<?php echo $arrayDatos['idBeneficiario'] ?>&idServicio=<?php echo $arrayDatos['idServicio'] ?>";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
              Window.location="detalleDeServicio?do=1&idBeneficiario=<?php echo $arrayDatos['idBeneficiario'] ?>&idServicio=<?php echo $arrayDatos['idServicio'] ?>";
        </script>
        <?php }
}

function GETPOST() {
        $datos_getpost = array();
        if ($_POST) {
            if (array_key_exists('altaDictamen', $_POST)) {
                $datos_getpost['altaDictamen'] = $_POST['altaDictamen'];
            }
            if (array_key_exists('idServicio', $_POST)) {
                $datos_getpost['idServicio'] =  $_POST['idServicio'];
            }
            if (array_key_exists('idBeneficiario', $_POST)) {
                $datos_getpost['idBeneficiario'] =  $_POST['idBeneficiario'];
            }
            if (array_key_exists('observaciones', $_POST)) {
                $datos_getpost['observaciones'] =  $_POST['observaciones'];
            }
            if (array_key_exists('totalFacturar', $_POST)) {
                $datos_getpost['totalFacturar'] =  $_POST['totalFacturar'];
            }        
        } else if ($_GET) {
            
        }
        return $datos_getpost;
}
}
?>