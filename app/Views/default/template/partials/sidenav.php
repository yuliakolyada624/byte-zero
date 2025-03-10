<div class="col-auto bg-main-light px-0">
    <aside class="sticky-top sticky-offset vh-100 overflow-auto py-2 sidenav-nav">
          <a href="/" class="sidenav-nav__header">

            <picture class="header__image">
              <source srcset="/assets/themes/default/img/./content/logo.webp" type="image/webp" class="header__img " />
              <img src="/assets/themes/default/img/./content/logo.png" alt="img" class="header__img " width="146" height="28" />
            </picture>

          </a>
          <ul class="sidenav-nav__content">
            <li class="sidenav-nav__item mb-1 <?= uri_string() == 'dashboard/index' ? 'active' : '' ?>">
              <a href="/dashboard/index" class="sidenav-nav__link" aria-label="Dashboard">
                <span class="sidenav-nav__link-icon">

                  <svg class="icon icon-nav-home stroke">
                    <use href="/assets/themes/default/icon/icons/icons.svg#nav-home" />
                  </svg>

                </span>
                <span class="sidenav-nav__link-value">Dashboard</span>
              </a>
            </li>
            <li class="sidenav-nav__item mb-1 <?= uri_string() == 'orders/cases' ? 'active' : '' ?>">
              <a href="/orders/cases" class="sidenav-nav__link" aria-label="Cases">
                <span class="sidenav-nav__link-icon">

                  <svg class="icon icon-nav-cases stroke">
                    <use href="/assets/themes/default/icon/icons/icons.svg#nav-cases" />
                  </svg>

                </span>
                <span class="sidenav-nav__link-value">Cases</span>
              </a>
            </li>
            <li class="sidenav-nav__item mb-1 <?= uri_string() == 'transactions/list' ? 'active' : '' ?>">
              <a href="/transactions/list" class="sidenav-nav__link" aria-label="Transactions">
                <span class="sidenav-nav__link-icon">

                  <svg class="icon icon-nav-billing fill">
                    <use href="/assets/themes/default/icon/icons/icons.svg#nav-billing" />
                  </svg>

                </span>
                <span class="sidenav-nav__link-value">Transactions</span>
              </a>
            </li>
            <li class="sidenav-nav__item mb-1 <?= uri_string() == 'user-management/list' ? 'active' : '' ?>">
              <a href="/user-management/list/" class="sidenav-nav__link" aria-label="Users">
                <span class="sidenav-nav__link-icon">

                  <svg class="icon icon-nav-management stroke">
                    <use href="/assets/themes/default/icon/icons/icons.svg#nav-management" />
                  </svg>

                </span>
                <span class="sidenav-nav__link-value">Users</span>
              </a>
            </li>
            <li class="sidenav-nav__item mb-1 ">
              <a href="/preferences/index" class="sidenav-nav__link" aria-label="Preferences">
                <span class="sidenav-nav__link-icon">

                  <svg class="icon icon-nav-settings stroke">
                    <use href="/assets/themes/default/icon/icons/icons.svg#nav-settings" />
                  </svg>

                </span>
                <span class="sidenav-nav__link-value">Preferences</span>
              </a>
            </li>
            <li class="sidenav-nav__item mb-1 ">
              <a href="/support/index" class="sidenav-nav__link" aria-label="Support">
                <span class="sidenav-nav__link-icon">

                  <svg class="icon icon-nav-support fill">
                    <use href="/assets/themes/default/icon/icons/icons.svg#nav-support" />
                  </svg>

                </span>
                <span class="sidenav-nav__link-value">Support</span>
              </a>
            </li>
          </ul>

          <div class="sidenav-nav__bottom">
            <div class="card">

              <picture class="icon__image">
                <source srcset="/assets/themes/default/img/./content/juris.webp" type="image/webp" class="icon__img " />
                <img src="/assets/themes/default/img/./content/juris.png" alt="img" class="icon__img " width="35" height="35" />
              </picture>

              <div class="card-body">
                <p>Meet <b>Juris</b><br> Your Data Expert!</p>
                <hr>
                <a href="">Start Now</a>
              </div>
            </div>

            <button class="btn btn-primary " type="button" aria-label="Logout" onclick="location.href='<?=base_url('/accounts/logout/')?>';" >
              <svg class="icon icon-log-out ">
                <use href="/assets/themes/default/icon/icons/icons.svg#log-out" />
              </svg>
              Logout
            </button>

            <p>Med-Test.AI © <?=date('Y')?></p>
          </div>
        </aside>
</div>