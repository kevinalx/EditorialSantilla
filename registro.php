<?php

include 'config.php';

if(isset($_POST['submit'])){

   $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $contrasena = mysqli_real_escape_string($conn, md5($_POST['contrasena']));
   $ccontrasena = mysqli_real_escape_string($conn, md5($_POST['ccontrasena']));
   $tipo_usuario = $_POST['tipo_usuario'];

   $select_usuarios = mysqli_query($conn, "SELECT * FROM `usuarios` WHERE email = '$email' AND contrasena = '$contrasena'") or die('query failed');

   if(mysqli_num_rows($select_usuarios) > 0){
      $message[] = '¡el usuario ya existe!';
   }else{
      if($contrasena != $ccontrasena){
         $message[] = 'la contraseña no coincide';
      }else{
         mysqli_query($conn, "INSERT INTO `usuarios`(nombre, email, contrasena, tipo_usuario) VALUES('$nombre', '$email', '$ccontrasena', '$tipo_usuario')") or die('query failed');
         $message[] = 'registrado con éxito!';
         header('location:login.php');
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
   <title>Registro</title>

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
      <h3>Registrar</h3>
      <input type="text" name="nombre" placeholder="ingrese nombre" required class="box">
      <input type="email" name="email" placeholder="ingrese email" required class="box">
      <input type="password" name="password" placeholder="ingrese contraseña" required class="box">
      <input type="password" name="cpassword" placeholder="confirmar contraseña" required class="box">
      <select name="tipo_usuario" class="box">
         <option value="user">usuario</option>
         <option value="admin">admin</option>
      </select>
      <input type="submit" name="submit" value="Registrar" class="btn">
      <p>¿Ya tienes una cuenta? <a href="login.php">Ingresar</a></p>
   </form>

</div>

</body>
</html>