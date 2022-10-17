<?php 
function generarCodigo($longitud) {
$key = '';
$pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
$max = strlen($pattern)-1;
for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
return $key;
}
$codigo=generarCodigo(8);

$i=0;
for ($i = 1; $i <= 1308; $i++){
$codigo=generarCodigo(8);
 // echo $codigo;
 echo "UPDATE beneficiarios SET codigoBenefeciario='$codigo' where idBenefeciario=$i;";
 echo "<br>";
}
?>