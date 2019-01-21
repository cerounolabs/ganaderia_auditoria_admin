$(document).ready(function() {
	var nomDominio = document.getElementById('tableDominio').className;
	var urlDominio = 'https://www.cerouno.me/ganaderia_auditoria/public/api/v1/600/dominio/' + nomDominio;
	
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
		],
		columns		: [
			{ data				: 'tipo_subtipo_codigo', name : 'tipo_subtipo_codigo'},
			{ data				: 'estado_tipo_subtipo_nombre', name : 'estado_tipo_subtipo_nombre'},
			{ data				: 'tipo_nombre', name : 'tipo_nombre'},
			{ data				: 'subtipo_nombre', name : 'subtipo_nombre'},
			{ render			: function (data, type, full, meta) {return '<a href="../public/dominio_sub_m.php?dominio='+ nomDominio +'&mode=R&codigo=' + full.tipo_subtipo_codigo + '" role="button" class="btn btn-primary"><i class="ti-eye"></i>&nbsp;</a>&nbsp;<a href="../public/dominio_sub_m.php?dominio='+ nomDominio +'&mode=U&codigo=' + full.tipo_subtipo_codigo + '" role="button" class="btn btn-success"><i class="ti-pencil"></i>&nbsp;</a></a>&nbsp;<a href="../public/dominio_sub_m.php?dominio='+ nomDominio +'&mode=D&codigo=' + full.tipo_subtipo_codigo + '" role="button" class="btn btn-danger"><i class="ti-trash"></i>&nbsp;</a>';}},
		]
	});
});