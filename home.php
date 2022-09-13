<?php

include 'config.php';

session_start();

$usuario_id = $_SESSION['usuario_id'];

if(!isset($usuario_id)){
   header('location:login.php');
}

if(isset($_POST['add_al_carrito'])){

   $nombre_producto = $_POST['nombre'];
   $precio_producto = $_POST['precio'];
   $imagen_producto = $_POST['image'];
   $cantidad_producto = $_POST['cantidad'];

   $comprobar_numeros_de_carro = mysqli_query($conn, "SELECT * FROM `carrito` WHERE nombre = '$nombre_producto' AND usuario_id = '$usuario_id'") or die('query failed');

   if(mysqli_num_rows($comprobar_numeros_de_carro) > 0){
      $message[] = '¡ya se ha añadido a la cesta!';
   }else{
      mysqli_query($conn, "INSERT INTO `carrito`(usuario_id, nombre, precio, cantidad, image) VALUES('$usuario_id', '$nombre_producto', '$precio_producto', '$cantidad_producto', '$imagen_producto')") or die('query failed');
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
   <title>inicio</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/estilos.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="home">

   <div class="content">
      <h3>Libro escogido a mano a su puerta.</h3>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi, quod? Reiciendis ut porro iste totam.</p>
      <a href="about.php" class="white-btn">discover more</a>
   </div>

</section>

<section class="products">

   <h1 class="title">últimos productos</h1>

   <div class="box-container">

      <?php  
         $seleccionar_productos = mysqli_query($conn, "SELECT * FROM `productos` LIMIT 6") or die('query failed');
         if(mysqli_num_rows($seleccionar_productos) > 0){
            while($buscar_productos = mysqli_fetch_assoc($seleccionar_productos)){
      ?>
     <form action="" method="post" class="box">
      <img class="image" src="uploaded_img/<?php echo $buscar_productos['image']; ?>" alt="">
      <div class="nombre"><?php echo $buscar_productos['nombre']; ?></div>
      <div class="precio">$<?php echo $buscar_productos['precio']; ?>/-</div>
      <input type="number" min="1" name="cantidad" value="1" class="qty">
      <input type="hidden" name="nombre" value="<?php echo $buscar_productos['nombre']; ?>">
      <input type="hidden" name="precio" value="<?php echo $buscar_productos['precio']; ?>">
      <input type="hidden" name="image" value="<?php echo $buscar_productos['image']; ?>">
      <input type="submit" value="add to cart" name="add_al_carrito" class="btn">
     </form>
      <?php
         }
      }else{
         echo '<p class="empty">¡no hay productos añadidos todavía!</p>';
      }
      ?>
   </div>

   <div class="load-more" style="margin-top: 2rem; text-align:center">
      <a href="shop.php" class="option-btn">cargar más</a>
   </div>

</section>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/about-img.jpg" alt="">
      </div>

      <div class="content">
         <h3>about us</h3>
         <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit quos enim minima ipsa dicta officia corporis ratione saepe sed adipisci?</p>
         <a href="about.php" class="btn">read more</a>
      </div>

   </div>

</section>

<section class="home-contact">

   <div class="content">
      <h3>¿tiene alguna pregunta?</h3>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Atque cumque exercitationem repellendus, amet ullam voluptatibus?</p>
      <a href="contact.php" class="white-btn">contact us</a>
   </div>

</section>





<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>