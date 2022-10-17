<?php
date_default_timezone_set ('America/Mexico_City');
@session_start();
require_once ('conexion.php');
class respondeOrdenCompra_class {

function accionesOrdenCompra() {
    //arreglo
    $datosCmb = $this->GETPOST();
    //llamar las funciones 
    if (array_key_exists('responderOrdenCompra', $datosCmb)) {
         $resp= $this->responderOrdenCompra();
    }
}

// funcion para actualizar los datos de cotizacion
function responderOrdenCompra() {
$con=conexion();
$arrayDatos = $this->GETPOST();

function generarCodigo($longitud) {
$key = '';
$pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
$max = strlen($pattern)-1;
for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
return $key;
}


if ($_POST['recotizacion']=='si') {
    $number = count($_POST["idMedicamentoSolicitud"]);
    if($number >= 1)
        {
    for($i=0; $i<$number; $i++)
        {
    if(trim($_POST["idMedicamentoSolicitud"][$i]!= ''))
        {
     // Actualizamos el precio y la fecha de los medicamentos del proveedor
        $sql1 = "UPDATE solicitudcotizacionesmedicamentos SET costo='".$_POST["costo"][$i]."', costototal='".$_POST['costototal'][$i]."', estatus=80 where idMedicamentoSolicitud=".$_POST["idMedicamentoSolicitud"][$i]."";
        mysqli_query($con, $sql1);

        $query="INSERT INTO actualizacioncotizacion (idMedicamentoSolicitud, idcotizacion, fechaEnvio, estatus)
        values 
        (".$_POST["idMedicamentoSolicitud"][$i].", " . $idCotizacion .", '" . $hoy ."',1)";
        $crea=mysqli_query($con,$query);
        }
        }
        }
?>
<script type="text/javascript">
              window.location = "responderOrdenesDeCompra?do=8";
        </script> 
<?php } else {

$idUsuario=$_SESSION['idUsuario'];
$hoy=date('Y-m-d H:i:s');
$idBeneficiario=$arrayDatos['idBeneficiario'];
$idCotizacion=$arrayDatos['idCotizacion'];
$idServicio=$arrayDatos['idServicio'];
$fechaEntregaMed=$arrayDatos['fechaEntregaMed'];
$finalizar=$arrayDatos['finalizar'];
$proveedorantes=$arrayDatos['proveedor'];


     foreach($_FILES["archivo"]['tmp_name'] as $key => $tmp_name)
    {
        //condicional si el fuchero existe
        if($_FILES["archivo"]["name"][$key]) {
            $codigoP=generarCodigo(10);
            // Nombres de archivos de temporales
            // $archivonombre=$id_unico.'-archivoticket-'.$codigoP;
            $archivonombre = $_FILES["archivo"]["name"][$key];
            $archivonombre=$codigoP.'-'.$archivonombre; 
            $fuente = $_FILES["archivo"]["tmp_name"][$key];
            $extension = end(explode(".", $_FILES['archivo']['name'][$key])); 
            
            $carpeta = 'documentosempodera/acuses/'; //Declaramos el nombre de la carpeta que guardara los archivos
            $target_path = $carpeta.'/'.$id_unico.''.$archivonombre; //indicamos la ruta de destino de los archivos
            $target_path2 = $id_unico.''.$archivonombre;
    
            if(move_uploaded_file($fuente, $target_path)) {
                $sqlArchivos="INSERT INTO archivosacuses (idServicio,archivo,fechaEntrega,idSubio,fechaSubida,estatus) values ($idServicio,'$target_path2','$fechaEntregaMed',$idUsuario,'$hoy',1)";
                $creaDoc=mysqli_query($con,$sqlArchivos);
                // echo "Los archivos $archivonombre se han cargado de forma correcta.<br>";
                } else {    
                // echo "Se ha producido un error, por favor revise los archivos e intentelo de nuevo.<br>";
            }
            
        }
    }

    $insertarNota="INSERT INTO notasautomaticas (idServicio,idUsuario,nota,fechaAlta,estatus) VALUES (".$idServicio.",".$idUsuario.",'SE AGREGA ARCHIVO ACUSE DE ENTREGA DE MEDICAMENTO DEL PROVEEDOR: ".$proveedorantes."','".$hoy."',1)";
                    $reAcuse=mysqli_query($con,$insertarNota);

    // si se finaliza el acuse
if ($finalizar=='finalizar'){
// ACTUAlizo el servicio a estatus 9 
$queryActualizaServicio = "UPDATE servicios SET estatus=9 where idServicio=$idServicio";
mysqli_query($con,$queryActualizaServicio);
// creo la nota de cierre de acuse
$insertarNota="INSERT INTO notasautomaticas (idServicio,idUsuario,nota,fechaAlta,estatus) VALUES (".$idServicio.",".$idUsuario.",'SE CIERRA ACUSE DE MEDICAMENTOS','".$hoy."',1)";
mysqli_query($con,$insertarNota);
// actualizo la cotizacion a estatus entregado
$sql12 = "UPDATE solicitudcotizaciones SET estatus=4  where idCotizacion=".$idCotizacion."";
mysqli_query($con,$sql12);
// actualizo la orden de compra a 4
// $sqlUpdateOrden="UPDATE ordenesdecompra SET estatus=4  where idOrden=".$idOrden."";
// mysqli_query($con, $sqlUpdateOrden);
}
 

        if (!$crea) { ?>
        <script type="text/javascript">
              window.location="responderOrdenesDeCompra?do=1";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
              window.location="responderOrdenesDeCompra?do=2";
        </script>
        <?php }
} 

}




function GETPOST() {
        $datos_getpost = array();
        if ($_POST) {
            if (array_key_exists('responderCotizacion', $_POST)) {
                $datos_getpost['responderCotizacion'] = $_POST['responderCotizacion'];
            }
            
            if (array_key_exists('idCotizacion', $_POST)) {
                $datos_getpost['idCotizacion'] = $_POST['idCotizacion'];
            }
            if (array_key_exists('idServicio', $_POST)) {
                $datos_getpost['idServicio'] = $_POST['idServicio'];
            }
            if (array_key_exists('idOrden', $_POST)) {
                $datos_getpost['idOrden'] = $_POST['idOrden'];
            }
            if (array_key_exists('idBeneficiario', $_POST)) {
                $datos_getpost['idBeneficiario'] = $_POST['idBeneficiario'];
            }
            if (array_key_exists('finalizar', $_POST)) {
                $datos_getpost['finalizar'] = $_POST['finalizar'];
            }
            if (array_key_exists('fechaEntregaMed', $_POST)) {
                $datos_getpost['fechaEntregaMed'] = $_POST['fechaEntregaMed'];
            }
            if (array_key_exists('proveedor', $_POST)) {
                $datos_getpost['proveedor'] = $_POST['proveedor'];
            }

                      
        } else if ($_GET) {
            
        }
        return $datos_getpost;
}
}
?>