<?php
    require '../class/function/curl_api.php';
    require '../class/function/function.php';
    require '../class/session/session_system.php';
    require '../vendor/autoload.php';

    $workCodigo     = $_GET['id1'];

    if ($workCodigo <> 0){
        $otJSON     = get_curl('1000/'.$workCodigo);

        if ($otJSON['code'] == 200){
			$row_ot_01      = $otJSON['data'][0]['estado_ot_codigo'];
			$row_ot_02      = $otJSON['data'][0]['estado_ot_nombre'];
			$row_ot_03      = $otJSON['data'][0]['establecimiento_codigo'];
			$row_ot_04      = $otJSON['data'][0]['establecimiento_nombre'];
			$row_ot_05      = $otJSON['data'][0]['establecimiento_sigor'];
			$row_ot_06      = $otJSON['data'][0]['establecimiento_observacion'];
			$row_ot_07      = $otJSON['data'][0]['ot_codigo'];
			$row_ot_08      = $otJSON['data'][0]['ot_numero'];
			$row_ot_09      = $otJSON['data'][0]['ot_fecha_inicio_trabajo'];
			$row_ot_10      = $otJSON['data'][0]['ot_fecha_inicio_trabajo_2'];
			$row_ot_11      = $otJSON['data'][0]['ot_fecha_final_trabajo'];
            $row_ot_12      = $otJSON['data'][0]['ot_fecha_final_trabajo_2'];
            $row_ot_13      = $otJSON['data'][0]['ot_observacion'];

            $otAudJSON      = get_curl('1200/ot/partediario/'.$workCodigo);
		}

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'Legal', 'orientation' => 'L']);

        $mpdf -> SetTitle('Sistema Auditor Ganadero');
        $mpdf -> SetHeader('<div style="font-size:14px; text-align:left; font-weight:bold;">ESTABLECIMIENTO '.strtoupper($row_ot_04).'</span></div>');
        $mpdf -> SetFooter('<table width="100%" style="font-size:10px;"><tr><td text-align:left; colspan="2">TIC&#39;S & GANADERIA S.A.</td><td style="text-align:right;"></td></tr><tr><td width="33%">{DATE j/m/Y H:i:s}</td><td width="33%" align="center">{PAGENO}/{nbpg}</td><td width="33%" style="text-align:right;">IMPRESO POR: '.strtoupper($sysUsu).'</td></tr></table>');

        $mpdf -> WriteHTML('<body>');
        $mpdf -> WriteHTML('<br>');
        $mpdf -> WriteHTML('<h2 style="margin:0px;">PARTE DIARIO</h2>');
        $mpdf -> WriteHTML('<br>');
        $mpdf -> WriteHTML('<table width="100%" style="border: 1px solid #000;">');
        $mpdf -> WriteHTML('<tr>');
        $mpdf -> WriteHTML('<td width="25%" style="text-align:left; font-weight:bold;">ESTABLECIMIENTO</td>');
        $mpdf -> WriteHTML('<td width="25%" style="text-align:left;"> '.$row_ot_04.' </td>');
        $mpdf -> WriteHTML('<td width="25%" style="text-align:left; font-weight:bold;">ORDER DE TRABAJO</td>');
        $mpdf -> WriteHTML('<td width="25%" style="text-align:left;"> '.$row_ot_08 .' </td>');
        $mpdf -> WriteHTML('<tr>');
        $mpdf -> WriteHTML('<tr>');
        $mpdf -> WriteHTML('<td width="25%" style="text-align:left; font-weight:bold;">FECHA INICIO</td>');
        $mpdf -> WriteHTML('<td width="25%" style="text-align:left;"> '.$row_ot_10.' </td>');
        $mpdf -> WriteHTML('<td width="25%" style="text-align:left; font-weight:bold;">FECHA FIN</td>');
        $mpdf -> WriteHTML('<td width="25%" style="text-align:left;"> '.$row_ot_12 .' </td>');
        $mpdf -> WriteHTML('<tr>');
        $mpdf -> WriteHTML('</table>');
        $mpdf -> WriteHTML('<br>');
        $mpdf -> WriteHTML('<table width="100%" style="font-size:8px; border-collapse:collapse;">');
        $mpdf -> WriteHTML('<thead>');
        $mpdf -> WriteHTML('<tr>');
        $mpdf -> WriteHTML('<th style="border:1px solid #000;" rowspan="2">ITEM</th>');
        $mpdf -> WriteHTML('<th style="border:1px solid #000;" rowspan="2">FECHA</th>');
        $mpdf -> WriteHTML('<th style="border:1px solid #000;" rowspan="2">POTRERO</th>');
        $mpdf -> WriteHTML('<th style="border:1px solid #000;" rowspan="2">ORIGEN</th>');
        $mpdf -> WriteHTML('<th style="border:1px solid #000;" rowspan="2">RAZA</th>');

        $mpdf -> WriteHTML('<th style="border:1px solid #000;" colspan="2">DESMAMANTE</th>');
        $mpdf -> WriteHTML('<th style="border:1px solid #000;" colspan="4">VAQUILLA</th>');
        $mpdf -> WriteHTML('<th style="border:1px solid #000;" colspan="4">VACA</th>');
        $mpdf -> WriteHTML('<th style="border:1px solid #000;" colspan="6">NOVILLO</th>');
        $mpdf -> WriteHTML('<th style="border:1px solid #000;" colspan="1">BUEY</th>');
        $mpdf -> WriteHTML('<th style="border:1px solid #000;" colspan="6">TORO</th>');
        $mpdf -> WriteHTML('<th style="border:1px solid #000;" colspan="2">TERNERO</th>');

        $mpdf -> WriteHTML('<th style="width:50px; border:1px solid #000;" rowspan="2">TOTAL MARCADOS</th>');
        $mpdf -> WriteHTML('<th style="width:50px; border:1px solid #000;" rowspan="2">TOTAL TERNEROS</th>');
        $mpdf -> WriteHTML('<th style="width:50px; border:1px solid #000;" rowspan="2">TOTAL</th>');
        $mpdf -> WriteHTML('</tr>');
        $mpdf -> WriteHTML('<tr>');

        $mpdf -> WriteHTML('<th style="border:1px solid #000;">MACHO</th>');
        $mpdf -> WriteHTML('<th style="border:1px solid #000;">HEMBRA</th>');

        $mpdf -> WriteHTML('<th style="border:1px solid #000;">C/05</th>');
        $mpdf -> WriteHTML('<th style="border:1px solid #000;">C/06</th>');
        $mpdf -> WriteHTML('<th style="border:1px solid #000;">C/07</th>');
        $mpdf -> WriteHTML('<th style="border:1px solid #000;">C/08</th>');

        $mpdf -> WriteHTML('<th style="border:1px solid #000;">ADULT</th>');
        $mpdf -> WriteHTML('<th style="border:1px solid #000;">CUT</th>');
        $mpdf -> WriteHTML('<th style="border:1px solid #000;">VACIA</th>');
        $mpdf -> WriteHTML('<th style="border:1px solid #000;">REFUG</th>');

        $mpdf -> WriteHTML('<th style="border:1px solid #000;">ADULT</th>');
        $mpdf -> WriteHTML('<th style="border:1px solid #000;">SEÑUELO</th>');
        $mpdf -> WriteHTML('<th style="border:1px solid #000;">C/05</th>');
        $mpdf -> WriteHTML('<th style="border:1px solid #000;">C/06</th>');
        $mpdf -> WriteHTML('<th style="border:1px solid #000;">C/07</th>');
        $mpdf -> WriteHTML('<th style="border:1px solid #000;">C/08</th>');

        $mpdf -> WriteHTML('<th style="border:1px solid #000;">ADULT</th>');

        $mpdf -> WriteHTML('<th style="border:1px solid #000;">ADULT</th>');
        $mpdf -> WriteHTML('<th style="border:1px solid #000;">REFUG</th>');
        $mpdf -> WriteHTML('<th style="border:1px solid #000;">C/05</th>');
        $mpdf -> WriteHTML('<th style="border:1px solid #000;">C/06</th>');
        $mpdf -> WriteHTML('<th style="border:1px solid #000;">C/07</th>');
        $mpdf -> WriteHTML('<th style="border:1px solid #000;">C/08</th>');

        $mpdf -> WriteHTML('<th style="border:1px solid #000;">MACHO</th>');
        $mpdf -> WriteHTML('<th style="border:1px solid #000;">HEMBRA</th>');
        $mpdf -> WriteHTML('</tr>');
        $mpdf -> WriteHTML('</thead>');
        $mpdf -> WriteHTML('<tbody>');

        if ($otAudJSON['code'] == 200) {
            $auxBandera = true;
            
            foreach ($otAudJSON['data'] as $ot_auditadaKey=>$ot_auditadaArray) {
                $rowFecha           = $ot_auditadaArray['ot_auditada_fecha_2'];
                $rowPotreroCod      = $ot_auditadaArray['potrero_codigo'];
                $rowPotreroNom      = $ot_auditadaArray['potrero_nombre'];
                $rowOrigenCod       = $ot_auditadaArray['origen_codigo'];
                $rowOrigenNom       = $ot_auditadaArray['origen_nombre'];
                $rowRazaCod         = $ot_auditadaArray['raza_codigo'];
                $rowRazaNom         = $ot_auditadaArray['raza_nombre'];
                $rowCategoriaCod    = $ot_auditadaArray['categoria_codigo'];
                $rowSubCategoriaCod = $ot_auditadaArray['subcategoria_codigo'];
                $rowCantidad        = $ot_auditadaArray['ot_auditada_cantidad'];

                if ($auxBandera == true){
                    $nroItem    = 1;
                    $nroRepite  = 0;
                    $auxFecha   = $rowFecha;
                    $auxPotrero = $rowPotreroCod;
                    $auxOrigen  = $rowOrigenCod;
                    $auxRaza    = $rowRazaCod;
                    $auxBandera = false;
                }

                if (($rowFecha == $auxFecha) && ($rowPotreroCod == $auxPotrero) && ($rowOrigenCod == $auxOrigen) && ($rowRazaCod == $auxRaza)) {
                    $rowImpFecha    = $rowFecha;
                    $rowImpPotrero  = $rowPotreroNom;
                    $rowImpOrigen   = $rowOrigenNom;
                    $rowImpRaza     = $rowRazaNom;
                    $nroRepite      = $nroRepite + 1;

                    if (($rowCategoriaCod == 37) && ($rowSubCategoriaCod == 47)) {
                        $rowImpTotDesMac    = $rowImpTotDesMac + $rowCantidad;
                    }
                } else {
                    
                    $mpdf -> WriteHTML('<tr>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000;">'.$nroItem.'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000;">'.$rowImpFecha.'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000;">'.$rowImpPotrero.'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000;">'.$rowImpOrigen.'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000;">'.$rowImpRaza.'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000;">'.$rowImpTotDesMac.'</td>');

                    $mpdf -> WriteHTML('<td style="border:1px solid #000;">'.$nroRepite.'</td>');
                    $mpdf -> WriteHTML('</tr>');

                    $nroItem        = $nroItem + 1;
                    $nroRepite      = 1;
                    $auxFecha       = $rowFecha;
                    $auxPotrero     = $rowPotreroCod;
                    $auxOrigen      = $rowOrigenCod;
                    $auxRaza        = $rowRazaCod;

                    $rowImpFecha    = $rowFecha;
                    $rowImpPotrero  = $rowPotreroNom;
                    $rowImpOrigen   = $rowOrigenNom;
                    $rowImpRaza     = $rowRazaNom;

                    if (($rowCategoriaCod == 37) && ($rowSubCategoriaCod == 47)) {
                        $rowImpTotDesMac    = $rowCantidad;
                    }
                }
            }
        }

        $mpdf -> WriteHTML('</tbody>');
        $mpdf -> WriteHTML('</table>');
        $mpdf -> WriteHTML('</body>');

        $mpdf -> Output('otParteDiario.pdf', 'I');
        exit;
    }
?>