$(document).ready(function() {
	var nomDominio = document.getElementById('tableDominio').className;
	var urlDominio = 'https://www.cerouno.me/ganaderia_auditoria/public/api/v1/500/dominio/' + nomDominio;
	var codDominio = 0;
	
	switch(nomDominio) {
		case 'DOMINIOSISTEMA':
			codDominio	= 3;
			break;
		case 'DOMINIOESTADO':
			codDominio	= 4;
			break;
		case 'ESTABLECIMIENTOESTADO':
			codDominio	= 5;
			break;
		case 'ANIMALESTADO':
			codDominio	= 6;
			break;
		case 'ANIMALESPECIE':
			codDominio	= 7;
			break;
		case 'ANIMALRAZA':
			codDominio	= 8;
			break;
		case 'ANIMALCATEGORIA':
			codDominio	= 9;
			break;
		case 'ANIMALSUBCATEGORIA':
			codDominio	= 10;
			break;
		case 'ANIMALORIGEN':
			codDominio	= 11;
			break;
		case 'ANIMALRECUENTO':
			codDominio	= 12;
			break;
		case 'PERSONATIPO':
			codDominio	= 13;
			break;
		case 'PERSONADOCUMENTO':
			codDominio	= 14;
			break;
		case 'USUARIOESTADO':
			codDominio	= 15;
			break;
		case 'USUARIOROL':
			codDominio	= 16;
			break;
		case 'USUARIOACCESO':
			codDominio	= 17;
			break;
		case 'ORDENTRABAJOESTADO':
			codDominio	= 18;
			break;
		case 'ORDENTRABAJOTIPO':
			codDominio	= 19;
			break;
		case 'USUARIOPROGRAMA':
			codDominio	= 68;
			break;
		case 'ESTABLECIMIENTOCARGO':
			codDominio	= 87;
			break;
	}
	
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
			{ data				: 'dominio_codigo', name : 'dominio_codigo'},
			{ data				: 'estado_dominio_nombre', name : 'estado_dominio_nombre'},
			{ data				: 'dominio_nombre', name : 'dominio_nombre'},
			{ data				: 'dominio_busqueda', name : 'dominio_busqueda'},
			{ data				: 'dominio_valor', name : 'dominio_valor'},
			{ render			: function (data, type, full, meta) {return '<a href="../public/dominio_m.php?dominio='+ codDominio +'&mode=R&codigo=' + full.dominio_codigo + '" role="button" class="btn btn-primary"><i class="ti-eye"></i>&nbsp;</a>&nbsp;<a href="../public/dominio_m.php?dominio='+ codDominio +'&mode=U&codigo=' + full.dominio_codigo + '" role="button" class="btn btn-success"><i class="ti-pencil"></i>&nbsp;</a></a>&nbsp;<a href="../public/dominio_m.php?dominio='+ codDominio +'&mode=D&codigo=' + full.dominio_codigo + '" role="button" class="btn btn-danger"><i class="ti-trash"></i>&nbsp;</a>';}},
		]
	});
});