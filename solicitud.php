<?php
	
	include('admins_all.php');
	session_name('user_sesion');
	session_start();
	//Procesa solucitudes
	$fecha_req = $_POST['fechareq'];
	$cerrar_session = $_POST['cerrarss'];
	$tipo_solicitud = $_POST['ts'];
	$cerrar_session = $_POST['cerrarss'];
	$desarrollo = $_POST['desarrollo'];
	$beneficiario = $_POST['beneficiario'];
	$concepto = $_POST['concepto'];
	$factura = $_POST['nfactura'];
	$depto = $_POST['depto'];
	$monto = $_POST['monto'];
	$coment = $_POST['comentario'];
	$usuario_creador = $_SESSION['id_usr'];
	$factura_archivo = $_FILES['archivoFactura']['tmp_name'];
	$tipo_archivo = $_FILES['archivoFactura']['type'];
	//Fecha actual
	$anio = date("Y");
	$dia = date("j");
	$mes = date("m");
	$fechactual = $anio."-".$mes."-".$dia;
	
	switch ($tipo_solicitud){
		case "scaja":
			$tipo_solicitud_rel=1; //Correspondiente a Rembolso caja chica
			$estatus_solicitud=1; //Correspondiente por default a NO APROBADA
			$fechactual; //Contiene la fecha actual del servidor
			$nombre_factura=subirArchivo($factura_archivo,"CC",$_SESSION['tipo_usr'],$tipo_archivo);
			if($coment==""){ $coment="Ninguno";}
			agregar("INSERT INTO `solicitud` (`id_solicitud`,`usuario_creador_solicitud`, `tipo_solicitud`, `fecha_solicitud`, `fecha_requerida_solicitud`, `beneficiario_solicitud`, `concepto_solicitud`, `factura_solicitud`, `tipo_desarrollo_solicitud`, `tipo_departamento_solicitud`, `importe_solicitud`, `estatus_solicitud`, `imagen_factura_solicitud`, `comentario_solicitud`) VALUES (NULL,'".$usuario_creador."', '".$tipo_solicitud_rel."', '".$fechactual."', '".$fecha_req."', '".$beneficiario."', '".$concepto."', '".$factura."', '".$desarrollo."', '".$depto."', '".$monto."', '".$estatus_solicitud."', '".$nombre_factura."', '".$coment."')");	
			/* Recuperar id par numero de solicitud */
			echo libreriasJS();
			$id = regresa_id("1");
			if($cerrar_session == "cerrar"){
				echo '<body background="img/background.png"><div id="ventana"><p>Se genero el siguiente n&uacute;mero de su solicitud, por favor recu&eacute;rdelo para posteriores aclaraciones.<br /><br /><b>N&uacute;mero de solicitud: '.$id.'</b></p><br /><br /><center><button id="aceptar">Aceptar</button></div> <script type="text/javascript">cargar_ventana("ventana","Datos de solicitud",300,300); $("button").button(); $("#aceptar").click(function (){ window.location.assign("menugeneral.php"); });</script></body>';
			}else if($cerrar_session == "cerrar_usr_1"){
				echo '<body background="img/background.png"><div id="ventana"><p>Se genero el siguiente n&uacute;mero de su solicitud, por favor recu&eacute;rdelo para posteriores aclaraciones.<br /><br /><b>N&uacute;mero de solicitud: '.$id.'</b></p><br /><br /><center><button id="aceptar">Aceptar</button></div> <script type="text/javascript">cargar_ventana("ventana","Datos de solicitud",300,300); $("button").button(); $("#aceptar").click(function (){ window.location.assign("menu.php"); });</script></body>';
			}else{
				echo '<body background="img/background.png"><div id="ventana"><p>Se genero el siguiente n&uacute;mero de su solicitud, por favor recu&eacute;rdelo para posteriores aclaraciones.<br /><br /><b>N&uacute;mero de solicitud: '.$id.'</b></p><br /><br /><center><button id="aceptar">Aceptar</button></div> <script type="text/javascript">cargar_ventana("ventana","Datos de solicitud",300,300); $("button").button(); $("#aceptar").click(function (){ window.location.assign("caja.php"); });</script></body>';
			}
		break;
		case "sprov":
			$tipo_solicitud_rel=2; //Correspondiente a solicitud de proveedor
			$estatus_solicitud=1; //Correspondiente por default a NO APROBADA
			$fechactual; //Contiene la fecha actual del servidor
			$nombre_factura=subirArchivo($factura_archivo,"PR",$_SESSION['tipo_usr'],$tipo_archivo);
			if($coment==""){ $coment="Ninguno"; }
			agregar("INSERT INTO `solicitud` (`id_solicitud`,`usuario_creador_solicitud`, `tipo_solicitud`, `fecha_solicitud`, `fecha_requerida_solicitud`, `beneficiario_solicitud`, `concepto_solicitud`, `factura_solicitud`, `tipo_desarrollo_solicitud`, `tipo_departamento_solicitud`, `importe_solicitud`, `estatus_solicitud`, `imagen_factura_solicitud`, `comentario_solicitud`) VALUES (NULL,'".$usuario_creador."','".$tipo_solicitud_rel."', '".$fechactual."', '".$fecha_req."', '".$beneficiario."', '".$concepto."', '".$factura."', '".$desarrollo."', '".$depto."', '".$monto."', '".$estatus_solicitud."', '".$nombre_factura."', '".$coment."')");
			/* Recuperar id par numero de solicitud */
			echo libreriasJS();
			$id = regresa_id("2");
			if($cerrar_session == "cerrar"){
				echo '<body background="img/background.png"><div id="ventana"><p>Se genero el siguiente n&uacute;mero de su solicitud, por favor recu&eacute;rdelo para posteriores aclaraciones.<br /><br /><b>N&uacute;mero de solicitud: '.$id.'</b></p><br /><br /><center><button id="aceptar">Aceptar</button></div> <script type="text/javascript">cargar_ventana("ventana","Datos de solicitud",300,300); $("button").button(); $("#aceptar").click(function (){ window.location.assign("menugeneral.php"); });</script></body>';
			}else if($cerrar_session == "cerrar_usr_1"){
				echo '<body background="img/background.png"><div id="ventana"><p>Se genero el siguiente n&uacute;mero de su solicitud, por favor recu&eacute;rdelo para posteriores aclaraciones.<br /><br /><b>N&uacute;mero de solicitud: '.$id.'</b></p><br /><br /><center><button id="aceptar">Aceptar</button></div> <script type="text/javascript">cargar_ventana("ventana","Datos de solicitud",300,300); $("button").button(); $("#aceptar").click(function (){ window.location.assign("menu.php"); });</script></body>';
			}else{
				echo '<body background="img/background.png"><div id="ventana"><p>Se genero el siguiente n&uacute;mero de su solicitud, por favor recu&eacute;rdelo para posteriores aclaraciones.<br /><br /><b>N&uacute;mero de solicitud: '.$id.'</b></p><br /><br /><center><button id="aceptar">Aceptar</button></div> <script type="text/javascript">cargar_ventana("ventana","Datos de solicitud",300,300); $("button").button(); $("#aceptar").click(function (){ window.location.assign("proveedor.php"); });</script></body>';
			}
		break;
		case "scomision":
			$estatus_solicitud=1; //Correspondiente por default a NO APROBADA
			$fechactual; //Contiene la fecha actual del servidor
			$asesor = $_POST['asesor']; //Asesor
			$cliente = $_POST['cliente']; //Cliente
			$anticipo = $_POST['anticipo']; //Anticipo
			$nombre_factura=subirArchivo($factura_archivo,"CO",$_SESSION['tipo_usr'],$tipo_archivo);
			if($coment==""){ $coment="Ninguno"; }
			agregar("INSERT INTO `comisiones` (`id_comisiones`, `fecha_solicitud_comisiones`, `fecha_requerida_comisiones`, `asesor_comisiones`, `concepto_comisiones`, `factura_comisiones`, `tipo_departamento_comisiones`, `tipo_desarrollo_comisiones`, `monto_comisiones`, `cliente_comisiones`, `anticipo_comisiones`, `imagen_factura_comision`, `comentario_comisiones`, `estatus_comisiones`) VALUES (NULL, '".$fechactual."', '".$fecha_req."', '".$asesor."', '".$concepto."', '".$factura."', '".$depto."', '".$desarrollo."', '".$monto."', '".$cliente."', '".$anticipo."', '".$nombre_factura."', '".$coment."', '".$estatus_solicitud."')");
			/* Recuperar id par numero de solicitud */
			echo libreriasJS();
			$id = regresa_id("3");
			if($cerrar_session == "cerrar"){
				echo '<body background="img/background.png"><div id="ventana"><p>Se genero el siguiente n&uacute;mero de su solicitud, por favor recu&eacute;rdelo para posteriores aclaraciones.<br /><br /><b>N&uacute;mero de solicitud: '.$id.'</b></p><br /><br /><center><button id="aceptar">Aceptar</button></div> <script type="text/javascript">cargar_ventana("ventana","Datos de solicitud",300,300); $("button").button(); $("#aceptar").click(function (){ window.location.assign("menugeneral.php"); });</script></body>';
			}else if($cerrar_session == "cerrar_usr_1"){
				echo '<body background="img/background.png"><div id="ventana"><p>Se genero el siguiente n&uacute;mero de su solicitud, por favor recu&eacute;rdelo para posteriores aclaraciones.<br /><br /><b>N&uacute;mero de solicitud: '.$id.'</b></p><br /><br /><center><button id="aceptar">Aceptar</button></div> <script type="text/javascript">cargar_ventana("ventana","Datos de solicitud",300,300); $("button").button(); $("#aceptar").click(function (){ window.location.assign("menu.php"); });</script></body>';
			}else{
				echo '<body background="img/background.png"><div id="ventana"><p>Se genero el siguiente n&uacute;mero de su solicitud, por favor recu&eacute;rdelo para posteriores aclaraciones.<br /><br /><b>N&uacute;mero de solicitud: '.$id.'</b></p><br /><br /><center><button id="aceptar">Aceptar</button></div> <script type="text/javascript">cargar_ventana("ventana","Datos de solicitud",300,300); $("button").button(); $("#aceptar").click(function (){ window.location.assign("comision.php"); });</script></body>';
			}
		break;
		case "scliente":
			$asesorCliente = $_POST['asesor']; //Asesor
			$nombreCliente = $_POST['nombreCliente']; //Cliente
			$depCliente = $_POST['deptoCliente']; //Anticipo
			if($coment==""){ $coment="Ninguno"; }
			agregar("INSERT INTO `cliente` (`nombre_cliente`, `depto_cliente`, `asesor_cliente`, `comentarios_cliente`) VALUES ('".$nombreCliente."', '".$depCliente."', '".$asesorCliente."', '".$coment."')");
			/* Recuperar id par numero de solicitud */
			echo libreriasJS();
			if($cerrar_session == "cerrar"){
				echo '<body background="img/background.png"><div id="ventana"><p>El cliente, <b>'.$nombreCliente.'</b> se ha agregado exitosamente.</p><br /><br /><center><button id="aceptar">Aceptar</button></div> <script type="text/javascript">cargar_ventana("ventana","Agregar cliente",300,300); $("button").button(); $("#aceptar").click(function (){ window.location.assign("menugeneral.php"); });</script></body>';
			}else if($cerrar_session == "cerrar_usr_1"){
				echo '<body background="img/background.png"><div id="ventana"><p>El cliente, <b>'.$nombreCliente.'</b> se ha agregado exitosamente.</p><br /><br /><center><button id="aceptar">Aceptar</button></div> <script type="text/javascript">cargar_ventana("ventana","Agregar cliente",300,300); $("button").button(); $("#aceptar").click(function (){ window.location.assign("menu.php"); });</script></body>';
			}else{
				echo '<body background="img/background.png"><div id="ventana"><p>El cliente, <b>'.$nombreCliente.'</b> se ha agregado exitosamente.</p><br /><br /><center><button id="aceptar">Aceptar</button></div> <script type="text/javascript">cargar_ventana("ventana","Agregar cliente",300,300); $("button").button(); $("#aceptar").click(function (){ window.location.assign("cliente.php"); });</script></body>';
			}
		break;		
	}

?>