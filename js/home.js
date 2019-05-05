$(document).ready(function() {
	var codigo		= document.getElementById('tableCodigo').className;
	var urlDominio = 'https://www.cerouno.me/ganaderia_auditoria/public/api/v1/1700/usuario/' + codigo;
	
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
		],
		columns		: [
			{ data				: 'establecimiento_codigo', name : 'establecimiento_codigo'},
			{ data				: 'distrito_nombre', name : 'distrito_nombre'},
			{ data				: 'establecimiento_nombre', name : 'establecimiento_nombre'},
			{ data				: 'establecimiento_sigor', name : 'establecimiento_sigor'},
			{ data				: 'ot_cantidad', name : 'ot_cantidad'},
			{ render			: function (data, type, full, meta) {return '<a href="../public/establecimiento_ot_l.php?id1=' + full.establecimiento_codigo + '" role="button" class="btn btn-info" title="Orden Trabajo"><i class="ti-clipboard"></i>&nbsp;</a>&nbsp;';}},
		]
	});
});