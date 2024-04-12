
<?php

 $this->extend('dashboard_view'); ?>
<?php $this->section('contenido'); ?>
<div class="row">
                    
<div class="col-lg-12 mb-5">
        <div class="p-5">
         
            <div class="row">

                    <div class="col-lg-12 mb-4 ">
                        <div class="card shadow mb-10">
                            <div class="card-header py-4">
                                <h7 class="m-0 font-weight-bold text-primary">busqueda</h7>
                            </div>
                                <div class="card-body">
                                <form action="#" id="busqueda">
                                        <div class="input-group">
                                           
                                            <input name="rut" type="text" class="form-control bg-light border-0 small" placeholder="RUT" aria-label="RUT" aria-describedby="basic-addon2">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fas fa-search fa-sm"></i>
                                                </button>
                                            </div>
                                        </div>
                                    
                              
                                    <input type="hidden" value="" name="id "/>
                <br>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label>NOMBRE
                                                <input type="text" name="nombre" id="nombre" class="form-control form-control-user rut-registro" id="exampleFirstName" placeholder="Nombre completo" value="" >
                                        </label>
                                            </div>
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label>SEXO
                                    <select class="selectpicker form-control bg-light border-0 small rut-registro" name="sexo" id="sexo" value="0">
                                                <option value="0" title="SELECCIONE">SELECCIONE...</option>
                                                <option value="VAR" title="id">HOMBRE</option>
                                                <option value="MUJ" title="userName">MUJER</option>
                                            </select>
                                    </label>
                                            </div>
                                       
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label>DIRECCION
                                                <input type="text" name="direccion" class="form-control form-control-user rut-registro" id="direccion" placeholder="DIRECCION" value="" >
                                        </label>
                                            </div>
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label>COMUNA
                                                <input type="text" name="comuna" class="form-control form-control-user rut-registro" id="comuna" placeholder="COMUNA" value="" >
                                        </label>
                                            </div>
                                       
                                    </div>
                                  
                                   
                                     <div class="col-sm-6 col-md-3">
                                     <div class="text-rigth">
                                        <button class="btn btn-primary btn-user btn-block rut-registro" id="btn-done">aceptar</button>
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
                   
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
    
        $('#busqueda').submit(function(event) {
            // Evita que el formulario se envíe normalmente
            event.preventDefault();
            alert('si pasa');
            // Serializa los datos del formulario
            var formData = $(this).serialize();

            // Envía la solicitud GET
            $.post('<?=site_url('/adm/dashboard/rut/buscar')?>', formData, function(data) {
            
                $('#btn-done').prop('disabled', true);
                $('#nombre').val(data['RUT']['nombre']);
                $('#sexo').val(data['RUT']['sexo']);
                $('#direccion').val(data['RUT']['direccion']);
                $('#comuna').val(data['RUT']['comuna']);
                $('.rut-registro').prop('readonly', true);
            },'json')
            .fail(function(xhr, textStatus, errorThrown) {
                alert(textStatus+", "+errorThrown);
    console.log('Error en la solicitud:', textStatus, errorThrown);
});
        });
    });
</script>
<?php $this->endSection(); ?>