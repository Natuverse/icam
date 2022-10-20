<div class="modal fade" id="modalEmocion" tabindex="-2" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModal">Nueva Emocion</h5>
                <button type="button" class="btn-close" onclick="cerrarModal()" aria-label="Close">

                </button>
            </div>
            <div class="modal-body">

               
            
                <div class="card">

                    <div class="card-body">
                        <form id="formEmocion" name="formEmocion" enctype="multipart/form-data" class="form-horizontal">

                            <input type="hidden" id="idemocion" name="idemocion" value="">

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
                                            <label class="form-label" for="emocion">Emocion:<span
                                                    class="required">*</span></label>
                                                    <select value="0" class="form-select" id="emocion" name="emocion" aria-label="Default select example">
                                                        <option selected>Emocion</option>
                                                        <option value="1">sadness</option>
                                                        <option value="2">joy</option>
                                                        <option value="3">love</option>
                                                        <option value="4">sex</option>
                                                        <option value="5">fear</option>
                                                        <option value="6">surprise</option>
                                                    </select>
                                        </div>



                                    </div>
                                    <div class="mb-3 p-0 row">
                                            <div class="col-md-12">
                                                <label class="form-label" for="descripcion">DESCRIPCION: </label>
                                                <input type="text" name="descripcion" id="descripcion" class="form-control " placeholder="descripcion" required>
                                            </div>
                                       


                                    </div>
                                 

                                </div>

                               
                                <div class="col-md-4">
                                    <div class="photo">
                                        <p class="text-center">Imagen</p>

                                        <div class="prevRegistro ">
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

                            <button type="submit" id="btnEmocion" class="btn btn-primary">Crear Palabra</button>
                        </form>

                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
