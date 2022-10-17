<?php
date_default_timezone_set ('America/Mexico_City');
@session_start();
require_once ('conexion.php');
class altaComplemento_class {

function accionesComplemento() {
    //arreglo
    $datosCmb = $this->GETPOST();
    //llamar las funciones 
    if (array_key_exists('altaComplemento', $datosCmb)) {
         $resp= $this->altaComplemento();
    }
}

// funcion para dar de alta registro
function altaComplemento() {
$con=conexion();
$arrayDatos = $this->GETPOST();
// creo el numero de proveedor
$idUsuario=$_SESSION['idUsuario'];
// OBTENGO EL NOMBRE DEL USUARIO
$queryUsuario="SELECT * FROM usuarios where idUsuario=$idUsuario";
$res=mysqli_query($con, $queryUsuario);
$extraidoUsuario=mysqli_fetch_array($res);
$nombreUsuario=$extraidoUsuario['usuario'];
$hoy=date('Y-m-d H:i:s');

//valido sino regreso
if ($arrayDatos['montoComplemento']>$arrayDatos['montoPendiente']) {?>
<script type="text/javascript">
             window.location="agregarComprobantePago?do=2&idServicio=<?php echo $arrayDatos['idServicio'] ?>";
        </script>

<?php 
exit();
}

if ($arrayDatos['montoPendiente']==$arrayDatos['montoComplemento']) {
        $query="UPDATE servicios SET estatus=13 where idServicio=".$arrayDatos['idServicio']." ";
	    mysqli_query($con,$query);
}
        $insertarNota="INSERT INTO servicioscomplementos (idServicio, idFactura, tipoComplemento, montoComplemento, idUsuario, fechaCarga, estatus) VALUES (".$arrayDatos['idServicio'].",0,'".$arrayDatos['tipoComplemento']."','".$arrayDatos['montoComplemento']."',".$idUsuario.",'".$hoy."',1)";
            $crea=mysqli_query($con,$insertarNota);           

        // creo la nota de quien autorizo la factura
        $insertarNota="INSERT INTO notasautomaticas (idServicio,nota,fechaAlta,estatus) VALUES (".$arrayDatos['idServicio'].",'SE AGREGA COMPLEMENTO POR ".$nombreUsuario." ','".$hoy."',1)";
            mysqli_query($con,$insertarNota);

        if (!$crea) { ?>
        <script type="text/javascript">
            window.location = "detalleDeServicio?do=2&idServicio=<?php echo $arrayDatos['idServicio'] ?>&idBeneficiario=<?php echo $arrayDatos['idBeneficiario'] ?>";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
             window.location="detalleDeServicio?do=1&idServicio=<?php echo $arrayDatos['idServicio'] ?>&idBeneficiario=<?php echo $arrayDatos['idBeneficiario'] ?>";
        </script>
        <?php }
}

function GETPOST() {
        $datos_getpost = array();
        if ($_POST) {
            if (array_key_exists('altaComplemento', $_POST)) {
                $datos_getpost['altaComplemento'] = $_POST['altaComplemento'];
            }
            if (array_key_exists('idServicio', $_POST)) {
                $datos_getpost['idServicio'] = $_POST['idServicio'];
            }
            if (array_key_exists('idBeneficiario', $_POST)) {
                $datos_getpost['idBeneficiario'] = $_POST['idBeneficiario'];
            }
            if (array_key_exists('montoPendiente', $_POST)) {
                $datos_getpost['montoPendiente'] =  $_POST['montoPendiente'];
            } 
            if (array_key_exists('tipoComplemento', $_POST)) {
                $datos_getpost['tipoComplemento'] =  $_POST['tipoComplemento'];
            } 
            if (array_key_exists('montoComplemento', $_POST)) {
                $datos_getpost['montoComplemento'] =  $_POST['montoComplemento'];
            }          
        } else if ($_GET) {
            
        }
        return $datos_getpost;
}
}

?>