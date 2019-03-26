<?php
    require '../class/function/curl_api.php';
    require '../class/function/function.php';
    require '../class/session/session_system.php';

	$workCodigo 	    = $_GET['codigo'];
    $workModo 		    = $_GET['mode'];
    $codeRest           = $_GET['code'];
    $msgRest            = $_GET['msg'];
    $paisJSON		    = get_curl('100');
    $departamentoJSON	= get_curl('200');

	if ($workCodigo <> 0){
		$dataJSON			= get_curl('300/'.$workCodigo);

		if ($dataJSON['code'] == 200){
			$row_01			= $dataJSON['data'][0]['estado_distrito_codigo'];
			$row_02			= $dataJSON['data'][0]['pais_codigo'];
			$row_03			= $dataJSON['data'][0]['pais_nombre'];
			$row_04			= $dataJSON['data'][0]['pais_observacion'];
			$row_05			= $dataJSON['data'][0]['departamento_codigo'];
			$row_06			= $dataJSON['data'][0]['departamento_nombre'];
			$row_07			= $dataJSON['data'][0]['departamento_observacion'];
			$row_08			= $dataJSON['data'][0]['distrito_codigo'];
			$row_09			= $dataJSON['data'][0]['distrito_nombre'];
			$row_10			= $dataJSON['data'][0]['distrito_observacion'];
			
			if ($row_01 == 1){
				$row_01_h = 'selected';
				$row_01_d = '';
			}else{
				$row_01_h = '';
				$row_01_d = 'selected';
			}
		}
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
                                        <a href="../public/localidad_distrito_l.php">Localidad Distrito</a>
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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Localidad Distrito</h4>
                                <form id="form" data-parsley-validate class="m-t-30" method="post" action="../class/crud/localidad_distrito_a.php">
                                	<div class="form-group">
                                        <input id="workCodigo" name="workCodigo" class="form-control" type="hidden" placeholder="Codigo" value="<?php echo $workCodigo; ?>" required readonly>
                                        <input id="workModo" name="workModo" class="form-control" type="hidden" placeholder="Modo" value="<?php echo $workModo; ?>" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="distritoEstado">Estado</label>
                                		<select id="distritoEstado" name="distritoEstado" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?>>
                                    		<optgroup label="Estado">
                                        		<option value="1" <?php echo $row_01_h; ?>>Habilitado</option>
                                        		<option value="2" <?php echo $row_01_d; ?>>Deshabilitado</option>
                                    		</optgroup>
                                		</select>
                                    </div>
                                    <div class="form-group">
                                        <label for="distritoDepartamento">Pa&iacute;s - Departamento</label>
                                		<select id="distritoDepartamento" name="distritoDepartamento" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?>>
<?php
    if ($paisJSON['code'] == 200) {
        foreach ($paisJSON['data'] as $paisKey=>$paisArray) {
            $row_pais_00      	= $paisArray['pais_codigo'];
			$row_pais_01      	= $paisArray['pais_nombre'];			
?>
                                  			<optgroup label="<?php echo $row_pais_01; ?>">
								
<?php
    if ($departamentoJSON['code'] == 200) {
        foreach ($departamentoJSON['data'] as $departamentoKey=>$departamentoArray) {
            $row_departamento_00      	= $departamentoArray['departamento_codigo'];
			$row_departamento_01      	= $departamentoArray['pais_codigo'];
            $row_departamento_02      	= $departamentoArray['departamento_nombre'];
			
			if ($row_pais_00 == $row_departamento_01) {
				$selected			= '';
				if ($row_05 == $row_departamento_00){
					$selected 		= 'selected';
				}
?>
												<option value="<?php echo $row_departamento_00; ?>" <?php echo $selected; ?>><?php echo $row_departamento_02; ?></option>
<?php
			}
		}
	}
?>
                                    		</optgroup>
<?php
		}
	}
?>
                                		</select>
                                    </div>
                                    <div class="form-group">
                                        <label for="distritoNombre">Distrito</label>
                                        <input id="distritoNombre" name="distritoNombre" class="form-control" type="text" placeholder="Nombre" value="<?php echo $row_09; ?>" required <?php echo $workReadonly; ?>>
                                    </div>
                                    <div class="form-group">
                                    	<label for="distritoObservacion">Observaci&oacute;n</label>
                                    	<textarea id="distritoObservacion" name="distritoObservacion" class="form-control" rows="5" <?php echo $workReadonly; ?>><?php echo $row_10; ?></textarea>
                                	</div>
                                    <button type="submit" class="btn <?php echo $workAStyle; ?>" <?php echo $workReadonly; ?>><?php echo $workATitulo; ?></button>
                                    <a role="button" class="btn btn-dark" href="../public/localidad_distrito_l.php">Volver</a>
                                </form>
                            </div>
                        </div>
                    </div>
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