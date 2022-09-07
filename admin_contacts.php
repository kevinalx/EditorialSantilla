<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `mensajes` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_contacts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>mensajes</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_estilos.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="messages">

   <h1 class="title"> mensajes </h1>

   <div class="box-container">
   <?php
      $seleccionar_mensajes = mysqli_query($conn, "SELECT * FROM `mensajes`") or die('query failed');
      if(mysqli_num_rows($seleccionar_mensajes) > 0){
         while($buscar_mensajes = mysqli_fetch_assoc($seleccionar_mensajes)){
      
   ?>
   <div class="box">
      <p> usuario id : <span><?php echo $buscar_mensajes['usuario_id']; ?></span> </p>
      <p> nombre : <span><?php echo $buscar_mensajes['nombre']; ?></span> </p>
      <p> numero : <span><?php echo $buscar_mensajes['numero']; ?></span> </p>
      <p> email : <span><?php echo $buscar_mensajes['email']; ?></span> </p>
      <p> mensaje : <span><?php echo $buscar_mensajes['mensaje']; ?></span> </p>
      <a href="admin_contacts.php?delete=<?php echo $buscar_mensajes['id']; ?>" onclick="return confirm('eliminar mensaje?');" class="delete-btn">Eliminar mensaje</a>
   </div>
   <?php
      };
   }else{
      echo '<p class="empty">no tienes mensajes</p>';
   }
   ?>
   </div>

</section>









<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>