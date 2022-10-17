<?php
date_default_timezone_set ('America/Mexico_City');
@session_start();
require_once ('conexion.php');
class AltaCieCpt_class {

function accionesCieCpt() {
    //arreglo
    $datosCmb = $this->GETPOST();
    //llamar las funciones 
    if (array_key_exists('altaCIE', $datosCmb)) {
         $resp= $this->altaCIE();
    }
}

// funcion para dar de alta registro
function altaCIE() {
$con=conexion();
$arrayDatos = $this->GETPOST();
// creo el numero de proveedor
$idUsuaio=$_SESSION['idUsuario'];
$hoy=date('Y-m-d H:i:s');
$idBeneficiario=$arrayDatos['idBeneficiario'];
$idServicio=$arrayDatos['idServicio'];

// OBTENGO EL NOMBRE DEL USUARIO
$queryUsuario="SELECT * FROM usuarios where idUsuario=$idUsuaio";
$res=mysqli_query($con, $queryUsuario);
$extraidoUsuario=mysqli_fetch_array($res);
$nombreUsuario=$extraidoUsuario['usuario'];


            // inserto los cie10
            $number = count($_POST["cie10"]);
            if($number >= 1)
            {
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["cie10"][$i]!= ''))
            {
                // Insertamos la informacion enviada por el formulario
                $sql1="INSERT INTO datoscie (idServicio, idBeneficiario, grupocie, cie10, diagnosticocie10, idUsuario, fechaAgrega, estatus) VALUES(".$idServicio.",".$idBeneficiario.",'".$arrayDatos['grupocie']."','".$_POST["cie10"][$i]."','".$_POST["diagnosticocie10"][$i]."',".$idUsuaio.",'".$hoy."',1)";
                $crea=mysqli_query($con, $sql1);

                //agrego la nota automatica para la carga de factura
                $insertarNota2="INSERT INTO notasautomaticas (idServicio,nota,fechaAlta,estatus) VALUES (".$idServicio.",'SE AGREGA CIE POR ".$nombreUsuario."','".$hoy."',1)";
                       mysqli_query($con,$insertarNota2);
            }
            }
            }

            // inserto los cpt4
            $number = count($_POST["cpt4"]);
            if($number >= 1)
            {
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["cpt4"][$i]!= ''))
            {
                // Insertamos la informacion enviada por el formulario
                $sql1 = "INSERT INTO datoscpt (idServicio, idBeneficiario, grupocpt, cpt4, tratamientocpt4, idUsuario, fechaAgrega, estatus) VALUES(".$idServicio.",".$idBeneficiario.",'".$arrayDatos['grupocpt']."','".$_POST["cpt4"][$i]."','".$_POST["tratamientocpt"][$i]."',".$idUsuaio.",'".$hoy."',1)";
                $crea=mysqli_query($con, $sql1);

                //agrego la nota automatica para la carga de factura
                       $insertarNota2="INSERT INTO notasautomaticas (idServicio,nota,fechaAlta,estatus) VALUES (".$idServicio.",'SE AGREGA CPT POR ".$nombreUsuario."','".$hoy."',1)";
                       mysqli_query($con,$insertarNota2);
            }
            }
            }


            // inserto las consultas
            $number = count($_POST["cpt4consulta"]);
            if($number >= 1)
            {
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["cpt4consulta"][$i]!= ''))
            {
                // Insertamos la informacion enviada por el formulario
            $sql1 = "INSERT INTO datosconsultas (idServicio, idBeneficiario, tipo, grupocpt, cpt4, consultacpt4, idUsuario, fechaAgrega, estatus) VALUES(".$idServicio.",".$idBeneficiario.",'".$arrayDatos['grupocpt2']."', '".$arrayDatos['grupocpt2']."','".$_POST["cpt4consulta"][$i]."','".$_POST["tratamientocptconsulta"][$i]."',".$idUsuaio.",'".$hoy."',1)";
            $crea=mysqli_query($con, $sql1);

                // agrego la nota automatica para la carga de factura
            $insertarNota2="INSERT INTO notasautomaticas (idServicio,nota,fechaAlta,estatus) VALUES (".$idServicio.",'SE AGREGA CPT DE CONSULTA POR ".$nombreUsuario."','".$hoy."',1)";
                       mysqli_query($con,$insertarNota2);

            // obtengo el id de consulta agregado
            $queryConsulta="SELECT * FROM datosconsultas ORDER BY idConsulta DESC";
            $resConsulta=mysqli_query($con,$queryConsulta);
            $registrosConsultas=mysqli_fetch_array($resConsulta);
            $idConsulta=$registrosConsultas['idConsulta'];
            
                // agrego el costo de la consulta
            $monto=$_POST["montoconsulta"][$i];
            $monto = str_replace( ',', '', $monto );
            $monto = str_replace( '$', '', $monto );

            if ($monto==''){$monto='0';}
            $insertarMonto="INSERT INTO montosconsultas (idConsulta,idServicio,idBeneficiario,monto,medico,fechaAgrega,idUsuario,estatus) values ($idConsulta,$idServicio,$idBeneficiario,'".$monto."','".$_POST["nombremedico"][$i]."','$hoy',$idUsuaio,1)";
            mysqli_query($con,$insertarMonto);
            
            }
            }
            }

            

        if (!$crea) { ?>
        <script type="text/javascript">
            window.location = "detalleDeServicio?do=2?&idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
               window.location="detalleDeServicio?do=1&idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>";
        </script>
        <?php }
}

function GETPOST() {
        $datos_getpost = array();
        if ($_POST) {
            if (array_key_exists('altaCIE', $_POST)) {
                $datos_getpost['altaCIE'] = $_POST['altaCIE'];
            }
            if (array_key_exists('idBeneficiario', $_POST)) {
                $datos_getpost['idBeneficiario'] = $_POST['idBeneficiario'];
            }
            if (array_key_exists('idServicio', $_POST)) {
                $datos_getpost['idServicio'] = $_POST['idServicio'];
            }
            if (array_key_exists('grupocie', $_POST)) {
                $datos_getpost['grupocie'] = $_POST['grupocie'];
            }
            if (array_key_exists('grupocpt', $_POST)) {
                $datos_getpost['grupocpt'] = $_POST['grupocpt'];
            }
            if (array_key_exists('grupocpt2', $_POST)) {
                $datos_getpost['grupocpt2'] = $_POST['grupocpt2'];
            }
            
        } else if ($_GET) {
            
        }
        return $datos_getpost;
}
}
?>