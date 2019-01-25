<?php
    require '../class/session/session_system.php';
    require '../class/function/curl_api.php';
    require '../class/function/function.php';

    $establecimientoJSON    = get_curl('700');
    $seccionJSON		    = get_curl('800');
	$workCodigo 	        = $_GET['codigo'];
	$workModo               = $_GET['mode'];

	if ($workCodigo <> 0){
		$dataJSON			= get_curl('900/'.$workCodigo);

		if ($dataJSON['code'] == 200){
            $row_01			= $dataJSON['data'][0]['estado_potrero_codigo'];
            $row_02			= $dataJSON['data'][0]['establecimiento_codigo'];
            $row_03			= $dataJSON['data'][0]['establecimiento_nombre'];
			$row_04			= $dataJSON['data'][0]['establecimiento_observacion'];
			$row_05			= $dataJSON['data'][0]['seccion_codigo'];
            $row_06			= $dataJSON['data'][0]['seccion_nombre'];
			$row_07			= $dataJSON['data'][0]['seccion_observacion'];
			$row_08			= $dataJSON['data'][0]['potrero_codigo'];
			$row_09			= $dataJSON['data'][0]['potrero_nombre'];
			$row_10			= $dataJSON['data'][0]['potrero_observacion'];
			
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
	
	<title>Panel Administrador - Establecimiento Potrero</title>
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
                                        <a href="../public/establecimiento_potrero_l.php">Establecimiento Potrero</a>
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
                                <h4 class="card-title">Establecimiento Potrero</h4>
                                <form id="form" data-parsley-validate class="m-t-30" method="post" action="../class/crud/establecimiento_potrero_a.php">
                                	<div class="form-group">
                                        <input id="workCodigo" name="workCodigo" class="form-control" type="hidden" placeholder="Codigo" value="<?php echo $workCodigo; ?>" required readonly>
                                        <input id="workModo" name="workModo" class="form-control" type="hidden" placeholder="Modo" value="<?php echo $workModo; ?>" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="potreroEstado">Estado</label>
                                		<select id="potreroEstado" name="potreroEstado" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?>>
                                    		<optgroup label="Estado">
                                        		<option value="1" <?php echo $row_01_h; ?>>Habilitado</option>
                                        		<option value="2" <?php echo $row_01_d; ?>>Deshabilitado</option>
                                    		</optgroup>
                                		</select>
                                    </div>
                                    <div class="form-group">
                                        <label for="potreroSeccion">Establecimiento - Secci&oacute;n</label>
                                		<select id="potreroSeccion" name="potreroSeccion" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?>>
<?php
    if ($establecimientoJSON['code'] == 200) {
        foreach ($establecimientoJSON['data'] as $establecimientoKey=>$establecimientoArray) {
            $row_establecimiento_00      	= $establecimientoArray['establecimiento_codigo'];
			$row_establecimiento_01      	= $establecimientoArray['establecimiento_nombre'];			
?>
                                  			<optgroup label="<?php echo $row_establecimiento_01; ?>">
								
<?php
            if ($seccionJSON['code'] == 200) {
                foreach ($seccionJSON['data'] as $seccionKey=>$seccionArray) {
                    $row_seccion_00      	= $seccionArray['seccion_codigo'];
                    $row_seccion_01      	= $seccionArray['establecimiento_codigo'];
                    $row_seccion_02      	= $seccionArray['seccion_nombre'];
                    
                    if ($row_establecimiento_00 == $row_seccion_01) {
                        $selected			= '';
                        if ($row_05 == $row_seccion_00){
                            $selected 		= 'selected';
                        }
?>
												<option value="<?php echo $row_seccion_00; ?>" <?php echo $selected; ?>><?php echo $row_seccion_02; ?></option>
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
                                        <label for="potreroNombre">Potrero</label>
                                        <input id="potreroNombre" name="potreroNombre" class="form-control" type="text" placeholder="Nombre" value="<?php echo $row_09; ?>" required <?php echo $workReadonly; ?>>
                                    </div>
                                    <div class="form-group">
                                    	<label for="potreroObservacion">Observaci&oacute;n</label>
                                    	<textarea id="potreroObservacion" name="potreroObservacion" class="form-control" rows="5" <?php echo $workReadonly; ?>><?php echo $row_10; ?></textarea>
                                	</div>
                                    <button type="submit" class="btn <?php echo $workAStyle; ?>" <?php echo $workReadonly; ?>><?php echo $workATitulo; ?></button>
                                    <a role="button" class="btn btn-dark" href="../public/establecimiento_potrero_l.php">Volver</a>
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