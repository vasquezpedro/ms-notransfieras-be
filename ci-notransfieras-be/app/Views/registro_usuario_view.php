
<?php $this->extend('dashboard_view'); ?>
<?php $this->section('contenido'); ?>
<div class="row">
                    
                    <div class="col-lg-12">
                        <div class="p-5">
                         
                            <div class="col-lg-12 mb-4 ">
                        <div class="card shadow mb-10">
                            <div class="card-header py-4">
                                <h7 class="m-0 font-weight-bold text-primary">Datos registro</h7>
                            </div>
                                <div class="card-body">
                                        <form class="user" action="<?=site_url('/adm/dashboard/usuario')?>" method="post" id="register_user"  >
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="text" name="names" class="form-control form-control-user" id="nombres" placeholder="Nombres">
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" name="apellidos" class="form-control form-control-user" id="apellidos" placeholder="Apellidos">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="email"  name="email" class="form-control form-control-user" id="email" placeholder="Email">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="usuario" class="form-control form-control-user" id="username" placeholder="Nombre usuario">
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="password" name="password" class="form-control form-control-user" id="password" placeholder="Password">
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="password" name="password2" class="form-control form-control-user" id="repassword" placeholder="Repite Password">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-3">
                                        <button class="btn btn-primary btn-user btn-block">aceptar</button>
                                     </div>   
                                    </form>
                                </div>
                            </div>
                            <div class="card-footer">
                               
                                <?php if(isset($usuarioID)):?>
                                <a href="<?= base_url('adm/dashboard/usuario/rol/'.$usuarioID); ?>" class="btn btn-success  btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-exclamation-triangle"></i>
                                            </span>
                                            <span class="text">el usuario ha sido registrado bajo el id=<?php echo $usuarioID?></span>
                                        </a>
                                <?php endif;?>
                            </div>
                        </div>
                            
                            
                        </div>
                    </div>
                </div> 
<?php $this->endSection(); ?>


