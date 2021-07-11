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

    //Funciones
    function create_slug($texto){
      $slug = preg_replace('/[^A-Za-z0-9-]+/','+',$texto);
      return $slug;
    }

    //Productos
    $coneccionBD = mysqli_connect("localhost","id16974633_admin",">@wP{@k%1mE3l2D-");

    mysqli_select_db($coneccionBD, "id16974633_mercadocerrado");

    //Filtrar busqueda
    if (!empty($_GET['buscar'])) {
      $busqueda = $_GET['buscar'];

      $instruccion = "SELECT * FROM productos WHERE nombre LIKE '%$busqueda%'";
    }
    else {
      $instruccion = "SELECT * FROM productos";
    }

    $data = mysqli_query($coneccionBD, $instruccion);

    mysqli_close($coneccionBD);
    ?>
    <title>
      <?php
      if (!empty($_GET['buscar'])) {
        echo "Busqueda: ".$busqueda;
      }
      else {
        echo "Mercado Cerrado";
      }
      ?>
    </title>
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
      <div class="row">
        <!-- Productos -->
        <?php
          while ($row = mysqli_fetch_row($data)) {
            echo '<div class="col-md-4">';
            echo '<a href="producto.php?producto='.create_slug($row[1]).'">';
            echo '<img src="img/producto.jpg" alt="producto" style="width: 100%; height: 70%">';
            echo '</a>';
            echo '<a href="producto.php?producto='.create_slug($row[1]).'">';
            echo '<h3>'.$row[1].'</h3>';
            echo '<p>Precio: $ '.$row[5].'.00</p>';
            echo '</a>';
            echo '</div>';
          }
        ?>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
  </body>
</html>
