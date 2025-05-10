<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
  <div class="sidebar-logo">
    <div class="logo-header" data-background-color="dark">
      <a href="<?= $base_url ?>/home" class="logo">
        <img src="<?= $base_url ?>/assets/img/logo.jpg" alt="navbar brand" class="navbar-brand" width="100" height="60" />
      </a>
      <div class="nav-toggle">
        <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
        <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
      </div>
      <button class="topbar-toggler more"><i class="gg-more-vertical-alt"></i></button>
    </div>
  </div>
  <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
      <ul class="nav nav-secondary">
        <li class="nav-item active">
          <a href="<?= $base_url ?>/home"><i class="fas fa-home"></i>
            <p>Accueil</p>
          </a>
        </li>
        <li class="nav-section">
          <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
          <h4 class="text-section">Menu</h4>
        </li>

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="<?= $base_url ?>/#exo"><i class="fas fa-cog"></i>
            <p>Exercices</p><span class="caret"></span>
          </a>
          <div class="collapse" id="exo">
            <ul class="nav nav-collapse">
              <li><a href="<?= $base_url ?>/#"><span class="sub-item">Insertion</span></a></li>
              <li><a href="<?= $base_url ?>/#"><span class="sub-item">Liste</span></a></li>
              <li><a href="<?= $base_url ?>/#"><span class="sub-item">Import</span></a></li>

            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="<?= $base_url ?>/#dept"><i class="fas fa-laptop"></i>
            <p>Departements</p><span class="caret"></span>
          </a>
          <div class="collapse" id="dept">
            <ul class="nav nav-collapse">
              <li><a href="<?= $base_url ?>/#"><span class="sub-item">Insertion</span></a></li>
              <li><a href="<?= $base_url ?>/#"><span class="sub-item">Liste</span></a></li>
              <li><a href="<?= $base_url ?>/#"><span class="sub-item">Import</span></a></li>

            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="<?= $base_url ?>/#transactions"><i class="fas fa-retweet"></i>
            <p>Transactions</p><span class="caret"></span>
          </a>
          <div class="collapse" id="transactions">
            <ul class="nav nav-collapse">
              <li><a href="<?= $base_url ?>/#"><span class="sub-item">Insertion</span></a></li>
              <li><a href="<?= $base_url ?>/#"><span class="sub-item">Liste</span></a></li>
              <li><a href="<?= $base_url ?>/#"><span class="sub-item">Validation</span></a></li>
              <li><a href="<?= $base_url ?>/#"><span class="sub-item">Import</span></a></li>
              <li><a href="<?= $base_url ?>/#"><span class="sub-item">Export</span></a></li>
            </ul>
          </div>
        </li>


        <li class="nav-item">
          <a data-bs-toggle="collapse" href="<?= $base_url ?>/#gestion"><i class="fas fa-file-invoice-dollar"></i>
            <p>Budget Elements</p><span class="caret"></span>
          </a>
          <div class="collapse" id="gestion">
            <ul class="nav nav-collapse">
              <li><a href="<?= $base_url ?>/"><span class="sub-item">Insertion</span></a></li>
              <li><a href="<?= $base_url ?>/"><span class="sub-item">Liste</span></a></li>
              <li><a href="<?= $base_url ?>/#"><span class="sub-item">Import</span></a></li>
              <li><a href="<?= $base_url ?>/#"><span class="sub-item">Export</span></a></li>
            </ul>
          </div>
        </li>


        <li class="nav-item submenu">
          <a data-bs-toggle="collapse" href="<?= $base_url ?>/#crm" class="" aria-expanded="true">
            <i class="fas fa-hands-helping"></i>
            <p>CRM</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="crm">
            <ul class="nav nav-collapse">
              <li class="submenu">
                <a data-bs-toggle="collapse" href="<?= $base_url ?>/#subnav1" class="collapsed" aria-expanded="false">
                  <span class="sub-item">Actions</span>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="subnav1">
                  <ul class="nav nav-collapse subnav">
                    <li>
                      <a href="<?= $base_url ?>/crm/action/insert">
                        <span class="sub-item">Insertion</span>
                      </a>
                    </li>
                    <li>
                      <a href="<?= $base_url ?>/#">
                        <span class="sub-item">Liste</span>
                      </a>
                    </li>
                    <li>
                      <a href="<?= $base_url ?>/#">
                        <span class="sub-item">Import</span>
                      </a>
                    </li>
                    <li>
                      <a href="<?= $base_url ?>/#">
                        <span class="sub-item">Export</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li>
                <a data-bs-toggle="collapse" href="<?= $base_url ?>/#type_act">
                  <span class="sub-item">Type D'Action</span>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="type_act">
                  <ul class="nav nav-collapse subnav">
                    <li>
                      <a href="<?= $base_url ?>/crm/type_action/insert">
                        <span class="sub-item">Insertion</span>
                      </a>
                    </li>
                    <li>
                      <a href="<?= $base_url ?>/crm/type_action/liste">
                        <span class="sub-item">Liste</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li>
                <a data-bs-toggle="collapse" href="<?= $base_url ?>/#subnav2">
                  <span class="sub-item">Reactions</span>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="subnav2">
                  <ul class="nav nav-collapse subnav">
                    <li>
                      <a href="<?= $base_url ?>/crm/reaction/insert">
                        <span class="sub-item">Insertion</span>
                      </a>
                    </li>
                    <li>
                      <a href="<?= $base_url ?>/#">
                        <span class="sub-item">Liste</span>
                      </a>
                    </li>
                    <li>
                      <a href="<?= $base_url ?>/crm/reaction/validation">
                        <span class="sub-item">Validation</span>
                      </a>
                    </li>
                    <li>
                      <a href="<?= $base_url ?>/#">
                        <span class="sub-item">Import</span>
                      </a>
                    </li>
                    <li>
                      <a href="<?= $base_url ?>/#">
                        <span class="sub-item">Export</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li>
                <a data-bs-toggle="collapse" href="<?= $base_url ?>/#type_reaction">
                  <span class="sub-item">Type De Reaction</span>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="type_reaction">
                  <ul class="nav nav-collapse subnav">
                    <li>
                      <a href="<?= $base_url ?>/crm/type_reaction/insert">
                        <span class="sub-item">Insertion</span>
                      </a>
                    </li>
                    <li>
                      <a href="<?= $base_url ?>/crm/type_reaction/liste">
                        <span class="sub-item">Liste</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </li>


        <li class="nav-item">
          <a data-bs-toggle="collapse" href="<?= $base_url ?>/#clients"><i class="fas fa-people-carry"></i>
            <p>Clients</p><span class="caret"></span>
          </a>
          <div class="collapse" id="clients">
            <ul class="nav nav-collapse">
              <li><a href="<?= $base_url ?>/"><span class="sub-item">Insertion</span></a></li>
              <li><a href="<?= $base_url ?>/"><span class="sub-item">Liste</span></a></li>
              <li><a href="<?= $base_url ?>/#"><span class="sub-item">Import</span></a></li>
              <li><a href="<?= $base_url ?>/#"><span class="sub-item">Export</span></a></li>
            </ul>
          </div>
        </li>


        <li class="nav-item deconex"><a href="<?= $base_url ?>/logout"><i class="fas fa-sign-out-alt "></i>
            <p>Déconnexion</p>
          </a></li>
      </ul>
    </div>
  </div>
</div>
<!-- End Sidebar -->