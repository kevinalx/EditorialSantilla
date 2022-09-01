<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `usuarios` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_users.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_estilos.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="users">

   <h1 class="title"> cuentas de usuario </h1>

   <div class="box-container">
      <?php
         $seleccionar_usuarios = mysqli_query($conn, "SELECT * FROM `usuarios`") or die('query failed');
         while($buscar_usuarios = mysqli_fetch_assoc($seleccionar_usuarios)){
      ?>
      <div class="box">
         <p> usuario id : <span><?php echo $buscar_usuarios['id']; ?></span> </p>
         <p> nombre de usuario : <span><?php echo $buscar_usuarios['nombre']; ?></span> </p>
         <p> email : <span><?php echo $buscar_usuarios['email']; ?></span> </p>
         <p> tipo de usuario : <span style="color:<?php if($buscar_usuarios['tipo_usuario'] == 'admin'){ echo 'var(--orange)'; } ?>"><?php echo $buscar_usuarios['tipo_usuario']; ?></span> </p>
         <a href="admin_users.php?delete=<?php echo $buscar_usuarios['id']; ?>" onclick="return confirm('eliminar ');" class="delete-btn">Eliminar usuario</a>
      </div>
      <?php
         };
      ?>
   </div>

</section>









<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>