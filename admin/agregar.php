<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
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

    if (!empty($_SESSION['admin-id'])) {
      $session = $_SESSION;
    }else {
      header("Location: iniciar-secion.php");
    }

    //Productos
    $coneccionBD = mysqli_connect("localhost","id16974633_admin",">@wP{@k%1mE3l2D-");

    mysqli_select_db($coneccionBD, "id16974633_mercadocerrado");

    $msg = '';

    if (!empty($_POST['registerSubmit'])) {
      $nombre = $_POST['nombre'];
      $descripcion = $_POST['descripcion'];
      $cantidad = $_POST['cantidad'];
      $precio = $_POST['precio'];

      $instruccion = "INSERT INTO productos (nombre, descripcion, cantidad, precio) VALUES ('".$nombre."', '".$descripcion."', '".$cantidad."', '".$precio."')";

      mysqli_query($coneccionBD, $instruccion);

      $msg = "Producto agragado exitosamente";

      $_POST = null;
    }

    mysqli_close($coneccionBD);
    ?>
    <title>Inventario Admin</title>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-8 align-self-center">
          <h1>Mercado Cerrado</h1>
        </div>
        <div class="col-md-4 align-self-center">
          <?php if(!empty($session['admin-id'])): ?>
            <a href="../cerrar-secion.php" class="float-left"  style="margin-left: 10px;">Cerrar Seción</a>
          <?php endif; ?>
        </div>
        <div class="col-12">
          <nav class="navbar navbar-expand-lg navbar-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav">
                <li class="nav-item active">
                  <a class="nav-link" href="inventario.php">Inventario</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="agregar.php">Agregar Producto</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="actualizar.php">Actualizar Producto</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="eliminar.php">Eliminar Producto</a>
                </li>
              </ul>
            </div>
          </nav>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row justify-content-md-center">
        <div class="col-6">
          <h2>Producto</h2>
          <form class="" action="" method="post" name="signup">
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">Nombre</label>
              <div class="col-sm-10">
                <input type="text" name="nombre" value="" class="form-control" required>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">Descripción</label>
              <div class="col-sm-10">
                <input type="text" name="descripcion" value="" class="form-control" required>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">Cantidad</label>
              <div class="col-sm-10">
                <input type="text" name="cantidad" value="" class="form-control" required>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">Precio</label>
              <div class="col-sm-10">
                <input type="text" name="precio" value="" class="form-control" required>
              </div>
            </div>
            <div class="mb-3">
              <div class=""><?php echo $msg; ?></div>
            </div>
            <input type="submit" class="btn btn-primary" name="registerSubmit" value="Registrar">
          </form>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
  </body>
</html>
