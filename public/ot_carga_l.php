<?php
    require '../class/session/session_system.php';
    require '../class/function/curl_api.php';
    require '../class/function/function.php';

	$workCodigo 	    = $_GET['codigo'];
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

        $otExiJSON          = get_curl('1100/ot/detalle/'.$workCodigo);
        $otAudJSON          = get_curl('1200/ot/detalle/'.$workCodigo);
    }
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
                    <div class="col-12">
                        <div class="card border-success">
                            <div class="card-header bg-success">
                                <h4 class="m-b-0 text-white">PLANILLA EXISTENCIA</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tableLoadExistencia" class="table table-striped table-bordered">
                                        <thead id="tableExistencia" class="<?php echo $workCodigo; ?>">
                                            <tr>
                                                <th>ELIMINAR</th>
                                                <th>FECHA</th>
                                                <th>POTRERO</th>
                                                <th>PROPIETARIO</th>
                                                <th>ORIGEN</th>
                                                <th>RAZA</th>
                                                <th>CATEGOR&Iacute;A</th>
                                                <th>SUBCATEGOR&Iacute;A</th>
                                                <th>PESO PROMEDIO</th>
                                                <th>CANTIDAD</th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php
    if ($otExiJSON['code'] == 200) {
        $exiTotAdu = 0;
        $exiTotTer = 0;
        $exiTotGen = 0;

        foreach ($otExiJSON['data'] as $existenciaKey=>$existenciaArray) {
            $row_existencia_00  = $existenciaArray['potrero_codigo'];
            $row_existencia_01  = $existenciaArray['potrero_nombre'];
            $row_existencia_02  = $existenciaArray['propietario_codigo'];
            $row_existencia_03  = $existenciaArray['propietario_marca'];
            $row_existencia_04  = $existenciaArray['origen_codigo'];
            $row_existencia_05  = $existenciaArray['origen_nombre'];
            $row_existencia_06  = $existenciaArray['raza_codigo'];
            $row_existencia_07  = $existenciaArray['raza_nombre'];
            $row_existencia_08  = $existenciaArray['categoria_codigo'];
            $row_existencia_09  = $existenciaArray['categoria_nombre'];
            $row_existencia_10  = $existenciaArray['subcategoria_codigo'];
            $row_existencia_11  = $existenciaArray['subcategoria_nombre'];
            $row_existencia_12  = $existenciaArray['ot_existencia_codigo'];
            $row_existencia_13  = $existenciaArray['ot_existencia_fecha_2'];
            $row_existencia_14  = $existenciaArray['ot_existencia_peso'];
            $row_existencia_15  = $existenciaArray['ot_existencia_cantidad'];
            

            if ($row_existencia_08 == 40) {
                $exiTotTer = $exiTotTer + $row_existencia_15;
            } else {
                $exiTotAdu = $exiTotAdu + $row_existencia_15;
            }
?>
                                            <tr>
                                                <td>
                                                    <button type="button" class="btn btn-success" onclick="deteleItem(<?php echo $workCodigo; ?>, 1100, <?php echo $row_existencia_12; ?>)"><i class="ti-trash"></i></button>
                                                </td>
                                                <td> <?php echo $row_existencia_13; ?> </td>
                                                <td> <?php echo $row_existencia_01; ?> </td>
                                                <td> <?php echo $row_existencia_03; ?> </td>
                                                <td> <?php echo $row_existencia_05; ?> </td>
                                                <td> <?php echo $row_existencia_07; ?> </td>
                                                <td> <?php echo $row_existencia_09; ?> </td>
                                                <td> <?php echo $row_existencia_11; ?> </td>
                                                <td class="text-right"> <?php echo $row_existencia_14; ?> </td>
                                                <td class="text-right"> <?php echo $row_existencia_15; ?> </td>
                                            </tr>
<?php
        }

        $exiTotGen = $exiTotTer + $exiTotAdu;
    }
?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>ELIMINAR</th>
                                                <th>FECHA</th>
                                                <th>POTRERO</th>
                                                <th>PROPIETARIO</th>
                                                <th>ORIGEN</th>
                                                <th>RAZA</th>
                                                <th>CATEGOR&Iacute;A</th>
                                                <th>SUBCATEGOR&Iacute;A</th>
                                                <th>PESO PROMEDIO</th>
                                                <th>CANTIDAD</th>
                                            </tr>
                                            <tr style="background-color:rgba(0,0,0,0.05); font-weight: bold;">
                                                <th colspan="9">TOTAL ADULTO</th>
                                                <th style="text-align:right;"><?php echo number_format($exiTotAdu, 0, ',', '.'); ?></th>
                                            </tr>
                                            <tr style="font-weight: bold;">
                                                <th colspan="9">TOTAL TENERO</th>
                                                <th style="text-align:right;"><?php echo number_format($exiTotTer, 0, ',', '.'); ?></th>
                                            </tr>
                                            <tr style="background-color:rgba(0,0,0,0.05); font-weight: bold;">
                                                <th colspan="9">TOTAL POBLACI&Oacute;N BOVINA</th>
                                                <th style="text-align:right;"><?php echo number_format($exiTotGen, 0, ',', '.'); ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card border-danger">
                            <div class="card-header bg-danger">
                                <h4 class="m-b-0 text-white">PLANILLA AUDITADA</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tableLoadAuditada" class="table table-striped table-bordered">
                                        <thead id="tableAuditada" class="<?php echo $workCodigo; ?>">
                                            <tr>
                                                <th>ELIMINAR</th>
                                                <th>FECHA</th>
                                                <th>POTRERO</th>
                                                <th>PROPIETARIO</th>
                                                <th>ORIGEN</th>
                                                <th>RAZA</th>
                                                <th>CATEGOR&Iacute;A</th>
                                                <th>SUBCATEGOR&Iacute;A</th>
                                                <th>PESO PROMEDIO</th>
                                                <th>CANTIDAD</th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php
    if ($otAudJSON['code'] == 200) {
        $audTotAdu = 0;
        $audTotTer = 0;
        $audTotGen = 0;

        foreach ($otAudJSON['data'] as $auditadaKey=>$auditadaArray) {
            $row_auditada_00  = $auditadaArray['potrero_codigo'];
            $row_auditada_01  = $auditadaArray['potrero_nombre'];
            $row_auditada_02  = $auditadaArray['propietario_codigo'];
            $row_auditada_03  = $auditadaArray['propietario_marca'];
            $row_auditada_04  = $auditadaArray['origen_codigo'];
            $row_auditada_05  = $auditadaArray['origen_nombre'];
            $row_auditada_06  = $auditadaArray['raza_codigo'];
            $row_auditada_07  = $auditadaArray['raza_nombre'];
            $row_auditada_08  = $auditadaArray['categoria_codigo'];
            $row_auditada_09  = $auditadaArray['categoria_nombre'];
            $row_auditada_10  = $auditadaArray['subcategoria_codigo'];
            $row_auditada_11  = $auditadaArray['subcategoria_nombre'];
            $row_auditada_12  = $auditadaArray['ot_auditada_codigo'];
            $row_auditada_13  = $auditadaArray['ot_auditada_fecha_2'];
            $row_auditada_14  = $auditadaArray['ot_auditada_peso'];
            $row_auditada_15  = $auditadaArray['ot_auditada_cantidad'];

            if ($row_auditada_04 == 40) {
                $audTotTer = $audTotTer + $row_auditada_15;
            } else {
                $audTotAdu = $audTotAdu + $row_auditada_15;
            }
?>
                                            <tr>
                                                <td>
                                                    <button type="button" class="btn btn-danger" onclick="deteleItem(<?php echo $workCodigo; ?>, 1200, <?php echo $row_auditada_12; ?>)"><i class="ti-trash"></i></button>
                                                </td>
                                                <td> <?php echo $row_auditada_13; ?> </td>
                                                <td> <?php echo $row_auditada_01; ?> </td>
                                                <td> <?php echo $row_auditada_03; ?> </td>
                                                <td> <?php echo $row_auditada_05; ?> </td>
                                                <td> <?php echo $row_auditada_07; ?> </td>
                                                <td> <?php echo $row_auditada_09; ?> </td>
                                                <td> <?php echo $row_auditada_11; ?> </td>
                                                <td class="text-right"> <?php echo $row_auditada_14; ?> </td>
                                                <td class="text-right"> <?php echo $row_auditada_15; ?> </td>
                                            </tr>
<?php
        }

        $audTotGen = $audTotTer + $audTotAdu;
    }
?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>ELIMINAR</th>
                                                <th>FECHA</th>
                                                <th>POTRERO</th>
                                                <th>PROPIETARIO</th>
                                                <th>ORIGEN</th>
                                                <th>RAZA</th>
                                                <th>CATEGOR&Iacute;A</th>
                                                <th>SUBCATEGOR&Iacute;A</th>
                                                <th>PESO PROMEDIO</th>
                                                <th>CANTIDAD</th>
                                            </tr>
                                            <tr style="background-color:rgba(0,0,0,0.05); font-weight: bold;">
                                                <th colspan="9">TOTAL ADULTO</th>
                                                <th style="text-align:right;"><?php echo number_format($audTotAdu, 0, ',', '.'); ?></th>
                                            </tr>
                                            <tr style="font-weight: bold;">
                                                <th colspan="9">TOTAL TENERO</th>
                                                <th style="text-align:right;"><?php echo number_format($audTotTer, 0, ',', '.'); ?></th>
                                            </tr>
                                            <tr style="background-color:rgba(0,0,0,0.05); font-weight: bold;">
                                                <th colspan="9">TOTAL POBLACI&Oacute;N BOVINA</th>
                                                <th style="text-align:right;"><?php echo number_format($audTotGen, 0, ',', '.'); ?></th>
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

            <a href="../public/ot_carga_m.php?mode=C&codigo=<?php echo $workCodigo; ?>" class="float">
                <i class="fa fa-plus custom-float"></i>
            </a>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                Todos los derechos reservados. Dise&ntilde;ado y desarrollado por 
                <a href="http://cerouno.com.py">CEROUNO Labs</a>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
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

    <script src="../js/ot_carga.js"></script>
</body>
</html>