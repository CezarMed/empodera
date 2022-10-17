<?php
date_default_timezone_set ('America/Mexico_City');
@session_start();
require_once ('conexion.php');
class autorizaFacturacion_class {

function accionesFacturacion() {
    //arreglo
    $datosCmb = $this->GETPOST();
    //llamar las funciones 
    if (array_key_exists('autorizaFactura', $datosCmb)) {
         $resp= $this->autorizaFactura();
    }
}

// funcion para dar de alta registro
function autorizaFactura() {
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
//print_r($_POST);

// consulto para conocer el idServicio
$queryServicio="SELECT * FROM servicios where folioEmpodera='".$_POST["folioservicio"][0]."'";
$res=mysqli_query($con,$queryServicio);
$extraido=mysqli_fetch_array($res);
$tiposervicio=$extraido['servicio'];
if ($tiposervicio=='MEDICAMENTOS'){
    $grupo="FACPROMED";
} else {
    $grupo="FACPROGRAL";
}

$selectGrupo="SELECT * from facturasdatosxml where grupo='$grupo' and estatus=2 ORDER BY idFacturas DESC LIMIT 1";
$resgrupo=mysqli_query($con,$selectGrupo);
$registrosfactura=mysqli_fetch_array($resgrupo);
$numeroGrupo=$registrosfactura['numeroGrupo'];
$idGrupoConsecutivo=$registrosfactura['idGrupoConsecutivo'];

if ($numeroGrupo==''){
    $numeroGrupo=1;
}

if ($idGrupoConsecutivo<=5){
    $idGrupoConsecutivo=$idGrupoConsecutivo+1;
}

if ($idGrupoConsecutivo==6){
    $idGrupoConsecutivo=1;
    $numeroGrupo=$numeroGrupo+1;
}

            // actualizo estatus de la factura
            $query2="UPDATE facturasdatosxml SET estatus=2, idGrupoConsecutivo=$idGrupoConsecutivo where  idFacturas=".$arrayDatos['idFactura']." ";
            $crea=mysqli_query($con,$query2); 

            if ($idGrupoConsecutivo==5){

                $envioHora=date('Y-m-d H:i:s');
    // envio el grupo a revision de facturas
    $selectFr="SELECT * from facturasdatosxml where grupo='$grupo' and numeroGrupo=$numeroGrupo";
    $res=mysqli_query($con,$selectFr);
    while ($regis=mysqli_fetch_array($res)){
        $idFacturas=$regis['idFacturas'];
            $insert="INSERT INTO gruposfacturas (grupo,idGrupoConsecutivo,idFactura,fechaEnvioValidacion,estatus) values ('$grupo',$numeroGrupo,$idFacturas,'$envioHora',1)";
            $creaGrupo=mysqli_query($con,$insert);
        }


                $html.='
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="x-apple-disable-message-reformatting">
  <title></title>
    <!--[if mso]>
  <style>
    table {border-collapse:collapse;border-spacing:0;border:none;margin:0;}
    div, td {padding:0;}
    div {margin:0 !important;}
    </style>
  <noscript>
    <xml>
      <o:OfficeDocumentSettings>
        <o:PixelsPerInch>96</o:PixelsPerInch>
      </o:OfficeDocumentSettings>
    </xml>
  </noscript>
  <![endif]-->
  <style>
    table, td, div, h1, p {
      font-family: Arial, sans-serif;
    }
    @media screen and (max-width: 530px) {
      .unsub {
        display: block;
        padding: 8px;
        margin-top: 14px;
        border-radius: 6px;
        background-color: #555555;
        text-decoration: none !important;
        font-weight: bold;
      }
      .col-lge {
        max-width: 100% !important;
      }
    }
    @media screen and (min-width: 531px) {
      .col-sml {
        max-width: 27% !important;
      }
      .col-lge {
        max-width: 73% !important;
      }
    }
  </style>
</head>
<body style="margin:0;padding:0;word-spacing:normal;background-color:#939297;">
  <div role="article" aria-roledescription="email" lang="en" style="text-size-adjust:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#939297;">
    <table role="presentation" style="width:100%;border:none;border-spacing:0;">
      <tr>
        <td align="center" style="padding:0;">
          <!--[if mso]>
          <table role="presentation" align="center" style="width:600px;">
          <tr>
          <td>
          <![endif]-->
          <table role="presentation" style="width:100%;max-width:600px;border:none;border-spacing:0;text-align:left;font-family:Arial,sans-serif;font-size:16px;line-height:22px;color:#363636;">
            <tr>
              <td style="text-align:center;font-size:24px;font-weight:bold;">
                <a href="https://sysadmin.empoderasalud.mx" style="text-decoration:none;">
                <img src="https://sysadmin.empoderasalud.mx/dist/img/logo_mail.jpg" width="100%" alt="Logo Hurra" style="width:600px;max-width:100%;height:auto;border:none;text-decoration:none;color:#ffffff;"></a>
              </td>
            </tr>
            <tr>
              <td style="padding:30px;background-color:#ffffff;">
                <h1 style="margin-top:0;margin-bottom:16px;font-size:26px;line-height:32px;font-weight:bold;letter-spacing:-0.02em;">Aviso Importante.</h1>
                <p style="margin:0;">En este momento se ha creado un nuevo grupo para validación de facturas con folio <b>'.$grupo.'_'.$numeroGrupo.'</b></p>
              </td>
            </tr>
            <tr>
              <td style="padding:0;font-size:24px;line-height:28px;font-weight:bold;">
                <a href="https://sysadmin.empoderasalud.mx" style="text-decoration:none;"><img src="https://sysadmin.empoderasalud.mx/dist/img/1200x800-2.png" width="600" alt="" style="width:100%;height:auto;display:block;border:none;text-decoration:none;color:#363636;"></a>
              </td>
            </tr>
            <tr>
              <td style="padding:35px 30px 11px 30px;font-size:0;background-color:#ffffff;border-bottom:1px solid #f0f0f5;border-color:rgba(201,201,207,.35);">
                <!--[if mso]>
                <table role="presentation" width="100%">
                <tr>
                <td style="width:145px;" align="left" valign="top">
                <![endif]-->
                <div class="col-sml" style="display:inline-block;width:100%;max-width:145px;vertical-align:top;text-align:left;font-family:Arial,sans-serif;font-size:14px;color:#363636;">
                  <img src="https://sysadmin.empoderasalud.mx/dist/img/logo_empodera.png" width="115" alt="" style="width:115px;max-width:80%;margin-bottom:20px;">
                </div>
                <!--[if mso]>
                </td>
                <td style="width:395px;padding-bottom:20px;" valign="top">
                <![endif]-->
                <div class="col-lge" style="display:inline-block;width:100%;max-width:395px;vertical-align:top;padding-bottom:20px;font-family:Arial,sans-serif;font-size:16px;line-height:22px;color:#363636;">
                  <p style="margin-top:0;margin-bottom:12px;">Estas facturas ya están disponibles en la plataforma para su validación, el listado completo lo puedes visuallizar desde el menú "CONCILIACIÓN DE PAGOS / Validar Facturas"</p>
                  
                </div>
                <!--[if mso]>
                </td>
                </tr>
                </table>
                <![endif]-->
              </td>
            </tr>
            <tr>
              <td style="padding:30px;font-size:24px;line-height:28px;font-weight:bold;background-color:#ffffff;border-bottom:1px solid #f0f0f5;border-color:rgba(201,201,207,.35);">
                <a href="https://sysadmin.empoderasalud.mx" style="text-decoration:none;"><img src="https://sysadmin.empoderasalud.mx/dist/img/1200x800-1.png" width="540" alt="" style="width:100%;height:auto;border:none;text-decoration:none;color:#363636;"></a>
              </td>
            </tr>
            <tr>
              <td style="padding:30px;background-color:#ffffff;">
                <p style="margin-top:0;margin-bottom:18px;">Este email fue generado automáticamente por la plataforma de Empodera Salud, favor de NO RESPONDER a este email.</p>
                <p style="margin-top:0;margin-bottom:18px;">Si tiene alguna duda podrá escribir a <b>facturacion@empoderasalud.mx</b></p>
              </td>
            </tr>
            <tr>
              <td style="padding:30px;text-align:center;font-size:12px;background-color:#404040;color:#cccccc;">
                <p style="margin:0 0 8px 0;"><a href="http://www.facebook.com/" style="text-decoration:none;"><img src="http://hurra.com.mx/img/icon-facebook.png" width="40" height="40" alt="f" style="display:inline-block;color:#cccccc;"></a> <a href="http://www.twitter.com/" style="text-decoration:none;"><img src="http://hurra.com.mx/img/icon-twitter.png" width="40" height="40" alt="t" style="display:inline-block;color:#cccccc;"></a></p>
                <p style="margin:0;font-size:14px;line-height:20px;">Torre Reforma 180, Piso 14,<br>
 Col. Juárez, 06600, CDMX<br>
5541240309 / contacto@empoderasalud.mx</center><br>&reg; Todos los derechos reservados, Empodera Salud 2022<br><a class="unsub" href="https://empoderasalud.mx/" style="color:#cccccc;text-decoration:underline;">www.empoderasalud.mx/</a></p>
              </td>
            </tr>
          </table>
          <!--[if mso]>
          </td>
          </tr>
          </table>
          <![endif]-->
        </td>
      </tr>
    </table>
  </div>
</body>
</html>'; 
// echo $html;

// ENVIO EL EMAIL
$emailDr='alejandrotoledo@empoderasalud.mx';
$emailIr='irvingzuniga@empoderasalud.mx';
$emailCz='cesar_medt@hotmail.com';
$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$from = 'noresponder_noreply@empoderasalud.mx';
$to = '$emailCz,$emailIr';
$subject = 'GRUPO DE FACTURACION';
$message = $html;
$headers .= 'From: EMPODERA | GRUPO DE FACTURAS <noresponder_noreply@empoderasalud.mx>';
mail($to,$subject,$message, $headers);
            }
                                  
            $number = count($_POST["folioservicio"]);
            if($number >= 1)
            {
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["folioservicio"][$i]!= ''))
            {   
                // coonsulto para conocer el idServicio
                $queryServicio="SELECT * FROM servicios where folioEmpodera='".$_POST["folioservicio"][$i]."'";
                $res=mysqli_query($con,$queryServicio);
                $extraido=mysqli_fetch_array($res);
                $idservicioC=$extraido['idServicio'];
                $monto=$_POST["montofacturable"][$i];
                $monto = str_replace( ',', '', $monto );
                $monto = str_replace( '$', '', $monto );
                
                // Insertamos el monto a aplicar en el servicio
                $sql1 = "INSERT INTO servicioscomplementos (idServicio, idFactura, tipoComplemento, montoComplemento, idUsuario, fechaCarga, estatus) VALUES (".$idservicioC.", ".$arrayDatos['idFactura'].", '".$_POST["servicio"][$i]."', '".$monto."',".$idUsuario.", '".$hoy."', 1)";
            mysqli_query($con, $sql1);

             // creo la nota automatica de pagos
                $insertarNota2="INSERT INTO notaspagos (idServicio,nota,fechaAlta,idUsuarioAgrega,estatus) VALUES (".$idservicioC.",'".$arrayDatos['comentariosfactura']."','".$hoy."','".$idUsuario."',1)";
                mysqli_query($con,$insertarNota2);


            }
            }
            }

        if (!$crea) { ?>
        <script type="text/javascript">
            window.location = "validarFacturaProveedor?do=2";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
            window.location="validarFacturaProveedor?do=1";
        </script>
        <?php }
}

function GETPOST() {
        $datos_getpost = array();
        if ($_POST) {
            if (array_key_exists('idFactura', $_POST)) {
                $datos_getpost['idFactura'] = $_POST['idFactura'];
            }
            if (array_key_exists('autorizaFactura', $_POST)) {
                $datos_getpost['autorizaFactura'] = $_POST['autorizaFactura'];
            } 
            if (array_key_exists('comentariosfactura', $_POST)) {
                $datos_getpost['comentariosfactura'] = $_POST['comentariosfactura'];
            }  
                  
        } else if ($_GET) {
            
        }
        return $datos_getpost;
}
}
?>