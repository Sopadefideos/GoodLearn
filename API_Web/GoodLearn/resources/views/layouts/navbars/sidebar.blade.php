<div class="sidebar" data-color="azure" data-background-color="white">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="{{route('home')}}" class="simple-text logo-normal">
      <img src="/img/logoLong.jpeg" alt="" style="width: 100%">
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Panel de administración') }}</p>
        </a>
      </li>

      <li class="nav-item ">
        <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
          <i class="material-icons">admin_panel_settings</i>
          <p>Administracion
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse show" id="laravelExample" style="">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'usuario' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('usuarios') }}">
                <i class="material-icons">face</i>
                  <p>{{ __('Usuarios') }}</p>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'asignaturas' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('asignaturas') }}">
                <i class="material-icons">subject</i>
                  <p>{{ __('Asignaturas') }}</p>
              </a>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</div>
