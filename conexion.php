<?php
	
	/* Conexión a la base de datos */
	
	function conectar($onoff){
		//Conexion a la base de datos
		
		/*PARAMETROS SERVIDOR FREHOSTIA (PRODUCCION)
		$servidor="mysql12.freehostia.com";
		$usuario="marpug6_usersg"; 
		$clave="shoulder123";
		$base="marpug6_usersg";*/

		/*PARAMETROS SERVIDOR LOCAL*/
		$servidor="localhost";
		$usuario="root"; 
		$clave="";
		$base="spi";
		$conexion = mysql_connect($servidor,$usuario,$clave);
		if($onoff=="on"){
			//Abriendo conexion
			if(!$conexion){
				die("<style type='text/css' media='all'>
						a { text-decoration:none; color:#06C; }
						a:hover { text-decoration:underline; }
						a:visited { color:#06C; }
						p { font-family:'Arial'; font-size:18px; color:#06C; }
			  		</style>
			  		<p align='center'>No se ha podido conectar con la base de datos por causa de un error.</p>
			  		<br /><a href='index.php'><p align='center'>Aceptar</p></a>");
			}
			mysql_select_db($base,$conexion); 
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