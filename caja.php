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
      '.chosen-select-no-results': {no_results_text:'No se encontro!'},
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
	<h1>Solicitud<br />Caja chica</h1>
	<form action="solicitud.php" method="post" onSubmit="return verifica(1);" enctype="multipart/form-data">
		<fieldset>
			
            <label for="fechareq">Fecha requerida:</label>
			<input type="text" id="fechareq" placeholder="2013/01/12" name="fechareq" />
            
            <label for="company">Beneficiario:</label>
			<input type="text" id="company" placeholder="Beneficiario" name="beneficiario" />
            
            <label for="company">Concepto:</label>
			<input type="text" id="concep" placeholder="Por concepto de " name="concepto" />
            
            <label for="nfac"># Factura:</label>
            <input type="text" id="nfac" placeholder="0" name="nfactura" />
            
			<label for="seldesDesarrollo" id="desarrollo">Desarrollo:</label>
            <br />
            <select data-placeholder="Seleccione un desarrollo..." id="seldesDesarrollo" class="chosen-select" style="width:260px;" name="desarrollo">
            	<option value=""></option>
            	<?php
					$objConexion = conectar("on");
					$opciones = $objConexion->query('SELECT id_desarrollo, nombre_desarrollo FROM desarrollo');
					if($opciones->num_rows != 0){
						while($fila=$opciones->fetch_assoc()){
							echo '<option value="'.$fila['id_desarrollo'].'">'.$fila['nombre_desarrollo'].'</option>'; 
						}
					}else{
						echo '<option value="">No hay desarrollos</option>';
					}
					conectar("off");
				?>
          	</select><br /><br />
            
            <label for="seldesDepartamento">Depto:</label>
            <select data-placeholder="Seleccione un departamento..." id="seldesDepartamento" class="chosen-select" style="width:260px;" name="depto">
            	<option value=""></option>
            	<?php
					$objConexion = conectar("on");
					$opciones = $objConexion->query('SELECT id_departamento, nombre_departamento FROM departamento');
					if($opciones->num_rows != 0){
						while($fila=$opciones->fetch_assoc()){
							echo '<option value="'.$fila['id_departamento'].'">'.$fila['nombre_departamento'].'</option>'; 
						}
					}else{
						echo '<option value="">No hay departamentos</option>';
					}
					conectar("off");
				?>
          	</select><br /><br /><br />
            
            <label for="monto">Monto:</label>
            <input type="number" onKeyPress="return soloNumeros(event);" id="monto" placeholder="$" name="monto" />
            
            <label for="factura">Factura:</label>
            <input type="file" id="factura" placeholder="Archivos JPG/PDF" name="archivoFactura" />
			
			<label for="comentario">Comentario:</label>
			<textarea id="comentario" placeholder="Comentario y/u observaciones" name="comentario"></textarea>
            
            <input type="hidden" value="scaja" name="ts" />
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