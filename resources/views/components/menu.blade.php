

    <a href="index3.html" class="brand-link">

        <span class="brand-text font-weight-light"><b>AzulDash</b></span>
    </a>

    <div class="sidebar">

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('images/jennifer.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{userFullName()}}</a>
            </div>
        </div>

        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
           
          <li class="nav-item">
              <a href="{{ route('home') }}" class="nav-link {{ setMenuClass('home', 'active') }}">
                <i class="nav-icon fas fa-home"></i>
                <p>
                  Accueil
                </p>
              </a>
            </li>
        
          @can("manager")
          <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Tableau de bord
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-chart-line"></i>
                    <p>Vue globale</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-swatchbook"></i>
                    <p>Locations</p>
                  </a>
                </li>
              </ul>
          </li>
          @endcan
        
          @can("admin")
          <li class="nav-item {{ setMenuClass('admin.habilitations.', 'menu-open') }}">
              <a href="#" class="nav-link {{ setMenuClass('admin.habilitations.', 'active') }}">
                <i class=" nav-icon fas fa-user-shield"></i>
                <p>
                  Habilitations
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item ">
                  <a
                  href="{{ route('admin.habilitations.users.index') }}"
                  class="nav-link {{ setMenuClass('admin.habilitations.users.index', 'active') }}"
                  >
                    <i class=" nav-icon fas fa-users-cog"></i>
                    <p>Utilisateurs</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-fingerprint"></i>
                    <p>Roles et permissions</p>
                  </a>
                </li>
              </ul>
          </li>
        
          <li class="nav-item ">
              <a href="#" class="nav-link ">
                  <i class="nav-icon fas fa-cogs"></i>
                  <p>
                  Gestion articles
                  <i class="right fas fa-angle-left"></i>
                  </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href=""
                          class="nav-link">
                      <i class="nav-icon far fa-circle"></i>
                      <p>Type d'articles</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href=""
                          class="nav-link ">
                      <i class="nav-icon fas fa-list-ul"></i>
                      <p>Articles</p>
                      </a>
                  </li>
                  
              </ul>
          </li>
          @endcan
        
          @can("employe")
          <li class="nav-header">LOCATION</li>
          <li class="nav-item">
              <a href="" class="nav-link ">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                  Gestion des clients
                  </p>
              </a>
          </li>
          <li class="nav-item">
              <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-exchange-alt"></i>
                  <p>
                  Gestion des locations
                  </p>
              </a>
          </li>
        
          <li class="nav-header">CAISSE</li>
          <li class="nav-item">
              <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-coins"></i>
                  <p>
                  Gestion des paiements
                  </p>
              </a>
          </li>
          @endcan
        
          </ul>
        </nav>