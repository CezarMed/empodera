
<?php
error_reporting(0);
@session_start();
//creo la conexion
require_once ('class/conexion.php');
$con=conexion();
// print_r($_POST);
$idServicio=$_POST['idServicio'];
$idBeneficiario=$_POST['idBeneficiario'];

$number = count($_POST["idnotacheck"]);
            if($number >= 1)
            {
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["idnotacheck"][$i]!= ''))
            {
                // Insertamos la informacion enviada por el formulario
                $sql1 = "UPDATE notasmedicas SET estatus=3 where idnota='".$_POST["idnotacheck"][$i]."'";
                $res=mysqli_query($con, $sql1);
            }
            }
            }



            $number = count($_POST["idnotaprecheck"]);
            if($number >= 1)
            {
                $html.="";
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["idnotaprecheck"][$i]!= ''))
            {
                // Insertamos la informacion enviada por el formulario
                $sql1 = "UPDATE notaspreoperatorias SET estatus=3 where idNotaPreoperatoria='".$_POST["idnotaprecheck"][$i]."'";
                $res=mysqli_query($con, $sql1);

            }
            }
            }
?>
         <script type="text/javascript">
              window.location="reporteNotasAutorizar?idBeneficiario=<?php echo $idBeneficiario?>&idServicio=<?php echo $idServicio?>";
        </script>  
