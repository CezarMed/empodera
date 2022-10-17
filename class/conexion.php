<?php 


 	function conexion()
 	{
 	  # declaro las variables de conexion
	  $host = "localhost";
	  $usuario = "sysadmin_DBuserData";
	  $contrasena = "Empodera2020*";
	  $baseDeDatos ="sysadmin_DBdata";
	  #establezco la conexion
 	  //return mysqli_connect($host,$usuario,$contrasena,$baseDeDatos);
 	  // para local
 	  return mysqli_connect('localhost','root','','empoderanew');
 	  // para productivo
 	  // return mysqli_connect('localhost','sysadmin_DBuserData','Q?453mp0der4','sysadmin_DBdata');

    }


?>