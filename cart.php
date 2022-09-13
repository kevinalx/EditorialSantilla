<?php

include 'config.php';

session_start();

$usuario_id = $_SESSION['usuario_id'];

if(!isset($usuario_id)){
   header('location:login.php');
}

if(isset($_POST['actualizar_carrito'])){
   $carrito_id = $_POST['carrito_id'];
   $carrito_cantidad = $_POST['carrito_cantidad'];
   mysqli_query($conn, "UPDATE `carrito` SET cantidad = '$carrito_cantidad' WHERE id = '$carrito_id'") or die('query failed');
   $message[] = '¡cantidad de la cesta actualizada!';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `carrito` WHERE id = '$delete_id'") or die('query failed');
   header('location:cart.php');
}

if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `carrito` WHERE usuario_id = '$usuario_id'") or die('query failed');
   header('location:cart.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>carrito</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/estilos.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>carrito de compras</h3>
   <p> <a href="home.php">inicio</a> / carrito </p>
</div>

<section class="shopping-cart">

   <h1 class="title">productos añadidos</h1>

   <div class="box-container">
      <?php
         $total_general = 0;
         $seleccionar_carrito = mysqli_query($conn, "SELECT * FROM `carrito` WHERE usuario_id = '$usuario_id'") or die('query failed');
         if(mysqli_num_rows($seleccionar_carrito) > 0){
            while($buscar_carrito = mysqli_fetch_assoc($seleccionar_carrito)){   
      ?>
      <div class="box">
         <a href="cart.php?delete=<?php echo $buscar_carrito['id']; ?>" class="fas fa-times" onclick="return confirm('¿quieres eliminar esto de la cesta?');"></a>
         <img src="uploaded_img/<?php echo $buscar_carrito['image']; ?>" alt="">
         <div class="nombre"><?php echo $buscar_carrito['nombre']; ?></div>
         <div class="precio">$<?php echo $buscar_carrito['precio']; ?>/-</div>
         <form action="" method="post">
            <input type="hidden" name="carrito_id" value="<?php echo $buscar_carrito['id']; ?>">
            <input type="number" min="1" name="carrito_cantidad" value="<?php echo $buscar_carrito['cantidad']; ?>">
            <input type="submit" name="actualizar_carrito" value="update" class="option-btn">
         </form>
         <div class="sub-total"> sub total : <span>$<?php echo $sub_total = ($buscar_carrito['cantidad'] * $buscar_carrito['precio']); ?></span> </div>
      </div>
      <?php
      $total_general += $sub_total;
         }
      }else{
         echo '<p class="empty">su cesta está vacía</p>';
      }
      ?>
   </div>

   <div style="margin-top: 2rem; text-align:center;">
      <a href="cart.php?delete_all" class="delete-btn <?php echo ($total_general > 1)?'':'disabled'; ?>" onclick="return confirm('¿borrar todo del carrito?');">eliminar todo</a>
   </div>

   <div class="cart-total">
      <p> total general: <span>$<?php echo $total_general; ?>/-</span></p>
      <div class="flex">
         <a href="shop.php" class="option-btn">seguir comprando</a>
         <a href="checkout.php" class="btn <?php echo ($total_general > 1)?'':'disabled'; ?>">pasar a la caja</a>
      </div>
   </div>

</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>