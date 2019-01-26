<?php
	// connect to db
	include("conexion.php");
	conectar("on");
	mysql_query("SET NAMES 'utf8'");
	// require our class
	require_once("grid.php");
	$tipo_solicitud = $_GET['tsajax'];
	
	switch ($tipo_solicitud){
		case 'cja':
			// load our grid with a table Caja
			$grid = new Grid("solicitud", array(
				"save"=>true,
				"delete"=>true,
				"where"=>"tipo_solicitud=1 AND estatus_solicitud=1",
				"fields"=>array(
					"tipo_departamento_solicitud"=>"(SELECT nombre_departamento FROM departamento WHERE id_departamento=tipo_departamento_solicitud)"
				),
				"select"=>'selFunc'
			));
			conectar("off");
		break;
		case 'prv':
			// load our grid with a table Provedor
			$grid = new Grid("solicitud", array(
				"save"=>true,
				"delete"=>true,
				"where"=>"tipo_solicitud=2 AND estatus_solicitud=1",
				"fields"=>array(
					"tipo_departamento_solicitud"=>"(SELECT nombre_departamento FROM departamento WHERE id_departamento=tipo_departamento_solicitud)"
				),
				"select"=>'selFunc'
			));
			conectar("off");
		break;
		case 'cims':
			// load our grid with a table Comisiones
			$grid = new Grid("comisiones", array(
				"save"=>true,
				"delete"=>true,
				"where"=>"estatus_comisiones=1",
				"fields"=>array(
					"cliente_comisiones"=>"(SELECT nombre_cliente FROM cliente WHERE id_cliente=cliente_comisiones)",
					"resto"=>"(monto_comisiones-anticipo_comisiones)"
				),
				"select"=>'selFunc'
			));
			conectar("off");
		break;
		
	}
	
	function selFunc($grid){
		$selects = array();
		$selects["estatus_comisiones"] = array("1"=>"No aprobado","2"=>"Aprobado");
		$selects["estatus_solicitud"] = array("1"=>"No aprobado","2"=>"Aprobado");
		$grid->render($selects);
	}
	
?>
