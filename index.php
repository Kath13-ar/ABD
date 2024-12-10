<?php

session_start();
if (!empty($_SESSION['active'])) {
    header('location: src/');
} else {
    if (!empty($_POST)) {
        $alert = '';
        if (empty($_POST['correo']) || empty($_POST['pass'])) {
            $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Ingrese correo y contraseña
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
        } else {
            require_once "conexion.php";
            $user = mysqli_real_escape_string($conexion, $_POST['correo']);
            $pass = md5(mysqli_real_escape_string($conexion, $_POST['pass']));
            $query = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo = '$user' AND pass = '$pass'");
            mysqli_close($conexion);
            $resultado = mysqli_num_rows($query);
            if ($resultado > 0) {
                $dato = mysqli_fetch_array($query);
                $_SESSION['active'] = true;
                $_SESSION['idUser'] = $dato['id'];
                $_SESSION['nombre'] = $dato['nombre'];
                $_SESSION['rol'] = $dato['rol'];
                header('Location: src/dashboard.php');
            } else {
                $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Contraseña incorrecta
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                session_destroy();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  <style>
    body {
    margin: 0;
    padding: 0;
    background-image: url('assets/img/fondo.jpg'); /* Cambia a la ruta correcta */
    background-size: cover; /* Ajusta la imagen para cubrir toda la pantalla */
    background-position: center; /* Centra la imagen */
    background-repeat: no-repeat; /* Evita repeticiones */
    height: 100vh; /* La altura de la pantalla completa */
    display: flex; /* Asegura que el contenido esté alineado */
    align-items: center; /* Centra verticalmente */
    justify-content: center; /* Centra horizontalmente */
}

 .card {
    background-color: rgba(255, 255, 255, 0.8); 
    border-radius: 10px;
    padding: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.card-header {
    font-size: 1.5rem;
    font-weight: bold;
    color: #333;
} 



.card-header {
    font-size: 1.5rem;
    font-weight: bold;
    color: #333;
}

/* .input-group-text {
    background-color: rgba(255, 255, 255, 0.8); 
    border: 1px solid #ccc;
    color: #333; 
}

input.form-control {
    background-color: rgba(255, 255, 255, 0.9); 
    border: 1px solid #ccc; 
    color: #333; 
} */

</style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
  <img src="assets/img/Logo2.jpg" alt="Icon" style="width: 100px; height: 100px; margin-right: 5px;">
  </div>
  <!-- /.login-logo -->
  <div class="card">
    
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="" method="post" autocomplete="off">
      <?php echo (isset($alert)) ? $alert : '' ; ?>  
      <div class="input-group mb-3">
          <input type="email" class="form-control" name="correo" placeholder="correo">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="pass" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-danger btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.min.js"></script>
</body>
</html>
