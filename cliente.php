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
			include('conexion.php');
			echo '<head>';
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			echo '<title>SPI - Rembolso caja chica -</title>';
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
		calendario("fechareq"); 
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
}
</script>
<link href="css/styleform.css" rel="stylesheet" type="text/css" media="screen" />
<link type="text/css" href="css/jquery-ui-min.css" rel="stylesheet" />
<link rel="stylesheet" href="css/chosen.css">
</head>

<body onLoad="cargarDatos()">

<div id="contact">
	<h1>Agregar<br />Cliente</h1>
	<form action="solicitud.php" method="post" onSubmit="return verifica(6);">
		<fieldset>
			
            <label for="fechareq">Cliente:</label>
			<input type="text" id="nomCliente" placeholder="Nombre completo" name="nombreCliente" />
            
            <label for="company">Depto:</label>
			<input type="text" id="deptoCliente" placeholder="# de departamento" name="deptoCliente" />
            
			<label for="seldesAsesor">Asesor:</label>
            <select data-placeholder="Seleccione un asesor..." id="seldesAsesor" class="chosen-select" style="width:260px;" name="asesor">
            	<option value=""></option>
            	<?php
					$objConexion = conectar("on");
					$opciones = $objConexion->query('SELECT id_usuario, nombre_usuario FROM usuario');
					if($opciones->num_rows != 0){
						while($fila=$opciones->fetch_assoc()){
							echo '<option value="'.$fila['id_usuario'].'">'.$fila['nombre_usuario'].'</option>'; 
						}
					}else{
						echo '<option value="">No hay asesores</option>';
					}
					conectar("off");
				?>
          	</select><br /><br /><br />
			
			<label for="comentario">Comentario:</label>
			<textarea id="comentario" placeholder="Comentario y/u observaciones" name="comentario"></textarea>
            
            <input type="hidden" value="scliente" name="ts" />
            <input type="hidden" id="save_cerrar" name="cerrarss" value="" />
			
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