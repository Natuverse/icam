<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <?php if (!empty($_SESSION['permisos'][MDASHBOARD]['r'])) {
            ?>
                <div class="sb-sidenav-menu-heading">ICAM</div>
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
               
                 if (!empty($_SESSION['permisos'][MMODELOS]['r'])) {
            ?>
                <div class="sb-sidenav-menu-heading">Modelos</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseModelos"
                    aria-expanded="false" aria-controls="collapseModelos">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Modelos
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseModelos" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="<?= base_url(); ?>/modelo">Modelos</a>
                       
                    </nav>
                </div>
                <?php }  if (!empty($_SESSION['permisos'][MDICCIONARIO]['r'])) {
            ?>

                <div class="sb-sidenav-menu-heading">DICCIONARIO</div>
                <a class="nav-link" href="<?= base_url(); ?>/diccionario">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Diccionario
                </a>
                <?php } if (!empty($_SESSION['permisos'][MANALISIS]['r'])) {
            ?>
                <div class="sb-sidenav-menu-heading">Analisis</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAnalisis"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Analisis
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseAnalisis" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="<?= base_url(); ?>/analisis">Graficas</a>
                        <a class="nav-link" href="<?= base_url(); ?>/analisis/modelos">Modelos</a>                       
                       
                    </nav>
                </div>
                <?php } if (!empty($_SESSION['permisos'][MEMOCIONES]['r'])) {
            ?>
                <div class="sb-sidenav-menu-heading">Emociones</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseEmociones"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Emociones
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseEmociones" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="<?= base_url(); ?>/emocion">Emociones</a>
                        
                    </nav>
                </div>
                <?php } ?>
            </div>
        </div>

    </nav>
</div>