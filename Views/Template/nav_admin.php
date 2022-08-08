<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <?php if (!empty($_SESSION['permisos'][MUSUARIOS]['r'])) {
            ?>
                <div class="sb-sidenav-menu-heading">MMP</div>
                <a class="nav-link" href="<?= base_url(); ?>/dashboard">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <?php } 
                 if (!empty($_SESSION['permisos'][MUSUARIOS]['r'])) {
            ?>
                <div class="sb-sidenav-menu-heading">Usuarios</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Usuarios
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="<?= base_url(); ?>/usuarios">Usuarios</a>
                        <?php if (!empty($_SESSION['permisos'][MROLES]['r'])) {
            ?>
                        <a class="nav-link" href="<?= base_url(); ?>/roles">Roles</a>
                        <?php } ?>
                    </nav>
                </div>
                <?php } 
                  if (!empty($_SESSION['permisos'][MCLIENTES]['r'])) {
                    ?>
                        <div class="sb-sidenav-menu-heading">CLientes</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseClinetes"
                            aria-expanded="false" aria-controls="collapseClinetes">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Clientes
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseClinetes" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?= base_url(); ?>/clientes">Clientes</a>                              
                            </nav>
                        </div>
                        <?php } 
                 if (!empty($_SESSION['permisos'][MINVENTARIO]['r'])) {
            ?>

                <div class="sb-sidenav-menu-heading">Inventario</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseInventario"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Inventario
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseInventario" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="<?= base_url(); ?>/Inventario/Operaciones">Operaciones</a>
                        <a class="nav-link" href="<?= base_url(); ?>/Inventario/Productos">Propducto</a>
                        <a class="nav-link" href="<?= base_url(); ?>/Inventario/Ubicaciones">Ubicacion</a>
                    </nav>
                </div>

                <?php } ?>

                <?php if (!empty($_SESSION['permisos'][MCONTRATOS]['r'])) {
            ?>

                <div class="sb-sidenav-menu-heading">Contratos</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseContratos"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Contratos
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseContratos" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="<?= base_url(); ?>/Contratos/contratos">Contratos</a>
                        <a class="nav-link" href="<?= base_url(); ?>/Contratos/cartagena">Eventos</a>
                   

                    </nav>
                </div>



                <?php } ?>
            </div>
        </div>

    </nav>
</div>