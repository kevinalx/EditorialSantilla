<?php

include 'config.php';

session_start();

$usuario_id = $_SESSION['usuario_id'];

if(!isset($usuario_id)){
   header('location:login.php');
}

if(isset($_POST['add_to_cart'])){

   $producto_nombre = $_POST['producto_nombre'];
   $producto_precio = $_POST['producto_precio'];
   $producto_image = $_POST['producto_image'];
   $producto_cantidad = $_POST['producto_cantidad'];

   $comprobar_numeros_de_carro = mysqli_query($conn, "SELECT * FROM `carrito` WHERE nombre = '$producto_nombre' AND usuario_id = '$usuario_id'") or die('query failed');

   if(mysqli_num_rows($comprobar_numeros_de_carro) > 0){
      $message[] = '¡ya se ha añadido a la cesta!';
   }else{
      mysqli_query($conn, "INSERT INTO `carrito`(usuario_id, nombre, precio, cantidad, image) VALUES('$usuario_id', '$producto_nombre', '$producto_precio', '$producto_cantidad', '$producto_image')") or die('query failed');
      $message[] = '¡producto añadido a la cesta!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>comprar</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/estilos.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>nuestra tienda</h3>
   <p> <a href="home.php">inicio</a> / tienda </p>
</div>

<section class="products">

   <h1 class="title">últimos productos</h1>

   <div class="box-container">

      <?php  
         $seleccionar_productos = mysqli_query($conn, "SELECT * FROM `productos`") or die('query failed');
         if(mysqli_num_rows($seleccionar_productos) > 0){
            while($buscar_productos = mysqli_fetch_assoc($seleccionar_productos)){
      ?>
     <form action="" method="post" class="box">
      <img class="image" src="uploaded_img/<?php echo $buscar_productos['image']; ?>" alt="">
      <div class="nombre"><?php echo $buscar_productos['nombre']; ?></div>
      <div class="precio">$<?php echo $buscar_productos['precio']; ?>/-</div>
      <input type="number" min="1" name="producto_cantidad" value="1" class="qty">
      <input type="hidden" name="producto_nombre" value="<?php echo $buscar_productos['nombre']; ?>">
      <input type="hidden" name="producto_precio" value="<?php echo $buscar_productos['precio']; ?>">
      <input type="hidden" name="producto_image" value="<?php echo $buscar_productos['image']; ?>">
      <input type="submit" value="add to cart" name="add_to_cart" class="btn">
     </form>
      <?php
         }
      }else{
         echo '<p class="empty">¡no hay productos añadidos todavía!</p>';
      }
      ?>
   </div>

</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>