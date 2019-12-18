<?php
    require '../class/function/curl_api.php';
    require '../class/function/function.php';
    require '../class/session/session_system.php';

    if (isset($_GET['code'])){
        $codeRest 		= $_GET['code'];
    } else {
        $codeRest 		= '';
    }

    if (isset($_GET['msg'])){
        $msgRest 		= $_GET['msg'];
    } else {
        $msgRest 		= '';
    }

    if (isset($_GET['codigo'])){
        $workCodigo     = $_GET['codigo'];
    } else {
        $workCodigo     = '';
    }

    if (isset($_GET['mode'])){
        $workModo 		= $_GET['mode'];
    } else {
        $workModo 		= '';
    }

    $dominioJSON		        = get_curl('500');
    $subdominioJSON		        = get_curl('600/dominio/CATEGORIASUBCATEGORIA');
    $establecimientoJSON		= get_curl('700');
    $propietarioJSON            = get_curl('1400');
    $row_05                     = getOT();

	if ($workCodigo <> 0){
		$dataJSON			= get_curl('1000/'.$workCodigo);

		if ($dataJSON['code'] == 200){
            $row_00			= $dataJSON['data'][0]['ot_codigo'];
			$row_01			= $dataJSON['data'][0]['estado_ot_codigo'];
			$row_02			= $dataJSON['data'][0]['establecimiento_codigo'];
            $row_05			= $dataJSON['data'][0]['ot_numero'];
			$row_06			= $dataJSON['data'][0]['ot_fecha_inicio_trabajo'];
			$row_07			= $dataJSON['data'][0]['ot_fecha_final_trabajo'];
			$row_08			= $dataJSON['data'][0]['ot_observacion'];
		}
    }
    
    if(!isset($row_00)){
        $row_00			= '';
        $row_01			= 73;
        $row_02			= '';
        $row_06			= '';
        $row_07			= '';
        $row_08			= '';
    }

	switch($workModo){
		case 'C':
			$workReadonly	= '';
			$workATitulo	= 'Agregar';
			$workAStyle		= 'btn-info';
			break;
		case 'R':
			$workReadonly	= 'disabled';
			$workATitulo	= 'Ver';
			$workAStyle		= 'btn-primary';
			break;
		case 'U':
			$workReadonly	= '';
			$workATitulo	= 'Actualizar';
			$workAStyle		= 'btn-success';
			break;
		case 'D':
			$workReadonly	= 'disabled';
			$workATitulo	= 'Eliminar';
			$workAStyle		= 'btn-danger';
			break;
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
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-5 align-self-center">
                        <h4 class="page-title">Mantenimiento</h4>
                        <div class="d-flex align-items-center"></div>
                    </div>
                    <div class="col-7 align-self-center">
                        <div class="d-flex no-block justify-content-end align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="../public/home.php">Home</a>
                                    </li>
                                    <li class="breadcrumb-item" aria-current="page">
                                        <a href="../public/ot_l.php">Orden de Trabajo</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Mantenimiento</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
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
                <!-- row -->
                <div class="row">
                    <form id="form" data-parsley-validate class="m-t-30" style="width:100%;" method="post" action="../class/crud/ot_a.php">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Orden de Trabajo</h4>
                                	<div class="form-group">
                                        <input type="hidden" class="form-control" id="workCodigo" name="workCodigo" value="<?php echo $workCodigo; ?>" placeholder="Codigo" required readonly>
                                        <input type="hidden" class="form-control" id="workModo" name="workModo" value="<?php echo $workModo; ?>" placeholder="Modo" required readonly>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <label for="var001">Orden de Trabajo</label>
                                                <input type="text" class="form-control" id="var001" name="var001" value="<?php echo $row_05; ?>" style="width:100%; height:40px;" placeholder="O.T." required readonly>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <label for="var002">Estado</label>
                                		        <select class="select2 form-control custom-select" id="var002" name="var002" style="width:100%; height:40px;" required disabled>
													<optgroup label="Estado">
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_estado_00          	= $dominioArray['estado_dominio_codigo'];
            $row_estado_01          	= $dominioArray['dominio_codigo'];
            $row_estado_02          	= $dominioArray['dominio_nombre'];
            $row_estado_03          	= $dominioArray['dominio_valor'];
            $row_estado_04         	    = $dominioArray['dominio_observacion'];
            $selectedEstado 			= '';

            if ($row_estado_00 == 1 && $row_estado_03 == 'ORDENTRABAJOESTADO') {
                if ($row_01 == $row_estado_01){
                    $selectedEstado = 'selected';
                }
?>
														<option value="<?php echo $row_estado_01; ?>" <?php echo $selectedEstado; ?>><?php echo $row_estado_02; ?></option>
<?php
            }
        }
    }
?>
													</optgroup>
												</select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <label for="var003">Fecha Inicio O.T.</label>
                                                <input type="date" class="form-control" id="var003" name="var003" value="<?php echo $row_06; ?>" style="width:100%; height:40px;" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <label for="var004">Fecha Final O.T.</label>
                                                <input type="date" class="form-control" id="var004" name="var004" value="<?php echo $row_07; ?>" style="width:100%; height:40px;">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <label for="var005">Establecimiento</label>
                                                <select class="select2 form-control custom-select" id="var005" name="var005" onblur="loadPropietario(1);" style="width:100%; height:40px;">
                                                    <optgroup label="Establecimiento">
<?php
    if ($establecimientoJSON['code'] == 200) {
        foreach ($establecimientoJSON['data'] as $detalleKey=>$detalleArray) {
            $row_establecimiento_00          	= $detalleArray['establecimiento_codigo'];
            $row_establecimiento_01          	= $detalleArray['establecimiento_nombre'];
            $selected 				            = '';
            
            if ($row_02 == $row_establecimiento_00){
                $selected = 'selected';
            }
?>
                                                        <option value="<?php echo $row_establecimiento_00; ?>" <?php echo $selected; ?>><?php echo $row_establecimiento_01; ?></option>
<?php
        }
    }
?>
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <label for="var006">Administrador/Responsable</label>
                                                <select class="select2 form-control custom-select" id="var006" name="var006" style="width:100%; height:40px;">
                                                    <optgroup label="Establecimiento">
<?php
    if ($establecimientoJSON['code'] == 200) {
        foreach ($establecimientoJSON['data'] as $detalleKey=>$detalleArray) {
            $row_establecimiento_00          	= $detalleArray['establecimiento_codigo'];
            $row_establecimiento_01          	= $detalleArray['establecimiento_nombre'];
            $selected 				            = '';
            
            if ($row_02 == $row_establecimiento_00){
                $selected = 'selected';
            }
?>
                                                        <option value="<?php echo $row_establecimiento_00; ?>" <?php echo $selected; ?>><?php echo $row_establecimiento_01; ?></option>
<?php
        }
    }
?>
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <label for="var007">Certificador/Auditor</label>
                                                <select class="select2 form-control custom-select" id="var007" name="var007" style="width:100%; height:40px;">
                                                    <optgroup label="Establecimiento">
<?php
    if ($establecimientoJSON['code'] == 200) {
        foreach ($establecimientoJSON['data'] as $detalleKey=>$detalleArray) {
            $row_establecimiento_00          	= $detalleArray['establecimiento_codigo'];
            $row_establecimiento_01          	= $detalleArray['establecimiento_nombre'];
            $selected 				            = '';
            
            if ($row_02 == $row_establecimiento_00){
                $selected = 'selected';
            }
?>
                                                        <option value="<?php echo $row_establecimiento_00; ?>" <?php echo $selected; ?>><?php echo $row_establecimiento_01; ?></option>
<?php
        }
    }
?>
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <label for="var008">Template de Carga</label>
                                                <select class="select2 form-control custom-select" id="var008" name="var008" style="width:100%; height:40px;">
                                                    <optgroup label="Template">
                                                        <option value="1"> Template 01</option>
                                                        <option value="2"> Template 02</option>
                                                        <option value="3"> Template 03</option>
                                                        <option value="4"> Template 04</option>
                                                        <option value="5"> Template 05</option>
                                                        <option value="6"> Template 06</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">VACUNACI&Oacute;N</h4>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th scope="col">VACUNACI&Oacute;N</th>
                                                            <th scope="col">CATEGOR&Iacute;A - SUB-CATEGOR&Iacute;A</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr style="height:72px;">
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="var101_1" name="var101_1" >
                                                                    <label class="custom-control-label" for="var101_1">ANTIAFTOSA</label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <select class="select2 form-control custom-select" id="var101_2" name="var101_2" style="width:100%; height:40px;" required>
<?php 
    if ($dominioJSON['code'] == 200) { 
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) { 
            $row_dominio_00 = $dominioArray['dominio_codigo']; 
            $row_dominio_01 = $dominioArray['estado_dominio_codigo']; 
            $row_dominio_02 = $dominioArray['dominio_nombre']; 
            $row_dominio_03 = $dominioArray['dominio_valor']; 
            
            if ($row_dominio_01 == 1 && $row_dominio_03 == 'ANIMALCATEGORIA') { 
?>
                                                                    <optgroup label="<?php echo $row_dominio_02; ?>"> 
<?php 
                if ($subdominioJSON['code'] == 200) { 
                    foreach ($subdominioJSON['data'] as $dominio_subKey=>$dominio_subArray) { 
                        $row_dominio_sub_00 = $dominio_subArray['tipo_subtipo_codigo']; 
                        $row_dominio_sub_01 = $dominio_subArray['estado_tipo_subtipo_codigo']; 
                        $row_dominio_sub_02 = $dominio_subArray['estado_tipo_subtipo_nombre']; 
                        $row_dominio_sub_03 = $dominio_subArray['subtipo_codigo']; 
                        $row_dominio_sub_04 = $dominio_subArray['subtipo_nombre']; 
                        $row_dominio_sub_05 = $dominio_subArray['tipo_codigo']; 
                        $row_dominio_sub_06 = $dominio_subArray['tipo_nombre']; 
                        
                        if ($row_dominio_00 == $row_dominio_sub_05) {
?> 
                                                                        <option value="<?php echo $row_dominio_sub_00; ?>"><?php echo $row_dominio_sub_06.' - '.$row_dominio_sub_04; ?></option>
<?php 
                        } 
                    } 
                } 
?>                                                                  </optgroup> 
<?php 
            } 
        } 
    }
?>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr style="height:72px;">
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="var102_1" name="var102_1" >
                                                                    <label class="custom-control-label" for="var102_1">BRUSELOSIS RB51</label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <select class="select2 form-control custom-select" id="var102_2" name="var102_2" style="width:100%; height:40px;" required>
<?php 
    if ($dominioJSON['code'] == 200) { 
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) { 
            $row_dominio_00 = $dominioArray['dominio_codigo']; 
            $row_dominio_01 = $dominioArray['estado_dominio_codigo']; 
            $row_dominio_02 = $dominioArray['dominio_nombre']; 
            $row_dominio_03 = $dominioArray['dominio_valor']; 
            
            if ($row_dominio_01 == 1 && $row_dominio_03 == 'ANIMALCATEGORIA') { 
?>
                                                                    <optgroup label="<?php echo $row_dominio_02; ?>"> 
<?php 
                if ($subdominioJSON['code'] == 200) { 
                    foreach ($subdominioJSON['data'] as $dominio_subKey=>$dominio_subArray) { 
                        $row_dominio_sub_00 = $dominio_subArray['tipo_subtipo_codigo']; 
                        $row_dominio_sub_01 = $dominio_subArray['estado_tipo_subtipo_codigo']; 
                        $row_dominio_sub_02 = $dominio_subArray['estado_tipo_subtipo_nombre']; 
                        $row_dominio_sub_03 = $dominio_subArray['subtipo_codigo']; 
                        $row_dominio_sub_04 = $dominio_subArray['subtipo_nombre']; 
                        $row_dominio_sub_05 = $dominio_subArray['tipo_codigo']; 
                        $row_dominio_sub_06 = $dominio_subArray['tipo_nombre']; 
                        
                        if ($row_dominio_00 == $row_dominio_sub_05) {
?> 
                                                                        <option value="<?php echo $row_dominio_sub_00; ?>"><?php echo $row_dominio_sub_06.' - '.$row_dominio_sub_04; ?></option>
<?php 
                        } 
                    } 
                } 
?>                                                                  </optgroup> 
<?php 
            } 
        } 
    }
?>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr style="height:72px;">
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="var103_1" name="var103_1" >
                                                                    <label class="custom-control-label" for="var103_1">ANTIRABIA</label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <select class="select2 form-control custom-select" id="var103_2" name="var103_2" style="width:100%; height:40px;" required>
<?php 
    if ($dominioJSON['code'] == 200) { 
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) { 
            $row_dominio_00 = $dominioArray['dominio_codigo']; 
            $row_dominio_01 = $dominioArray['estado_dominio_codigo']; 
            $row_dominio_02 = $dominioArray['dominio_nombre']; 
            $row_dominio_03 = $dominioArray['dominio_valor']; 
            
            if ($row_dominio_01 == 1 && $row_dominio_03 == 'ANIMALCATEGORIA') { 
?>
                                                                    <optgroup label="<?php echo $row_dominio_02; ?>"> 
<?php 
                if ($subdominioJSON['code'] == 200) { 
                    foreach ($subdominioJSON['data'] as $dominio_subKey=>$dominio_subArray) { 
                        $row_dominio_sub_00 = $dominio_subArray['tipo_subtipo_codigo']; 
                        $row_dominio_sub_01 = $dominio_subArray['estado_tipo_subtipo_codigo']; 
                        $row_dominio_sub_02 = $dominio_subArray['estado_tipo_subtipo_nombre']; 
                        $row_dominio_sub_03 = $dominio_subArray['subtipo_codigo']; 
                        $row_dominio_sub_04 = $dominio_subArray['subtipo_nombre']; 
                        $row_dominio_sub_05 = $dominio_subArray['tipo_codigo']; 
                        $row_dominio_sub_06 = $dominio_subArray['tipo_nombre']; 
                        
                        if ($row_dominio_00 == $row_dominio_sub_05) {
?> 
                                                                        <option value="<?php echo $row_dominio_sub_00; ?>"><?php echo $row_dominio_sub_06.' - '.$row_dominio_sub_04; ?></option>
<?php 
                        } 
                    } 
                } 
?>                                                                  </optgroup> 
<?php 
            } 
        } 
    }
?>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">INVENTARIO DEL HATO POR</h4>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th scope="col">TIPO</th>
                                                            <th scope="col">TIPO</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr style="height:72px;">
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="var201" name="var201">
                                                                    <label class="custom-control-label" for="var201">PROPIETARIO</label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="var202" name="var202">
                                                                    <label class="custom-control-label" for="var202">ORIGEN</label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr style="height:72px;">
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="var203" name="var203">
                                                                    <label class="custom-control-label" for="var203">RAZA</label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="var204" name="var204">
                                                                    <label class="custom-control-label" for="var204">CATEGOR&Iacute;A - SUBCATEGOR&Iacute;A</label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr style="height:72px;">
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="var205" name="var205">
                                                                    <label class="custom-control-label" for="var205">PESO PROMEDIO</label>
                                                                </div>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <h4 class="col-2 card-title">POBLACI&Oacute;N BOVINA DETALLE</h4>
                                                <h4 class="col-10 card-title" style="text-align: right;">
                                                    <button type="submit" id="addRow" class="btn btn-info"> <i class="ti-plus"></i> Agregar Item </button>
                                                </h4>
                                            </div>
                                            <div class="table-responsive">
                                                <table id="tableDetalle" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>ELIMINAR</th>
                                                            <th>PROPIETARIO</th>
                                                            <th>ORIGEN</th>
                                                            <th>RAZA</th>
                                                            <th>CATEGOR&Iacute;A - SUBCATEGOR&Iacute;A</th>
                                                            <th>PESO PROMEDIO</th>
                                                            <th>CANTIDAD</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <h4 class="col-2 card-title">POBLACI&Oacute;N BOVINA TOTAL</h4>
                                            </div>
                                            <div class="table-responsive">
                                                <table id="tableTotal" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-left">CATEGORÍA</th>
                                                            <th class="text-center">DESMAMANTE</th>
                                                            <th class="text-center">VAQUILLA</th>
                                                            <th class="text-center">VACA</th>
                                                            <th class="text-center">NOVILLO</th>
                                                            <th class="text-center">SE&Ntilde;UELO</th>
                                                            <th class="text-center">BUEY</th>
                                                            <th class="text-center">TORO</th>
                                                            <th class="text-center">TOTAL ADULTO</th>
                                                            <th class="text-center">TOTAL TERNERO</th>
                                                            <th class="text-center">TOTAL</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-left">CANTIDAD</td>
                                                            <td id="tot01" class="text-center">0</td>
                                                            <td id="tot02" class="text-center">0</td>
                                                            <td id="tot03" class="text-center">0</td>
                                                            <td id="tot04" class="text-center">0</td>
                                                            <td id="tot05" class="text-center">0</td>
                                                            <td id="tot06" class="text-center">0</td>
                                                            <td id="tot07" class="text-center">0</td>
                                                            <td id="tot08" class="text-center">0</td>
                                                            <td id="tot09" class="text-center">0</td>
                                                            <td id="tot10" class="text-center">0</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
<!--
                                    <div class="form-group">
                                    	<label for="otObservacion">Observaci&oacute;n</label>
                                    	<textarea id="otObservacion" name="otObservacion" class="form-control" rows="5" <?php echo $workReadonly; ?>><?php echo $row_08; ?></textarea>
                                	</div>

                                    <button type="submit" class="btn <?php echo $workAStyle; ?>" <?php echo $workReadonly; ?>><?php echo $workATitulo; ?></button>
                                    <a role="button" class="btn btn-dark" href="../public/ot_l.php">Volver</a>
-->
                    </form>
                </div>
                <!-- row -->
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
        $(document).ready(function() {
            var tabDat = $('#tableDetalle').DataTable({
                "paging":   false,
                "ordering": false,
                "searching": false,
                "info":     false
            });
            var colCod = 1;
            
            $('#addRow').on('click', function () {
                tabDat.row.add([
                    "<td><button id='var300_"+ colCod +"' type='button' class='btn btn-danger'><i class='ti-trash'></i></button></td>",
                    "<td><select id='var301_"+ colCod +"' name='var301_"+ colCod +"' onblur='sumaTotal();' class='select2 form-control custom-select' style='width:100%; height:40px;' required></select></td>",
                    "<td><select id='var302_"+ colCod +"' name='var302_"+ colCod +"' onblur='sumaTotal();' class='select2 form-control custom-select' style='width:100%; height:40px;' required></select></td>",
                    "<td><select id='var303_"+ colCod +"' name='var303_"+ colCod +"' onblur='sumaTotal();' class='select2 form-control custom-select' style='width:100%; height:40px;' required></select></td>",
                    "<td><select id='var304_"+ colCod +"' name='var304_"+ colCod +"' onblur='sumaTotal();' class='select2 form-control custom-select' style='width:100%; height:40px;' required></select></td>",
                    "<td><input  id='var305_"+ colCod +"' name='var305_"+ colCod +"' onblur='sumaTotal();' class='form-control' type='number' step='.01' value='0' style='width:100%; height:40px;'></td>",
                    "<td><input  id='var306_"+ colCod +"' name='var306_"+ colCod +"' onblur='sumaTotal();' class='form-control' type='number' min='1' required></td>"
                ]).draw(true);
                
                loadPropietario(colCod);
                loadOrigen(colCod);
                loadRaza(colCod);
                loadCategoria(colCod);

                colCod++;
            });

            $('#tableDetalle').on('click', '.btn-danger', function() {
                tabDat.row($(this).parents('tr')).remove().draw(false);
            });

            $('#addRow').click(); 
        } );

        function loadPropietario(rowInd) {
            var xDATA   = '<?php echo json_encode($propietarioJSON['data']); ?>';
            var xJSON   = JSON.parse(xDATA);
            var colEst  = document.getElementById('var005');
            var xSELC   = document.getElementById('var301_'+rowInd);

            while (xSELC.length > 0) {
                xSELC.remove(0);
            }
            
            xJSON.forEach(element => {
                if (colEst.value == element.establecimiento_codigo) {
                    var option      = document.createElement('option');
                    option.value    = element.establecimiento_propietario_codigo;
                    option.text     = element.establecimiento_propietario_marca;                    
                    xSELC.add(option, null);
                }
            });
        }

        function loadOrigen(rowInd) {
            var xDATA   = '<?php echo json_encode($dominioJSON['data']); ?>';
            var xJSON   = JSON.parse(xDATA);
            var xSELC   = document.getElementById('var302_'+rowInd);

            while (xSELC.length > 0) {
                xSELC.remove(0);
            }
            
            xJSON.forEach(element => {
                if (element.estado_dominio_codigo == 1 && element.dominio_valor == 'ANIMALORIGEN') {
                    var option      = document.createElement('option');
                    option.value    = element.dominio_codigo;
                    option.text     = element.dominio_nombre;

                    if (element.dominio_codigo == 20){
                        option.selected = true;
                    } else {
                        option.selected = false;
                    }

                    xSELC.add(option, null);
                }
            });
        }

        function loadRaza(rowInd) {
            var xDATA   = '<?php echo json_encode($dominioJSON['data']); ?>';
            var xJSON   = JSON.parse(xDATA);
            var xSELC   = document.getElementById('var303_'+rowInd);

            while (xSELC.length > 0) {
                xSELC.remove(0);
            }
            
            xJSON.forEach(element => {
                if (element.estado_dominio_codigo == 1 && element.dominio_valor == 'ANIMALRAZA') {
                    var option      = document.createElement('option');
                    option.value    = element.dominio_codigo;
                    option.text     = element.dominio_nombre;

                    if (element.dominio_codigo == 86){
                        option.selected = true;
                    } else {
                        option.selected = false;
                    }

                    xSELC.add(option, null);
                }
            });
        }

        function loadCategoria(rowInd) {
            var xDATA   = '<?php echo json_encode($dominioJSON['data']); ?>';
            var xDATA1  = '<?php echo json_encode($subdominioJSON['data']); ?>';
            var xJSON   = JSON.parse(xDATA);
            var xJSON1  = JSON.parse(xDATA1);
            var xSELC   = document.getElementById('var304_'+rowInd);

            while (xSELC.length > 0) {
                xSELC.remove(0);
            }
            
            xJSON.forEach(element => {
                if (element.estado_dominio_codigo == 1 && element.dominio_valor == 'ANIMALCATEGORIA') {
                    var optgroup    = document.createElement('optgroup');
                    optgroup.label  = element.dominio_nombre;

                    xJSON1.forEach(element1 => {
                        if (element.dominio_codigo == element1.tipo_codigo) {
                            var option      = document.createElement('option');
                            option.value    = element.dominio_codigo + '_' + element1.subtipo_codigo;
                            option.text     = element.dominio_nombre + ' - ' + element1.subtipo_nombre;

                            optgroup.appendChild(option);
                        }
                    });

                    xSELC.add(optgroup, null);
                }
            });
        }

        function sumaTotal() {
            var rowTotDes   = document.getElementById("tot01");
            var rowTotVaq   = document.getElementById("tot02");
            var rowTotVac   = document.getElementById("tot03");
            var rowTotNov   = document.getElementById("tot04");
            var rowTotSen   = document.getElementById("tot05");
            var rowTotBue   = document.getElementById("tot06");
            var rowTotTor   = document.getElementById("tot07");
            var rowTotAdu   = document.getElementById("tot08");
            var rowTotTer   = document.getElementById("tot09");
            var rowTotGen   = document.getElementById("tot10");

            var totDes      = 0;
            var totVaq      = 0;
            var totVac      = 0;
            var totNov      = 0;
            var totSen      = 0;
            var totBue      = 0;
            var totTor      = 0;
            var totAdu      = 0;
            var totTer      = 0;
            var totGen      = 0;

            for (let index = 1; index < 100; index++) {
                var existeSiNo = isInPage(document.getElementById("var304_"+index));

                if (existeSiNo != false) {
                    var rowCate = Number(document.getElementById("var304_"+index).value);
                    var rowCant = Number(document.getElementById("var305_"+index).value);
                    var rowPos  = rowCate.search('_');
                    rowCate     = rowCate.substr(rowPos);

                    console.log(rowCate);

                    if (rowCate == 29 || rowCate == 30) {
                        totTer = totTer + rowCant;
                    } else {
                        totAdu = totAdu + rowCant;
                    }

                    totCan = index;
                }
            }

            rowTotCan.value     = totCan;
            totPob              = totTer + totAdu;
            rowTotAdu.innerHTML = totAdu;
            rowTotTer.innerHTML = totTer;
            rowTotGen.innerHTML = totPob;
        }

        function isInPage(node) {
            return (node === document.body) ? false : document.body.contains(node);
        }
    </script>
</body>
</html>