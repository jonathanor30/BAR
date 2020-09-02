<!DOCTYPE html>
<html lang="<?php echo LANG; ?>">

<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="id=edge">
   <meta name="generator" content="<?php echo NOMBRE_APP; ?>" />
   <meta name="description" content="" />
   <meta name="theme-color" content="#33333" />
   <title><?php echo $datos['titulo']; ?></title>
   <link rel="shortcut icon" href="<?php echo RUTA_URL; ?>/public/img/icon.ico" />
   <link rel="apple-touch-icon" sizes="150x150" href="<?php echo RUTA_URL; ?>/public/img/icon.png" />
   <?php if (isset($_SESSION['modeView'])) : ?>
      <link rel="stylesheet" href="<?php echo RUTA_URL; ?>/public/bootstrap/css/dark.min.css" id="linkestilo1" />
      <link rel="stylesheet" type="text/css" href="<?php echo RUTA_URL; ?>/public/css/styles_dark.css" id="linkestilo2">
   <?php else : ?>
      <link rel="stylesheet" type="text/css" href="<?php echo RUTA_URL; ?>/public/css/styles.css" id="linkestilo1">
      <link rel="stylesheet" href="<?php echo RUTA_URL; ?>/public/bootstrap/css/sb-admin-2.min.css" id="linkestilo2" />
   <?php endif ?>
   <link rel="stylesheet" href="<?php echo RUTA_URL; ?>/public/fontawesome/css/all.min.css" />
   <link rel="stylesheet" href="<?php echo RUTA_URL; ?>/public/css/alertify.min.css" />
   <link rel="stylesheet" href="<?php echo RUTA_URL; ?>/public/css/jquery-ui.css" />
   <script type="text/javascript" src="<?php echo RUTA_URL ?>/public/jquery/jquery.min.js"></script>
   <script type="text/javascript" src="<?php echo RUTA_URL; ?>/public/bootstrap/js/popper.min.js"></script>
   <script type="text/javascript" src="<?php echo RUTA_URL; ?>/public/bootstrap/js/bootstrap.min.js"></script>
   <script src="<?php echo RUTA_URL ?>/public/js/main.js"></script>
   <script type="text/javascript" src="<?php echo RUTA_URL ?>/public/js/alertify.min.js"></script>
   <script type="text/javascript" src="<?php echo RUTA_URL ?>/public/js/jquery-ui.js"></script>
   <?php if (isset($datos['dataTables'])) : ?>
      <?php echo $datos['dataTables']; ?>
   <?php endif; ?>
   <?php if (isset($datos['vueJS'])) : ?>
      <?php echo $datos['vueJS']; ?>
   <?php endif; ?>
</head>

<body id="body">
   <input type="hidden" id="ruta" value="<?php echo RUTA_URL ?>">
   <!-- envoltura de página -->
   <div id="wrapper">
      <!-- Acá inicia la barra lateral-->
      <ul class="navbar-nav bg-bar70 sidebar sidebar-dark accordion toggled" id="accordionSidebar">
         <!--Barra Lateral - Marca -->
         <?php if ($_SESSION['user_type'] != 1 && $_SESSION['user_type'] != 99) { ?>
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo RUTA_URL . SEPARATOR . $_SESSION['modulos'][0]->nombre_modulo ?>">
               <img class="logo img-fluid" src="<?php echo RUTA_URL; ?>/public/img/logo.png">
               <div class="sidebar-brand-text mx-3"><img class="logo img-fluid" src="<?php echo RUTA_URL; ?>/public/img/logo.png"></div>
            </a>
         <?php } else { ?>
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo RUTA_URL; ?>/Productos">
               <img class="logo img-fluid" src="<?php echo RUTA_URL; ?>/public/img/logo.png">
               <div class="sidebar-brand-text mx-3"><img class="logo img-fluid" src="<?php echo RUTA_URL; ?>/public/img/logo.png"></div>
            </a>
         <?php } ?>
         <!-- Divider -->
         <hr class="sidebar-divider my-0">
         <!-- Nav Item - Dashboard -->
         <br>
         <li class="nav-item active">
            <a class="nav-link">

               <span><?php echo $datos['titulo']; ?></span></a>
         </li>
         <!-- Divider -->
         <hr class="sidebar-divider">
         <!-- Heading -->
         <div class="sidebar-heading">
            Aplicación
         </div>
         <!-- Nav Item - Utilities Collapse Menu -->
         <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
               <i class="fas fa-cubes"></i>
               <span>Módulos</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
               <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Utilidades personalizadas:</h6>
                  <?php $modulos = getExistingPlugins(RUTA_PLUGINS); ?>
                  <?php if ($_SESSION['user_type'] != 1 && $_SESSION['user_type'] != 99) : ?>
                     <?php foreach ($modulos as $plugins) : ?>
                        <?php $i = parse_ini_file(RUTA_PLUGINS . $plugins . SEPARATOR . 'info.ini'); ?>
                        <?php foreach ($_SESSION['modulos'] as $allow) : ?>
                           <?php if ($i["estado"] != "inactivo" && $i['nombre'] == $allow->nombre_modulo) : ?>
                              <a class="collapse-item row  <?php echo (isset($i['mant_mode']) && $i['mant_mode'] == true ? "text-danger" : "") ?>" href="<?php echo RUTA_URL . "/" . $i['nombre']; ?>" <?php echo (isset($i['mant_mode']) && $i['mant_mode'] == true ? "target='_blank' title='Módulo en mantenimiento'" : "") ?>><?php echo $i['nombre'] . (isset($i['mant_mode']) && $i['mant_mode'] == true ? "<i style='float:right;' class='fas fa-wrench text-danger'></i>" : " <i style='float:right;' class='" . $i['icon'] . "'></i>") ?></a>
                           <?php endif ?>
                        <?php endforeach; ?>
                     <?php endforeach ?>
                  <?php else : ?>
                     <?php foreach ($modulos as $plugins) : ?>
                        <?php $i = parse_ini_file(RUTA_PLUGINS . $plugins . SEPARATOR . 'info.ini'); ?>
                        <?php if ($i["estado"] != "inactivo") : ?>
                           <a class="collapse-item row  <?php echo (isset($i['mant_mode']) && $i['mant_mode'] == true ? "text-danger" : "") ?>" href="<?php echo RUTA_URL . "/" . $i['nombre']; ?>" <?php echo (isset($i['mant_mode']) && $i['mant_mode'] == true ? "target='_blank' title='Módulo en mantenimiento'" : "") ?>><?php echo $i['nombre'] . (isset($i['mant_mode']) && $i['mant_mode'] == true ? "<i style='float:right;' class='fas fa-wrench text-danger'></i>" : " <i style='float:right;' class='" . $i['icon'] . "'></i>") ?></a>
                        <?php endif ?>
                     <?php endforeach ?>
                  <?php endif; ?>
               </div>
            </div>
         </li>
         <!-- Nav Item - Pages Collapse Menu -->
         <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
               <i class="fas fa-fw fa-cog"></i>
               <span>Admin</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
               <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Custom Components:</h6>
                  <?php $admin  = getExistingPlugins(RUTA_APP . SEPARATOR . 'Controllers'); ?>
                  <?php foreach ($admin as $controllers) : ?>
                     <?php $listControllers = explode('.php', $controllers) ?>
                     <a class="collapse-item" href="<?php echo RUTA_URL . "/" . $listControllers[0]; ?>"><?php echo $listControllers[0]; ?> <i style='float:right' class="fas fa-copy fa-fw"></i></a>
                  <?php endforeach ?>
               </div>
            </div>
         </li>
         <!-- Divider 
         <hr class="sidebar-divider">
         <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#system-status" aria-expanded="true" aria-controls="collapseTwo">
               <i class="fas fa-fw fa-cog"></i>
               <span>System</span>
            </a>
            <div id="system-status" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
               <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Recursos en uso</h6>
                  <a class="collapse-item" title="Database"><span id="database"></span> <i class="fas fa-database"></i></a>
                  <a class="collapse-item" title="Hard Disk"><span id="harddisk"></span> <i class="fas fa-hdd"></i></a>
                  <a class="collapse-item" title="Memory"><span id="memory"></span> <i class="fas fa-memory"></i></a>
               </div>
            </div>
         </li>-->
         <!-- Divider -->
         <hr class="sidebar-divider d-none d-md-block">
         <!-- Sidebar Toggler (Sidebar) -->
         <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
         </div>
      </ul>
      <!-- Termina barra lateral -->
      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">
         <!-- Main Content -->
         <div id="content">
            <!-- Topbar -->
            <nav id="page-top" class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
               <!-- Sidebar Toggle (Topbar) -->
               <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                  <i class="fa fa-bars"></i>
               </button>
               <!-- Topbar Search -->
               <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                  <div class="input-group">
                     <input id="myPlugin" type="text" name="myPlugin" class="form-control form-control-sm bg-light border-0 small" placeholder="Buscar Módulos..." aria-label="Search" aria-describedby="basic-addon2">
                     <datalist id="plugins-datalist"></datalist>
                     <div class="input-group-append">
                        <button class="btn btn-sm btn-primary" type="button" onclick="buscarModulo();">
                           <i class="fas fa-search fa-sm"></i>
                        </button>
                     </div>
                  </div>
               </form>
               <!-- Topbar Navbar -->
               <ul class="navbar-nav ml-auto">
                  <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                  <li class="nav-item dropdown no-arrow d-sm-none">
                     <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-search fa-fw"></i>
                     </a>
                     <!-- Dropdown - Messages -->
                     <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                        <form class="form-inline mr-auto w-100 navbar-search">
                           <div class="input-group">
                              <div class="input-group-append">
                                 <button class="btn btn-primary" type="button" onclick="buscarModulo();">
                                    <i class="fas fa-search fa-sm"></i>
                                 </button>
                              </div>
                           </div>
                        </form>
                     </div>
                  </li>
                  <div class="topbar-divider d-none d-sm-block"></div>
                  <!-- Nav Item - User Information -->
                  <li class="nav-item dropdown no-arrow">
                     <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['user_name']; ?></span>
                        <img class="img-profile rounded-circle" src="<?php echo RUTA_URL ?>/public/img/icon.png">
                     </a>
                     <!-- Dropdown - User Information -->
                     <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                        <!--
                     <a class="dropdown-item" href="#">
                     <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                     Profile
                     </a>
                     <a class="dropdown-item" href="#">
                     <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                     Settings
                     </a>
                     <a class="dropdown-item" href="#">
                     <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                     Activity Log
                     </a>
                     <div class="dropdown-divider"></div>
                     -->
                        <a class="dropdown-item" href="<?php echo RUTA_URL ?>/login/doLogout">
                           <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                           Salir
                        </a>
                     </div>
                  </li>
               </ul>
            </nav>
            <div class="row">
               <div class="col-sm" style="left:50px">
                  <div class="d-sm-flex align-items-center justify-content-between mb-4">
                     <h1 class="h6 mb-0 text-gray-800">
                        <?php if (isset($this->getUrl()[1])) : ?>
                           <div class='btn-group'>
                              <?php
                              echo "<a class='btn btn-sm btn-outline-secondary' href='" . RUTA_URL . "/" . $this->getUrl()[0] . "'><i class='fas fa-arrow-left'></i> " . $this->getUrl()[0] . "</a><button type='button' disabled class='btn btn-sm btn-outline-secondary'>" . $datos['titulo'] . "</button>" ?>
                           </div>
                        <?php endif ?>
                     </h1>
                  </div>
               </div>
            </div>
            <!-- Termina barra superior -->
            <!-- Acá Comienza el contenido de la página -->
            <div class="container-fluid">
               <!-- Encabezado de página -->