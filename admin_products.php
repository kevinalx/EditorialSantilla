<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_product'])){

   $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
   $precio = $_POST['precio'];
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $seleccionar_productos_nombre = mysqli_query($conn, "SELECT nombre FROM `productos` WHERE nombre = '$nombre'") or die('query failed');

   if(mysqli_num_rows($seleccionar_productos_nombre) > 0){
      $message[] = 'nombre del producto ya añadido';
   }else{
      $añadir_consulta_de_producto = mysqli_query($conn, "INSERT INTO `productos`(nombre, precio, image) VALUES('$nombre', '$precio', '$image')") or die('query failed');

      if($añadir_consulta_de_producto){
         if($image_size > 2000000){
            $message[] = 'el tamaño de la imagen es demasiado grande';
         }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = '¡producto añadido con éxito!';
         }
      }else{
         $message[] = '¡el producto no pudo ser añadido!';
      }
   }
}

if(isset($_GET['delete'])){
   $eliminar_id = $_GET['delete'];
   $consulta_de_eliminacion_de_imagen = mysqli_query($conn, "SELECT image FROM `productos` WHERE id = '$eliminar_id'") or die('query failed');
   $buscar_eliminar_imagen = mysqli_fetch_assoc($consulta_de_eliminacion_de_imagen);
   unlink('uploaded_img/'.$buscar_eliminar_imagen['image']);
   mysqli_query($conn, "DELETE FROM `productos` WHERE id = '$eliminar_id'") or die('query failed');
   header('location:admin_products.php');
}

if(isset($_POST['update_product'])){

   $actualizar_p_id = $_POST['actualizar_p_id'];
   $actualizar_nombre = $_POST['actualizar_nombre'];
   $actualizar_precio = $_POST['actualizar_precio'];

   mysqli_query($conn, "UPDATE `productos` SET nombre = '$actualizar_nombre', precio = '$actualizar_precio' WHERE id = '$actualizar_p_id'") or die('query failed');

   $update_image = $_FILES['update_image']['name'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_folder = 'uploaded_img/'.$update_image;
   $update_old_image = $_POST['update_old_image'];

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'image file size is too large';
      }else{
         mysqli_query($conn, "UPDATE `products` SET image = '$update_image' WHERE id = '$actualizar_p_id'") or die('query failed');
         move_uploaded_file($update_image_tmp_name, $update_folder);
         unlink('uploaded_img/'.$update_old_image);
      }
   }

   header('location:admin_products.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>productos</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_estilos.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- product CRUD section starts  -->

<section class="add-products">

   <h1 class="title">productos de la tienda</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <h3>añadir producto</h3>
      <input type="text" name="nombre" class="box" placeholder="introduzca el nombre del producto" required>
      <input type="number" min="0" name="precio" class="box" placeholder="introduzca el precio del producto" required>
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
      <input type="submit" value="add product" name="add_product" class="btn">
   </form>

</section>

<!-- product CRUD section ends -->

<!-- show products  -->

<section class="show-products">

   <div class="box-container">

      <?php
         $seleccionar_productos = mysqli_query($conn, "SELECT * FROM `productos`") or die('query failed');
         if(mysqli_num_rows($seleccionar_productos) > 0){
            while($buscar_productos = mysqli_fetch_assoc($seleccionar_productos)){
      ?>
      <div class="box">
         <img src="uploaded_img/<?php echo $buscar_productos['image']; ?>" alt="">
         <div class="nombre"><?php echo $buscar_productos['nombre']; ?></div>
         <div class="precio">$<?php echo $buscar_productos['precio']; ?></div>
         <a href="admin_products.php?update=<?php echo $buscar_productos['id']; ?>" class="option-btn">Actualizar</a>
         <a href="admin_products.php?delete=<?php echo $buscar_productos['id']; ?>" class="delete-btn" onclick="return confirm('¿eliminar este producto?');">Eliminar</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">¡no hay productos añadidos todavía!</p>';
      }
      ?>
   </div>

</section>

<section class="edit-product-form">

   <?php
      if(isset($_GET['update'])){
         $actualizar_id = $_GET['update'];
         $actualizar_busqueda = mysqli_query($conn, "SELECT * FROM `productos` WHERE id = '$actualizar_id'") or die('query failed');
         if(mysqli_num_rows($actualizar_busqueda) > 0){
            while($buscar_actualizacion = mysqli_fetch_assoc($actualizar_busqueda)){
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="actualizar_p_id" value="<?php echo $buscar_actualizacion['id']; ?>">
      <input type="hidden" name="update_old_image" value="<?php echo $buscar_actualizacion['image']; ?>">
      <img src="uploaded_img/<?php echo $buscar_actualizacion['image']; ?>" alt="">
      <input type="text" name="actualizar_nombre" value="<?php echo $buscar_actualizacion['nombre']; ?>" class="box" required placeholder="introduzca el nombre del producto">
      <input type="number" name="actualizar_precio" value="<?php echo $buscar_actualizacion['precio']; ?>" min="0" class="box" required placeholder="introduzca el precio">
      <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
      <input type="submit" value="update" name="update_product" class="btn">
      <input type="reset" value="cancel" id="close-update" class="option-btn">
   </form>
   <?php
         }
      }
      }else{
         echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
      }
   ?>

</section>







<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>