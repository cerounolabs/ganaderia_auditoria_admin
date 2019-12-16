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
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="var005">Establecimiento</label>
                                                <select class="select2 form-control custom-select" id="var005" name="var005" style="width:100%; height:40px;">
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
                                                        <tr>
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
                                                        <tr>
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
                                                        <tr>
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
                                                        <tr>
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
                                                        <tr>
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
                                                        <tr>
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
</body>
</html>