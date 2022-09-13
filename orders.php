<?php

include 'config.php';

session_start();

$usuario_id = $_SESSION['usuario_id'];

if(!isset($usuario_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>pedidos</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/estilos.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>tus pedidos</h3>
   <p> <a href="home.php">inicio</a> / pedidos </p>
</div>

<section class="placed-orders">

   <h1 class="title">pedidos realizados</h1>

   <div class="box-container">

      <?php
         $consulta_de_pedido = mysqli_query($conn, "SELECT * FROM `pedidos` WHERE usuario_id = '$usuario_id'") or die('query failed');
         if(mysqli_num_rows($consulta_de_pedido) > 0){
            while($buscar_pedidos = mysqli_fetch_assoc($consulta_de_pedido)){
      ?>
      <div class="box">
         <p> colocado en : <span><?php echo $buscar_pedidos['colocado_en']; ?></span> </p>
         <p> nombre : <span><?php echo $buscar_pedidos['nombre']; ?></span> </p>
         <p> numero : <span><?php echo $buscar_pedidos['numero']; ?></span> </p>
         <p> email : <span><?php echo $buscar_pedidos['email']; ?></span> </p>
         <p> direccion : <span><?php echo $buscar_pedidos['direccion']; ?></span> </p>
         <p> metodo de pago : <span><?php echo $buscar_pedidos['metodo']; ?></span> </p>
         <p> tus pedidos : <span><?php echo $buscar_pedidos['toltal_productos']; ?></span> </p>
         <p> total precio : <span>$<?php echo $buscar_pedidos['total_precio']; ?>/-</span> </p>
         <p> estado del pago : <span style="color:<?php if($buscar_pedidos['estado_pago'] == 'pendiente'){ echo 'red'; }else{ echo 'green'; } ?>;"><?php echo $buscar_pedidos['estado_pago']; ?></span> </p>
         </div>
      <?php
       }
      }else{
         echo '<p class="empty">¡aún no hay pedidos realizados!</p>';
      }
      ?>
   </div>

</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>