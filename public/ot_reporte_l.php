<?php
    require '../class/function/curl_api.php';
    require '../class/function/function.php';
    require '../class/session/session_system.php';

    $workEstablecimiento    = $_GET['id1'];
    $workOrdenTrabajo       = $_GET['id2'];
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
                        <h4 class="page-title">Listado</h4>
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
                                        <a href="../public/establecimiento_ot_l.php?id1=<?php echo $workEstablecimiento; ?>">Orden de Trabajo</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Reporte</li>
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
                                <div class="row">
                                	<h4 class="col-10 card-title">Reportes</h4>
								</div>
                                <div class="table-responsive">
                                    <table id="tableLoad" class="table table-striped table-bordered">
                                        <thead id="tableCodigo" class="<?php echo $workEstablecimiento; ?>">
                                            <tr>
                                                <th>REPORTE</th>
                                                <th>DESCRIPCI&Oacute;N</th>
                                            </tr>
                                        </thead>
                                        <tboby>
                                            <tr>
                                                <td><a href="../report/ot_parte_diario.php?id1=<?php echo $workOrdenTrabajo; ?>" target="_blank">PARTE DIARIO</a></td>
                                                <td>DETALLE DE LAS EXISTENCIAS DETALLANDO POR FECHA, PROTERO, ORIGEN, RAZA, CATEGOR&Iacute;A, SUBCATEGOR&Iacute;A</td> 
                                            </tr>
                                            <tr>
                                                <td><a href="../report/ot_existencia_poblacion.php?id1=<?php echo $workOrdenTrabajo; ?>" target="_blank">EXISTENCIA POR POBLACI&Oacute;N</a></td>
                                                <td>DETALLE DE LAS EXISTENCIAS DETALLANDO POR POBLACI&Oacute;N, CATEGOR&Iacute;A, SUBCATEGOR&Iacute;A</td> 
                                            </tr>
                                            <tr>
                                                <td><a href="../report/ot_existencia_origen.php?id1=<?php echo $workOrdenTrabajo; ?>" target="_blank">EXISTENCIA POR ORIGEN</a></td>
                                                <td>DETALLE DE LAS EXISTENCIAS DETALLANDO POR ORIGEN, CATEGOR&Iacute;A, SUBCATEGOR&Iacute;A</td> 
                                            </tr>
                                            <tr>
                                                <td><a href="../report/ot_existencia_potrero.php?id1=<?php echo $workOrdenTrabajo; ?>" target="_blank">EXISTENCIA POR POTRERO</a></td>
                                                <td>DETALLE DE LAS EXISTENCIAS DETALLANDO POR POTRERO, CATEGOR&Iacute;A, SUBCATEGOR&Iacute;A</td> 
                                            </tr>
                                            <tr>
                                                <td><a href="../report/ot_existencia_propietario.php?id1=<?php echo $workOrdenTrabajo; ?>" target="_blank">EXISTENCIA POR PROPIETARIO</a></td>
                                                <td>DETALLE DE LAS EXISTENCIAS DETALLANDO POR PROPIETARIO, CATEGOR&Iacute;A, SUBCATEGOR&Iacute;A</td> 
                                            </tr>
                                            <tr>
                                                <td><a href="../report/ot_existencia_raza.php?id1=<?php echo $workOrdenTrabajo; ?>" target="_blank">EXISTENCIA POR RAZA</a></td>
                                                <td>DETALLE DE LAS EXISTENCIAS DETALLANDO POR RAZA, CATEGOR&Iacute;A, SUBCATEGOR&Iacute;A</td> 
                                            </tr>
                                        </tboby>
                                        <tfoot>
                                            <tr>
                                                <th>REPORTE</th>
                                                <th>DESCRIPCI&Oacute;N</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
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
?>

</body>
</html>