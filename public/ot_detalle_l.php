<?php
    require '../class/session/session_system.php';
    require '../class/function/curl_api.php';
    require '../class/function/function.php';

	$workCodigo 	    = $_GET['codigo'];
    $workModo 		    = $_GET['mode'];
    $codeRest           = $_GET['code'];;
    $msgRest            = $_GET['msg'];;
    $dominioJSON        = get_curl('500');
    $dominio_subJSON    = get_curl('600/dominio/CATEGORIASUBCATEGORIA');

	if ($workCodigo <> 0){
        $otJSON             = get_curl('1000/'.$workCodigo);
        $otExiJSON          = get_curl('1100/ot/'.$workCodigo);

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
        
        if ($otExiJSON['code'] == 200){
            $acuTotAdu = 0;
            $acuTotTer = 0;

            foreach ($otExiJSON['data'] as $otExiKey=>$otExiArray) {
                $row_ot_existencia_01 = $otExiArray['categoria_codigo'];
                $row_ot_existencia_02 = $otExiArray['subcategoria_codigo'];
                $row_ot_existencia_03 = $otExiArray['ot_existencia_cantidad'];

                if ($row_ot_existencia_01 == 40) {
                    $acuTotTer = $acuTotTer + $row_ot_existencia_03;
                } else {
                    $acuTotAdu = $acuTotAdu + $row_ot_existencia_03;
                }
            }

            $acuTotGen = $acuTotTer + $acuTotAdu;
        }
    }
?>

<!DOCTYPE html>
<html lang="es" dir="ltr">

<head>
<?php
    include '../include/header.php';
?>
	
	<title>Panel Administrador - O.T. Ficha</title>
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
                                <div class="row">
                                	<h4 class="col-8 card-title">&nbsp;</h4>
                                	<h4 class="col-4 card-title" style="text-align: right;">
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-pdf"><i class="far fa-file-pdf"></i></button>
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-contact"><i class="ti-plus"></i></button>
                                	</h4>
								</div>
                                <div class="table-responsive">
                                    <table id="tableLoadExistencia" class="table table-striped table-bordered">
                                        <thead id="tableExistencia" class="<?php echo $workCodigo; ?>">
                                            <tr>
                                                <th>C&Oacute;DIGO</th>
                                                <th>ORIGEN</th>
                                                <th>RAZA</th>
                                                <th>CATEGOR&Iacute;A</th>
                                                <th>SUBCATEGOR&Iacute;A</th>
                                                <th>CANTIDAD</th>
                                                <th>OBSERVACI&Oacute;N</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>C&Oacute;DIGO</th>
                                                <th>ORIGEN</th>
                                                <th>RAZA</th>
                                                <th>CATEGOR&Iacute;A</th>
                                                <th>SUBCATEGOR&Iacute;A</th>
                                                <th>CANTIDAD</th>
                                                <th>OBSERVACI&Oacute;N</th>
                                            </tr>
                                            <tr style="background-color:rgba(0,0,0,0.05); font-weight: bold;">
                                                <th>&nbsp;</th>
                                                <th>TOTAL ADULTO</th>
                                                <th colspan="5" style="text-align:right;"><?php echo number_format($acuTotAdu, 0, ',', '.'); ?></th>
                                            </tr>
                                            <tr style="font-weight: bold;">
                                                <th>&nbsp;</th>
                                                <th>TOTAL TENERO</th>
                                                <th colspan="5" style="text-align:right;"><?php echo number_format($acuTotTer, 0, ',', '.'); ?></th>
                                            </tr>
                                            <tr style="background-color:rgba(0,0,0,0.05); font-weight: bold;">
                                                <th>&nbsp;</th>
                                                <th>TOTAL POBLACI&Oacute;N BOVINA</th>
                                                <th colspan="5" style="text-align:right;"><?php echo number_format($acuTotGen, 0, ',', '.'); ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="row">
                                    <div id="add-contact" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">Agregar Animal</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-horizontal form-material" method="post" action="../class/crud/ot_existencia_a.php">
                                                        <div class="form-group">
                                                            <input id="workCodigo" name="workCodigo" class="form-control" type="hidden" placeholder="Codigo" value="<?php echo $workCodigo; ?>" required readonly>
                                                            <input id="workModo" name="workModo" class="form-control" type="hidden" placeholder="Modo" value="C" required readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="existenciaOrigen">Origen</label>
                                                            <select id="existenciaOrigen" name="existenciaOrigen" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?>>
													            <optgroup label="Origen">
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_tipo_00          	= $dominioArray['estado_dominio_codigo'];
            $row_tipo_01          	= $dominioArray['dominio_codigo'];
            $row_tipo_02          	= $dominioArray['dominio_nombre'];
            $row_tipo_03          	= $dominioArray['dominio_valor'];
            $row_tipo_04         	= $dominioArray['dominio_observacion'];
            $selectedTipo 			= '';

            if ($row_tipo_00 == 1 && $row_tipo_03 == 'ANIMALORIGEN') {
                if ($row_tipo_01 == 20){
                    $selectedTipo = 'selected';
                }
?>
														            <option value="<?php echo $row_tipo_01; ?>" <?php echo $selectedTipo; ?>><?php echo $row_tipo_02; ?></option>
<?php
            }
        }
    }
?>
													            </optgroup>
												            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="existenciaRaza">Raza</label>
                                                            <select id="existenciaRaza" name="existenciaRaza" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?>>
													            <optgroup label="Raza">
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_tipo_00          	= $dominioArray['estado_dominio_codigo'];
            $row_tipo_01          	= $dominioArray['dominio_codigo'];
            $row_tipo_02          	= $dominioArray['dominio_nombre'];
            $row_tipo_03          	= $dominioArray['dominio_valor'];
            $row_tipo_04         	= $dominioArray['dominio_observacion'];
            $selectedTipo 			= '';

            if ($row_tipo_00 == 1 && $row_tipo_03 == 'ANIMALRAZA') {
                if ($row_tipo_01 == 86){
                    $selectedTipo = 'selected';
                }
?>
														            <option value="<?php echo $row_tipo_01; ?>" <?php echo $selectedTipo; ?>><?php echo $row_tipo_02; ?></option>
<?php
            }
        }
    }
?>
													            </optgroup>
												            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="existenciaCategoria">Categor&iacute;as - SubCategor&iacute;as</label>
                                                            <select id="existenciaCategoria" name="existenciaCategoria" class="select2 form-control custom-select" style="width: 100%; height:36px;">
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_dominio_00      	= $dominioArray['dominio_codigo'];
            $row_dominio_01      	= $dominioArray['estado_dominio_codigo'];
            $row_dominio_02      	= $dominioArray['dominio_nombre'];
            $row_dominio_03      	= $dominioArray['dominio_valor'];

            if ($row_dominio_01 == 1 && $row_dominio_03 == "ANIMALCATEGORIA") {
?>
                                  			                    <optgroup label="<?php echo $row_dominio_02; ?>">
								
<?php
                if ($dominio_subJSON['code'] == 200) {
                    foreach ($dominio_subJSON['data'] as $dominio_subKey=>$dominio_subArray) {
                        $row_dominio_sub_00      	= $dominio_subArray['tipo_subtipo_codigo'];
                        $row_dominio_sub_01      	= $dominio_subArray['estado_tipo_subtipo_codigo'];
                        $row_dominio_sub_02      	= $dominio_subArray['estado_tipo_subtipo_nombre'];
                        $row_dominio_sub_03      	= $dominio_subArray['subtipo_codigo'];
                        $row_dominio_sub_04      	= $dominio_subArray['subtipo_nombre'];
                        $row_dominio_sub_05      	= $dominio_subArray['tipo_codigo'];
                        $row_dominio_sub_06      	= $dominio_subArray['tipo_nombre'];
			
			            if ($row_dominio_00 == $row_dominio_sub_05) {
?>
												                    <option value="<?php echo $row_dominio_sub_00; ?>"><?php echo $row_dominio_sub_04; ?></option>
<?php
			            }
		            }
	            }
?>
                                    		                    </optgroup>
<?php
		    }
        }
    }
?>
                                		                    </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="existenciaCantidad">Cantidad</label>
                                                            <input id="existenciaCantidad" name="existenciaCantidad" class="form-control" type="number" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="existenciaObservacion">Observaci&oacute;n</label>
                                                            <textarea id="existenciaObservacion" name="existenciaObservacion" class="form-control" rows="5"></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-info waves-effect">Guardar</button>
                                                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancelar</button>
                                                        </div>
                                                    </form>
                                                </div>      
                                            </div>
                                        </div>
                                    </div>
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
                                <div class="row">
                                	<h4 class="col-10 card-title">&nbsp;</h4>
                                	<h4 class="col-2 card-title" style="text-align: right;">
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#add-auditoria"><i class="ti-plus"></i></button>
                                	</h4>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="card border-secondary">
                            <div class="card-header bg-secondary">
                                <h4 class="m-b-0 text-white">DOCUMENTOS ADJUNTOS</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                	<h4 class="col-10 card-title">&nbsp;</h4>
                                	<h4 class="col-2 card-title" style="text-align: right;">
                                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#add-documento"><i class="ti-plus"></i></button>
                                	</h4>
								</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="card border-warning">
                            <div class="card-header bg-warning">
                                <h4 class="m-b-0 text-white">USUARIOS</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                	<h4 class="col-10 card-title">&nbsp;</h4>
                                	<h4 class="col-2 card-title" style="text-align: right;">
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#add-usuario"><i class="ti-plus"></i></button>
                                	</h4>
								</div>
                            </div>
                        </div>
                    </div>
                </div>-->
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
    <script src="../js/ot_detalle.js"></script>
</body>
</html>