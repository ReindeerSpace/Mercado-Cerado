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
    }else {
      header("Location: index.php");
    }

    $coneccionBD = mysqli_connect("localhost","id16974633_admin",">@wP{@k%1mE3l2D-");

    mysqli_select_db($coneccionBD, "id16974633_mercadocerrado");

    $errorMsgReg = '';

    if (!empty($_POST['actualizarSubmit'])) {
      $nombre=$_POST['nombre'];
      $correo=$_POST['correo'];
      $domicilio=$_POST['domicilio'];
      $codigo_postal=$_POST['codigo_postal'];
      $estado=$_POST['estado'];
      $municipio=$_POST['municipio'];

      //Comprobacion de campos
      $correo_check = preg_match('~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+.([a-zA-Z]{2,4})$~i', $correo);

      if ($correo_check) {
        $instruccion = "UPDATE usuarios SET nombre = '".$nombre."', correo = '".$correo."', domicilio = '".$domicilio."', codigo_postal = '".$codigo_postal."', estado = '".$estado."', municipio = '".$municipio."' WHERE id = '".$session['id']."'";

        mysqli_query($coneccionBD, $instruccion);

        $instruccion = "SELECT * FROM usuarios WHERE id = '".$session['id']."' LIMIT 1";

        $data = mysqli_query($coneccionBD, $instruccion);

        $data = mysqli_fetch_assoc($data);

        $_SESSION = $data;

        $session = $_SESSION;

        $errorMsgReg = "Datos actualizardos";

        $_POST = null;
      }
      else {
        $errorMsgReg = "Correo invalido";

        $_POST = null;
      }
    }
    ?>
    <title></title>
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
        <div class="col-12">
          <h1>Datos de tu Cuenta</h1>
        </div>
        <hr style="border: 1px solid black;">
        <div class="">
          <h2>Actualizar datos de tu cuenta</h2>
        </div>
        <div class="col-8">
          <form class="" action="cuenta.php" method="post">
            <form class="" action="" method="post" name="signup">
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-10">
                  <input type="text" name="nombre" value="<?php echo $session['nombre']; ?>" class="form-control" required>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Correo</label>
                <div class="col-sm-10">
                  <input type="text" name="correo" value="<?php echo $session['correo']; ?>" class="form-control" required>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Domicilio</label>
                <div class="col-sm-10">
                  <input type="text" name="domicilio" value="<?php echo $session['domicilio']; ?>" class="form-control" required>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Codígo Postal</label>
                <div class="col-sm-10">
                  <input type="text" name="codigo_postal" value="<?php echo $session['codigo_postal']; ?>" class="form-control" required>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Estado</label>
                <div class="col-sm-10">
                  <input type="text" name="estado" value="<?php echo $session['estado']; ?>" class="form-control" required>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Municipio</label>
                <div class="col-sm-10">
                  <input type="text" name="municipio" value="<?php echo $session['municipio']; ?>" class="form-control" required>
                </div>
              </div>
              <div class="mb-3">
                <div class="errorMsg"><?php echo $errorMsgReg; ?></div>
              </div>
              <input type="submit" class="btn btn-primary" name="actualizarSubmit" value="Actualizar">
            </form>
          </form>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
  </body>
</html>
