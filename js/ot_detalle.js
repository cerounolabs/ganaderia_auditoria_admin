$(function() {
	'use strict';

	$('#tableLoadExistencia').DataTable({
		dom: 'Bfrtip',
		buttons: [
			{ text: '<i class="far fa-file-excel"></i> Exporte EXCELL',	extend:'excel',	className: 'btn btn-success mr-1', title: 'PLANILLA EXISTENCIA' },
			{ text: '<i class="far fa-file-pdf"></i> Exporte PDF', 		extend:'pdf', 	className: 'btn btn-success mr-1', title: 'PLANILLA EXISTENCIA' }
		]
	});

	$('#tableLoadAuditada').DataTable({
		dom: 'Bfrtip',
		buttons: [
			{ text: '<i class="far fa-file-excel"></i> Exporte EXCELL',	extend:'excel',	className: 'btn btn-danger mr-1', title: 'PLANILLA AUDITADA' },
			{ text: '<i class="far fa-file-pdf"></i> Exporte PDF', 		extend:'pdf', 	className: 'btn btn-danger mr-1', title: 'PLANILLA AUDITADA' }
		]
	});
});