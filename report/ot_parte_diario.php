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
            $auxBandera         = true;

            //DESMAMANTE
            $rowImpTotDesMac    = 0;
            $rowImpTotDesHem    = 0;

            $colImpTotDesMac    = 0;
            $colImpTotDesHem    = 0;

            //VAQUILLA
            $rowImpTotVaqC05    = 0;
            $rowImpTotVaqC06    = 0;
            $rowImpTotVaqC07    = 0;
            $rowImpTotVaqC08    = 0;

            $colImpTotVaqC05    = 0;
            $colImpTotVaqC06    = 0;
            $colImpTotVaqC07    = 0;
            $colImpTotVaqC08    = 0;

            //VACA
            $rowImpTotVacAdu    = 0;
            $rowImpTotVacCut    = 0;
            $rowImpTotVacVac    = 0;
            $rowImpTotVacRef    = 0;

            $colImpTotVacAdu    = 0;
            $colImpTotVacCut    = 0;
            $colImpTotVacVac    = 0;
            $colImpTotVacRef    = 0;

            //NOVILLO
            $rowImpTotNovAdu    = 0;
            $rowImpTotNovSen    = 0;
            $rowImpTotNovC05    = 0;
            $rowImpTotNovC06    = 0;
            $rowImpTotNovC07    = 0;
            $rowImpTotNovC08    = 0;

            $colImpTotNovAdu    = 0;
            $colImpTotNovSen    = 0;
            $colImpTotNovC05    = 0;
            $colImpTotNovC06    = 0;
            $colImpTotNovC07    = 0;
            $colImpTotNovC08    = 0;

            //BUEY
            $rowImpTotBueAdu    = 0;

            $colImpTotBueAdu    = 0;

            //TORO
            $rowImpTotTorAdu    = 0;
            $rowImpTotTorRef    = 0;
            $rowImpTotTorC05    = 0;
            $rowImpTotTorC06    = 0;
            $rowImpTotTorC07    = 0;
            $rowImpTotTorC08    = 0;

            $colImpTotTorAdu    = 0;
            $colImpTotTorRef    = 0;
            $colImpTotTorC05    = 0;
            $colImpTotTorC06    = 0;
            $colImpTotTorC07    = 0;
            $colImpTotTorC08    = 0;

            //TERNERO
            $rowImpTotTerMac    = 0;
            $rowImpTotTerHem    = 0;

            $colImpTotTerMac    = 0;
            $colImpTotTerHem    = 0;

            //TOTAL
            $rowImpTotTolMar    = 0;
            $rowImpTotTolTer    = 0;
            $rowImpTotTolRow    = 0;

            $colImpTotTolMar    = 0;
            $colImpTotTolTer    = 0;
            $colImpTotTolRow    = 0;

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

                    //DESMAMANTE
                    if (($rowCategoriaCod == 37) && ($rowSubCategoriaCod == 47)) {
                        $rowImpTotDesMac    = $rowImpTotDesMac + $rowCantidad;
                        $colImpTotDesMac    = $colImpTotDesMac + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 37) && ($rowSubCategoriaCod == 46)) {
                        $rowImpTotDesHem    = $rowImpTotDesHem + $rowCantidad;
                        $colImpTotDesHem    = $colImpTotDesHem + $rowCantidad;
                    }

                    //VAQUILLA
                    if (($rowCategoriaCod == 43) && ($rowSubCategoriaCod == 79)) {
                        $rowImpTotVaqC05    = $rowImpTotVaqC05 + $rowCantidad;
                        $colImpTotVaqC05    = $colImpTotVaqC05 + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 43) && ($rowSubCategoriaCod == 80)) {
                        $rowImpTotVaqC06    = $rowImpTotVaqC06 + $rowCantidad;
                        $colImpTotVaqC06    = $colImpTotVaqC06 + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 43) && ($rowSubCategoriaCod == 81)) {
                        $rowImpTotVaqC07    = $rowImpTotVaqC07 + $rowCantidad;
                        $colImpTotVaqC07    = $colImpTotVaqC07 + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 43) && ($rowSubCategoriaCod == 82)) {
                        $rowImpTotVaqC08    = $rowImpTotVaqC08 + $rowCantidad;
                        $colImpTotVaqC08    = $colImpTotVaqC08 + $rowCantidad;
                    }

                    //VACA
                    if (($rowCategoriaCod == 42) && ($rowSubCategoriaCod == 83)) {
                        $rowImpTotVacAdu    = $rowImpTotVacAdu + $rowCantidad;
                        $colImpTotVacAdu    = $colImpTotVacAdu + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 42) && ($rowSubCategoriaCod == 44)) {
                        $rowImpTotVacCut    = $rowImpTotVacCut + $rowCantidad;
                        $colImpTotVacCut    = $colImpTotVacCut + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 42) && ($rowSubCategoriaCod == 84)) {
                        $rowImpTotVacVac    = $rowImpTotVacVac + $rowCantidad;
                        $colImpTotVacVac    = $colImpTotVacVac + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 42) && ($rowSubCategoriaCod == 49)) {
                        $rowImpTotVacRef    = $rowImpTotVacVac + $rowCantidad;
                        $colImpTotVacRef    = $colImpTotVacRef + $rowCantidad;
                    }

                    //NOVILLO
                    if (($rowCategoriaCod == 38) && ($rowSubCategoriaCod == 83)) {
                        $rowImpTotNovAdu    = $rowImpTotNovAdu + $rowCantidad;
                        $colImpTotNovAdu    = $colImpTotNovAdu + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 38) && ($rowSubCategoriaCod == 85)) {
                        $rowImpTotNovSen    = $rowImpTotNovSen + $rowCantidad;
                        $colImpTotNovSen    = $colImpTotNovSen + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 38) && ($rowSubCategoriaCod == 79)) {
                        $rowImpTotNovC05    = $rowImpTotNovC05 + $rowCantidad;
                        $colImpTotNovC05    = $colImpTotNovC05 + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 38) && ($rowSubCategoriaCod == 80)) {
                        $rowImpTotNovC06    = $rowImpTotNovC06 + $rowCantidad;
                        $colImpTotNovC06    = $colImpTotNovC06 + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 38) && ($rowSubCategoriaCod == 81)) {
                        $rowImpTotNovC07    = $rowImpTotNovC07 + $rowCantidad;
                        $colImpTotNovC07    = $colImpTotNovC07 + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 38) && ($rowSubCategoriaCod == 82)) {
                        $rowImpTotNovC08    = $rowImpTotNovC08 + $rowCantidad;
                        $colImpTotNovC08    = $colImpTotNovC08 + $rowCantidad;
                    }

                    //BUEY
                    if (($rowCategoriaCod == 36) && ($rowSubCategoriaCod == 83)) {
                        $rowImpTotBueAdu    = $rowImpTotBueAdu + $rowCantidad;
                        $colImpTotBueAdu    = $colImpTotBueAdu + $rowCantidad;
                    }

                    //TORO
                    if (($rowCategoriaCod == 41) && ($rowSubCategoriaCod == 83)) {
                        $rowImpTotTorAdu    = $rowImpTotTorAdu + $rowCantidad;
                        $colImpTotTorAdu    = $colImpTotTorAdu + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 41) && ($rowSubCategoriaCod == 49)) {
                        $rowImpTotTorRef    = $rowImpTotTorRef + $rowCantidad;
                        $colImpTotTorRef    = $colImpTotTorRef + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 41) && ($rowSubCategoriaCod == 79)) {
                        $rowImpTotTorC05    = $rowImpTotTorC05 + $rowCantidad;
                        $colImpTotTorC05    = $colImpTotTorC05 + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 41) && ($rowSubCategoriaCod == 80)) {
                        $rowImpTotTorC06    = $rowImpTotTorC06 + $rowCantidad;
                        $colImpTotTorC06    = $colImpTotTorC06 + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 41) && ($rowSubCategoriaCod == 81)) {
                        $rowImpTotTorC07    = $rowImpTotTorC07 + $rowCantidad;
                        $colImpTotTorC07    = $colImpTotTorC07 + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 41) && ($rowSubCategoriaCod == 82)) {
                        $rowImpTotTorC08    = $rowImpTotTorC08 + $rowCantidad;
                        $colImpTotTorC08    = $colImpTotTorC08 + $rowCantidad;
                    }

                    //TERNERO
                    if (($rowCategoriaCod == 40) && ($rowSubCategoriaCod == 47)) {
                        $rowImpTotTerMac    = $rowImpTotTerMac + $rowCantidad;
                        $colImpTotTerMac    = $colImpTotTerMac + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 40) && ($rowSubCategoriaCod == 46)) {
                        $rowImpTotTerHem    = $rowImpTotTerHem + $rowCantidad;
                        $colImpTotTerHem    = $colImpTotTerHem + $rowCantidad;
                    }

                    //TOTAL
                    if ($rowCategoriaCod == 40) {
                        $rowImpTotTolTer    = $rowImpTotTolTer + $rowCantidad;
                        $colImpTotTolTer    = $colImpTotTolTer + $rowCantidad;
                    } else {
                        $rowImpTotTolMar    = $rowImpTotTolMar + $rowCantidad;
                        $colImpTotTolMar    = $colImpTotTolMar + $rowCantidad;
                    }
                } else {
                    $rowImpTotTolRow  = $rowImpTotTolTer + $rowImpTotTolMar ;
                    
                    $mpdf -> WriteHTML('<tr>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000;">'.$nroItem.'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000;">'.$rowImpFecha.'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000;">'.$rowImpPotrero.'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000;">'.$rowImpOrigen.'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000;">'.$rowImpRaza.'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($rowImpTotDesMac, 0, ',', '.').'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($rowImpTotDesHem, 0, ',', '.').'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($rowImpTotVaqC05, 0, ',', '.').'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($rowImpTotVaqC06, 0, ',', '.').'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($rowImpTotVaqC07, 0, ',', '.').'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($rowImpTotVaqC08, 0, ',', '.').'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($rowImpTotVacAdu, 0, ',', '.').'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($rowImpTotVacCut, 0, ',', '.').'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($rowImpTotVacVac, 0, ',', '.').'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($rowImpTotVacRef, 0, ',', '.').'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($rowImpTotNovAdu, 0, ',', '.').'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($rowImpTotNovSen, 0, ',', '.').'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($rowImpTotNovC05, 0, ',', '.').'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($rowImpTotNovC06, 0, ',', '.').'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($rowImpTotNovC07, 0, ',', '.').'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($rowImpTotNovC08, 0, ',', '.').'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($rowImpTotBueAdu, 0, ',', '.').'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($rowImpTotTorAdu, 0, ',', '.').'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($rowImpTotTorRef, 0, ',', '.').'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($rowImpTotTorC05, 0, ',', '.').'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($rowImpTotTorC06, 0, ',', '.').'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($rowImpTotTorC07, 0, ',', '.').'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($rowImpTotTorC08, 0, ',', '.').'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($rowImpTotTerMac, 0, ',', '.').'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($rowImpTotTerHem, 0, ',', '.').'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($rowImpTotTolMar, 0, ',', '.').'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($rowImpTotTolTer, 0, ',', '.').'</td>');
                    $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($rowImpTotTolRow, 0, ',', '.').'</td>');
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

                    //DESMAMANTE
                    $rowImpTotDesMac    = 0;
                    $rowImpTotDesHem    = 0;

                    //VAQUILLA
                    $rowImpTotVaqC05    = 0;
                    $rowImpTotVaqC06    = 0;
                    $rowImpTotVaqC07    = 0;
                    $rowImpTotVaqC08    = 0;

                    //VACA
                    $rowImpTotVacAdu    = 0;
                    $rowImpTotVacCut    = 0;
                    $rowImpTotVacVac    = 0;
                    $rowImpTotVacRef    = 0;

                    //NOVILLO
                    $rowImpTotNovAdu    = 0;
                    $rowImpTotNovSen    = 0;
                    $rowImpTotNovC05    = 0;
                    $rowImpTotNovC06    = 0;
                    $rowImpTotNovC07    = 0;
                    $rowImpTotNovC08    = 0;

                    //BUEY
                    $rowImpTotBueAdu    = 0;

                    //TORO
                    $rowImpTotTorAdu    = 0;
                    $rowImpTotTorRef    = 0;
                    $rowImpTotTorC05    = 0;
                    $rowImpTotTorC06    = 0;
                    $rowImpTotTorC07    = 0;
                    $rowImpTotTorC08    = 0;

                    //TERNERO
                    $rowImpTotTerMac    = 0;
                    $rowImpTotTerHem    = 0;

                    //TOTAL
                    $rowImpTotTolMar    = 0;
                    $rowImpTotTolTer    = 0;
                    $rowImpTotTolRow    = 0;

                    if (($rowCategoriaCod == 37) && ($rowSubCategoriaCod == 47)) {
                        $rowImpTotDesMac    = $rowCantidad;
                        $colImpTotDesMac    = $colImpTotDesMac + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 37) && ($rowSubCategoriaCod == 46)) {
                        $rowImpTotDesHem    = $rowCantidad;
                        $colImpTotDesHem    = $colImpTotDesHem + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 43) && ($rowSubCategoriaCod == 79)) {
                        $rowImpTotVaqC05    = $rowCantidad;
                        $colImpTotVaqC05    = $colImpTotVaqC05 + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 43) && ($rowSubCategoriaCod == 80)) {
                        $rowImpTotVaqC06    = $rowCantidad;
                        $colImpTotVaqC06    = $colImpTotVaqC06 + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 43) && ($rowSubCategoriaCod == 81)) {
                        $rowImpTotVaqC07    = $rowCantidad;
                        $colImpTotVaqC07    = $colImpTotVaqC07 + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 43) && ($rowSubCategoriaCod == 82)) {
                        $rowImpTotVaqC08    = $rowCantidad;
                        $colImpTotVaqC08    = $colImpTotVaqC08 + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 42) && ($rowSubCategoriaCod == 83)) {
                        $rowImpTotVacAdu    = $rowCantidad;
                        $colImpTotVacAdu    = $colImpTotVacAdu + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 42) && ($rowSubCategoriaCod == 44)) {
                        $rowImpTotVacCut    = $rowCantidad;
                        $colImpTotVacCut    = $colImpTotVacCut + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 42) && ($rowSubCategoriaCod == 84)) {
                        $rowImpTotVacVac    = $rowCantidad;
                        $colImpTotVacVac    = $colImpTotVacVac + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 42) && ($rowSubCategoriaCod == 49)) {
                        $rowImpTotVacRef    = $rowCantidad;
                        $colImpTotVacRef    = $colImpTotVacRef + $rowCantidad;
                    }

                    //NOVILLO
                    if (($rowCategoriaCod == 38) && ($rowSubCategoriaCod == 83)) {
                        $rowImpTotNovAdu    = $rowCantidad;
                        $colImpTotNovAdu    = $colImpTotNovAdu + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 38) && ($rowSubCategoriaCod == 85)) {
                        $rowImpTotNovSen    = $rowCantidad;
                        $colImpTotNovSen    = $colImpTotNovSen + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 38) && ($rowSubCategoriaCod == 79)) {
                        $rowImpTotNovC05    = $rowCantidad;
                        $colImpTotNovC05    = $colImpTotNovC05 + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 38) && ($rowSubCategoriaCod == 80)) {
                        $rowImpTotNovC06    = $rowCantidad;
                        $colImpTotNovC06    = $colImpTotNovC06 + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 38) && ($rowSubCategoriaCod == 81)) {
                        $rowImpTotNovC07    = $rowCantidad;
                        $colImpTotNovC07    = $colImpTotNovC07 + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 38) && ($rowSubCategoriaCod == 82)) {
                        $rowImpTotNovC08    = $rowCantidad;
                        $colImpTotNovC08    = $colImpTotNovC08 + $rowCantidad;
                    }

                    //BUEY
                    if (($rowCategoriaCod == 36) && ($rowSubCategoriaCod == 83)) {
                        $rowImpTotBueAdu    = $rowCantidad;
                        $colImpTotBueAdu    = $colImpTotBueAdu + $rowCantidad;
                    }

                    //TORO
                    if (($rowCategoriaCod == 41) && ($rowSubCategoriaCod == 83)) {
                        $rowImpTotTorAdu    = $rowCantidad;
                        $colImpTotTorAdu    = $colImpTotTorAdu + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 41) && ($rowSubCategoriaCod == 49)) {
                        $rowImpTotTorRef    = $rowCantidad;
                        $colImpTotTorRef    = $colImpTotTorRef + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 41) && ($rowSubCategoriaCod == 79)) {
                        $rowImpTotTorC05    = $rowCantidad;
                        $colImpTotTorC05    = $colImpTotTorC05 + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 41) && ($rowSubCategoriaCod == 80)) {
                        $rowImpTotTorC06    = $rowCantidad;
                        $colImpTotTorC06    = $colImpTotTorC06 + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 41) && ($rowSubCategoriaCod == 81)) {
                        $rowImpTotTorC07    = $rowCantidad;
                        $colImpTotTorC07    = $colImpTotTorC07 + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 41) && ($rowSubCategoriaCod == 82)) {
                        $rowImpTotTorC08    = $rowCantidad;
                        $colImpTotTorC08    = $colImpTotTorC08 + $rowCantidad;
                    }

                    //TERNERO
                    if (($rowCategoriaCod == 40) && ($rowSubCategoriaCod == 47)) {
                        $rowImpTotTerMac    = $rowCantidad;
                        $colImpTotTerMac    = $colImpTotTerMac + $rowCantidad;
                    }

                    if (($rowCategoriaCod == 40) && ($rowSubCategoriaCod == 46)) {
                        $rowImpTotTerHem    = $rowCantidad;
                        $colImpTotTerHem    = $colImpTotTerHem + $rowCantidad;
                    }

                    //TOTAL
                    if ($rowCategoriaCod == 40) {
                        $rowImpTotTolTer    = $rowImpTotTolTer + $rowCantidad;
                    } else {
                        $rowImpTotTolMar    = $rowImpTotTolMar + $rowCantidad;
                    }
                }
            }

            $colImpTotTolMar = $colImpTotDesMac + $colImpTotDesHem + $colImpTotVaqC05 + $colImpTotVaqC06 + $colImpTotVaqC07 + $colImpTotVaqC08 + $colImpTotVacAdu + $colImpTotVacCut + $colImpTotVacVac + $colImpTotVacRef + $colImpTotNovAdu + $colImpTotNovSen + $colImpTotNovC05 + $colImpTotNovC06 + $colImpTotNovC07 + $colImpTotNovC08 + $colImpTotBueAdu + $colImpTotTorAdu + $colImpTotTorRef + $colImpTotTorC05 + $colImpTotTorC06 + $colImpTotTorC07 + $colImpTotTorC08;
            $colImpTotTolTer = $colImpTotTerHem + $colImpTotTerMac;
            $colImpTotTolRow = $colImpTotTolMar + $colImpTotTolTer;

            $mpdf -> WriteHTML('<tr>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:left; color:#fff;" colspan="33"> . </td>');
            $mpdf -> WriteHTML('</tr>');

            $mpdf -> WriteHTML('<tr>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:left; font-weight:bold;" rowspan="2" colspan="5">TOTAL</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;" colspan="2">'.number_format(($colImpTotDesMac + $colImpTotDesHem), 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;" colspan="4">'.number_format(($colImpTotVaqC05 + $colImpTotVaqC06 + $colImpTotVaqC07 + $colImpTotVaqC08), 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;" colspan="4">'.number_format(($colImpTotVacAdu + $colImpTotVacCut + $colImpTotVacVac + $colImpTotVacRef), 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;" colspan="6">'.number_format(($colImpTotNovAdu + $colImpTotNovSen + $colImpTotNovC05 + $colImpTotNovC06 + $colImpTotNovC07 + $colImpTotNovC08), 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;" colspan="1">'.number_format($colImpTotBueAdu, 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;" colspan="6">'.number_format(($colImpTotTorAdu + $colImpTotTorRef + $colImpTotTorC05 + $colImpTotTorC06 + $colImpTotTorC07 + $colImpTotTorC08), 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;" colspan="2">'.number_format(($colImpTotTerMac + $colImpTotTerHem), 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;" rowspan="2">'.number_format($colImpTotTolMar, 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;" rowspan="2">'.number_format($colImpTotTolTer, 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;" rowspan="2">'.number_format($colImpTotTolRow, 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('</tr>');

            $mpdf -> WriteHTML('<tr>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($colImpTotDesMac, 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($colImpTotDesHem, 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($colImpTotVaqC05, 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($colImpTotVaqC06, 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($colImpTotVaqC07, 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($colImpTotVaqC08, 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($colImpTotVacAdu, 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($colImpTotVacCut, 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($colImpTotVacVac, 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($colImpTotVacRef, 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($colImpTotNovAdu, 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($colImpTotNovSen, 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($colImpTotNovC05, 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($colImpTotNovC06, 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($colImpTotNovC07, 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($colImpTotNovC08, 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($colImpTotBueAdu, 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($colImpTotTorAdu, 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($colImpTotTorRef, 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($colImpTotTorC05, 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($colImpTotTorC06, 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($colImpTotTorC07, 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($colImpTotTorC08, 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($colImpTotTerMac, 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('<td style="border:1px solid #000; text-align:right;">'.number_format($colImpTotTerHem, 0, ',', '.').'</td>');
            $mpdf -> WriteHTML('</tr>');
        }

        $mpdf -> WriteHTML('</tbody>');
        $mpdf -> WriteHTML('</table>');
        $mpdf -> WriteHTML('</body>');

        $mpdf -> Output('otParteDiario.pdf', 'I');
        exit;
    }
?>