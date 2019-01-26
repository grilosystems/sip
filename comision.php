<?php
	//Evita que se entre directamente a la pagina
	session_name('user_sesion');
	session_start();
	if(isset($_SESSION['usr_ses'])){
		$usuario = $_SESSION['usr_ses'];
		if($usuario=="nada"){
			header('Location: index.html');
		}else{
			/*******Precargar datos relacionados****************************************************************/
			include('admins_all.php');
			$fecha_actual=getFecha();
			echo '<head>';
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			echo '<title>SPI - Solicitud de comisión -</title>';
			echo '</head>';
		}
	}else{
		header('Location: http://www.grilosystems.com');
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>CSS3 Contact Form</title>
<script type="text/javascript" src="js/jquery-2.min.js"></script>
<script type="text/javascript" src="js/jqueryui.js"></script>
<script type="text/javascript" src="js/funComunes.js"></script>
<script src="js/chosen.jquery.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
	function cargarDatos(){
		var config = {
      		'.chosen-select'           : {},
      		'.chosen-select-deselect'  : {allow_single_deselect:true},
      		'.chosen-select-no-single' : {disable_search_threshold:10},
      		'.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      		'.chosen-select-width'     : {width:"5%"}
    	}
    	for (var selector in config) {
      		$(selector).chosen(config[selector]);
    	}
		calendario("fechareq"); 
	}
</script>
<link href="css/styleform.css" rel="stylesheet" type="text/css" media="screen" />
<link type="text/css" href="css/jquery-ui-min.css" rel="stylesheet" />
<link rel="stylesheet" href="css/chosen.css">
</head>

<body onLoad="cargarDatos()">

<div id="contact">
	<h1>Solicitud<br />
	COMISI&oacute;N</h1>
	<form action="solicitud.php" method="POST" onSubmit="return verifica(2);" enctype="multipart/form-data">
		<fieldset>
			
            <label for="fechareq">Fecha requerida:</label>
			<input type="text" id="fechareq" placeholder="2013/01/12" name="fechareq" />
            
            <label for="seldesAsesor">ASESOR:</label>
            <select data-placeholder="Seleccione un asesor..." id="seldesAsesor" class="chosen-select" style="width:260px;" name="asesor">
            	<option value=""></option>
            	<?php
					conectar("on");
					mysql_query("SET NAMES 'utf8'");
					$opciones = mysql_query('SELECT id_usuario, nombre_usuario FROM usuario');
					if(mysql_num_rows($opciones) != 0){
						while($fila=mysql_fetch_array($opciones)){
							echo '<option value="'.$fila['id_usuario'].'">'.$fila['nombre_usuario'].'</option>'; 
						}
					}else{
						echo '<option value="">No hay asesores</option>';
					}
					conectar("off");
				?>
          	</select><br /><br /><br />
            
            <label for="concep">Concepto:</label>
			<input type="text" id="concep" placeholder="Por concepto de " name="concepto" />
            
            <label for="nfac"># Factura:</label>
            <input type="text" id="nfc" placeholder="0" name="nfactura"/>
            
            <label for="seldesDepartamento">Depto:</label>
            <select data-placeholder="Seleccione un departamento..." id="seldesDepartamento" class="chosen-select" style="width:260px;" name="depto">
            	<option value=""></option>
            	<?php
					conectar("on");
					mysql_query("SET NAMES 'utf8'");
					$opciones = mysql_query('SELECT id_departamento, nombre_departamento FROM departamento');
					if(mysql_num_rows($opciones) != 0){
						while($fila=mysql_fetch_array($opciones)){
							echo '<option value="'.$fila['id_departamento'].'">'.$fila['nombre_departamento'].'</option>'; 
						}
					}else{
						echo '<option value="">No hay departamentos</option>';
					}
					conectar("off");
				?>
          	</select><br /><br /><br />
            
            <label for="seldesDesarrollo">Desarrollo:</label>
            <br />
            <select data-placeholder="Seleccione un desarrollo..." id="seldesDesarrollo" class="chosen-select" style="width:260px;" name="desarrollo">
            	<option value=""></option>
            	<?php
					conectar("on");
					mysql_query("SET NAMES 'utf8'");
					$opciones = mysql_query('SELECT id_desarrollo, nombre_desarrollo FROM desarrollo');
					if(mysql_num_rows($opciones) != 0){
						while($fila=mysql_fetch_array($opciones)){
							echo '<option value="'.$fila['id_desarrollo'].'">'.$fila['nombre_desarrollo'].'</option>'; 
						}
					}else{
						echo '<option value="">No hay desarrollos</option>';
					}
					conectar("off");
				?>
          	</select><br /><br />
            
            <label for="monto">MONTO:</label>
            <input type="number" id="monto" onKeyPress="return soloNumeros(event);" placeholder="$" name="monto" />
            
            <label for="cliente">CLIENTE:</label>
            <select data-placeholder="Seleccione un cliente..." id="seldesCliente" class="chosen-select" style="width:260px;" name="cliente">
            	<option value=""></option>
            	<?php
					conectar("on");
					mysql_query("SET NAMES 'utf8'");
					$opciones = mysql_query('SELECT id_cliente, nombre_cliente FROM cliente');
					if(mysql_num_rows($opciones) != 0){
						while($fila=mysql_fetch_array($opciones)){
							echo '<option value="'.$fila['id_cliente'].'">'.$fila['nombre_cliente'].'</option>'; 
						}
					}else{
						echo '<option value="">No hay clientes oops!!</option>';
					}
					conectar("off");
				?>
          	</select><br /><br /><br />
            
            <label for="anticipo">Anticipo:</label>
            <input type="number" id="anticipo" onKeyPress="return soloNumeros(event);" placeholder="$" name="anticipo" />
            
            <label for="factura">Factura:</label>
            <input type="file" id="factura" placeholder="Archivo JPG" name="archivoFactura" />
            
			<label for="comentario">Comentario:</label>
			<textarea id="comentario" placeholder="Comentario y/u observaciones" name="comentario"></textarea>
            
            <input type="hidden" value="scomision" name="ts" />
            <input type="hidden" value="<?=$fecha_actual?>" id="fecha_actual" />
            <input type="hidden" id="save_cerrar" name="cerrarss" value="" />
             <input type="hidden" id="DiaSemana" value="<?=date('N')?>" />
			
			<input type="submit" value="Guardar y nuevo" />
	        <input type="submit" onClick="guardarSalir('<?=$_SESSION['tipo_usr']?>')" value="Guardar y salir" /><br /><br /><br /><br /><br />
            <input type="reset" value="Limpiar" />
            <input type="button" onClick="cerrar_solicitud('<?=$_SESSION['tipo_usr']?>')" value="Cancelar" />
			
		</fieldset>
	</form>
</div>
<div id="dialogo" title="Error en los campos"></div>
</body>
</html>