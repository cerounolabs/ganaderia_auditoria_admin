$(document).ready(function() {
	var codigo		= document.getElementById('tableCodigo').className;
	var urlDominio = 'https://www.cerouno.me/ganaderia_auditoria/public/api/v1/1500/rol/'+ codigo;
	
	$('#tableLoad').DataTable({
		processing	: true,
		destroy		: true,
		ajax		: {
			type				: 'GET',
			cache				: false,
			crossDomain			: true,
			crossOrigin			: true,
			contentType			: 'application/json; charset=utf-8',
			dataType			: 'json',
			url				: urlDominio,
			dataSrc				: 'data'
		},
		columnDefs	: [
			{ targets			: [0], visible : false, searchable : false, orderData : [0, 0] },
			{ targets			: [1], visible : true,  searchable : true,  orderData : [1, 0] },
			{ targets			: [2], visible : true,  searchable : true,  orderData : [2, 0] },
			{ targets			: [3], visible : true,  searchable : true,  orderData : [3, 0] },
			{ targets			: [4], visible : true,  searchable : true,  orderData : [4, 0] },
			{ targets			: [5], visible : true,  searchable : true,  orderData : [5, 0] },
			{ targets			: [6], visible : true,  searchable : true,  orderData : [6, 0] },
			{ targets			: [7], visible : true,  searchable : true,  orderData : [7, 0] },
			{ targets			: [8], visible : true,  searchable : true,  orderData : [8, 0] },
			{ targets			: [9], visible : true,  searchable : true,  orderData : [9, 0] }
		],
		columns		: [
			{ data				: 'acceso_codigo', name : 'acceso_codigo'},
			{ data				: 'estado_acceso_nombre', name : 'estado_acceso_nombre'},
			{ data				: 'programa_nombre', name : 'programa_nombre'},
			{ data				: 'acceso_ingresar', name : 'acceso_ingresar'},
			{ data				: 'acceso_visualizar', name : 'acceso_visualizar'},
			{ data				: 'acceso_insertar', name : 'acceso_insertar'},
			{ data				: 'acceso_modificar', name : 'acceso_modificar'},
			{ data				: 'acceso_eliminar', name : 'acceso_eliminar'},
			{ render			: function (data, type, full, meta) {return '<a href="../public/usuario_rol_acceso_m.php?mode=R&codigo=' + full.acceso_codigo + '" role="button" class="btn btn-primary"><i class="ti-eye"></i>&nbsp;</a>&nbsp;<a href="../public/usuario_rol_acceso_m.php?mode=U&codigo=' + full.acceso_codigo + '" role="button" class="btn btn-success"><i class="ti-pencil"></i>&nbsp;</a></a>&nbsp;<a href="../public/usuario_rol_acceso_m.php?mode=D&codigo=' + full.acceso_codigo + '" role="button" class="btn btn-danger"><i class="ti-trash"></i>&nbsp;</a>';}}
		]
	});
});