<?php
include("../template/header.php");
include("../admin/config/db.php");

$query = $conexion->prepare("SELECT * FROM cursos");
$query->execute();
$listCourses = $query->fetchAll(PDO::FETCH_ASSOC);


$query = $conexion->prepare("SELECT c.id, c.nombre AS nombre_categoria, COUNT(cu.id) AS cantidad_cursos FROM categorias_cursos c LEFT JOIN cursos cu ON c.id = cu.categoria_id GROUP BY c.id, c.nombre;");
$query->execute();
$listCategories = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="section">
  <div class="" style="min-height: calc(100vh - 64px);">

    <h3 class="text-3xl text-gray-900 font-bold dark:text-white mt-5 flex justify-center category__title">Categoría de cursos</h3>
    <div class="grid  md:grid-cols-3 gap-4 p-6 flex justify-center">

      <?php foreach ($listCategories as $category) { ?>
        <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 relative category__item1">
          <a href="#">
            <h5 class="mb-2 text-2xl font-medium tracking-tight text-gray-900 dark:text-white">
              <?php echo $category["nombre_categoria"]; ?>
            </h5>
          </a>
          <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
            <?php if ($category["cantidad_cursos"] == 0) { ?>
              sin cursos disponibles
            <?php  } else if ($category["cantidad_cursos"] == 1) { ?>
              1 curso disponible
            <?php  } else { ?>
              <?php echo $category["cantidad_cursos"] ?> cursos disponibles
            <?php  }  ?>
          </p>

          <a href="<?php echo $url; ?>/cursos/#<?php echo  str_replace(' ', '_', $category["nombre_categoria"]); ?>" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Ver cursos
            <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
            </svg>
          </a>
        </div>
      <?php } ?>

    </div>
  </div>



  <?php foreach ($listCategories as $category) { ?>

    <div class="w-full " id="<?php echo  str_replace(' ', '_', $category["nombre_categoria"]); ?>" style="min-height: calc(100vh - 64px);">
      <h3 class="text-2xl font-bold text-gray-900 dark:text-white m-4"><?= $category["nombre_categoria"]; ?></h3>

      <div class="grid justify-center sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
        <?php foreach ($listCourses as $course) { ?>

          <?php if ($category["id"] == $course["categoria_id"]) { ?>
            <div class="card__course max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
              <a href="#">
                <img class="rounded-t-lg" src="../img/cursos/<?= $course["imagen"] ?>" alt="<?= $course["nombre"] ?>" />
              </a>
              <div class="p-5 h-52">
                <a href="#">
                  <!-- j3su -->
                  <h5 class="mb-2 text-xl md:text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><?= $course["nombre"] ?></h5>
                </a>
                <p class="mb-3 font-normal text-sm text-gray-700 dark:text-gray-400 h-52 line-clamp-1" style="display: -webkit-box; -webkit-line-clamp: 5; -webkit-box-orient: vertical; overflow: hidden;text-overflow: ellipsis;"><?= $course["objetivo"] ?></p>

                <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 ">
                  Ver más
                  <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                  </svg>
                </a>
              </div>
            </div>
          <?php } ?>
        <?php } ?>
      </div>

    </div>

  <?php } ?>



</div>


<?php include("../template/footer.php"); ?>