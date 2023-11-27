let tablaActas = null, tablaAcuerdos = null;

$(document).ready(function (){
	if(segmento2 == ''){
		tablaActas = $('#tablaActas').DataTable({
			ajax: {
				url: base_url + 'actas/lista',
				type: 'post',
				data: function(d){
					d.anio = $('#anio').val()
				}
			},
			bAutoWidth:false, bDestroy:true, responsive:true, select:false, lengthMenu:[[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todas']], language: lngDataTable,
			columns:[
				{
					data: null,
					orderable: false,
					render: function(data){
						let hrefEdit = (data.activo === '1' && btnEdit)?'href="'+base_url+'actas/editar?id='+data.idacta+'"':'';
						let hrefAnular = (data.activo === '1' && btnAnular && data.activo === '1')?'href="'+base_url+'actas/anular?id='+data.idacta+'"':'';
						let hrefAcuerdos = (data.activo === '1' && btnAcuerdos)?'href="'+base_url+'actas/acuerdos?id='+data.idacta+'"':'';
						let hrefReporte = (data.activo === '1' && btnReporte)?'href="'+base_url+'actas/reporte?id='+data.idacta+'"':'';
						/*let hrefEval = (data.activo === '1' && btnEval && parseInt(data.idestado) < 3 && 
							data.calificado === '0' && data.idestado === '2')?'href="'+base_url+'locadores/evaluar?id='+data.idconvocatoria+'"':'';
						let hrefPub = (data.activo === '1' && btnPub && parseInt(data.idestado) < 3 && parseInt(data.calificado))?
								'href="'+base_url+'locadores/ver?id='+data.idconvocatoria+'"':'';*/
						let btnAccion =
							'<div class="btn-group">'+
								'<a '+(hrefEdit?'title="Editar Acta" '+hrefEdit:'')+' class="bg-info btnTable">'+
									'<img src="'+base_url+'public/images/edit_ico.png" width="22"></a>'+
								'<a '+(hrefAcuerdos?'title="Registrar Acuerdos" '+hrefAcuerdos:'')+' class="bg-warning btnTable px-1">'+
									'<img src="'+base_url+'public/images/evaluar_ico.png" width="15"></a>'+
								'<a '+(hrefAnular?'title="Anular Acta" '+hrefAnular:'')+' class="bg-danger btnTable '+(hrefAnular?'anular':'')+'">'+
									'<img src="'+base_url+'public/images/cancel_ico.png" width="22"></a>'+
								'<a '+(hrefReporte?'title="Ver Reporte" '+hrefReporte:'')+' class="bg-light btnTable border border-secondary" target="_blank">'+
									'<img src="'+base_url+'public/images/pdf_ico.png" width="18"></a>'+
							'</div>';
						return btnAccion;
					}
				},
				{ data: 'anio' },{ data: 'cor' },{ data: 'fecha' },{ data: 'descripcion' },
				{
					data: 'activo',
					render: function(data){
						let var_status = '';
						switch(data){
							case '1': var_status = '<span class="text-success">Activo</span>'; break;
							case '0': var_status = '<span class="text-danger">Inactivo</span>'; break;
						}
						return var_status;
					}
				},
				/*{ data: 'fi', render: function(data,type,row,meta){ return data+'<br><span style="color:#0000FF;font-weight:bold">'+row.hinicio+'</span>'; } },
				{ data: 'ff', render: function(data,type,row,meta){ return data+'<br><span style="color:#0000FF;font-weight:bold">'+row.hfin+'</span>'; } },
				{
					data: 'archivo_base',
					render: function(data){
						let href = 'href="'+base_url+'locadores/descargar?file='+data+'"', ext = $(data.split('.')).get(-1);
						let img = '<a title="Descargar" '+href+'><img src="'+base_url+'public/images/pdf_ico.png" width="27"></a>'
						if(ext === 'doc' || ext === 'docx'){
							img = '<a title="Descargar" '+href+'><img src="'+base_url+'public/images/word_ico.png" width="27"></a>';
						}
						return img;
					}
				},
				{
					data: 'archivo_anexos',
					render: function(data){
						let href = 'href="'+base_url+'locadores/descargar?file='+data+'"', ext = $(data.split('.')).get(-1);
						let img = '<a title="Descargar" '+href+'><img src="'+base_url+'public/images/pdf_ico.png" width="27"></a>'
						if(ext === 'doc' || ext === 'docx'){
							img = '<a title="Descargar" '+href+'><img src="'+base_url+'public/images/word_ico.png" width="27"></a>';
						}
						return img;
					}
				},{ data: 'fecha_registro' },*/
			],
			columnDefs:headers, order: [],
		});
	}else if(segmento2 === 'acuerdos'){
		tablaAcuerdos = $('#tablaAcuerdos').DataTable({
			ajax: {
				url: base_url + 'actas/listaacuerdos',
				type: 'post',
				data: function(d){
					d.idacta = $('#idacta').val()
				}
			},
			bAutoWidth:false, bDestroy:true, responsive:true, select:false, lengthMenu:[[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todas']], language: lngDataTable,
			columns:[
				{
					data: null,
					orderable: false,
					render: function(data){
						let hrefEditar = data.activo === '0'? 'class="bg-info btnTable"' : 'href="#" data-target="#modalEdit" data-toggle="modal" class="bg-info btnTable editar"';
						let hrefAnular = data.activo === '0'? 'class="bg-danger btnTable"' : 'href="'+base_url+'acuerdos/anular?id='+
								data.idacuerdo+'&idacta='+data.idacta+'" class="bg-danger btnTable anular"';
						let btnAccion =
							'<div class="btn-group">'+
								'<a title="Editar Acuerdo" '+hrefEditar+' >'+
									'<img src="'+base_url+'public/images/edit_ico.png" width="22"></a><a title="Anular Acuerdo" '+hrefAnular+' >'+
									'<img src="'+base_url+'public/images/cancel_ico.png" width="22"></a>'+
							'</div>';							
						return btnAccion;
					}
				},
				{ data: 'correlativo', render: function(data){ return ceros(data, 5); } },{ data: 'acuerdo' },{ data: 'responsables' },
				{ data: 'fecha_inicial', render:function(data){ let fecha = new Date(data);
							return fecha.toLocaleString('es-PE', { timeZone: 'UTC', year: 'numeric', month: 'numeric', day: 'numeric' }); } },
				{
					data: 'check_inicio',
					render: function(data){
						return '<div class="abs-center"><label class="check"><input type="checkbox" class="inicio" '+
								(data == '1'?'checked':'')+' onclick="return false;" /></label></div>';
					}
				},
				{ data: 'fecha_iniciacion', render:function(data){
						let fecha = isNaN(Date.parse(data))? '' : new Date(data);
						return (fecha != '')? fecha.toLocaleString('es-PE', { timeZone: 'UTC', year: 'numeric', month: 'numeric', day: 'numeric' }) : ''; } },
				{ data: 'fecha_final', render:function(data){ let fecha = new Date(data);
						return fecha.toLocaleString('es-PE', { timeZone: 'UTC', year: 'numeric', month: 'numeric', day: 'numeric' }); } },
				{
					data: 'check_final',
					render: function(data){
						return '<div class="abs-center"><label class="check"><input type="checkbox" class="final" '+
								(data == '1'?'checked':'')+' onclick="return false;" /></label></div>';
					}
				},
				{ data: 'fecha_finalizacion', render:function(data){
						let fecha = isNaN(Date.parse(data))? '' : new Date(data);
						return (fecha != '')? fecha.toLocaleString('es-PE', { timeZone: 'UTC', year: 'numeric', month: 'numeric', day: 'numeric' }) : ''; } },
				{
					data: 'activo',
					render: function(data){
						let var_status = '';
						switch(data){
							case '1': var_status = '<span class="text-success">Activo</span>'; break;
							case '0': var_status = '<span class="text-danger">Anulado</span>'; break;
						}
						return var_status;
					}
				},
				{
					data: null,
					orderable: false,
					render: function(data){
						let color = 0, finic = isNaN(Date.parse((data.fecha_iniciacion)))? 0 : Date.parse((data.fecha_iniciacion).slice(0,-9)); let hoy = new Date();
						hoy = Date.parse(hoy.toLocaleDateString('es-PE')); let img = '';
						
						if(data.activo === '0'){
							color = 0;
						}else{
							if(finic === 0){
								//if(hoy === Date.parse(data.fecha_inicial)) color = 0;
								if(hoy > Date.parse(data.fecha_inicial) && hoy < Date.parse(data.fecha_final) || hoy === Date.parse(data.fecha_final)) color = 2;
								else if(hoy > Date.parse(data.fecha_final)) color = 3;
							}
							if(finic > 0){
								if(finic === Date.parse(data.fecha_inicial)) color = 1;
								else if(finic > Date.parse(data.fecha_inicial) && (finic < Date.parse(data.fecha_final) || finic === Date.parse(data.fecha_final))) color = 2;
								else if(finic > Date.parse(data.fecha_final)) color = 3;
							}
						}
						
						switch(color){
							case 0:
								img = base_url+'public/images/semaforo/gris.png';
								break;
							case 1:
								img = base_url+'public/images/semaforo/verde.png';
								break;
							case 2:
								img = base_url+'public/images/semaforo/ambar.png';
								break;
							case 3:
								img = base_url+'public/images/semaforo/rojo.png';
								break;
						}
						return '<div class="abs-center"><img src="'+img+'" width="27" /></div>';
					}
				}
			],
			columnDefs:[
				{title: 'Acciones',targets: 0},{title:'Correlativo',targets: 1},{title:'Acuerdo',targets: 2},{title:'Responsables',targets: 3},
				{title:'Inicio(Acuerdo)',targets: 4},{title:'Iniciado',targets: 5},{title:'Fecha Iniciado',targets: 6},{title:'Fin(Acuerdo)',targets: 7},
				{title:'Finalizado',targets: 8},{title:'Fecha Finalizado',targets: 9},{title:'Estado',targets: 10},{title:'Avance',targets: 11},
			], order: [],
		});
		
		var resolvedOptions = Intl.DateTimeFormat().resolvedOptions();
		console.log(resolvedOptions);
	}
});

$('#anio').bind('change', function(){
	tablaActas.ajax.reload();
});


/*
$('.atach').bind('change', function(){
	let file = this.files[0], arr = (this.files[0]!==undefined?file.name.split('.'):[]), ext = $(arr).get(-1);
	
	if(ext === 'pdf' || ext === 'docx' || ext === 'doc'){
		if(this.id === 'customfile'){
			$('.tdr').html(file.name);
			$('.sptdr').html('<span class="text-primary">Archivo Correcto</span>');
			$('#file1').val(file.name);
		}else if(this.id === 'customfile1'){
			$('.anexo').html(file.name);
			$('.spanexo').html('<span class="text-primary">Archivo Correcto</span>');
			$('#file2').val(file.name);
		}
	}else{
		$(file).val('');
		if(this.id === 'customfile'){
			$('.sptdr').html('<span class="text-danger">Archivo inv&aacute;lido</span>');
			$('#file1').val(''), $('.tdr').html('');
		}else if(this.id === 'customfile1'){
			$('.spanexo').html('<span class="text-danger">Archivo inv&aacute;lido</span>');
			$('#file2').val(''), $('.anexo').html('');
		}
	}
});*/
$('.form').validate({
	errorClass: 'form_error',
	/*validClass: 'success',*/
	rules: { 
		acuerdo: { required: function () { if ($('#acuerdo').css('display') != 'none') return true; else return false; } },
		responsables: { required: function () { if ($('#responsables').css('display') != 'none') return true; else return false; } },
	},
	messages: {
		acuerdo: { required: 'Campo requerido' },
		responsables: { required: 'Campo requerido' },
	},
	errorPlacement: function(error, element){
		error.insertAfter(element);
	},
	submitHandler: function (form, event){
		event.preventDefault();
		let json = [{ 'correlativo':$('#correlativo').val(),'acuerdo':$('#acuerdo').val(),'responsables':$('#responsables').val(),'fecha_inicial':$('#finicio').val(),
					'check_inicio':0,'fecha_iniciacion':'','fecha_final':$('#ffin').val(),'check_final':0,'fecha_finalizacion':'',
					'activo':'1'
			}];
		
		tablaAcuerdos.rows.add(json).draw();
		form.reset();
		//let data = tablaAcuerdos.rows().data().toArray();
		let data = tablaAcuerdos.rows().data(), nro = data.length, n = 0;
		$.each(data,function(i,e){
			if(i === nro - 1) n = parseInt(e.correlativo) + 1;
		});
		$('#correlativo').val(n);
	}
});

$('#guardar').bind('click',function(e){
	let json = [], i = 0, idacta = $('#idacta').val(), check_i = 0, check_f = 0;
	if(tablaAcuerdos.rows().data().length > 0){
		tablaAcuerdos.rows().iterator('row', function (context, index){
			let node = $(this.row(index).node());
			let ci = node.find('.inicio'), cf = node.find('.final'), fi = node.find('.iniciacion'), ff = node.find('.finalizacion');
			let data = this.row(index).data();
			check_i = ci.prop('checked')? 1: 0; check_f = cf.prop('checked')? 1: 0; fi = (fi.val() != ''? fi.val() : null); ff = (ff.val() != ''? ff.val() : null);
			
			json[i] = {'idacta':idacta,'correlativo':data.correlativo,'acuerdo':data.acuerdo,'responsables':data.responsables,'fecha_inicial':data.fecha_inicial,
				'fecha_final':data.fecha_final,'check_inicio':check_i,'check_final':check_f,'activo':1,'fecha_iniciacion':fi,'fecha_finalizacion':ff};
			i++;
		});
		$.ajax({
			data: JSON.stringify(json),
			url: base_url + 'acuerdos/registrar',
			method: 'POST',
			dataType: 'JSON',
			error: function(xhr){ $('#guardar').removeClass('disabled'), $('#guardar').html('Guardar/Actualizar Detalle'); },
			beforeSend: function(){
				$('#guardar').html('<span class="spinner-border spinner-border-sm"></span>&nbsp;&nbsp;Cargando...');
				$('#guardar').addClass('disabled');
			},
			success: function(data){
				$('#guardar').removeClass('disabled'), $('#guardar').html('Guardar/Actualizar Detalle');
				if(parseInt(data.status) === 200){
					tablaAcuerdos.ajax.reload();
					$('#correlativo').val(data.nro);
				}
				$('.resp').html(data.data);
				setTimeout(function () { $('.resp').html(''); }, 2500);
				
			}
		});
	}
});

$('#tablaActas').bind('click','a',function(e){
	let el = e.target, a = $(el).closest('a'), mensaje = '';
	let data = tablaActas.row(a).child.isShown()? tablaActas.row(a).data() : tablaActas.row($(el).parents('tr')).data();
	if($(a).hasClass('anular')){
		e.preventDefault();
		mensaje = 'Seguro que desea Anular el Acta?';
		let confirmacion = confirm(mensaje);
		if(confirmacion){
			$.ajax({
				data: {},
				url: $(a).attr('href'),
				method: 'GET',
				dataType: 'JSON',
				error: function(xhr){},
				beforeSend: function(){},
				success: function(data){
					if(parseInt(data.status) === 200){
						tablaActas.ajax.reload();
					}
					$('.resp').html(data.msg);
					setTimeout(function () { $('.resp').html(''); }, 2500);
				}
			});
		}
	}
});

$('#tablaAcuerdos').bind('click','a',function(e){
	let el = e.target, a = $(el).closest('a'), mensaje = '';
	let data = tablaAcuerdos.row(a).child.isShown()? tablaAcuerdos.row(a).data() : tablaAcuerdos.row($(el).parents('tr')).data();
	if($(a).hasClass('anular')){
		e.preventDefault();
		mensaje = 'Seguro que desea Anular el Acuerdo?';
		let confirmacion = confirm(mensaje);
		if(confirmacion){
			$.ajax({
				data: {},
				url: $(a).attr('href'),
				method: 'GET',
				dataType: 'JSON',
				error: function(xhr){},
				beforeSend: function(){},
				success: function(data){
					if(parseInt(data.status) === 200){
						tablaAcuerdos.ajax.reload();
						$('#correlativo').val(data.nro);
					}
					$('.resp').html(data.msg);
					setTimeout(function () { $('.resp').html(''); }, 2500);
				}
			});
		}
	}else if($(a).hasClass('editar')){
		let fecha = '';
		$('#ecorrelativo').val(data.correlativo);
		$('#eacuerdo').val(data.acuerdo);
		$('#eresponsables').val(data.responsables);
		$('#efinicio').val(data.fecha_inicial);
		$('#effin').val(data.fecha_final);
		$('#eidacuerdo').val(data.idacuerdo);
		
		if(data.check_inicio === '1'){
			fecha = new Date(data.fecha_iniciacion);
			fecha = fecha.toLocaleString('es-PE', { timeZone: 'UTC', year: 'numeric', month: 'numeric', day: 'numeric' });
			$('#ceini').prop('checked', true), $('#eini').removeClass('d-none'), $('#eini').val(fecha);
		}
		if(data.check_final === '1'){
			fecha = new Date(data.fecha_finalizacion);
			fecha = fecha.toLocaleString('es-PE', { timeZone: 'UTC', year: 'numeric', month: 'numeric', day: 'numeric' });
			$('#cefin').prop('checked', true), $('#efin').removeClass('d-none'), $('#efin').val(fecha);
		}
		console.log(data);
	}
});

$('#ceini').bind('change', function(){
	if($(this).prop('checked')){
		$('#eini').removeAttr('readonly'), $('#eini').removeClass('d-none'), $('#eini').val('');
	}else $('#eini').prop('readonly', true), $('#eini').addClass('d-none'), $('#eini').val('');
});

$('#cefin').bind('change', function(){
	if($(this).prop('checked')){
		$('#efin').removeAttr('readonly'), $('#efin').removeClass('d-none'), $('#efin').val('');
	}else $('#efin').prop('readonly', true), $('#efin').addClass('d-none'), $('#efin').val('');
});

$('#modalEdit').on('hidden.bs.modal',function(e){
	$('#form_edit')[0].reset();
	$('#form_edit input:checkbox').prop('checked',false);
	$('#efin').addClass('d-none'), $('#efin').val(''), $('#eini').addClass('d-none'), $('#eini').val('');
	$('#eini').removeAttr('readonly'), $('#efin').removeAttr('readonly');
	$('body,html').animate({ scrollTop: 0 }, 'fast');
	//setTimeout(function () { if(!$('.mesg').css('display') == 'none' || $('.mesg').css('opacity') == 1) $('.mesg').hide('slow'); }, 3000);*/
});

$('#editAcuerdo').bind('click', function(){
	let formData = new FormData(document.getElementById('form_edit'));
	$.ajax({
		data: new URLSearchParams(formData).toString(),
		url: base_url + 'acuerdos/editAcuerdo',
		method: 'POST',
		dataType: 'JSON',
		beforeSend: function(){},
		success: function(data){
			$('.resp').html(data.msg);
			if(data.status === 200) tablaAcuerdos.ajax.reload();
			setTimeout(function(){ $('.resp').html(''); }, 2500);
		}
	});
});
/*
function formatoFecha(fecha, formato) {
	let m = (fecha.getMonth()+1).toString();
	m = m.length < 2? '0'+m : m;
    const map = {
        Y: fecha.getFullYear(),
		m: m,
		d: fecha.getDate(),
        h: fecha.getHours()+':'+fecha.getMinutes(),
    }
    return formato.replace(/Y|m|d|h/gi, matched => map[matched])
}

$('.blur').on('blur',function(){
	let id = $(this).attr('id');
	if(!isNaN(this)){
		alert('Formato de fecha errado');
		let fecha = formatoFecha(new Date(),'Y-m-d h'); $('#finicio').val(fecha), $('#ffin').val(fecha);
	}else{
		let f2 = new Date($('#ffin').val()), f1 = new Date($('#finicio').val());
		if((f2.getTime()-f1.getTime()) < 0){
			alert('La fecha/hora inicial no puede ser mayor que la fecha/hora final');
			let fecha = formatoFecha(new Date(),'Y-m-d h'); $('#finicio').val(fecha), $('#ffin').val(fecha);
		}
	}
});

$('#tablaLocadores').bind('click','a',function(e){
	let el = e.target, a = $(el).closest('a'), mensaje = '';
	let data = tablaLocadores.row(a).child.isShown()? tablaLocadores.row(a).data() : tablaLocadores.row($(el).parents('tr')).data();
	if($(a).hasClass('cancelar')){
		e.preventDefault();
		mensaje = 'Seguro que desea Cancelar la convocatoria?';
		let confirmacion = confirm(mensaje);
		if(confirmacion){
			$.ajax({
				data: {},
				url: $(a).attr('href'),
				method: 'GET',
				dataType: 'JSON',
				error: function(xhr){},
				beforeSend: function(){},
				success: function(data){
					if(parseInt(data.status) === 200){
						tablaLocadores.ajax.reload();
					}
					$('.resp').html(data.msg);
					setTimeout(function () { $('.resp').html(''); }, 2500);
				}
			});
		}
	}
});

$('#tablaEval').bind('input',function(e){
	let el = e.target;
	if($(el).attr('type') === 'text'){
		jQuery(el).val(jQuery(el).val().replace(/([^0-9\.]+)/g, ''));
		jQuery(el).val(jQuery(el).val().replace(/^[\.]/,''));
		jQuery(el).val(jQuery(el).val().replace(/[\.][\.]/g,''));
		jQuery(el).val(jQuery(el).val().replace(/\.(\d)(\d)(\d)/g,'.$1$2'));
		jQuery(el).val(jQuery(el).val().replace(/\.(\d{1,2})\./g,'.$1'));
	}
});
$('#tablaEval').bind('click',function(e){
	let el = e.target;
	if($(el).attr('type') === 'text') $(el).select();
});
$('#evaluar').bind('click',function(e){
	//let arr = tablaEval.rows().data().toArray();
	let data = [], row = null, dni = '', valor = '', ganador = '', id = '', idpost = '';
	
	$('#tablaEval tbody tr').each(function(i, e){
		dni = $(e).children(':first').html();
		$('#tablaEval tbody input').each(function(ind, el){
			row = tablaEval.row($(el).parents('tr')).data();
			if(dni === row.numero_documento){
				id = row.idpostulacion, idpost = row.idconvocatoria;
				if(el.type === 'text'){
					valor = el.value;
				}else if(el.type === 'checkbox' && $(el).prop('checked')){
					ganador = 1;
				}if(el.type === 'checkbox' && !$(el).prop('checked')){
					ganador = 0;
				}
			}
		});
		data.push({
			'idconvocatoria' : idpost,
			'idpostulacion' : id,
			'puntaje' : valor,
			'ganador' : ganador
		});
	});
	$(location).attr('href',base_url+segmento+'/evaluado?json='+JSON.stringify(data));
	//console.log(JSON.stringify(data));
});*/