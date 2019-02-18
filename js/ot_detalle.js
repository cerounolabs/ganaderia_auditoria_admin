$(function() {
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

function deteleItem(codPage, urlDetalle, idDetalle) {
	xhr 			= new XMLHttpRequest();
	var url			= "https://www.cerouno.me/ganaderia_auditoria/public/api/v1/" + urlDetalle + "/" + idDetalle;
	var dataCode	= "";
	var dataMessage = "";
	var request 	= confirm("¿Desea eliminar el item?");
  
	if (request == true) {
		xhr.open("DELETE", url, true);
		xhr.setRequestHeader("Content-type", "application/json");
		xhr.onload = function () {
			var dataJSON = JSON.parse(xhr.responseText);
			if (xhr.readyState == 4 && xhr.status == "200") {
				dataCode 	= dataJSON.code;
				dataMessage = dataJSON.message;
			} else {
				dataCode 	= dataJSON.code;
				dataMessage = dataJSON.message;
			}
			window.location.href = "http://auditoria.cerouno.com.py/public/ot_detalle_l.php?mode=R&codigo=" + codPage + "&code=" + dataCode + "&msg=" + dataMessage;
		}
	
		xhr.send(null);
  	}
}