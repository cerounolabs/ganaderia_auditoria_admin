<?php
    require '../class/session/session_system.php';
    require '../class/function/curl_api.php';
    require '../class/function/function.php';

    $dominioJSON		        = get_curl('500');
    $establecimientoJSON		= get_curl('700');
	$workCodigo 	            = $_GET['codigo'];
	$workModo 		            = $_GET['mode'];
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
	
	<title>Panel Administrador - Orden de Trabajo</title>
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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Orden de Trabajo</h4>
                                <form id="form" data-parsley-validate class="m-t-30" method="post" action="../class/crud/ot_a.php">
                                	<div class="form-group">
                                        <input id="workCodigo" name="workCodigo" class="form-control" type="hidden" placeholder="Codigo" value="<?php echo $workCodigo; ?>" required readonly>
                                        <input id="workModo" name="workModo" class="form-control" type="hidden" placeholder="Modo" value="<?php echo $workModo; ?>" required readonly>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="otEstado">Estado</label>
                                		        <select id="otEstado" name="otEstado" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?>>
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="otNumero">Orden de Trabajo</label>
                                                <input id="otNumero" name="otNumero" class="form-control" type="text" placeholder="O.T." value="<?php echo $row_05; ?>" required readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="otFechaInicio">Fecha Inicio O.T.</label>
                                                <input id="otFechaInicio" name="otFechaInicio" class="form-control" type="date" placeholder="Nombre" value="<?php echo $row_06; ?>" required <?php echo $workReadonly; ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="otFechaFinal">Fecha Final O.T.</label>
                                                <input id="otFechaFinal" name="otFechaFinal" class="form-control" type="date" placeholder="Nombre" value="<?php echo $row_07; ?>" <?php echo $workReadonly; ?>>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="otEstablecimiento">Establecimiento</label>
                                		<select id="otEstablecimiento" name="otEstablecimiento" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?>>
                                    		<optgroup label="Pa&iacute;s">
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
                                    <div class="form-group">
                                    	<label for="otObservacion">Observaci&oacute;n</label>
                                    	<textarea id="otObservacion" name="otObservacion" class="form-control" rows="5" <?php echo $workReadonly; ?>><?php echo $row_08; ?></textarea>
                                	</div>
                                    <button type="submit" class="btn <?php echo $workAStyle; ?>" <?php echo $workReadonly; ?>><?php echo $workATitulo; ?></button>
                                    <a role="button" class="btn btn-dark" href="../public/ot_l.php">Volver</a>
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
</body>
</html>