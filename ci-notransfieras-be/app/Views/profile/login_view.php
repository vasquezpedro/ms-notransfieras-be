<!DOCTYPE html>
<html lang="es">


<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>BACKADM</title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url()?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url()?>css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('bootstrap-4.3.1/css/bootstrap.css'); ?>">
  <script src="https://www.google.com/recaptcha/api.js?render=<?php echo $_ENV['recaptchav3_key_site'] ?>"></script>  
  <script src="<?php echo base_url('/js/jquery-3.7.1.min.js'); ?>"></script>  
  <script src="<?php echo base_url('/bootstrap-4.3.1/js/bootstrap.js'); ?>"></script>  
</head>
        <title>fake rut</title>


  
 

   <body class="text-center">

    <script>
    
    $(document).ready(function(){
            $('#enviar').click(function(){
                
                grecaptcha.ready(function() {
                grecaptcha.execute('<?php echo $_ENV['recaptchav3_key_site'] ?>', {action: 'auth'})
                .then(function(token) {
                  $('#loginForm').prepend('<input type="hidden" name="token" value="'+token+'">');
                  $('#loginForm').prepend('<input type="hidden" name="action" value="auth">');
                  $('#loginForm').prepend('<input type="hidden" name="rutID" value="<?php echo $rutID?>">');
                  $('#loginForm').submit();
                    });
                 });
            });
        });
   

 </script>

<div class="container">

  

  <div class="col-lg-8 mb-4 text-center">
    <div class="card shadow mb-10">
     <div class="card-header py-4">
          <h7 class="m-0 font-weight-bold text-primary">Login</h7>
      </div>
            <div class="card-body">

            <div class="row">
                    <div class="col align-self-center">
                      <form action="<?php echo site_url('profile/login')?>"  method="post" id="loginForm">
                     
                       
                      <div class="form-group">
                      <div class="row">
                            <div class="col-lg-5 mb-4">
                              <label for="exampleInputEmail1">user</label>
                            </div>
                            <div class="col-lg-5 mb-4">
                              <input type="text" class="form-control" id="exampleInputPassword1" placeholder="user" name="usuario">
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-lg-5 mb-4">
                              <label for="exampleInputPassword1">Password</label>
                            </div>
                            <div class="col-lg-5 mb-4">
                              <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
                            </div>
                          </div>
                      </div>

                      <button type="button" id="enviar" class="btn btn-primary">Ingresar</button>
                      
                      <?php if(isset($error)):?>
                        <small id="emailHelp" class="form-text text-muted"><?php echo $error ?></small>
                      <?php endif;?>

                      </form>
                    </div>
                  </div>

            </div>
      </div>
    </div>
  </div>

  
</div>
    


</body>