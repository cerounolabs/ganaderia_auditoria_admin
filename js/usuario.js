$(document).ready(function() {
	var urlDominio = 'https://www.cerouno.me/ganaderia_auditoria/public/api/v1/1600';
	
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
			{ targets			: [5], visible : true,  searchable : true,  orderData : [5, 0] }
		],
		columns		: [
			{ data				: 'usuario_codigo', name : 'usuario_codigo'},
			{ data				: 'estado_usuario_nombre', name : 'estado_usuario_nombre'},
			{ data				: 'rol_nombre', name : 'rol_nombre'},
			{ data				: 'usuario_nombre', name : 'usuario_nombre'},
			{ data				: 'persona_completo', name : 'persona_completo'},
			{ render			: function (data, type, full, meta) {return '<a href="../public/usuario_m.php?mode=R&codigo=' + full.usuario_codigo + '" role="button" class="btn btn-primary"><i class="ti-eye"></i>&nbsp;</a>&nbsp;<a href="../public/usuario_m.php?mode=U&codigo=' + full.usuario_codigo + '" role="button" class="btn btn-success"><i class="ti-pencil"></i>&nbsp;</a></a>&nbsp;<a href="../public/usuario_m.php?mode=D&codigo=' + full.usuario_codigo + '" role="button" class="btn btn-danger"><i class="ti-trash"></i>&nbsp;</a>';}}
		]
	});
});