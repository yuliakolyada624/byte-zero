<?php
$lang = get_language();
$user = auth()->user();
?>
<header class="header ">
          <div class="container-fluid">
            <div class="row justify-content-between align-items-center">
              <div class="col ps-0">
                <h4><?= $user->getUserCompanyName() ?></h4>
              </div>
              <div class="col d-flex justify-content-end align-items-center gap-3 pe-0">
                <div class="dropdown">
                  <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">

                    <svg class="icon icon-bell ">
                      <use href="/assets/themes/default/icon/icons/icons.svg#bell" />
                    </svg>

                  </button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                  </ul>
                </div>
                <div class="dropdown user">
                  <button class="dropdown-toggle user__btn" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <img class="js__global-header-avatar user-avatar" src="<?= user_avatar($user->id, 30, 30); ?>" />
                  </button>
                  <ul class="dropdown-menu">
                    <li class="dropdown-item">
                      <?= $user->first_name ?>
                      <?= $user->last_name ?>
                    </li>
                    <li class="dropdown-item"><?= $user->getUserRoleName() ?></li>
                    <li>
                      <hr>
                    </li>
                    <li><a class="dropdown-item" href="<?= base_url() ?>account/profile">
                        <svg class="icon icon-user ">
                          <use href="/assets/themes/default/icon/icons/icons.svg#user" />
                        </svg>
                        My Profile</a></li>
                    <li><a class="dropdown-item" href="#">
                        <svg class="icon icon-bell ">
                          <use href="/assets/themes/default/icon/icons/icons.svg#bell" />
                        </svg>
                        My Notifications</a></li>

                    <?php if (is_object(auth()->user()) && auth()->user()->can('system.access')) : ?>
                          <li>
                            <a class="header-user-menu__link" href="<?= base_url('admin/dashboard') ?>" aria-label="Admin">
                              <svg class="icon icon-nav-settings stroke">
                                <use href="/assets/themes/default/icon/icons/icons.svg#nav-settings"></use>
                              </svg>
                              Admin Dashboard
                            </a>
                          </li>
                    <?php endif; ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </header>