<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin panel</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_estilos.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- admin dashboard section starts  -->

<section class="dashboard">

   <h1 class="title">dashboard</h1>

   <div class="box-container">

      <div class="box">
         <?php
            $total_pendientes = 0;
            $seleccionar_pendiente = mysqli_query($conn, "SELECT total_precio FROM `pedidos` WHERE estado_pago = 'pendiente'") or die('query failed');
            if(mysqli_num_rows($seleccionar_pendiente) > 0){
               while($buscar_pendientes = mysqli_fetch_assoc($seleccionar_pendiente)){
                  $total_precio = $buscar_pendientes['total_precio'];
                  $total_pendientes += $total_precio;
               };
            };
         ?>
         <h3>$<?php echo $total_pendientes; ?>/-</h3>
         <p>total pendientes</p>
      </div>

      <div class="box">
         <?php
            $total_completado = 0;
            $seleccionar_completado = mysqli_query($conn, "SELECT total_precio FROM `pedidos` WHERE estado_pago = 'completado'") or die('query failed');
            if(mysqli_num_rows($seleccionar_completado) > 0){
               while($buscar_completado = mysqli_fetch_assoc($seleccionar_completado)){
                  $total_precio = $buscar_completado['total_precio'];
                  $total_completado += $total_precio;
               };
            };
         ?>
         <h3>$<?php echo $total_completado; ?>/-</h3>
         <p>pago realizado</p>
      </div>

      <div class="box">
         <?php 
            $select_pedidos = mysqli_query($conn, "SELECT * FROM `pedidos`") or die('query failed');
            $numero_de_pedidos = mysqli_num_rows($select_pedidos);
         ?>
         <h3><?php echo $numero_de_pedidos; ?></h3>
         <p>pedido realizado</p>
      </div>

      <div class="box">
         <?php 
            $seleccionar_productos = mysqli_query($conn, "SELECT * FROM `productos`") or die('query failed');
            $numero_de_productos = mysqli_num_rows($seleccionar_productos);
         ?>
         <h3><?php echo $numero_de_productos; ?></h3>
         <p>productos añadidos</p>
      </div>

      <div class="box">
         <?php 
            $seleccionar_usuarios = mysqli_query($conn, "SELECT * FROM `usuarios` WHERE tipo_usuario = 'user'") or die('query failed');
            $numero_de_usuarios = mysqli_num_rows($seleccionar_usuarios);
         ?>
         <h3><?php echo $numero_de_usuarios; ?></h3>
         <p>usuarios normales</p>
      </div>

      <div class="box">
         <?php 
            $seleccionar_admins = mysqli_query($conn, "SELECT * FROM `usuarios` WHERE tipo_usuario = 'admin'") or die('query failed');
            $numero_de_admins = mysqli_num_rows($seleccionar_admins);
         ?>
         <h3><?php echo $numero_de_admins; ?></h3>
         <p>admin usuarios</p>
      </div>

      <div class="box">
         <?php 
            $seleccionar_cuenta = mysqli_query($conn, "SELECT * FROM `usuarios`") or die('query failed');
            $numero_de_cuentas = mysqli_num_rows($seleccionar_cuenta);
         ?>
         <h3><?php echo $numero_de_cuentas; ?></h3>
         <p>total cuentas</p>
      </div>

      <div class="box">
         <?php 
            $seleccionar_mensajes = mysqli_query($conn, "SELECT * FROM `mensajes`") or die('query failed');
            $numero_de_mensajes = mysqli_num_rows($seleccionar_mensajes);
         ?>
         <h3><?php echo $numero_de_mensajes; ?></h3>
         <p>nuevos mensajes</p>
      </div>

   </div>

</section>

<!-- admin dashboard section ends -->









<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>