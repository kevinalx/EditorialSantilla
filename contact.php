<?php

include 'config.php';

session_start();

$usuario_id = $_SESSION['usuario_id'];

if(!isset($usuario_id)){
   header('location:login.php');
}

if(isset($_POST['enviar'])){

   $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $numero = $_POST['numero'];
   $msg = mysqli_real_escape_string($conn, $_POST['mensaje']);

   $seleccionar_mensaje = mysqli_query($conn, "SELECT * FROM `mensajes` WHERE nombre = '$nombre' AND email = '$email' AND numero = '$numero' AND mensaje = '$msg'") or die('query failed');

   if(mysqli_num_rows($seleccionar_mensaje) > 0){
      $message[] = '¡mensaje enviado ya!';
   }else{
      mysqli_query($conn, "INSERT INTO `mensajes`(usuario_id, nombre, email, numero, mensaje) VALUES('$usuario_id', '$nombre', '$email', '$numero', '$msg')") or die('query failed');
      $message[] = '¡mensaje enviado con éxito!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contacto</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/estilos.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>contacto con nosotros</h3>
   <p> <a href="home.php">inicio</a> / contacto </p>
</div>

<section class="contact">

   <form action="" method="post">
      <h3>¡Di algo!</h3>
      <input type="text" name="nombre" required placeholder="introduzca su nombre" class="box">
      <input type="email" name="email" required placeholder="introduzca su email" class="box">
      <input type="number" name="numero" required placeholder="introduzca su numero" class="box">
      <textarea name="mensaje" class="box" placeholder="introduzca su mensaje" id="" cols="30" rows="10"></textarea>
      <input type="submit" value="enviar mensaje" name="enviar" class="btn">
   </form>

</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>