<?php
    require '../class/session/session_system.php';
    require '../class/function/curl_api.php';
    require '../class/function/function.php';

	$workCodigo 	    = $_GET['codigo'];
    $workModo 		    = $_GET['mode'];
    $codeRest           = $_GET['code'];
    $msgRest            = $_GET['msg'];

	if ($workCodigo <> 0){
        $otJSON             = get_curl('1000/'.$workCodigo);
        $otExiJSON          = get_curl('1100/ot/'.$workCodigo);
        $otAudJSON          = get_curl('1200/ot/detalle/'.$workCodigo);

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
        $potreroJSON        = get_curl('900/establecimiento/'.$row_ot_03);
        $propietarioJSON    = get_curl('1400/establecimiento/'.$row_ot_03);
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
                        <div class="card border-secondary">
                            <div class="card-header bg-secondary">
                                <h4 class="m-b-0 text-white">PROPIETARIOS</h4></div>
                            <div class="card-body">
<?php
    if ($propietarioJSON['code'] == 200) {
        foreach ($propietarioJSON['data'] as $propietarioKey=>$propietarioArray) {
            $row_propietario_00  = $propietarioArray['establecimiento_propietario_codigo'];
            $row_propietario_01  = $propietarioArray['persona_nombre'].' '.$propietarioArray['persona_apellido'];
            $row_propietario_02  = $propietarioArray['persona_razon_social'];
            $row_propietario_03  = $propietarioArray['persona_documento'];
            $row_propietario_04  = $propietarioArray['persona_telefono'];
            $row_propietario_05  = $propietarioArray['persona_correo_electronico'];
?>
                                <div class="row">
                                    <div class="col-md-3">
                                        <p class="card-text"><span style="font-weight:bold;">Persona:</span> <?php echo $row_propietario_01; ?></p>
                                    </div>
                                    <div class="col-md-3">
                                        <p class="card-text"><span style="font-weight:bold;">Raz&oacute;n Social:</span>  <?php echo $row_propietario_02; ?></p>
                                    </div>
                                    <div class="col-md-3">
                                        <p class="card-text"><span style="font-weight:bold;">Tel&eacute;fono:</span>  <?php echo $row_propietario_04; ?></p>
                                    </div>
                                    <div class="col-md-3">
                                        <p class="card-text"><span style="font-weight:bold;">Email:</span> <?php echo $row_propietario_05; ?></p>
                                    </div>
                                </div>
                                <?php
        }
    }
?>
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
                                	<h4 class="col-6 card-title">&nbsp;</h4>
                                	<h4 class="col-6 card-title" style="text-align: right;">
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#existencia-animal"><i class="ti-plus"></i></button>
                                	</h4>
								</div>
                                <div class="table-responsive">
                                    <table id="tableLoadExistencia" class="table table-striped table-bordered">
                                        <thead id="tableExistencia" class="<?php echo $workCodigo; ?>">
                                            <tr>
                                                <th>ELIMINAR</th>
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
?>
                                            <tr>
                                                <td>
                                                    <button type="button" class="btn btn-success" onclick="deteleItem(<?php echo $workCodigo; ?>, 1100, <?php echo $row_existencia_10; ?>)"><i class="ti-trash"></i></button>
                                                </td>
                                                <td> <?php echo $row_existencia_01; ?> </td>
                                                <td> <?php echo $row_existencia_03; ?> </td>
                                                <td> <?php echo $row_existencia_05; ?> </td>
                                                <td> <?php echo $row_existencia_07; ?> </td>
                                                <td class="text-right"> <?php echo $row_existencia_08; ?> </td>
                                                <td class="text-right"> <?php echo $row_existencia_09; ?> </td>
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
                                                <th>ORIGEN</th>
                                                <th>RAZA</th>
                                                <th>CATEGOR&Iacute;A</th>
                                                <th>SUBCATEGOR&Iacute;A</th>
                                                <th>PESO PROMEDIO</th>
                                                <th>CANTIDAD</th>
                                            </tr>
                                            <tr style="background-color:rgba(0,0,0,0.05); font-weight: bold;">
                                                <th colspan="6">TOTAL ADULTO</th>
                                                <th style="text-align:right;"><?php echo number_format($exiTotAdu, 0, ',', '.'); ?></th>
                                            </tr>
                                            <tr style="font-weight: bold;">
                                                <th colspan="6">TOTAL TENERO</th>
                                                <th style="text-align:right;"><?php echo number_format($exiTotTer, 0, ',', '.'); ?></th>
                                            </tr>
                                            <tr style="background-color:rgba(0,0,0,0.05); font-weight: bold;">
                                                <th colspan="6">TOTAL POBLACI&Oacute;N BOVINA</th>
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
                                <div class="row">
                                	<h4 class="col-6 card-title">&nbsp;</h4>
                                	<h4 class="col-6 card-title" style="text-align: right;">
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#auditada-animal"><i class="ti-plus"></i></button>
                                	</h4>
								</div>
                                <div class="table-responsive">
                                    <table id="tableLoadAuditada" class="table table-striped table-bordered">
                                        <thead id="tableAuditada" class="<?php echo $workCodigo; ?>">
                                            <tr>
                                                <th>ELIMINAR</th>
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
            $row_auditada_00  = $auditadaArray['origen_codigo'];
            $row_auditada_01  = $auditadaArray['origen_nombre'];
            $row_auditada_02  = $auditadaArray['raza_codigo'];
            $row_auditada_03  = $auditadaArray['raza_nombre'];
            $row_auditada_04  = $auditadaArray['categoria_codigo'];
            $row_auditada_05  = $auditadaArray['categoria_nombre'];
            $row_auditada_06  = $auditadaArray['subcategoria_codigo'];
            $row_auditada_07  = $auditadaArray['subcategoria_nombre'];
            $row_auditada_08  = $auditadaArray['ot_auditada_cantidad'];
            $row_auditada_09  = $auditadaArray['ot_auditada_peso'];

            if ($row_auditada_04 == 40) {
                $audTotTer = $audTotTer + $row_auditada_09;
            } else {
                $audTotAdu = $audTotAdu + $row_auditada_09;
            }
?>
                                            <tr>
                                                <td>
                                                    <button type="button" class="btn btn-danger" onclick="deteleItem(<?php echo $workCodigo; ?>, 1200, <?php echo $row_existencia_10; ?>)"><i class="ti-trash"></i></button>
                                                </td>
                                                <td> <?php echo $row_auditada_01; ?> </td>
                                                <td> <?php echo $row_auditada_03; ?> </td>
                                                <td> <?php echo $row_auditada_05; ?> </td>
                                                <td> <?php echo $row_auditada_07; ?> </td>
                                                <td class="text-right"> <?php echo $row_auditada_08; ?></td>
                                                <td class="text-right"> <?php echo $row_auditada_09; ?> </td>
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
                                                <th>ORIGEN</th>
                                                <th>RAZA</th>
                                                <th>CATEGOR&Iacute;A</th>
                                                <th>SUBCATEGOR&Iacute;A</th>
                                                <th>PESO PROMEDIO</th>
                                                <th>CANTIDAD</th>
                                            </tr>
                                            <tr style="background-color:rgba(0,0,0,0.05); font-weight: bold;">
                                                <th colspan="6">TOTAL ADULTO</th>
                                                <th style="text-align:right;"><?php echo number_format($audTotAdu, 0, ',', '.'); ?></th>
                                            </tr>
                                            <tr style="font-weight: bold;">
                                                <th colspan="6">TOTAL TENERO</th>
                                                <th style="text-align:right;"><?php echo number_format($audTotTer, 0, ',', '.'); ?></th>
                                            </tr>
                                            <tr style="background-color:rgba(0,0,0,0.05); font-weight: bold;">
                                                <th colspan="6">TOTAL POBLACI&Oacute;N BOVINA</th>
                                                <th style="text-align:right;"><?php echo number_format($audTotGen, 0, ',', '.'); ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div id="existencia-animal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="existenciaAnimal" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="existenciaAnimal">Agregar Animal</h4>
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

                <div class="row">
                    <div id="auditada-animal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="auditadaAnimal" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="auditadaAnimal">Agregar Animal</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal form-material" method="post" action="../class/crud/ot_auditada_a.php">
                                        <div class="form-group">
                                            <input id="workCodigo" name="workCodigo" class="form-control" type="hidden" placeholder="Codigo" value="<?php echo $workCodigo; ?>" required readonly>
                                            <input id="workModo" name="workModo" class="form-control" type="hidden" placeholder="Modo" value="C" required readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="auditadaPotrero">Secci&oacute;n - Potrero</label>
                                            <select id="auditadaPotrero" name="auditadaPotrero" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?>>
                                                <optgroup label="Secci&oacute;n - Potrero">
<?php
    if ($potreroJSON['code'] == 200) {
        foreach ($potreroJSON['data'] as $potreroKey=>$potreroArray) {
            $row_potrero_00          	= $potreroArray['potrero_codigo'];
            $row_potrero_01          	= $potreroArray['estado_potrero_codigo'];
            $row_potrero_02          	= $potreroArray['seccion_nombre'];
            $row_potrero_03          	= $potreroArray['potrero_nombre'];
            $selectedTipo 			= '';

            if ($row_potrero_01 == 1) {
?>
												    <option value="<?php echo $row_potrero_00; ?>"><?php echo $row_potrero_02 .' - '.$row_potrero_03; ?></option>
<?php
            }
        }
    }
?>
												</optgroup>
								            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="auditadaOrigen">Origen</label>
                                            <select id="auditadaOrigen" name="auditadaOrigen" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?>>
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
                                            <label for="auditadaRaza">Raza</label>
                                            <select id="auditadaRaza" name="auditadaRaza" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?>>
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
                                            <label for="auditadaCategoria">Categor&iacute;as - SubCategor&iacute;as</label>
                                            <select id="auditadaCategoria" name="auditadaCategoria" class="select2 form-control custom-select" style="width: 100%; height:36px;">
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
                                            <label for="auditadaFecha">Fecha</label>
                                            <input id="auditadaFecha" name="auditadaFecha" class="form-control" type="date" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="auditadaCantidad">Cantidad</label>
                                            <input id="auditadaCantidad" name="auditadaCantidad" class="form-control" type="number" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="auditadaPesoPromedio">Peso Promedio</label>
                                            <input id="auditadaPesoPromedio" name="auditadaPesoPromedio" class="form-control" type="number" step=".01">
                                        </div>
                                        <div class="form-group">
                                            <label for="auditadaObservacion">Observaci&oacute;n</label>
                                            <textarea id="auditadaObservacion" name="auditadaObservacion" class="form-control" rows="5"></textarea>
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