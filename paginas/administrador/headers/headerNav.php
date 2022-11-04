<?php
session_start();

if (!isset($_SESSION['usuario'])) {
  header("Location: /paginas/sesion/login.php");
  return;
}

if ($_SESSION['usuario']['id_rol'] > 2) {
  header("Location: /paginas/usuario/principal.php");
  return;
}

?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="/paginas/administrador/principal.php">Inicio</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mr-auto">


        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Escanear</a>
          <div class="dropdown-menu">
            <a href="/paginas/administrador/formcompraventa.php" class="dropdown-item">Compraventa</a>
            <a href="/paginas/administrador/formdeclaracion.php" class="dropdown-item">Declaración jurada</a>
            <a href="/paginas/administrador/formherencia.php" class="dropdown-item">Cesion de Derechos Hereditarios</a>
            <a href="/paginas/administrador/formdonacion.php" class="dropdown-item">Donacion Entre Vivos</a>
        </li>

        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Documentos</a>
          <div class="dropdown-menu">
            <a href="#" class="dropdown-item">Compraventa</a>
            <a href="#" class="dropdown-item">Declaración jurada</a>
            <a href="#" class="dropdown-item">Cesion de Derechos Hereditarios</a>
            <a href="#" class="dropdown-item">Donacion Entre Vivos</a>
            <div class="dropdown-divider"></div>
            <a href="/paginas/administrador/listardocumentos.php" class="dropdown-item">Todos los documentos</a>
          </div>
        </li>


        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Usuarios</a>
          <div class="dropdown-menu">
            <a href="/paginas/administrador/formcrearusuario.php" class="dropdown-item">Crear</a>
            <div class="dropdown-divider"></div>
            <a href="/paginas/administrador/listarusuarios.php" class="dropdown-item">Listar</a>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="/paginas/administrador/listarpeticiones.php">Peticiones</a>
        </li>


      </ul>
    </div>
  </div>

  <div class="d-flex">
    <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
      <ul class="navbar-nav">

        <li class="nav-item dropdown col-6 col-md-auto">

          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person">
              <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
              </svg>
            </i>
            <?php echo $_SESSION['usuario']['nombre_usuario']; ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <!-- <li><a class="dropdown-item" href="#">Perfil</a></li>
            <li><a class="dropdown-item" href="#">Configuracion</a></li> -->
            <!-- <li>
              <hr class="dropdown-divider">
            </li> -->
            <li><a class="dropdown-item" href="#" onclick="cerrarSesion()">Cerrar Sesión</a></li>
          </ul>

        </li>

      </ul>
    </div>
  </div>

</nav>

<script>
  function cerrarSesion() {

    Swal.fire({
      title: 'Cerrando sesion',
      timerProgressBar: true,
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading()
      },
    });

    const usuario = {
      idUsuario: '<?php echo $_SESSION['usuario']['id_usuario']; ?>',
      funcion: 'logout'
    };

    $.ajax({
      type: "POST",
      url: '/funcionesphp/sesion.php',
      data: usuario,
      success: function(response) {
        console.log(response);

        if (response.mensaje === "Sesion cerrada") {

          setTimeout(() => {
            Swal.fire({
              icon: 'success',
              title: 'Sesion cerrada',
              showConfirmButton: false
            });
          }, 1200);

          setTimeout(() => {
            window.location.href = "/paginas/sesion/login.php";
          }, 2500);

        }


      },
      error: function(xhr, status) {
        console.log('HUBO UN ERROR');
        console.log(xhr, status);
        Swal.fire({
          icon: 'error',
          title: 'Error en el servidor',
          showConfirmButton: false,
          showCloseButton: true,
        });
      }
    });

  }
</script>