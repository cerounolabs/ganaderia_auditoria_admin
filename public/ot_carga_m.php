<?php
    require '../class/function/curl_api.php';
    require '../class/function/function.php';
    require '../class/session/session_system.php';

    $workCodigo             = $_GET['codigo'];
    $workModo               = $_GET['mode'];
    $dominioJSON            = get_curl('500');
    $dominio_subJSON        = get_curl('600/dominio/CATEGORIASUBCATEGORIA');

    if ($workCodigo <> 0) {
        $otJSON             = get_curl('1000/'.$workCodigo);
        
		if ($otJSON['code'] == 200){
			$row_ot_00  = $otJSON['data'][0]['ot_codigo'];
			$row_ot_01	= $otJSON['data'][0]['estado_ot_codigo'];
			$row_ot_02	= $otJSON['data'][0]['estado_ot_nombre'];
			$row_ot_03	= $otJSON['data'][0]['establecimiento_codigo'];
			$row_ot_04	= $otJSON['data'][0]['establecimiento_nombre'];
			$row_ot_05	= $otJSON['data'][0]['establecimiento_sigor'];
			$row_ot_06	= $otJSON['data'][0]['establecimiento_observacion'];
			$row_ot_07	= $otJSON['data'][0]['ot_numero'];
            $row_ot_08	= $otJSON['data'][0]['ot_fecha_inicio_trabajo'];
            $row_ot_09	= $otJSON['data'][0]['ot_fecha_inicio_trabajo_2'];
            $row_ot_10	= $otJSON['data'][0]['ot_fecha_final_trabajo'];
            $row_ot_11	= $otJSON['data'][0]['ot_fecha_final_trabajo_2'];
            $row_ot_12	= $otJSON['data'][0]['ot_observacion'];
        }

        $potreroJSON            = get_curl('900/establecimiento/'.$row_ot_03);
        $propietarioJSON        = get_curl('1400/establecimiento/'.$row_ot_03);
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
                        <div class="card border-primary">
                            <div class="card-header bg-primary">
                                <h4 class="m-b-0 text-white"><?php echo $row_ot_04; ?></h4></div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <p class="card-text"><span style="font-weight:bold;">Estado:</span> <?php echo $row_ot_02; ?></p>
                                    </div>
                                    <div class="col-md-3">
                                        <p class="card-text"><span style="font-weight:bold;">Fecha Inicio:</span>  <?php echo $row_ot_09; ?></p>
                                    </div>
                                    <div class="col-md-3">
                                        <p class="card-text"><span style="font-weight:bold;">Fecha Fin:</span>  <?php echo $row_ot_11; ?></p>
                                    </div>
                                    <div class="col-md-3">
                                        <p class="card-text"><span style="font-weight:bold;">O.T. Nro.:</span> <?php echo $row_ot_07; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card border-info">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">O.T. CARGA</h4>
                            </div>
                            <div class="card-body">
                                <h4 class="col-12 card-title" style="text-align: right;">
                                    <button type="submit" id="addRow" class="btn btn-info"> <i class="ti-plus"></i> Agregar Item </button>
                                </h4>
                                <form id="form" data-parsley-validate class="m-t-30" method="post" action="../class/crud/ot_carga_a.php">
                                    <div class="form-group">
                                        <input id="workCodigo" name="workCodigo" class="form-control" type="hidden" placeholder="Codigo" value="<?php echo $workCodigo; ?>" required readonly>
                                        <input id="workModo" name="workModo" class="form-control" type="hidden" placeholder="Modo" value="<?php echo $workModo; ?>" required readonly>
                                        <input id="workCantidad" name="workCantidad" class="form-control" type="hidden" placeholder="Modo" value="1" required readonly>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="poblacionTipo"> Tipo </label>
                                                <select id="poblacionTipo" name="poblacionTipo" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> required>
                                                    <optgroup label="Tipo">
                                                        <option value='' selected disabled>Seleccionar</option>
												        <option value="1"> Planilla Existencia </option>
                                                        <option value="2"> Planilla Auditada </option>
												    </optgroup>
								                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="poblacionPotrero">Secci&oacute;n - Potrero</label>
                                                <select id="poblacionPotrero" name="poblacionPotrero" class="select2 form-control custom-select" style="width: 100%; height:36px;" <?php echo $workReadonly; ?> required>
                                                    <optgroup label="Secci&oacute;n - Potrero">
                                                        <option value='' selected disabled>Seleccionar</option>
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

                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="poblacionFecha">Fecha</label>
                                                <input id="poblacionFecha" name="poblacionFecha" class="form-control" type="date" placeholder="Nombre" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="tableLoad" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>ELIMINAR</th>
                                                    <th>PROPIETARIO</th>
                                                    <th>ORIGEN</th>
                                                    <th>RAZA</th>
                                                    <th>CATEGOR&Iacute;A - SUBCATEGOR&Iacute;A</th>
                                                    <th>PESO PROMEDIO</th>
                                                    <th>CANTIDAD</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>ELIMINAR</th>
                                                    <th>PROPIETARIO</th>
                                                    <th>ORIGEN</th>
                                                    <th>RAZA</th>
                                                    <th>CATEGOR&Iacute;A - SUBCATEGOR&Iacute;A</th>
                                                    <th>PESO PROMEDIO</th>
                                                    <th>CANTIDAD</th>
                                                </tr>
                                                <tr style="background-color:rgba(0,0,0,0.05); font-weight: bold;">
                                                    <th colspan="6">TOTAL ADULTO</th>
                                                    <th style="text-align:right;" id="totalCantAdulto">0</th>
                                                </tr>
                                                <tr style="font-weight: bold;">
                                                    <th colspan="6">TOTAL TENERO</th>
                                                    <th style="text-align:right;" id="totalCantTernero">0</th>
                                                </tr>
                                                <tr style="background-color:rgba(0,0,0,0.05); font-weight: bold;">
                                                    <th colspan="6">TOTAL POBLACI&Oacute;N BOVINA</th>
                                                    <th style="text-align:right;" id="totalCantGeneral">0</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <br/>
                                    <br/>
                                    <button type="submit" class="btn btn-info"> Guardar </button>
                                    <a role="button" class="btn btn-dark" href="../public/ot_carga_l.php?mode=R&codigo=<?php echo $workCodigo; ?>">Volver</a>
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
    <script>
        $(document).ready(function() {
            var tabDat = $('#tableLoad').DataTable({
                "paging":   false,
                "ordering": false,
                "searching": false,
                "info":     false
            });
            var colCod = 1;

            $('#addRow').on( 'click', function () {
                tabDat.row.add( [
                    "<td><button id='poblacionCodigo"+ colCod +"' type='button' class='btn btn-danger'><i class='ti-trash'></i></button></td>",
                    "<td><select id='poblacionPropietario"+ colCod +"' name='poblacionPropietario"+ colCod +"' class='select2 form-control custom-select' style='width: 100%; height:36px;' <?php echo $workReadonly; ?> onchange='sumaTotal()' required><optgroup label='Propietario'><?php if ($propietarioJSON['code'] == 200) { foreach ($propietarioJSON['data'] as $propietarioKey=>$propietarioArray) { $row_propietario_00  = $propietarioArray['establecimiento_propietario_codigo']; $row_propietario_01  = $propietarioArray['establecimiento_propietario_marca']; ?> <option value='<?php echo $row_propietario_00; ?>'><?php echo $row_propietario_01; ?></option><?php } } ?></optgroup></select></td>",
                    "<td><select id='poblacionOrigen"+ colCod +"' name='poblacionOrigen"+ colCod +"' class='select2 form-control custom-select' style='width: 100%; height:36px;' <?php echo $workReadonly; ?> onchange='sumaTotal()' required><?php if ($dominioJSON['code'] == 200) { foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) { $row_tipo_00 = $dominioArray['estado_dominio_codigo']; $row_tipo_01 = $dominioArray['dominio_codigo']; $row_tipo_02 = $dominioArray['dominio_nombre']; $row_tipo_03 = $dominioArray['dominio_valor']; $select = ''; if ($row_tipo_00 == 1 && $row_tipo_03 == 'ANIMALORIGEN') { if ($row_tipo_01 == 21) { $select = 'selected'; }  ?> <option value='<?php echo $row_tipo_01; ?>' <?php echo $select; ?>><?php echo $row_tipo_02; ?></option><?php } } } ?></optgroup></select></td>",
                    "<td><select id='poblacionRaza"+ colCod +"' name='poblacionRaza"+ colCod +"' class='select2 form-control custom-select' style='width: 100%; height:36px;' <?php echo $workReadonly; ?> onchange='sumaTotal()' required><optgroup label='Raza'><?php if ($dominioJSON['code'] == 200) { foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) { $row_tipo_00 = $dominioArray['estado_dominio_codigo']; $row_tipo_01 = $dominioArray['dominio_codigo']; $row_tipo_02 = $dominioArray['dominio_nombre']; $row_tipo_03 = $dominioArray['dominio_valor']; $row_tipo_04 = $dominioArray['dominio_observacion']; $select = ''; if ($row_tipo_00 == 1 && $row_tipo_03 == 'ANIMALRAZA') { if ($row_tipo_01 == 86) { $select = 'selected'; }?> <option value='<?php echo $row_tipo_01; ?>' <?php echo $select; ?>><?php echo $row_tipo_02; ?></option><?php } } } ?></optgroup></select></td>",
                    "<td><select id='poblacionCategoria"+ colCod +"' name='poblacionCategoria"+ colCod +"' class='select2 form-control custom-select' style='width: 100%; height:36px;' onchange='sumaTotal()' required><?php if ($dominioJSON['code'] == 200) { foreach ($dominioJSON['data'] as $dominioKey=>$dominioArray) { $row_dominio_00 = $dominioArray['dominio_codigo']; $row_dominio_01 = $dominioArray['estado_dominio_codigo']; $row_dominio_02 = $dominioArray['dominio_nombre']; $row_dominio_03 = $dominioArray['dominio_valor']; if ($row_dominio_01 == 1 && $row_dominio_03 == 'ANIMALCATEGORIA') { ?> <optgroup label='<?php echo $row_dominio_02; ?>'> <?php if ($dominio_subJSON['code'] == 200) { foreach ($dominio_subJSON['data'] as $dominio_subKey=>$dominio_subArray) { $row_dominio_sub_00 = $dominio_subArray['tipo_subtipo_codigo']; $row_dominio_sub_01 = $dominio_subArray['estado_tipo_subtipo_codigo']; $row_dominio_sub_02 = $dominio_subArray['estado_tipo_subtipo_nombre']; $row_dominio_sub_03 = $dominio_subArray['subtipo_codigo']; $row_dominio_sub_04 = $dominio_subArray['subtipo_nombre']; $row_dominio_sub_05 = $dominio_subArray['tipo_codigo']; $row_dominio_sub_06 = $dominio_subArray['tipo_nombre']; if ($row_dominio_00 == $row_dominio_sub_05) { ?> <option value='<?php echo $row_dominio_sub_00; ?>'><?php echo $row_dominio_sub_06.' - '.$row_dominio_sub_04; ?></option><?php } } } ?> </optgroup> <?php } } } ?> </select></td>",
                    "<td><input  id='poblacionPesoPromedio"+ colCod +"' name='poblacionPesoPromedio"+ colCod +"' class='form-control' type='number' step='.01' value='0' onchange='sumaTotal()'></td>",
                    "<td><input  id='poblacionCantidad"+ colCod +"' name='poblacionCantidad"+ colCod +"' class='form-control' type='number' onchange='sumaTotal()' required></td>"
                ] ).draw( true );
                colCod++;
            } );

            $('#tableLoad').on('click', '.btn-danger', function () {
                tabDat.row($(this).parents('tr')).remove().draw(false);
                sumaTotal();
            });

            $('#addRow').click(); 
        } );

        function sumaTotal() {
            var rowTotCan = document.getElementById("workCantidad");
            var rowTotAdu = document.getElementById("totalCantAdulto");
            var rowTotTer = document.getElementById("totalCantTernero");
            var rowTotGen = document.getElementById("totalCantGeneral");

            var totCan = 0;
            var totAdu = 0;
            var totTer = 0;
            var totPob = 0;

            for (let index = 1; index < 100; index++) {
                var existeSiNo = isInPage(document.getElementById("poblacionCategoria"+index));

                if (existeSiNo == false) {
                } else {
                    var rowCate = Number(document.getElementById("poblacionCategoria"+index).value);
                    var rowCant = Number(document.getElementById("poblacionCantidad"+index).value);

                    if (rowCate == 29 || rowCate == 30) {
                        totTer = totTer + rowCant;
                    } else {
                        totAdu = totAdu + rowCant;
                    }

                    totCan = index;
                }
            }

            rowTotCan.value     = totCan;
            totPob              = totTer + totAdu;
            rowTotAdu.innerHTML = totAdu;
            rowTotTer.innerHTML = totTer;
            rowTotGen.innerHTML = totPob;
        }

        function isInPage(node) {
            return (node === document.body) ? false : document.body.contains(node);
        }
    </script>
</body>
</html>