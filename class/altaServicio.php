<?php
date_default_timezone_set ('America/Mexico_City');
@session_start();
require_once ('conexion.php');
class Altaservicio_class {

function accionesServicios() {
    //arreglo
    $datosCmb = $this->GETPOST();
    //llamar las funciones 
    if (array_key_exists('altaServicio', $datosCmb)) {
         $resp= $this->altaServicio();
    }
}

// funcion para dar de alta servicio
function altaServicio() {
$con=conexion();
$arrayDatos = $this->GETPOST();
// creo el numero de proveedor
$idUsuario=$_SESSION['idUsuario'];
$hoy=date('Y-m-d H:i:s');

function generarCodigo($longitud) {
$key = '';
$pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
$max = strlen($pattern)-1;
for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
return $key;
}
$codigo=generarCodigo(8);

$query="INSERT INTO servicios (folioServicio,idCuenta,idBeneficiario,servicio,observaciones,monto,fechaAlta,idUsuario,servicioprincipal,estatus)
        values 
        ('" . $codigo ."'," . $arrayDatos['idCuenta'] ."," . $arrayDatos['idBeneficiario'] .",'" . $arrayDatos['servicio'] ."','" . $arrayDatos['observaciones'] ."',0,'" . $hoy ."',". $idUsuario .",0,1)";
            $crea=mysqli_query($con,$query);
            $queryM="SELECT * from servicios where folioServicio='".$codigo."'";
            $result=mysqli_query($con,$queryM);
            $extraido=mysqli_fetch_array($result);
            $idServicio=$extraido['idServicio'];
            if ($idServicio>=0 && $idServicio<=9) {$ceros='00000';}
            if ($idServicio>=10 && $idServicio<=99) {$ceros='0000';}
            if ($idServicio>=100 && $idServicio<=999) {$ceros='000';} 
            if ($idServicio>=1000 && $idServicio<=9999) {$ceros='00';}
            if ($idServicio>=10000 && $idServicio<=99999) {$ceros='0';}                                   
            
        $ano=date('Y');
        $anonumeros=substr($ano,2, 2);
        $folioEmpodera=$anonumeros.''.$ceros.''.$idServicio;
        $query3="UPDATE servicios set folioEmpodera='$folioEmpodera' where idServicio=$idServicio";
        mysqli_query($con,$query3);

        //agrego nota automatica de respuesta
        $insertarNota="INSERT INTO notasautomaticas (idServicio,idUsuario,nota,fechaAlta,estatus) VALUES (".$idServicio.",".$idUsuario.",'SE DA DE ALTA EL SERVICIO','".$hoy."',1)";
        mysqli_query($con,$insertarNota); 

        // insertamos la informacion enviada por el formulario
        if ($arrayDatos['servicio']!='MEDICAMENTOS'){
        $sql1="INSERT INTO servicioscerradosproveedor (folioCierre, idServicio, idBeneficiario, fechaAsignacion, fechaServicio, proveedorname, contenidonota, idUsuario, fechaRegistro, estatus) 
        VALUES
        ('SIN ASIGNAR',".$idServicio.",".$arrayDatos['idBeneficiario'].",'".$hoy."','".$hoy."',108,'SIN ASIGNAR',".$idUsuario.",'".$hoy."',1)";
        mysqli_query($con, $sql1);
        }




        if (!$crea) { ?>
        <script type="text/javascript">
             window.location = "agregarServiciosBeneficiario?do=2&idBeneficiario=<?php echo $arrayDatos['idBeneficiario'] ?>&idCuenta=<?php echo $arrayDatos['idCuenta'] ?>";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
              window.location="agregarServiciosBeneficiario?do=1&idBeneficiario=<?php echo $arrayDatos['idBeneficiario'] ?>&idCuenta=<?php echo $arrayDatos['idCuenta']?>";
        </script>
        <?php }
}

function GETPOST() {
        $datos_getpost = array();
        if ($_POST) {
            if (array_key_exists('altaServicio', $_POST)) {
                $datos_getpost['altaServicio'] = $_POST['altaServicio'];
            }
            if (array_key_exists('idCuenta', $_POST)) {
                $datos_getpost['idCuenta'] =  $_POST['idCuenta'];
            }
            if (array_key_exists('idBeneficiario', $_POST)) {
                $datos_getpost['idBeneficiario'] =  $_POST['idBeneficiario'];
            }
            if (array_key_exists('servicio', $_POST)) {
                $datos_getpost['servicio'] =  $_POST['servicio'];
            }
            if (array_key_exists('observaciones', $_POST)) {
                $datos_getpost['observaciones'] =  $_POST['observaciones'];
            }      
        } else if ($_GET) {
            
        }
        return $datos_getpost;
}

}
?>