<?php
	
	/* Conexión a la base de datos */
	
	function conectar($onoff){
		//Conexion a la base de datos
		$conexion = "";
		/*PARAMETROS SERVIDOR LOCAL*/
		$servidor="localhost";
		$usuario="spidb"; 
		$clave="spi_123#db";
		$base="spi";

		try {
			$conexion = new mysqli($servidor,$usuario,$clave,$base);
			$conexion->set_charset("utf8");
			if($conexion->connect_errno){
				throw new Exception($conexion->connect_error);
			}
		} catch (Exception $e) {
			throw new Exception("Existen errores en la conexión a la BD ");
		}
		
		if($onoff=="on"){
			// Devuelve objeto de conexion
			return $conexion;

		}else if($onoff=="off"){
			mysql_close($conexion);
		}else{ echo 'Error: No especifico parametro valido'; }
	}
	
	/* Insertar datos en la base de datos */
	
	function agregar($consulta){
		conectar("on");
			mysql_query("SET NAMES 'utf8'");
			mysql_query($consulta);
		conectar("off");
	}
	
	function regresa_id($tipo_solicitud){
		if($tipo_solicitud==3){
			conectar("on");
				$consulta = "SELECT MAX(id_comisiones) as ultimo_ID FROM comisiones";
				$los_ids = mysql_query($consulta);
				while($fila=mysql_fetch_array($los_ids)){
					$el_id=$fila['ultimo_ID'];
				}
			conectar("off");			
		}else{
			conectar("on");
				$consulta = "SELECT MAX(id_solicitud) AS ultimo_ID FROM solicitud WHERE tipo_solicitud=".$tipo_solicitud."";
				$los_ids = mysql_query($consulta);
				while($fila=mysql_fetch_array($los_ids)){
					$el_id=$fila['ultimo_ID'];
				}
			conectar("off");
		}
		return $el_id;
	}
	
?>