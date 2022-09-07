<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <div class="header-1">
      <div class="flex">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <p> Iniciar <a href="login.php">sesion</a> | <a href="registro.php">registrarse</a> </p>
      </div>
   </div>

   <div class="header-2">
      <div class="flex">
         <a href="home.php" class="logo">Editorial Santillana.</a>

         <nav class="navbar">
            <a href="home.php">inicio</a>
            <a href="about.php">acerca de</a>
            <a href="shop.php">comprar</a>
            <a href="contact.php">contacto</a>
            <a href="orders.php">pedidos</a>
         </nav>

         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="buscar_pagina.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            <?php
               $seleccionar_numero_de_carro = mysqli_query($conn, "SELECT * FROM `carrito` WHERE usuario_id = '$usuario_id'") or die('query failed');
               $numero_de_filas_del_carrito = mysqli_num_rows($seleccionar_numero_de_carro); 
            ?>
            <a href="carrito.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $numero_de_filas_del_carrito; ?>)</span> </a>
         </div>

         <div class="user-box">
            <p>Nombre de usuario : <span><?php echo $_SESSION['nombre']; ?></span></p>
            <p>email : <span><?php echo $_SESSION['email']; ?></span></p>
            <a href="cerrarsesion.php" class="delete-btn">Cerrar sesion</a>
         </div>
      </div>
   </div>

</header>