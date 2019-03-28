<?php
    require '../class/function/curl_api.php';
    require '../class/function/function.php';
    require '../class/session/session_system.php';

	$workCodigo 	        = $_GET['codigo'];
    $workModo 		        = $_GET['mode'];
    $workEstablecimiento    = $_GET['id1'];
    $codeRest               = $_GET['code'];
    $msgRest                = $_GET['msg'];
    $usuarioJSON	        = get_curl('1600');

	if ($workCodigo <> 0){
		$dataJSON			= get_curl('1700/'.$workCodigo);

		if ($dataJSON['code'] == 200){
			$row_01			= $dataJSON['data'][0]['estado_establecimiento_usuario_codigo'];
			$row_02			= $dataJSON['data'][0]['establecimiento_codigo'];
            $row_03			= $dataJSON['data'][0]['usuario_codigo'];

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
            $workSelect		= 'selected';
			break;
		case 'R':
			$workReadonly	= 'disabled';
			$workATitulo	= 'Ver';
            $workAStyle		= 'btn-primary';
            $workSelect		= '';
			break;
		case 'U':
			$workReadonly	= '';
			$workATitulo	= 'Actualizar';
            $workAStyle		= 'btn-success';
            $workSelect		= '';
			break;
		case 'D':
			$workReadonly	= '';
			$workATitulo	= 'Eliminar';
            $workAStyle		= 'btn-danger';
            $workSelect		= '';
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
                                        <a href="../public/establecimiento_l.php">Establecimiento</a>
                                    </li>
                                    <li class="breadcrumb-item" aria-current="page">
                                        <a href="../public/establecimiento_usuario_l.php?id1=<?php echo $workEstablecimiento; ?>">Establecimiento Usuario</a>
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
                                <h4 class="card-title">Establecimiento Usuario</h4>
                                <form id="form" data-parsley-validate class="m-t-30" method="post" action="../class/crud/establecimiento_usuario_a.php">
                                   	<div class="form-group">
                                        <input id="workCodigo" name="workCodigo" class="form-control" type="hidden" placeholder="Codigo" value="<?php echo $workCodigo; ?>" required readonly>
                                        <input id="workModo" name="workModo" class="form-control" type="hidden" placeholder="Modo" value="<?php echo $workModo; ?>" required readonly>
                                        <input id="workId1" name="workId1" class="form-control" type="hidden" placeholder="Establecimiento" value="<?php echo $workEstablecimiento; ?>" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="usuarioEstado">Estado</label>
                                		<select id="usuarioEstado" name="usuarioEstado" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?>>
                                    		<optgroup label="Estado">
                                        		<option value="1" <?php echo $row_01_h; ?>>Habilitado</option>
                                        		<option value="2" <?php echo $row_01_d; ?>>Deshabilitado</option>
                                    		</optgroup>
                                		</select>
                                    </div>
                                    <div class="form-group">
                                        <label for="usuarioNombre">Usuario</label>
                                		<select id="usuarioNombre" name="usuarioNombre" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?>>
										    <optgroup label="Usuario">
                                                <option value="0" <?php echo $workSelect; ?> disabled>Seleccionar</option>
<?php
    if ($usuarioJSON['code'] == 200) {
        foreach ($usuarioJSON['data'] as $usuarioKey=>$usuarioArray) {
            $row_usuario_00          	= $usuarioArray['estado_usuario_codigo'];
            $row_usuario_01          	= $usuarioArray['usuario_codigo'];
            $row_usuario_02          	= $usuarioArray['usuario_nombre'];
            $row_usuario_03          	= $usuarioArray['persona_completo'];
            $row_usuario_04             = $row_usuario_02.' - '.$row_usuario_03;
            $selectedUsuario 			= '';

            if ($row_usuario_00 == 1) {
                if ($row_03 == $row_usuario_01){
                    $selectedUsuario = 'selected';
                }
?>
											    <option value="<?php echo $row_usuario_01; ?>" <?php echo $selectedUsuario; ?>><?php echo $row_usuario_04; ?></option>
<?php
            }
        }
    }
?>
											</optgroup>
									    </select>
                                    </div>
                                    <button type="submit" class="btn <?php echo $workAStyle; ?>" <?php echo $workReadonly; ?>><?php echo $workATitulo; ?></button>
                                    <a role="button" class="btn btn-dark" href="../public/establecimiento_usuario_l.php?id1=<?php echo $workEstablecimiento; ?>">Volver</a>
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