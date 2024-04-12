
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
                                <form action="<?=site_url('adm/dashboard/usuario/rol/find')?>" method="post">
                                        <div class="input-group">
                                            <select class="selectpicker form-control bg-light border-0 small" name="seleccion" value="0">
                                                <option value="0" title="seleccione...">SELECCIONE...</option>
                                                <option value="id" title="id">userID</option>
                                                <option value="username" title="userName">username</option>
                                                <option value="email" title="email">email</option>
                                            </select>
                                            <input name="criterio" type="text" class="form-control bg-light border-0 small" placeholder="buscar..." aria-label="Search" aria-describedby="basic-addon2">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fas fa-search fa-sm"></i>
                                                </button>
                                            </div>
                                        </div>
                                </form>
                                </div>
                                <div class="card-footer">
                                        <?php if(isset($error)):?>
                                      
                                           
                                            <a  class="btn btn-danger btn-icon-split">
                                                <span class="icon text-white-50">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                </span>
                                            <span class="text"><?php echo $error?></span>
                                            </a>
                                        <?php endif;?>
                                </div> 
                    </div>
            </div>

            



            <?php if (!empty($usuarioID) ): ?>

                    <div class="row">
                        <div class="col-lg-12 mb-4 ">
                            <div class="card shadow mb-10">
                                <div class="card-header py-4">
                                        <h7 class="m-0 font-weight-bold text-primary">Datos usuario</h7>
                                    </div>
                                    <div class="card-body">
                                        <div class="col-lg-12 mb-4 ">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    USERID</div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-800"><?php echo $usuarioID->id?></div>
                                            </div>
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    NOMBRE</div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-800"><?php echo $usuarioID->name.' '.$usuarioID->apellido?></div>
                                            </div>
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                USERNAME</div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-800"><?php echo $usuarioID->usuario ?></div>
                                            </div>
                                    
                                         </div>
                                        
                                         
                                        </div>
                            </div>
                        </div>

                        <!-- -->


                        <div class="col-lg-12 mb-4 ">
                                            
                                            <div class="card-header py-4">
                                                <h7 class="m-0 font-weight-bold text-primary">ROL</h7>
                                            </div>
                                             
                                                <form action="<?=site_url('adm/dashboard/usuario/rol/find')?>" method="post">
                                                        <div class="input-group">
                                                        <select class="selectpicker form-control bg-light border-0 small" name="seleccion" value="0">
                                                                    <option value="0" title="seleccione...">SELECCIONE...</option>
                                                                    <?php if (!empty($listadoRoles) && is_array($listadoRoles)): ?>
                                                                                <?php foreach ($listadoRoles as $rol): ?>
                                                                                    <option value="<?php echo $rol['id'] ?>"><?php echo $rol['nombre'] ?></option>
                                                                                <?php endforeach; ?>
                                                                            <?php endif; ?>
                                                                </select>
                                                            
                                                            <div class="input-group-append">
                                                                <button class="btn btn-primary" type="submit">
                                                                    <i class="fas fa-chec fa-sm">Agregar</i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                </form>
                                                </div>
                                                <div class="card-footer">
                                                <?php if (!empty($usuarioID->roles) && is_array($usuarioID->roles)): ?>
                                                            <?php foreach ($usuarioID->roles as $rol): ?>          
                                                                <!-- -->
                                                                <div class="card mb-4 py-3 border-bottom-primary" id="<?php echo $rol->id ?>">
                                                                    <div class="card-body">
                                                                        <?php echo $rol->nombre ?>
                                                                        <a href="<?php echo site_url("adm/dashboard/usuario/rol/delete/")?>" class="btn btn-danger btn-circle">
                                                                            <i class="fas fa-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <!-- -->
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                </div> 
                                            </div>
                                        </div>
                                     <!-- -->



                        
                    </div>
                    

        </div> 
        <?php endif;?>
</div>       
                  
                    
                                    <!-- ASIGNACION DE ROLES INI-->
</div>
                   
                <script>


                </script>
<?php $this->endSection(); ?>