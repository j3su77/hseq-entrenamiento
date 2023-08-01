
<?php 
 $url = "http://".$_SERVER["HTTP_HOST"]."/hseq-entrenamiento";
?>



<footer class="bg-white dark:bg-gray-900">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="md:flex md:justify-between">
          <div class="mb-6 md:mb-0 mr-4">
            <a href="<?php echo $url; ?>/" class="flex flex-col items-start leading-none">
              <span class="font-normal leading-none p-0 text-xl whitespace-nowrap text-red-700">HSEQ</span>
               <span class=" font-normal leading-none p-0 text-xl whitespace-nowrap dark:text-white">Entrenamiento</span>
            </a>
         
          </div>
          
         
        
          <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3 ml-4">
              <!-- ================================== -->

              <div>
                  <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Enlace rápido</h2>
                  <ul class="text-gray-500 dark:text-gray-400 font-medium">
                      <li class="mb-2">
                          <a href="#" class="hover:underline">Sobre nosotros</a>
                      </li>
                      <li class="mb-2">
                          <a href="#" class="hover:underline">Nuestra historia</a>
                      </li>
                      <li class="mb-2">
                          <a href="#" class="hover:underline">Certificados</a>
                      </li>
                      <li class="mb-2">
                          <a href="#" class="hover:underline">Blog</a>
                      </li>
                      <li class="mb-2">
                          <a href="#" class="hover:underline">Trabaja con nosotros</a>
                      </li>
                  </ul>
              </div>
              <!-- ================================== -->
              <div>
                  <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Líneas de negocio</h2>
                  <ul class="text-gray-500 dark:text-gray-400 font-medium">
                      <li class="mb-2">
                          <a href="#" class="hover:underline ">HSEQ Entrenamiento</a>
                      </li>
                      <li class="mb-2">
                          <a href="#" class="hover:underline ">HSEQ Consultorías</a>
                      </li>
                      <li class="mb-2">
                          <a href="#" class="hover:underline ">HSEQ Seguros</a>
                      </li>
                      <li class="mb-2">
                          <a href="#" class="hover:underline ">HSEQ Salud IPS</a>
                      </li>
                      <li class="mb-2">
                          <a href="#" class="hover:underline ">HSEQ Suministros</a>
                      </li>
                      
                  </ul>
              </div>
              <!-- ================================== -->
              <div>
                  <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Contacto</h2>
                  <ul class="text-gray-500 dark:text-gray-400 font-medium">
                      <li class="mb-4">
                          <a href="#" class="">Calle 30 Nº 10-230 Local 1 y Bodega interna 33. Oficinas administrativas y centro de entrenamiento.</a>
                      </li>
                      <li class="mb-2">
                          <a href="#" class="">+57 3145468721</a>
                      </li>
                      <li class="mb-2">
                          <a href="#" class="">info@grupohseq.com</a>
                      </li>
                  </ul>
              </div>
          </div>
      </div>
      <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
      <div class="sm:flex sm:items-center sm:justify-between">
          <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2023 <a href="#" class="hover:underline">HSEQ</a>. Todos los derechos reservados.
          </span>
         
          <div>
          <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">j3su</span>
          </div>
      </div>
    </div>
</footer>






<script>
    // On page load or when changing themes, best to add inline in `head` to avoid FOUC
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark')
    }
</script>


<script src="<?php echo $url; ?>/js/scrollreveal.min.js"></script>
<script src="<?php echo $url; ?>/js/flowbite.min.js"></script>
<script src="<?php echo $url; ?>/js/main.js"></script>
</body>

</html>