$(document).ready(function() {
	var urlDominio = 'https://www.cerouno.me/ganaderia_auditoria/public/api/v1/700';
	
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
			{ targets			: [4], visible : false, searchable : false, orderData : [4, 0] },
			{ targets			: [5], visible : true,  searchable : true,  orderData : [5, 0] },
			{ targets			: [6], visible : true,  searchable : true,  orderData : [6, 0] },
			{ targets			: [7], visible : true,  searchable : true,  orderData : [7, 0] },
			{ targets			: [8], visible : true,  searchable : true,  orderData : [8, 0] },
			{ targets			: [9], visible : true,  searchable : true,  orderData : [9, 0] },
			{ targets			: [10], visible : true,  searchable : true,  orderData : [10, 0] }
		],
		columns		: [
			{ data				: 'establecimiento_codigo', name : 'establecimiento_codigo'},
			{ data				: 'estado_establecimiento_nombre', name : 'estado_establecimiento_nombre'},
			{ data				: 'establecimiento_nombre', name : 'establecimiento_nombre'},
			{ data				: 'pais_nombre', name : 'pais_nombre'},
			{ data				: 'departamento_nombre', name : 'departamento_nombre'},
			{ data				: 'distrito_nombre', name : 'distrito_nombre'},
			{ render			: function (data, type, full, meta) {return '<a href="../public/establecimiento_seccion_l.php?id1=' + full.establecimiento_codigo + '" role="button" class="btn btn-dark" title="Sección"><i class="ti-direction"></i>&nbsp;</a>&nbsp;';}},
			{ render			: function (data, type, full, meta) {return '<a href="../public/establecimiento_potrero_l.php?id1=' + full.establecimiento_codigo + '" role="button" class="btn btn-warning" title="Potrero"><i class="ti-direction-alt"></i>&nbsp;</a>&nbsp;';}},
			{ render			: function (data, type, full, meta) {return '<a href="../public/establecimiento_ot_l.php?id1=' + full.establecimiento_codigo + '" role="button" class="btn btn-info" title="Orden Trabajo"><i class="ti-clipboard"></i>&nbsp;</a>&nbsp;';}},
			{ render			: function (data, type, full, meta) {return '<a href="../public/establecimiento_propietario_l.php?id1=' + full.establecimiento_codigo + '" role="button" class="btn btn-secondary" title="Propietario"><i class="ti-user"></i>&nbsp;</a>&nbsp;';}},
			{ render			: function (data, type, full, meta) {return '<a href="../public/establecimiento_m.php?mode=R&codigo=' + full.establecimiento_codigo + '" role="button" class="btn btn-primary" title="Ver"><i class="ti-eye"></i>&nbsp;</a>&nbsp;<a href="../public/establecimiento_m.php?mode=U&codigo=' + full.establecimiento_codigo + '" role="button" class="btn btn-success" title="Editar"><i class="ti-pencil"></i>&nbsp;</a></a>&nbsp;<a href="../public/establecimiento_m.php?mode=D&codigo=' + full.establecimiento_codigo + '" role="button" class="btn btn-danger" title="Eliminar"><i class="ti-trash"></i>&nbsp;</a>';}},
		]
	});
});