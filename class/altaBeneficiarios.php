<?php
date_default_timezone_set ('America/Mexico_City');
@session_start();
require_once ('conexion.php');
class AltaBenefeciarios_class {

function accionesBenefeciarios() {
    //arreglo
    $datosCmb = $this->GETPOST();
    //llamar las funciones 
    if (array_key_exists('altaBenefeciarios', $datosCmb)) {
         $resp= $this->altaBenefeciarios();
    }
    if (array_key_exists('editaBenefeciarios', $datosCmb)) {
         $resp= $this->editaBenefeciarios();
    }
}

// funcion para dar de alta registro
function altaBenefeciarios() {
$con=conexion();
$arrayDatos = $this->GETPOST();
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

$nombre=$arrayDatos['nombreBeneficiario'];
$apellidoP=$arrayDatos['apeliidoPaternoBeneficiario'];
$apellidoM=$arrayDatos['apeliidoMaternoBeneficiario'];
$nombrecompleto=$apellidoP.' '.$apellidoM.' '.$nombre;
$fechaNac=$arrayDatos['fechaNac'];
list($anio, $mes, $dia) = explode('-', $fechaNac);
$folioBene=$anio.$mes.$dia;

// valido si ya existe el nombre y la fecha de naciemiento es la misma
$queryValida = "SELECT count(*) as totalRegistros from beneficiarios where nombreBeneficiario='$nombrecompleto' and fechaNacimiento='$fechaNac'";
$resultValida = mysqli_query($con,$queryValida);
$extraidoValida= mysqli_fetch_array($resultValida);;
$totalRegistros=$extraidoValida['totalRegistros'];

            //obtengo el homoclave para el registro del beneficiario
            $queryM = "SELECT * from beneficiarios where folioBeneficiario like '%$folioBene%' ORDER BY idBenefeciario DESC LIMIT 1";
            $result = mysqli_query($con,$queryM);
            $extraido= mysqli_fetch_array($result);;
            $idBeneficiario=$extraido['folioBeneficiario'];
            if ($idBeneficiario=='') {
                $homoclave='001';
            } else {
                $lastChar = substr($idBeneficiario, -1);
                $final=$lastChar+1;
                 $homoclave='00'.$final;                
            }

            $folioBene=$anio.$mes.$dia.$homoclave;

            $query="INSERT INTO beneficiarios (codigoBenefeciario, folioBeneficiario, nombreBeneficiario, sexo, genero, fechaNacimiento, entidadFederativa, municipioDelegacion, calle, colonia, noExteriorInterior, codigoPostal, telefonoBeneficiario, nombreRecibe, telefonoRecibe, tipoPrograma, subgrupo, referencias, idUsuario, fechaAlta, estatus)
            values 
            ('". $codigo ."', '". $folioBene ."', '" . strtoupper($nombrecompleto) ."', '" . $arrayDatos['sexo'] ."', '" . $arrayDatos['genero'] ."', '" . $arrayDatos['fechaNac'] ."', " . $arrayDatos['entidadFederativa'] .", " . $arrayDatos['municipioDelegacion'] .", '" . $arrayDatos['calle'] ."', '" . $arrayDatos['colonia'] ."', '" . $arrayDatos['noExteriorInterior'] ."', '" . $arrayDatos['codigoPostal'] ."', '" . $arrayDatos['telefonoBeneficiario'] ."', '" . $arrayDatos['nombreRecibe'] ."', '" . $arrayDatos['telefonoRecibe'] ."', '" . $arrayDatos['tipoPrograma'] ."','" . $arrayDatos['subgrupo'] ."', '" . $arrayDatos['referencias'] ."', ". $idUsuario .", '" . $hoy ."', 1)";
            $crea=mysqli_query($con,$query);


            $queryM2 = "SELECT * from beneficiarios where nombreBeneficiario='$nombrecompleto' ORDER BY idBenefeciario DESC LIMIT 1";
            $result2 = mysqli_query($con,$queryM2);
            $extraido2= mysqli_fetch_array($result2);;
            $idBeneficiarioInsert=$extraido2['idBenefeciario'];



            // agrego los subgrupos del beneficiario
            $number = count($_POST["idprograma"]);
            if($number >= 1)
            {
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["idprograma"][$i]!= ''))
            {
            $queryCuenta="INSERT INTO beneficiarioscuentas (idBeneficiario,idPrograma,contribucion,copago,estatusCuenta) values (". $idBeneficiarioInsert .", " . $_POST["idprograma"][$i].", ".$_POST["contribucion"][$i].", ".$_POST["copago"][$i].", 1)";
            $creaCuenta=mysqli_query($con,$queryCuenta);
            }
            }
            }


            $queryFechas="INSERT INTO periodosbeneficiarios (idBeneficiario,fechaInicial,fechaFin,idUsuario,fechaAlta,estatus)
                        values 
            (". $idBeneficiarioInsert .",'" . $arrayDatos['fechaInicio'] ."','" . $arrayDatos['fechaFin'] ."',". $idUsuario .",'" . $hoy ."',1)";
            $creaFechas=mysqli_query($con,$queryFechas);

            // agrego los numero adicionales
            $number = count($_POST["telefonoadic"]);
            if($number >= 1)
            {
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["telefonoadic"][$i]!= ''))
            {
                // Insertamos la informacion enviada por el formulario
                $sqlTelefonos = "INSERT INTO telefonosbeneficiarios (idBeneficiario, tipoTelefono, telefono, extension, estatus) VALUES(".$idBeneficiarioInsert.",'".$_POST["tipoTelefono"][$i]."','".$_POST["telefonoadic"][$i]."','".$_POST["extension"][$i]."',1)";
                    mysqli_query($con, $sqlTelefonos);
            }
            }
            }

        if (!$crea) { ?>
        <script type="text/javascript">
            window.location="altaBenefeci>ario?do=2&folio=<?php echo $folioBene ?>";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
            window.location="altaBenefeciario?do=1&folio=<?php echo $folioBene ?>";
        </script>
        <?php }
}




function editaBenefeciarios() {
$con=conexion();
$arrayDatos = $this->GETPOST();
$idUsuario=$_SESSION['idUsuario'];
$hoy=date('Y-m-d H:i:s');
$codigoBen=$arrayDatos['codigoBenefeciario'];
$nuevoperiodo=$arrayDatos['checkboxPrimary2'];
$municipio=$arrayDatos['municipioDelegacion'];
if ($municipio==''){$municipio='0';}

$update="UPDATE beneficiarios set nombreBeneficiario='" . $arrayDatos['nombreBeneficiario'] ."', folioBeneficiario='" . $arrayDatos['folioBeneficiario'] ."', sexo='" . $arrayDatos['sexo'] ."', genero='" . $arrayDatos['genero'] ."', fechaNacimiento='" . $arrayDatos['fechaNac'] ."', entidadFederativa=" . $arrayDatos['entidadFederativa'] .", municipioDelegacion=" . $municipio .", calle='" . $arrayDatos['calle'] ."', colonia='" . $arrayDatos['colonia'] ."', noExteriorInterior='" . $arrayDatos['noExteriorInterior'] ."', codigoPostal='" . $arrayDatos['codigoPostal'] ."', telefonoBeneficiario='" . $arrayDatos['telefonoBeneficiario'] ."', nombreRecibe='" . $arrayDatos['nombreRecibe'] ."', telefonoRecibe='" . $arrayDatos['telefonoRecibe'] ."', referencias='" . $arrayDatos['referencias'] ."' where idBenefeciario=" . $arrayDatos['idBeneficiario'] ."";
            $creas=mysqli_query($con,$update);

            if ($nuevoperiodo==1) {
                $actualizafechas="UPDATE periodosbeneficiarios SET estatus=2 where idBeneficiario=" . $arrayDatos['idBeneficiario'] ."";
                mysqli_query($con,$actualizafechas);

                $queryFechas="INSERT INTO periodosbeneficiarios (idBeneficiario,fechaInicial,fechaFin,idUsuario,fechaAlta,estatus)
                        values 
                     (". $arrayDatos['idBeneficiario'] .",'" . $arrayDatos['fechaInicio'] ."','" . $arrayDatos['fechaFin'] ."',". $idUsuario .",'" . $hoy ."',1)";
                $creaFechas=mysqli_query($con,$queryFechas);

            }

            $queryMonto = "SELECT * from montosclientes where idMontoCliente=" . $arrayDatos['subGrupoPrograma'] ."";
            $resultados = mysqli_query($con,$queryMonto);
            $extraidoMonto= mysqli_fetch_array($resultados);;
            $contribucion=$extraidoMonto['contribucion'];
            $copago=$extraidoMonto['copago'];

            $number = count($_POST["idCuenta"]);
            if($number >= 1)
            {
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["idCuenta"][$i]!= ''))
            {
                $sqlUpdate = "UPDATE beneficiarioscuentas SET estatusCuenta='".$_POST["elegido"][$i]."' where idCuenta='".$_POST["idCuenta"][$i]."'";
                    mysqli_query($con, $sqlUpdate);

            }
            }
            }

            if ($arrayDatos['subGrupoPrograma']!=''){
            $queryCuenta="INSERT INTO beneficiarioscuentas (idBeneficiario,idPrograma,contribucion,copago,estatusCuenta) values (".$arrayDatos['idBeneficiario'].", ".$arrayDatos['subGrupoPrograma'].", ".$contribucion.", ".$copago.", 1)";
            $creas2=mysqli_query($con,$queryCuenta);
            }

        if (!$creas) { ?>
        <script type="text/javascript">
           window.location="editaBenefeciarios?do=2&id=<?php echo $codigoBen ?>";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
          window.location="editaBenefeciarios?do=1&id=<?php echo $codigoBen ?>";
        </script>
        <?php }

}


function GETPOST() {
        $datos_getpost = array();
        if ($_POST) {
            if (array_key_exists('altaBenefeciarios', $_POST)) {
                $datos_getpost['altaBenefeciarios'] = $_POST['altaBenefeciarios'];
            }
            if (array_key_exists('nombreBeneficiario', $_POST)) {
                $datos_getpost['nombreBeneficiario'] = $_POST['nombreBeneficiario'];
            }
            if (array_key_exists('apeliidoPaternoBeneficiario', $_POST)) {
                $datos_getpost['apeliidoPaternoBeneficiario'] = $_POST['apeliidoPaternoBeneficiario'];
            }
            if (array_key_exists('apeliidoMaternoBeneficiario', $_POST)) {
                $datos_getpost['apeliidoMaternoBeneficiario'] = $_POST['apeliidoMaternoBeneficiario'];
            }
            if (array_key_exists('idCliente', $_POST)) {
                $datos_getpost['idCliente'] = $_POST['idCliente'];
            }
            if (array_key_exists('subGrupoPrograma', $_POST)) {
                $datos_getpost['subGrupoPrograma'] = $_POST['subGrupoPrograma'];
            }
            if (array_key_exists('contribucionInicial', $_POST)) {
                $datos_getpost['contribucionInicial'] = $_POST['contribucionInicial'];
            }
            if (array_key_exists('copago', $_POST)) {
                $datos_getpost['copago'] = $_POST['copago'];
            }
            if (array_key_exists('fechaNac', $_POST)) {
                $datos_getpost['fechaNac'] = $_POST['fechaNac'];
            }
            if (array_key_exists('sexo', $_POST)) {
                $datos_getpost['sexo'] = $_POST['sexo'];
            }
            if (array_key_exists('genero', $_POST)) {
                $datos_getpost['genero'] = $_POST['genero'];
            }
            if (array_key_exists('entidadFederativa', $_POST)) {
                $datos_getpost['entidadFederativa'] = $_POST['entidadFederativa'];
            }
            if (array_key_exists('municipioDelegacion', $_POST)) {
                $datos_getpost['municipioDelegacion'] = $_POST['municipioDelegacion'];
            }
            if (array_key_exists('calle', $_POST)) {
                $datos_getpost['calle'] = $_POST['calle'];
            }
            if (array_key_exists('noExteriorInterior', $_POST)) {
                $datos_getpost['noExteriorInterior'] = $_POST['noExteriorInterior'];
            }
            if (array_key_exists('colonia', $_POST)) {
                $datos_getpost['colonia'] = $_POST['colonia'];
            }
            if (array_key_exists('codigoPostal', $_POST)) {
                $datos_getpost['codigoPostal'] = $_POST['codigoPostal'];
            }
            if (array_key_exists('telefonoBeneficiario', $_POST)) {
                $datos_getpost['telefonoBeneficiario'] = $_POST['telefonoBeneficiario'];
            }
            if (array_key_exists('nombreRecibe', $_POST)) {
                $datos_getpost['nombreRecibe'] = $_POST['nombreRecibe'];
            }
            if (array_key_exists('telefonoRecibe', $_POST)) {
                $datos_getpost['telefonoRecibe'] = $_POST['telefonoRecibe'];
            }
            if (array_key_exists('referencias', $_POST)) {
                $datos_getpost['referencias'] = $_POST['referencias'];
            }
            if (array_key_exists('fechaInicio', $_POST)) {
                $datos_getpost['fechaInicio'] = $_POST['fechaInicio'];
            }
            if (array_key_exists('fechaFin', $_POST)) {
                $datos_getpost['fechaFin'] = $_POST['fechaFin'];
            }
            if (array_key_exists('tipoPrograma', $_POST)) {
                $datos_getpost['tipoPrograma'] = $_POST['tipoPrograma'];
            }
            if (array_key_exists('subgrupo', $_POST)) {
                $datos_getpost['subgrupo'] = $_POST['subgrupo'];
            }

            // para actualizar
            if (array_key_exists('editaBenefeciarios', $_POST)) {
                $datos_getpost['editaBenefeciarios'] = $_POST['editaBenefeciarios'];
            }
            if (array_key_exists('idBeneficiario', $_POST)) {
                $datos_getpost['idBeneficiario'] = $_POST['idBeneficiario'];
            }
            if (array_key_exists('folioBeneficiario', $_POST)) {
                $datos_getpost['folioBeneficiario'] = $_POST['folioBeneficiario'];
            }
            if (array_key_exists('codigoBenefeciario', $_POST)) {
                $datos_getpost['codigoBenefeciario'] = $_POST['codigoBenefeciario'];
            }
            if (array_key_exists('checkboxPrimary2', $_POST)) {
                $datos_getpost['checkboxPrimary2'] = $_POST['checkboxPrimary2'];
            }

                      
        } else if ($_GET) {
            
        }
        return $datos_getpost;
}
}
?>