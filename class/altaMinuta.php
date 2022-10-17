<?php
date_default_timezone_set ('America/Mexico_City');
@session_start();
require_once ('conexion.php');
class Altaminuta_class {

function accionesMinuta() {
    //arreglo
    $datosCmb = $this->GETPOST();
    //llamar las funciones 
    if (array_key_exists('altaMinuta', $datosCmb)) {
         $resp= $this->altaMinuta();
    }
    if (array_key_exists('actualizaMinuta', $datosCmb)) {
         $resp= $this->actualizaMinuta();
    }
}

// funcion para dar de alta registro
function altaMinuta() {
$con=conexion();
$arrayDatos = $this->GETPOST();
// creo el numero de proveedor
$idUsuaio=$_SESSION['idUsuario'];
$hoy=date('Y-m-d H:i:s');
$idRegistro=$arrayDatos['idRegistro'];

$query="INSERT INTO minutas (idRegistro,medio,fechaMinuta,nombreElabora,emailElabora,emailEnviar,acuerdos,asuntos,anuncios,nuevosAsuntos,firmas,idUsuario,fechaAgrega,estatus)
        values 
        (" . $arrayDatos['idRegistro'] .",'" . $arrayDatos['medio'] ."','" . $arrayDatos['fechaMinuta'] ."','" . $arrayDatos['nombreElabora'] ."','" . $arrayDatos['emailElabora'] ."','" . $arrayDatos['emailEnviar'] ."','" . $arrayDatos['acuerdos'] ."','" . $arrayDatos['asuntos'] ."','" . $arrayDatos['anuncios'] ."','" . $arrayDatos['nuevosAsuntos'] ."','" . $arrayDatos['firmas'] ."',". $idUsuaio .",'" . $hoy ."',1)";
		    $crea=mysqli_query($con,$query);
         //obtengo id de minuta agregada
            $queryM = "SELECT idMinuta from minutas where idRegistro=$idRegistro ORDER BY idMinuta DESC LIMIT 1";
            $result = mysqli_query($con,$queryM);
            $extraido= mysqli_fetch_array($result);
            $idMinutaNew=$extraido['idMinuta'];

         // inserto los asistentes
            $number = count($_POST["nombre"]);
            if($number>=1)
            {
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["nombre"][$i]!= ''))
            {
                // Insertamos la informacion enviada por el formulario
                $sql1 = "INSERT INTO asistentesminutas (idMinuta, nombre, puesto, email, telefono, estatus) VALUES(".$idMinutaNew.",'".$_POST["nombre"][$i]."','".$_POST["puesto"][$i]."','".$_POST["emailAsistente"][$i]."','".$_POST["telefono"][$i]."',1)";
                mysqli_query($con, $sql1);
            }
            }
            }

            $number1 = count($_POST["nombre1"]);
            if($number1>=1)
            {
            for($i=0; $i<$number1; $i++)
            {
            if(trim($_POST["nombre1"][$i]!= ''))
            {
                // Insertamos la informacion enviada por el formulario
                $sql1 = "INSERT INTO noasistentesminutas (idMinuta, nombre, puesto, email, telefono, estatus) VALUES(".$idMinutaNew.",'".$_POST["nombre1"][$i]."','".$_POST["puesto1"][$i]."','".$_POST["emailAsistente1"][$i]."', '".$_POST["telefono1"][$i]."',1)";
                mysqli_query($con, $sql1);
            }
            }
            }

        if (!$crea) { ?>
        <script type="text/javascript">
            window.location = "agregarMinuta?do=2?&id=<?php echo $arrayDatos['idRegistro'] ?>";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
            window.location="agregarMinuta?do=1&id=<?php echo $arrayDatos['idRegistro'] ?>";
        </script>
        <?php }
}


function actualizaMinuta() {
$con=conexion();
$arrayDatos = $this->GETPOST();
// creo el numero de proveedor
$idUsuaio=$_SESSION['idUsuario'];
$hoy=date('Y-m-d H:i:s');
$idMinuta=$arrayDatos['idMinuta'];

$query="UPDATE minutas SET medio='" . $arrayDatos['medio'] ."', fechaMinuta='" . $arrayDatos['fechaMinuta'] ."', nombreElabora='" . $arrayDatos['nombreElabora'] ."', emailElabora='" . $arrayDatos['emailElabora'] ."', emailEnviar='" . $arrayDatos['emailEnviar'] ."', acuerdos='" . $arrayDatos['acuerdos'] ."', asuntos='" . $arrayDatos['asuntos'] ."', anuncios='" . $arrayDatos['anuncios'] ."', nuevosAsuntos='" . $arrayDatos['nuevosAsuntos'] ."', firmas='" . $arrayDatos['firmas'] ."' where idMinuta=$idMinuta";
         $crea=mysqli_query($con,$query);

            // actualizo los asistentes
            $number = count($_POST["idasistenteA"]);
            if($number>=1)
            {
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["idasistenteA"][$i]!= ''))
            {
                // Insertamos la informacion enviada por el formulario
                $sqlUpdate = "UPDATE asistentesminutas SET nombre='".$_POST["nombreA"][$i]."', puesto='".$_POST["puestoA"][$i]."', email='".$_POST["emailA"][$i]."', telefono='".$_POST["telefonoA"][$i]."'  WHERE idAsistente=".$_POST["idasistenteA"][$i]."";
                mysqli_query($con, $sqlUpdate);
            }
            }
            }

            // actualizo los no asistentes
            $number = count($_POST["idasistenteN"]);
            if($number>=1)
            {
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["idasistenteN"][$i]!= ''))
            {
                // Insertamos la informacion enviada por el formulario
                $sqlUpdate = "UPDATE noasistentesminutas SET nombre='".$_POST["nombreN"][$i]."', puesto='".$_POST["puestoN"][$i]."', email='".$_POST["emailN"][$i]."', telefono='".$_POST["telefonoN"][$i]."'  WHERE idAsistente=".$_POST["idasistenteN"][$i]."";
                mysqli_query($con, $sqlUpdate);
            }
            }
            }

                     // inserto los asistentes
            $number = count($_POST["nombre"]);
            if($number>=1)
            {
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["nombre"][$i]!= ''))
            {
                // Insertamos la informacion enviada por el formulario
                $sql1 = "INSERT INTO asistentesminutas (idMinuta, nombre, puesto, email, telefono, estatus) VALUES(".$idMinuta.",'".$_POST["nombre"][$i]."','".$_POST["puesto"][$i]."','".$_POST["emailAsistente"][$i]."','".$_POST["telefono"][$i]."',1)";
                mysqli_query($con, $sql1);
            }
            }
            }

            $number1 = count($_POST["nombre1"]);
            if($number1>=1)
            {
            for($i=0; $i<$number1; $i++)
            {
            if(trim($_POST["nombre1"][$i]!= ''))
            {
                // Insertamos la informacion enviada por el formulario
                $sql1 = "INSERT INTO noasistentesminutas (idMinuta, nombre, puesto, email, telefono, estatus) VALUES(".$idMinuta.",'".$_POST["nombre1"][$i]."','".$_POST["puesto1"][$i]."','".$_POST["emailAsistente1"][$i]."', '".$_POST["telefono1"][$i]."',1)";
                mysqli_query($con, $sql1);
            }
            }
            }

        if (!$crea) { ?>
        <script type="text/javascript">
            window.location = "editarMinuta?do=2?&id=<?php echo $arrayDatos['idMinuta'] ?>";
        </script> 
        <?php } else {
        $queryUpdate="INSERT INTO movimientosminutas (idMinuta,idUsuario,tipoMovimiento,fechaMovimiento)
        values 
        ($idMinuta,$idUsuaio,'ACTUALIZAR','" . $hoy ."')";
         $actualizar=mysqli_query($con,$queryUpdate); 
        ?>
        <script type="text/javascript">
              window.location="editarMinuta?do=1&id=<?php echo $arrayDatos['idMinuta'] ?>";
        </script>
        <?php }
}

function GETPOST() {
        $datos_getpost = array();
        if ($_POST) {
            if (array_key_exists('medio', $_POST)) {
                $datos_getpost['medio'] = $_POST['medio'];
            }
            if (array_key_exists('fechaMinuta', $_POST)) {
                $datos_getpost['fechaMinuta'] = $_POST['fechaMinuta'];
            }
            if (array_key_exists('idRegistro', $_POST)) {
                $datos_getpost['idRegistro'] = $_POST['idRegistro'];
            }
            if (array_key_exists('nombreElabora', $_POST)) {
                $datos_getpost['nombreElabora'] =  $_POST['nombreElabora'];
            } 
            if (array_key_exists('emailElabora', $_POST)) {
                $datos_getpost['emailElabora'] =  $_POST['emailElabora'];
            }
            if (array_key_exists('emailEnviar', $_POST)) {
                $datos_getpost['emailEnviar'] =  $_POST['emailEnviar'];
            } 
            if (array_key_exists('acuerdos', $_POST)) {
                $datos_getpost['acuerdos'] =  $_POST['acuerdos'];
            }
            if (array_key_exists('asuntos', $_POST)) {
                $datos_getpost['asuntos'] =  $_POST['asuntos'];
            }
            if (array_key_exists('anuncios', $_POST)) {
                $datos_getpost['anuncios'] =  $_POST['anuncios'];
            }
            if (array_key_exists('nuevosAsuntos', $_POST)) {
                $datos_getpost['nuevosAsuntos'] =  $_POST['nuevosAsuntos'];
            }
            if (array_key_exists('medio', $_POST)) {
                $datos_getpost['medio'] =  $_POST['medio'];
            }
            if (array_key_exists('firmas', $_POST)) {
                $datos_getpost['firmas'] =  $_POST['firmas'];
            }
            if (array_key_exists('idMinuta', $_POST)) {
                $datos_getpost['idMinuta'] =  $_POST['idMinuta'];
            }          
        } else if ($_GET) {
            
        }
        return $datos_getpost;
}
}
?>