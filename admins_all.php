<?php

	include("conexion.php");
	include("expdf.php");
	
	// /*Variables de sesión */
	// if(!isset($_SESSION['usr_ses'])){
	// 	// echo '<script type="text/javascript">window.location.assign("http://www.grilosystems.com");</script>';
	// }
	
	// $id_usr = $_SESSION['id_usr'];
	// $id_tipo = $_SESSION['tipo_usr'];
	// $nombre_usr = $_SESSION['usr_ses'];
	// $correo_usr = $_SESSION['correo_usr'];
	$accion = "";

	/*Javascript y JQuery*/
	$librerias='<script type="text/javascript" src="js/jquery-2.min.js"></script>
			  	<script type="text/javascript" src="js/jqueryui.js"></script>
				<script type="text/javascript" src="js/jquery.validate.js"></script>
			  	<script type="text/javascript" src="js/funComunes.js"></script>
			  	<link type="text/css" href="css/jquery-ui-min.css" rel="stylesheet" />
			  	<link type="text/css" href="css/tablas.css" rel="stylesheet" />
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

	//Esto debe ser restructurado
	if(isset($_REQUEST['accion'])){
		$accion = $_REQUEST['accion'];
	}
	// die($_REQUEST['accion']);
	/*Variables capturadas */
	switch ($accion){
		/*********************************************************USUARIOS****************************************************/
		case "eliminar_usr":
			echo $librerias;
			$id_del=$_REQUEST['id'];
			if($id_usr==$id_del){
					echo $librerias;
					echo '<div id="ventana_del">
						<center><p>NO ES POSIBLE ELIMINARSE ASI MISMO.</p></center>
						<br /><center><button id="aceptar">Aceptar</button></center></div>
						<script type="text/javascript">cargar_ventana("ventana_del","Error al eliminar",330,265);
						$("button").button(); $("#aceptar").click(function(){
								window.location.assign("menu.php");
						});</script>';
			}else{
				$objConexion = conectar("on");
				
					$quepacho=$objConexion->query("DELETE FROM usuario WHERE id_usuario = '".$id_del."'");
				conectar("off");
				if(!$quepacho){
					echo '<div id="ventana_del">
						<p>El usuario no se pudo eliminar, puede ser por las siguientes razones:</p>
						<ul>
							<li>El usuario se encuentra relacionado con otros datos.</li>
							<li>Hay mantenimiento en la base de datos.</li>
							<li>El servidor presenta alg&uacute;n error.</li>
						</ul>
						<br /><center><button id="aceptar">Aceptar</button></center></div>
						<script type="text/javascript">cargar_ventana("ventana_del","Error al eliminar",330,265);
						$("button").button(); $("#aceptar").click(function(){
								window.location.assign("menu.php?tsolicitud=admin_usr");
						});</script>';
				}else{
					echo '<div id="ventana_del">
						<center><p>El usuario fue eliminado exitosamente.</p></center>
						<br /><center><button id="aceptar">Hecho</button></center></div>
						<script type="text/javascript">cargar_ventana("ventana_del","Usuario eliminado",330,265);
						$("button").button(); $("#aceptar").click(function(){
								window.location.assign("menu.php?tsolicitud=admin_usr");
						});</script>';
				}
			}
		break;
		case "editar_usr":
			echo $librerias;
			if($id_tipo==1){
				$objConexion = conectar("on");
				
				$consulta = $objConexion->query("SELECT * FROM usuario WHERE id_usuario='".$_REQUEST['id']."'");
				while($fila=$consulta->fetch_assoc()){
					$tipo_usr_opc=$fila['tipo_usuario'];
					$correo=$fila['email_usuario'];
					$clave=$fila['password_usuario'];
					$nombre=$fila['nombre_usuario'];
					$rfc=$fila['rfc_usuario'];
					$telefono=$fila['telefono_usuario'];
				}
				conectar("off");
				echo '<div id="ventana">';
				echo '<center><table>
						<tr>
							<td><label>Correo: </label></td>
							<td><input type="text" id="correo" value="'.$correo.'" /></td>
						</tr>
						<tr>
							<td><label>Clave: </label></td>
							<td><input type="text" id="clave" value="'.$clave.'" /></td>
						</tr>
						<tr>
							<td><label>Nombre: </label></td>
							<td><input type="text" id="nombre" value="'.$nombre.'" /></td>
						</tr>
					  	<tr>
							<td><label>RFC: </label></td>
							<td><input type="text" id="rfc" value="'.$rfc.'" /></td>
						</tr>
					  	<tr>
							<td><label>Telefono: </label></td>
							<td><input type="text" id="telefono" value="'.$telefono.'" /></td>
						</tr>
						<tr>
							<td><label>Tipo: </label></td>
							<td><select id="tipo_de_usuario">';
							$objConexion = conectar("on");
							
							$opciones=$objConexion->query("SELECT * FROM tipo_usuario");
							while($opcion=mysql_fetch_array($opciones)){
								if($opcion['id_tipo_usuario']==$tipo_usr_opc){
									echo '<option value="'.$opcion['id_tipo_usuario'].'" selected="selected">'.$opcion['tipo'].'</option>';
								}else{
									echo '<option value="'.$opcion['id_tipo_usuario'].'">'.$opcion['tipo'].'</option>';
								}
							}	
							conectar("off");
							echo '</select></td>
						</tr>
					</table></center>
					<br /><center><button id="actualizar">Actualizar</button>&nbsp;<button id="cerrar">Cerrar</button></center>
					</div>
					<script type="text/javascript">
						cargar_ventana("ventana","Editar Usuario",330,265);
						$("button").button();
						$("#cerrar").click(function(){
							window.location.assign("menu.php?tsolicitud=admin_usr");
						});
						$("#actualizar").click(function(){
							var valida=verifica(3);
							var correo = $("#correo").val();
							var clave = $("#clave").val();
							var nombre = $("#nombre").val();
							var rfc = $("#rfc").val();
							var telefono = $("#telefono").val();
							var tipo = $("#tipo_de_usuario").val();
							var dato = "accion=actualizar_usr&datos="+correo+","+clave+","+nombre+","+rfc+","+telefono+","+tipo+","+valida+","+'.$_REQUEST['id'].';
							enviar_datos_ajax("admins_all.php",dato,"");
						});
					</script>';
			}else{
				header("Location: menu.php");
			}
		break;
		case "actualizar_usr":
			/* Recibir los datos
				separar los datos por medio de las comas
				guardarlos en variables
				actualizar en la BD con las variables (datos nuevos)
				llamar a la ventana para informar que se han actualizado */
			$cadena_datos=$_POST['datos'];
			$datos_req = preg_split( '[,]',$cadena_datos); //correo 0,clave 1,nombre 2,rfc 3,telefono 4,tipo 5,validacion 6,usuario 7

			if($datos_req[6]=="true"){
				$objConexion = conectar("on");
				
				$consulta_actualizar="UPDATE `usuario` SET `email_usuario`='".$datos_req[0]."', `password_usuario`='".$datos_req[1]."', `nombre_usuario`='".$datos_req[2]."', `rfc_usuario`='".$datos_req[3]."', `tipo_usuario`='".$datos_req[5]."', `telefono_usuario`='".$datos_req[4]."' WHERE `id_usuario`='".$datos_req[7]."'";
				$objConexion->query($consulta_actualizar);
				conectar("off");
				echo '<div id="ventana_actualizado">
						<p>Se han actualizado los datos del usuario: <br />
						<center>'.$datos_req[2].'</center></p><br />
						<center><button id="actualizar">Hecho</button></center>
					  </div>
					 <script type="text/javascript">
						cargar_ventana("ventana_actualizado","Usuario actualizado",330,265);
						$("button").button();
						$("#actualizar").click(function(){
							window.location.assign("menu.php?tsolicitud=admin_usr");
						});
					  </script>';
			}else{
				echo $librerias;
				echo '<div id="ventana_actualizado">
				      <p>Existen errores en los datos que introdujo, verifique lo siguiente:<br />
					  <ul>'.$datos_req[6].'</ul><br /></p>
						<center><button id="actualizar">Aceptar</button></center>
					  </div>
					 <script type="text/javascript">
						cargar_ventana("ventana_actualizado","Error al actualizar",330,265);
						$("button").button();
						$("#actualizar").click(function(){
							window.location.assign("admins_all.php?accion=editar_usr&id='.$datos_req[7].'");
						});
					  </script>';
			}
		break;
		case "agregar_usr":
				echo $librerias;
				echo '<div id="ventana">';
				echo '<center><table>
						<tr>
							<td><label>Correo: </label></td>
							<td><input type="text" id="correo" /></td>
						</tr>
						<tr>
							<td><label>Clave: </label></td>
							<td><input type="text" id="clave" /></td>
						</tr>
						<tr>
							<td><label>Nombre: </label></td>
							<td><input type="text" id="nombre" /></td>
						</tr>
					  	<tr>
							<td><label>RFC: </label></td>
							<td><input type="text" id="rfc" /></td>
						</tr>
					  	<tr>
							<td><label>Telefono: </label></td>
							<td><input type="text" id="telefono" /></td>
						</tr>
						<tr>
							<td><label>Tipo: </label></td>
							<td><select id="tipo_de_usuario">';
							$objConexion = conectar("on");
							
							$opciones=$objConexion->query("SELECT * FROM tipo_usuario");
							while($opcion=mysql_fetch_array($opciones)){
								if($opcion['id_tipo_usuario']==$tipo_usr_opc){
									echo '<option value="'.$opcion['id_tipo_usuario'].'" selected="selected">'.$opcion['tipo'].'</option>';
								}else{
									echo '<option value="'.$opcion['id_tipo_usuario'].'">'.$opcion['tipo'].'</option>';
								}
							}	
							conectar("off");
							echo '</select></td></tr></table></center>
							<br /><center><button id="agregar">Agregar usuario</button>&nbsp;<button id="cerrar">Cancelar</button></center></div>
						<script type="text/javascript">
							cargar_ventana("ventana","Agregar Usuario",330,265);
							$("#agregar").button(); $("#cerrar").button();
							$("#agregar").click(function(){
								var valida = verifica(3);
								var correo = $("#correo").val();
								var clave = $("#clave").val();
								var nombre = $("#nombre").val();
								var rfc = $("#rfc").val();
								var telefono = $("#telefono").val();
								var tipo = $("#tipo_de_usuario").val();
								var dato="accion=grabar_usr&datos="+correo+","+clave+","+nombre+","+rfc+","+telefono+","+tipo+","+valida;
								enviar_datos_ajax("admins_all.php",dato,"ventana");
							});
							$("#cerrar").click(function(){
								window.location.assign("menu.php");
							});
							
						</script>';
		break;
		case "grabar_usr":
			$cadena_datos = $_POST['datos'];
			$datos_req = preg_split('[,]',$cadena_datos); //correo 0, clave 1, nombre 2, rfc 3, telefono 4, tipo 5, valida 6
			$valido = $datos_req[6];
			if($valido=="true"){
				$consulta_grabar="INSERT INTO `usuario` (`tipo_usuario`, `email_usuario`, `password_usuario`, `nombre_usuario`, `rfc_usuario`) VALUES ('".$datos_req[5]."', '".$datos_req[0]."', '".$datos_req[1]."', '".$datos_req[2]."', '".$datos_req[3]."')";
				$objConexion = conectar("on");
				
					$quepacho=$objConexion->query($consulta_grabar);
				conectar("off");
				if(!$quepacho){
					echo '<p align="center">Error al grabar los datos, puede ser por las siguentes razones:<br /><ul><li>El usuario ya existe.</li><li>Se esta dando mantenimiento a la base de datos.</li><li>Se esta realizando mantenimiento al sistema</li>';
				}else{
				echo '<p align="center">El usuario: '.$datos_req[0].' se ha agregado satisfactoriamente.<br />Datos del usuario: <ul><li>Usuario: '.$datos_req[0].'</li><li>Nombre de usuario: '.$datos_req[2].'</li><li>RFC: '.$datos_req[3].'</li><li>Telefono: '.$datos_req[4].'</li><li>Tipo de usuario: '.$datos_req[5].'</li></ul></p><center><button id="cerrar">Hecho</button></center><script type="text/javascript">$("#cerrar").button(); $("#cerrar").click(function(){window.location.assign("admins_all.php?accion=agregar_usr");});</script>';
				}
			}else{
				echo '<p align="center"><h5>Error en los datos capturados, fueron los siguientes: <br /><ul>'.$valido.'<li>Verifique el tipo de usuario sea el correcto.</li></ul></h5></p><br /><center><button id="aceptar">Aceptar</button></center>
				<script type="text/javascript">$("#aceptar").button(); $("#aceptar").click(function(){window.location.assign("admins_all.php?accion=agregar_usr");});</script>';
			}
		break;
		/*********************************************************DESARROLLOS****************************************************/
		case "eliminar_des":
			echo $librerias;
			$id_del=$_REQUEST['id'];
				$objConexion = conectar("on");
				
					$quepacho=$objConexion->query("DELETE FROM desarrollo WHERE id_desarrollo = '".$id_del."'");
				conectar("off");
				if(!$quepacho){
					echo '<div id="ventana_del">
						<p>El desarrollo no se pudo eliminar, puede ser por las siguientes razones:</p>
						<ul>
							<li>El desarrollo se encuentra relacionado con otros datos.</li>
							<li>Hay mantenimiento en la base de datos.</li>
							<li>El servidor presenta alg&uacute;n error.</li>
						</ul>
						<br /><center><button id="aceptar">Aceptar</button></center></div>
						<script type="text/javascript">cargar_ventana("ventana_del","Error al eliminar",330,265);
						$("button").button(); $("#aceptar").click(function(){
								window.location.assign("menu.php?tsolicitud=admin_des");
						});</script>';
				}else{
					echo '<div id="ventana_del">
						<center><p>El desarrollo fue eliminado exitosamente.</p></center>
						<br /><center><button id="aceptar">Hecho</button></center></div>
						<script type="text/javascript">cargar_ventana("ventana_del","Desarrollo eliminado",330,265);
						$("button").button(); $("#aceptar").click(function(){
								window.location.assign("menu.php?tsolicitud=admin_des");
						});</script>';
				}
		break;
		case "editar_des":
		echo $librerias;
		if($id_tipo==1){
				$objConexion = conectar("on");
				
				$consulta = $objConexion->query("SELECT * FROM desarrollo WHERE id_desarrollo='".$_REQUEST['id']."'");
				while($fila=$consulta->fetch_assoc()){
					$desarrollo=$fila['nombre_desarrollo'];
					$rfc_des=$fila['rfc_desarrollo'];
					$dir_des=$fila['diereccion_desarrollo'];
					$usr_des=$fila['usuario_desarrollo'];
				}
				conectar("off");
				echo '<div id="ventana">';
				echo '<center><table>
						<tr>
							<td><label>Desarrollo: </label></td>
							<td><input type="text" id="desarrollo" value="'.$desarrollo.'" /></td>
						</tr>
						<tr>
							<td><label>RFC: </label></td>
							<td><input type="text" id="rfc" value="'.$rfc_des.'" /></td>
						</tr>
						<tr>
							<td><label>Direcci&oacute;n: </label></td>
							<td><input type="text" id="direccion" value="'.$dir_des.'" /></td>
						</tr>
					  	<tr>
							<td><label>Titular: </label></td>
							<td><select id="titular_des">';
							$objConexion = conectar("on");
							
							$opciones=$objConexion->query("SELECT id_usuario, nombre_usuario FROM usuario");
							while($opcion=mysql_fetch_array($opciones)){
								if($opcion['id_usuario']==$usr_des){
									echo '<option value="'.$opcion['id_usuario'].'" selected="selected">'.$opcion['nombre_usuario'].'</option>';
								}else{
									echo '<option value="'.$opcion['id_usuario'].'">'.$opcion['nombre_usuario'].'</option>';
								}
							}	
							conectar("off");
							echo '</select></td>
						</tr>
					</table></center>
					<br /><center><button id="actualizar">Actualizar</button>&nbsp;<button id="cerrar">Cerrar</button></center>
					</div>
					<script type="text/javascript">
						cargar_ventana("ventana","Editar Desarrollo",330,265);
						$("button").button();
						$("#cerrar").click(function(){
							window.location.assign("menu.php?tsolicitud=admin_des");
						});
						$("#actualizar").click(function(){
							var valida=verifica(4);
							var desarrollo = $("#desarrollo").val();
							var rfc = $("#rfc").val();
							var direccion = $("#direccion").val();
							var titular_des = $("#titular_des").val();
							var dato = "accion=actualizar_des&datos="+desarrollo+","+rfc+","+direccion+","+titular_des+","+valida+","+'.$_REQUEST['id'].';
							enviar_datos_ajax("admins_all.php",dato,"");
						});
					</script>';
			}else{
				header("Location: menu.php");
			}
		break;
		case "actualizar_des":
			/* Recibir los datos
				separar los datos por medio de las comas
				guardarlos en variables
				actualizar en la BD con las variables (datos nuevos)
				llamar a la ventana para informar que se han actualizado */
				$cadena_datos=$_POST['datos'];
				$datos_req = preg_split( '[,]',$cadena_datos); //desarrollo 0,rfc 1,direccion 2,titular_des 3,validacion 4,usuario 5
				if($datos_req[4]=="true"){
					$objConexion = conectar("on");
					
				$consulta_actualizar="UPDATE `desarrollo` SET `nombre_desarrollo`='".$datos_req[0]."', `rfc_desarrollo`='".$datos_req[1]."', `diereccion_desarrollo`='".$datos_req[2]."', `usuario_desarrollo`='".$datos_req[3]."' WHERE `id_desarrollo`='".$datos_req[5]."'";
				$objConexion->query($consulta_actualizar);
				conectar("off");
				echo '<div id="ventana_actualizado">
						<p>Se han actualizado los datos del desarrollo: <br />
						<center>'.$datos_req[0].'</center></p><br />
						<center><button id="actualizar">Hecho</button></center>
					  </div>
					 <script type="text/javascript">
						cargar_ventana("ventana_actualizado","Desarrollo actualizado",330,265);
						$("button").button();
						$("#actualizar").click(function(){
							window.location.assign("menu.php?tsolicitud=admin_des");
						});
					  </script>';
			}else{
				echo $librerias;
				echo '<div id="ventana_actualizado">
				      <p>Existen errores en los datos que introdujo, verifique lo siguiente:<br />
					  <ul>'.$datos_req[4].'</ul><br /></p>
						<center><button id="actualizar">Aceptar</button></center>
					  </div>
					 <script type="text/javascript">
						cargar_ventana("ventana_actualizado","Error al actualizar",330,265);
						$("button").button();
						$("#actualizar").click(function(){
							window.location.assign("admins_all.php?accion=editar_des&id='.$datos_req[5].'");
						});
					  </script>';
			}				
		break;
		case "agregar_des":
			echo $librerias;
			echo '<div id="ventana">';
			echo '<center><table>
					<tr>
						<td><label>Desarrollo: </label></td>
						<td><input type="text" id="desarrollo" value="" /></td>
					</tr>
					<tr>
						<td><label>RFC: </label></td>
						<td><input type="text" id="rfc" value="" /></td>
					</tr>
					<tr>
						<td><label>Direcci&oacute;n: </label></td>
						<td><input type="text" id="direccion" value="" /></td>
					</tr>
					<tr>
						<td><label>Titular: </label></td>
						<td><select id="titular_des">';
						$objConexion = conectar("on");
						
						$opciones=$objConexion->query("SELECT id_usuario, nombre_usuario FROM usuario");
						while($opcion=mysql_fetch_array($opciones)){
							if($opcion['id_usuario']==$usr_des){
								echo '<option value="'.$opcion['id_usuario'].'" selected="selected">'.$opcion['nombre_usuario'].'</option>';
							}else{
								echo '<option value="'.$opcion['id_usuario'].'">'.$opcion['nombre_usuario'].'</option>';
							}
						}	
						conectar("off");
						echo '</select></td>
					</tr>
				</table></center>
				<br /><center><button id="agregar">Agregar desarrollo</button>&nbsp;<button id="cerrar">Cerrar</button></center></div>
				<script type="text/javascript">
					cargar_ventana("ventana","Agregar Desarrollo",330,265);
					$("#agregar").button(); $("#cerrar").button();
					$("#agregar").click(function(){
								var valida=verifica(4);
								var desarrollo = $("#desarrollo").val();
								var rfc = $("#rfc").val();
								var direccion = $("#direccion").val();
								var titular_des = $("#titular_des").val();
								var dato = "accion=grabar_des&datos="+desarrollo+","+rfc+","+direccion+","+titular_des+","+valida;
								enviar_datos_ajax("admins_all.php",dato,"ventana")
							});
							$("#cerrar").click(function(){
								window.location.assign("menu.php");
							});
				</script>';
		break;
		case "grabar_des":
			$cadena_datos = $_POST['datos'];
			$datos_req = preg_split('[,]',$cadena_datos); //desarrollo 0, rfc 1, direccion 2, titular 3, valida 4
			$valido = $datos_req[4];
			if($valido=="true"){
				$consulta_grabar="INSERT INTO `desarrollo` (`nombre_desarrollo`, `rfc_desarrollo`, `diereccion_desarrollo`, `usuario_desarrollo`) VALUES ('".$datos_req[0]."', '".$datos_req[1]."', '".$datos_req[2]."', '".$datos_req[3]."')";
				$objConexion = conectar("on");
				
					$quepacho=$objConexion->query($consulta_grabar);
				conectar("off");
				if(!$quepacho){
					echo '<p align="center">Error al grabar los datos, puede ser por las siguentes razones:<br /><ul><li>El desarrollo ya existe.</li><li>Se esta dando mantenimiento a la base de datos.</li><li>Se esta realizando mantenimiento al sistema</li>';
				}else{
				echo '<p align="center">El desarrollo: '.$datos_req[0].' se ha agregado satisfactoriamente.<br />Datos del desarrollo: <ul><li>Desarrollo: '.$datos_req[0].'</li><li>RFC: '.$datos_req[1].'</li><li>Direcci&oacute;n: '.$datos_req[2].'</li><li>Titular: '.$datos_req[3].'</li></ul></p><center><button id="cerrar">Hecho</button></center><script type="text/javascript">$("#cerrar").button(); $("#cerrar").click(function(){window.location.assign("admins_all.php?accion=agregar_des");});</script>';
				}
			}else{
				echo '<p align="center"><h5>Error en los datos capturados, fueron los siguientes: <br /><ul>'.$valido.'<li>Verifique que si esten disponibles usuarios titulares accesibles.</li></ul></h5></p><br /><center><button id="aceptar">Aceptar</button></center>
				<script type="text/javascript">$("#aceptar").button(); $("#aceptar").click(function(){window.location.assign("admins_all.php?accion=gregar_des");});</script>';
			}
		break;
		/*********************************************************DEPARTAMENTOS****************************************************/
		case "eliminar_dep":
			echo $librerias;
			$id_del=$_REQUEST['id'];
			$objConexion = conectar("on");
			
				$quepacho=$objConexion->query("DELETE FROM departamento WHERE id_departamento = '".$id_del."'");
			conectar("off");
			if(!$quepacho){
					echo '<div id="ventana_del">
						<p>El departamento no se pudo eliminar, puede ser por las siguientes razones:</p>
						<ul>
							<li>El departamento se encuentra relacionado con otros datos.</li>
							<li>Hay mantenimiento en la base de datos.</li>
							<li>El servidor presenta alg&uacute;n error.</li>
						</ul>
						<br /><center><button id="aceptar">Aceptar</button></center></div>
						<script type="text/javascript">cargar_ventana("ventana_del","Error al eliminar",330,265);
						$("button").button(); $("#aceptar").click(function(){
								window.location.assign("menu.php?tsolicitud=admin_dep");
						});</script>';
				}else{
					echo '<div id="ventana_del">
						<center><p>El departamento fue eliminado exitosamente.</p></center>
						<br /><center><button id="aceptar">Hecho</button></center></div>
						<script type="text/javascript">cargar_ventana("ventana_del","Departamento eliminado",330,265);
						$("button").button(); $("#aceptar").click(function(){
								window.location.assign("menu.php?tsolicitud=admin_dep");
						});</script>';
				}
		break;
		case "editar_dep":
		echo $librerias;
		if($id_tipo==1){
				$objConexion = conectar("on");
				
				$consulta = $objConexion->query("SELECT * FROM departamento WHERE id_departamento='".$_REQUEST['id']."'");
				while($fila=$consulta->fetch_assoc()){
					$departamento=$fila['nombre_departamento'];
				}
				conectar("off");
				echo '<div id="ventana">';
				echo '<center><table>
						<tr>
							<td><label>Departamento: </label></td>
							<td><input type="text" id="departamento" value="'.$departamento.'" /></td>
						</tr>
					</table></center>
					<br /><center><button id="actualizar">Actualizar</button>&nbsp;<button id="cerrar">Cerrar</button></center>
					</div>
					<script type="text/javascript">
						cargar_ventana("ventana","Editar Departamento",330,200);
						$("button").button();
						$("#cerrar").click(function(){
							window.location.assign("menu.php?tsolicitud=admin_dep");
						});
						$("#actualizar").click(function(){
							var valida=verifica(5);
							var departamento = $("#departamento").val();
							var dato = "accion=actualizar_dep&datos="+departamento+","+valida+","+'.$_REQUEST['id'].';
							enviar_datos_ajax("admins_all.php",dato,"");
						});
					</script>';
			}else{
				header("Location: menu.php");
			}
		break;
		case "actualizar_dep":
			/* Recibir los datos
			separar los datos por medio de las comas
			guardarlos en variables
			actualizar en la BD con las variables (datos nuevos)
			llamar a la ventana para informar que se han actualizado */
			$cadena_datos=$_POST['datos'];
			$datos_req = preg_split( '[,]',$cadena_datos); //departamento 0,valida 1,usuario 2
			if($datos_req[1]=="true"){
			$objConexion = conectar("on");
			
				$consulta_actualizar="UPDATE `departamento` SET `nombre_departamento`='".$datos_req[0]."' WHERE `id_departamento`='".$datos_req[2]."'";
				$objConexion->query($consulta_actualizar);
			conectar("off");
			echo '<div id="ventana_actualizado">
					<p>Se han actualizado los datos del departamento: <br />
					<center>'.$datos_req[0].'</center></p><br />
					<center><button id="actualizar">Hecho</button></center>
				  </div>
				 <script type="text/javascript">
					cargar_ventana("ventana_actualizado","Desarrollo actualizado",330,265);
					$("button").button();
					$("#actualizar").click(function(){
						window.location.assign("menu.php?tsolicitud=admin_dep");
					});
				  </script>';
		}else{
			echo $librerias;
			echo '<div id="ventana_actualizado">
				  <p>Existen errores en los datos que introdujo, verifique lo siguiente:<br />
				  <ul>'.$datos_req[1].'</ul><br /></p>
					<center><button id="actualizar">Aceptar</button></center>
				  </div>
				 <script type="text/javascript">
					cargar_ventana("ventana_actualizado","Error al actualizar",330,265);
					$("button").button();
					$("#actualizar").click(function(){
						window.location.assign("admins_all.php?accion=editar_dep&id='.$datos_req[2].'");
					});
				  </script>';
		}
		break;
		case "agregar_dep":
				echo $librerias;
				echo '<div id="ventana">';
				echo '<center><table>
						<tr>
							<td><label>Departamento: </label></td>
							<td><input type="text" id="departamento" /></td>
						</tr>
					</table></center>
					<br /><center><button id="agregar">Agregar departamento</button>&nbsp;<button id="cerrar">Cerrar</button></center></div>
					<script type="text/javascript">
						cargar_ventana("ventana","Agregar Departamento",400,200);
						$("#agregar").button(); $("#cerrar").button();
						$("#agregar").click(function(){
							var valida=verifica(5);
							var departamento = $("#departamento").val();
							var dato = "accion=grabar_dep&datos="+departamento+","+valida;
							enviar_datos_ajax("admins_all.php",dato,"ventana");
						});
						$("#cerrar").click(function(){
								window.location.assign("menu.php");
						});
					</script>';
		break;
		case "grabar_dep":
			$cadena_datos = $_POST['datos'];
			$datos_req = preg_split('[,]',$cadena_datos); //departamento 0, valida 1
			$valido = $datos_req[1];
			if($valido=="true"){
				$consulta_grabar="INSERT INTO `departamento` (`nombre_departamento`) VALUES ('".$datos_req[0]."')";
				$objConexion = conectar("on");
				
					$quepacho=$objConexion->query($consulta_grabar);
				conectar("off");
				if(!$quepacho){
					echo '<p align="center">Error al grabar los datos, puede ser por las siguentes razones:<br /><ul><li>El departamento ya existe.</li><li>Se esta dando mantenimiento a la base de datos.</li><li>Se esta realizando mantenimiento al sistema</li>';
				}else{
				echo '<p align="center">El departamento: '.$datos_req[0].' se ha agregado satisfactoriamente.<br />Datos del departamento: <ul><li>Departamento: '.$datos_req[0].'</li></p><center><button id="cerrar">Hecho</button></center><script type="text/javascript">$("#cerrar").button(); $("#cerrar").click(function(){window.location.assign("admins_all.php?accion=agregar_dep");});</script>';
				}
			}else{
				echo '<p align="center"><h5>Error en los datos capturados, fueron los siguientes: <br /><ul>'.$valido.'</ul></h5></p><br /><center><button id="aceptar">Aceptar</button></center>
				<script type="text/javascript">$("#aceptar").button(); $("#aceptar").click(function(){window.location.assign("admins_all.php?accion=agregar_dep");});</script>';
			}
		break;
/*********************************************** CLIENTES *******************************************************************/
		case "eliminar_cli":
			$id_del=$_REQUEST['id'];
			$objConexion = conectar("on");
			
				$quepacho=$objConexion->query("DELETE FROM cliente WHERE id_cliente = '".$id_del."'");
			conectar("off");
			if(!$quepacho){
					echo $librerias;
					echo '<div id="ventana_del">
						<p>El cliente no se pudo eliminar, puede ser por las siguientes razones:</p>
						<ul>
							<li>El cliente se encuentra relacionado con otros datos.</li>
							<li>Hay mantenimiento en la base de datos.</li>
							<li>El servidor presenta alg&uacute;n error.</li>
						</ul>
						<br /><center><button id="aceptar">Aceptar</button></center></div>
						<script type="text/javascript">cargar_ventana("ventana_del","Error al eliminar",330,265);
						$("button").button(); $("#aceptar").click(function(){
								window.location.assign("menu.php?tsolicitud=admin_cli");
						});</script>';
				}else{
					echo $librerias;
					echo '<div id="ventana_del">
						<center><p>El cliente fue eliminado exitosamente.</p></center>
						<br /><center><button id="aceptar">Hecho</button></center></div>
						<script type="text/javascript">cargar_ventana("ventana_del","Cliente eliminado",330,265);
						$("button").button(); $("#aceptar").click(function(){
								window.location.assign("menu.php?tsolicitud=admin_cli");
						});</script>';
				}
		break;
		case "editar_cli":
		echo $librerias;
		if($id_tipo==1){
				$objConexion = conectar("on");
				
				$consulta = $objConexion->query("SELECT * FROM cliente WHERE id_cliente='".$_REQUEST['id']."'");
				while($fila=$consulta->fetch_assoc()){
					$cliente=$fila['nombre_cliente'];
					$departamentoCliente=$fila['depto_cliente'];
					$comentarioCliente=$fila['comentarios_cliente'];
					$id_asesorCliente=$fila['asesor_cliente'];
				}
				conectar("off");
				echo '<div id="ventana">';
				echo '<center><table>
						<tr>
							<td><label>Cliente: </label></td>
							<td><input type="text" id="nomCliente" value="'.$cliente.'" /></td>
						</tr>
						<tr>
							<td><label>Departamento: </label></td>
							<td><input type="text" id="deptoCliente" value="'.$departamentoCliente.'" /></td>
						</tr>
						<tr>
						<td><label>Asesor: </label></td>
						<td><select id="seldesAsesor">';
						$objConexion = conectar("on");
						
						$opciones=$objConexion->query("SELECT id_usuario, nombre_usuario FROM usuario");
						while($opcion=mysql_fetch_array($opciones)){
							if($opcion['id_usuario']==$id_asesorCliente){
								echo '<option value="'.$opcion['id_usuario'].'" selected="selected">'.$opcion['nombre_usuario'].'</option>';
							}else{
								echo '<option value="'.$opcion['id_usuario'].'">'.$opcion['nombre_usuario'].'</option>';
							}
						}	
						conectar("off");
						echo '</select></td>
					</tr>
						<tr>
							<td><label>Comentarios: </label></td>
							<td><textarea id="comentCliente">'.$comentarioCliente.'</textarea></td>
						</tr>
					</table></center>
					<br /><center><button id="actualizar">Actualizar</button>&nbsp;<button id="cerrar">Cerrar</button></center>
					</div>
					<script type="text/javascript">
						cargar_ventana("ventana","Editar Cliente",330,200);
						$("button").button();
						$("#cerrar").click(function(){
							window.location.assign("menu.php?tsolicitud=admin_cli");
						});
						$("#actualizar").click(function(){
							var valida=verifica(7);
							var nombre = $("#nomCliente").val();
							var depto = $("#deptoCliente").val();
							var asesor = $("#seldesAsesor").val();
							var comentCliente = $("#comentCliente").val();
							var dato = "accion=actualizar_cli&datos="+nombre+","+depto+","+asesor+","+valida+","+comentCliente+","+'.$_REQUEST['id'].';
							enviar_datos_ajax("admins_all.php",dato,"");
						});
					</script>';
			}else{
				header("Location: menu.php");
			}
		break;
		case "actualizar_cli":
			/* Recibir los datos
			separar los datos por medio de las comas
			guardarlos en variables
			actualizar en la BD con las variables (datos nuevos)
			llamar a la ventana para informar que se han actualizado */
			$cadena_datos=$_POST['datos'];
			$datos_req = preg_split( '[,]',$cadena_datos); //nombre 0, depto 1, asesor 2, valida 3, comentario 4, idCliente 5
			if($datos_req[3]=="true"){
			$objConexion = conectar("on");
			
				$consulta_actualizar="UPDATE `cliente` SET `nombre_cliente`='".$datos_req[0]."', `depto_cliente`='".$datos_req[1]."', `asesor_cliente`='".$datos_req[2]."', `comentarios_cliente`='".$datos_req[4]."' WHERE `id_cliente`='".$datos_req[5]."'";
				$objConexion->query($consulta_actualizar);
			conectar("off");
			echo '<div id="ventana_actualizado">
					<p>Se han actualizado los datos del cliente: <br />
					<center>'.$datos_req[0].'</center></p><br />
					<center><button id="actualizar">Hecho</button></center>
				  </div>
				 <script type="text/javascript">
					cargar_ventana("ventana_actualizado","Cliente actualizado",330,265);
					$("button").button();
					$("#actualizar").click(function(){
						window.location.assign("menu.php?tsolicitud=admin_cli");
					});
				  </script>';
		}else{
			echo $librerias;
			echo '<div id="ventana_actualizado">
				  <p>Existen errores en los datos que introdujo, verifique lo siguiente:<br />
				  <ul>'.$datos_req[3].'</ul><br /></p>
					<center><button id="actualizar">Aceptar</button></center>
				  </div>
				 <script type="text/javascript">
					cargar_ventana("ventana_actualizado","Error al actualizar",330,265);
					$("button").button();
					$("#actualizar").click(function(){
						window.location.assign("admins_all.php?accion=editar_cli&id='.$datos_req[2].'");
					});
				  </script>';
		}
		break;
/********************************************************* ADMINISTRACION DE SOLICITUDES *******************************************************************/
		case "adm_rcc":
			echo '<link rel="stylesheet" href="css/gridstyle/css/bootstrap.css"/>
				  <link rel="stylesheet" href="css/grid.css"/>
				  <script src="js/root.js"></script>
				  <script src="js/grid.js"></script>
				  <script type="text/javascript">
				  	var dato="accion=detalles_solicitudes&tipo=rcc&numeroSolicitud=";
					function solicitar(msg){
						enviar_datos_ajax("admins_all.php",msg,"ventana");
					}
				  </script>
				  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				  <center>
				  <table class="grid caja" action="ajax_grid.php?tsajax=cja">
					<tr>	
						<th col="id_solicitud" width="8" href="javascript:solicitar(dato+{{value}})">#</th>
						<th col="fecha_requerida_solicitud" width="80">Fecha</th>
						<th col="tipo_departamento_solicitud" width="100">Depto</th>
						<th col="importe_solicitud" type="money" width="70">Monto</th>
						<th col="concepto_solicitud" width="195">Concepto</th>
						<th col="factura_solicitud" width="70">Factura</th>
						<th col="estatus_solicitud" type="select" width="150">Estado</th>
					</tr>
				</table>
				</center><br />
				<p align="center"><strong>Para mas informaci&oacute;n sobre la solicitud, haga click sobre el n&uacute;mero de la solicitud.</strong></p>
			<br /><center><button id="reversa">Regresar</button></center>
			<script type="text/javascript">
				$(function() {
					var $grid = $(".caja").grid({
						title : "Proveedores",
						page : 1,
						showPager : true,
						editing : true,
						deleting : false,
						nRowsShowing : 10,
						width: 730,
						deleting : false
					});
				});
				$("#reversa").button();
				$("#reversa").click(function(){
					window.location.assign("menu.php?tsolicitud=admin_soli");
				});
			</script>';
		break;
		case "adm_comi":
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				  <link rel="stylesheet" href="css/gridstyle/css/bootstrap.css"/>
				  <link rel="stylesheet" href="css/grid.css"/>
				  <script src="js/root.js"></script>
				  <script src="js/grid.js"></script>
				  <script type="text/javascript">
				  	var dato="accion=detalles_solicitudes&tipo=comi&numeroSolicitud=";
					function solicitar(msg){
						enviar_datos_ajax("admins_all.php",msg,"ventana");
					}
				  </script>
				  <center>
				  <table class="grid comisiones" action="ajax_grid.php?tsajax=cims">
					<tr>	
						<th col="id_comisiones" width="8" href="javascript:solicitar(dato+{{value}})">#</th>
						<th col="cliente_comisiones" width="201">Cliente</th>
						<th col="monto_comisiones" type="money" width="73">Monto</th>
						<th col="anticipo_comisiones" type="money" width="73">Anticipo</th>
						<th col="resto" type="money" width="73">Resto</th>
						<th col="factura_comisiones" width="73">Factura</th>
						<th col="estatus_comisiones" type="select" width="150">Estado</th>
					</tr>
				</table>
				</center><br />
				<p align="center"><strong>Para mas informaci&oacute;n sobre la solicitud, haga click sobre el n&uacute;mero de la solicitud.</strong></p>
			<br /><center><button id="reversa">Regresar</button></center>
			<script type="text/javascript">
				$(function() {
					var $grid = $(".comisiones").grid({
						title : "Comisiones",
						page : 1,
						showPager : true,
						editing : true,
						deleting : false,
						nRowsShowing : 10,
						width: 762,
						deleting : false
					});
				});
				$("#reversa").button();
				$("#reversa").click(function(){
					window.location.assign("menu.php?tsolicitud=admin_soli");
				});
			</script>';
		break;
		case "adm_prove":
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				  <link rel="stylesheet" href="css/gridstyle/css/bootstrap.css"/>
				  <link rel="stylesheet" href="css/grid.css"/>
				  <script src="js/root.js"></script>
				  <script src="js/grid.js"></script>
				  <script type="text/javascript">
				  	var dato="accion=detalles_solicitudes&tipo=prove&numeroSolicitud=";
					function solicitar(msg){
						enviar_datos_ajax("admins_all.php",msg,"ventana");
					}
				  </script>
				  <center>
				  <table class="grid proveedor" action="ajax_grid.php?tsajax=prv">
					<tr>	
						<th col="id_solicitud" width="8" href="javascript:solicitar(dato+{{value}})">#</th>
						<th col="fecha_requerida_solicitud" width="80">Fecha</th>
						<th col="tipo_departamento_solicitud" width="100">Depto</th>
						<th col="importe_solicitud" type="money" width="70">Monto</th>
						<th col="concepto_solicitud" width="195">Concepto</th>
						<th col="factura_solicitud" width="70">Factura</th>
						<th col="estatus_solicitud" type="select" width="150">Estado</th>
					</tr>
				</table>
				</center><br />
				<p align="center"><strong>Para mas informaci&oacute;n sobre la solicitud, haga click sobre el n&uacute;mero de la solicitud.</strong></p>
			<br /><center><button id="reversa">Regresar</button></center>
			<script type="text/javascript">
				$(function() {
					var $grid = $(".proveedor").grid({
						title : "Usuario",
						page : 1,
						showPager : true,
						editing : true,
						deleting : false,
						nRowsShowing : 10,
						width: 730,
						deleting : false
					});
				});
				$("#reversa").button();
				$("#reversa").click(function(){
					window.location.assign("menu.php?tsolicitud=admin_soli");
				});
			</script>';
		break;
/********************************************************* CONFIGURACION DE CUENTA *****************************************************************/
		case "admin_usr_correo":
			echo $librerias;
			echo '<div id="ventana">
					Correo de: <strong>'.$nombre_usr.'<br /><br />
					Nuevo correo: <input type="text" id="correo_nuevo" name="correo_nuevo" value="'.$correo_usr.'"><br /><br />
					<div id="error"></div><br /><br />
					<center><button id="cambiar">Cambiar</button><button id="cerrar">Cerrar</button></center>
				  </div>
				  <script type="text/javascript">
				  	cargar_ventana("ventana","Editar mi correo electronico",400,200);
				  	$("button").button();
					$("#cerrar").click(function(){
						cerrar_solicitud("'.$id_tipo.'");
					});
					$("#cambiar").click(function(){
						var cadena=$("#correo_nuevo").val();
						$("#correo_nuevo").attr("value",$.trim(cadena));
						var filter=/^[A-Za-z][A-Za-z0-9_]*@[A-Za-z0-9_]+\.[A-Za-z0-9_.]+[A-za-z]$/;
						if($("#correo_nuevo").val()!=""){
							if($("#correo_nuevo").val()!="'.$correo_usr.'"){
								if (!(filter.test($("#correo_nuevo").val()))){
									$("#error").html(\'<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Error:</strong> Debe escribir un correo valido.</p></div></div>\');
								}else{
									$("#error").html("");
									var correo_nuevo=$("#correo_nuevo").val();
									var correo_anterior="'.$correo_usr.'";
									var dato="accion=cambiar_correo_usuario_actual&correo_viejo="+correo_anterior+"&correo_nuevo="+correo_nuevo;
									enviar_datos_ajax("admins_all.php",dato,"ventana");
								}
							}else{
								$("#error").html(\'<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Error:</strong> El correo no es nuevo.</p></div></div>\');
							}
						}else{
							$("#error").html(\'<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Error:</strong> Debe escribir un correo.</p></div></div>\');
						}
					});
				  </script>';
		break;
		case "cambiar_correo_usuario_actual":
			$objConexion = conectar("on");
				
				$consulta_actualizar_correo='UPDATE `usuario` SET `email_usuario`="'.$_POST['correo_nuevo'].'" WHERE `id_usuario`='.$id_usr.'';
				$objConexion->query($consulta_actualizar_correo);
			conectar("off");
			$_SESSION['correo_usr']=$_POST['correo_nuevo'];
			echo 'Cuenta de: '.$nombre_usr.'<br /><br />
				  El correo se ha cambiado.<br /><br />
				  Correo anterior: <strong>'.$_POST['correo_viejo'].'</strong> <br /><br />
				  Correo nuevo: <strong>'.$_POST['correo_nuevo'].'</strong><br /><br />
				  <center><button id="aceptar">Hecho</button>
				  <script type="text/javascript">
				  	$("#aceptar").button();
					$("#aceptar").click(function(){
						cerrar_solicitud("'.$id_tipo.'");
					});
				  </script>';	
		break;
		case "admin_usr_telefono":
			echo $librerias;
			echo '<div id="ventana">
					Teléfono de: <strong>'.$nombre_usr.'<br /><br />
					Nuevo número: <input id="telefono_nuevo" type="number" onKeyPress="return soloNumeros(event);"><br /><br />
					<div id="error"></div><br /><br />
					<center><button id="cambiar">Cambiar</button><button id="cerrar">Cerrar</button></center>
				  </div>
				  <script type="text/javascript">
				  	cargar_ventana("ventana","Editar mi teléfono",400,200);
				  	$("button").button();
					$("#cambiar").click(function(){
						if($("#telefono_nuevo").val()==""){
							$("#error").html(\'<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Error:</strong> Debe escribir un número de teléfono.</p></div></div>\');
						}else{
							$("#error").html("");
							var tel_nuevo=$("#telefono_nuevo").val();
							var dato="accion=cambiar_telefono_usuario_actual&telefono_nuevo="+tel_nuevo;
							enviar_datos_ajax("admins_all.php",dato,"ventana");
						}
					});
					$("#cerrar").click(function(){
						cerrar_solicitud("'.$id_tipo.'");
					});
				  </script>';
		break;
		case "cambiar_telefono_usuario_actual":
			$objConexion = conectar("on");
				
				$consulta_actualizar_tel='UPDATE `usuario` SET `telefono_usuario`="'.$_POST['telefono_nuevo'].'" WHERE `id_usuario`='.$id_usr.'';
				$objConexion->query($consulta_actualizar_tel);
			conectar("off");
			echo 'Cuenta de: '.$nombre_usr.'<br /><br />
				  El Teléfono se ha cambiado.<br /><br />
				  Teléfono nuevo: <strong>'.$_POST['telefono_nuevo'].'</strong><br /><br />
				  <center><button id="aceptar">Hecho</button>
				  <script type="text/javascript">
				  	$("#aceptar").button();
					$("#aceptar").click(function(){
						cerrar_solicitud("'.$id_tipo.'");
					});
				  </script>';
		break;
		case "admin_usr_password":
			echo $librerias;
			echo '<div id="ventana">
					Clave de: <strong>'.$nombre_usr.'<br /><br />
					<center>Indique su clave anterior: <input type="password" id="clave_vieja" /><br /><br />
					Indique su clave nueva: <input type="password" id="clave_nueva" type="text" /></center><br /><br />
					<div id="error"></div><br /><br />
					<center><button id="cambiar">Cambiar</button><button id="cerrar">Cerrar</button></center>
				  </div>
				  <script type="text/javascript">
				  	cargar_ventana("ventana","Editar mi contraseña",400,200);
				  	$("button").button();
					$("#cambiar").click(function(){
						if($("#clave_vieja").val()!="" && $("#clave_nueva").val()!=""){
							var cadena=$("#clave_vieja").val();
							$("#clave_vieja").attr("value",$.trim(cadena));
							cadena=$("#clave_nueva").val();
							$("#clave_nueva").attr("value",$.trim(cadena));
							$("#error").html("");
							var clvieja=$("#clave_vieja").val();
							var clnueva=$("#clave_nueva").val();
							var dato="accion=cambiar_clave_usuario_actual&clvieja="+clvieja+"&clnueva="+clnueva;
							enviar_datos_ajax("admins_all.php",dato,"ventana");
						}else{
							$("#error").html(\'<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Error:</strong> Debe indicar la clave anterior y escribir una nueva.</p></div></div>\');
						}
					});
					$("#cerrar").click(function(){
						cerrar_solicitud("'.$id_tipo.'");
					});
				  </script>';
		break;
		case "cambiar_clave_usuario_actual":
			$objConexion = conectar("on");
	 		
	 		$consulta = $objConexion->query('SELECT * FROM usuario WHERE email_usuario="'.$correo_usr.'"');
			if($consulta->num_rows == 0){
				echo 'Error fatal: No existe el usuario.
					<center><button id="aceptar">Hecho</button></center>
						<script type="text/javascript">
						$("#aceptar").button();
						$("#aceptar").click(function(){
							cerrar_solicitud("'.$id_tipo.'");
						});
					</script>';
				conectar("off");
			}
			while($fila=$consulta->fetch_assoc()){
				$clave_anterior=$fila['password_usuario'];
			}
			conectar("off");
			if($clave_anterior==$_POST['clvieja']){
				$objConexion = conectar("on");
					
					$consulta_actualizar_psw='UPDATE `usuario` SET `password_usuario`="'.$_POST['clnueva'].'" WHERE `id_usuario`='.$id_usr.'';
					$objConexion->query($consulta_actualizar_psw);
				conectar("off");
				echo 'Cuenta del usuario: <strong>'.$nombre_usr.'</strong><br /><br />
				<center><strong>Su contrase&ntilde;a ha sido modificada correctamente.</strong></center><br /><br />
				<center><button id="aceptar">Hecho</button></center>
				<script type="text/javascript">
					$("#aceptar").button();
					$("#aceptar").click(function(){
						cerrar_solicitud("'.$id_tipo.'");
					});
				</script>';
			}else{
				echo 'Cuenta del usuario: '.$nombre_usr.'<br /><br />
				<strong>La contraseña anterior no es correcta.</strong><br /><br />
				<strong>Verifique con el administrador de sistema</strong><br /><br />
				<center><button id="aceptar">Hecho</button></center>
				<script type="text/javascript">
					$("#aceptar").button();
					$("#aceptar").click(function(){
						cerrar_solicitud("'.$id_tipo.'");
					});
				</script>';
			}
		break;
		case "admin_usr_avatar":
			echo $librerias;
			echo '<div id="ventana">
					Avatar de: <strong>'.$nombre_usr.'<br /><br />
					<center>Seleccione una imagen de 100x100px con formato jpg: <input type="file" name="archivos[]" multiple="multiple" id="avatar_nuevo" />
					<br /><br />
					<div id="error"></div><br /><br />
					<center><button id="cambiar">Cambiar</button><button id="cerrar">Cerrar</button></center>
				  </div>
				  <script type="text/javascript">
				  	cargar_ventana("ventana","Cambiar mi avatar",380,250);
					$("button").button();
					$("#cerrar").click(function(){
						cerrar_solicitud("'.$id_tipo.'");
					});
					$("#cambiar").click(function(){
						if($("#avatar_nuevo").val()!=""){
							var archivo=$("#avatar_nuevo").val();
							var extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
							if(extension==".jpg"){
								var archivos = document.getElementById("avatar_nuevo");
								var archivo = archivos.files;
								var data = new FormData();
								for(i=0; i<=0; i++){
    								data.append("archivo"+i,archivo[i]);
  								}
								$("#error").html("");
								subirImagenAjax("admins_all.php?accion=cambiar_avatar_usuario",data,"ventana");
							}else{
								$("#error").html(\'<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Error:</strong> La imagen debe ser formato JPG.</p></div></div>\');
							}
						}else{
							$("#error").html(\'<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Error:</strong> Debe seleccionar una imagen.</p></div></div>\');
						}
					});
				  </script>';
		break;
		case "cambiar_avatar_usuario":
			$ruta="fotos/";
  			foreach ($_FILES as $key) {
  				if($key['error'] == UPLOAD_ERR_OK ){//Verificamos si se subio correctamente
    				$nombre = $key['name'];//Obtenemos el nombre del archivo
	  				$temporal = $key['tmp_name']; //Obtenemos el nombre del archivo temporal
	  				$tamano= ($key['size'] / 1000)."Kb"; //Obtenemos el tamaño en KB
					$numero = rand(1,100);
					$numero2 = rand(100,1000);
					$nombre_avatar = "avatar".$id_usr.$numero.$numero2.".jpg";
	  				move_uploaded_file($temporal, $ruta . $nombre_avatar); //Movemos el archivo temporal a la ruta especificada
				$objConexion = conectar("on");
					
					$consulta_actualizar_avt='UPDATE `usuario` SET `avatar_usuario`="'.$nombre_avatar.'" WHERE `id_usuario`='.$id_usr.'';
					$objConexion->query($consulta_actualizar_avt);
				conectar("off");
					$_SESSION['avatar']=$ruta.$nombre_avatar;
	  				//El echo es para que lo reciba jquery y lo ponga en el div "cargados"
      				echo "<br /><br />
        				<div id='aviso'>
							<h12><strong>Se ha cambiado su avatar</strong></h2><br />
							<hr>
        				</div>";
    			}else{
      				echo $key['error']; //Si no se cargo mostramos el error
    			}
  			}
		break;
/********************************************************* DETALLES DE SOLICITUDES *****************************************************************/
	case "detalles_solicitudes":
		$tipo_solicitud = $_POST['tipo'];
		$id_solicitud = $_POST['numeroSolicitud'];
		if($tipo_solicitud=="rcc"){
			$objConexion = conectar("on");
			
				$consulta = 'SELECT fecha_solicitud as fechaIngreso,
							fecha_requerida_solicitud as fechaRequerida,
							beneficiario_solicitud as beneficiario,
							concepto_solicitud as concepto,
							factura_solicitud as factura,
							(SELECT nombre_desarrollo FROM desarrollo WHERE id_desarrollo=tipo_desarrollo_solicitud) as des,
							(SELECT nombre_departamento FROM departamento WHERE id_departamento=tipo_departamento_solicitud) as dep,
							importe_solicitud as monto,
							imagen_factura_solicitud as fotoFactura,
							comentario_solicitud as comentario
							FROM solicitud WHERE id_solicitud='.$id_solicitud.'';
				$solicitudConsultada = $objConexion->query($consulta);
				while($fila=mysql_fetch_array($solicitudConsultada)){
					$fechaIngreso=$fila['fechaIngreso'];
					$fechaRequerida=$fila['fechaRequerida'];
					$beneficiario=$fila['beneficiario'];
					$concepto=$fila['concepto'];
					$factura=$fila['factura'];
					$des=$fila['des'];
					$dep=$fila['dep'];
					$monto=$fila['monto'];
					$comentario=$fila['comentario'];
					$fotoFactura=$fila['fotoFactura'];
				}
			conectar("off");
			echo '
				<link type="text/css" href="css/ventanadetalle.css" rel="stylesheet" />
				<div class="divDetalle">
					<h3><center>Detalle Proveedor.<br />
						Solicitud n&uacute;mero: '.$id_solicitud.'
					</center></h3>
					<form>
						<table align="center">
							<tr>
								<td><label for="fechareq">Fecha de ingreso:</label></td>
								<td><input disabled="disabled" type="text" id="fechareq" name="fechaing" value="'.$fechaIngreso.'" /></td>
							</tr>
							<tr>
								<td><label for="fechareq">Fecha requerida:</label></td>
								<td><input disabled="disabled" type="text" id="fechareq" name="fechareq" value="'.$fechaRequerida.'" /></td>
							</tr>
							<tr>
								<td><label for="company">Beneficiario:</label></td>
								<td><input disabled="disabled" type="text" id="company" name="beneficiario" value="'.$beneficiario.'" /></td>
							</tr>
							<tr>
								<td><label for="concepto">Concepto:</label></td>
								<td><input disabled="disabled" type="text" id="concep" name="concepto" value="'.$concepto.'" /></td>
							</tr>
							<tr>
								<td><label for="nfac"># Factura:</label></td>
								<td><input disabled="disabled" type="text" id="nfac" name="nfactura" value="'.$factura.'" /></td>
							</tr>
							<tr>
								<td><label for="seldesDesarrollo" id="desarrollo">Desarrollo:</label></td>
								<td><input disabled="disabled" type="text" id="desarrollo" name="desarrollo" value="'.$des.'" /></td>
							</tr>
							<tr>
								<td><label for="seldesDepto" id="desarrollo">Depto:</label></td>
								<td><input disabled="disabled" type="text" id="depto" name="depto" value="'.$dep.'" /></td>
							</tr>
							<tr>
								<td><label for="monto">Monto:</label></td>
								<td><input <input disabled="disabled" type="text" id="monto" name="monto" value="$'.$monto.'" /></td>
							</tr>
							<tr>
								<td><label for="comentario">Comentario:</label></td>
								<td><textarea id="comentario" placeholder="Comentario y/u observaciones" name="comentario">'.$comentario.'</textarea></td>
							</tr>
						</table>
						<input type="hidden" id="ruta_imagen_factura" value="'.$fotoFactura.'" />         
					</form>
					<center><input type="button" id="verFactura" value="Ver factura" />
					<input type="button" id="cerrarDetalle" value="Cerrar" /></center>
					<div id="muestraPDF"></div>
    			</div>
				<script type="text/javascript">
					$("#cerrarDetalle, #verFactura").button();
					$("#cerrarDetalle").click(function(){
						enviar_datos_ajax("admins_all.php","accion=adm_rcc","ventana");
					});
					$("#verFactura").click(function(){
						var direccionImagen=$("#ruta_imagen_factura").val();
						//alert(direccionImagen);
						var extension = (direccionImagen.substring(direccionImagen.lastIndexOf("."))).toLowerCase();
						//alert(extension);
						if(extension==".jpg"){
							$.prettyPhoto.open(direccionImagen,\'Factura: '.$factura.'\',\'Monto: $'.$monto.'<br />Concepto: '.$concepto.'\');
						}else if(extension==".pdf"){
							$("#outerContainer").remove();
							$("#visorPDF").remove();
							$("#muestraPDF").dialog({
								title:"Factura: '.$factura.'",
								modal:true,
								width: 500,
								minHeight: 400,
								resizable: false
							});
							$("#muestraPDF").html(\'<iframe id="visorPDF" width="100%" height="400" frameborder="0">\');
							$("#visorPDF").attr("src",direccionImagen);
						}else{
							alert("No hay copia de la factura!!!\nConsulte con el administrador.");
						}						
					});
				</script>
			';
		}else if($tipo_solicitud=="prove"){
			$objConexion = conectar("on");
			
				$consulta = 'SELECT fecha_solicitud as fechaIngreso,
							fecha_requerida_solicitud as fechaRequerida,
							beneficiario_solicitud as beneficiario,
							concepto_solicitud as concepto,
							factura_solicitud as factura,
							(SELECT nombre_desarrollo FROM desarrollo WHERE id_desarrollo=tipo_desarrollo_solicitud) as des,
							(SELECT nombre_departamento FROM departamento WHERE id_departamento=tipo_departamento_solicitud) as dep,
							importe_solicitud as monto,
							imagen_factura_solicitud as fotoFactura,
							comentario_solicitud as comentario
							FROM solicitud WHERE id_solicitud='.$id_solicitud.'';
				$solicitudConsultada = $objConexion->query($consulta);
				while($fila=mysql_fetch_array($solicitudConsultada)){
					$fechaIngreso=$fila['fechaIngreso'];
					$fechaRequerida=$fila['fechaRequerida'];
					$beneficiario=$fila['beneficiario'];
					$concepto=$fila['concepto'];
					$factura=$fila['factura'];
					$des=$fila['des'];
					$dep=$fila['dep'];
					$monto=$fila['monto'];
					$comentario=$fila['comentario'];
					$fotoFactura=$fila['fotoFactura'];
				}
			conectar("off");
			echo '<link type="text/css" href="css/ventanadetalle.css" rel="stylesheet" />
				<div class="divDetalle">
					<h3><center>Detalle Proveedor.<br />
						Solicitud n&uacute;mero: '.$id_solicitud.'
					</center></h3>
					<form>
						<table align="center">
							<tr>
								<td><label for="fechareq">Fecha de ingreso:</label></td>
								<td><input disabled="disabled" type="text" id="fechareq" name="fechaing" value="'.$fechaIngreso.'" /></td>
							</tr>
							<tr>
								<td><label for="fechareq">Fecha requerida:</label></td>
								<td><input disabled="disabled" type="text" id="fechareq" name="fechareq" value="'.$fechaRequerida.'" /></td>
							</tr>
							<tr>
								<td><label for="company">Beneficiario:</label></td>
								<td><input disabled="disabled" type="text" id="company" name="beneficiario" value="'.$beneficiario.'" /></td>
							</tr>
							<tr>
								<td><label for="concepto">Concepto:</label></td>
								<td><input disabled="disabled" type="text" id="concep" name="concepto" value="'.$concepto.'" /></td>
							</tr>
							<tr>
								<td><label for="nfac"># Factura:</label></td>
								<td><input disabled="disabled" type="text" id="nfac" name="nfactura" value="'.$factura.'" /></td>
							</tr>
							<tr>
								<td><label for="seldesDesarrollo" id="desarrollo">Desarrollo:</label></td>
								<td><input disabled="disabled" type="text" id="desarrollo" name="desarrollo" value="'.$des.'" /></td>
							</tr>
							<tr>
								<td><label for="seldesDepto" id="desarrollo">Depto:</label></td>
								<td><input disabled="disabled" type="text" id="depto" name="depto" value="'.$dep.'" /></td>
							</tr>
							<tr>
								<td><label for="monto">Monto:</label></td>
								<td><input <input disabled="disabled" type="text" id="monto" name="monto" value="$'.$monto.'" /></td>
							</tr>
							<tr>
								<td><label for="comentario">Comentario:</label></td>
								<td><textarea id="comentario" placeholder="Comentario y/u observaciones" name="comentario">'.$comentario.'</textarea></td>
							</tr>
						</table>
						<input type="hidden" id="ruta_imagen_factura" value="'.$fotoFactura.'" />         
					</form>
					<center><input type="button" id="verFactura" value="Ver factura" />
					<input type="button" id="cerrarDetalle" value="Cerrar" /></center>
					<div id="muestraPDF"></div>
    			</div>
				<script type="text/javascript">
					$("#cerrarDetalle, #verFactura").button();
					$("#cerrarDetalle").click(function(){
						enviar_datos_ajax("admins_all.php","accion=adm_prove","ventana");
					});
					$("#verFactura").click(function(){
						var direccionImagen=$("#ruta_imagen_factura").val();
						//alert(direccionImagen);
						var extension = (direccionImagen.substring(direccionImagen.lastIndexOf("."))).toLowerCase();
						//alert(extension);
						if(extension==".jpg"){
							$.prettyPhoto.open(direccionImagen,\'Factura: '.$factura.'\',\'Monto: $'.$monto.'<br />Concepto: '.$concepto.'\');
						}else if(extension==".pdf"){
							$("#outerContainer").remove();
							$("#visorPDF").remove();
							$("#muestraPDF").dialog({
								title:"Factura: '.$factura.'",
								modal:true,
								width: 500,
								minHeight: 400,
								resizable: false
							});
							$("#muestraPDF").html(\'<iframe id="visorPDF" width="100%" height="400" frameborder="0">\');
							$("#visorPDF").attr("src",direccionImagen);
						}else{
							alert("No hay copia de la factura!!!\nConsulte con el administrador.");
						}						
					});
				</script>
			';
		}else if($tipo_solicitud=="comi"){
			$objConexion = conectar("on");
			
				$consulta = 'SELECT fecha_solicitud_comisiones as fechaIngreso,
							fecha_requerida_comisiones as fechaRequerida,
							concepto_comisiones as concepto,
							factura_comisiones as factura,
							(SELECT nombre_desarrollo FROM desarrollo WHERE id_desarrollo=tipo_desarrollo_comisiones) as des,
							(SELECT nombre_departamento FROM departamento WHERE id_departamento=tipo_departamento_comisiones) as dep,
							(SELECT nombre_usuario FROM usuario WHERE id_usuario=asesor_comisiones) as asesor,
							monto_comisiones as monto,
							anticipo_comisiones as anticipo,
							(monto_comisiones-anticipo_comisiones) as resta,
							comentario_comisiones as comentario,
							imagen_factura_comision as fotoFactura
							FROM comisiones WHERE id_comisiones='.$id_solicitud.'';
				$solicitudConsultada = $objConexion->query($consulta);
				while($fila=mysql_fetch_array($solicitudConsultada)){
					$fechaIngreso=$fila['fechaIngreso'];
					$fechaRequerida=$fila['fechaRequerida'];
					$concepto=$fila['concepto'];
					$factura=$fila['factura'];
					$des=$fila['des'];
					$dep=$fila['dep'];
					$asesor=$fila['asesor'];
					$monto=$fila['monto'];
					$anticipo=$fila['anticipo'];
					$resta=$fila['resta'];
					$comentario=$fila['comentario'];
					$fotoFactura=$fila['fotoFactura'];
				}
			conectar("off");
			echo '<link type="text/css" href="css/ventanadetalle.css" rel="stylesheet" />
				<div class="divDetalle">
					<center>
					<h3>Detalle Comisi&oacute;n.<br />
						Solicitud n&uacute;mero: '.$id_solicitud.'
					</h3>
					<form>
						<table align="center">
						<tr>
							<td><label for="fechareq">Fecha de ingreso:</label></td>
							<td><input disabled="disabled" type="text" id="fechareq" name="fechaing" value="'.$fechaIngreso.'" /></td>
						</tr>
						<tr>
							<td><label for="fechareq">Fecha requerida:</label></td>
							<td><input disabled="disabled" type="text" id="fechareq" name="fechareq" value="'.$fechaRequerida.'" /></td>
						</tr>
						<tr>
							<td><label for="company">Asesor:</label></td>
							<td><input disabled="disabled" type="text" id="company" name="beneficiario" value="'.$asesor.'" /></td>
						</tr>
						<tr>
							<td><label for="concepto">Concepto:</label></td>
							<td><input disabled="disabled" type="text" id="concep" name="concepto" value="'.$concepto.'" /></td>
						</tr>
						<tr>
							<td><label for="nfac"># Factura:</label></td>
							<td><input disabled="disabled" type="text" id="nfac" name="nfactura" value="'.$factura.'" /></td>
						</tr>
						<tr>
							<td><label for="seldesDesarrollo" id="desarrollo">Desarrollo:</label></td>
							<td><input disabled="disabled" type="text" id="desarrollo" name="desarrollo" value="'.$des.'" /></td>
						</tr>
						<tr>
							<td><label for="seldesDepto" id="desarrollo">Depto:</label></td>
							<td><input disabled="disabled" type="text" id="depto" name="depto" value="'.$dep.'" /></td>
						</tr>
						<tr>
							<td><label for="monto">Monto:</label></td>
							<td><input <input disabled="disabled" type="text" id="monto" name="monto" value="$'.$monto.'" /></td>
						</tr>
						<tr>
							<td><label for="monto">Anticipo:</label></td>
							<td><input <input disabled="disabled" type="text" id="monto" name="monto" value="$'.$anticipo.'" /></td>
						</tr>
						<tr>
							<td><label for="monto">Resta:</label></td>
							<td><input <input disabled="disabled" type="text" id="monto" name="monto" value="$'.$resta.'" /></td>
						</tr>
						<tr>
							<td><label for="comentario">Comentario:</label></td>
							<td><textarea id="comentario" placeholder="Comentario y/u observaciones" name="comentario">'.$comentario.'</textarea> </td>
						</tr>
						</table>
						<input type="hidden" id="ruta_imagen_factura" value="'.$fotoFactura.'" />         
					</form>
					<center><input type="button" id="verFactura" value="Ver factura" />
					<input type="button" id="cerrarDetalle" value="Cerrar" /></center>
					<div id="muestraPDF"></div>
				</div>
				<script type="text/javascript">
					$("#cerrarDetalle, #verFactura").button();
					$("#cerrarDetalle").click(function(){
						enviar_datos_ajax("admins_all.php","accion=adm_comi","ventana");
					});
					$("#verFactura").click(function(){
						var direccionImagen=$("#ruta_imagen_factura").val();
						//alert(direccionImagen);
						var extension = (direccionImagen.substring(direccionImagen.lastIndexOf("."))).toLowerCase();
						//alert(extension);
						if(extension==".jpg"){
							$.prettyPhoto.open(direccionImagen,\'Factura: '.$factura.'\',\'Monto: $'.$monto.'<br />Concepto: '.$concepto.'\');
						}else if(extension==".pdf"){
							$("#outerContainer").remove();
							$("#visorPDF").remove();
							$("#muestraPDF").dialog({
								title:"Factura: '.$factura.'",
								modal:true,
								width: 500,
								minHeight: 400,
								resizable: false
							});
							$("#muestraPDF").html(\'<iframe id="visorPDF" width="100%" height="400" frameborder="0">\');
							$("#visorPDF").attr("src",direccionImagen);
						}else{
							alert("No hay copia de la factura!!!\nConsulte con el administrador.");
						}						
					});
				</script>
			';			
		}
	break;
/********************************************************* LLAMADAS A FUNCIONES *******************************************************************/		
		case "exp_usr":
			if(isset($_SESSION['usr_ses'])){
				exporta("tab_Usr","Usuarios");
			}else{
				header('Location: http://www.grilosystems.com');
			}
		break;
		case "exp_des":
			if(isset($_SESSION['usr_ses'])){
				exporta("tab_Des","Desarrollos");
			}else{
				header('Location: http://www.grilosystems.com');
			}
		break;
		case "exp_dep":
			if(isset($_SESSION['usr_ses'])){
				exporta("tab_Dep","Departamentos");
			}else{
				header('Location: http://www.grilosystems.com');
			}
		break;
		case "exp_scc":
			if(isset($_SESSION['usr_ses'])){
				exporta("tab_s_caja","Rembolso caja chica");
			}else{
				header('Location: http://www.grilosystems.com');
			}
		break;
		case "exp_spv":
			if(isset($_SESSION['usr_ses'])){
				exporta("tab_s_proveedor","Proveedores");
			}else{
				header('Location: http://www.grilosystems.com');
			}
		break;
		case "exp_com":
			if(isset($_SESSION['usr_ses'])){
				exporta("tab_s_comision","Comisiones");
			}else{
				header('Location: http://www.grilosystems.com');
			}
		break;
		case "exp_sall":
			exporta("tab_s_todas","Todas las solicitudes");
		break;
		case "exp_cli":
			if(isset($_SESSION['usr_ses'])){
				exporta("tab_clientes","Clientes");
			}else{
				header('Location: http://www.grilosystems.com');
			}
		break;
	}
	
	/*********************************************************OPCIONES ADMINISTRATIVAS****************************************************/
	/*Según la opcion a administrar es:
		1. Usuarios
		2. Desarrollos
		3. Departamentos
		4. Exportación
		5. Clientes
		6. Solicitudes
	**********************************************/
	
	/* Recibir opcion */
	function opcion_admin($opcion){
		switch($opcion){
			case 1:
				usuarios();
			break;
			case 2:
				desarrollos();
			break;
			case 3:
				departamentos();
			break;
			case 4:
				exportar_pdf();
			break;
			case 5:
				clientes();
			break;
			case 6:
				admin_soli_director();
			break;
		}
	}
	
	/* Crear la pagina para dibujar usuarios */
	
	function usuarios(){
		$i=1;
		$objConexion = conectar("on");
		$consulta = $objConexion->query("SELECT id_usuario,email_usuario,password_usuario,nombre_usuario,rfc_usuario,telefono_usuario,(SELECT tipo FROM  tipo_usuario WHERE id_tipo_usuario=tipo_usuario) as tipo FROM  usuario");
		if($consulta->num_rows == 0){
			echo 'No hay usuarios'; /* editar esta opcion */ 
	 	}
		echo libreriasJS();
		echo '<link type="text/css" href="css/tablas.css" rel="stylesheet" />';
		echo '<div id="ventana">';
		echo '<table border="1">';
		echo '<thead><tr><th scope="col">Correo</th><th scope="col">Clave</th><th scope="col">Nombre</th><th scope="col">RFC</th><th scope="col">Telefono</th><th scope="col">Tipo</th><th scope="col">Acci&oacute;n</th></tr></thead>';
		echo '<tbody>';
			while($fila=$consulta->fetch_assoc()){
				if(($i%2)==0){
					echo '<tr>';
						echo '<td>'.$fila['email_usuario'].'</td>';
						echo '<td>'.$fila['password_usuario'].'</td>';
						echo '<td>'.$fila['nombre_usuario'].'</td>';
						echo '<td>'.$fila['rfc_usuario'].'</td>';
						echo '<td>'.$fila['telefono_usuario'].'</td>';
						echo '<td>'.$fila['tipo'].'</td>';
						echo '<td><a href="admins_all.php?accion=eliminar_usr&id='.$fila['id_usuario'].'" data-tooltip="Haz click para volver al artículo"><img src="img/btn_del.png" /></a><a href="admins_all.php?accion=editar_usr&id='.$fila['id_usuario'].'"><img src="img/btn_edi.png" /></a></td>';
					echo '</tr>';
				}else{
					echo '<tr class="odd">';
						echo '<td>'.$fila['email_usuario'].'</td>';
						echo '<td>'.$fila['password_usuario'].'</td>';
						echo '<td>'.$fila['nombre_usuario'].'</td>';
						echo '<td>'.$fila['rfc_usuario'].'</td>';
						echo '<td>'.$fila['telefono_usuario'].'</td>';
						echo '<td>'.$fila['tipo'].'</td>';
						echo '<td><a href="admins_all.php?accion=eliminar_usr&id='.$fila['id_usuario'].'"><img src="img/btn_del.png" /></a><a href="admins_all.php?accion=editar_usr&id='.$fila['id_usuario'].'"><img src="img/btn_edi.png" /></a></td>';
					echo '</tr>';
				}
				$i+=1;
			}
		echo '</tbody>';
		echo '</table><br /><center><button id="agregar">Agregar nuevo usuario</button>&nbsp;<button id="cerrar">Cerrar el administrador</button></center>';
		echo '</div>';
		conectar("off");
		echo '<script type="text/javascript">
				$("button").button(); 
				cargar_ventana("ventana","Administrador de usuarios");
				$("#agregar").click(function(){
					window.location.assign("admins_all.php?accion=agregar_usr");
				});
				$("#cerrar").click(function(){
					window.location.assign("menu.php");
				});
			 </script>';
	}
	
	/* Crear la pagina para dibujar desarrollos */
	
	function desarrollos(){
		$i=1;
		$objConexion = conectar("on");
		
		$consulta = $objConexion->query("SELECT id_desarrollo as ID,nombre_desarrollo as Nombre,rfc_desarrollo as RFC,diereccion_desarrollo as Direccion,(SELECT nombre_usuario FROM  usuario WHERE id_usuario=usuario_desarrollo) as Usuario FROM  desarrollo");
		if($consulta->num_rows == 0){
			echo 'No hay usuarios'; /* editar esta opcion */ 
	 	}
		echo libreriasJS();
		echo '<link type="text/css" href="css/tablas.css" rel="stylesheet" />';
		echo '<div id="ventana">';
		echo '<table border="1">';
		echo '<thead><tr><th scope="col">Desarrollo</th><th scope="col">RFC</th><th scope="col">Direcci&oacute;n</th><th scope="col">Titular</th><th scope="col">Acci&oacute;n</th></tr></thead>';
		echo '<tbody>';
			while($fila=$consulta->fetch_assoc()){
				if(($i%2)==0){
					echo '<tr>';
						echo '<td>'.$fila['Nombre'].'</td>';
						echo '<td>'.$fila['RFC'].'</td>';
						echo '<td>'.$fila['Direccion'].'</td>';
						echo '<td>'.$fila['Usuario'].'</td>';
						echo '<td><a href="admins_all.php?accion=eliminar_des&id='.$fila['ID'].'"><img src="img/btn_del.png" /></a><a href="admins_all.php?accion=editar_des&id='.$fila['ID'].'"><img src="img/btn_edi.png" /></a></td>';
					echo '</tr>';
				}else{
					echo '<tr class="odd">';
						echo '<td>'.$fila['Nombre'].'</td>';
						echo '<td>'.$fila['RFC'].'</td>';
						echo '<td>'.$fila['Direccion'].'</td>';
						echo '<td>'.$fila['Usuario'].'</td>';
						echo '<td><a href="admins_all.php?accion=eliminar_des&id='.$fila['ID'].'"><img src="img/btn_del.png" /></a><a href="admins_all.php?accion=editar_des&id='.$fila['ID'].'"><img src="img/btn_edi.png" /></a></td></tr>';
				}
				$i+=1;
			}
		echo '</tbody>';
		echo '</table>
			<br /><center><button id="agregar">Agregar nuevo desarrollo</button>
			&nbsp;<button id="cerrar">Cerrar el administrador</button></center>';
		echo '</div>';
		conectar("off");
		echo '<script type="text/javascript">
				$("button").button();
				$("#agregar").click(function(){
					window.location.assign("admins_all.php?accion=agregar_des");
				});
				$("#cerrar").click(function(){
					window.location.assign("menu.php");
				});
				cargar_ventana("ventana","Administrador de desarrollos");
				</script>';
	}
	
	/* Crear la pagina para dibujar departamentos */
	
	function departamentos(){
		$i=1;
		$objConexion = conectar("on");
		
		$consulta = $objConexion->query("SELECT id_departamento as ID,nombre_departamento as Departamento FROM  departamento");
		if($consulta->num_rows == 0){
			echo 'No hay usuarios'; /* editar esta opcion */ 
	 	}
		echo libreriasJS();
		echo '<link type="text/css" href="css/tablas.css" rel="stylesheet" />';
		echo '<div id="ventana">';
		echo '<center><table border="1">';
		echo '<thead><tr><th scope="col">Departamento</th><th scope="col">Acci&oacute;n</th></tr></thead>';
		echo '<tbody>';
			while($fila=$consulta->fetch_assoc()){
				if(($i%2)==0){
					echo '<tr>';
						echo '<td>'.$fila['Departamento'].'</td>';
						echo '<td><a href="admins_all.php?accion=eliminar_dep&id='.$fila['ID'].'"><img src="img/btn_del.png" /></a><a href="admins_all.php?accion=editar_dep&id='.$fila['ID'].'"><img src="img/btn_edi.png" /></a></td>';
					echo '</tr>';
				}else{
					echo '<tr class="odd">';
						echo '<td>'.$fila['Departamento'].'</td>';
						echo '<td><a href="admins_all.php?accion=eliminar_dep&id='.$fila['ID'].'"><img src="img/btn_del.png" /></a><a href="admins_all.php?accion=editar_dep&id='.$fila['ID'].'"><img src="img/btn_edi.png" /></a></td>';
					echo '</tr>';
				}
				$i+=1;
			}
		echo '</tbody>';
		echo '</table></center>
			<br /><center><button id="agregar">Agregar nuevo departamento</button>
			&nbsp;<button id="cerrar">Cerrar el administrador</button></center>';
		echo '</div>';
		conectar("off");
		echo '<script type="text/javascript">
				$("button").button(); 
				cargar_ventana("ventana","Administrador de departamentos",330,200);
				$("#agregar").click(function(){
					window.location.assign("admins_all.php?accion=agregar_dep");
				});
				$("#cerrar").click(function(){
					window.location.assign("menu.php");
				});
			 </script>';
	}
	
	/* Crear la pagina para dibujar exportación */
	
	function exportar_pdf(){
		echo libreriasJS();
		echo '<link type="text/css" href="css/tablas.css" rel="stylesheet" />';
		echo '<div id="ventana">
		<p align="center">CREACI&Oacute;N DE REPORTES</p>
		<ul>
			<li><a href="admins_all.php?accion=exp_scc" target="_blank">Solicitudes de rembolso caja chica</a></li>
			<li><a href="admins_all.php?accion=exp_spv" target="_blank">Solicitudes de proveedores</a></li>
			<li><a href="admins_all.php?accion=exp_com" target="_blank">Solicitudes de comisiones</a></li>
			<li><a href="admins_all.php?accion=exp_sall" target="_blank">Todas las solicitudes (rembolso caja chica y proveedores)</a></li>
		</ul>
		</div>
		<script type="text/javascript">
			$("button").button();
			cargar_ventana("ventana","Reporte de solicitudes",400,300);
		</script>';
	}
	
	/* Administrar clientes */
	
	function clientes(){
		$i=1;
		$objConexion = conectar("on");
		
		$consulta = $objConexion->query("SELECT id_cliente as clienteID, nombre_cliente as nombre, depto_cliente as depto, (SELECT nombre_usuario FROM usuario WHERE id_usuario=asesor_cliente) as asesor FROM cliente ORDER BY nombre");
		if($consulta->num_rows == 0){
			echo 'No hay usuarios'; /* editar esta opcion */ 
	 	}
		echo libreriasJS();
		echo '<link type="text/css" href="css/tablas.css" rel="stylesheet" />';
		echo '<div id="ventana">';
		echo '<center><table border="1">';
		echo '<thead><tr><th scope="col">Cliente</th><th scope="col">Departamento</th><th scope="col">Asesor</th><th scope="col">Acci&oacute;n</th></tr></thead>';
		echo '<tbody>';
		while($fila=$consulta->fetch_assoc()){
				if(($i%2)==0){
					echo '<tr>';
						echo '<td>'.$fila['nombre'].'</td>';
						echo '<td>'.$fila['depto'].'</td>';
						echo '<td>'.$fila['asesor'].'</td>';
						echo '<td><a href="admins_all.php?accion=eliminar_cli&id='.$fila['clienteID'].'"><img src="img/btn_del.png" /></a><a href="admins_all.php?accion=editar_cli&id='.$fila['clienteID'].'"><img src="img/btn_edi.png" /></a></td>';
					echo '</tr>';
				}else{
					echo '<tr class="odd">';
						echo '<td>'.$fila['nombre'].'</td>';
						echo '<td>'.$fila['depto'].'</td>';
						echo '<td>'.$fila['asesor'].'</td>';
						echo '<td><a href="admins_all.php?accion=eliminar_cli&id='.$fila['clienteID'].'"><img src="img/btn_del.png" /></a><a href="admins_all.php?accion=editar_cli&id='.$fila['clienteID'].'"><img src="img/btn_edi.png" /></a></td>';
					echo '</tr>';
				}
				$i+=1;
			}
		echo '</tbody>';
		echo '</table></center>
			<br /><center><button id="cerrar">Cerrar el administrador</button></center>';
		echo '</div>';
		conectar("off");
		echo '<script type="text/javascript">
				$("button").button(); 
				cargar_ventana("ventana","Administrador de clientes",600,300);
				$("#cerrar").click(function(){
					window.location.assign("menu.php");
				});
			 </script>';
		
	}
	
	/* Administrar solicutudes */
	
	function admin_soli_director(){
		echo libreriasJS();
		echo '<link type="text/css" href="css/styles.css" rel="stylesheet" />';
		echo '<div id="ventana">
				<div class="cabecera" id="cabecera" style="height:70px;">
					<p align="center" style="height:50px; width:auto;">
						De click en uno de los siguientes botones para listar, buscar y editar las solicitudes.
					</p>
				</div>
				<div class="contenBtns">
					<div class="botones" id="caja"><img class="caja" src="img/img_trans.gif" width="1" height="1" /></div>
					<div class="botones" id="comision"><img class="comision" src="img/img_trans.gif" width="1" height="1" /></div>
					<div class="botones" id="proveedor"><img class="proveedor" src="img/img_trans.gif" width="1" height="1" /></div>
				</div>
		</div>';
		echo '<script type="text/javascript">
				cargar_ventana("ventana","Administrar solicitudes",800,300);
				$("#caja").hover(sobre,fuera);
				$("#comision").hover(sobre,fuera);
				$("#proveedor").hover(sobre,fuera);
				
				$("#caja").click(function(){
					enviar_datos_ajax("admins_all.php","accion=adm_rcc","ventana");
				});
				$("#comision").click(function(){
					enviar_datos_ajax("admins_all.php","accion=adm_comi","ventana");
				});
				$("#proveedor").click(function(){
					enviar_datos_ajax("admins_all.php","accion=adm_prove","ventana");
				});
		</script>';
		
	}
	
	/* Librerias para JQuery y funciones comunes */
	
	function libreriasJS(){
		$libreriasJAVA='<script type="text/javascript" src="js/jquery-2.min.js"></script>
			  	<script type="text/javascript" src="js/jqueryui.js"></script>
			  	<script type="text/javascript" src="js/funComunes.js"></script>
			  	<link type="text/css" href="css/jquery-ui-min.css" rel="stylesheet" />
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		return $libreriasJAVA;
	}
	
	/* Retorna la fecha actual del servidor */
	function getFecha(){
		$anio = date("Y");
		$dia = date("j");
		$mes = date("m");
		$fechactual = $anio."-".$mes."-".$dia;
		return $fechactual;
	}
	
	/* Subir ficheros */
	function subirArchivo($nombreArchivo,$factSol,$id_usr,$tipoArchivo){
		if($nombreArchivo!="" && $factSol!="" && $id_usr!=""){
			$randNumero = rand(10,100);
			$usuarioSube=$id_usr;
			$origenArchivo=$nombreArchivo;
			$tiempo=date("z").date("y").date("g").date("i").date("s").$randNumero;
			if($tipoArchivo=='image/jpeg'){
				$destinoArchivo="facturas/"."F".$factSol.$tiempo.$usuarioSube.".jpg";
			}
			if($tipoArchivo=='application/pdf'){
				$destinoArchivo="facturas/"."F".$factSol.$tiempo.$usuarioSube.".pdf";
			}
			move_uploaded_file($origenArchivo,$destinoArchivo);
			return $destinoArchivo;
		}else{
			return "Falto un parametro: ".$nombreArchivo.$factSol.$id_usr;
		}
	}
	
	/* Crea archivo XML */
	
	function crearXML(){
		$objConexion = conectar("on");
		
		$consulta='SELECT id_solicitud as numero,
					fecha_requerida_solicitud as requerida,
					beneficiario_solicitud as beneficiario,
					concepto_solicitud as concepto,
					factura_solicitud as factura,
					(SELECT nombre_desarrollo FROM desarrollo WHERE id_desarrollo=tipo_desarrollo_solicitud) as desarrollo,
					(SELECT nombre_departamento FROM departamento WHERE id_departamento=tipo_departamento_solicitud) as depto,
					importe_solicitud as monto,
					estatus_solicitud as estado 
					FROM solicitud WHERE tipo_solicitud=1';
					
		$datos_consulta=$objConexion->query($consulta);
		
		$xml = new DomDocument('1.0','UTF-8');
		$root = $xml->createElement('registros');
		$root = $xml->appendChild($root);
		
		while($fila=mysql_fetch_array($datos_consulta)){
			$caja = $xml->createElement('caja');
 			$caja = $root->appendChild($caja);
			$numero_sc = $xml->createElement('id_solicitud',$fila['numero']);
			$numero_sc = $caja->appendChild($numero_sc);
			$fechreq=$fila['requerida'];
			$fechareq = $xml->createElement('fecha_requerida',$fechreq);
			$fechareq = $caja->appendChild($fechareq);
			$beneficiaro = $xml->createElement('beneficiario',$fila['beneficiario']);
			$beneficiaro = $caja->appendChild($beneficiaro);
			$concepto = $xml->createElement('concepto',$fila['concepto']);
			$concepto = $caja->appendChild($concepto);
			$factura = $xml->createElement('factura',$fila['factura']);
			$factura = $caja->appendChild($factura);
			$desarrollo = $xml->createElement('desarrollo',$fila['desarrollo']);
			$desarrollo = $caja->appendChild($desarrollo);
			$departamento = $xml->createElement('departamento',$fila['depto']);
			$departamento = $caja->appendChild($departamento);
			$monto = $xml->createElement('monto',$fila['monto']);
			$monto = $caja->appendChild($monto);
			$estatus = $xml->createElement('estatus',$fila['estado']);
			$estatus = $caja->appendChild($estatus);
		}
		
		$consulta='SELECT id_solicitud as numero,
					fecha_requerida_solicitud as requerida,
					beneficiario_solicitud as beneficiario,
					concepto_solicitud as concepto,
					factura_solicitud as factura,
					(SELECT nombre_desarrollo FROM desarrollo WHERE id_desarrollo=tipo_desarrollo_solicitud) as desarrollo,
					(SELECT nombre_departamento FROM departamento WHERE id_departamento=tipo_departamento_solicitud) as depto,
					importe_solicitud as monto,
					estatus_solicitud as estado 
					FROM solicitud WHERE tipo_solicitud=2';
					
		$datos_consulta=$objConexion->query($consulta);
		
		while($fila=mysql_fetch_array($datos_consulta)){
			$proveedor = $xml->createElement('proveedor');
 			$proveedor = $root->appendChild($proveedor);
			$numero_sp = $xml->createElement('id_solicitud',$fila['numero']);
			$numero_sp = $proveedor->appendChild($numero_sp);
			$fechreq=$fila['requerida'];
			$fechareq = $xml->createElement('fecha_requerida',$fechreq);
			$fechareq = $proveedor->appendChild($fechareq);
			$beneficiaro = $xml->createElement('beneficiario',$fila['beneficiario']);
			$beneficiaro = $proveedor->appendChild($beneficiaro);
			$concepto = $xml->createElement('concepto',$fila['concepto']);
			$concepto = $proveedor->appendChild($concepto);
			$factura = $xml->createElement('factura',$fila['factura']);
			$factura = $proveedor->appendChild($factura);
			$desarrollo = $xml->createElement('desarrollo',$fila['desarrollo']);
			$desarrollo = $proveedor->appendChild($desarrollo);
			$departamento = $xml->createElement('departamento',$fila['depto']);
			$departamento = $proveedor->appendChild($departamento);
			$monto = $xml->createElement('monto',$fila['monto']);
			$monto = $proveedor->appendChild($monto);
			$estatus = $xml->createElement('estatus',$fila['estado']);
			$estatus = $proveedor->appendChild($estatus);
		}
		
		$consulta='SELECT id_comisiones as numero,
					fecha_requerida_comisiones as requerida,
					(SELECT nombre_usuario FROM usuario WHERE id_usuario=asesor_comisiones) as asesor,
					factura_comisiones as factura,
					concepto_comisiones as concepto,
					(SELECT nombre_departamento FROM departamento WHERE id_departamento=tipo_departamento_comisiones) as depto,
					(SELECT nombre_desarrollo FROM desarrollo WHERE id_desarrollo=tipo_desarrollo_comisiones) as desarrollo,
					(SELECT nombre_cliente FROM cliente WHERE id_cliente=cliente_comisiones) as cliente,
					monto_comisiones as monto,
					anticipo_comisiones as anticipo,
					(monto_comisiones-anticipo_comisiones) as resta,
					estatus_comisiones as estado
					FROM comisiones';
					
		$datos_consulta=$objConexion->query($consulta);
		
		while($fila=mysql_fetch_array($datos_consulta)){
			$comision = $xml->createElement('comision');
 			$comision = $root->appendChild($comision);
			$numero_scn = $xml->createElement('id_solicitud',$fila['numero']);
			$numero_scn = $comision->appendChild($numero_scn);
			$fechreq=$fila['requerida'];
			$fechareq = $xml->createElement('fecha_requerida',$fechreq);
			$fechareq = $comision->appendChild($fechareq);
			$asesor = $xml->createElement('asesor',$fila['asesor']);
			$asesor = $comision->appendChild($asesor);
			$concepto = $xml->createElement('concepto',$fila['concepto']);
			$concepto = $comision->appendChild($concepto);
			$factura = $xml->createElement('factura',$fila['factura']);
			$factura = $comision->appendChild($factura);
			$desarrollo = $xml->createElement('desarrollo',$fila['desarrollo']);
			$desarrollo = $comision->appendChild($desarrollo);
			$departamento = $xml->createElement('departamento',$fila['depto']);
			$departamento = $comision->appendChild($departamento);
			$cliente = $xml->createElement('cliente',$fila['cliente']);
			$cliente = $comision->appendChild($cliente);
			$anticipo = $xml->createElement('anticipo',$fila['anticipo']);
			$anticipo = $comision->appendChild($anticipo);
			$monto = $xml->createElement('monto',$fila['monto']);
			$monto = $comision->appendChild($monto);
			$resto = $xml->createElement('resto',$fila['resta']);
			$resto = $comision->appendChild($resto);
			$estatus = $xml->createElement('estatus',$fila['estado']);
			$estatus = $comision->appendChild($estatus);
		}
		
		conectar("off");
		$xml->formatOutput = true;
		$strings_xml = $xml->saveXML();
		$xml->save('admins_all_reg.xml');
		
	}
?>