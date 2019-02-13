<?php
    require '../class/session/session_system.php';
    require '../class/function/curl_api.php';
    require '../class/function/function.php';

	$workCodigo 	            = $_GET['codigo'];
    $workModo 		            = $_GET['mode'];
    $codeRest                   = $_GET['code'];
    $msgRest                    = $_GET['msg'];
    $dominioJSON		        = get_curl('500');

	if ($workCodigo <> 0){
		$dataJSON			= get_curl('1300/'.$workCodigo);

		if ($dataJSON['code'] == 200){
            $row_00			= $dataJSON['data'][0]['persona_codigo'];
            $row_01			= $dataJSON['data'][0]['estado_persona_codigo'];
			$row_02			= $dataJSON['data'][0]['estado_persona_nombre'];
			$row_03			= $dataJSON['data'][0]['estado_persona_valor'];
            $row_04			= $dataJSON['data'][0]['estado_persona_observacion'];
			$row_05			= $dataJSON['data'][0]['tipo_persona_codigo'];
			$row_06			= $dataJSON['data'][0]['tipo_persona_nombre'];
            $row_07			= $dataJSON['data'][0]['tipo_persona_valor'];
            $row_08			= $dataJSON['data'][0]['tipo_persona_observacion'];
			$row_09			= $dataJSON['data'][0]['tipo_documento_codigo'];
            $row_10			= $dataJSON['data'][0]['tipo_documento_nombre'];
			$row_11			= $dataJSON['data'][0]['tipo_documento_valor'];
			$row_12			= $dataJSON['data'][0]['tipo_documento_observacion'];
            $row_13			= $dataJSON['data'][0]['persona_completo'];
            $row_14			= $dataJSON['data'][0]['persona_nombre'];
            $row_15			= $dataJSON['data'][0]['persona_apellido'];
            $row_16			= $dataJSON['data'][0]['persona_razon_social'];
            $row_17			= $dataJSON['data'][0]['persona_documento'];
            $row_18			= $dataJSON['data'][0]['persona_fecha_nacimiento'];
            $row_19			= $dataJSON['data'][0]['persona_telefono'];
            $row_20			= $dataJSON['data'][0]['persona_correo_electronico'];
        }
        
        if ($row_01 == 1){
            $row_01_h = 'selected';
            $row_01_d = '';
        }else{
            $row_01_h = '';
            $row_01_d = 'selected';
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
	
	<title>Panel Administrador - Persona</title>
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
                                        <a href="../public/persona_l.php">Persona</a>
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
                                <h4 class="card-title">Persona</h4>
                                <form id="form" data-parsley-validate class="m-t-30" method="post" action="../class/crud/persona_a.php">
                                	<div class="form-group">
                                        <input id="workCodigo" name="workCodigo" class="form-control" type="hidden" placeholder="Codigo" value="<?php echo $workCodigo; ?>" required readonly>
                                        <input id="workModo" name="workModo" class="form-control" type="hidden" placeholder="Modo" value="<?php echo $workModo; ?>" required readonly>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="estadoPersona">Estado</label>
                                            <select id="estadoPersona" name="estadoPersona" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?>>
                                                <optgroup label="Estado">
                                                    <option value="1" <?php echo $row_01_h; ?>>Habilitado</option>
                                                    <option value="2" <?php echo $row_01_d; ?>>Deshabilitado</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="tipoPersona">Tipo Persona</label>
                                		        <select id="tipoPersona" name="tipoPersona" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?>>
													<optgroup label="Tipo Persona">
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_estado_00          	= $dominioArray['estado_dominio_codigo'];
            $row_estado_01          	= $dominioArray['dominio_codigo'];
            $row_estado_02          	= $dominioArray['dominio_nombre'];
            $row_estado_03          	= $dominioArray['dominio_valor'];
            $row_estado_04         	    = $dominioArray['dominio_observacion'];
            $selectedEstado 			= '';

            if ($row_estado_00 == 1 && $row_estado_03 == 'PERSONATIPO') {
                if ($row_05 == $row_estado_01){
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
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="tipoDocumentoPersona">Tipo Documento</label>
                                		        <select id="tipoDocumentoPersona" name="tipoDocumentoPersona" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?>>
													<optgroup label="Tipo Documento">
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_estado_00          	= $dominioArray['estado_dominio_codigo'];
            $row_estado_01          	= $dominioArray['dominio_codigo'];
            $row_estado_02          	= $dominioArray['dominio_nombre'];
            $row_estado_03          	= $dominioArray['dominio_valor'];
            $row_estado_04         	    = $dominioArray['dominio_observacion'];
            $selectedEstado 			= '';

            if ($row_estado_00 == 1 && $row_estado_03 == 'PERSONADOCUMENTO') {
                if ($row_09 == $row_estado_01){
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
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nombrePersona">Nombre</label>
                                                <input id="nombrePersona" name="nombrePersona" class="form-control" type="text" placeholder="Nombre" value="<?php echo $row_14; ?>" <?php echo $workReadonly; ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="apellidoPersona">Apellido</label>
                                                <input id="apellidoPersona" name="apellidoPersona" class="form-control" type="text" placeholder="Apellido" value="<?php echo $row_15; ?>" <?php echo $workReadonly; ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="razonSocialPersona">Raz&oacute;n Social</label>
                                                <input id="razonSocialPersona" name="razonSocialPersona" class="form-control" type="text" placeholder="Razón Social" value="<?php echo $row_16; ?>" <?php echo $workReadonly; ?>>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="documentoPersona">Documento N&uacute;mero</label>
                                                <input id="documentoPersona" name="documentoPersona" class="form-control" type="text" placeholder="Documento N&uacute;mero" value="<?php echo $row_17; ?>" required <?php echo $workReadonly; ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="telefonoPersona">Tel&eacute;fono</label>
                                                <input id="telefonoPersona" name="telefonoPersona" class="form-control" type="text" placeholder="Tel&eacute;fono" value="<?php echo $row_19; ?>" <?php echo $workReadonly; ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="emailPersona">Email</label>
                                                <input id="emailPersona" name="emailPersona" class="form-control" type="email" placeholder="Email" value="<?php echo $row_20; ?>" <?php echo $workReadonly; ?>>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn <?php echo $workAStyle; ?>" <?php echo $workReadonly; ?>><?php echo $workATitulo; ?></button>
                                    <a role="button" class="btn btn-dark" href="../public/persona_l.php">Volver</a>
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