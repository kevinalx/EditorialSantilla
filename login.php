<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $contrasena = mysqli_real_escape_string($conn, md5($_POST['contrasena']));

   $seleccionar_usuarios = mysqli_query($conn, "SELECT * FROM `usuarios` WHERE email = '$email' AND contrasena = '$contrasena'") or die('query failed');

   if(mysqli_num_rows($seleccionar_usuarios) > 0){

      $row = mysqli_fetch_assoc($seleccionar_usuarios);
      
      if($row['tipo_usuario'] == 'user'){

         $_SESSION['user_name'] = $row['nombre'];
         $_SESSION['user_email'] = $row['email'];
         $_SESSION['usuario_id'] = $row['id'];
         header('location:home.php');

      }
      if($row['tipo_usuario'] == 'admin'){

         $_SESSION['admin_name'] = $row['nombre'];
         $_SESSION['admin_email'] = $row['email'];
         $_SESSION['admin_id'] = $row['id'];
         header('location:admin_page.php');

      }
   }else{
      $message[] = 'contraseña o email incorrecto!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/estilos.css">

</head>
<body>

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
   
<div class="form-container">

   <form action="" method="post">
      <h3>Ingresar</h3>
      <input type="email" name="email" placeholder="ingresa tu email" required class="box">
      <input type="password" name="password" placeholder="ingresa tu contraseña" required class="box">
      <input type="submit" name="submit" value="Ingresar" class="btn">
      <p>¿no tienes una cuenta? <a href="registro.php">Registrate</a></p>
   </form>

</div>

</body>
</html>