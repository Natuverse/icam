<?php headerAdmin($data);
getModal('modalUsuarios', $data);
?>


<main class="content card m-4">
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-user"></i></li>
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>/Usuarios"><?= $data['page_title'] ?></a></li>
    </ul>
    <div class="app-title">

        <div>
            <h1><i class="fa fa-user"></i><?= $data['page_title'] ?></h1>
            <?php if ($_SESSION['permisosMod']['w']) { ?>
            <button class="btn btn-primary" type="button" onclick="openModal();"><i class="fas fa-plus-circle"></i>
                Nuevo</button>
            <?php } ?>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12 card mb-4">
            <div class="tile">
                <div class="tile-body ">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Usuarios
                    </div>
                    <div class="table-responsive card-body">
                        <table class="table table-hover table-bordered " style="width:100%" id="tableUsuarios">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Foto</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Rol</th>
                                    <th>Status</th>
                                    <th style="width:180px">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>




</main>

<?php footerAdmin($data); ?>