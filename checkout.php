<?php

include 'config.php';

session_start();

$usuario_id = $_SESSION['usuario_id'];

if(!isset($usuario_id)){
   header('location:login.php');
}

if(isset($_POST['order_btn'])){

   $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
   $numero = $_POST['numero'];
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $metodo = mysqli_real_escape_string($conn, $_POST['metodo']);
   $direccion = mysqli_real_escape_string($conn, 'piso no. '. $_POST['piso'].', '. $_POST['calle'].', '. $_POST['ciudad'].', '. $_POST['pais'].' - '. $_POST['codigo_postal']);
   $colocado_en = date('d-M-Y');

   $carrito_total = 0;
   $carrito_productos[] = '';

   $consulta_de_carrito = mysqli_query($conn, "SELECT * FROM `carrito` WHERE usuario_id = '$usuario_id'") or die('query failed');
   if(mysqli_num_rows($consulta_de_carrito) > 0){
      while($carrito_item = mysqli_fetch_assoc($consulta_de_carrito)){
         $carrito_productos[] = $carrito_item['nombre'].' ('.$carrito_item['cantidad'].') ';
         $sub_total = ($carrito_item['precio'] * $carrito_item['cantidad']);
         $carrito_total += $sub_total;
      }
   }

   $total_productos = implode(', ',$carrito_productos);

   $consulta_de_pedido = mysqli_query($conn, "SELECT * FROM `pedidos` WHERE nombre = '$nombre' AND numero = '$numero' AND email = '$email' AND metodo = '$metodo' AND direccion = '$direccion' AND total_productos = '$total_productos' AND total_precio = '$carrito_total'") or die('query failed');

   if($carrito_total == 0){
      $message[] = 'su cesta está vacía';
   }else{
      if(mysqli_num_rows($consulta_de_pedido) > 0){
         $message[] = '¡pedido ya realizado!'; 
      }else{
         mysqli_query($conn, "INSERT INTO `pedidos`(usuario_id, nombre, numero, email, metodo, direccion, total_productos, total_precio, colocado_en) VALUES('$usuario_id', '$nombre', '$numero', '$email', '$metodo', '$direccion', '$total_productos', '$carrito_total', '$colocado_en')") or die('query failed');
         $message[] = '¡pedido realizado con éxito!';
         mysqli_query($conn, "DELETE FROM `carrito` WHERE usuario_id = '$usuario_id'") or die('query failed');
      }
   }
   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/estilos.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>checkout</h3>
   <p> <a href="home.php">inicio</a> / checkout </p>
</div>

<section class="display-order">

   <?php  
      $total_general = 0;
      $seleccionar_carrito = mysqli_query($conn, "SELECT * FROM `carrito` WHERE usuario_id = '$usuario_id'") or die('query failed');
      if(mysqli_num_rows($seleccionar_carrito) > 0){
         while($buscar_carrito = mysqli_fetch_assoc($seleccionar_carrito)){
            $total_precio = ($buscar_carrito['precio'] * $buscar_carrito['cantidad']);
            $total_general += $total_precio;
   ?>
   <p> <?php echo $buscar_carrito['nombre']; ?> <span>(<?php echo '$'.$buscar_carrito['precio'].''.' x '. $buscar_carrito['cantidad']; ?>)</span> </p>
   <?php
      }
   }else{
      echo '<p class="empty">tu carrito esta vacio</p>';
   }
   ?>
   <div class="grand-total">  total general: <span>$<?php echo $total_general; ?>/-</span> </div>

</section>

<section class="checkout">

   <form action="" metodo="post">
      <h3>haga su pedido</h3>
      <div class="flex">
         <div class="inputBox">
            <span>tu nombre :</span>
            <input type="text" name="nombre" required placeholder="intoduzca su nombre">
         </div>
         <div class="inputBox">
            <span>tu numero :</span>
            <input type="number" name="numero" required placeholder="intoduzca su numero">
         </div>
         <div class="inputBox">
            <span>tu email :</span>
            <input type="email" name="email" required placeholder="intoduzca su email">
         </div>
         <div class="inputBox">
            <span> metodo de pago :</span>
            <select name="metodo">
               <option value="pago contraentrega">pago contraentrega</option>
               <option value="tarjeta de credito">tarjeta de crdito</option>
               <option value="paypal">paypal</option>
            </select>
         </div>
         <div class="inputBox">
            <span>direccion linea 01 :</span>
            <input type="number" min="0" name="piso" required placeholder="e.g. piso no.">
         </div>
         <div class="inputBox">
            <span>direccion line 01 :</span>
            <input type="text" name="calle" required placeholder="e.g. nombre de la calle">
         </div>
         <div class="inputBox">
            <span>ciudad :</span>
            <input type="text" name="ciudad" required placeholder="e.g. medellin">
         </div>
         <div class="inputBox">
            <span>estado :</span>
            <input type="text" name="estado" required placeholder="e.g. antioquia">
         </div>
         <div class="inputBox">
            <span>pais :</span>
            <input type="text" name="pais" required placeholder="e.g. colombia">
         </div>
         <div class="inputBox">
            <span>codigo postal :</span>
            <input type="number" min="0" name="codigo_postal" required placeholder="e.g. 123456">
         </div>
      </div>
      <input type="submit" value="pedir ahora" class="btn" name="order_btn">
   </form>

</section>









<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>