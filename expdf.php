<?php
function exporta($tabla,$titulo_doc){
	require('phps/mysql_table.php');
	//include("conexion.php");
	
	class PDF extends PDF_MySQL_Table
	{
		function Header($titulo='Datos de:')
		{
			//Title
			$this->SetFont('Arial','',18);
			$this->Cell(0,6,$titulo,0,1,'C');
			$this->Ln(10);
			//Ensure table header is output
			parent::Header();
		}
		// Pie de página
		function Footer()
		{
			// Posición: a 1,5 cm del final
			$this->SetY(-15);
			// Arial italic 8
			$this->SetFont('Arial','I',8);
			// Número de página
			$this->Cell(0,10,'GrupoCorintio - Pag: '.$this->PageNo(),0,0,'C');
		}
	}
	
	//Connect to database
	conectar("on");
	
	$pdf=new PDF('L','mm','A4'); //Pagina en horizontal
	//Fuente Linea 122 en mysql_table.php
	$pdf->AddPage();
	//$pdf->Header($titulo_doc);
	//First table: put all columns automatically
	switch ($tabla){
		case "tab_Des":
			$qry = 'SELECT nombre_desarrollo as Desarrollo,diereccion_desarrollo as Direccion,rfc_desarrollo as RFC,(SELECT nombre_usuario FROM usuario WHERE id_usuario=usuario_desarrollo) as Titular, (SELECT telefono_usuario FROM usuario WHERE id_usuario=usuario_desarrollo) as Telefono FROM desarrollo ORDER BY id_desarrollo';
			$pdf->Header($titulo_doc);
			$pdf->Table(conectar("on"), $qry);
			$pdf->Output("Desarrollos.pdf",'I');
			conectar("off");
		break;
		case "tab_Dep":
			$qry = 'SELECT nombre_departamento as Departamento FROM departamento ORDER BY nombre_departamento';
			$pdf->Header($titulo_doc);
			$pdf->Table(conectar("on"), $qry);
			$pdf->Output("Departamentos.pdf",'I');
			conectar("off");
		break;
		case "tab_Usr":
			$qry = 'SELECT email_usuario as Cuenta,
						password_usuario as Clave,
						nombre_usuario as Nombre,
						rfc_usuario as RFC,
						(SELECT tipo FROM tipo_usuario WHERE id_tipo_usuario=tipo_usuario) as Tipo,
						telefono_usuario as Telefono FROM usuario ORDER BY tipo_usuario';

			$pdf->Header($titulo_doc);
			$pdf->Table(conectar("on"), $qry);
			$pdf->Output("Usuarios.pdf",'I');
			conectar("off");
		break;
		case "tab_s_caja":
			$qry = 'SELECT id_solicitud as Num,
							factura_solicitud as NFactura,
							importe_solicitud as Importe,
							fecha_solicitud as Ingreso,
							fecha_requerida_solicitud as Requerida,
							beneficiario_solicitud as Beneficiario,
							(SELECT nombre_desarrollo FROM desarrollo WHERE id_desarrollo=tipo_desarrollo_solicitud) as Desarrollo,
							(SELECT nombre_departamento FROM departamento WHERE id_departamento=tipo_departamento_solicitud) as Departamento,
							concepto_solicitud as Concepto,
							(SELECT estatus FROM estatus_solicitud WHERE id_estatus_solicitud=estatus_solicitud) as Estatus,
							comentario_solicitud as Comentario 
							FROM solicitud WHERE tipo_solicitud=1 ORDER BY Requerida ASC';
			$pdf->Header($titulo_doc);
			$pdf->AddCol('Num',15,'Num','L');
			$pdf->AddCol('NFactura',15,'Fact','L');
			$pdf->AddCol('Importe',15,'Imp','L');
			$pdf->AddCol('Ingreso',15,'Ingreso','L');
			$pdf->AddCol('Requerida',15,'Requerida','L');
			$pdf->AddCol('Beneficiario',30,'Beneficiario','L');
			$pdf->AddCol('Desarrollo',25,'Desarrollo','L');
			$pdf->AddCol('Departamento',25,'Departamento','L');
			$pdf->AddCol('Concepto',40,'Concepto','L');
			$pdf->AddCol('Estatus',30,'Estado','L');
			$pdf->AddCol('Comentario',40,'Comentario','L');
			
			$prop=array('HeaderColor'=>array(255,150,100),
						'color1'=>array(210,245,255),
						'color2'=>array(255,255,210),
						'padding'=>2,
						'tamLetH'=>8,
						'tamLetR'=>6);
			$pdf->Table(conectar("on"), $qry, $prop);
			$pdf->Output("Cajachica.pdf",'I');
			conectar("off");
		break;
		case "tab_s_proveedor":
			$qry = 'SELECT id_solicitud as Num,
							factura_solicitud as NFactura,
							importe_solicitud as Importe,
							fecha_solicitud as Ingreso,
							fecha_requerida_solicitud as Requerida,
							beneficiario_solicitud as Beneficiario,
							(SELECT nombre_desarrollo FROM desarrollo WHERE id_desarrollo=tipo_desarrollo_solicitud) as Desarrollo,
							(SELECT nombre_departamento FROM departamento WHERE id_departamento=tipo_departamento_solicitud) as Departamento,
							concepto_solicitud as Concepto,
							(SELECT estatus FROM estatus_solicitud WHERE id_estatus_solicitud=estatus_solicitud) as Estatus,
							comentario_solicitud as Comentario 
							FROM solicitud WHERE tipo_solicitud=2 ORDER BY Requerida ASC';
			$pdf->Header($titulo_doc);
			$pdf->AddCol('Num',15,'Num','L');
			$pdf->AddCol('NFactura',15,'Fact','L');
			$pdf->AddCol('Importe',15,'Imp','L');
			$pdf->AddCol('Ingreso',15,'Ingreso','L');
			$pdf->AddCol('Requerida',15,'Requerida','L');
			$pdf->AddCol('Beneficiario',30,'Beneficiario','L');
			$pdf->AddCol('Desarrollo',25,'Desarrollo','L');
			$pdf->AddCol('Departamento',25,'Departamento','L');
			$pdf->AddCol('Concepto',40,'Concepto','L');
			$pdf->AddCol('Estatus',30,'Estado','L');
			$pdf->AddCol('Comentario',40,'Comentario','L');
			
			$prop=array('HeaderColor'=>array(255,150,100),
						'color1'=>array(210,245,255),
						'color2'=>array(255,255,210),
						'padding'=>2,
						'tamLetH'=>8,
						'tamLetR'=>6);
			$pdf->Table(conectar("on"), $qry, $prop);
			$pdf->Output("Proveedores.pdf",'I');
			conectar("off");
		break;
		case "tab_s_comision":
			$qry = 'SELECT id_comisiones as Num,
									fecha_solicitud_comisiones as Ingreso,
									fecha_requerida_comisiones as Requerida,
									(SELECT nombre_usuario FROM usuario WHERE id_usuario=asesor_comisiones) as Asesor,
									(SELECT nombre_desarrollo FROM desarrollo WHERE id_desarrollo=tipo_desarrollo_comisiones) as Desarrollo,
									(SELECT nombre_departamento FROM departamento WHERE id_departamento=tipo_departamento_comisiones) as Depto,
									monto_comisiones as Monto,
									(SELECT nombre_cliente FROM cliente WHERE id_cliente=cliente_comisiones) as Cliente,
									anticipo_comisiones as Anticipo,
									comentario_comisiones as comentario,
									(SELECT estatus FROM estatus_solicitud WHERE id_estatus_solicitud=estatus_comisiones) as Estado,
									(monto_comisiones-anticipo_comisiones) as Resta 
									FROM comisiones ORDER BY Requerida ASC';
			$pdf->Header($titulo_doc);
			$pdf->AddCol('Num',15,'Num','L');
			$pdf->AddCol('Ingreso',15,'Ingreso','L');
			$pdf->AddCol('Requerida',15,'Requerida','L');
			$pdf->AddCol('Desarrollo',30,'Desarrrollo','L');
			$pdf->AddCol('Depto',30,'Departamento','L');
			$pdf->AddCol('Asesor',40,'Asesor','L');
			$pdf->AddCol('Cliente',40,'Cliente','L');
			$pdf->AddCol('Monto',15,'Monto','L');
			$pdf->AddCol('Anticipo',15,'Anticipo','L');
			$pdf->AddCol('Resta',15,'Resta','L');
			$pdf->AddCol('Estado',20,'Estado','L');
			$pdf->AddCol('Comentario',40,'Comentario','L');
			
			$prop=array('HeaderColor'=>array(255,150,100),
						'color1'=>array(210,245,255),
						'color2'=>array(255,255,210),
						'padding'=>2,
						'tamLetH'=>8,
						'tamLetR'=>6);
			$pdf->Table(conectar("on"), $qry, $prop);
			$pdf->Output("Comisiones.pdf",'I');
			conectar("off");
		break;
		case "tab_s_todas":
			$qry = 'SELECT id_solicitud as Num,
							factura_solicitud as NFactura,
							importe_solicitud as Importe,
							(SELECT nombre_solicitud FROM tipo_solicitud WHERE id_tipo_solicitud=tipo_solicitud) as Tipo,
							fecha_solicitud as Ingreso,
							fecha_requerida_solicitud as Requerida,
							beneficiario_solicitud as Beneficiario,
							(SELECT nombre_desarrollo FROM desarrollo WHERE id_desarrollo=tipo_desarrollo_solicitud) as Desarrollo,
							(SELECT nombre_departamento FROM departamento WHERE id_departamento=tipo_departamento_solicitud) as Depto,
							concepto_solicitud as Concepto,
							(SELECT estatus FROM estatus_solicitud WHERE id_estatus_solicitud=estatus_solicitud) as Estatus,
							comentario_solicitud as Comentario 
							FROM solicitud ORDER BY Tipo DESC';
			$pdf->Header($titulo_doc);
			$pdf->AddCol('Num',15,'Num','L');
			$pdf->AddCol('NFactura',15,'Fact','L');
			$pdf->AddCol('Importe',15,'Imp','L');
			$pdf->AddCol('Tipo',25,'Tipo','L');
			$pdf->AddCol('Ingreso',15,'Ingreso','L');
			$pdf->AddCol('Requerida',15,'Requerida','L');
			$pdf->AddCol('Beneficiario',30,'Beneficiario','L');
			$pdf->AddCol('Desarrollo',30,'Desarrrollo','L');
			$pdf->AddCol('Depto',30,'Departamento','L');
			$pdf->AddCol('Concepto',30,'Concepto','L');
			$pdf->AddCol('Estatus',20,'Estado','L');
			$pdf->AddCol('Comentario',25,'Comentario','L');
			
			$prop=array('HeaderColor'=>array(255,150,100),
						'color1'=>array(210,245,255),
						'color2'=>array(255,255,210),
						'padding'=>2,
						'tamLetH'=>8,
						'tamLetR'=>6);
			$pdf->Table(conectar("on"), $qry, $prop);
			$pdf->Output("CompendioCajaProveedor.pdf",'I');
			conectar("off");
		break;
		case "tab_clientes":
			$qry = 'SELECT nombre_cliente as Cliente,
				depto_cliente as Depto,
				(SELECT nombre_usuario FROM usuario WHERE id_usuario=asesor_cliente) as Asesor,
				comentarios_cliente as Comentarios 
				FROM cliente ORDER BY Cliente;';
			$pdf->Header($titulo_doc);
			$pdf->Table(conectar("on"), $qry);
			$pdf->Output("Clientes.pdf",'I');
			conectar("off");
		break;
	}
	
}
?>