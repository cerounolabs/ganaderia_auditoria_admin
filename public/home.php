<?php
    require '../class/function/curl_api.php';
    require '../class/function/function.php';
    require '../class/session/session_system.php';

    if (isset($_GET['code'])){
        $codeRest 		= $_GET['code'];
    } else {
        $codeRest 		= '';
    }

    if (isset($_GET['msg'])){
        $msgRest 		= $_GET['msg'];
    } else {
        $msgRest 		= '';
    }

    $ganaderoJSON   = get_curl('1000/resumen/establecimiento/'.$sysUsu);
    $charGanadero   = getCantEstablecimiento($ganaderoJSON);
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
                        <h4 class="page-title">Home</h4>
                        <div class="d-flex align-items-center"></div>
                    </div>
                    <div class="col-7 align-self-center">
                        <div class="d-flex no-block justify-content-end align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="../public/home.php">Home</a>
                                    </li>
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
                                <h4 class="card-title">POBLACI&Oacute;N BOVINA X ESTABLECIMIENTO (AUDITADA)</h4>
                                <div id="resumenGanadero"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                	<h4 class="col-10 card-title">Establecimiento</h4>
                                	<h4 class="col-2 card-title" style="text-align: right;">
                                	</h4>
								</div>
                                <div class="table-responsive">
                                    <table id="tableLoad" class="table table-striped table-bordered">
                                        <thead id="tableCodigo" class="<?php echo $sysUsu; ?>">
                                            <tr>
                                                <th>C&Oacute;DIGO</th>
                                                <th>DISTRITO</th>
                                                <th>ESTABLECIMIENTO</th>
                                                <th>SIGOR</th>
                                                <th>CANTIDAD O.T.</th>
                                                <th>DETALLE O.T.</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>C&Oacute;DIGO</th>
                                                <th>DISTRITO</th>
                                                <th>ESTABLECIMIENTO</th>
                                                <th>SIGOR</th>
                                                <th>CANTIDAD O.T.</th>
                                                <th>DETALLE O.T.</th>
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
   
    if ($codeRest == 401) {
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
        $(function() {
            'use strict';

            var chart_01 = c3.generate({
                bindto: "#resumenGanadero",
                data: {
                    x : "x",
                    columns: [
                        ["x", <?php echo $charGanadero[0]; ?>],
                        ["Establecimiento", <?php echo $charGanadero[1]; ?>]
                    ],
                    type: "bar"
                },
                color: { 
                    pattern: ["#4fc3f7"] 
                },
                size: { 
                    //height: 163.6 
                },
                axis: {
                    x: {
                        type: "category"
                    },
                    y: {
                        tick: {
                            count: 3,
                            outer: false
                        }
                    }
                },
                legend: {
                    hide: false
                },
                grid: { 
                    x: { 
                        show: true 
                    },
                    y: {
                        show: true
                    }
                },
                bar: {
                    space: 0.2,
                    width: 15
                }
            });
        });
    </script>
    
    <script src="../js/home.js"></script>
</body>
</html>