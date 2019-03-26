<?php
    require '../class/function/curl_api.php';
    require '../class/function/function.php';
    require '../class/session/session_system.php';

	$workCodigo 	= $_GET['codigo'];
	$workModo 		= $_GET['mode'];
    $workValor 		= $_GET['dominio'];
    $codeRest       = $_GET['code'];
    $msgRest        = $_GET['msg'];
    $dominioJSON	= get_curl('500');

	if ($workCodigo <> 0){
		$dataJSON			= get_curl('600/'.$workCodigo);

		if ($dataJSON['code'] == 200){
			$row_01			= $dataJSON['data'][0]['estado_tipo_subtipo_codigo'];
			$row_02			= $dataJSON['data'][0]['tipo_codigo'];
			$row_03			= $dataJSON['data'][0]['subtipo_codigo'];
			$row_04			= $dataJSON['data'][0]['tipo_subtipo_valor'];
			$row_05			= $dataJSON['data'][0]['tipo_subtipo_observacion'];

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

	switch($workValor){
        case 'ESPECIERAZA':
            $dominioTitulo  = 'Especie/Raza';
            $dominioTit1    = 'ESPECIE';
            $dominioDom1    = 'ANIMALESPECIE';
            $dominioTit2    = 'RAZA';
            $dominioDom2    = 'ANIMALRAZA';
            break;
        case 'CATEGORIASUBCATEGORIA':
            $dominioTitulo  = 'Categoria/SubCategoria';
            $dominioTit1    = 'CATEGORIA';
            $dominioDom1    = 'ANIMALCATEGORIA';
            $dominioTit2    = 'SUBCATEGORIA';
            $dominioDom2    = 'ANIMALSUBCATEGORIA';
            break;
        case 'ROLACCESO':
            $dominioTitulo  = 'Rol/Acceso';
            $dominioTit1    = 'ROL';
            $dominioDom1    = 'USUARIOROL';
            $dominioTit2    = 'ACCESO';
            $dominioDom2    = 'USUARIOACCESO';
            break;
        case 'ROLPROGRAMA':
            $dominioTitulo  = 'Rol/Programa';
            $dominioTit1    = 'ROL';
            $dominioDom1    = 'USUARIOROL';
            $dominioTit2    = 'Programa';
            $dominioDom2    = 'USUARIOPROGRAMA';
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
                                        <a href="../public/dominio_sub_l.php?dominio=<?php echo $workValor; ?>">Par&aacute;metro <?php echo $dominioTitulo; ?></a>
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
                                <h4 class="card-title">Par&aacute;metro <?php echo $dominioTitulo; ?></h4>
                                <form id="form" data-parsley-validate class="m-t-30" method="post" action="../class/crud/dominio_sub_a.php">
                                   	<div class="form-group">
                                        <input id="workCodigo" name="workCodigo" class="form-control" type="hidden" placeholder="Codigo" value="<?php echo $workCodigo; ?>" required readonly>
                                        <input id="workModo" name="workModo" class="form-control" type="hidden" placeholder="Modo" value="<?php echo $workModo; ?>" required readonly>
                                        <input id="workDominio" name="workDominio" class="form-control" type="hidden" placeholder="Dominio" value="<?php echo $workValor; ?>" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="dominioSubEstado">Estado</label>
                                		<select id="dominioSubEstado" name="dominioSubEstado" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?>>
                                    		<optgroup label="Estado">
                                        		<option value="1" <?php echo $row_01_h; ?>>Habilitado</option>
                                        		<option value="2" <?php echo $row_01_d; ?>>Deshabilitado</option>
                                    		</optgroup>
                                		</select>
                                    </div>
                                    <div class="form-group">
                                        <label for="dominioSubTipo"><?php echo $dominioTit1; ?></label>
                                		<select id="dominioSubTipo" name="dominioSubTipo" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?>>
													<optgroup label="<?php echo $dominioTit1; ?>">
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_tipo_00          	= $dominioArray['estado_dominio_codigo'];
            $row_tipo_01          	= $dominioArray['dominio_codigo'];
            $row_tipo_02          	= $dominioArray['dominio_nombre'];
            $row_tipo_03          	= $dominioArray['dominio_valor'];
            $row_tipo_04         	= $dominioArray['dominio_observacion'];
            $selectedTipo 			= '';

            if ($row_tipo_00 == 1 && $row_tipo_03 == $dominioDom1) {
                if ($row_02 == $row_tipo_01){
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
                                        <label for="dominioSubTipoSub"><?php echo $dominioTit2; ?></label>
                                		<select id="dominioSubTipoSub" name="dominioSubTipoSub" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?>>
													<optgroup label="<?php echo $dominioTit2; ?>">
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_subtipo_00          	= $dominioArray['estado_dominio_codigo'];
            $row_subtipo_01          	= $dominioArray['dominio_codigo'];
            $row_subtipo_02          	= $dominioArray['dominio_nombre'];
            $row_subtipo_03          	= $dominioArray['dominio_valor'];
            $row_subtipo_04         	= $dominioArray['dominio_observacion'];
            $selectedSubTipo 			= '';

            if ($row_subtipo_00 == 1 && $row_subtipo_03 == $dominioDom2) {
                if ($row_03 == $row_subtipo_01){
                    $selectedSubTipo = 'selected';
                }
?>
														<option value="<?php echo $row_subtipo_01; ?>" <?php echo $selectedSubTipo; ?>><?php echo $row_subtipo_02; ?></option>
<?php
            }
        }
    }
?>
													</optgroup>
												</select>
                                    </div>
                                    <div class="form-group">
                                        <label for="dominioSubValor">Dominio</label>
                                        <input id="dominioSubValor" name="dominioSubValor" class="form-control" type="text" placeholder="Dominio" value="<?php echo $workValor; ?>" required readonly>
                                    </div>
                                    <div class="form-group">
                                    	<label for="dominioSubObservacion">Observaci&oacute;n</label>
                                    	<textarea id="dominioSubObservacion" name="dominioSubObservacion" class="form-control" rows="5" <?php echo $workReadonly; ?>><?php echo $row_05; ?></textarea>
                                	</div>
                                    <button type="submit" class="btn <?php echo $workAStyle; ?>" <?php echo $workReadonly; ?>><?php echo $workATitulo; ?></button>
                                    <a role="button" class="btn btn-dark" href="../public/dominio_sub_l.php?dominio=<?php echo $workValor; ?>">Volver</a>
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