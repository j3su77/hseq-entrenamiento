<?php

include("./admin/config/db.php");
$url = "http://" . $_SERVER["HTTP_HOST"] . "/hseq-entrenamiento";

$query = $conexion->prepare("SELECT c.id, c.nombre AS nombre_categoria, COUNT(cu.id) AS cantidad_cursos FROM categorias_cursos c LEFT JOIN cursos cu ON c.id = cu.categoria_id GROUP BY c.id, c.nombre;");
$query->execute();
$listCategories = $query->fetchAll(PDO::FETCH_ASSOC);

?>



<div class="p-2 h-screen section container dark:bg-gray-900 mt-5 mb-5  ">

  <h3 class="text-3xl font-bold text-gray-900 dark:text-white flex justify-center category__title">Categoría de cursos</h3>
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

        <a href="<?php echo $url; ?>/cursos/#<?php echo  str_replace(' ', '_',$category["nombre_categoria"]) ; ?>" class=" inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
          Ver cursos
          <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
          </svg>
        </a>
      </div>
    <?php } ?>

  </div>

</div>