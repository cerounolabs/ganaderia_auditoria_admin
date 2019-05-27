<?php
    require '../class/function/curl_api.php';
    require '../class/function/function.php';
    require '../class/session/session_system.php';

	$workCodigo 	    = $_GET['id2'];
    $workModo 		    = $_GET['mode'];
    $codeRest           = $_GET['code'];
    $msgRest            = $_GET['msg'];

	if ($workCodigo <> 0) {
        $otJSON             = get_curl('1000/'.$workCodigo);
        
		if ($otJSON['code'] == 200){
			$row_ot_00  = $otJSON['data'][0]['ot_codigo'];
			$row_ot_01	= $otJSON['data'][0]['estado_ot_codigo'];
			$row_ot_02	= $otJSON['data'][0]['estado_ot_nombre'];
			$row_ot_03	= $otJSON['data'][0]['establecimiento_codigo'];
			$row_ot_04	= $otJSON['data'][0]['establecimiento_nombre'];
			$row_ot_05	= $otJSON['data'][0]['establecimiento_sigor'];
			$row_ot_06	= $otJSON['data'][0]['establecimiento_observacion'];
			$row_ot_07	= $otJSON['data'][0]['ot_numero'];
            $row_ot_08	= $otJSON['data'][0]['ot_fecha_inicio_trabajo'];
            $row_ot_09	= $otJSON['data'][0]['ot_fecha_inicio_trabajo_2'];
            $row_ot_10	= $otJSON['data'][0]['ot_fecha_final_trabajo'];
            $row_ot_11	= $otJSON['data'][0]['ot_fecha_final_trabajo_2'];
            $row_ot_12	= $otJSON['data'][0]['ot_observacion'];
        }

        $dominioJSON        = get_curl('500');
        $dominio_subJSON    = get_curl('600/dominio/CATEGORIASUBCATEGORIA');
        $seccionJSON        = get_curl('800/establecimiento/'.$row_ot_03);
        $potreroJSON        = get_curl('900/establecimiento/'.$row_ot_03);
        $otExiJSON          = get_curl('1100/ot/detalle/'.$workCodigo);
        $otAudJSON          = get_curl('1200/ot/detalle/'.$workCodigo);
        $otAudDiaTraJSON    = get_curl('1200/ot/resumen/dia/'.$workCodigo);
        $propietarioJSON    = get_curl('1400/establecimiento/'.$row_ot_03);

        if ($otExiJSON['code'] == 200) {
            $exiTotAdu = 0;
            $exiTotTer = 0;
            $exiTotGen = 0;
    
            foreach ($otExiJSON['data'] as $existenciaKey=>$existenciaArray) {
                $row_existencia_00  = $existenciaArray['origen_codigo'];
                $row_existencia_01  = $existenciaArray['origen_nombre'];
                $row_existencia_02  = $existenciaArray['raza_codigo'];
                $row_existencia_03  = $existenciaArray['raza_nombre'];
                $row_existencia_04  = $existenciaArray['categoria_codigo'];
                $row_existencia_05  = $existenciaArray['categoria_nombre'];
                $row_existencia_06  = $existenciaArray['subcategoria_codigo'];
                $row_existencia_07  = $existenciaArray['subcategoria_nombre'];
                $row_existencia_08  = 0.00;
                $row_existencia_09  = $existenciaArray['ot_existencia_cantidad'];
                $row_existencia_10  = $existenciaArray['ot_existencia_codigo'];
                
    
                if ($row_existencia_04 == 40) {
                    $exiTotTer = $exiTotTer + $row_existencia_09;
                } else {
                    $exiTotAdu = $exiTotAdu + $row_existencia_09;
                }
            }

            $exiTotGen = $exiTotTer + $exiTotAdu;
        }

        if ($otAudJSON['code'] == 200) {
            $audTotAdu = 0;
            $audTotTer = 0;
            $audTotGen = 0;
    
            foreach ($otAudJSON['data'] as $auditadaKey=>$auditadaArray) {
                $row_auditada_00  = $auditadaArray['origen_codigo'];
                $row_auditada_01  = $auditadaArray['origen_nombre'];
                $row_auditada_02  = $auditadaArray['raza_codigo'];
                $row_auditada_03  = $auditadaArray['raza_nombre'];
                $row_auditada_04  = $auditadaArray['categoria_codigo'];
                $row_auditada_05  = $auditadaArray['categoria_nombre'];
                $row_auditada_06  = $auditadaArray['subcategoria_codigo'];
                $row_auditada_07  = $auditadaArray['subcategoria_nombre'];
                $row_auditada_08  = $auditadaArray['ot_auditada_peso'];
                $row_auditada_09  = $auditadaArray['ot_auditada_cantidad'];
    
                if ($row_auditada_04 == 40) {
                    $audTotTer = $audTotTer + $row_auditada_09;
                } else {
                    $audTotAdu = $audTotAdu + $row_auditada_09;
                }
            }

            $audTotGen = $audTotTer + $audTotAdu;
        }

        if ($audTotGen > 0) {
            if ($exiTotGen == 0) {
                $bovTotGen = number_format((($audTotGen * 100) / 1), 2, ',', '.');
            } else {
                $bovTotGen = number_format((($audTotGen * 100) / $exiTotGen), 2, ',', '.');
            }

            
        } else {
            $bovTotGen = number_format(0 , 2, ',', '.');
        }
    }

    $charDiaTrabajo             = getCantDiaTrabajo($otAudDiaTraJSON);
    
    $charSeccion                = getCantSeccion($seccionJSON, $otAudJSON);
    $charSeccionPotrero         = getCantSeccionPotrero($seccionJSON, $potreroJSON, $otAudJSON);
    $charSeccionCategoria       = getCantSeccionCategoria($seccionJSON, $potreroJSON, $dominioJSON, $otAudJSON);
    $charSeccionSubCategoria    = getCantSeccionSubCategoria($seccionJSON, $potreroJSON, $dominioJSON, $dominioJSON, $otAudJSON);

//    $charPotreroCategoria       = getCantPotreroCategoria($potreroJSON, $dominioJSON, $otAudJSON);

    $charPotrero                = getCantPotrero($potreroJSON, $otAudJSON);
    $charCategoria              = getCantCategoria($dominio_subJSON, $otExiJSON, $otAudJSON);
    $charSubCategoria           = getCantSubCategoria($dominio_subJSON, $otExiJSON, $otAudJSON);
?>

<!DOCTYPE html>
<html lang="es" dir="ltr">

<head>
<?php
    include '../include/header.php';
?>
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
<?php
    	include '../include/menu.php';
?>
       
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->

            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- basic table -->
                <div class="row">
                    <div class="col-12">
                        <div class="card border-primary">
                            <div class="card-header bg-primary">
                                <h4 class="m-b-0 text-white"><?php echo $row_ot_04; ?></h4></div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <p class="card-text"><span style="font-weight:bold;">Estado:</span> <?php echo $row_ot_02; ?></p>
                                    </div>
                                    <div class="col-md-3">
                                        <p class="card-text"><span style="font-weight:bold;">Fecha Inicio:</span>  <?php echo $row_ot_09; ?></p>
                                    </div>
                                    <div class="col-md-3">
                                        <p class="card-text"><span style="font-weight:bold;">Fecha Fin:</span>  <?php echo $row_ot_11; ?></p>
                                    </div>
                                    <div class="col-md-3">
                                        <p class="card-text"><span style="font-weight:bold;">O.T. Nro.:</span> <?php echo $row_ot_07; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="card bg-light-success border-success">
                            <div class="card-body">
                                <h4 class="card-title">POBLACI&Oacute;N BOVINA AUDITADA <?php echo $bovTotGen; ?>%</h4>
                                <div class="d-flex no-block">
                                    <div class="align-self-end no-shrink">
                                        <h6 class="text-muted">Cantidad Existencia</h6>
                                        <h2 id="totExi" value="<?php echo $exiTotGen; ?>" class="m-b-0"><?php echo number_format($exiTotGen, 0, ',', '.'); ?></h2>
                                        <br><br>
                                        <h6 class="text-muted">Cantidad Auditada</h6>
                                        <h2 id="totAud" value="<?php echo $audTotGen; ?>" class="m-b-0"><?php echo number_format($audTotGen, 0, ',', '.'); ?></h2>
                                    </div>
                                    <div class="ml-auto">
                                        <div id="cantPoblacionRealizado"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="card bg-light-info border-info">
                            <div class="card-body">
                                <h4 class="card-title">POBLACI&Oacute;N BOVINA POR D&Iacute;A TRABAJO (AUDITADA)</h4>
                                <div id="cantPoblacionxDiaTrabajo"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">POBLACI&Oacute;N BOVINA POR PROPIETARIO (AUDITADA)</h4>
                                <div id="cantPoblacionxPropietario"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">POBLACI&Oacute;N BOVINA POR ORIGEN (AUDITADA)</h4>
                                <div id="cantPoblacionxOrigen"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">POBLACI&Oacute;N BOVINA POR RAZA (AUDITADA)</h4>
                                <div id="cantPoblacionxRaza"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">POBLACI&Oacute;N BOVINA POR SECCI&Oacute;N (AUDITADA)</h4>
                                <div id="cantPoblacionxSeccion">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<!--
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">POBLACI&Oacute;N BOVINA X SECCI&Oacute;N (AUDITADA)</h4>
                                <div id="cantPoblacionxSecCatSubCat">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
-->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">POBLACI&Oacute;N BOVINA POR POTRERO (AUDITADA)</h4>
                                <div id="cantPoblacionxPotrero">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">POBLACI&Oacute;N BOVINA POR CATEGOR&Iacute;A (EXISTENCIA VS AUDITADA)</h4>
                                <div id="cantPoblacionxCategoria"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">POBLACI&Oacute;N BOVINA POR SUBCATEGOR&Iacute;A (EXISTENCIA VS AUDITADA)</h4>
                                <div id="cantPoblacionxSubCategoria">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card border-info">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">POBLACI&Oacute;N BOVINA DETALLADA (EXISTENCIA VS AUDITADA)</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tableLoadPoblacionDetallada" class="table table-striped table-bordered">
                                        <thead id="tablePoblacionDetallada" class="<?php echo $workCodigo; ?>">
                                            <tr class="text-center">
                                                <th rowspan="2">ORIGEN</th>
                                                <th rowspan="2">RAZA</th>
                                                <th rowspan="2">CATEGOR&Iacute;A</th>
                                                <th rowspan="2">SUBCATEGOR&Iacute;A</th>
                                                <th colspan="2">CANTIDAD</th>
                                                <th rowspan="2">DIFERENCIA</th>
                                            </tr>
                                            <tr class="text-center">
                                                <th>EXISTENCIA</th>
                                                <th>AUDITADA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php
    if (($otExiJSON['code'] == 200) || ($otAudJSON['code'] == 200)) {
        $totalExiAdulto     = 0;
        $totalExiTernero    = 0;
        $totalAudAdulto     = 0;
        $totalAudTernero    = 0;

        foreach ($dominioJSON['data'] as $domOrigenKey=>$domOrigenArray) {
            $row_origen_00  = $domOrigenArray['dominio_codigo'];
            $row_origen_01  = $domOrigenArray['dominio_nombre'];
            $row_origen_02  = $domOrigenArray['dominio_valor'];

            if ($row_origen_02 == 'ANIMALORIGEN') {
                foreach ($dominioJSON['data'] as $domRazaKey=>$domRazaArray) {
                    $row_raza_00  = $domRazaArray['dominio_codigo'];
                    $row_raza_01  = $domRazaArray['dominio_nombre'];
                    $row_raza_02  = $domRazaArray['dominio_valor'];

                    if ($row_raza_02 == 'ANIMALRAZA') {
                        foreach ($dominio_subJSON['data'] as $domCategoriaKey=>$domCategoriaArray) {
                            $row_categoria_00  = $domCategoriaArray['tipo_subtipo_codigo'];
                            $row_categoria_01  = $domCategoriaArray['tipo_subtipo_valor'];
                            $row_categoria_02  = $domCategoriaArray['tipo_codigo'];
                            $row_categoria_03  = $domCategoriaArray['tipo_nombre'];
                            $row_categoria_04  = $domCategoriaArray['tipo_valor'];
                            $row_categoria_05  = $domCategoriaArray['subtipo_codigo'];
                            $row_categoria_06  = $domCategoriaArray['subtipo_nombre'];
                            $row_categoria_07  = $domCategoriaArray['subtipo_valor'];

                            if ($row_categoria_01 == 'CATEGORIASUBCATEGORIA') {
                                if ($otExiJSON['code'] == 200) {
                                    $totalExistencia = 0;
                            
                                    foreach ($otExiJSON['data'] as $existenciaKey=>$existenciaArray) {
                                        $row_existencia_00  = $existenciaArray['origen_codigo'];
                                        $row_existencia_01  = $existenciaArray['raza_codigo'];
                                        $row_existencia_02  = $existenciaArray['categoria_codigo'];
                                        $row_existencia_03  = $existenciaArray['subcategoria_codigo'];
                                        $row_existencia_04  = $existenciaArray['ot_existencia_cantidad'];
                
                                        if (($row_existencia_00 == $row_origen_00) && ($row_existencia_01 == $row_raza_00) && ($row_existencia_02 == $row_categoria_02) && ($row_existencia_03 == $row_categoria_05)) {
                                            $totalExistencia = $totalExistencia + $row_existencia_04;

                                            if ($row_existencia_02 == 40) {
                                                $totalExiTernero    = $totalExiTernero + $row_existencia_04;
                                            } else {
                                                $totalExiAdulto     = $totalExiAdulto + $row_existencia_04;
                                            }
                                        }
                                    }
                                }

                                if ($otAudJSON['code'] == 200) {
                                    $totalAuditada = 0;
                            
                                    foreach ($otAudJSON['data'] as $auditadaKey=>$auditadaArray) {
                                        $row_auditada_00  = $auditadaArray['origen_codigo'];
                                        $row_auditada_01  = $auditadaArray['raza_codigo'];
                                        $row_auditada_02  = $auditadaArray['categoria_codigo'];
                                        $row_auditada_03  = $auditadaArray['subcategoria_codigo'];
                                        $row_auditada_04  = $auditadaArray['ot_auditada_cantidad'];
                
                                        if (($row_auditada_00 == $row_origen_00) && ($row_auditada_01 == $row_raza_00) && ($row_auditada_02 == $row_categoria_02) && ($row_auditada_03 == $row_categoria_05)) {
                                            $totalAuditada = $totalAuditada + $row_auditada_04;

                                            if ($row_auditada_02 == 40) {
                                                $totalAudTernero    = $totalAudTernero + $row_auditada_04;
                                            } else {
                                                $totalAudAdulto     = $totalAudAdulto + $row_auditada_04;
                                            }
                                        }
                                    }
                                }

                                if (($totalExistencia > 0) || ($totalAuditada > 0) ) {
                                    $totalDiferencia = $totalAuditada - $totalExistencia;
                                    $styleDiferencia = getColorPositivoNegativo($totalDiferencia);
?>
                                            <tr>
                                                <td> <?php echo $row_origen_01; ?> </td>
                                                <td> <?php echo $row_raza_01; ?> </td>
                                                <td> <?php echo $row_categoria_03; ?> </td>
                                                <td> <?php echo $row_categoria_06; ?> </td>
                                                <td class="text-right"> <?php echo $totalExistencia; ?> </td>
                                                <td class="text-right"> <?php echo $totalAuditada; ?> </td>
                                                <td class="text-right" style="color:<?php echo $styleDiferencia; ?>;"> <?php echo $totalDiferencia; ?> </td>
                                            </tr>
<?php
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    $totalDifAdulto     = $totalAudAdulto - $totalExiAdulto;
    $totalDifTernero    = $totalAudTernero - $totalExiTernero;

    $totalExiGeneral    = $totalExiAdulto + $totalExiTernero;
    $totalAudGeneral    = $totalAudAdulto + $totalAudTernero;
    $totalDifGeneral    = $totalAudGeneral - $totalExiGeneral;

    $styleDifAdulto     = getColorPositivoNegativo($totalDifAdulto);
    $styleDifTernero    = getColorPositivoNegativo($totalDifTernero);
    $styleDifGeneral    = getColorPositivoNegativo($totalDifGeneral);
?>
                                        </tbody>
                                        <tfoot>
                                            <tr class="text-center">
                                                <th>ORIGEN</th>
                                                <th>RAZA</th>
                                                <th>CATEGOR&Iacute;A</th>
                                                <th>SUBCATEGOR&Iacute;A</th>
                                                <th>EXISTENCIA</th>
                                                <th>AUDITADA</th>
                                                <th>DIFERENCIA</th>
                                            </tr>
                                            <tr style="background-color:rgba(0,0,0,0.05); font-weight: bold;">
                                                <th colspan="4">TOTAL ADULTO</th>
                                                <th style="text-align:right;"><?php echo number_format($totalExiAdulto, 0, ',', '.'); ?></th>
                                                <th style="text-align:right;"><?php echo number_format($totalAudAdulto, 0, ',', '.'); ?></th>
                                                <th style="text-align:right; color:<?php echo $styleDifAdulto; ?>;"><?php echo number_format($totalDifAdulto, 0, ',', '.'); ?></th>
                                            </tr>
                                            <tr style="font-weight: bold;">
                                                <th colspan="4">TOTAL TENERO</th>
                                                <th style="text-align:right;"><?php echo number_format($totalExiTernero, 0, ',', '.'); ?></th>
                                                <th style="text-align:right;"><?php echo number_format($totalAudTernero, 0, ',', '.'); ?></th>
                                                <th style="text-align:right; color:<?php echo $styleDifTernero; ?>;"><?php echo number_format($totalDifTernero, 0, ',', '.'); ?></th>
                                            </tr>
                                            <tr style="background-color:rgba(0,0,0,0.05); font-weight: bold;">
                                                <th colspan="4">TOTAL POBLACI&Oacute;N BOVINA</th>
                                                <th style="text-align:right;"><?php echo number_format($totalExiGeneral, 0, ',', '.'); ?></th>
                                                <th style="text-align:right;"><?php echo number_format($totalAudGeneral, 0, ',', '.'); ?></th>
                                                <th style="text-align:right; color:<?php echo $styleDifGeneral; ?>;"><?php echo number_format($totalDifGeneral, 0, ',', '.'); ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
<?php
    include '../include/development.php';
?>
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <div class="chat-windows"></div>
<?php
    include '../include/footer.php';

    if ($codeRest == 200) {
?>
    <script>
        $(function() {
            toastr.success('<?php echo $msgRest; ?>', 'Correcto!');
        });
    </script>
<?php
    }

    if ($codeRest == 204) {
?>
    <script>
        $(function() {
            toastr.error('<?php echo $msgRest; ?>', 'Error!');
        });
    </script>
<?php
    }
?>

    <script>
        $(function() {
            'use strict';

            var totExi = $('#totExi').attr('value');
	        var totAud = $('#totAud').attr('value');
	        var totRea = (totAud * 100) / totExi;
            
            totRea = totRea.toFixed(2);

            var chart_01 = c3.generate({
                bindto: "#cantPoblacionRealizado",
                data: {
                    columns: [
                        ["TOTAL AUDITADA " + totAud, totRea]
                    ],
                    type: "gauge",
                        onclick: function(d, i) {
                            console.log("onclick", d, i);
                        },
                        onmouseover: function(d, i) {
                            console.log("onmouseover", d, i);
                        },
                        onmouseout: function(d, i) {
                            console.log("onmouseout", d, i);
                        }
                },
                color: {
                    pattern: ["#20aee3", "#20aee3", "#20aee3", "#24d2b5"],
                    threshold: {
                        values: [30, 60, 90, 100]
                    }
                },
                size: {
                    height: 120,
                    width: 150
                },
                gauge: {
                    width: 22
                },
            });
    
            var chart_02 = c3.generate({
                bindto: "#cantPoblacionxPotrero",
                data: {
                    x : "x",
                    columns: [
                        ["x", <?php echo $charPotrero[0]; ?>],
                        ["Cantidad Bovino", <?php echo $charPotrero[1]; ?>],
                    ],
                    type: "bar"
                },
                color: { 
                    pattern: ["#4fc3f7"] 
                },
                size: {
                    height: 600
                },
                axis: { 
                    rotated: !0,
                    x: {
                        type: "category"
                    }
                },
                grid: { 
                    x: { 
                        show: true 
                    },
                    y: {
                        show: !0 
                    }
                },
                legend: {
                    hide: true
                }
            });

            var chart_03 = c3.generate({
                bindto: "#cantPoblacionxCategoria",
                data: {
                    x : "x",
                    columns: [
                        ["x", <?php echo $charCategoria[0]; ?>],
                        ["Población Existencia", <?php echo $charCategoria[1]; ?>],
                        ["Población Auditada", <?php echo $charCategoria[2]; ?>]
                    ],
                    type: "bar"
                },
                size: { 
                    height: 270 
                },
                axis: {
                    x: {
                        type: "category"
                    },
                    y: {
                        tick: {
                            count: 3,
                            outer: false
                        }
                    }
                },
                legend: {
                    hide: false
                },
                grid: { 
                    x: { 
                        show: true 
                    },
                    y: {
                        show: true
                    }
                },
                bar: {
                    space: 0.2,
                    width: 15
                }
            });

            var chart_04 = c3.generate({
                bindto: "#cantPoblacionxSubCategoria",
                data: {
                    x : "x",
                    columns: [
                        ["x", <?php echo $charSubCategoria[0]; ?>],
                        ["Población Existencia", <?php echo $charSubCategoria[1]; ?>],
                        ["Población Auditada", <?php echo $charSubCategoria[2]; ?>]
                    ],
                    type: "bar"
                },
                size: { 
                    height: 270 
                },
                axis: {
                    x: {
                        type: "category"
                    },
                    y: {
                        tick: {
                            count: 3,
                            outer: false
                        }
                    }
                },
                legend: {
                    hide: false
                },
                grid: { 
                    x: { 
                        show: true 
                    },
                    y: {
                        show: true
                    }
                },
                bar: {
                    space: 0.2,
                    width: 15
                }
            });

            var chart_05 = c3.generate({
                bindto: "#cantPoblacionxPropietario",
                data: {
                    columns: [
<?php
    if ($propietarioJSON['code'] == 200) {
        foreach ($propietarioJSON['data'] as $propietarioKey=>$propietarioArray) {
            $row_propietario_00 = $propietarioArray['persona_codigo'];
            $row_propietario_01 = $propietarioArray['establecimiento_propietario_marca'];

            if ($otAudJSON['code'] == 200) {
                $totalAuditada  = 0;
        
                foreach ($otAudJSON['data'] as $auditadaKey=>$auditadaArray) {
                    $row_auditada_00  = $auditadaArray['propietario_codigo'];
                    $row_auditada_02  = $auditadaArray['propietario_marca'];
                    $row_auditada_03  = $auditadaArray['ot_auditada_cantidad'];

                    if (($row_auditada_00 == $row_propietario_00)) {
                        $charTitulo01   = $row_auditada_02;
                        $totalAuditada  = $totalAuditada + $row_auditada_03;
                    }
                }

                if ($totalAuditada > 0) {
?>
                        ["<?php echo $charTitulo01.' '.$totalAuditada; ?>", <?php echo $totalAuditada; ?>],
<?php
                }
            }
        }
    }
?>
                    ],
                    type: "pie",
                    onclick: function(o, n) { 
                        console.log("onclick", o, n) 
                    },
                    onmouseover: function(o, n) { 
                        console.log("onmouseover", o, n) 
                    },
                    onmouseout: function(o, n) { 
                        console.log("onmouseout", o, n) 
                    }
                }
            });

            var chart_06 = c3.generate({
                bindto: "#cantPoblacionxOrigen",
                data: {
                    columns: [
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_dominio_00 = $dominioArray['dominio_codigo'];
            $row_dominio_01 = $dominioArray['dominio_nombre'];
            $row_dominio_02 = $dominioArray['dominio_valor'];

            if ($row_dominio_02 == 'ANIMALORIGEN') {
                if ($otAudJSON['code'] == 200) {
                    $totalAuditada  = 0;
            
                    foreach ($otAudJSON['data'] as $auditadaKey=>$auditadaArray) {
                        $row_auditada_00  = $auditadaArray['origen_codigo'];
                        $row_auditada_02  = $auditadaArray['origen_nombre'];
                        $row_auditada_03  = $auditadaArray['ot_auditada_cantidad'];

                        if (($row_auditada_00 == $row_dominio_00)) {
                            $charTitulo01   = $row_auditada_02;
                            $totalAuditada  = $totalAuditada + $row_auditada_03;
                        }
                    }

                    if ($totalAuditada > 0) {
?>
                        ["<?php echo $row_dominio_01.' '.$totalAuditada; ?>", <?php echo $totalAuditada; ?>],
<?php
                    }
                }
            }
        }
    }
?>
                    ],
                    type: "pie",
                    onclick: function(o, n) { 
                        console.log("onclick", o, n) 
                    },
                    onmouseover: function(o, n) { 
                        console.log("onmouseover", o, n) 
                    },
                    onmouseout: function(o, n) { 
                        console.log("onmouseout", o, n) 
                    }
                }
            });

            var chart_07 = c3.generate({
                bindto: "#cantPoblacionxRaza",
                data: {
                    columns: [
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_dominio_00 = $dominioArray['dominio_codigo'];
            $row_dominio_01 = $dominioArray['dominio_nombre'];
            $row_dominio_02 = $dominioArray['dominio_valor'];

            if ($row_dominio_02 == 'ANIMALRAZA') {
                if ($otAudJSON['code'] == 200) {
                    $totalAuditada  = 0;
            
                    foreach ($otAudJSON['data'] as $auditadaKey=>$auditadaArray) {
                        $row_auditada_00  = $auditadaArray['raza_codigo'];
                        $row_auditada_02  = $auditadaArray['raza_nombre'];
                        $row_auditada_03  = $auditadaArray['ot_auditada_cantidad'];

                        if (($row_auditada_00 == $row_dominio_00)) {
                            $charTitulo01   = $row_auditada_02;
                            $totalAuditada  = $totalAuditada + $row_auditada_03;
                        }
                    }

                    if ($totalAuditada > 0) {
?>
                        ["<?php echo $row_dominio_01.' '.$totalAuditada; ?>", <?php echo $totalAuditada; ?>],
<?php
                    }
                }
            }
        }
    }
?>
                    ],
                    type: "pie",
                    onclick: function(o, n) { 
                        console.log("onclick", o, n) 
                    },
                    onmouseover: function(o, n) { 
                        console.log("onmouseover", o, n) 
                    },
                    onmouseout: function(o, n) { 
                        console.log("onmouseout", o, n) 
                    }
                }
            });

            var chart_08 = c3.generate({
                bindto: "#cantPoblacionxDiaTrabajo",
                data: {
                    x : "x",
                    columns: [
                        ["x", <?php echo $charDiaTrabajo[0]; ?>],
                        ["Auditada", <?php echo $charDiaTrabajo[1]; ?>]
                    ],
                    type: "bar"
                },
                color: { 
                    pattern: ["#4fc3f7"] 
                },
                size: { 
                    height: 163.6 
                },
                axis: {
                    x: {
                        type: "category"
                    },
                    y: {
                        tick: {
                            count: 3,
                            outer: false
                        }
                    }
                },
                legend: {
                    hide: false
                },
                grid: { 
                    x: { 
                        show: true 
                    },
                    y: {
                        show: true
                    }
                },
                bar: {
                    space: 0.2,
                    width: 15
                }
            });
        });

        // Create the chart
        Highcharts.chart('cantPoblacionxSeccion', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'POBLACIÓN BOVINA AGRUPADO POR SECCIÓN - POTRERO - CATEGORÍA - SUBCATEGORÍA'
            },
            subtitle: {
                text: 'Click sobre las columnas para ver los detalles'
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Total Población Bovina'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    }
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> Cabezas<br/>'
            },
            "series": [
                {
                    "name": "Sección",
                    "colorByPoint": true,
                    "data": [
<?php
    foreach ($charSeccion as $seccionKey=>$seccionArray) {
?>
                        {
                            "name": "<?php echo $seccionArray['name']; ?>",
                            "y": <?php echo $seccionArray['value']; ?>,
                            "drilldown": "<?php echo $seccionArray['name']; ?>"
                        },
<?php
    }
?>
                    ]
                }
            ],
            "drilldown": {
                "series": [
<?php
    foreach ($charSeccion as $seccionKey=>$seccionArray) {
?>
                    {
                        "id": "<?php echo $seccionArray['name']; ?>",
                        "name": "<?php echo $seccionArray['name']; ?>",
                        "data": [
<?php
        foreach ($charSeccionPotrero as $seccionPotreroKey=>$seccionPotreroArray) {
            if ($seccionArray['seccion_id'] == $seccionPotreroArray['seccion_id']) {
?>
                            {
                                "name": "<?php echo $seccionPotreroArray['name']; ?>",
                                "y": <?php echo $seccionPotreroArray['value']; ?>,
                                "drilldown": "<?php echo $seccionArray['name'].' - '.$seccionPotreroArray['name']; ?>"
                            },
<?php
            }
        }
?>
                        ]
                    },
<?php
    }
    foreach ($charSeccion as $seccionKey=>$seccionArray) {
        foreach ($charSeccionPotrero as $seccionPotreroKey=>$seccionPotreroArray) {
            if ($seccionArray['seccion_id'] == $seccionPotreroArray['seccion_id']) {
?>
                    {
                        "id": "<?php echo $seccionArray['name'].' - '.$seccionPotreroArray['name']; ?>",
                        "name": "<?php echo $seccionArray['name'].' - '.$seccionPotreroArray['name']; ?>",
                        "data": [
<?php
                foreach ($charSeccionCategoria as $seccionCategoriaKey=>$seccionCategoriaArray) {
                    if (($seccionArray['seccion_id'] == $seccionCategoriaArray['seccion_id']) && ($seccionPotreroArray['potrero_id'] == $seccionCategoriaArray['potrero_id'])) {
?>
                            {
                                "name": "<?php echo $seccionArray['name'].' - '.$seccionPotreroArray['name'].' - '.$seccionCategoriaArray['name']; ?>",
                                "y": <?php echo $seccionCategoriaArray['value']; ?>,
                                "drilldown": "<?php echo $seccionArray['name'].' - '.$seccionPotreroArray['name'].' - '.$seccionCategoriaArray['name']; ?>"
                            },
<?php
                    }
                }
?>
                        ]
                    },
<?php
            }
        }
    }

    foreach ($charSeccion as $seccionKey=>$seccionArray) {
        foreach ($charSeccionPotrero as $seccionPotreroKey=>$seccionPotreroArray) {
            if ($seccionArray['seccion_id'] == $seccionPotreroArray['seccion_id']) {
                foreach ($charSeccionCategoria as $seccionCategoriaKey=>$seccionCategoriaArray) {
                    if (($seccionArray['seccion_id'] == $seccionCategoriaArray['seccion_id']) && ($seccionPotreroArray['potrero_id'] == $seccionCategoriaArray['potrero_id'])) {
?>
                    {
                        "id": "<?php echo $seccionArray['name'].' - '.$seccionPotreroArray['name'].' - '.$seccionCategoriaArray['name']; ?>",
                        "data": [
<?php
                        foreach ($charSeccionSubCategoria as $seccionSubCategoriaKey=>$seccionSubCategoriaArray) {
                            if (($seccionArray['seccion_id'] == $seccionSubCategoriaArray['seccion_id']) && ($seccionPotreroArray['potrero_id'] == $seccionSubCategoriaArray['potrero_id']) && ($seccionCategoriaArray['categoria_id'] == $seccionSubCategoriaArray['categoria_id'])) {
?>
                            [ "<?php echo $seccionArray['name'].' - '.$seccionPotreroArray['name'].' - '.$seccionCategoriaArray['name'].' - '.$seccionSubCategoriaArray['name']; ?>", <?php echo $seccionSubCategoriaArray['value']; ?>],
<?php
                            }
                        }
?>
                        ]
                    },
<?php
                    }
                }
            }
        }
    }
?>
                ]
            }
        });
    </script>

    <script src="../js/ot_detalle.js"></script>
</body>
</html>