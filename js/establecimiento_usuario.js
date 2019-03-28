$(document).ready(function() {
	var codigo		= document.getElementById('tableCodigo').className;
	var urlDominio	= 'https://www.cerouno.me/ganaderia_auditoria/public/api/v1/1700/establecimiento/'+ codigo;
	
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
			{ targets			: [4], visible : true,  searchable : true,  orderData : [4, 0] }
		],
		columns		: [
			{ data				: 'establecimiento_usuario_codigo', name : 'establecimiento_usuario_codigo'},
			{ data				: 'estado_establecimiento_usuario_nombre', name : 'estado_establecimiento_usuario_nombre'},
			{ data				: 'establecimiento_nombre', name : 'establecimiento_nombre'},
			{ data				: 'usuario_nombre', name : 'usuario_nombre'},
			{ render			: function (data, type, full, meta) {return '<a href="../public/establecimiento_usuario_m.php?id1='+ codigo +'&mode=R&codigo=' + full.establecimiento_usuario_codigo + '" role="button" class="btn btn-primary"><i class="ti-eye"></i>&nbsp;</a>&nbsp;<a href="../public/establecimiento_usuario_m.php?id1='+ codigo +'&mode=U&codigo=' + full.establecimiento_usuario_codigo + '" role="button" class="btn btn-success"><i class="ti-pencil"></i>&nbsp;</a></a>&nbsp;<a href="../public/establecimiento_usuario_m.php?id1='+ codigo +'&mode=D&codigo=' + full.establecimiento_usuario_codigo + '" role="button" class="btn btn-danger"><i class="ti-trash"></i>&nbsp;</a>';}}
		]
	});
});