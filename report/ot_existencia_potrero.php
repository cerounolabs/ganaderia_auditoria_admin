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

            $dominioJSON    = get_curl('500');
            $potreroJSON	= get_curl('900/establecimiento/'.$row_ot_03);
            $otAudJSON      = get_curl('1200/ot/detalle/'.$workCodigo);
		}

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'Legal', 'orientation' => 'P']);

        $mpdf -> SetTitle('Sistema Auditor Ganadero');
        $mpdf -> SetHeader('<div style="font-size:14px; text-align:left; font-weight:bold;">ESTABLECIMIENTO '.strtoupper($row_ot_04).'</span></div>');
        $mpdf -> SetFooter('<table width="100%" style="font-size:10px;"><tr><td text-align:left; colspan="2">TIC&#39;S & GANADERIA S.A.</td><td style="text-align:right;"></td></tr><tr><td width="33%">{DATE j/m/Y H:i:s}</td><td width="33%" align="center">{PAGENO}/{nbpg}</td><td width="33%" style="text-align:right;">IMPRESO POR: '.strtoupper($sysUsu).'</td></tr></table>');

        $mpdf -> WriteHTML('<body>');
        $mpdf -> WriteHTML('<br>');
        $mpdf -> WriteHTML('<h2 style="margin:0px;">EXISTENCIA POR POTRERO</h2>');
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
        $mpdf -> WriteHTML('<table width="100%" style="font-size:12px;">');
        
        if ($potreroJSON['code'] == 200) {
            foreach ($potreroJSON['data'] as $potreroKey=>$potreroArray) {
                $row_potrero_00 = $potreroArray['potrero_codigo'];
                $row_potrero_01 = $potreroArray['potrero_nombre'];
                $impTitulo      = true;
                $impCorte       = false;

                if ($dominioJSON['code'] == 200) {
                    foreach ($dominioJSON['data'] as $categoriasubKey=>$categoriaArray) {
                        $row_categoria_00 = $categoriaArray['dominio_codigo'];
                        $row_categoria_01 = $categoriaArray['dominio_nombre'];
                        $row_categoria_02 = $categoriaArray['dominio_valor'];

                        if ($row_categoria_02 == 'ANIMALCATEGORIA'){
                            if ($dominioJSON['code'] == 200) {
                                foreach ($dominioJSON['data'] as $subcategoriasubKey=>$subcategoriaArray) {
                                    $row_subcategoria_00 = $subcategoriaArray['dominio_codigo'];
                                    $row_subcategoria_01 = $subcategoriaArray['dominio_nombre'];
                                    $row_subcategoria_02 = $subcategoriaArray['dominio_valor'];

                                    if ($row_subcategoria_02 == 'ANIMALSUBCATEGORIA'){
                                        if ($otAudJSON['code'] == 200) {
                                            $impDetalle     = false;

                                            foreach ($otAudJSON['data'] as $ot_auditadaKey=>$ot_auditadaArray) {
                                                $row_auditada_00  = $ot_auditadaArray['potrero_codigo'];
                                                $row_auditada_01  = $ot_auditadaArray['potrero_nombre'];
                                                $row_auditada_02  = $ot_auditadaArray['categoria_codigo'];
                                                $row_auditada_03  = $ot_auditadaArray['categoria_nombre'];
                                                $row_auditada_04  = $ot_auditadaArray['subcategoria_codigo'];
                                                $row_auditada_05  = $ot_auditadaArray['subcategoria_nombre'];
                                                $row_auditada_06  = $ot_auditadaArray['ot_codigo'];
                                                $row_auditada_07  = $ot_auditadaArray['ot_auditada_cantidad'];

                                                if ($row_auditada_00 == $row_potrero_00 && $row_auditada_06 == $row_ot_07 && $row_auditada_02 == $row_categoria_00 && $row_auditada_04 == $row_subcategoria_00){
                                                    $detCategoria   = $row_auditada_03;
                                                    $detSubCategoria= $row_auditada_05;
                                                    $detCantidad    = $detCantidad + $row_auditada_07;
                                                    $cantPotero     = $cantPotero + $row_auditada_07;
                                                    $cantPoblacion  = $cantPoblacion + $row_auditada_07;
                                                    $impDetalle     = true;

                                                    if ($row_auditada_02 == 40) {
                                                        $cantTernero = $cantTernero + $row_auditada_07;
                                                    } else {
                                                        $cantAdulto = $cantAdulto + $row_auditada_07;
                                                    }
                                                }
                                            }

                                            if ($impDetalle == true){
                                                if ($impTitulo == true){
                                                    $mpdf -> WriteHTML('<tr><td style="text-align:left; font-weight:bold;" colspan="3">POTRERO '.$row_potrero_01.'</td></tr>');
                                                    $mpdf -> WriteHTML('<tr><td width="33%" style="text-align:left; font-weight:bold;">CATEGORÍA</td> <td width="33%" style="text-align:left; font-weight:bold;"> SUBCATEGORÍA </td><td width="33%" style="text-align:right; font-weight:bold;"> CANTIDAD </td></tr>');
                                                    $impTitulo = false;
                                                }

                                                $detCantidad    = number_format($detCantidad, 0, ',', '.');

                                                $mpdf -> WriteHTML('<tr>');
                                                $mpdf -> WriteHTML('<td width="33%" style="text-align:left;">'.$detCategoria.'</td>');
                                                $mpdf -> WriteHTML('<td width="33%" style="text-align:left;">'.$detSubCategoria.'</td>');
                                                $mpdf -> WriteHTML('<td width="33%" style="text-align:right;">'.$detCantidad.'</td>');
                                                $mpdf -> WriteHTML('</tr>');
                                                $detCantidad = 0;
                                                $impCorte = true;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                if ($impCorte == true){
                    $cantPotero     = number_format($cantPotero, 0, ',', '.');
                    $mpdf -> WriteHTML('<tr> <td style="text-align:left; font-weight:bold;" colspan="2"> SUB-TOTAL POTRERO '.$row_potrero_01.'</td><td style="text-align:right; font-weight:bold;">'.$cantPotero.'</td></tr>');
                    $mpdf -> WriteHTML('<tr> <td style="text-align:left; font-weight:bold;" colspan="3"> &nbsp; </td></tr>');
                    $cantPotero     = 0;
                }
            }
        }

        $cantAdulto     = number_format($cantAdulto, 0, ',', '.');
        $cantTernero    = number_format($cantTernero, 0, ',', '.');
        $cantPoblacion  = number_format($cantPoblacion, 0, ',', '.');

        $mpdf -> WriteHTML('<tr> <td style="text-align:left; font-weight:bold;" colspan="3"> &nbsp; </td></tr>');
        $mpdf -> WriteHTML('<tr> <td style="text-align:left; font-weight:bold;" colspan="2"> TOTAL ADULTO </td><td style="text-align:right; font-weight:bold;">'.$cantAdulto.'</td></tr>');
        $mpdf -> WriteHTML('<tr> <td style="text-align:left; font-weight:bold;" colspan="2"> TOTAL TENERO </td><td style="text-align:right; font-weight:bold;">'.$cantTernero.'</td></tr>');
        $mpdf -> WriteHTML('<tr> <td style="text-align:left; font-weight:bold;" colspan="2"> TOTAL POBLACIÓN BOVINA </td><td style="text-align:right; font-weight:bold;">'.$cantPoblacion.'</td></tr>');
        $mpdf -> WriteHTML('</table>');
        $mpdf -> WriteHTML('</body>');

        $mpdf -> Output('otExistenciaPorPotrero.pdf', 'I');
        exit;
    }
?>