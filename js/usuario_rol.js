$(document).ready(function() {
	var urlDominio = 'https://www.cerouno.me/ganaderia_auditoria/public/api/v1/500/dominio/USUARIOROL';
	var codDominio = 16;
	
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
			{ targets			: [3], visible : false, searchable : false, orderData : [3, 0] },
			{ targets			: [4], visible : true,  searchable : true,  orderData : [4, 0] },
			{ targets			: [5], visible : true,  searchable : true,  orderData : [5, 0] }
		],
		columns		: [
			{ data				: 'dominio_codigo', name : 'dominio_codigo'},
			{ data				: 'estado_dominio_nombre', name : 'estado_dominio_nombre'},
			{ data				: 'dominio_nombre', name : 'dominio_nombre'},
			{ data				: 'dominio_valor', name : 'dominio_valor'},
			{ render			: function (data, type, full, meta) {return '<a href="../public/usuario_rol_programa_l.php?id1=' + full.dominio_codigo + '" role="button" class="btn btn-primary"><i class="ti-eye"></i>&nbsp;</a>&nbsp;';}},
			{ render			: function (data, type, full, meta) {return '<a href="../public/usuario_rol_m.php?mode=R&codigo=' + full.dominio_codigo + '" role="button" class="btn btn-primary"><i class="ti-eye"></i>&nbsp;</a>&nbsp;<a href="../public/usuario_rol_m.php?mode=U&codigo=' + full.dominio_codigo + '" role="button" class="btn btn-success"><i class="ti-pencil"></i>&nbsp;</a></a>&nbsp;<a href="../public/usuario_rol_m.php?mode=D&codigo=' + full.dominio_codigo + '" role="button" class="btn btn-danger"><i class="ti-trash"></i>&nbsp;</a>';}},
		]
	});
});