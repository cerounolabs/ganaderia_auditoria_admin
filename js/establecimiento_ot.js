$(document).ready(function() {
	var codigo		= document.getElementById('tableCodigo').className;
	var urlDominio = 'https://www.cerouno.me/ganaderia_auditoria/public/api/v1/1000/establecimiento/'+ codigo;
	
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
			{ targets			: [7], visible : true,  searchable : true,  orderData : [7, 0] }
		],
		columns		: [
			{ data				: 'ot_codigo', name : 'ot_codigo'},
			{ data				: 'establecimiento_nombre', name : 'establecimiento_nombre'},
			{ data				: 'estado_ot_nombre', name : 'estado_ot_nombre'},
			{ data				: 'ot_fecha_inicio_trabajo_2', name : 'ot_fecha_inicio_trabajo_2'},
			{ data				: 'ot_numero', name : 'ot_numero'},
			{ render			: function (data, type, full, meta) {return '<a href="../public/ot_detalle_l.php?mode=R&codigo=' + full.ot_codigo + '" role="button" class="btn btn-primary"><i class="ti-bar-chart"></i>&nbsp;</a>&nbsp;';}},
			{ render			: function (data, type, full, meta) {return '<a href="../public/ot_reporte_l.php?mode=R&codigo=' + full.ot_codigo + '" role="button" class="btn btn-success"><i class="ti-image"></i>&nbsp;</a>&nbsp;';}},
			{ render			: function (data, type, full, meta) {return '<a href="../public/ot_carga_l.php?mode=R&codigo=' + full.ot_codigo + '" role="button" class="btn btn-warning"><i class="ti-layout"></i>&nbsp;</a>&nbsp;';}},
		]
	});
});