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
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>SPI - Corintio</title>
<link rel="stylesheet" href="css/jquery-ui-min.css" />
<link rel="stylesheet" href="css/stylemenu.css" />
<script type="text/javascript" src="js/jquery-2.min.js"></script>
<script type="text/javascript" src="js/jqueryui.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
        $(".menu_acordion").accordion();
    });
</script>
</head>

<body>
<div id="contenedor">
	<header>
    	<ul>
        	<li id="nomUsr"><h3><?=$usuario?></h3></li><br /><br />
            <li><h3>Preferencias</li>
            <li><h3>Ayuda</h3></li>
        </ul>
        <div id="avatar">
        	<img src="img/avatar.png" />
        </div>
    </header>
    <section>
    	<div style="clear:both"></div>
        <div class="menu_acordion">
            <h3><a href="#">Administración de datos</a></h3>
                <div>
                    <p>
                        <div class="icono"><img class="iconAdmon" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Solicitudes</p></div></div>
                        <div class="icono"><img class="iconAdmon" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Usuarios</p></div></div>
                        <div class="icono"><img class="iconAdmon" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Desarrollos</p></div></div>
                        <div class="icono"><img class="iconAdmon" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Clientes</p></div></div>
                        <div class="icono"><img class="iconAdmon" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Departamentos</p></div></div>
                        <div style="clear:both"></div>
                </div>
            <h3><a href="#">Exportación de datos</a></h3>
            	<div>
                    <div class="icono"><img class="iconExp" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Usuarios</p></div></div>
                    <div class="icono"><img class="iconExp" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Clientes</p></div></div>
                    <div class="icono"><img class="iconExp" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Desarrollos</p></div></div>
                    <div class="icono"><img class="iconExp" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Departamentos</p></div></div>
                    <div class="icono"><img class="iconExp" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Solicitudes</p></div></div>
                    <div style="clear:both"></div>
                </div>
            <h3><a href="#">Generar solicitudes</a></h3>
            	<div>
                    <div class="deCuatro"><img class="iconSolC" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Caja chica</p></div></div>
                    <div class="deCuatro"><img class="iconSolP" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Proveedor</p></div></div>
                    <div class="deCuatro"><img class="iconSolN" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Comision</p></div></div>
                    <div class="deCuatro"><img class="iconSolE" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Agregar cliente</p></div></div>
                    <div style="clear:both"></div>
                </div>
            <h3><a href="#">Mi cuenta SPI</a></h3>
            	<div>
                    <div class="deCuatro"><img class="iconMail" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Correo</p></div></div>
                    <div class="deCuatro"><img class="iconTele" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Tel&eacute;fono</p></div></div>
                    <div class="deCuatro"><img class="iconPass" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Clave</p></div></div>
                    <div class="deCuatro"><img class="iconFoto" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Foto</p></div></div>
                    <div style="clear:both"></div>
                </div>
        </div>
    </section>
    <footer>
    	<center><h3>&copy;SPI - GriloSystems 2013</h3></center>
    </footer>	
</div>
</body>
</html>
