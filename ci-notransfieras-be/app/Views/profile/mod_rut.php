
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
                                <h7 class="m-0 font-weight-bold text-primary">Busqueda</h7>
                            </div>
                                <div class="card-body">
                                <form action="#" id="busqueda">
                                        <div class="input-group">
                                           
                                            <input name="rut" type="text" class="form-control bg-light border-0 small rut-registro" placeholder="RUT" aria-label="RUT" aria-describedby="basic-addon2">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fas fa-search fa-sm"></i>
                                                </button>
                                            </div>
                                        </div>
                                    
                              
                               <form>
</div>
                                    <div class="card-header py-4">
                                <h7 class="m-0 font-weight-bold text-primary">Datos RUT</h7>
                            </div>
                            <div class="card-body">
                              
                            <div class="form-group ">
                                       
                                        <label>NOMBRE
                                        </label>
                                        <input type="text" name="nombre" id="nombre" class="form-control form-control-user rut-registro"  placeholder="Nombre completo" value="" >
                                        
                                            </div>
                            <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label>ID</label>
                                        <input type="text" name="id" id="id" class="form-control form-control-user rut-registro"  readonly >
                                        
                                            </div>
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label>SEXO</label>
                                    <select class="selectpicker form-control bg-light border-0 small rut-registro" name="sexo" id="sexo" value="0">
                                                <option value="0" title="SELECCIONE">SELECCIONE...</option>
                                                <option value="VAR" title="id">HOMBRE</option>
                                                <option value="MUJ" title="userName">MUJER</option>
                                            </select>
                                    
                                            </div>
                                       
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label>DIRECCION</label>
                                                <input type="text" name="direccion" class="form-control form-control-user rut-registro" id="direccion" placeholder="DIRECCION" value="" >
                                        
                                            </div>
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label>COMUNA</label>
                                                <input type="text" name="comuna" class="form-control form-control-user rut-registro" id="comuna" placeholder="COMUNA" value="" >
                                        
                                            </div>
                                       
                                    </div>
                                  
                                   
                                     <div class="col-sm-6 col-md-3">
                                     <div class="text-rigth">
                                        <button class="btn btn-primary btn-user btn-block rut-registro" id="btn-done" >aceptar</button>
                                     </div>
                                     </div>   
                              
                                </div>
                               
                            </div>
                        </div>
                    </div>
            </div>



           
</div>       
 
</div>
                   
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        $('#btn-done').prop('disabled', true);

            $('#btn-done').click(function(event) {

            event.preventDefault();

            var formData = $(this).serialize();

          
            $.post('<?=site_url('/adm/dashboard/rut/alter')?>', formData, function(data) {
                alert("se ha modificado el RUT");
                $('#btn-done').prop('disabled', true);
                $('.rut-registro').val("");
  
            },'json')
            .fail(function(xhr, textStatus, errorThrown) {
                alert(textStatus+", "+errorThrown);
            console.log('Error en la solicitud:', textStatus, errorThrown);
            });
        });

        $('#busqueda').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
              
                $.post('<?=site_url('/adm/dashboard/rut/buscar')?>', formData, function(data) {
                    $('#btn-done').prop('disabled', false);
                    $('#id').val(data['RUT']['id']);
                    $('#nombre').val(data['RUT']['nombre']);
                    $('#sexo').val(data['RUT']['sexo']);
                    $('#direccion').val(data['RUT']['direccion']);
                    $('#comuna').val(data['RUT']['comuna']);
                    //$('.rut-registro').prop('readonly', true);
                },'json')
                .fail(function(xhr, textStatus, errorThrown) {
                    alert(textStatus+", "+errorThrown);
                console.log('Error en la solicitud:', textStatus, errorThrown);
                });
                });
    });
</script>
<?php $this->endSection(); ?>