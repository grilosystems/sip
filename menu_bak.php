<?php
	
	include("admins_all.php");
	//Evita que se entre directamente a la pagina
	session_name('user_sesion');
	session_start();
	if(isset($_SESSION['usr_ses']) && isset($_SESSION['tipo_usr'])){
		$usuario = $_SESSION['usr_ses'];
		$id_admin=$_SESSION['tipo_usr'];
		if($usuario=="nada" || $id_admin!=1){
			header('Location: index.html');
		}
	}else{
		header('Location: http://www.grilosystems.com');
	}
	
	//Solicitudes
	switch($_REQUEST['tsolicitud']){
		case "rembolso":
			echo '<meta http-equiv="refresh" content="0;url=caja.php" >';
		break;
		case "comision":
			echo '<meta http-equiv="refresh" content="0;url=comision.php" >';
		break;
		case "proveedor":
			echo '<meta http-equiv="refresh" content="0;url=proveedor.php" >';
		break;
		case "cliente":
			echo '<meta http-equiv="refresh" content="0;url=cliente.php" >';
		break;
		case "admin_usr":
			opcion_admin(1);
		break;
		case "admin_des":
			opcion_admin(2);
		break;
		case "admin_dep":
			opcion_admin(3);
		break;
		case "exp_datos":
			opcion_admin(4);
		break;
		case "admin_cli":
			opcion_admin(5);
		break;
		case "admin_soli":
			opcion_admin(6);
		break;
		case "cerrars":
			session_name('user_sesion');
			session_start();
			unset($_SESSION["usr_ses"]); 
  			session_destroy();
			echo '<meta http-equiv="refresh" content="0;url=index.html" />';
		break;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bienvenido <?=$usuario?> a SPI</title>
<style type="text/css">
body {
	background-image: url(img/background.png);
	background-repeat: repeat;
	background-position: center center;
	background-color: #1E2025;
}
.nada{}
.formulario {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 16px;
	font-style: normal;
	line-height: normal;
	font-weight: bolder;
	font-variant: normal;
	text-transform: none;
	color: #E8CD36;
	background-image: url(img/transparencia.fw.png);
}
</style>
</head>

<body>
<table width="80%" align="center" border="0" class="nada">
  <tr>
    <td class="formulario" align="center"><img src="img/top_up2.png" width="326" height="178" /></td>
  </tr>
  <tr>
    <td class="formulario" align="center">Bienvenid@ <?=$usuario?>, al Sistema de Pago Integral aqu&iacute; podras dar de alta cualquier solicitud y administrar los datos de las mismas.</td>
  </tr>
  <tr>
    <td class="formulario" align="center"><hr  /></td>
  </tr>
  <tr>
    <td class="formulario" align="center">ADMINISTRACI&Oacute;N DE DATOS</td>
  </tr>
  <tr>
    <td class="formulario" align="center"><a href="menu.php?tsolicitud=admin_usr">Administrar usuarios</a></td>
  </tr>
  <tr>
    <td class="formulario" align="center"><a href="menu.php?tsolicitud=admin_des">Administrar desarrollos</a></td>
  </tr>
  <tr>
    <td class="formulario" align="center"><a href="menu.php?tsolicitud=admin_dep">Administrar departamentos</a></td>
  </tr>
  <tr>
    <td class="formulario" align="center"><a href="menu.php?tsolicitud=admin_cli">Administrar clientes</a></td>
  </tr>
  <tr>
    <td class="formulario" align="center"><a href="menu.php?tsolicitud=admin_soli">ADMINISTRAR SOLICITUDES</a></td>
  </tr>
  <tr>
    <td class="formulario" align="center"><a href="menu.php?tsolicitud=exp_datos">Exportar datos</a></td>
  </tr>
  <tr>
    <td class="formulario" align="center"><hr /></td>
  </tr>
  <tr>
    <td class="formulario" align="center">SOLICITUDES</td>
  </tr>
  <tr>
    <td class="formulario" align="center"><a href="menu.php?tsolicitud=rembolso">Rembolso Caja Chica</a></td>
  </tr>
  <tr>
    <td class="formulario" align="center"><a href="menu.php?tsolicitud=proveedor">Pago a Proveedor</a></td>
  </tr>
  <tr>
    <td class="formulario" align="center"><a href="menu.php?tsolicitud=comision">Solicitud de comisi&oacute;n</a></td>
  </tr>
  <tr>
    <td class="formulario" align="center"><a href="menu.php?tsolicitud=cliente">Agregar cliente</a></td>
  </tr>
  <tr>
    <td class="formulario" align="center"><hr  /></td>
  </tr>
  <tr>
    <td class="formulario" align="center"><a href="menu.php?tsolicitud=cerrars">Cerrar sesi&oacute;n</a></td>
  </tr>
  <tr>
    <td class="formulario" align="center"><hr  /></td>
  </tr>
  <tr>
    <td class="formulario" align="center">Para que las solicitudes sean tramitadas en la semana corriente tendrán que ser subidas al sistema a más tardar los días Martes hasta las 11:55pm las que se realizen posteriormente serán tramitadas hasta la siguiente semana.</td>
  </tr>
</table>
</div>
</body>
</html>
