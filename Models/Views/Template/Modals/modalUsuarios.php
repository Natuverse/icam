<div class="modal fade" id="modalFormUsuario" tabindex="-2" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModal">Nuevo usario</h5>
                <button type="button" class="btn-close" onclick="cerrarModal()" aria-label="Close">

                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-3 col-xl-2">

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Usuario nuevo</h5>
                            </div>

                            <div class="list-group list-group-flush" role="tablist">
                                <a class="list-group-item list-group-item-action active" data-toggle="list" id="link1"
                                    href="#conductor" role="tab">
                                    Usuario
                                </a>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-9 col-xl-10">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="conductor" role="tabpanel">

                                <div class="card">

                                    <div class="card-body">
                                        <form id="formUsuario" name="formUsuario" class="form-horizontal">
                                            <input type="hidden" id="idusuario" name="idusuario" value="">

                                            <input type="hidden" id="imgregistro_actual" name="imgregistro_actual"
                                                value="">
                                            <input type="hidden" id="imgregistro_remove" name="imgregistro_remove"
                                                value="0">

                                            <div class="mb-3   row">
                                                <h2 class=" col-12 text-center">Usuario</h2>
                                            </div>
                                            <p class="text-primary">Los campos con asterisco (<span
                                                    class="required">*</span>) son obligatorios.</p>
                                            <div class="row">

                                                <div class="col-md-8 ">


                                                    <div class="mb-3 p-0 row">
                                                        <div class=" col-md-6">
                                                            <label class="form-label" for="nombres">NOMBRES:<span
                                                                    class="required">*</span></label>
                                                            <input type="text" name="nombres" id="nombres"
                                                                class="form-control valid validText"
                                                                placeholder="Nombres">
                                                        </div>
                                                        <div class=" col-md-6">
                                                            <label class="form-label" for="apellidos">APELLIDOS:<span
                                                                    class="required">*</span> </label>
                                                            <input type="text" name="apellidos" id="apellidos"
                                                                class="form-control valid validText"
                                                                placeholder="Apellidos">
                                                        </div>


                                                    </div>

                                                    <div class="mb-3 p-0  row">


                                                        <div class="col-md-6">
                                                            <label class="form-label" for="telefono_movil">TELÉFONO
                                                                MOVIL:<span class="required">*</span> </label>
                                                            <input type="number" name="telefono_movil"
                                                                id="telefono_movil"
                                                                class="form-control valid validNumber"
                                                                placeholder="Teléfono_movil" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label" for="correo">CORREO
                                                                ELECTRONICO:<span class="required"></span></label>
                                                            <input type="email" name="correo" id="correo"
                                                                class="form-control  valid validEmail"
                                                                placeholder="Corrreo electronico">
                                                        </div>

                                                    </div>


                                                    <div class="mb-3   p-0 row">

                                                        <div class="col-md-6">
                                                            <label class="form-label" for="estado">ROL:<span
                                                                    class="required">*</span></label>
                                                            <select name='rol_form' id="rol_form" class='form-control'
                                                                required>
                                                                <option value='' selected>Rol</option>

                                                            </select>
                                                        </div>

                                                    </div>



                                                </div>
                                                <div class="col-md-4">
                                                    <div class="photo">
                                                        <p class="text-center">FOTO</p>

                                                        <div class="prevRegistro ">
                                                            <span class="delFotoRegistro notBlock">X</span>
                                                            <label for="fotoRegistro"></label>
                                                            <div>
                                                                <img id="imgregistro"
                                                                    src="<?= media(); ?>/images/uploads/perfil/default.png">
                                                            </div>
                                                        </div>
                                                        <div class="upimg ">
                                                            <input type="file" class="img-profile " name="fotoRegistro"
                                                                id="fotoRegistro">
                                                        </div>
                                                        <div id="form_alertfoto"></div>


                                                    </div>
                                                </div>



                                                <div class="mb-3  row" id="pass">


                                                </div>
                                            </div>

                                            <button type="submit" id="btnUsuario" class="btn btn-primary">Crear
                                                conductor</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="modalFormPass" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title" id="titleModal">Cambiar password</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formPass" name="formPass">
                            <input type="hidden" id="iduserpass" name="iduserpass" value="">

                            <div class="mb-3  row">
                                <div class="col-md-6"><label class="form-label" for="password">PASSWORD:<span
                                            class="required">*</span> </label><input type="password" name="passwordu"
                                        id="passwordu" class="form-control " placeholder="Password" required></div>

                                <div class="col-md-6"><label class="form-label" for="rep_password">REPETIR
                                        PASSWORD:<span class="required">*</span></label><input type="password"
                                        name="rep_passwordu" id="rep_passwordu" class="form-control "
                                        placeholder="Repetir password"></div>
                            </div>
                            <div class="modal-footer">
                                <button id="btnActionForm" class="btn btn-primary" type="submit"><i
                                        class="fa fa-fw fa-lg fa-check-circle"></i><span
                                        id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;<a
                                    class="btn btn-secondary" href="#" data-bs-dismiss="modal"><i
                                        class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalInfoUsario" tabindex="-2" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModal">Usuario</h5>
                <button type="button" class="btn-close" onclick="cerrarModalInfo()" aria-label="Close">

                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-3 col-xl-2">

                        <div class="card">

                            <div class="list-group list-group-flush" role="tablist">
                                <a class="list-group-item list-group-item-action active" data-toggle="list" id="link1"
                                    href="#conductor" role="tab">
                                    Usuario
                                </a>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-9 col-xl-10">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="conductor" role="tabpanel">

                                <div class="card">

                                    <div class="card-body">

                                        <form id="formUsuarioinfo" name="formUsuarioinfo" class="form-horizontal">
                                            <div class="mb-3   row">
                                                <h2 class=" col-12 text-center">Usuario</h2>
                                            </div>

                                            <div class="row">

                                                <div class="col-md-8 ">


                                                    <div class="mb-3 p-0 row">
                                                        <div class=" col-md-6">
                                                            <label class="form-label" for="nombres">NOMBRES:</label>
                                                            <input type="text" name="nombresinfo" id="nombresinfo"
                                                                class="form-control  sinborde" disabled
                                                                placeholder="Nombres">
                                                        </div>
                                                        <div class=" col-md-6">
                                                            <label class="form-label" for="apellidos">APELLIDOS:</label>
                                                            <input type="text" name="apellidosinfo" id="apellidosinfo"
                                                                class="form-control  sinborde" disabled
                                                                placeholder="Apellidos">
                                                        </div>


                                                    </div>

                                                    <div class="mb-3 p-0  row">


                                                        <div class="col-md-6">
                                                            <label class="form-label" for="telefono_movil">TELÉFONO
                                                                MOVIL: </label>
                                                            <input type="number" name="telefono_movilinfo"
                                                                id="telefono_movilinfo" class="form-control  sinborde"
                                                                disabled placeholder="Teléfono_movil" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label" for="correo">CORREO
                                                                ELECTRONICO:</label>
                                                            <input type="email" name="correoinfo" id="correoinfo"
                                                                class="form-control   sinborde" disabled
                                                                placeholder="Corrreo electronico">
                                                        </div>

                                                    </div>


                                                    <div class="mb-3   p-0 row">

                                                        <div class="col-md-6">
                                                            <label class="form-label" for="rol_form">ROL:</label>
                                                            <input type="text" name="rol_forminfo" id="rol_forminfo"
                                                                class="form-control   sinborde" disabled
                                                                placeholder="Rol">
                                                        </div>

                                                    </div>



                                                </div>
                                                <div class="col-md-4">
                                                    <div class="photo">
                                                        <p class="text-center">FOTO</p>

                                                        <div class="prevRegistroinfo ">
                                                            <label for="prevRegistroinfo"></label>
                                                            <div>
                                                                <img id="imgregistroinfo"
                                                                    src="<?= media(); ?>/images/uploads/perfil/default.png">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>