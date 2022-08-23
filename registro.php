<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

    <link rel="stylesheet" href="css/estilos.css">

</head>
<body>
    <div class="form-register">
    <form action="" method="post">
      <h3>register now</h3>
      <input type="text" name="name" placeholder="ingrese su nombre" required class="box">
      <input type="email" name="email" placeholder="ingrese su email" required class="box">
      <input type="password" name="password" placeholder="ingrese su contraseña" required class="box">
      <input type="password" name="cpassword" placeholder="confirme su contraseña" required class="box">
      <select name="user_type" class="box">
         <option value="user">usuario</option>
         <option value="admin">admin</option>
      </select>
      <input type="submit" name="submit" value="register now" class="btn">
      <p> ¿tienes una cuenta? <a href="login.php">Ingresa ahora</a></p>
   </form>
    </div> 
</body>
</html>