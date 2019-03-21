<?php
    require '../class/session/session_system.php';
    require '../class/function/curl_api.php';
    require '../class/function/function.php';

	$workCodigo 	            = $_GET['codigo'];
    $workModo 		            = $_GET['mode'];
    $workRol                    = $_GET['id1'];
    $codeRest                   = $_GET['code'];
    $msgRest                    = $_GET['msg'];
    $dominioJSON		        = get_curl('500');

	if ($workCodigo <> 0){
		$dataJSON			= get_curl('1500/'.$workCodigo);

		if ($dataJSON['code'] == 200){
            $row_00			= $dataJSON['data'][0]['acceso_codigo'];
            $row_01			= $dataJSON['data'][0]['estado_acceso_codigo'];
			$row_02			= $dataJSON['data'][0]['rol_codigo'];
			$row_03			= $dataJSON['data'][0]['programa_codigo'];
            $row_04			= $dataJSON['data'][0]['acceso_ingresar'];
            $row_05			= $dataJSON['data'][0]['acceso_visualizar'];
            $row_06			= $dataJSON['data'][0]['acceso_insertar'];
            $row_07			= $dataJSON['data'][0]['acceso_modificar'];
            $row_08			= $dataJSON['data'][0]['acceso_eliminar'];
        }
        
        if ($row_01 == 1){
            $row_01_h = 'selected';
            $row_01_d = '';
        }else{
            $row_01_h = '';
            $row_01_d = 'selected';
        }

        if ($row_04 == 'N'){
            $row_04_h = 'selected';
            $row_04_d = '';
        }else{
            $row_04_h = '';
            $row_04_d = 'selected';
        }

        if ($row_05 == 'N'){
            $row_05_h = 'selected';
            $row_05_d = '';
        }else{
            $row_05_h = '';
            $row_05_d = 'selected';
        }

        if ($row_06 == 'N'){
            $row_06_h = 'selected';
            $row_06_d = '';
        }else{
            $row_06_h = '';
            $row_06_d = 'selected';
        }

        if ($row_07 == 'N'){
            $row_07_h = 'selected';
            $row_07_d = '';
        }else{
            $row_07_h = '';
            $row_07_d = 'selected';
        }

        if ($row_08 == 'N'){
            $row_08_h = 'selected';
            $row_08_d = '';
        }else{
            $row_08_h = '';
            $row_08_d = 'selected';
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
                                    <li class="breadcrumb-item">
                                        <a href="../public/usuario_rol_l.php">Rol</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="../public/usuario_rol_programa_l.php?id1=<?php echo $workRol; ?>">Rol Programa</a>
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
                                <h4 class="card-title">Rol Programa</h4>
                                <form id="form" data-parsley-validate class="m-t-30" method="post" action="../class/crud/usuario_rol_programa_a.php">
                                	<div class="form-group">
                                        <input id="workCodigo" name="workCodigo" class="form-control" type="hidden" placeholder="Codigo" value="<?php echo $workCodigo; ?>" required readonly>
                                        <input id="workModo" name="workModo" class="form-control" type="hidden" placeholder="Modo" value="<?php echo $workModo; ?>" required readonly>
                                        <input id="workRol" name="workRol" class="form-control" type="hidden" placeholder="Modo" value="<?php echo $workRol; ?>" required readonly>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="estadoRolPrograma">Estado</label>
                                            <select id="estadoRolPrograma" name="estadoRolPrograma" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?>>
                                                <optgroup label="Estado">
                                                    <option value="1" <?php echo $row_01_h; ?>>Habilitado</option>
                                                    <option value="2" <?php echo $row_01_d; ?>>Deshabilitado</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="rolRolPrograma">Rol</label>
                                		        <select id="rolRolPrograma" name="rolRolPrograma" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?>>
													<optgroup label="Rol">
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_estado_00          	= $dominioArray['estado_dominio_codigo'];
            $row_estado_01          	= $dominioArray['dominio_codigo'];
            $row_estado_02          	= $dominioArray['dominio_nombre'];
            $row_estado_03          	= $dominioArray['dominio_valor'];
            $row_estado_04         	    = $dominioArray['dominio_observacion'];
            $selectedEstado 			= '';

            if ($row_estado_00 == 1 && $row_estado_03 == 'USUARIOROL') {
                if ($row_02 == $row_estado_01){
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
                                                <label for="programaRolPrograma">Programa</label>
                                		        <select id="programaRolPrograma" name="programaRolPrograma" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?>>
													<optgroup label="Programa">
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_estado_00          	= $dominioArray['estado_dominio_codigo'];
            $row_estado_01          	= $dominioArray['dominio_codigo'];
            $row_estado_02          	= $dominioArray['dominio_nombre'];
            $row_estado_03          	= $dominioArray['dominio_valor'];
            $row_estado_04         	    = $dominioArray['dominio_observacion'];
            $selectedEstado 			= '';

            if ($row_estado_00 == 1 && $row_estado_03 == 'USUARIOPROGRAMA') {
                if ($row_03 == $row_estado_01){
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
                                        <div class="col-md-2">
                                            <label for="ingresaRolPrograma">Ingresar</label>
                                            <select id="ingresaRolPrograma" name="ingresaRolPrograma" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?>>
                                                <optgroup label="Ingresar">
                                                    <option value="N" <?php echo $row_04_h; ?>>NO</option>
                                                    <option value="S" <?php echo $row_04_d; ?>>SI</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="visualizaRolPrograma">Visualizar</label>
                                            <select id="visualizaRolPrograma" name="visualizaRolPrograma" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?>>
                                                <optgroup label="Visualizar">
                                                    <option value="N" <?php echo $row_05_h; ?>>NO</option>
                                                    <option value="S" <?php echo $row_05_d; ?>>SI</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="insertaRolPrograma">Insertar</label>
                                            <select id="insertaRolPrograma" name="insertaRolPrograma" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?>>
                                                <optgroup label="Insertar">
                                                    <option value="N" <?php echo $row_06_h; ?>>NO</option>
                                                    <option value="S" <?php echo $row_06_d; ?>>SI</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="modificaRolPrograma">Modificar</label>
                                            <select id="modificaRolPrograma" name="modificaRolPrograma" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?>>
                                                <optgroup label="Modificar">
                                                    <option value="N" <?php echo $row_07_h; ?>>NO</option>
                                                    <option value="S" <?php echo $row_07_d; ?>>SI</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="eliminaRolPrograma">Eliminar</label>
                                            <select id="eliminaRolPrograma" name="eliminaRolPrograma" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?>>
                                                <optgroup label="Eliminar">
                                                    <option value="N" <?php echo $row_08_h; ?>>NO</option>
                                                    <option value="S" <?php echo $row_08_d; ?>>SI</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn <?php echo $workAStyle; ?>" <?php echo $workReadonly; ?>><?php echo $workATitulo; ?></button>
                                    <a role="button" class="btn btn-dark" href="../public/usuario_rol_programa_l.php?id1=<?php echo $workRol; ?>">Volver</a>
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
    
    if (($codeRest == 204) || ($codeRest == 400)) {
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