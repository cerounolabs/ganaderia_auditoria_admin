<?php
    require '../class/function/curl_api.php';
    require '../class/function/function.php';
    require '../class/session/session_system.php';
    
	$dominioNombre 	= $_GET['dominio'];

	switch($dominioNombre){
		case 'ESPECIERAZA':
            $dominioTitulo  = 'Especie/Raza';
            $dominioTit1    = 'ESPECIE';
            $dominioTit2    = 'RAZA';
            break;
        case 'CATEGORIASUBCATEGORIA':
            $dominioTitulo  = 'Categoria/SubCategoria';
            $dominioTit1    = 'CATEGORIA';
            $dominioTit2    = 'SUBCATEGORIA';
            break;
        case 'ROLACCESO':
            $dominioTitulo  = 'Rol/Acceso';
            $dominioTit1    = 'ROL';
            $dominioTit2    = 'ACCESO';
            break;
        case 'ROLPROGRAMA':
            $dominioTitulo  = 'Rol/Programa';
            $dominioTit1    = 'ROL';
            $dominioTit2    = 'PROGRAMA';
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
                                    <li class="breadcrumb-item active" aria-current="page">Par&aacute;metro <?php echo $dominioTitulo; ?></li>
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
                            		<h4 class="col-10 card-title">Par&aacute;metro Tipo <?php echo $dominioTitulo; ?></h4>
                                	<h4 class="col-2 card-title" style="text-align: right;">
                                		<a class="btn btn-info" href="../public/dominio_sub_m.php?dominio=<?php echo $dominioNombre; ?>&mode=C&codigo=0" role="button" title="Agregar"><i class="ti-plus"></i></a>
                                	</h4>
                            	</div>
                                <div class="table-responsive">
                                    <table id="tableLoad" class="table table-striped table-bordered">
                                        <thead id="tableDominio" class="<?php echo $dominioNombre; ?>">
                                            <tr>
                                                <th>C&Oacute;DIGO</th>
                                                <th>ESTADO</th>
                                                <th><?php echo $dominioTit1; ?></th>
                                                <th><?php echo $dominioTit2; ?></th>
                                                <th style="width: 130px;">&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>C&Oacute;DIGO</th>
                                                <th>ESTADO</th>
                                                <th><?php echo $dominioTit1; ?></th>
                                                <th><?php echo $dominioTit2; ?></th>
                                                <th style="width: 130px;">&nbsp;</th>
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
    
    <script src="../js/dominio_sub.js"></script>
</body>
</html>