<?php
    require '../class/session/session_system.php';
    require '../class/function/curl_api.php';
    require '../class/function/function.php';
?>

<!DOCTYPE html>
<html lang="es" dir="ltr">

<head>
<?php
    include '../include/header.php';
    $workEstablecimiento    = $_GET['id1'];
    $workCodigo             = $_GET['codigo'];
    $dominioJSON            = get_curl('500');
    $dominio_subJSON        = get_curl('600/dominio/CATEGORIASUBCATEGORIA');
    $potreroJSON            = get_curl('900/establecimiento/'.$workEstablecimiento);
    $propietarioJSON        = get_curl('1400/establecimiento/'.$workEstablecimiento);
?>
	
	<title>Panel Administrador - Orden de Trabajo Planilla Auditada</title>
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
                        <h4 class="page-title">Carga de Planilla Auditada</h4>
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
                                        <a href="../public/ot_detalle_l.php?mode=R&codigo=<?php echo $workCodigo; ?>">Orden de Trabajo Detalle</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Orden de Trabajo Carga</li>
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
                <!-- basic table -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="form" data-parsley-validate class="m-t-30" method="post" action="../class/crud/ot_auditada_a.php">
                                    <div class="form-group">
                                        <input id="workCodigo" name="workCodigo" class="form-control" type="hidden" placeholder="Codigo" value="<?php echo $workCodigo; ?>" required readonly>
                                        <input id="workModo" name="workModo" class="form-control" type="hidden" placeholder="Modo" value="<?php echo $workModo; ?>" required readonly>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="auditadaPotrero">Secci&oacute;n - Potrero</label>
                                                <select id="auditadaPotrero" name="auditadaPotrero" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> required>
                                                    <optgroup label="Secci&oacute;n - Potrero">
<?php
    if ($potreroJSON['code'] == 200) {
        foreach ($potreroJSON['data'] as $potreroKey=>$potreroArray) {
            $row_potrero_00          	= $potreroArray['potrero_codigo'];
            $row_potrero_01          	= $potreroArray['estado_potrero_codigo'];
            $row_potrero_02          	= $potreroArray['seccion_nombre'];
            $row_potrero_03          	= $potreroArray['potrero_nombre'];
            $selectedTipo 			= '';

            if ($row_potrero_01 == 1) {
?>
												        <option value="<?php echo $row_potrero_00; ?>"><?php echo $row_potrero_02 .' - '.$row_potrero_03; ?></option>
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
                                                <label for="auditadaFecha">Fecha</label>
                                                <input id="auditadaFecha" name="auditadaFecha" class="form-control" type="date" placeholder="Nombre" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="tableLoad" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>PROPIETARIO</th>
                                                    <th>ORIGEN</th>
                                                    <th>RAZA</th>
                                                    <th>CATEGOR&Iacute;A - SUBCATEGOR&Iacute;A</th>
                                                    <th>PESO PROMEDIO</th>
                                                    <th>CANTIDAD</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <select id="auditadaPropietario1" name="auditadaPropietario1" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> onchange="sumaTotal()">
                                                            <optgroup label="Propietario">
<?php
    if ($propietarioJSON['code'] == 200) {
        foreach ($propietarioJSON['data'] as $propietarioKey=>$propietarioArray) {
            $row_propietario_00  = $propietarioArray['establecimiento_propietario_codigo'];
            $row_propietario_01  = $propietarioArray['persona_nombre'].' '.$propietarioArray['persona_apellido'];
            $row_propietario_02  = $propietarioArray['persona_razon_social'];
            $row_propietario_03  = $propietarioArray['persona_documento'];
            $row_propietario_04  = $propietarioArray['persona_telefono'];
            $row_propietario_05  = $propietarioArray['persona_correo_electronico'];
            $row_propietario_06  = $propietarioArray['establecimiento_propietario_marca'];
?>
												                <option value="<?php echo $row_propietario_00; ?>"><?php echo $row_propietario_06; ?></option>
<?php
        }
    }
?>
												            </optgroup>
								                        </select>
                                                    </td>
                                                    <td> 
                                                        <select id="auditadaOrigen1" name="auditadaOrigen1" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> onchange="sumaTotal()">
                                                            <optgroup label="Origen">
                                                                <option value="" selected disabled>Seleccionar</option>
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_tipo_00          	= $dominioArray['estado_dominio_codigo'];
            $row_tipo_01          	= $dominioArray['dominio_codigo'];
            $row_tipo_02          	= $dominioArray['dominio_nombre'];
            $row_tipo_03          	= $dominioArray['dominio_valor'];
            $row_tipo_04         	= $dominioArray['dominio_observacion'];

            if ($row_tipo_00 == 1 && $row_tipo_03 == 'ANIMALORIGEN') {
?>
												                <option value="<?php echo $row_tipo_01; ?>"><?php echo $row_tipo_02; ?></option>
<?php
            }
        }
    }
?>
												            </optgroup>
								                        </select>
                                                    </td>
                                                    <td> 
                                                        <select id="auditadaRaza1" name="auditadaRaza1" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> onchange="sumaTotal()">
                                                            <optgroup label="Raza">
                                                                <option value="" selected disabled>Seleccionar</option>
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_tipo_00          	= $dominioArray['estado_dominio_codigo'];
            $row_tipo_01          	= $dominioArray['dominio_codigo'];
            $row_tipo_02          	= $dominioArray['dominio_nombre'];
            $row_tipo_03          	= $dominioArray['dominio_valor'];
            $row_tipo_04         	= $dominioArray['dominio_observacion'];

            if ($row_tipo_00 == 1 && $row_tipo_03 == 'ANIMALRAZA') {
?>
												                <option value="<?php echo $row_tipo_01; ?>"><?php echo $row_tipo_02; ?></option>
<?php
            }
        }
    }
?>
												            </optgroup>
								                        </select>
                                                    </td>
                                                    <td>
                                                        <select id="auditadaCategoria1" name="auditadaCategoria1" class="select2 form-control custom-select" style="width: 100%; height:36px;" onchange="sumaTotal()">
                                                            <option value="" selected disabled>Seleccionar</option>
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_dominio_00      	= $dominioArray['dominio_codigo'];
            $row_dominio_01      	= $dominioArray['estado_dominio_codigo'];
            $row_dominio_02      	= $dominioArray['dominio_nombre'];
            $row_dominio_03      	= $dominioArray['dominio_valor'];

            if ($row_dominio_01 == 1 && $row_dominio_03 == "ANIMALCATEGORIA") {
?>
                                  			                <optgroup label="<?php echo $row_dominio_02; ?>">
								
<?php
                if ($dominio_subJSON['code'] == 200) {
                    foreach ($dominio_subJSON['data'] as $dominio_subKey=>$dominio_subArray) {
                        $row_dominio_sub_00      	= $dominio_subArray['tipo_subtipo_codigo'];
                        $row_dominio_sub_01      	= $dominio_subArray['estado_tipo_subtipo_codigo'];
                        $row_dominio_sub_02      	= $dominio_subArray['estado_tipo_subtipo_nombre'];
                        $row_dominio_sub_03      	= $dominio_subArray['subtipo_codigo'];
                        $row_dominio_sub_04      	= $dominio_subArray['subtipo_nombre'];
                        $row_dominio_sub_05      	= $dominio_subArray['tipo_codigo'];
                        $row_dominio_sub_06      	= $dominio_subArray['tipo_nombre'];
			
			            if ($row_dominio_00 == $row_dominio_sub_05) {
?>
												                <option value="<?php echo $row_dominio_sub_00; ?>"><?php echo $row_dominio_sub_06.' - '.$row_dominio_sub_04; ?></option>
<?php
			            }
		            }
	            }
?>
                                    		                </optgroup>
<?php
		    }
        }
    }
?>
                                		                </select>
                                                    </td>
                                                    <td>
                                                        <input id="auditadaPesoPromedio1" name="auditadaPesoPromedio1" class="form-control" type="number" step=".01" value="0" onchange="sumaTotal()">
                                                    </td>
                                                    <td>
                                                        <input id="auditadaCantidad1" name="auditadaCantidad1" class="form-control" type="number" onchange="sumaTotal()">
                                                    </th>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <select id="auditadaPropietario2" name="auditadaPropietario2" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> onchange="sumaTotal()">
                                                            <optgroup label="Propietario">
<?php
    if ($propietarioJSON['code'] == 200) {
        foreach ($propietarioJSON['data'] as $propietarioKey=>$propietarioArray) {
            $row_propietario_00  = $propietarioArray['establecimiento_propietario_codigo'];
            $row_propietario_01  = $propietarioArray['persona_nombre'].' '.$propietarioArray['persona_apellido'];
            $row_propietario_02  = $propietarioArray['persona_razon_social'];
            $row_propietario_03  = $propietarioArray['persona_documento'];
            $row_propietario_04  = $propietarioArray['persona_telefono'];
            $row_propietario_05  = $propietarioArray['persona_correo_electronico'];
            $row_propietario_06  = $propietarioArray['establecimiento_propietario_marca'];
?>
												                <option value="<?php echo $row_propietario_00; ?>"><?php echo $row_propietario_06; ?></option>
<?php
        }
    }
?>
												            </optgroup>
								                        </select>
                                                    </td>
                                                    <td> 
                                                        <select id="auditadaOrigen2" name="auditadaOrigen2" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> onchange="sumaTotal()">
                                                            <optgroup label="Origen">
                                                                <option value="" selected disabled>Seleccionar</option>
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_tipo_00          	= $dominioArray['estado_dominio_codigo'];
            $row_tipo_01          	= $dominioArray['dominio_codigo'];
            $row_tipo_02          	= $dominioArray['dominio_nombre'];
            $row_tipo_03          	= $dominioArray['dominio_valor'];
            $row_tipo_04         	= $dominioArray['dominio_observacion'];

            if ($row_tipo_00 == 1 && $row_tipo_03 == 'ANIMALORIGEN') {
?>
												                <option value="<?php echo $row_tipo_01; ?>"><?php echo $row_tipo_02; ?></option>
<?php
            }
        }
    }
?>
												            </optgroup>
								                        </select>
                                                    </td>
                                                    <td> 
                                                        <select id="auditadaRaza2" name="auditadaRaza2" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> onchange="sumaTotal()">
                                                            <optgroup label="Raza">
                                                                <option value="" selected disabled>Seleccionar</option>
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_tipo_00          	= $dominioArray['estado_dominio_codigo'];
            $row_tipo_01          	= $dominioArray['dominio_codigo'];
            $row_tipo_02          	= $dominioArray['dominio_nombre'];
            $row_tipo_03          	= $dominioArray['dominio_valor'];
            $row_tipo_04         	= $dominioArray['dominio_observacion'];

            if ($row_tipo_00 == 1 && $row_tipo_03 == 'ANIMALRAZA') {
?>
												                <option value="<?php echo $row_tipo_01; ?>"><?php echo $row_tipo_02; ?></option>
<?php
            }
        }
    }
?>
												            </optgroup>
								                        </select>
                                                    </td>
                                                    <td>
                                                        <select id="auditadaCategoria2" name="auditadaCategoria2" class="select2 form-control custom-select" style="width: 100%; height:36px;" onchange="sumaTotal()">
                                                            <option value="" selected disabled>Seleccionar</option>
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_dominio_00      	= $dominioArray['dominio_codigo'];
            $row_dominio_01      	= $dominioArray['estado_dominio_codigo'];
            $row_dominio_02      	= $dominioArray['dominio_nombre'];
            $row_dominio_03      	= $dominioArray['dominio_valor'];

            if ($row_dominio_01 == 1 && $row_dominio_03 == "ANIMALCATEGORIA") {
?>
                                  			                <optgroup label="<?php echo $row_dominio_02; ?>">
								
<?php
                if ($dominio_subJSON['code'] == 200) {
                    foreach ($dominio_subJSON['data'] as $dominio_subKey=>$dominio_subArray) {
                        $row_dominio_sub_00      	= $dominio_subArray['tipo_subtipo_codigo'];
                        $row_dominio_sub_01      	= $dominio_subArray['estado_tipo_subtipo_codigo'];
                        $row_dominio_sub_02      	= $dominio_subArray['estado_tipo_subtipo_nombre'];
                        $row_dominio_sub_03      	= $dominio_subArray['subtipo_codigo'];
                        $row_dominio_sub_04      	= $dominio_subArray['subtipo_nombre'];
                        $row_dominio_sub_05      	= $dominio_subArray['tipo_codigo'];
                        $row_dominio_sub_06      	= $dominio_subArray['tipo_nombre'];
			
			            if ($row_dominio_00 == $row_dominio_sub_05) {
?>
												                <option value="<?php echo $row_dominio_sub_00; ?>"><?php echo $row_dominio_sub_06.' - '.$row_dominio_sub_04; ?></option>
<?php
			            }
		            }
	            }
?>
                                    		                </optgroup>
<?php
		    }
        }
    }
?>
                                		                </select>
                                                    </td>
                                                    <td>
                                                        <input id="auditadaPesoPromedio2" name="auditadaPesoPromedio2" class="form-control" type="number" step=".01" value="0" onchange="sumaTotal()">
                                                    </td>
                                                    <td>
                                                        <input id="auditadaCantidad2" name="auditadaCantidad2" class="form-control" type="number" onchange="sumaTotal()">
                                                    </th>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <select id="auditadaPropietario3" name="auditadaPropietario3" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> onchange="sumaTotal()">
                                                            <optgroup label="Propietario">
<?php
    if ($propietarioJSON['code'] == 200) {
        foreach ($propietarioJSON['data'] as $propietarioKey=>$propietarioArray) {
            $row_propietario_00  = $propietarioArray['establecimiento_propietario_codigo'];
            $row_propietario_01  = $propietarioArray['persona_nombre'].' '.$propietarioArray['persona_apellido'];
            $row_propietario_02  = $propietarioArray['persona_razon_social'];
            $row_propietario_03  = $propietarioArray['persona_documento'];
            $row_propietario_04  = $propietarioArray['persona_telefono'];
            $row_propietario_05  = $propietarioArray['persona_correo_electronico'];
            $row_propietario_06  = $propietarioArray['establecimiento_propietario_marca'];
?>
												                <option value="<?php echo $row_propietario_00; ?>"><?php echo $row_propietario_06; ?></option>
<?php
        }
    }
?>
												            </optgroup>
								                        </select>
                                                    </td>
                                                    <td> 
                                                        <select id="auditadaOrigen3" name="auditadaOrigen3" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> onchange="sumaTotal()">
                                                            <optgroup label="Origen">
                                                                <option value="" selected disabled>Seleccionar</option>
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_tipo_00          	= $dominioArray['estado_dominio_codigo'];
            $row_tipo_01          	= $dominioArray['dominio_codigo'];
            $row_tipo_02          	= $dominioArray['dominio_nombre'];
            $row_tipo_03          	= $dominioArray['dominio_valor'];
            $row_tipo_04         	= $dominioArray['dominio_observacion'];

            if ($row_tipo_00 == 1 && $row_tipo_03 == 'ANIMALORIGEN') {
?>
												                <option value="<?php echo $row_tipo_01; ?>"><?php echo $row_tipo_02; ?></option>
<?php
            }
        }
    }
?>
												            </optgroup>
								                        </select>
                                                    </td>
                                                    <td> 
                                                        <select id="auditadaRaza3" name="auditadaRaza3" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> onchange="sumaTotal()">
                                                            <optgroup label="Raza">
                                                                <option value="" selected disabled>Seleccionar</option>
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_tipo_00          	= $dominioArray['estado_dominio_codigo'];
            $row_tipo_01          	= $dominioArray['dominio_codigo'];
            $row_tipo_02          	= $dominioArray['dominio_nombre'];
            $row_tipo_03          	= $dominioArray['dominio_valor'];
            $row_tipo_04         	= $dominioArray['dominio_observacion'];

            if ($row_tipo_00 == 1 && $row_tipo_03 == 'ANIMALRAZA') {
?>
												                <option value="<?php echo $row_tipo_01; ?>"><?php echo $row_tipo_02; ?></option>
<?php
            }
        }
    }
?>
												            </optgroup>
								                        </select>
                                                    </td>
                                                    <td>
                                                        <select id="auditadaCategoria3" name="auditadaCategoria3" class="select2 form-control custom-select" style="width: 100%; height:36px;" onchange="sumaTotal()">
                                                            <option value="" selected disabled>Seleccionar</option>
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_dominio_00      	= $dominioArray['dominio_codigo'];
            $row_dominio_01      	= $dominioArray['estado_dominio_codigo'];
            $row_dominio_02      	= $dominioArray['dominio_nombre'];
            $row_dominio_03      	= $dominioArray['dominio_valor'];

            if ($row_dominio_01 == 1 && $row_dominio_03 == "ANIMALCATEGORIA") {
?>
                                  			                <optgroup label="<?php echo $row_dominio_02; ?>">
								
<?php
                if ($dominio_subJSON['code'] == 200) {
                    foreach ($dominio_subJSON['data'] as $dominio_subKey=>$dominio_subArray) {
                        $row_dominio_sub_00      	= $dominio_subArray['tipo_subtipo_codigo'];
                        $row_dominio_sub_01      	= $dominio_subArray['estado_tipo_subtipo_codigo'];
                        $row_dominio_sub_02      	= $dominio_subArray['estado_tipo_subtipo_nombre'];
                        $row_dominio_sub_03      	= $dominio_subArray['subtipo_codigo'];
                        $row_dominio_sub_04      	= $dominio_subArray['subtipo_nombre'];
                        $row_dominio_sub_05      	= $dominio_subArray['tipo_codigo'];
                        $row_dominio_sub_06      	= $dominio_subArray['tipo_nombre'];
			
			            if ($row_dominio_00 == $row_dominio_sub_05) {
?>
												                <option value="<?php echo $row_dominio_sub_00; ?>"><?php echo $row_dominio_sub_06.' - '.$row_dominio_sub_04; ?></option>
<?php
			            }
		            }
	            }
?>
                                    		                </optgroup>
<?php
		    }
        }
    }
?>
                                		                </select>
                                                    </td>
                                                    <td>
                                                        <input id="auditadaPesoPromedio3" name="auditadaPesoPromedio3" class="form-control" type="number" step=".01" value="0" onchange="sumaTotal()">
                                                    </td>
                                                    <td>
                                                        <input id="auditadaCantidad3" name="auditadaCantidad3" class="form-control" type="number" onchange="sumaTotal()">
                                                    </th>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <select id="auditadaPropietario4" name="auditadaPropietario4" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> onchange="sumaTotal()">
                                                            <optgroup label="Propietario">
<?php
    if ($propietarioJSON['code'] == 200) {
        foreach ($propietarioJSON['data'] as $propietarioKey=>$propietarioArray) {
            $row_propietario_00  = $propietarioArray['establecimiento_propietario_codigo'];
            $row_propietario_01  = $propietarioArray['persona_nombre'].' '.$propietarioArray['persona_apellido'];
            $row_propietario_02  = $propietarioArray['persona_razon_social'];
            $row_propietario_03  = $propietarioArray['persona_documento'];
            $row_propietario_04  = $propietarioArray['persona_telefono'];
            $row_propietario_05  = $propietarioArray['persona_correo_electronico'];
            $row_propietario_06  = $propietarioArray['establecimiento_propietario_marca'];
?>
												                <option value="<?php echo $row_propietario_00; ?>"><?php echo $row_propietario_06; ?></option>
<?php
        }
    }
?>
												            </optgroup>
								                        </select>
                                                    </td>
                                                    <td> 
                                                        <select id="auditadaOrigen4" name="auditadaOrigen4" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> onchange="sumaTotal()">
                                                            <optgroup label="Origen">
                                                                <option value="" selected disabled>Seleccionar</option>
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_tipo_00          	= $dominioArray['estado_dominio_codigo'];
            $row_tipo_01          	= $dominioArray['dominio_codigo'];
            $row_tipo_02          	= $dominioArray['dominio_nombre'];
            $row_tipo_03          	= $dominioArray['dominio_valor'];
            $row_tipo_04         	= $dominioArray['dominio_observacion'];

            if ($row_tipo_00 == 1 && $row_tipo_03 == 'ANIMALORIGEN') {
?>
												                <option value="<?php echo $row_tipo_01; ?>"><?php echo $row_tipo_02; ?></option>
<?php
            }
        }
    }
?>
												            </optgroup>
								                        </select>
                                                    </td>
                                                    <td> 
                                                        <select id="auditadaRaza4" name="auditadaRaza4" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> onchange="sumaTotal()">
                                                            <optgroup label="Raza">
                                                                <option value="" selected disabled>Seleccionar</option>
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_tipo_00          	= $dominioArray['estado_dominio_codigo'];
            $row_tipo_01          	= $dominioArray['dominio_codigo'];
            $row_tipo_02          	= $dominioArray['dominio_nombre'];
            $row_tipo_03          	= $dominioArray['dominio_valor'];
            $row_tipo_04         	= $dominioArray['dominio_observacion'];

            if ($row_tipo_00 == 1 && $row_tipo_03 == 'ANIMALRAZA') {
?>
												                <option value="<?php echo $row_tipo_01; ?>"><?php echo $row_tipo_02; ?></option>
<?php
            }
        }
    }
?>
												            </optgroup>
								                        </select>
                                                    </td>
                                                    <td>
                                                        <select id="auditadaCategoria4" name="auditadaCategoria4" class="select2 form-control custom-select" style="width: 100%; height:36px;" onchange="sumaTotal()">
                                                            <option value="" selected disabled>Seleccionar</option>
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_dominio_00      	= $dominioArray['dominio_codigo'];
            $row_dominio_01      	= $dominioArray['estado_dominio_codigo'];
            $row_dominio_02      	= $dominioArray['dominio_nombre'];
            $row_dominio_03      	= $dominioArray['dominio_valor'];

            if ($row_dominio_01 == 1 && $row_dominio_03 == "ANIMALCATEGORIA") {
?>
                                  			                <optgroup label="<?php echo $row_dominio_02; ?>">
								
<?php
                if ($dominio_subJSON['code'] == 200) {
                    foreach ($dominio_subJSON['data'] as $dominio_subKey=>$dominio_subArray) {
                        $row_dominio_sub_00      	= $dominio_subArray['tipo_subtipo_codigo'];
                        $row_dominio_sub_01      	= $dominio_subArray['estado_tipo_subtipo_codigo'];
                        $row_dominio_sub_02      	= $dominio_subArray['estado_tipo_subtipo_nombre'];
                        $row_dominio_sub_03      	= $dominio_subArray['subtipo_codigo'];
                        $row_dominio_sub_04      	= $dominio_subArray['subtipo_nombre'];
                        $row_dominio_sub_05      	= $dominio_subArray['tipo_codigo'];
                        $row_dominio_sub_06      	= $dominio_subArray['tipo_nombre'];
			
			            if ($row_dominio_00 == $row_dominio_sub_05) {
?>
												                <option value="<?php echo $row_dominio_sub_00; ?>"><?php echo $row_dominio_sub_06.' - '.$row_dominio_sub_04; ?></option>
<?php
			            }
		            }
	            }
?>
                                    		                </optgroup>
<?php
		    }
        }
    }
?>
                                		                </select>
                                                    </td>
                                                    <td>
                                                        <input id="auditadaPesoPromedio4" name="auditadaPesoPromedio4" class="form-control" type="number" step=".01" value="0" onchange="sumaTotal()">
                                                    </td>
                                                    <td>
                                                        <input id="auditadaCantidad4" name="auditadaCantidad4" class="form-control" type="number" onchange="sumaTotal()">
                                                    </th>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <select id="auditadaPropietario5" name="auditadaPropietario5" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> onchange="sumaTotal()">
                                                            <optgroup label="Propietario">
<?php
    if ($propietarioJSON['code'] == 200) {
        foreach ($propietarioJSON['data'] as $propietarioKey=>$propietarioArray) {
            $row_propietario_00  = $propietarioArray['establecimiento_propietario_codigo'];
            $row_propietario_01  = $propietarioArray['persona_nombre'].' '.$propietarioArray['persona_apellido'];
            $row_propietario_02  = $propietarioArray['persona_razon_social'];
            $row_propietario_03  = $propietarioArray['persona_documento'];
            $row_propietario_04  = $propietarioArray['persona_telefono'];
            $row_propietario_05  = $propietarioArray['persona_correo_electronico'];
            $row_propietario_06  = $propietarioArray['establecimiento_propietario_marca'];
?>
												                <option value="<?php echo $row_propietario_00; ?>"><?php echo $row_propietario_06; ?></option>
<?php
        }
    }
?>
												            </optgroup>
								                        </select>
                                                    </td>
                                                    <td> 
                                                        <select id="auditadaOrigen5" name="auditadaOrigen5" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> onchange="sumaTotal()">
                                                            <optgroup label="Origen">
                                                                <option value="" selected disabled>Seleccionar</option>
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_tipo_00          	= $dominioArray['estado_dominio_codigo'];
            $row_tipo_01          	= $dominioArray['dominio_codigo'];
            $row_tipo_02          	= $dominioArray['dominio_nombre'];
            $row_tipo_03          	= $dominioArray['dominio_valor'];
            $row_tipo_04         	= $dominioArray['dominio_observacion'];

            if ($row_tipo_00 == 1 && $row_tipo_03 == 'ANIMALORIGEN') {
?>
												                <option value="<?php echo $row_tipo_01; ?>"><?php echo $row_tipo_02; ?></option>
<?php
            }
        }
    }
?>
												            </optgroup>
								                        </select>
                                                    </td>
                                                    <td> 
                                                        <select id="auditadaRaza5" name="auditadaRaza5" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> onchange="sumaTotal()">
                                                            <optgroup label="Raza">
                                                                <option value="" selected disabled>Seleccionar</option>
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_tipo_00          	= $dominioArray['estado_dominio_codigo'];
            $row_tipo_01          	= $dominioArray['dominio_codigo'];
            $row_tipo_02          	= $dominioArray['dominio_nombre'];
            $row_tipo_03          	= $dominioArray['dominio_valor'];
            $row_tipo_04         	= $dominioArray['dominio_observacion'];

            if ($row_tipo_00 == 1 && $row_tipo_03 == 'ANIMALRAZA') {
?>
												                <option value="<?php echo $row_tipo_01; ?>"><?php echo $row_tipo_02; ?></option>
<?php
            }
        }
    }
?>
												            </optgroup>
								                        </select>
                                                    </td>
                                                    <td>
                                                        <select id="auditadaCategoria5" name="auditadaCategoria5" class="select2 form-control custom-select" style="width: 100%; height:36px;" onchange="sumaTotal()">
                                                            <option value="" selected disabled>Seleccionar</option>
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_dominio_00      	= $dominioArray['dominio_codigo'];
            $row_dominio_01      	= $dominioArray['estado_dominio_codigo'];
            $row_dominio_02      	= $dominioArray['dominio_nombre'];
            $row_dominio_03      	= $dominioArray['dominio_valor'];

            if ($row_dominio_01 == 1 && $row_dominio_03 == "ANIMALCATEGORIA") {
?>
                                  			                <optgroup label="<?php echo $row_dominio_02; ?>">
								
<?php
                if ($dominio_subJSON['code'] == 200) {
                    foreach ($dominio_subJSON['data'] as $dominio_subKey=>$dominio_subArray) {
                        $row_dominio_sub_00      	= $dominio_subArray['tipo_subtipo_codigo'];
                        $row_dominio_sub_01      	= $dominio_subArray['estado_tipo_subtipo_codigo'];
                        $row_dominio_sub_02      	= $dominio_subArray['estado_tipo_subtipo_nombre'];
                        $row_dominio_sub_03      	= $dominio_subArray['subtipo_codigo'];
                        $row_dominio_sub_04      	= $dominio_subArray['subtipo_nombre'];
                        $row_dominio_sub_05      	= $dominio_subArray['tipo_codigo'];
                        $row_dominio_sub_06      	= $dominio_subArray['tipo_nombre'];
			
			            if ($row_dominio_00 == $row_dominio_sub_05) {
?>
												                <option value="<?php echo $row_dominio_sub_00; ?>"><?php echo $row_dominio_sub_06.' - '.$row_dominio_sub_04; ?></option>
<?php
			            }
		            }
	            }
?>
                                    		                </optgroup>
<?php
		    }
        }
    }
?>
                                		                </select>
                                                    </td>
                                                    <td>
                                                        <input id="auditadaPesoPromedio5" name="auditadaPesoPromedio5" class="form-control" type="number" step=".01" value="0" onchange="sumaTotal()">
                                                    </td>
                                                    <td>
                                                        <input id="auditadaCantidad5" name="auditadaCantidad5" class="form-control" type="number" onchange="sumaTotal()">
                                                    </th>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <select id="auditadaPropietario6" name="auditadaPropietario6" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> onchange="sumaTotal()">
                                                            <optgroup label="Propietario">
<?php
    if ($propietarioJSON['code'] == 200) {
        foreach ($propietarioJSON['data'] as $propietarioKey=>$propietarioArray) {
            $row_propietario_00  = $propietarioArray['establecimiento_propietario_codigo'];
            $row_propietario_01  = $propietarioArray['persona_nombre'].' '.$propietarioArray['persona_apellido'];
            $row_propietario_02  = $propietarioArray['persona_razon_social'];
            $row_propietario_03  = $propietarioArray['persona_documento'];
            $row_propietario_04  = $propietarioArray['persona_telefono'];
            $row_propietario_05  = $propietarioArray['persona_correo_electronico'];
            $row_propietario_06  = $propietarioArray['establecimiento_propietario_marca'];
?>
												                <option value="<?php echo $row_propietario_00; ?>"><?php echo $row_propietario_06; ?></option>
<?php
        }
    }
?>
												            </optgroup>
								                        </select>
                                                    </td>
                                                    <td> 
                                                        <select id="auditadaOrigen6" name="auditadaOrigen6" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> onchange="sumaTotal()">
                                                            <optgroup label="Origen">
                                                                <option value="" selected disabled>Seleccionar</option>
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_tipo_00          	= $dominioArray['estado_dominio_codigo'];
            $row_tipo_01          	= $dominioArray['dominio_codigo'];
            $row_tipo_02          	= $dominioArray['dominio_nombre'];
            $row_tipo_03          	= $dominioArray['dominio_valor'];
            $row_tipo_04         	= $dominioArray['dominio_observacion'];

            if ($row_tipo_00 == 1 && $row_tipo_03 == 'ANIMALORIGEN') {
?>
												                <option value="<?php echo $row_tipo_01; ?>"><?php echo $row_tipo_02; ?></option>
<?php
            }
        }
    }
?>
												            </optgroup>
								                        </select>
                                                    </td>
                                                    <td> 
                                                        <select id="auditadaRaza6" name="auditadaRaza6" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> onchange="sumaTotal()">
                                                            <optgroup label="Raza">
                                                                <option value="" selected disabled>Seleccionar</option>
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_tipo_00          	= $dominioArray['estado_dominio_codigo'];
            $row_tipo_01          	= $dominioArray['dominio_codigo'];
            $row_tipo_02          	= $dominioArray['dominio_nombre'];
            $row_tipo_03          	= $dominioArray['dominio_valor'];
            $row_tipo_04         	= $dominioArray['dominio_observacion'];

            if ($row_tipo_00 == 1 && $row_tipo_03 == 'ANIMALRAZA') {
?>
												                <option value="<?php echo $row_tipo_01; ?>"><?php echo $row_tipo_02; ?></option>
<?php
            }
        }
    }
?>
												            </optgroup>
								                        </select>
                                                    </td>
                                                    <td>
                                                        <select id="auditadaCategoria6" name="auditadaCategoria6" class="select2 form-control custom-select" style="width: 100%; height:36px;" onchange="sumaTotal()">
                                                            <option value="" selected disabled>Seleccionar</option>
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_dominio_00      	= $dominioArray['dominio_codigo'];
            $row_dominio_01      	= $dominioArray['estado_dominio_codigo'];
            $row_dominio_02      	= $dominioArray['dominio_nombre'];
            $row_dominio_03      	= $dominioArray['dominio_valor'];

            if ($row_dominio_01 == 1 && $row_dominio_03 == "ANIMALCATEGORIA") {
?>
                                  			                <optgroup label="<?php echo $row_dominio_02; ?>">
								
<?php
                if ($dominio_subJSON['code'] == 200) {
                    foreach ($dominio_subJSON['data'] as $dominio_subKey=>$dominio_subArray) {
                        $row_dominio_sub_00      	= $dominio_subArray['tipo_subtipo_codigo'];
                        $row_dominio_sub_01      	= $dominio_subArray['estado_tipo_subtipo_codigo'];
                        $row_dominio_sub_02      	= $dominio_subArray['estado_tipo_subtipo_nombre'];
                        $row_dominio_sub_03      	= $dominio_subArray['subtipo_codigo'];
                        $row_dominio_sub_04      	= $dominio_subArray['subtipo_nombre'];
                        $row_dominio_sub_05      	= $dominio_subArray['tipo_codigo'];
                        $row_dominio_sub_06      	= $dominio_subArray['tipo_nombre'];
			
			            if ($row_dominio_00 == $row_dominio_sub_05) {
?>
												                <option value="<?php echo $row_dominio_sub_00; ?>"><?php echo $row_dominio_sub_06.' - '.$row_dominio_sub_04; ?></option>
<?php
			            }
		            }
	            }
?>
                                    		                </optgroup>
<?php
		    }
        }
    }
?>
                                		                </select>
                                                    </td>
                                                    <td>
                                                        <input id="auditadaPesoPromedio6" name="auditadaPesoPromedio6" class="form-control" type="number" step=".01" value="0" onchange="sumaTotal()">
                                                    </td>
                                                    <td>
                                                        <input id="auditadaCantidad6" name="auditadaCantidad6" class="form-control" type="number" onchange="sumaTotal()">
                                                    </th>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <select id="auditadaPropietario7" name="auditadaPropietario7" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> onchange="sumaTotal()">
                                                            <optgroup label="Propietario">
<?php
    if ($propietarioJSON['code'] == 200) {
        foreach ($propietarioJSON['data'] as $propietarioKey=>$propietarioArray) {
            $row_propietario_00  = $propietarioArray['establecimiento_propietario_codigo'];
            $row_propietario_01  = $propietarioArray['persona_nombre'].' '.$propietarioArray['persona_apellido'];
            $row_propietario_02  = $propietarioArray['persona_razon_social'];
            $row_propietario_03  = $propietarioArray['persona_documento'];
            $row_propietario_04  = $propietarioArray['persona_telefono'];
            $row_propietario_05  = $propietarioArray['persona_correo_electronico'];
            $row_propietario_06  = $propietarioArray['establecimiento_propietario_marca'];
?>
												                <option value="<?php echo $row_propietario_00; ?>"><?php echo $row_propietario_06; ?></option>
<?php
        }
    }
?>
												            </optgroup>
								                        </select>
                                                    </td>
                                                    <td> 
                                                        <select id="auditadaOrigen7" name="auditadaOrigen7" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> onchange="sumaTotal()">
                                                            <optgroup label="Origen">
                                                                <option value="" selected disabled>Seleccionar</option>
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_tipo_00          	= $dominioArray['estado_dominio_codigo'];
            $row_tipo_01          	= $dominioArray['dominio_codigo'];
            $row_tipo_02          	= $dominioArray['dominio_nombre'];
            $row_tipo_03          	= $dominioArray['dominio_valor'];
            $row_tipo_04         	= $dominioArray['dominio_observacion'];

            if ($row_tipo_00 == 1 && $row_tipo_03 == 'ANIMALORIGEN') {
?>
												                <option value="<?php echo $row_tipo_01; ?>"><?php echo $row_tipo_02; ?></option>
<?php
            }
        }
    }
?>
												            </optgroup>
								                        </select>
                                                    </td>
                                                    <td> 
                                                        <select id="auditadaRaza7" name="auditadaRaza7" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> onchange="sumaTotal()">
                                                            <optgroup label="Raza">
                                                                <option value="" selected disabled>Seleccionar</option>
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_tipo_00          	= $dominioArray['estado_dominio_codigo'];
            $row_tipo_01          	= $dominioArray['dominio_codigo'];
            $row_tipo_02          	= $dominioArray['dominio_nombre'];
            $row_tipo_03          	= $dominioArray['dominio_valor'];
            $row_tipo_04         	= $dominioArray['dominio_observacion'];

            if ($row_tipo_00 == 1 && $row_tipo_03 == 'ANIMALRAZA') {
?>
												                <option value="<?php echo $row_tipo_01; ?>"><?php echo $row_tipo_02; ?></option>
<?php
            }
        }
    }
?>
												            </optgroup>
								                        </select>
                                                    </td>
                                                    <td>
                                                        <select id="auditadaCategoria7" name="auditadaCategoria7" class="select2 form-control custom-select" style="width: 100%; height:36px;" onchange="sumaTotal()">
                                                            <option value="" selected disabled>Seleccionar</option>
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_dominio_00      	= $dominioArray['dominio_codigo'];
            $row_dominio_01      	= $dominioArray['estado_dominio_codigo'];
            $row_dominio_02      	= $dominioArray['dominio_nombre'];
            $row_dominio_03      	= $dominioArray['dominio_valor'];

            if ($row_dominio_01 == 1 && $row_dominio_03 == "ANIMALCATEGORIA") {
?>
                                  			                <optgroup label="<?php echo $row_dominio_02; ?>">
								
<?php
                if ($dominio_subJSON['code'] == 200) {
                    foreach ($dominio_subJSON['data'] as $dominio_subKey=>$dominio_subArray) {
                        $row_dominio_sub_00      	= $dominio_subArray['tipo_subtipo_codigo'];
                        $row_dominio_sub_01      	= $dominio_subArray['estado_tipo_subtipo_codigo'];
                        $row_dominio_sub_02      	= $dominio_subArray['estado_tipo_subtipo_nombre'];
                        $row_dominio_sub_03      	= $dominio_subArray['subtipo_codigo'];
                        $row_dominio_sub_04      	= $dominio_subArray['subtipo_nombre'];
                        $row_dominio_sub_05      	= $dominio_subArray['tipo_codigo'];
                        $row_dominio_sub_06      	= $dominio_subArray['tipo_nombre'];
			
			            if ($row_dominio_00 == $row_dominio_sub_05) {
?>
												                <option value="<?php echo $row_dominio_sub_00; ?>"><?php echo $row_dominio_sub_06.' - '.$row_dominio_sub_04; ?></option>
<?php
			            }
		            }
	            }
?>
                                    		                </optgroup>
<?php
		    }
        }
    }
?>
                                		                </select>
                                                    </td>
                                                    <td>
                                                        <input id="auditadaPesoPromedio7" name="auditadaPesoPromedio7" class="form-control" type="number" step=".01" value="0" onchange="sumaTotal()">
                                                    </td>
                                                    <td>
                                                        <input id="auditadaCantidad7" name="auditadaCantidad7" class="form-control" type="number" onchange="sumaTotal()">
                                                    </th>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <select id="auditadaPropietario8" name="auditadaPropietario8" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> onchange="sumaTotal()">
                                                            <optgroup label="Propietario">
<?php
    if ($propietarioJSON['code'] == 200) {
        foreach ($propietarioJSON['data'] as $propietarioKey=>$propietarioArray) {
            $row_propietario_00  = $propietarioArray['establecimiento_propietario_codigo'];
            $row_propietario_01  = $propietarioArray['persona_nombre'].' '.$propietarioArray['persona_apellido'];
            $row_propietario_02  = $propietarioArray['persona_razon_social'];
            $row_propietario_03  = $propietarioArray['persona_documento'];
            $row_propietario_04  = $propietarioArray['persona_telefono'];
            $row_propietario_05  = $propietarioArray['persona_correo_electronico'];
            $row_propietario_06  = $propietarioArray['establecimiento_propietario_marca'];
?>
												                <option value="<?php echo $row_propietario_00; ?>"><?php echo $row_propietario_06; ?></option>
<?php
        }
    }
?>
												            </optgroup>
								                        </select>
                                                    </td>
                                                    <td> 
                                                        <select id="auditadaOrigen8" name="auditadaOrigen8" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> onchange="sumaTotal()">
                                                            <optgroup label="Origen">
                                                                <option value="" selected disabled>Seleccionar</option>
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_tipo_00          	= $dominioArray['estado_dominio_codigo'];
            $row_tipo_01          	= $dominioArray['dominio_codigo'];
            $row_tipo_02          	= $dominioArray['dominio_nombre'];
            $row_tipo_03          	= $dominioArray['dominio_valor'];
            $row_tipo_04         	= $dominioArray['dominio_observacion'];

            if ($row_tipo_00 == 1 && $row_tipo_03 == 'ANIMALORIGEN') {
?>
												                <option value="<?php echo $row_tipo_01; ?>"><?php echo $row_tipo_02; ?></option>
<?php
            }
        }
    }
?>
												            </optgroup>
								                        </select>
                                                    </td>
                                                    <td> 
                                                        <select id="auditadaRaza8" name="auditadaRaza8" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> onchange="sumaTotal()">
                                                            <optgroup label="Raza">
                                                                <option value="" selected disabled>Seleccionar</option>
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_tipo_00          	= $dominioArray['estado_dominio_codigo'];
            $row_tipo_01          	= $dominioArray['dominio_codigo'];
            $row_tipo_02          	= $dominioArray['dominio_nombre'];
            $row_tipo_03          	= $dominioArray['dominio_valor'];
            $row_tipo_04         	= $dominioArray['dominio_observacion'];

            if ($row_tipo_00 == 1 && $row_tipo_03 == 'ANIMALRAZA') {
?>
												                <option value="<?php echo $row_tipo_01; ?>"><?php echo $row_tipo_02; ?></option>
<?php
            }
        }
    }
?>
												            </optgroup>
								                        </select>
                                                    </td>
                                                    <td>
                                                        <select id="auditadaCategoria8" name="auditadaCategoria8" class="select2 form-control custom-select" style="width: 100%; height:36px;" onchange="sumaTotal()">
                                                            <option value="" selected disabled>Seleccionar</option>
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_dominio_00      	= $dominioArray['dominio_codigo'];
            $row_dominio_01      	= $dominioArray['estado_dominio_codigo'];
            $row_dominio_02      	= $dominioArray['dominio_nombre'];
            $row_dominio_03      	= $dominioArray['dominio_valor'];

            if ($row_dominio_01 == 1 && $row_dominio_03 == "ANIMALCATEGORIA") {
?>
                                  			                <optgroup label="<?php echo $row_dominio_02; ?>">
								
<?php
                if ($dominio_subJSON['code'] == 200) {
                    foreach ($dominio_subJSON['data'] as $dominio_subKey=>$dominio_subArray) {
                        $row_dominio_sub_00      	= $dominio_subArray['tipo_subtipo_codigo'];
                        $row_dominio_sub_01      	= $dominio_subArray['estado_tipo_subtipo_codigo'];
                        $row_dominio_sub_02      	= $dominio_subArray['estado_tipo_subtipo_nombre'];
                        $row_dominio_sub_03      	= $dominio_subArray['subtipo_codigo'];
                        $row_dominio_sub_04      	= $dominio_subArray['subtipo_nombre'];
                        $row_dominio_sub_05      	= $dominio_subArray['tipo_codigo'];
                        $row_dominio_sub_06      	= $dominio_subArray['tipo_nombre'];
			
			            if ($row_dominio_00 == $row_dominio_sub_05) {
?>
												                <option value="<?php echo $row_dominio_sub_00; ?>"><?php echo $row_dominio_sub_06.' - '.$row_dominio_sub_04; ?></option>
<?php
			            }
		            }
	            }
?>
                                    		                </optgroup>
<?php
		    }
        }
    }
?>
                                		                </select>
                                                    </td>
                                                    <td>
                                                        <input id="auditadaPesoPromedio8" name="auditadaPesoPromedio8" class="form-control" type="number" step=".01" value="0" onchange="sumaTotal()">
                                                    </td>
                                                    <td>
                                                        <input id="auditadaCantidad8" name="auditadaCantidad8" class="form-control" type="number" onchange="sumaTotal()">
                                                    </th>
                                                </tr>
                                                
                                                <tr>
                                                    <td>
                                                        <select id="auditadaPropietario9" name="auditadaPropietario9" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> onchange="sumaTotal()">
                                                            <optgroup label="Propietario">
<?php
    if ($propietarioJSON['code'] == 200) {
        foreach ($propietarioJSON['data'] as $propietarioKey=>$propietarioArray) {
            $row_propietario_00  = $propietarioArray['establecimiento_propietario_codigo'];
            $row_propietario_01  = $propietarioArray['persona_nombre'].' '.$propietarioArray['persona_apellido'];
            $row_propietario_02  = $propietarioArray['persona_razon_social'];
            $row_propietario_03  = $propietarioArray['persona_documento'];
            $row_propietario_04  = $propietarioArray['persona_telefono'];
            $row_propietario_05  = $propietarioArray['persona_correo_electronico'];
            $row_propietario_06  = $propietarioArray['establecimiento_propietario_marca'];
?>
												                <option value="<?php echo $row_propietario_00; ?>"><?php echo $row_propietario_06; ?></option>
<?php
        }
    }
?>
												            </optgroup>
								                        </select>
                                                    </td>
                                                    <td> 
                                                        <select id="auditadaOrigen9" name="auditadaOrigen9" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> onchange="sumaTotal()">
                                                            <optgroup label="Origen">
                                                                <option value="" selected disabled>Seleccionar</option>
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_tipo_00          	= $dominioArray['estado_dominio_codigo'];
            $row_tipo_01          	= $dominioArray['dominio_codigo'];
            $row_tipo_02          	= $dominioArray['dominio_nombre'];
            $row_tipo_03          	= $dominioArray['dominio_valor'];
            $row_tipo_04         	= $dominioArray['dominio_observacion'];

            if ($row_tipo_00 == 1 && $row_tipo_03 == 'ANIMALORIGEN') {
?>
												                <option value="<?php echo $row_tipo_01; ?>"><?php echo $row_tipo_02; ?></option>
<?php
            }
        }
    }
?>
												            </optgroup>
								                        </select>
                                                    </td>
                                                    <td> 
                                                        <select id="auditadaRaza9" name="auditadaRaza9" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> onchange="sumaTotal()">
                                                            <optgroup label="Raza">
                                                                <option value="" selected disabled>Seleccionar</option>
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_tipo_00          	= $dominioArray['estado_dominio_codigo'];
            $row_tipo_01          	= $dominioArray['dominio_codigo'];
            $row_tipo_02          	= $dominioArray['dominio_nombre'];
            $row_tipo_03          	= $dominioArray['dominio_valor'];
            $row_tipo_04         	= $dominioArray['dominio_observacion'];

            if ($row_tipo_00 == 1 && $row_tipo_03 == 'ANIMALRAZA') {
?>
												                <option value="<?php echo $row_tipo_01; ?>"><?php echo $row_tipo_02; ?></option>
<?php
            }
        }
    }
?>
												            </optgroup>
								                        </select>
                                                    </td>
                                                    <td>
                                                        <select id="auditadaCategoria9" name="auditadaCategoria9" class="select2 form-control custom-select" style="width: 100%; height:36px;" onchange="sumaTotal()">
                                                            <option value="" selected disabled>Seleccionar</option>
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_dominio_00      	= $dominioArray['dominio_codigo'];
            $row_dominio_01      	= $dominioArray['estado_dominio_codigo'];
            $row_dominio_02      	= $dominioArray['dominio_nombre'];
            $row_dominio_03      	= $dominioArray['dominio_valor'];

            if ($row_dominio_01 == 1 && $row_dominio_03 == "ANIMALCATEGORIA") {
?>
                                  			                <optgroup label="<?php echo $row_dominio_02; ?>">
								
<?php
                if ($dominio_subJSON['code'] == 200) {
                    foreach ($dominio_subJSON['data'] as $dominio_subKey=>$dominio_subArray) {
                        $row_dominio_sub_00      	= $dominio_subArray['tipo_subtipo_codigo'];
                        $row_dominio_sub_01      	= $dominio_subArray['estado_tipo_subtipo_codigo'];
                        $row_dominio_sub_02      	= $dominio_subArray['estado_tipo_subtipo_nombre'];
                        $row_dominio_sub_03      	= $dominio_subArray['subtipo_codigo'];
                        $row_dominio_sub_04      	= $dominio_subArray['subtipo_nombre'];
                        $row_dominio_sub_05      	= $dominio_subArray['tipo_codigo'];
                        $row_dominio_sub_06      	= $dominio_subArray['tipo_nombre'];
			
			            if ($row_dominio_00 == $row_dominio_sub_05) {
?>
												                <option value="<?php echo $row_dominio_sub_00; ?>"><?php echo $row_dominio_sub_06.' - '.$row_dominio_sub_04; ?></option>
<?php
			            }
		            }
	            }
?>
                                    		                </optgroup>
<?php
		    }
        }
    }
?>
                                		                </select>
                                                    </td>
                                                    <td>
                                                        <input id="auditadaPesoPromedio9" name="auditadaPesoPromedio9" class="form-control" type="number" step=".01" value="0" onchange="sumaTotal()">
                                                    </td>
                                                    <td>
                                                        <input id="auditadaCantidad9" name="auditadaCantidad9" class="form-control" type="number" onchange="sumaTotal()">
                                                    </th>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <select id="auditadaPropietario10" name="auditadaPropietario10" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> onchange="sumaTotal()">
                                                            <optgroup label="Propietario">
<?php
    if ($propietarioJSON['code'] == 200) {
        foreach ($propietarioJSON['data'] as $propietarioKey=>$propietarioArray) {
            $row_propietario_00  = $propietarioArray['establecimiento_propietario_codigo'];
            $row_propietario_01  = $propietarioArray['persona_nombre'].' '.$propietarioArray['persona_apellido'];
            $row_propietario_02  = $propietarioArray['persona_razon_social'];
            $row_propietario_03  = $propietarioArray['persona_documento'];
            $row_propietario_04  = $propietarioArray['persona_telefono'];
            $row_propietario_05  = $propietarioArray['persona_correo_electronico'];
            $row_propietario_06  = $propietarioArray['establecimiento_propietario_marca'];
?>
												                <option value="<?php echo $row_propietario_00; ?>"><?php echo $row_propietario_06; ?></option>
<?php
        }
    }
?>
												            </optgroup>
								                        </select>
                                                    </td>
                                                    <td> 
                                                        <select id="auditadaOrigen10" name="auditadaOrigen10" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> onchange="sumaTotal()">
                                                            <optgroup label="Origen">
                                                                <option value="" selected disabled>Seleccionar</option>
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_tipo_00          	= $dominioArray['estado_dominio_codigo'];
            $row_tipo_01          	= $dominioArray['dominio_codigo'];
            $row_tipo_02          	= $dominioArray['dominio_nombre'];
            $row_tipo_03          	= $dominioArray['dominio_valor'];
            $row_tipo_04         	= $dominioArray['dominio_observacion'];

            if ($row_tipo_00 == 1 && $row_tipo_03 == 'ANIMALORIGEN') {
?>
												                <option value="<?php echo $row_tipo_01; ?>"><?php echo $row_tipo_02; ?></option>
<?php
            }
        }
    }
?>
												            </optgroup>
								                        </select>
                                                    </td>
                                                    <td> 
                                                        <select id="auditadaRaza10" name="auditadaRaza10" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> onchange="sumaTotal()">
                                                            <optgroup label="Raza">
                                                                <option value="" selected disabled>Seleccionar</option>
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_tipo_00          	= $dominioArray['estado_dominio_codigo'];
            $row_tipo_01          	= $dominioArray['dominio_codigo'];
            $row_tipo_02          	= $dominioArray['dominio_nombre'];
            $row_tipo_03          	= $dominioArray['dominio_valor'];
            $row_tipo_04         	= $dominioArray['dominio_observacion'];

            if ($row_tipo_00 == 1 && $row_tipo_03 == 'ANIMALRAZA') {
?>
												                <option value="<?php echo $row_tipo_01; ?>"><?php echo $row_tipo_02; ?></option>
<?php
            }
        }
    }
?>
												            </optgroup>
								                        </select>
                                                    </td>
                                                    <td>
                                                        <select id="auditadaCategoria10" name="auditadaCategoria10" class="select2 form-control custom-select" style="width: 100%; height:36px;" onchange="sumaTotal()">
                                                            <option value="" selected disabled>Seleccionar</option>
<?php
    if ($dominioJSON['code'] == 200) {
        foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) {
            $row_dominio_00      	= $dominioArray['dominio_codigo'];
            $row_dominio_01      	= $dominioArray['estado_dominio_codigo'];
            $row_dominio_02      	= $dominioArray['dominio_nombre'];
            $row_dominio_03      	= $dominioArray['dominio_valor'];

            if ($row_dominio_01 == 1 && $row_dominio_03 == "ANIMALCATEGORIA") {
?>
                                  			                <optgroup label="<?php echo $row_dominio_02; ?>">
								
<?php
                if ($dominio_subJSON['code'] == 200) {
                    foreach ($dominio_subJSON['data'] as $dominio_subKey=>$dominio_subArray) {
                        $row_dominio_sub_00      	= $dominio_subArray['tipo_subtipo_codigo'];
                        $row_dominio_sub_01      	= $dominio_subArray['estado_tipo_subtipo_codigo'];
                        $row_dominio_sub_02      	= $dominio_subArray['estado_tipo_subtipo_nombre'];
                        $row_dominio_sub_03      	= $dominio_subArray['subtipo_codigo'];
                        $row_dominio_sub_04      	= $dominio_subArray['subtipo_nombre'];
                        $row_dominio_sub_05      	= $dominio_subArray['tipo_codigo'];
                        $row_dominio_sub_06      	= $dominio_subArray['tipo_nombre'];
			
			            if ($row_dominio_00 == $row_dominio_sub_05) {
?>
												                <option value="<?php echo $row_dominio_sub_00; ?>"><?php echo $row_dominio_sub_06.' - '.$row_dominio_sub_04; ?></option>
<?php
			            }
		            }
	            }
?>
                                    		                </optgroup>
<?php
		    }
        }
    }
?>
                                		                </select>
                                                    </td>
                                                    <td>
                                                        <input id="auditadaPesoPromedio10" name="auditadaPesoPromedio10" class="form-control" type="number" step=".01" value="0" onchange="sumaTotal()">
                                                    </td>
                                                    <td>
                                                        <input id="auditadaCantidad10" name="auditadaCantidad10" class="form-control" type="number" onchange="sumaTotal()">
                                                    </th>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>PROPIETARIO</th>
                                                    <th>ORIGEN</th>
                                                    <th>RAZA</th>
                                                    <th>CATEGOR&Iacute;A - SUBCATEGOR&Iacute;A</th>
                                                    <th>PESO PROMEDIO</th>
                                                    <th>CANTIDAD</th>
                                                </tr>
                                                <tr style="background-color:rgba(0,0,0,0.05); font-weight: bold;">
                                                    <th colspan="5">TOTAL ADULTO</th>
                                                    <th style="text-align:right;" id="totalCantAdulto">0</th>
                                                </tr>
                                                <tr style="font-weight: bold;">
                                                    <th colspan="5">TOTAL TENERO</th>
                                                    <th style="text-align:right;" id="totalCantTernero">0</th>
                                                </tr>
                                                <tr style="background-color:rgba(0,0,0,0.05); font-weight: bold;">
                                                    <th colspan="5">TOTAL POBLACI&Oacute;N BOVINA</th>
                                                    <th style="text-align:right;" id="totalCantGeneral">0</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <br/>
                                    <br/>
                                    <button type="submit" class="btn btn-info"> Guardar </button>
                                    <a role="button" class="btn btn-dark" href="../public/ot_detalle_l.php?mode=R&codigo=<?php echo $workCodigo; ?>">Volver</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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
?>
    
    <script src="#"></script>
    <script>
        function sumaTotal() {
            var rowTotAdu = document.getElementById("totalCantAdulto");
            var rowTotTer = document.getElementById("totalCantTernero");
            var rowTotGen = document.getElementById("totalCantGeneral");

            var totAdu = 0;
            var totTer = 0;
            var totPob = 0;

            for (let index = 1; index < 11; index++) {
                var rowCate = Number(document.getElementById("auditadaCategoria"+index).value);
                var rowCant = Number(document.getElementById("auditadaCantidad"+index).value);

                if (rowCate == 29 || rowCate == 30) {
                    totTer = totTer + rowCant;
                } else {
                    totAdu = totAdu + rowCant;
                }
            }

            totPob = totTer + totAdu;

            rowTotAdu.innerHTML = totAdu;
            rowTotTer.innerHTML = totTer;
            rowTotGen.innerHTML = totPob;
        }
    </script>
</body>
</html>