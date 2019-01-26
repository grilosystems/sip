<?php
	
	//Evita que se entre directamente a la pagina
	session_name('user_sesion');
	session_start();
	if(isset($_SESSION['usr_ses'])){
		$usuario = $_SESSION['usr_ses'];
		if($usuario=="nada"){
			header('Location: index.html');
		}else{
			$avatar=$_SESSION['avatar'];
			echo '<head>';
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			echo '<title>Bienvenido '.$usuario.' a SPI</title>';
			echo '</head>';
			include("admins_all.php");
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
<style type="text/css">
a{ text-decoration:none; }
</style>
</head>

<body>
<div id="contenedor">
	<header>
    	<ul>
        	<li id="nomUsr"><h3><?=$usuario?></h3></li><br /><br />
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
            <h3><a href="#">Generar solicitudes y agregar clientes</a></h3>
            	<div>
                    <a href="menugeneral.php?tsolicitud=rembolso"><div class="deCuatro"><img class="iconSolC" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Caja chica</p></div></div></a>
                    <a href="menugeneral.php?tsolicitud=proveedor"><div class="deCuatro"><img class="iconSolP" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Proveedor</p></div></div></a>
                    <a href="menugeneral.php?tsolicitud=comision"><div class="deCuatro"><img class="iconSolN" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Comision</p></div></div></a>
                    <a href="menugeneral.php?tsolicitud=cliente"><div class="deCuatro"><img class="iconSolE" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Agregar cliente</p></div></div></a>
                    <div style="clear:both"></div>
                </div>
            <h3><a href="#">Mi cuenta SPI</a></h3>
            	<div>
                    <a href="menugeneral.php?accion=admin_usr_correo"><div class="deCuatro"><img class="iconMail" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Correo</p></div></div></a>
                    <a href="menugeneral.php?accion=admin_usr_telefono"><div class="deCuatro"><img class="iconTele" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Tel&eacute;fono</p></div></div></a>
                    <a href="menugeneral.php?accion=admin_usr_password"><div class="deCuatro"><img class="iconPass" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Clave</p></div></div></a>
                    <a href="menugeneral.php?accion=admin_usr_avatar"><div class="deCuatro"><img class="iconFoto" src="img/img_trans.gif" width="1" height="1" /><div><p align="center">Foto</p></div></div></a>
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