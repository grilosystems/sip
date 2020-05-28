<?php
	 include("conexion.php");
	 session_name('user_sesion');
	 session_start();
	 $_SESSION['usr_ses']='nada';
	 $_SESSION['tipo_usr']='nada';
	 $_SESSION['id_usr']='nada';
	 $_SESSION['avatar']='nada';
	 $_SESSION['correo_usr']='nada';
	 
	 $clave = $_POST['clave_usr'];
	 $usr = $_POST['mail_usr'];
	 if($usr!=""){
	 	try {
	 		$objConexion = conectar("on");
	 	} catch (Exception $e) {
	 		echo "Error en la conexión ".$e->getMessage();
	 	}
		
		$consulta = $objConexion->query('SELECT *,
		 						(SELECT CASE avatar_usuario IS NULL WHEN TRUE THEN CONCAT("img/avatar.png") ELSE 
									CONCAT("fotos/",avatar_usuario,"")
									END FROM usuario WHERE email_usuario="'.$usr.'") as avatar 
									FROM usuario WHERE email_usuario="'.$usr.'"');

		if($consulta->num_rows == 0){
			 echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			 <script type="text/javascript">
				alert("No existe el usuario: '.$usr.'");
				window.location.assign("index.html");
		     </script>';
		}

		while($fila = $consulta->fetch_assoc()){
			 if($clave == $fila['password_usuario']){
				//Redireccionar a la pagina menu
				$_SESSION['usr_ses']=$fila['nombre_usuario'];
				$_SESSION['tipo_usr']=$fila['tipo_usuario'];
				$_SESSION['id_usr']=$fila['id_usuario'];
				$_SESSION['correo_usr']=$fila['email_usuario'];
				$_SESSION['avatar']=$fila['avatar'];
				if($fila['tipo_usuario']==1){
					header('Location: menu.php'); 
				}else{
					header('Location: menugeneral.php'); 
				}
				break;
			 }else{
				 echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				 	<script type="text/javascript">
				 		alert("El usuario parece existir, pero la contraseña no es correcta.");
						window.location.assign("index.html");
					</script>';
				 break;
			 }
		}
		conectar("off");
	 }else{
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		 <script type="text/javascript">
		 	alert("No introdujo nombre de usuario, verifique.");
			window.location.assign("index.html");
		 </script>';
	 }

?>