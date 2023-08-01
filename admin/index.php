<?php
session_start();

include("../admin/config/db.php");


if ($_POST) {
 
  $user = $_POST["user"];
  $password = $_POST["password"];

  
  $query = $conexion->prepare("SELECT * FROM usuarios WHERE usuario = :user");
  $query->bindParam(":user", $user);
  $query->execute();
  $usuario = $query->fetch(PDO::FETCH_ASSOC);

 
  if ($usuario && ($password == $usuario["contrasena"])) {
    $_SESSION["logged"] = "ok";
    $_SESSION["username"] = $usuario["usuario"];
    header("Location: home.php");
    exit();
  } else {
    $mensaje = "Usuario y/o contraseña son incorrectos";
  }
}

?>

<?php include("template/header.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  .
  <title>Administracion</title>
</head>

<body>

  <div class="container">
    <div class="row d-flex justify-content-center pt-5">
      <div class="col-md-4">
        <div class="card mt-5">
          <div class="card-header">
          </div>
          <div class="card-body flex justify-center">

            <div class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">


              <form class="space-y-6" action="index.php" method="post" enctype=multipart/form-data>
                <h5 class="text-xl font-medium text-gray-900 dark:text-white">Iniciar Sesión</h5>
                <div>
                  <label for="user" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Usuario</label>
                  <input type="text" name="user" id="user" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="escribe tu usuario" required>
                </div>
                <div>
                  <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contraseña</label>
                  <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                </div>

                <?php if (isset($mensaje)) { ?>
                  <div class="alert alert-danger text-red-500" role="alert">
                    <strong>Error</strong> <?php echo $mensaje; ?>
                  </div>
                <?php } ?>

                <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Entrar</button>

              </form>
            </div>

          </div>

        </div>
      </div>

    </div>
  </div>

</body>

</html>


<?php include("template/footer.php"); ?>