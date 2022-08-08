<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Abel OSH">
    <meta name="theme-color" content="#009688">
    <link rel="shortcut icon" href="<?= media();?>/images/favicon.ico">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?= media();?>/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?= media();?>/css/app.css">

    <title><?= $data['page_tag']; ?></title>
</head>

<body>

    <section class="login-content">

        <div class="login-box">
            <div id="divLoading">
                <div>
                    <img src="<?= media(); ?>/images/loading.svg" alt="Loading">
                </div>
            </div>
            <form class="login-form" method="post" name="formLogin" id="formLogin" action="">
                <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>INICIAR SESIÓN</h3>
                <div class="form-group">
                    <label class="control-label">EMAIL</label>
                    <input id="txtemail" name="txtemail" class="form-control" type="email" placeholder="Documento"
                        autofocus>
                </div>
                <div class="form-group">
                    <label class="control-label">CONTRASEÑA</label>
                    <input id="txtPassword" name="txtPassword" class="form-control" type="password"
                        placeholder="Contraseña">
                </div>
                <div class="form-group">
                    <div class="utility">
                        <p class="semibold-text mb-2"><a href="#" data-toggle="flip">¿Olvidaste tu contraseña?</a></p>
                    </div>
                </div>
                <div id="alertLogin" class="text-center"></div>
                <div class="form-group btn-container">
                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-sign-in-alt"></i> INICIAR
                        SESIÓN</button>
                </div>
            </form>
            <form id="formRecetPass" name="formRecetPass" class="forget-form" action="">
                <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>¿Olvidaste contraseña?</h3>
                <div class="form-group">
                    <label class="control-label">EMAIL</label>
                    <input id="txtEmailReset" name="txtEmailReset" class="form-control" type="email"
                        placeholder="Email">
                </div>
                <div class="form-group btn-container">
                    <button type="submit" class="btn btn-primary btn-block"><i
                            class="fa fa-unlock fa-lg fa-fw"></i>REINICIAR</button>
                </div>
                <div class="form-group mt-3">
                    <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i>
                            Iniciar sesión</a></p>
                </div>
            </form>
        </div>
    </section>
    <script>
    const base_url = "<?= base_url(); ?>";
    </script>
    <!-- Essential javascripts for application to work-->
    <script src="<?= media(); ?>/js/plugins/jquery-3.6.0.min.js"></script>
    <script src="<?= media(); ?>/js/plugins/popper.min.js"></script>
    <script src="<?= media(); ?>/js/plugins/bootstrap.min.js"></script>
    <script src="<?= media(); ?>/js/fontawesome/js/all.js"></script>

    <!-- The javascript plugin to display page loading on top-->
    <script src="<?= media(); ?>/js/plugins/pace.min.js"></script>
    <script type="text/javascript" src="<?= media();?>/js/plugins/sweetalert.js"></script>
    <script src="<?= media(); ?>/js/<?= $data['page_functions_js']; ?>"></script>
</body>

</html>