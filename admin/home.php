
<?php
  include("template/header.php"); 

  if (isset($_SESSION["logged"])) {
    echo '<script>window.location.replace("index.php");</script>';
    exit();
  }

$txtId = (isset($_POST["txtId"])) ? $_POST["txtId"] : "";
$txtNombre = (isset($_POST["txtNombre"])) ? $_POST["txtNombre"] : "";
$txtImagen = (isset($_FILES["txtImagen"]["name"])) ? $_FILES["txtImagen"]["name"] : "";
$txtObjetivo = (isset($_POST["txtObjetivo"])) ? $_POST["txtObjetivo"] : "";
$txtCategory = (isset($_POST["txtCategory"])) ? $_POST["txtCategory"] : "";
$accion = (isset($_POST["accion"])) ? $_POST["accion"] : "";

include("./config/db.php");


switch ($accion) {

  case "agregar":
    $query = $conexion->prepare("INSERT INTO cursos (nombre, imagen, objetivo, categoria_id) VALUES (:nombre, :imagen, :objetivo, :category);");
    $query->bindParam(":nombre", $txtNombre);
    $query->bindParam(":objetivo", $txtObjetivo);
    $query->bindParam(":category", $txtCategory);

    $fecha = new DateTime();
    $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "_" . $_FILES["txtImagen"]["name"] : "imagen.jpg";

    $tmpImagen = $_FILES["txtImagen"]["tmp_name"];
    if ($tmpImagen != "") {
      move_uploaded_file($tmpImagen, "../img/cursos/" . $nombreArchivo);
    }
    $query->bindParam(":imagen", $nombreArchivo);
    $query->execute();

    $txtId = "";
    $txtNombre =  "";
    $txtImagen =  "";
    $txtObjetivo = "";
    $txtCategory = "";
    break;


  case "modificar":
    $query = $conexion->prepare("UPDATE cursos SET nombre=:nombre WHERE id=:id");
    $query->bindParam(":nombre", $txtNombre);
    $query->bindParam(":id", $txtId);
    $query->execute();

    if ($txtImagen != "") {

      $fecha = new DateTime();
      $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "_" . $_FILES["txtImagen"]["name"] : "imagen.jpg";

      $tmpImagen = $_FILES["txtImagen"]["tmp_name"];
      move_uploaded_file($tmpImagen, "../img/cursos/" . $nombreArchivo);


      $query = $conexion->prepare("UPDATE cursos SET imagen=:imagen WHERE id=:id");
      $query->bindParam(":imagen", $nombreArchivo);
      $query->bindParam(":id", $txtId);
      $query->execute();
    }

    $query = $conexion->prepare("UPDATE cursos SET objetivo=:objetivo WHERE id=:id");
    $query->bindParam(":objetivo", $txtObjetivo);
    $query->bindParam(":id", $txtId);
    $query->execute();

    $query = $conexion->prepare("UPDATE cursos SET categoria_id=:category WHERE id=:id");
    $query->bindParam(":category", $txtCategory);
    $query->bindParam(":id", $txtId);
    $query->execute();


    $txtId = "";
    $txtNombre =  "";
    $txtImagen =  "";
    $txtObjetivo = "";
    $txtCategory = "";

    break;


  case "cancelar":
    $txtId = "";
    $txtNombre =  "";
    $txtImagen =  "";
    $txtObjetivo = "";
    $txtCategory = "";
    break;

  case "seleccionar":
    $query = $conexion->prepare("SELECT * FROM cursos WHERE id=:id");
    $query->bindParam(":id", $txtId);
    $query->execute();
    $lib = $query->fetch(PDO::FETCH_LAZY);
    $txtNombre = $lib["nombre"];
    $txtImagen = $lib["imagen"];
    $txtObjetivo = $lib["objetivo"];
    $txtCategory = $lib["categoria_id"];
    break;


  case "borrar":
    $query = $conexion->prepare("SELECT imagen FROM cursos WHERE id=:id");
    $query->bindParam(":id", $txtId);
    $query->execute();
    $curso = $query->fetch(PDO::FETCH_LAZY);

    if (isset($curso["imagen"]) && ($curso["imagen"] != "imagen.jpg")) {
      if (file_exists("../img/cursos/" . $curso["imagen"])) {
        unlink("../img/cursos/" . $curso["imagen"]);
      }
    }

    $query = $conexion->prepare("DELETE FROM cursos WHERE id=:id");
    $query->bindParam(":id", $txtId);
    $query->execute();
    break;
}

$query = $conexion->prepare("SELECT * FROM cursos");
$query->execute();
$listCourse = $query->fetchAll(PDO::FETCH_ASSOC);


$query = $conexion->prepare("SELECT * FROM categorias_cursos");
$query->execute();
$listCategories = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="section">
  <div class="flex gap-4 items-start">
    <form class="space-y-6 col-auto flex flex-col" method="post" enctype="multipart/form-data" style="max-width: 700px;">
      <h5 class="text-xl font-medium text-gray-900 dark:text-white">Añadir un curso</h5>
      <div class="hidden">
        <label for="txtId" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ID</label>
        <input readonly type="text" name="txtId" id="txtId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" value="<?php echo $txtId; ?>" required>
      </div>
      <div>
        <label for="txtNombre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
        <input type="text" name="txtNombre" id="txtNombre" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" value="<?php echo $txtNombre; ?>" placeholder="escribe el nombre" required>
      </div>

      <div>
        <label for="txtImagen" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Imagen</label>
        <?php if ($txtImagen != "") { ?>
          <img src="../img/cursos/<?php echo $txtImagen ?>" class="self-center" width="80" alt="">
        <?php } ?>
        <input type="file" name="txtImagen" id="txtImagen" placeholder="selecciona una imagen del equipo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
      </div>

      <div>
        <label for="txtObjetivo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Objetivo</label>
        <textarea name="txtObjetivo" id="txtObjetivo" placeholder="Escribe el objetivo" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required ><?php echo $txtObjetivo; ?></textarea>
      </div>
      <div>
      <label for="txtCategory" class="block mb-2 text-sm font-medium text-2xl text-gray-900 dark:text-white">Categoria</label>
        <select id="txtCategory" name="txtCategory" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required >
          <option disabled selected>Elije una categoria</option>
          <?php foreach ($listCategories as $category) { ?>
            <?php if($txtCategory == $category["id"]) { ?>
              <option <?php echo $category["id"] ?> selected value="<?php echo $category["id"] ?>"><?= $category["nombre"] ?></option>
            <?php } else { ?>
              <option value="<?php echo $category["id"] ?>"><?php echo $category["nombre"] ?></option>
            <?php }  ?>
          <?php } ?>
         
        </select>
      </div>



      <div class="flex gap-2">
      <?php if($txtId == "") { ?>
        <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 disabled:bg-gray-400" name="accion" <?php echo ($accion == "seleccionar") ? "disabled" : "" ?> value="agregar">Guardar</button>
        <?php } else { ?>
          
          <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 disabled:opacity-75 disabled:bg-gray-300" name="accion" value="modificar" <?php echo ($accion != "seleccionar") ? "disabled" : "" ?>>Actualizar</button>
          <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 disabled:bg-gray-400" name="accion" value="cancelar" <?php echo ($accion != "seleccionar") ? "disabled" : "" ?>>Cancelar</button>
          <?php } ?>
      </div>

    </form>

    <div class="relative col overflow-x-auto shadow-md sm:rounded-lg">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col" class="px-6 py-3">
              ID
            </th>
            <th scope="col" class="px-6 py-3">
              Nombre
            </th>
            <th scope="col" class="px-6 py-3">
              Imagen
            </th>
            <th scope="col" class="px-6 py-3">
              Objetivo
            </th>
            <th scope="col" class="px-6 py-3">
              Acciones
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($listCourse as $curso) { ?>
            <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">

              <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                <?php echo $curso["id"]; ?>
              </th>
              <td class="px-6 py-4">
                <?php echo $curso["nombre"]; ?>
              </td>
              <td class="px-6 py-4">
                <img src="../img/cursos/<?php echo $curso["imagen"] ?>" width="100" alt="">
              </td>
              <td class="px-6 py-4 w-24 overflow-hidden" style="white-space: nowrap; overflow : hidden;text-overflow: ellipsis !important; max-width: 60px !important;">
                <?php echo $curso["objetivo"]; ?>
              </td>
              <td class="px-6 py-4">
                <form method="post" class="flex">
                  <input type="hidden" name="txtId" id="txtId" value="<?php echo $curso["id"] ?>">
                  <button type="submit" name="accion" value="seleccionar" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-1.5 text-center mr-1 mb-1 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">
                  <i class="ri-pencil-fill"></i>
                  </button>
                  <button type="submit" name="accion" value="borrar" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-2 py-1.5 text-center mr-2  dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                  <i class="ri-delete-bin-7-fill"></i>
                  </button>
                </form>
              </td>
            </tr>
          <?php } ?>

        </tbody>
      </table>
    </div>
  </div>
  <!-- by j3su -->
</div>


<?php include("template/footer.php"); ?>