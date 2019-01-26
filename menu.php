<?php
	//Evita que se entre directamente a la pagina
	session_name('user_sesion');
	session_start();
	if(isset($_SESSION['usr_ses']) && isset($_SESSION['tipo_usr'])){
		$usuario = $_SESSION['usr_ses'];
		$id_admin=$_SESSION['tipo_usr'];
		$avatar=$_SESSION['avatar'];
		include("admins_all.php");
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
			unset($_SESSION['tipo_usr']);
			session_unset();
  			session_destroy();
			echo '<meta http-equiv="refresh" content="0;url=index.html" />';
			//header("Location: index.html");
  			exit;
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
<script src="js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
<script type="text/javascript">
	$(document).ready(function() {
        $(".menu_acordion").accordion();
		$("a[rel^='prettyPhoto']").prettyPhoto();
    });
</script>
</head>

<body>
<div id="contenedor">
	<header>
    	<ul>
        	<li id="nomUsr" class="nomUsr"><h3><?=$usuario?></h3></li><br /><br />
            <li><a href="quickmanual.ppsx"><img class="iconAyuda" src="img/img_trans.gif" width="1" height="1"><p align="center"><font size="+2"><strong class="nomUsr">Ayuda</strong></font></p></a></li>
            <li><a href="menu.php?tsolicitud=cerrars"><img class="iconSalir" src="img/img_trans.gif" width="1" height="1"><p align="center"><font size="+2"><strong class="nomUsr">Salir</strong></font></p></a></li>
        </ul>
        <div id="avatar">
        	<img src="<?=$avatar?>" width="100px" height="100px" />
        </div>
    </header>
    <section>
    	<div style="clear:both"></div>
        <div class="menu_acordion">
            <h3><a href="#">Administración de datos</a></h3>
                <div>
                    <p>
                        <a href="menu.php?tsolicitud=admin_soli"><div class="icono"><img class="iconAdmon" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Solicitudes</p></div></div></a>
                        <a href="menu.php?tsolicitud=admin_usr"><div class="icono"><img class="iconAdmon" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Usuarios</p></div></div></a>
                        <a href="menu.php?tsolicitud=admin_des"><div class="icono"><img class="iconAdmon" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Desarrollos</p></div></div></a>
                        <a href="menu.php?tsolicitud=admin_cli"><div class="icono"><img class="iconAdmon" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Clientes</p></div></div></a>
                        <a href="menu.php?tsolicitud=admin_dep"><div class="icono"><img class="iconAdmon" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Departamentos</p></div></div></a>
                        <div style="clear:both"></div>
                </div>
            <h3><a href="#">Exportación de datos</a></h3>
            	<div>
                    <a href="admins_all.php?accion=exp_usr" target="_blank"><div class="icono"><img class="iconExp" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Usuarios</p></div></div></a>
                    <a href="admins_all.php?accion=exp_cli" target="_blank"><div class="icono"><img class="iconExp" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Clientes</p></div></div></a>
                    <a href="admins_all.php?accion=exp_des" target="_blank"><div class="icono"><img class="iconExp" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Desarrollos</p></div></div></a>
                    <a href="admins_all.php?accion=exp_dep" target="_blank"><div class="icono"><img class="iconExp" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Departamentos</p></div></div></a>
                    <a href="menu.php?tsolicitud=exp_datos"><div class="icono"><img class="iconExp" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Solicitudes</p></div></div></a>
                    <div style="clear:both"></div>
                </div>
            <h3><a href="#">Generar solicitudes y agregar clientes</a></h3>
            	<div>
                    <a href="menu.php?tsolicitud=rembolso"><div class="deCuatro"><img class="iconSolC" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Caja chica</p></div></div></a>
                    <a href="menu.php?tsolicitud=proveedor"><div class="deCuatro"><img class="iconSolP" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Proveedor</p></div></div></a>
                    <a href="menu.php?tsolicitud=comision"><div class="deCuatro"><img class="iconSolN" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Comision</p></div></div></a>
                    <a href="menu.php?tsolicitud=cliente"><div class="deCuatro"><img class="iconSolE" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Agregar cliente</p></div></div></a>
                    <div style="clear:both"></div>
                </div>
            <h3><a href="#">Mi cuenta SPI</a></h3>
            	<div>
                    <a href="menu.php?accion=admin_usr_correo"><div class="deCuatro"><img class="iconMail" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Correo</p></div></div></a>
                    <a href="menu.php?accion=admin_usr_telefono"><div class="deCuatro"><img class="iconTele" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Tel&eacute;fono</p></div></div></a>
                    <a href="menu.php?accion=admin_usr_password"><div class="deCuatro"><img class="iconPass" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Clave</p></div></div></a>
                    <a href="menu.php?accion=admin_usr_avatar"><div class="deCuatro"><img class="iconFoto" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Foto</p></div></div></a>
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
