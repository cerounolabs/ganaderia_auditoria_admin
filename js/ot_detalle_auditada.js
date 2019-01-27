$(document).ready(function() {
	var codOT 		= document.getElementById('tableAuditada').className;
	var urlDominio 	= 'https://www.cerouno.me/ganaderia_auditoria/public/api/v1/1200/ot/resumen/' + codOT;
	
	$('#tableLoadAuditada').DataTable({
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
			{ targets			: [0], visible : true,  searchable : true,  orderData : [0, 0] },
			{ targets			: [1], visible : true,  searchable : true,  orderData : [1, 0] },
			{ targets			: [2], visible : true,  searchable : true,  orderData : [2, 0] },
			{ targets			: [3], visible : true,  searchable : true,  orderData : [3, 0] },
			{ targets			: [4], visible : true,  searchable : true,  orderData : [4, 0], className	: 'text-right' },
			{ targets			: [5], visible : true,  searchable : true,  orderData : [5, 0], className	: 'text-right' }
		],
		columns		: [
			{ data				: 'origen_nombre', name : 'origen_nombre'},
			{ data				: 'raza_nombre', name : 'raza_nombre'},
			{ data				: 'categoria_nombre', name : 'categoria_nombre'},
			{ data				: 'subcategoria_nombre', name : 'subcategoria_nombre'},
			{ data				: 'ot_auditada_peso', name : 'ot_auditada_peso'},
			{ data				: 'ot_auditada_cantidad', name : 'ot_auditada_cantidad'}
		]
	});
});