<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <style media="screen">
    body{
      background-color: #bdbdbd;
    }
    a{
      text-decoration: none;
      color: #000;
    }

    .container-fluid{
      background-color: #ffd72b;
      padding: 10px;
    }
    .container{
      background-color: #fffefa;
      padding: 10px;
    }
    </style>
    <?php
    //Sesion
    session_start();

    if (!empty($_SESSION['id'])) {
      $session = $_SESSION;
    }

    $coneccionBD = mysqli_connect("localhost","id16974633_admin",">@wP{@k%1mE3l2D-");

    mysqli_select_db($coneccionBD, "id16974633_mercadocerrado");

    $errorMsgReg = '';

    if (!empty($_POST['registrarSubmit'])) {
      $nombre=$_POST['nombre'];
      $correo=$_POST['correo'];
      $contraseña=$_POST['contraseña'];
      $domicilio=$_POST['domicilio'];
      $codigo_postal=$_POST['codigo_postal'];
      $estado=$_POST['estado'];
      $municipio=$_POST['municipio'];

      //Comprobacion de existencia
      $instruccion = "SELECT correo FROM usuarios WHERE correo = '".$correo."' LIMIT 1";

      $data = mysqli_query($coneccionBD, $instruccion);

      $user = mysqli_fetch_assoc($data);

      //Comprobacion de campos
      $correo_check = preg_match('~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+.([a-zA-Z]{2,4})$~i', $correo);
      $contraseña_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $contraseña);

      if ($correo_check) {
        if ($contraseña_check) {
          if ($user) {
            $instruccion = "INSERT INTO usuarios (nombre, correo, contraseña, domicilio, codigo_postal, estado, municipio) VALUES ('".$nombre."', '".$correo."', '".$contraseña."', '".$domicilio."', '".$codigo_postal."', '".$estado."', '".$municipio."')";

            mysqli_query($coneccionBD, $instruccion);

            $user_id = mysqli_insert_id($coneccionBD);

            $instruccion = "SELECT * FROM usuarios WHERE id = '".$user_id."' LIMIT 1";

            $data = mysqli_query($coneccionBD, $instruccion);

            $data = mysqli_fetch_assoc($data);

            $_SESSION = $data;

            $errorMsgReg = "Usuario Registrado";

            header('location: index.php');
          }
          else{
            $errorMsgReg = "Este usuarios ya esta registrado";
          }
        }
        else {
          $errorMsgReg = "Contraseña invalido";
        }
      }
      else {
        $errorMsgReg = "Correo invalido";
      }
    }

    mysqli_close($coneccionBD);
    ?>
    <title>Registrar</title>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-8 align-self-center">
          <a href="index.php"><h1>Mercado Cerrado</h1></a>
        </div>
        <div class="col-md-4 align-self-center">
          <form class="" action="index.php" method="get" style="float: left;">
            <input type="text" name="buscar" placeholder="Nombre del Producto">
            <button type="submit" class="btn btn-primary">Buscar</button>
          </form>
          <?php if (empty($session)): ?>
            <a href="registrar.php" class="float-left" style="margin-left: 10px;">Registrar</a>
            <a href="iniciar-secion.php" style="margin-left: 10px;">Iniciar Seción</a>
          <?php elseif(!empty($session)): ?>
            <a href="cuenta.php" class="float-left"  style="margin-left: 10px;">Cuenta</a>
            <a href="cerrar-secion.php" class="float-left"  style="margin-left: 10px;">Cerrar Seción</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row justify-content-md-center">
        <div class="col-md-12">
          <h2>Registrar</h2>
        </div>
        <div class="col-md-6">
          <form class="" action="" method="post" name="signup">
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">Nombre</label>
              <div class="col-sm-10">
                <input type="text" name="nombre" value="" class="form-control" required>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">Correo</label>
              <div class="col-sm-10">
                <input type="text" name="correo" value="" class="form-control" required>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">Contraseña</label>
              <div class="col-sm-10">
                <input type="text" name="contraseña" minlength="6" maxlength="25" value="" class="form-control" required>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">Domicilio</label>
              <div class="col-sm-10">
                <input type="text" name="domicilio" value="" class="form-control" required>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">Codígo Postal</label>
              <div class="col-sm-10">
                <input type="text" name="codigo_postal" value="" class="form-control" required>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">Estado</label>
              <div class="col-sm-10">
                <input type="text" name="estado" value="" class="form-control" required>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">Municipio</label>
              <div class="col-sm-10">
                <input type="text" name="municipio" value="" class="form-control" required>
              </div>
            </div>
            <div class="mb-3">
              <div class="errorMsg"><?php echo $errorMsgReg; ?></div>
            </div>
            <input type="submit" class="btn btn-primary" name="registrarSubmit" value="Registrar">
          </form>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
  </body>
</html>
