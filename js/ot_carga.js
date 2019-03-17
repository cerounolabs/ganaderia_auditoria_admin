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
			window.location.href = "http://auditoria.cerouno.com.py/public/ot_carga_l.php?mode=R&codigo=" + codPage + "&code=" + dataCode + "&msg=" + dataMessage;
		}
	
		xhr.send(null);
  	}
}

function colFecha(classValue) {
	var elem    = document.getElementsByClassName(classValue);
	var aElem   = elem[0].innerText;
	var nElem   = 1;
	var iElem   = 0;

	for (i = 1; i < elem.length; i++) {
		if (elem[i].innerText == aElem) {
			nElem                   = nElem + 1;
			elem[i].style.display   = 'none';
		} else {
			elem[iElem].rowSpan     = nElem;
			iElem                   = i;
			aElem                   = elem[iElem].innerText;
			nElem                   = 1;
		}

		if (i == (elem.length - 1)) {
			elem[iElem].rowSpan     = nElem;
		}
	}
}

function colFechaPotrero(valFecha, valPotrero, valCantidad, valTotal) {
	var elem1   = document.getElementsByClassName(valFecha);
	var elem2   = document.getElementsByClassName(valPotrero);
	var elem3   = document.getElementsByClassName(valCantidad);
	var elem4	= document.getElementsByClassName(valTotal);

	var aElem1	= elem1[0].innerText;
	var aElem2  = elem2[0].innerText;
	var aElem3  = 0;

	var nElem   = 1;
	var iElem   = 0;
	var tElem   = Number(elem3[0].innerText);

	for (i = 1; i < elem1.length; i++) {
		if ((elem1[i].innerText == aElem1) && (elem2[i].innerText == aElem2)) {
			nElem					= nElem + 1;
			tElem					= tElem + Number(elem3[i].innerText);
			elem2[i].style.display  = 'none';
			elem4[i].style.display  = 'none';
		} else {
			elem2[iElem].rowSpan	= nElem;
			elem4[iElem].rowSpan	= nElem;
			elem4[iElem].innerHTML	= tElem;
			iElem                   = i;
			aElem1                  = elem1[iElem].innerText;
			aElem2                  = elem2[iElem].innerText;
			nElem                   = 1;
			tElem					= Number(elem3[i].innerText);
		}

		if (i == (elem1.length - 1)) {
			elem2[iElem].rowSpan    = nElem;
			elem4[iElem].rowSpan	= nElem;
			elem4[iElem].innerHTML	= tElem;
		}
	}
}