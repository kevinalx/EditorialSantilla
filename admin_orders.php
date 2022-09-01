<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_POST['actualizar_pedido'])){

   $actualizar_pedido_id = $_POST['pedido_id'];
   $actualizar_pago = $_POST['actualizar_pago'];
   mysqli_query($conn, "UPDATE `pedidos` SET estado_pago = '$actualizar_pago' WHERE id = '$actualizar_pedido_id'") or die('query failed');
   $message[] = '¡el estado del pago ha sido actualizado!';

}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `pedidos` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_orders.php');
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

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_estilos.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="orders">

   <h1 class="title">pedidos realizados</h1>

   <div class="box-container">
      <?php
      $seleccionar_pedidos = mysqli_query($conn, "SELECT * FROM `pedidos`") or die('query failed');
      if(mysqli_num_rows($seleccionar_pedidos) > 0){
         while($buscar_pedidos = mysqli_fetch_assoc($seleccionar_pedidos)){
      ?>
      <div class="box">
         <p> id del usuario : <span><?php echo $buscar_pedidos['usuario_id']; ?></span> </p>
         <p> colocado en : <span><?php echo $buscar_pedidos['colocado_en']; ?></span> </p>
         <p> nombre : <span><?php echo $buscar_pedidos['nombre']; ?></span> </p>
         <p> numero : <span><?php echo $buscar_pedidos['numero']; ?></span> </p>
         <p> email : <span><?php echo $buscar_pedidos['email']; ?></span> </p>
         <p> direccion : <span><?php echo $buscar_pedidos['direccion']; ?></span> </p>
         <p> total productos : <span><?php echo $buscar_pedidos['total_productos']; ?></span> </p>
         <p> total precio : <span>$<?php echo $buscar_pedidos['total_precio']; ?>/-</span> </p>
         <p> metodo de pago : <span><?php echo $buscar_pedidos['metodo']; ?></span> </p>
         <form action="" method="post">
            <input type="hidden" name="pedido_id" value="<?php echo $buscar_pedidos['id']; ?>">
            <select name="actualizar_pago">
               <option value="" selected disabled><?php echo $buscar_pedidos['estado_pago']; ?></option>
               <option value="pendiente">pendiente</option>
               <option value="completado">completado</option>
            </select>
            <input type="submit" value="actualizar" name="actualizar_pedido" class="option-btn">
            <a href="admin_orders.php?delete=<?php echo $buscar_pedidos['id']; ?>" onclick="return confirm('¿borrar este pedido?');" class="delete-btn">Eliminar</a>
         </form>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">¡aún no hay pedidos realizados!</p>';
      }
      ?>
   </div>

</section>










<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>