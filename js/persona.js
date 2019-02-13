$(document).ready(function() {
	var urlDominio = 'https://www.cerouno.me/ganaderia_auditoria/public/api/v1/1300';
	
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
			{ targets			: [6], visible : true,  searchable : true,  orderData : [6, 0] }
		],
		columns		: [
			{ data				: 'persona_codigo', name : 'persona_codigo'},
			{ data				: 'estado_persona_nombre', name : 'estado_persona_nombre'},
			{ data				: 'tipo_persona_nombre', name : 'tipo_persona_nombre'},
			{ data				: 'tipo_documento_nombre', name : 'tipo_documento_nombre'},
			{ data				: 'persona_documento', name : 'persona_documento'},
			{ data				: 'persona_completo', name : 'persona_completo'},
			{ render			: function (data, type, full, meta) {return '<a href="../public/persona_m.php?mode=R&codigo=' + full.persona_codigo + '" role="button" class="btn btn-primary"><i class="ti-eye"></i>&nbsp;</a>&nbsp;<a href="../public/persona_m.php?mode=U&codigo=' + full.persona_codigo + '" role="button" class="btn btn-success"><i class="ti-pencil"></i>&nbsp;</a></a>&nbsp;<a href="../public/persona_m.php?mode=D&codigo=' + full.persona_codigo + '" role="button" class="btn btn-danger"><i class="ti-trash"></i>&nbsp;</a>';}}
		]
	});
});