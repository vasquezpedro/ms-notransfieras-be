
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
                                <form action="<?=site_url('/adm/dashboard/usuario/editor/buscar')?>" method="post">
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
                    </div>
            </div>



            <?php if (!empty($usuarioID) ): ?>
            <div class="row">
                    <!-- busqueda INI-->
                    <div class="col-lg-12 mb-4 ">
                        <div class="card shadow mb-10">
                            <div class="card-header py-4">
                                <h7 class="m-0 font-weight-bold text-primary">Datos del usuario</h7>
                            </div>
                                <div class="card-body">
                                <form class="user" action="<?=site_url('/adm/dashboard/usuario/editor')?>" method="patch" id="register_user"  >
                              
                                    <input type="hidden" value="<?php echo $usuarioID->id ?>" name="id "/>
                              
                         
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                        
                                                
                                                <input type="text" name="name" class="form-control form-control-user" id="exampleFirstName" placeholder="First Name" value="<?php echo $usuarioID->name ?>" >
                                          
                                            
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" name="apellido" class="form-control form-control-user" id="exampleLastName" placeholder="Last Name" value="<?php echo $usuarioID->apellido ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="email"  name="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Email Address" value="<?php echo $usuarioID->email?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="usuario" class="form-control form-control-user" id="exampleInputEmail" placeholder="usuario" value="<?php echo $usuarioID->usuario ?>">
                                    </div>
                                   
                                     <div class="col-sm-6 col-md-3">
                                        <button class="btn btn-primary btn-user btn-block">aceptar</button>
                                     </div>   
                                    
                                    
                                </form>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <!-- busqueda FIN-->
                    <!-- roles INI-->
                    <div class="col-lg-12 mb-4 ">
                        <div class="card shadow mb-10">
                            <div class="card-header py-4">
                                <h7 class="m-0 font-weight-bold text-primary">Roles</h7>
            </div>
                                <div class="card-body">

                                <div class="row">
                                <div class="col-sm-8">
                                <form action="<?=site_url('/adm/dashboard/usuario/editor/buscar')?>" method="post">
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
                                                        <i class="fas fa-search fa-sm"></i>
                                                    </button>
                                                </div>
                                            </div>
                                    </form>
                                </div>
                                    
                                

                      
                                            <div class="col-sm-8">
                                                <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 80%;">nombre</th>
                                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 20%;">Accion</th>
                                            
                                                        </tr>
                                                    </thead>
                                                
                                                    <tbody>
                                                        <?php if (!empty($usuarioID) ): ?>
                                                            <?php if (!empty($usuarioID->roles) && is_array($usuarioID->roles)): ?>
                                                                <?php foreach ($usuarioID->roles as $rol): ?>
                                                                    
                                                                    <tr class="odd" id="<?php echo $rol->id ?>">
                                                                        <td class="sorting_1"><?php echo $rol->nombre ?></td>
                                                                        <td>
                                                                        <a href="#" class="btn btn-danger btn-circle">
                                                                            <i class="fas fa-trash"></i>
                                                                        </a>
                                                                        </td>
                                                                
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        <?php endif; ?>   
                                                    
                                                    </tbody>
                                                </table>
                                            </div>
                                                                </div>
                    
                                </div> 
                            </div>
                        </div>
                    </div>
            </div>
            <!-- roles FIN-->

        </div> 
        <?php endif;?>
</div>       
                  
                    
                                    <!-- ASIGNACION DE ROLES INI-->
</div>
                   

<?php $this->endSection(); ?>