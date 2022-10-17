<?php
@session_start();
require_once ('class/conexion.php');
$con=conexion();
?>
<!-- Main Sidebar Container -->
  <!--aside class="main-sidebar sidebar-dark-primary elevation-4"-->
    <aside class="main-sidebar sidebar-dark-blue elevation-4">
            <style>
      .sidebar-dark-blue{
        background: #253D90 !important;
      }
 </style>
    <!-- Brand Logo -->
    <a href="panelPrincipal" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Empodera Salud</span>
    </a>

    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo $imagensesion ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><font color="#FB7F03">Bienvenid@, <b><?php echo $nombre; ?></b></font></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="panelPrincipal" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                <b>PANEL PRINCIPAL</b>
              </p>
            </a>
          </li>

        <?php if ($tipousuario == 'Administrador') { ?>
          <li class="nav-header"><b>- CATALOGOS -</b></li>          
          <li class="nav-item">
            <a href="agregarUsuario" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>Alta Usuario</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="editarUsuarios" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>Edita Usuario</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="agregarBanco" class="nav-link">
              <i class="nav-icon fas fa-credit-card"></i>
              <p>Alta Bancos</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="agregarTipoContrato" class="nav-link">
              <i class="nav-icon fas fa-file-pdf"></i>
              <p>Alta Tipo de Contrato</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="agregarCpt" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Agregar CPT</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="editarCPT" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Editar CPT</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="agregarCie" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Agregar Cie</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="editarCIE" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Editar CIE</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="agregarCptConsultas" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Agregar Consultas</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="editarCPTConsultas" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Editar Consultas</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="agregarMunicipios" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Agregar Municipios</p>
            </a>
          </li>
          <li class="nav-header"><b>- MINUTAS -</b></li>          
          <li class="nav-item">
            <a href="reporteMinutas" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Reporte Minutas</p>
            </a>
          </li>
          <li class="nav-header"><b>- GESTION DE REDES -</b></li>
          <li class="nav-item">
            <a href="gestionRedes" class="nav-link">
              <i class="nav-icon far fa-address-card"></i>
              <p>
                Alta de Proveedor
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="altaCliente" class="nav-link">
              <i class="nav-icon far fa-address-card"></i>
              <p>
                Alta de Clientes
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="altaBenefeciario" class="nav-link">
              <i class="nav-icon far fa-address-card"></i>
              <p>
                Alta de beneficiario
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="registrosGR" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Datos Proveedor</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="agregarNotasBene" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Cuentas del beneficiario</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="reporteClientes" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Datos Cliente</p>
            </a>
          </li>
          <li class="nav-header"><b>- DICTAMEN MEDICO -</b></li>          
          <li class="nav-item">
            <a href="reporteSolicitudMedicamentos" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Solicitud de Cotización</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="reporteSolicitudCotizacionesEmpodera" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Responder Cotización</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="reporteCotizacionesPorBeneficiario" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Evaluar Cotización</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="responderReCotizaciones" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Evaluar Re-Cotización</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="responderOrdenesDeCompra" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Ordenes de Compra</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="reporteAcuses" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Acuses recibidos</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="buscadorMedicamentos" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p> Buscar medicamentos</p>
            </a>
          </li>
          <li class="nav-header"><b>- SEGUNDO CICLO -</b></li>
          <li class="nav-item">
            <a href="reporteSolicitudCotizacionesEmpoderaExt" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Responder Cot Segundo Ciclo</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="responderReCotizacionesExt" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Evaluar Cot Segundo cliclo</p>
            </a>
          </li>

          <li class="nav-header"><b>- CONCILIACION DE PAGOS -</b></li>
          
          <li class="nav-item">
            <a href="responderOrdenPago" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Enviar factura</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="validarFacturaProveedor" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Asignar factura</p>
            </a>
          </li>          
          <li class="nav-item">
            <a href="validarGruposFacturas" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Validar facturas</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="validarGruposFacturasPagos" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Validar facturas Dir</p>
            </a>
          </li> 
          <li class="nav-item">
            <a href="responderPagoProveedor" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Pagar Facturas</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="canceladasGruposFacturasPagos" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Canceladas</p>
            </a>
          </li> 
          <li class="nav-item">
            <a href="pagadasGruposFacturasPagos" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Pagadas</p>
            </a>
          </li>    
          <li class="nav-item">
            <a href="buscarFacturas" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Reporte de facturas</p>
            </a>
          </li>      
          <li class="nav-item">
            <a href="reporteGeneral" class="nav-link">
              <i class="nav-icon fas fa-file-excel"></i>
              <p>Reporte General</p>
            </a>
          </li>
          <li class="nav-header"><b>- VIDEOS -</b></li>
          <li class="nav-item">
            <a href="tutorialesVideos" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Tutoriales</p>
            </a>
          </li>
          <?php } ?>

          <?php if ($tipousuario == 'Transicion') { ?>
          <li class="nav-header"><b>- CATALOGOS -</b></li>          
          <li class="nav-item">
            <a href="agregarUsuario" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>Alta Usuario</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="editarUsuarios" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>Edita Usuario</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="agregarBanco" class="nav-link">
              <i class="nav-icon fas fa-credit-card"></i>
              <p>Alta Bancos</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="agregarTipoContrato" class="nav-link">
              <i class="nav-icon fas fa-file-pdf"></i>
              <p>Alta Tipo de Contrato</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="agregarCpt" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Agregar CPT</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="editarCPT" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Editar CPT</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="agregarCie" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Agregar Cie</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="editarCIE" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Editar CIE</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="agregarCptConsultas" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Agregar Consultas</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="editarCPTConsultas" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Editar Consultas</p>
            </a>
          </li>
          <li class="nav-header"><b>- MINUTAS -</b></li>          
          <li class="nav-item">
            <a href="reporteMinutas" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Reporte Minutas</p>
            </a>
          </li>
          <li class="nav-header"><b>- GESTION DE REDES -</b></li>
          <li class="nav-item">
            <a href="gestionRedes" class="nav-link">
              <i class="nav-icon far fa-address-card"></i>
              <p>
                Alta de Proveedor
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="altaCliente" class="nav-link">
              <i class="nav-icon far fa-address-card"></i>
              <p>
                Alta de Clientes
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="altaBenefeciario" class="nav-link">
              <i class="nav-icon far fa-address-card"></i>
              <p>
                Alta de beneficiario
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="registrosGR" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Datos Proveedor</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="agregarNotasBene" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Cuentas del beneficiario</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="reporteClientes" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Datos Cliente</p>
            </a>
          </li>
          <li class="nav-header"><b>- DICTAMEN MEDICO -</b></li>          
          <li class="nav-item">
            <a href="reporteSolicitudMedicamentos" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Solicitud de Cotización</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="reporteSolicitudCotizacionesEmpodera" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Responder Cotización</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="reporteCotizacionesPorBeneficiario" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Evaluar Cotización</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="responderReCotizaciones" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Evaluar Re-Cotización</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="responderOrdenesDeCompra" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Ordenes de Compra</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="reporteAcuses" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Acuses recibidos</p>
            </a>
          </li>
          <li class="nav-header"><b>- SEGUNDO CICLO -</b></li>
          <li class="nav-item">
            <a href="reporteSolicitudCotizacionesEmpoderaExt" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Responder Cot Segundo Ciclo</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="responderReCotizacionesExt" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Evaluar Cot Segundo cliclo</p>
            </a>
          </li>
          <li class="nav-header"><b>- VIDEOS -</b></li>
          <li class="nav-item">
            <a href="tutorialesVideos" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Tutoriales</p>
            </a>
          </li>
          <?php } ?>

        <?php if ($tipousuario == 'Medico') { ?>
          <li class="nav-header"><b>- GESTION DE REDES -</b></li>
          <li class="nav-item">
            <a href="registrosGR" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Datos Proveedor</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="agregarNotasBene" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Cuentas del beneficiario</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="reporteClientes" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Datos Cliente</p>
            </a>
          </li>
          <li class="nav-header"><b>- DICTAMEN MEDICO -</b></li>          
          <li class="nav-item">
            <a href="reporteSolicitudMedicamentos" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Solicitud de Cotización</p>
            </a>
          </li>
          <li class="nav-header"><b>- CONCILIACION DE PAGOS -</b></li>
          <li class="nav-item">
            <a href="buscarFacturas" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Reporte de facturas</p>
            </a>
          </li>
        <?php } ?>

        <?php if ($tipousuario == 'AdaptacionTres') { ?>
          <li class="nav-header"><b>- GESTION DE REDES -</b></li>
          <li class="nav-item">
            <a href="registrosGR" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Datos Proveedor</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="agregarNotasBene" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Cuentas del beneficiario</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="reporteClientes" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Datos Cliente</p>
            </a>
          </li>
          <li class="nav-header"><b>- DICTAMEN MEDICO -</b></li>          
          <li class="nav-item">
            <a href="reporteSolicitudMedicamentos" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Solicitud de Cotización</p>
            </a>
          </li>
        <?php } ?>

        <?php if ($tipousuario == 'GestorRed') { ?>
          <li class="nav-header"><b>- CATALOGOS -</b></li> 
          <li class="nav-item">
            <a href="agregarBanco" class="nav-link">
              <i class="nav-icon fas fa-credit-card"></i>
              <p>Alta Bancos</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="agregarTipoContrato" class="nav-link">
              <i class="nav-icon fas fa-file-pdf"></i>
              <p>Alta Tipo de Contrato</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="gestionRedes" class="nav-link">
              <i class="nav-icon far fa-address-card"></i>
              <p>
                Alta de Proveedor
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="altaCliente" class="nav-link">
              <i class="nav-icon far fa-address-card"></i>
              <p>
                Alta de Clientes
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="altaBenefeciario" class="nav-link">
              <i class="nav-icon far fa-address-card"></i>
              <p>
                Alta de beneficiario
              </p>
            </a>
          </li>

          <li class="nav-header"><b>- GESTION DE REDES -</b></li>
          <li class="nav-item">
            <a href="registrosGR" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Datos Proveedor</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="agregarNotasBene" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Cuentas del beneficiario</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="reporteClientes" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Datos Cliente</p>
            </a>
          </li>
          <li class="nav-header"><b>- CONCILIACION DE PAGOS -</b></li>
          <li class="nav-item">
            <a href="buscarFacturas" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Reporte de facturas</p>
            </a>
          </li>
        <?php } ?>

        <?php if ($tipousuario == 'AdaptacionUno') { ?>
          <li class="nav-header"><b>- CATALOGOS -</b></li> 
          <li class="nav-item">
            <a href="agregarBanco" class="nav-link">
              <i class="nav-icon fas fa-credit-card"></i>
              <p>Alta Bancos</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="agregarTipoContrato" class="nav-link">
              <i class="nav-icon fas fa-file-pdf"></i>
              <p>Alta Tipo de Contrato</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="gestionRedes" class="nav-link">
              <i class="nav-icon far fa-address-card"></i>
              <p>
                Alta de Proveedor
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="altaCliente" class="nav-link">
              <i class="nav-icon far fa-address-card"></i>
              <p>
                Alta de Clientes
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="altaBenefeciario" class="nav-link">
              <i class="nav-icon far fa-address-card"></i>
              <p>
                Alta de beneficiario
              </p>
            </a>
          </li>
          <li class="nav-header"><b>- GESTION DE REDES -</b></li>
          <li class="nav-item">
            <a href="registrosGR" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Datos Proveedor</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="agregarNotasBene" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Cuentas del beneficiario</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="reporteClientes" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Datos Cliente</p>
            </a>
          </li>
        <?php } ?>

        <?php if ($tipousuario == 'ProveedorMedicamentos') { ?>
          <li class="nav-header"><b>- DICTAMEN MEDICO -</b></li>
          <li class="nav-item">
            <a href="reporteSolicitudCotizaciones" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Responder Cotización</p>
            </a>
          </li>
          </li>
          <li class="nav-header"><b>- SEGUNDO CICLO -</b></li>
          <li class="nav-item">
            <a href="reporteSolicitudCotizacionesEmpoderaExt" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Responder Cot Segundo Ciclo</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="responderOrdenesDeCompra" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Enviar acuses recibido</p>
            </a>
          </li>
          <li class="nav-header"><b>- CONCILIACION DE PAGOS -</b></li>
          <li class="nav-item">
            <a href="responderOrdenPago" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Enviar factura para pago</p>
            </a>
          </li>
        <?php } ?>

        <?php if ($tipousuario == 'GerenteRed') { ?>
        <li class="nav-header"><b>- GESTION DE REDES -</b></li>
          <li class="nav-item">
            <a href="gestionRedes" class="nav-link">
              <i class="nav-icon far fa-address-card"></i>
              <p>
                Alta de Proveedor
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="altaCliente" class="nav-link">
              <i class="nav-icon far fa-address-card"></i>
              <p>
                Alta de Clientes
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="altaBenefeciario" class="nav-link">
              <i class="nav-icon far fa-address-card"></i>
              <p>
                Alta de beneficiario
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="registrosGR" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Datos Proveedor</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="agregarNotasBene" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Cuentas del beneficiario</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="reporteClientes" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Datos Cliente</p>
            </a>
          </li>
        <?php } ?>

        <?php if ($tipousuario == 'ConciliacionPagos') { ?>
          <li class="nav-header"><b>- GESTION DE REDES -</b></li>
          <li class="nav-item">
            <a href="registrosGR" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Datos Proveedor</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="agregarNotasBene" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Cuentas del beneficiario</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="reporteClientes" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Datos Cliente</p>
            </a>
          </li>
          <li class="nav-header"><b>- CONCILIACION DE PAGOS -</b></li>
          <li class="nav-item">
            <a href="buscarFacturas" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Reporte de facturas</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="responderOrdenPago" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Enviar factura para pago</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="validarFacturaProveedor" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Validar factura para pago</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="responderPagoProveedor" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Enviar pago a proveedor</p>
            </a>
          </li>  
        <?php } ?>

        <?php if ($tipousuario == 'AdaptacionDos') { ?>
          <li class="nav-header"><b>- GESTION DE REDES -</b></li>
          <li class="nav-item">
            <a href="registrosGR" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Datos Proveedor</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="agregarNotasBene" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Cuentas del beneficiario</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="reporteClientes" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Datos Cliente</p>
            </a>
          </li>
          <li class="nav-header"><b>- CONCILIACION DE PAGOS -</b></li>
          <li class="nav-item">
            <a href="buscarFacturas" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Reporte de facturas</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="responderOrdenPago" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Enviar factura para pago</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="validarFacturaProveedor" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Validar factura para pago</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="responderPagoProveedor" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Enviar pago a proveedor</p>
            </a>
          </li>  
        <?php } ?>

        <?php if ($tipousuario == 'GestorMedicamentos') { ?>
          <li class="nav-header"><b>- CATALOGOS -</b></li> 
          <li class="nav-item">
            <a href="agregarBanco" class="nav-link">
              <i class="nav-icon fas fa-credit-card"></i>
              <p>Alta Bancos</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="agregarTipoContrato" class="nav-link">
              <i class="nav-icon fas fa-file-pdf"></i>
              <p>Alta Tipo de Contrato</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="gestionRedes" class="nav-link">
              <i class="nav-icon far fa-address-card"></i>
              <p>
                Alta de Proveedor
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="altaCliente" class="nav-link">
              <i class="nav-icon far fa-address-card"></i>
              <p>
                Alta de Clientes
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="altaBenefeciario" class="nav-link">
              <i class="nav-icon far fa-address-card"></i>
              <p>
                Alta de beneficiario
              </p>
            </a>
          </li>
          <li class="nav-header"><b>- GESTION DE REDES -</b></li>
          <li class="nav-item">
            <a href="registrosGR" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Datos Proveedor</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="agregarNotasBene" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Cuentas del beneficiario</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="reporteClientes" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Datos Cliente</p>
            </a>
          </li>
          <li class="nav-header"><b>- DICTAMEN MEDICO -</b></li>          
          <li class="nav-item">
            <a href="reporteSolicitudMedicamentos" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Solicitud de Cotización</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="reporteSolicitudCotizacionesEmpodera" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Responder Cotización</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="reporteCotizacionesPorBeneficiario" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Evaluar Cotización</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="responderReCotizaciones" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Evaluar Re-Cotización</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="responderOrdenesDeCompra" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Ordenes de Compra</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="reporteAcuses" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Acuses recibidos</p>
            </a>
          </li>
          <li class="nav-header"><b>- SEGUNDO CICLO -</b></li>
          <li class="nav-item">
            <a href="reporteSolicitudCotizacionesEmpoderaExt" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Responder Cot Segundo Ciclo</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="responderReCotizacionesExt" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Evaluar Cot Segundo cliclo</p>
            </a>
          </li>
          <li class="nav-header"><b>- CONCILIACION DE PAGOS -</b></li>
          <li class="nav-item">
            <a href="buscarFacturas" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Reporte de facturas</p>
            </a>
          </li>
        <?php } ?>


        <?php if ($tipousuario == 'AdaptacionCuatro') { ?>
          <li class="nav-header"><b>- CATALOGOS -</b></li> 
          <li class="nav-item">
            <a href="agregarBanco" class="nav-link">
              <i class="nav-icon fas fa-credit-card"></i>
              <p>Alta Bancos</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="agregarTipoContrato" class="nav-link">
              <i class="nav-icon fas fa-file-pdf"></i>
              <p>Alta Tipo de Contrato</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="gestionRedes" class="nav-link">
              <i class="nav-icon far fa-address-card"></i>
              <p>
                Alta de Proveedor
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="altaCliente" class="nav-link">
              <i class="nav-icon far fa-address-card"></i>
              <p>
                Alta de Clientes
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="altaBenefeciario" class="nav-link">
              <i class="nav-icon far fa-address-card"></i>
              <p>
                Alta de beneficiario
              </p>
            </a>
          </li>
          <li class="nav-header"><b>- GESTION DE REDES -</b></li>
          <li class="nav-item">
            <a href="registrosGR" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Datos Proveedor</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="agregarNotasBene" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Cuentas del beneficiario</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="reporteClientes" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Datos Cliente</p>
            </a>
          </li>
          <li class="nav-header"><b>- DICTAMEN MEDICO -</b></li>          
          <li class="nav-item">
            <a href="reporteSolicitudMedicamentos" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Solicitud de Cotización</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="reporteSolicitudCotizacionesEmpodera" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Responder Cotización</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="reporteCotizacionesPorBeneficiario" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Evaluar Cotización</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="responderReCotizaciones" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Evaluar Re-Cotización</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="responderOrdenesDeCompra" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Ordenes de Compra</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="reporteAcuses" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Acuses recibidos</p>
            </a>
          </li>
          <li class="nav-header"><b>- SEGUNDO CICLO -</b></li>
          <li class="nav-item">
            <a href="reporteSolicitudCotizacionesEmpoderaExt" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Responder Cot Segundo Ciclo</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="responderReCotizacionesExt" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Evaluar Cot Segundo cliclo</p>
            </a>
          </li>
        <?php } ?>

        <?php if ($tipousuario == 'CoordinadorMed') { ?>
          <li class="nav-header"><b>- GESTION DE REDES -</b></li>
          <li class="nav-item">
            <a href="registrosGR" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Datos Proveedor</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="agregarNotasBene" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Cuentas del beneficiario</p>
            </a>
          </li>
          <li class="nav-header"><b>- DICTAMEN MEDICO -</b></li>          
          <li class="nav-item">
            <a href="reporteSolicitudMedicamentos" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Solicitud de Cotización</p>
            </a>
          </li>
          <li class="nav-header"><b>- CONCILIACION DE PAGOS -</b></li>
          <li class="nav-item">
            <a href="buscarFacturas" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Reporte de facturas</p>
            </a>
          </li>
          <li class="nav-header"><b>- MINUTAS -</b></li>          
          <li class="nav-item">
            <a href="reporteMinutas" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Reporte Minutas</p>
            </a>
          </li>  
        <?php } ?>

        <?php if ($tipousuario == 'CoordinadorRed') { ?>
          <li class="nav-header"><b>- CATALOGOS -</b></li> 
          <li class="nav-item">
            <a href="agregarBanco" class="nav-link">
              <i class="nav-icon fas fa-credit-card"></i>
              <p>Alta Bancos</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="agregarTipoContrato" class="nav-link">
              <i class="nav-icon fas fa-file-pdf"></i>
              <p>Alta Tipo de Contrato</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="gestionRedes" class="nav-link">
              <i class="nav-icon far fa-address-card"></i>
              <p>
                Alta de Proveedor
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="altaCliente" class="nav-link">
              <i class="nav-icon far fa-address-card"></i>
              <p>
                Alta de Clientes
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="altaBenefeciario" class="nav-link">
              <i class="nav-icon far fa-address-card"></i>
              <p>
                Alta de beneficiario
              </p>
            </a>
          </li>
          <li class="nav-header"><b>- GESTION DE REDES -</b></li>
          <li class="nav-item">
            <a href="registrosGR" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Datos Proveedor</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="reporteClientes" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Datos Cliente</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="agregarNotasBene" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Cuentas del beneficiario</p>
            </a>
          </li>
          <li class="nav-header"><b>- DICTAMEN MEDICO -</b></li>          
          <li class="nav-item">
            <a href="reporteSolicitudMedicamentos" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Solicitud de Cotización</p>
            </a>
          </li>          
          <li class="nav-header"><b>- MINUTAS -</b></li>          
          <li class="nav-item">
            <a href="reporteMinutas" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Reporte Minutas</p>
            </a>
          </li>  
          <li class="nav-header"><b>- CONCILIACION DE PAGOS -</b></li>
          <li class="nav-item">
            <a href="buscarFacturas" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Reporte de facturas</p>
            </a>
          </li>
        <?php } ?>
        
        <?php if ($tipousuario == 'CoordinadorMedicamentos') { ?>
          <li class="nav-header"><b>- CATALOGOS -</b></li> 
          <li class="nav-item">
            <a href="agregarBanco" class="nav-link">
              <i class="nav-icon fas fa-credit-card"></i>
              <p>Alta Bancos</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="agregarTipoContrato" class="nav-link">
              <i class="nav-icon fas fa-file-pdf"></i>
              <p>Alta Tipo de Contrato</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="gestionRedes" class="nav-link">
              <i class="nav-icon far fa-address-card"></i>
              <p>
                Alta de Proveedor
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="altaCliente" class="nav-link">
              <i class="nav-icon far fa-address-card"></i>
              <p>
                Alta de Clientes
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="altaBenefeciario" class="nav-link">
              <i class="nav-icon far fa-address-card"></i>
              <p>
                Alta de beneficiario
              </p>
            </a>
          </li>
          <li class="nav-header"><b>- GESTIÓN DE REDES -</b></li> 
          <li class="nav-item">
            <a href="registrosGR" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Datos Proveedor</p>
            </a>
          </li>
           <li class="nav-item">
            <a href="agregarNotasBene" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Cuentas del beneficiario</p>
            </a>
          </li>
          <li class="nav-header"><b>- MINUTAS -</b></li>          
          <li class="nav-item">
            <a href="reporteMinutas" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Reporte Minutas</p>
            </a>
          </li>
          <li class="nav-header"><b>- DICTAMEN MEDICO -</b></li>          
          <li class="nav-item">
            <a href="reporteSolicitudMedicamentos" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Solicitud de Cotización</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="reporteSolicitudCotizacionesEmpodera" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Responder Cotización</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="reporteCotizacionesPorBeneficiario" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Evaluar Cotización</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="responderReCotizaciones" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Evaluar Re-Cotización</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="responderOrdenesDeCompra" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>Ordenes de Compra</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="reporteAcuses" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Acuses recibidos</p>
            </a>
          </li>
          <li class="nav-header"><b>- SEGUNDO CICLO -</b></li>
          <li class="nav-item">
            <a href="reporteSolicitudCotizacionesEmpoderaExt" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Responder Cot Segundo Ciclo</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="responderReCotizacionesExt" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Evaluar Cot Segundo cliclo</p>
            </a>
          </li>
          <li class="nav-header"><b>- CONCILIACION DE PAGOS -</b></li>
          <li class="nav-item">
            <a href="buscarFacturas" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Reporte de facturas</p>
            </a>
          </li>
        <?php } ?>

        
          

          <li class="nav-header"><b>- UTILIDADES -</b></li>
          <li class="nav-item">
            <a href="salir" class="nav-link">
              <i class="nav-icon far fa-circle text-danger"></i>
              <p class="text">Salir</p>
            </a>
          </li>

          <li class="nav-header"><b>- ULTIMO ACCESO -</b></li>
          <li class="nav-item">
            <a href="salir" class="nav-link">
            <p class="text">
              <?php 
              $idUsuario=$_SESSION['idUsuario'];
              $sql="SELECT Fecha from bitacoralogin where IdUsuario=$idUsuario ORDER BY IdLogin DESC LIMIT 5";
              $res = mysqli_query($con,$sql);
              $registro = mysqli_fetch_array($res);
              $UltimoAcceso = $registro["Fecha"];
              ?>
              <font color="#FB7F03"><?php echo $UltimoAcceso; ?><br>
                PERFIL DE <?php echo strtoupper($tipousuario) ?>
              </font>
            </p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>