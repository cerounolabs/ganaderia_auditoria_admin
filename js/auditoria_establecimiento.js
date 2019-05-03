$(document).ready(function() {
	var urlDominio = 'https://www.cerouno.me/ganaderia_auditoria/public/api/v1/1800/establecimiento';
	
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
			{ targets			: [0],  visible : false, searchable : false, orderData : [0, 0] },
			{ targets			: [1],  visible : true,  searchable : true,  orderData : [1, 0] },
			{ targets			: [2],  visible : true,  searchable : true,  orderData : [2, 0] },
			{ targets			: [3],  visible : true,  searchable : true,  orderData : [3, 0] },
			{ targets			: [4],  visible : true,  searchable : true,  orderData : [4, 0] },
			{ targets			: [5],  visible : true,  searchable : true,  orderData : [5, 0] },
			{ targets			: [6],  visible : true,  searchable : true,  orderData : [6, 0] },
			{ targets			: [7],  visible : true,  searchable : true,  orderData : [7, 0] },
			{ targets			: [8],  visible : true,  searchable : true,  orderData : [8, 0] },
			{ targets			: [9],  visible : true,  searchable : true,  orderData : [9, 0] },
			{ targets			: [10], visible : true,  searchable : true,  orderData : [10, 0] },
			{ targets			: [11], visible : true,  searchable : true,  orderData : [11, 0] },
			{ targets			: [12], visible : true,  searchable : true,  orderData : [12, 0] },
			{ targets			: [13], visible : true,  searchable : true,  orderData : [13, 0] },
			{ targets			: [14], visible : true,  searchable : true,  orderData : [14, 0] },
			{ targets			: [15], visible : true,  searchable : true,  orderData : [15, 0] },
			{ targets			: [16], visible : true,  searchable : true,  orderData : [16, 0] }
		],
		columns		: [
			{ data				: 'auditoria_codigo', name : 'auditoria_codigo'},
			{ data				: 'auditoria_metodo', name : 'auditoria_metodo'},
			{ data				: 'auditoria_usuario', name : 'auditoria_usuario'},
			{ data				: 'auditoria_fecha_hora', name : 'auditoria_fecha_hora'},
			{ data				: 'auditoria_ip', name : 'auditoria_ip'},
			{ data				: 'establecimiento_codigo_antes', name : 'establecimiento_codigo_antes'},
			{ data				: 'establecimiento_estado_antes', name : 'establecimiento_estado_antes'},
			{ data				: 'establecimiento_distrito_antes', name : 'establecimiento_distrito_antes'},
			{ data				: 'establecimiento_nombre_antes', name : 'establecimiento_nombre_antes'},
			{ data				: 'establecimiento_sigor_antes', name : 'establecimiento_sigor_antes'},
			{ data				: 'establecimiento_observacion_antes', name : 'establecimiento_observacion_antes'},
			{ data				: 'establecimiento_codigo_despues', name : 'establecimiento_codigo_despues'},
			{ data				: 'establecimiento_estado_despues', name : 'establecimiento_estado_despues'},
			{ data				: 'establecimiento_distrito_despues', name : 'establecimiento_distrito_despues'},
			{ data				: 'establecimiento_nombre_despues', name : 'establecimiento_nombre_despues'},
			{ data				: 'establecimiento_sigor_despues', name : 'establecimiento_sigor_despues'},
			{ data				: 'establecimiento_observacion_despues', name : 'establecimiento_observacion_despues'}
		]
	});
});