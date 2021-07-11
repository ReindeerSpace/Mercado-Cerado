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

    .credit-card-div  span { padding-top:10px; }
    .credit-card-div img { padding-top:30px; }
    .credit-card-div .small-font { font-size:9px; }
    .credit-card-div .pad-adjust { padding-top:10px; }
    </style>
    <?php
    //Sesion
    session_start();

    if (!empty($_SESSION['id'])) {
      $session = $_SESSION;
    }

    //Productos
    $coneccionBD = mysqli_connect("localhost","id16974633_admin",">@wP{@k%1mE3l2D-");

    mysqli_select_db($coneccionBD, "id16974633_mercadocerrado");

    //Filtrar
    if (!empty($_GET['producto'])) {
      $producto = $_GET['producto'];

      $instruccion = "SELECT * FROM productos WHERE nombre LIKE '%$producto%'";
    }

    $data = mysqli_query($coneccionBD, $instruccion);

    $data = mysqli_fetch_row($data);

    mysqli_close($coneccionBD);

    //Simular compra
    $msg = '';

    if (!empty($_POST['pagado'])) {
      $msg = 'COMPRA REALIZADA CON EXITO';
    }
    ?>
    <title>Comprar: <?php echo $data[1]; ?></title>
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
        <div class="col-md-5">
          <div class="row">
            <div class="col-12">
              <h2>Datos de Envio</h2>
              <p>Domicilio: <?php echo $session['domicilio']; ?></p>
              <p>Codígo Postal: <?php echo $session['codigo_postal']; ?></p>
              <p>Estado: <?php echo $session['estado']; ?></p>
              <p>Municipio: <?php echo $session['municipio']; ?></p>
            </div>
            <div class="col-12">
              <h2>Datos de Pago</h2>
              <form action="" class="credit-card-div" method="post">
                <div class="panel panel-default" >
                  <div class="panel-heading">
                    <div class="row ">
                      <div class="col-md-12">
                        <input type="text" class="form-control" placeholder="Enter Card Number"  required/>
                      </div>
                    </div>
                    <div class="row ">
                      <div class="col-md-3 col-sm-3 col-xs-3">
                        <span class="help-block text-muted small-font" > Expiry Month</span>
                        <input type="text" class="form-control" placeholder="MM"  required/>
                      </div>
                      <div class="col-md-3 col-sm-3 col-xs-3">
                        <span class="help-block text-muted small-font" >  Expiry Year</span>
                        <input type="text" class="form-control" placeholder="YY"  required/>
                      </div>
                      <div class="col-md-3 col-sm-3 col-xs-3">
                        <span class="help-block text-muted small-font" >  CCV</span>
                        <input type="text" class="form-control" placeholder="CCV"  required/>
                      </div>
                      <div class="col-md-3 col-sm-3 col-xs-3">
                        <img src="img/tarjeta-de-credito.png" class="img-rounded" style = "width: 50px; height: auto;"/>
                      </div>
                    </div>
                    <div class="row ">
                      <div class="col-md-12 pad-adjust">
                        <input type="text" class="form-control" placeholder="Name On The Card"  required/>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 pad-adjust">
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" checked class="text-muted"  required> Save details for fast payments <a href="#"> learn how ?</a>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-sm-6 col-xs-6 pad-adjust">
                        <input type="submit"  class="btn btn-danger" value="CANCELAR" />
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-6 pad-adjust">
                        <input type="submit"  class="btn btn-warning btn-block" name="pagado" value="PAGAR" />
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-5" style="background-color: #e9e9e9; margin: 15px;">
          <h2><?php echo $data[1]; ?></h2>
          <p>Cantidad restante: <?php echo $data[4]; ?> unidades</p>
          <h4>Descripción del Producto</h4>
          <p><?php echo $data[2]; ?></p>
          <h4>Precio: $<?php echo $data[5]; ?>.00</h4>
          <h4>Envio: $99.00</h4>
          <hr style="border: 1px solid black;">
          <h4>Total: $<?php echo $data[5] + 99; ?>.00</h4>
        </div>
        <div class="d-flex align-items-center justify-content-center" style="background-color: #0f8600; color: #FFF; <?php if($msg != '') { echo 'height: 50px;'; } ?> margin: 20px;">
          <div class=""><?php echo $msg; ?></div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
  </body>
</html>
