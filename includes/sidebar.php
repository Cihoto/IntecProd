<div id="sidebar" class="active">
  <div class="sidebar-wrapper active">
    <div class="sidebar-header position-relative">
      <div class="d-flex justify-content-between align-items-center">
        <div class="logo col-7">
          <a href="index.php">
            <img src="./assets/images/logo/intech_horizontal.png" alt="Logo" srcset="" />
          </a>
        </div>

        <!-- iconos y barra cambio theme -->
        <!-- <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
          <svg class="iconify iconify--system-uicons" width="20" height="20">
            <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
              <g transform="translate(-210 -1)">
                <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                <circle cx="220.5" cy="11.5" r="4"></circle>
                <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
              </g>
            </g>
          </svg>
          <div class="form-check form-switch fs-6">
            <input class="form-check-input me-0" type="checkbox" id="toggle-dark" style="cursor: pointer" />
            <label class="form-check-label"></label>
          </div>
          <svg class="iconify iconify--mdi" width="20" height="20" viewBox="0 0 24 24">
            <path fill="currentColor" d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z"></path>
          </svg>
        </div> -->
        <!-- termino barra e iconos theme -->

        <div class="sidebar-toggler x">
          <a href="#" class="sidebar-hide d-xl-none d-block">
            <i class="bi bi-x bi-middle"></i>
          </a>
        </div>
      </div>
    </div>
    <div class="sidebar-menu">
      <ul class="menu" id="sidebarPr">
        <?php
        if ($active == 'dashboard') {
          echo '<li class="sidebar-item active">';
        } else {
          echo '<li class="sidebar-item">';
        }
        ?>
        <a href="index.php" class="sidebar-link sidebar-in">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
            <path d="M3 9.53369L12 2.53369L21 9.53369V20.5337C21 21.0641 20.7893 21.5728 20.4142 21.9479C20.0391 22.323 19.5304 22.5337 19 22.5337H5C4.46957 22.5337 3.96086 22.323 3.58579 21.9479C3.21071 21.5728 3 21.0641 3 20.5337V9.53369Z" stroke="#00B4B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M9 21.53V12.5337H15V22" stroke="#00B4B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          <!-- <span>Dashboard</span> -->
          <p class="sidebarTitle">Dashboard</p>
        </a>
        </li>


        <?php if (in_array("7", $rol_id) || in_array("8", $rol_id) || in_array("1", $rol_id) || in_array("2", $rol_id)) : ?>
          <?php
          if ($active == 'proximosEventos' || $active == 'crearEventos' || $active === "eventos") {
            echo '<li class="sidebar-item has-sub active">';
          } else {
            echo '<li class="sidebar-item has-sub">';
          }
          ?>
          <a href="#" class="sidebar-link sidebar-in">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
              <path d="M19 4.53369H5C3.89543 4.53369 3 5.42912 3 6.53369V20.5337C3 21.6383 3.89543 22.5337 5 22.5337H19C20.1046 22.5337 21 21.6383 21 20.5337V6.53369C21 5.42912 20.1046 4.53369 19 4.53369Z" stroke="#00B4B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M3 10.5337H21" stroke="#00B4B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M16 2.53369V6.53369" stroke="#00B4B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M8 2.53369V6.53369" stroke="#00B4B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <p class="sidebarTitle">Eventos</p>
          </a>
          <?php
          if ($active == 'proximosEventos' || $active == 'crearEventos' || $active === "eventos") {
            echo '<ul class="submenu active">';
          } else {
            echo '<ul class="submenu">';
          }
          ?>

          <?php if (in_array("7", $rol_id) || in_array("1", $rol_id) || in_array("2", $rol_id)) : ?>
            <li class="submenu-item">
              <a href="miEvento.php">Crear Evento</a>
            </li>
          <?php endif; ?>
          <li class="submenu-item">
            <a href="../eventos.php">Lista de Eventos</a>
          </li>
          <!-- <li class="submenu-item">
              <a href="" >Mis eventos</a>
            </li> -->
      </ul>
      </li>
    <?php endif; ?>

    <?php if (in_array("5", $rol_id) || in_array("1", $rol_id) || in_array("2", $rol_id)) : ?>

      <?php
      if ($active == 'inventario' || $active == 'inv2') {
        echo '<li class="sidebar-item has-sub active">';
      } else {
        echo '<li class="sidebar-item has-sub">';
      }
      ?>
      <a href="inventario.php" class="sidebar-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
          <path d="M21 8.53369V21.5337H3V8.53369" stroke="#00B4B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M10 12.5337H14" stroke="#00B4B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M23 3.53369H1V8.53369H23V3.53369Z" stroke="#00B4B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <!-- <span>Inventario</span> -->
        <p class="sidebarTitle">Inventario</p>
      </a>
      <ul class="submenu">
        <!-- <li class="submenu-item">
                <a href="inventario.php">Actual</a>
              </li> -->
        <li class="submenu-item">
          <a href="inventario.php">Disponible</a>
        </li>
        <!-- < -->
        <!-- php if (in_array("7", $rol_id) || in_array("1", $rol_id) || in_array("2", $rol_id)) : ?> -->
        <!-- <li class="submenu-item">
                <a href="projectPackages.php">Crear paquetes de recursos</a>
              </li> -->
        <!-- < -->
        <!-- php endif; ?> -->
        <li class="submenu-item">
          <a href="#">Por reparar</a>
        </li>
        <li class="submenu-item">
          <a href="#">En reparación</a>
        </li>
      </ul>
      <!-- </li> -->
    <?php endif; ?>

    <?php if (in_array("12", $rol_id) || in_array("1", $rol_id) || in_array("2", $rol_id)) : ?>
      <?php
      if ($active == 'personal' || $active == 'personal2') {
        echo '<li class="sidebar-item active">';
      } else {
        echo '<li class="sidebar-item">';
      }
      ?>
      <a href="personal.php" class="sidebar-link sidebar-in">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
          <path d="M23 21.5336V19.5336C22.9993 18.6473 22.7044 17.7863 22.1614 17.0859C21.6184 16.3854 20.8581 15.8851 20 15.6636" stroke="#00B4B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M17 21.5337V19.5337C17 18.4728 16.5786 17.4554 15.8284 16.7053C15.0783 15.9551 14.0609 15.5337 13 15.5337H5C3.93913 15.5337 2.92172 15.9551 2.17157 16.7053C1.42143 17.4554 1 18.4728 1 19.5337V21.5337" stroke="#00B4B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M16 3.66357C16.8604 3.88388 17.623 4.38428 18.1676 5.08588C18.7122 5.78749 19.0078 6.6504 19.0078 7.53857C19.0078 8.42674 18.7122 9.28965 18.1676 9.99126C17.623 10.6929 16.8604 11.1933 16 11.4136" stroke="#00B4B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M9 11.5337C11.2091 11.5337 13 9.74283 13 7.53369C13 5.32455 11.2091 3.53369 9 3.53369C6.79086 3.53369 5 5.32455 5 7.53369C5 9.74283 6.79086 11.5337 9 11.5337Z" stroke="#00B4B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <p class="sidebarTitle">Personal</p>
      </a>
      </li>
    <?php endif; ?>

    <?php if (in_array("14", $rol_id) || in_array("1", $rol_id) || in_array("2", $rol_id)) : ?>
      <?php
      if ($active == 'vehiculos') {
        echo '<li class="sidebar-item active">';
      } else {
        echo '<li class="sidebar-item">';
      }
      ?>
      <a href="vehiculos.php" class="sidebar-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
          <path d="M18.5 21.5337C19.8807 21.5337 21 20.4144 21 19.0337C21 17.653 19.8807 16.5337 18.5 16.5337C17.1193 16.5337 16 17.653 16 19.0337C16 20.4144 17.1193 21.5337 18.5 21.5337Z" stroke="#00B4B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M5.5 21.5337C6.88071 21.5337 8 20.4144 8 19.0337C8 17.653 6.88071 16.5337 5.5 16.5337C4.11929 16.5337 3 17.653 3 19.0337C3 20.4144 4.11929 21.5337 5.5 21.5337Z" stroke="#00B4B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M16 8.53369H20L23 11.5337V16.5337H16V8.53369Z" stroke="#00B4B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M16 3.53369H1V16.5337H16V3.53369Z" stroke="#00B4B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <p class="sidebarTitle">Vehículos</p>
      </a>
      </li>
    <?php endif; ?>


    <?php if (in_array("10", $rol_id) || in_array("1", $rol_id)) : ?>
      <?php
      if ($active == 'clientes') {
        echo '<li class="sidebar-item active">';
      } else {
        echo '<li class="sidebar-item">';
      }
      ?>
      <a href="/clientes.php" class="sidebar-link sidebar-in">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
          <g clip-path="url(#clip0_857_469)">
            <path d="M12 15.5337C15.866 15.5337 19 12.3997 19 8.53369C19 4.6677 15.866 1.53369 12 1.53369C8.13401 1.53369 5 4.6677 5 8.53369C5 12.3997 8.13401 15.5337 12 15.5337Z" stroke="#00B4B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M8.21 16.236L6 23.5336L12 20.5336L17 23.5336L15.79 16.4136" stroke="#00B4B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </g>
          <defs>
            <!-- <clipPath id="clip0_857_469">
                <rect width="24" height="24" fill="white" transform="translate(0 0.533691)"/>
              </clipPath> -->
          </defs>
        </svg>
        <!-- <span>Clientes</span> -->
        <p class="sidebarTitle">Clientes</p>

      </a>
      </li>
    <?php endif; ?>

    <?php
    // if ($active == '1' || $active == '2') {
    //   echo '<li class="sidebar-item has-sub active">';
    // } else {
    //   echo '<li class="sidebar-item has-sub">';
    // }
    ?>
    <!-- <a href="#" class="sidebar-link">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Layouts</span>
          </a>
          <ul class="submenu">
            <li class="submenu-item">
              <a href="layout-default.html">Default Layout</a>
            </li>
            <li class="submenu-item">
              <a href="layout-vertical-1-column.html">1 Column</a>
            </li>
          </ul>
        </li> -->

    <?php if (in_array("1", $rol_id) || in_array("2", $rol_id)) : ?>
      <?php
      if ($active == 'administracion') {
        echo '<li class="sidebar-item active">';
      } else {
        echo '<li class="sidebar-item">';
      }
      ?>
      <a href="/administracion.php" class="sidebar-link sidebar-in">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
          <path d="M2 17.5337L12 22.5337L22 17.5337" stroke="#00B4B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M2 12.5337L12 17.5337L22 12.5337" stroke="#00B4B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M12 2.53369L2 7.53369L12 12.5337L22 7.53369L12 2.53369Z" stroke="#00B4B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <p class="sidebarTitle">Administración</p>
      </a>
      </li>
    <?php endif; ?>

    <!-- < if (in_array("1", $rol_id) || in_array("2", $rol_id)) : ?> -->
    <?php
    if ($active == 'finance') {
      echo '<li class="sidebar-item active">';
    } else {
      echo '<li class="sidebar-item">';
    }
    ?>
    <a href="./finances.php" class="sidebar-link sidebar-in">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
        <g clip-path="url(#clip0_1957_52303)">
          <path d="M12 1.61328V23.6133" stroke="#00B4B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M17 5.61328H9.5C8.57174 5.61328 7.6815 5.98203 7.02513 6.63841C6.36875 7.29479 6 8.18502 6 9.11328C6 10.0415 
          6.36875 10.9318 7.02513 11.5882C7.6815 12.2445 8.57174 12.6133 9.5 12.6133H14.5C15.4283 12.6133 16.3185 
          12.982 16.9749 13.6384C17.6313 14.2948 18 15.185 18 16.1133C18 17.0415 17.6313 17.9318 16.9749 18.5882C16.3185 
          19.2445 15.4283 19.6133 14.5 19.6133H6" stroke="#00B4B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </g>
        <defs>
          <clipPath id="clip0_1957_52303">
            <rect width="24" height="24" fill="white" transform="translate(0 0.613281)" />
          </clipPath>
        </defs>
      </svg>
      <p class="sidebarTitle">Finanzas</p>
    </a>
    </li>
    <!-- < endif; ?> -->


    <?php if ($empresaId === "2" || $empresaId === "10") : ?>
      <?php

      if ($active == 'pruebas') {
        echo '<li class="sidebar-item active">';
      } else {
        echo '<li class="sidebar-item">';
      }
      ?>
      <a href="/login.php" class="sidebar-link">
        <i class="fa-solid fa-infinity"></i>
        <!-- <i class="bi bi-person-check"></i> -->
        <span>Pruebas</span>
      </a>
      </li>
      <?php

      if ($active == 'pruebas2') {
        echo '<li class="sidebar-item active">';
      } else {
        echo '<li class="sidebar-item">';
      }
      ?>
      <a href="/test2.php" class="sidebar-link">
        <i class="fa-solid fa-infinity"></i>
        <!-- <i class="bi bi-person-check"></i> -->
        <span>Pruebas 2</span>
      </a>
      </li>

      <?php

      if ($active == 'pruebas3') {
        echo '<li class="sidebar-item active">';
      } else {
        echo '<li class="sidebar-item">';
      }
      ?>
      <a href="/test3.php" class="sidebar-link">
        <i class="fa-solid fa-infinity"></i>
        <!-- <i class="bi bi-person-check"></i> -->
        <span>Pruebas 3</span>
      </a>
      </li>


    <?php endif; ?>

    </ul>
    </div>
    <div class="LogOut">
      <button class="closeSessionBtn" onclick="closeSession()">
        <p style="color: #ca2b2b;font-size: 25px;"><i class="fa-solid fa-power-off"></i> Cerrar Sesión</p>
      </button>
    </div>
  </div>
</div>


<script>
  function closeSession() {
    $.ajax({
      type: "POST",
      url: "ws/Sesion/sesion.php",
      data: JSON.stringify({
        action: 'CloseSession'
      }),
      dataType: 'json',
      success: async function(response) {
        // console.log("RESPONSE DE SESSION",response);
        if (response) {
          location.reload();
        }
      }
    })
  }
</script>