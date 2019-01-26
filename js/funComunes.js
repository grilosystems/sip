	function limpiar_formulario(){
		$("input type[text]").attr("value","");
	}
	function cerrar_solicitud(tipu){
		if(tipu=="1"){
			window.location.assign("menu.php");
		}else if(tipu=="2" || tipu=="3"){
			window.location.assign("menugeneral.php");
		}else{
			window.location.assign("index.html");
		}
	}
	function guardarSalir(tipu){
			if(tipu=="1"){
				$("#save_cerrar").val('cerrar_usr_1');
			}else{
				$("#save_cerrar").val('cerrar');
			}
	}
	function verifica(formulario){
		var campos="";
		var diaSem=$("#DiaSemana").val();
		switch (formulario) {
			case 1:
				var dato = $("#monto").val();
				$("#monto").val($.trim(dato));
				dato = $("#seldesDepartamento").val();
				$("#seldesDepartamento").val($.trim(dato));
				dato = $("#seldesDesarrollo").val();
				$("#seldesDesarrollo").val($.trim(dato));
				dato = $("#nfac").val();
				$("#nfac").val($.trim(dato));
				dato = $("#concep").val();
				$("#concep").val($.trim(dato));
				dato = $("#company").val();
				$("#company").val($.trim(dato));
				 
				if($("#fechareq").val()==""){
					campos+="Falta fecha requerida<br />";
				}
				if(diaSem==2 || diaSem==3){
					campos+="Este d&iacute;a no puede introducir la solicitud.<br />";
				}
				if($("#company").val()==""){
					campos+="Falta beneficiario<br />";
				}
				if($('#factura').val()==""){
					campos+="Falta la copia de la factura<br />";
				}else{
					var archivo=$("#factura").val();
					var extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
					if(extension!=".jpg"){
						if(extension!=".pdf"){
							campos+="El formato de la factura debe ser .jpg ó .pdf<br />";
						}
					}
				}
				if($("#concep").val()==""){
					campos+="Falta concepto<br />";
				}
				if($("#nfac").val()==""){
					campos+="Falta factura<br />";
				}
				if($("#seldesDesarrollo").val()==""){
					campos+="Falta desarrollo<br />";
				}
				if($("#seldesDepartamento").val()==""){
					campos+="Falta departamento<br />";
				}
				if($("#monto").val()==""){
					campos+="Falta monto<br />";
				}
				if(campos!=""){
					$("#dialogo").html(campos);
					$("#dialogo").dialog();
				}
			break;
			case 2:
				var dato = $("#fechareq").val();
				$("#fechareq").val($.trim(dato));
				dato = $("#seldesCliente").val();
				$("#seldesCliente").val($.trim(dato));
				dato = $("#concep").val();
				$("#concep").val($.trim(dato));
				dato = $("#nfc").val();
				$("#nfc").val($.trim(dato));
				dato = $("#seldesDesarrollo").val();
				$("#seldesDesarrollo").val($.trim(dato));
				dato = $("#seldesAsesor").val();
				$("#seldesAsesor").val($.trim(dato));
				dato = $("#seldesDepartamento").val();
				$("#seldesDepartamento").val($.trim(dato));
				dato = $("#anticipo").val();
				$("#anticipo").val($.trim(dato));
				dato = $("#monto").val();
				$("#monto").val($.trim(dato));
				
				if($("#fechareq").val()==""){
					campos+="Falta fecha requerida<br />";
				}
				if(diaSem==2 || diaSem==3){
					campos+="Este d&iacute;a no puede introducir la solicitud.<br />";
				}
				if($("#seldesCliente").val()==""){
					campos+="Falta cliente<br />";
				}
				if($('#factura').val()==""){
					campos+="Falta la copia de la factura<br />";
				}else{
					var archivo=$("#factura").val();
					var extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
					if(extension!=".jpg"){
						if(extension!=".pdf"){
							campos+="El formato de la factura debe ser .jpg ó .pdf<br />";
						}
					}
				}
				if($("#concep").val()==""){
					campos+="Falta concepto<br />";
				}
				if($("#nfc").val()==""){
					campos+="Falta factura<br />";
				} 
				if($("#seldesDesarrollo").val()==""){
					campos+="Falta desarrollo<br />";
				}
				if($("#seldesAsesor").val()==""){
					campos+="Falta asesor<br />";
				}
				if($("#seldesDepartamento").val()==""){
					campos+="Falta departamento<br />";
				}				
				if($("#anticipo").val()==""){
					campos+="Falta anticipo<br />";
				}else{
					var anticipo=parseInt($("#anticipo").val());
				}
				if($("#monto").val()==""){
					campos+="Falta monto<br />";
				}else{
					var monto=parseInt($("#monto").val());
				}
				if(monto < anticipo){
					campos+="El monto no puede ser menor que el anticipo, verifique<br />Monto: "+$("#monto").val()+"<br />Anticipo: "+$("#anticipo").val();
				}
				if(campos!=""){
					$("#dialogo").attr("title","Error en los campos");
					$("#dialogo").html(campos);
					$("#dialogo").dialog();
				}
			break;
			case 3://Quitar espacios
				var cadena="";
				cadena=$("#correo").val();
				$("#correo").attr("value",$.trim(cadena));
				cadena=$("#clave").val();
				$("#clave").attr("value",$.trim(cadena));
				cadena=$("#nombre").val();
				$("#nombre").attr("value",$.trim(cadena));
				cadena=$("#rfc").val();
				$("#rfc").attr("value",$.trim(cadena));
				
				if($("#correo").val()==""){
					campos+="<li>El nombre del correo o cuenta no la indico</li>";
				}else{
					var filter=/^[A-Za-z][A-Za-z0-9_]*@[A-Za-z0-9_]+\.[A-Za-z0-9_.]+[A-za-z]$/;
					if (!(filter.test($("#correo").val()))){
						campos+="<li>El nombre de suario debe ser un correo valido y real.</li>";
					}
				}
				if($("#clave").val()==""){
					campos+="<li>La clave no la indico</li>";
				}
				if($("#nombre").val()==""){
					campos+="<li>El nombre del usuario esta mal</li>";
				}
				if($("#rfc").val()==""){
					campos+="<li>El RFC esta mal</li>";
				}
				if($("#tipo_de_usuario").val()==""){
					campos+="<li>Debe especificar un tipo de usuario</li>";
				}
			break;
			case 4:
				//Quitar espacios
				var cadena="";
				cadena=$("#desarrollo").val();
				$("#desarrollo").attr("value",$.trim(cadena));
				cadena=$("#rfc").val();
				$("#rfc").attr("value",$.trim(cadena));
				cadena=$("#direccion").val();
				$("#direccion").attr("value",$.trim(cadena));
				
				if($("#desarrollo").val()==""){
					campos+="<li>El nombre del desarrollo no la indico</li>";
				}
				if($("#direccion").val()==""){
					campos+="<li>No indico dirección del desarrollo</li>";
				}
				if($("#rfc").val()==""){
					campos+="<li>El RFC esta mal</li>";
				}
				if($("#titular_des").val()==""){
					campos+="<li>Debe especificar un titular del desarrollo</li>";
				}
			break;
			case 5:
				//Quitar espacios
				var cadena="";
				cadena=$("#departamento").val();
				$("#departamento").attr("value",$.trim(cadena));
				
				if($("#departamento").val()==""){
					campos="<li>El nombre del departamento no lo indico</li>";
				}
			break;
			case 6:
				var cadena="";
				cadena=$("#nomCliente").val();
				$("#nomCliente").attr("value",$.trim(cadena));
				cadena=$("#deptoCliente").val();
				$("#deptoCliente").attr("value",$.trim(cadena));
				
				if($("#nomCliente").val()==""){
					campos+="Debe indicar el nombre del cliente, recuerde que es completo. (nombre(s) y apellidos)<br /><br />";
				}
				if($("#deptoCliente").val()==""){
					campos+="Debe indicar el n&uacute;mero del departamento del cliente.<br /><br />";
				}
				if($("#seldesAsesor").val()==""){
					campos+="Debe seleccionar un asesor existente.<br /><br />";
				}
				if(campos!=""){
					$("#dialogo").html(campos);
					$("#dialogo").dialog();
				}
			break;
			case 7:
				var cadena="";
				cadena=$("#nomCliente").val();
				$("#nomCliente").attr("value",$.trim(cadena));
				cadena=$("#deptoCliente").val();
				$("#deptoCliente").attr("value",$.trim(cadena));
				
				if($("#nomCliente").val()==""){
					campos+="<li>Debe indicar el nombre completo (nombres y apellidos)</li>";
				}
				if($("#deptoCliente").val()==""){
					campos+="<li>Debe indicar el departamento</li>";
				}
				if($("#seldesAsesor").val()==""){
					campos+="<li>Debe indicar un asesor</li>";
				}
			break;
		}
		if(campos==""){
			return true;
		}else{
			if(formulario==3 || formulario==4 || formulario==5 || formulario==7){
				return campos;
			}
			return false;
		}
	}
	function calendario(campo){
		obj="#"+campo;
		$(obj).datepicker({minDate:-1,maxDate:"0M 1W"});
	}
	function cargar_ventana(id,titulo,w,h){
		if(w==null || h==null){
			w=788;
			h=500;
		}
		$("#"+id).dialog( { 
			title: titulo,
			width: w, 
			minHeight: h, 
			modal: true, 
			resizable: false,
			beforeClose: function()
						{
							window.location.assign("menu.php");
						} 
		} );
	}
	function enviar_datos_ajax(pagina,datos,id_div){
		if(id_div==""){
			$.ajax({
				async:true,
					type:"post",
					dataType:"html",
					contentType: "application/x-www-form-urlencoded",
					url:pagina,
					data:datos,
					//beforeSend:espera,
					success:llegada,
					timeout:2000,
					error:problemas
				});
		}else{
			$.ajax({
				async:true,
					type:"post",
					dataType:"html",
					contentType: "application/x-www-form-urlencoded",
					url:pagina,
					data:datos,
					//beforeSend:espera,
					success:function (data){
							$("#"+id_div).html(data);
						},
					timeout:2000,
					error:problemas
				});
		}
	}
	function subirImagenAjax(pagina,datos,id_div){
		$.ajax({
			url:pagina, //Url a donde la enviaremos
			type:'POST', //Metodo que usaremos
			contentType:false, //Debe estar en false para que pase el objeto sin procesar
			data:datos, //Le pasamos el objeto que creamos con los archivos
			processData:false, //Debe estar en false para que JQuery no procese los datos a enviar
			cache:false //Para que el formulario no guarde cache
  		}).done(function(msg){
    	$("#"+id_div).append(msg); //Mostrara los archivos cargados en el div con el id "Cargados"
  });
	}
	function problemas(){
		alert("Problemas con el servidor.");
	}
	function espera(){
		
	}
	function llegada(data){
		$("body").html(data);
	}
	function sobre(){
		var x=$(this).attr("id");
		$(this).addClass("botonesSobre");
		switch (x){
			case "caja":
				mensaje="<p align='center' style='border: 2px dotted #06F; padding-top:10px; padding-bottom:10px;'>Modifica las solicitudes de rembolso de caja chica.</p>";
			break;
			case "comision":
				mensaje="<p align='center' style='border: 2px dotted #06F; padding-top:10px; padding-bottom:10px;'>Modifica las solicitudes de comisiones.</p>";
			break;
			case "proveedor":
				mensaje="<p align='center' style='border: 2px dotted #06F; padding-top:10px; padding-bottom:10px;'>Modifica las solicitudes de los proveedores.</p>";
			break;
		}
		$("#cabecera").html(mensaje);
		$("#cabecera").addClass("cabeceraSobre");
	}			
	function fuera(){
		$("#cabecera").html("<p align='center'>De click en uno de los siguientes botones para listar, buscar y editar las solicitudes.</p>");
		$("#cabecera").removeClass("cabeceraSobre");
		$(this).removeClass("botonesSobre");
	}
	function soloNumeros(e)
    {
		var keynum = window.event ? window.event.keyCode : e.which;
		if ((keynum == 8) || (keynum == 46))
		return true;
		 
		return /\d/.test(String.fromCharCode(keynum));
    }
	function filasModificadas(solicitudes){
		alert("Numero de IDs: " + solicitudes.length + solicitudes[0] + " " + solicitudes[1]);
	}
	/* LIMITAR FECHAS
	var fech_r=($("#fechareq").val()).split('/');
					var fech_c=($("#fecha_actual").val()).split('-');
					var anio_r = fech_r[0], mes_r = fech_r[1], dia_r = fech_r[2];
					var anio_c = fech_c[0], mes_c = fech_c[1], dia_c = fech_c[2];
					//campos+="año r:"+anio_r+"mes r:"+mes_r+"dia r:"+dia_r+"<br />año c:"+anio_c+"mes c:"+mes_c+"dia c:"+dia_c+"<br />";
					if(anio_c==anio_r){
						if(mes_c==mes_r){
							if(dia_r>dia_c){
								campos=campos;
							}else{
								campos+="El dia requerido no puede ser anterior al dia de hoy. Verifeque la fecha<br />";
							}
						}else{
							campos+="El mes requerido debe ser solo de este mes. Verifeque la fecha<br />";
						}
					}else{
						campos+="No puede ser de otro año diferente a este. Verifeque la fecha<br />";
					}
*/