<?php
    require '../class/function/curl_api.php';
    require '../class/function/function.php';
    require '../class/session/session_system.php';

	$workCodigo 	        = $_GET['codigo'];
    $workModo 		        = $_GET['mode'];
    $workEstablecimiento    = $_GET['id1'];
    $codeRest               = $_GET['code'];
    $msgRest                = $_GET['msg'];
    $personaJSON	        = get_curl('1300');

	if ($workCodigo <> 0){
		$dataJSON			= get_curl('1400/'.$workCodigo);

		if ($dataJSON['code'] == 200){
			$row_01			= $dataJSON['data'][0]['estado_establecimiento_propietario_codigo'];
			$row_02			= $dataJSON['data'][0]['establecimiento_codigo'];
            $row_03			= $dataJSON['data'][0]['persona_codigo'];
            $row_04			= $dataJSON['data'][0]['establecimiento_propietario_marca'];

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
                                        <a href="../public/establecimiento_propietario_l.php?id1=<?php echo $workEstablecimiento; ?>">Establecimiento Propietario</a>
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
                                <h4 class="card-title">Establecimiento Propietario</h4>
                                <form id="form" data-parsley-validate class="m-t-30" method="post" action="../class/crud/establecimiento_propietario_a.php">
                                   	<div class="form-group">
                                        <input id="workCodigo" name="workCodigo" class="form-control" type="hidden" placeholder="Codigo" value="<?php echo $workCodigo; ?>" required readonly>
                                        <input id="workModo" name="workModo" class="form-control" type="hidden" placeholder="Modo" value="<?php echo $workModo; ?>" required readonly>
                                        <input id="workId1" name="workId1" class="form-control" type="hidden" placeholder="Establecimiento" value="<?php echo $workEstablecimiento; ?>" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="propietarioEstado">Estado</label>
                                		<select id="propietarioEstado" name="propietarioEstado" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?>>
                                    		<optgroup label="Estado">
                                        		<option value="1" <?php echo $row_01_h; ?>>Habilitado</option>
                                        		<option value="2" <?php echo $row_01_d; ?>>Deshabilitado</option>
                                    		</optgroup>
                                		</select>
                                    </div>
                                    <div class="form-group">
                                        <label for="propietarioPersona">Persona</label>
                                		<select id="propietarioPersona" name="propietarioPersona" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?>>
										    <optgroup label="Persona">
                                                <option value="0" <?php echo $workSelect; ?> disabled>Seleccionar</option>
<?php
    if ($personaJSON['code'] == 200) {
        foreach ($personaJSON['data'] as $personaKey=>$personaArray) {
            $row_persona_00          	= $personaArray['estado_persona_codigo'];
            $row_persona_01          	= $personaArray['persona_codigo'];
            $row_persona_02          	= $personaArray['persona_nombre'];
            $row_persona_03          	= $personaArray['persona_apellido'];
            $row_persona_04         	= $personaArray['persona_razon_social'];
            $row_persona_05         	= $personaArray['persona_documento'];
            $row_persona_06         	= $personaArray['tipo_persona_codigo'];
            $row_persona_07         	= $personaArray['tipo_documento_codigo'];
            $selectedPersona 			= '';

            if ($row_persona_06 == 53){
                $nombrePersona = 'CI '.$row_persona_05.', '.$row_persona_02.' '.$row_persona_03;
            } else {
                $nombrePersona = 'RUC '.$row_persona_05.', '.$row_persona_04;
            }

            if ($row_persona_00 == 1) {
                if ($row_03 == $row_persona_01){
                    $selectedPersona = 'selected';
                }
?>
											    <option value="<?php echo $row_persona_01; ?>" <?php echo $selectedPersona; ?>><?php echo $nombrePersona; ?></option>
<?php
            }
        }
    }
?>
											</optgroup>
									    </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="propietarioMarca">Marca</label>
                                        <input id="propietarioMarca" name="propietarioMarca" class="form-control" type="text" placeholder="Marca" value="<?php echo $row_04; ?>" required <?php echo $workReadonly; ?> maxlength="10">
                                    </div>
                                    <button type="submit" class="btn <?php echo $workAStyle; ?>" <?php echo $workReadonly; ?>><?php echo $workATitulo; ?></button>
                                    <a role="button" class="btn btn-dark" href="../public/establecimiento_propietario_l.php?id1=<?php echo $workEstablecimiento; ?>">Volver</a>
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