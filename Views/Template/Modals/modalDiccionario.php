<div class="modal fade" id="modalDiccionario" tabindex="-2" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModal">Nueva palabra</h5>
                <button type="button" class="btn-close" onclick="cerrarModal()" aria-label="Close">

                </button>
            </div>
            <div class="modal-body">

               
            
                <div class="card">

                    <div class="card-body">
                        <form id="formDiccionario" name="formDiccionario" class="form-horizontal">

                            <input type="hidden" id="iddiccionario" name="iddiccionario" value="">

                            <input type="hidden" id="image_actual" name="image_actual"
                                value="">
                            <input type="hidden" id="image_remove" name="image_remove" value="0">

                            <div class="mb-3   row">
                                <h2 class=" col-12 text-center">Dicionario</h2>
                            </div>
                            <p class="text-primary">Los campos con asterisco (<span
                                    class="required">*</span>) son obligatorios.</p>
                            <div class="row">

                                <div class="col-md-8 ">


                                    <div class="mb-3 p-0 row">
                                        <div class=" col-md-12">
                                            <label class="form-label" for="palabra">Palabra:<span
                                                    class="required">*</span></label>
                                            <input type="text" name="palabra" id="palabra"
                                                class="form-control valid validText"
                                                placeholder="palabra">
                                        </div>



                                    </div>

                                    <div class="mb-3 p-0  row">


                                        <div class="col-md-12">
                                            <label class="form-label" for="significado_en">Significado EN
                                                <span class="required">*</span> </label>
                                            <input type="text" name="significado_en"
                                                id="significado_en"
                                                class="form-control valid validText"
                                                placeholder="significado en" >
                                        </div>


                                    </div>


                                    <div class="mb-3   p-0 row">

                                        <div class="col-md-12">
                                            <label class="form-label" for="traduccion_es">Traduccion ES:<span
                                                    class="required">*</span></label>
                                                    <input type="text" name="traduccion_es"
                                                id="traduccion_es"
                                                class="form-control valid validText"
                                                placeholder="Traduccion ES" >
                                        </div>

                                    </div>

                                    <div class="mb-3   p-0 row">

                                    <div class="col-md-12">
                                        <label class="form-label" for="significado_es">Significado ES:<span
                                                class="required">*</span></label>
                                                <input type="text" name="significado_es"
                                            id="significado_es"
                                            class="form-control valid validText"
                                            placeholder="Significado ES" >
                                    </div>

                                </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="photo">
                                        <p class="text-center">Imagen</p>

                                        <div class="prevRegistro rounded-circle  rounded">
                                            <span class="delFotoRegistro notBlock">X</span>
                                            <label for="fotoRegistro"></label>
                                            <div>
                                                <img id="imgregistro "
                                                    src="<?= media(); ?>/images/uploads/diccionario/default-image.png">
                                            </div>
                                        </div>
                                        <div class="upimg ">
                                            <input type="file" class="img-profile " name="fotoRegistro"
                                                id="fotoRegistro">
                                        </div>
                                        <div id="form_alertfoto"></div>


                                    </div>
                                </div>



                                
                            </div>

                            <button type="submit" id="btnDiccionario" class="btn btn-primary">Crear Palabra</button>
                        </form>

                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
