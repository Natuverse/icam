<div class="modal fade" id="modalFormModelo" tabindex="-2" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModal">Modelo</h5>
                <button type="button" class="btn-close" onclick="cerrarModal()" aria-label="Close">

                </button>
            </div>
            <div class="modal-body">              
            
                <div class="card">

                    <div class="card-body">
                        <form id="formModelo" name="formModelo" class="form-horizontal">

                            <input type="hidden" id="idemodelo" name="idemodelo" value="">                          

                            <div class="mb-3   row">
                                <h2 class=" col-12 text-center">Modelo</h2>
                            </div>
                            <p class="text-primary">Los campos con asterisco (<span
                                    class="required">*</span>) son obligatorios.</p>
                            <div class="row">                             

                                <div class=" col-md-6">
                                    <label class="form-label" for="Modleo">Modelo:<span
                                            class="required">*</span></label>
                                    <input type="text" name="modelo" id="modelo"
                                        class="form-control valid validText"
                                        placeholder="Modelo" disabled>
                                </div>
                                <div class=" col-md-6">
                                    <label class="form-label" for="nacimiento">Fecha de nacimiento:<span
                                            class="required">*</span></label>
                                    <input type="date" name="nacimiento" id="nacimiento"
                                        class="form-control "
                                        placeholder="Fecha de nacimiento">
                                </div>                            
                                   
                            </div>

                            <div class="mb-3   p-0 row">
                         

                               
                                <div class=" col-md-6">
                                    <label class="form-label" for="antiguedad">Antiguedad:<span
                                            class="required">*</span></label>
                                    <input type="date" name="antiguedad" id="antiguedad"
                                        class="form-control "
                                        placeholder="Fecha de antiguedad">
                                </div>   
                                <div class="col-md-6">
                                    <label class="form-label" for="ingles">Nivel de ingles:<span
                                            class="required">*</span></label>
                                    <select name='ingles' id="ingles" class='form-control'
                                        required>
                                        <option value=0 selected>Nivel</option>
                                        <option value=1 >Basico</option>
                                        <option value=2 >Invermedio</option>
                                        <option value=3 >Avanzado</option>
                                    </select>
                                </div>                         

                            </div>

                           

                            <button type="submit" id="btnmodelo" class="btn btn-primary">Crear Palabra</button>
                        </form>

                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>