<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.register') ?> <?= $this->endSection() ?>

<?= $this->section('bobyClass') ?>company-information-page<?= $this->endSection() ?>
<?= $this->section('main') ?>
<div class="wrapper">
    <div class="content">
        <div class="auth-page__wrapper">
            <div class="auth-page__container">
                <div class="auth-page__section auth-page__main">
                    <div class="auth-page__main-container">
                        <header class="auth-page-header">
                            <a href="<?= base_url() ?>" class="auth-page-header__logo" aria-label="Logo link">
                                <picture class="auth-page-header__image">
                                    <source srcset="/assets/thames/default/img/content/auth-page/auth-logo.webp" type="image/webp" class="auth-page-header__img" />
                                    <img src="/assets/thames/default/img/content/auth-page/auth-logo.png" alt="img" class="auth-page-header__img" width="228" height="28" />
                                </picture>
                            </a>
                        </header>
                        <div class="auth-page__section auth-page__contentbox">

                            <div class="auth-page__section-content">
                                <h2 class="auth-page-title">
                                    Company Information
                                </h2>
                                <p class="auth-page-subtitle">
                                    Final step to complete your account registration.
                                </p>
                                <form class="form js-form auth-page__form" 
                                        action="<?=url_to('company-create') ?>" 
                                        method="POST" data-validation="company" 
                                        data-href="<?=url_to('company-create') ?>">
                                    <?= csrf_field() ?>
                                    <div class="form-field auth-page__form-field order-0   js-field " data-type="text">
                                        <label for="company_name" class="form-field__title">Company name</label>
                                        <div class="form-field__input-wrap">
                                            <input class="form-field__input js-field-input" id="company_name" type="text" name="company_name" value="" placeholder="Enter legal name" />
                                        </div>
                                    </div>


                                    <div class="form-field auth-page__form-field order-1">
                                        <label for="job_title" class="form-field__title">What’s your job title?</label>
                                        <div class="dropdown js-select auth-page__form-field__select" data-direction="bottom" data-title="job_title">
                                            <input class="field__input js-select-input" id="job_title" type="hidden" name="job_title" value="" />
                                            <button class="dropdown__trigger js-select-trigger" type="button" aria-label="Select">
                                                <span class="dropdown__trigger-value js-select-trigger-value">
                                                    Select
                                                </span>
                                                <svg class="icon icon-chevron ">
                                                    <use href="/assets/thames/default/icon/icons/icons.svg#chevron" />
                                                </svg>

                                            </button>
                                            <div class="dropdown__item js-select-dropdown">
                                                <ul>
                                                    <li>
                                                        <button class="js-select-option" type="button" data-select-value="Administration" aria-label="Administration">
                                                            Administration
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="js-select-option" type="button" data-select-value="C-Level Executives" aria-label="C-Level Executives">
                                                            C-Level Executives
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="js-select-option" type="button" data-select-value="Finance" aria-label="Finance">
                                                            Finance
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="js-select-option" type="button" data-select-value="Human resources (HR)" aria-label="Human resources (HR)">
                                                            Human resources (HR)
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="js-select-option" type="button" data-select-value="Operations" aria-label="Operations">
                                                            Operations
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="js-select-option" type="button" data-select-value="Other" aria-label="Other">
                                                            Other
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-field auth-page__form-field order-3">
                                        <label for="number_of_employees" class="form-field__title">Number of employees</label>
                                        <div class="dropdown js-select auth-page__form-field__select" data-direction="top" data-title="number_of_employees">
                                            <input class="field__input js-select-input" id="number_of_employees" type="hidden" name="number_of_employees" value="" />
                                            <button class="dropdown__trigger js-select-trigger" type="button" aria-label="Select">
                                                <span class="dropdown__trigger-value js-select-trigger-value">
                                                    Select
                                                </span>
                                                <svg class="icon icon-chevron ">
                                                    <use href="/assets/thames/default/icon/icons/icons.svg#chevron" />
                                                </svg>

                                            </button>
                                            <div class="dropdown__item js-select-dropdown">
                                                <ul>
                                                    <li>
                                                        <button class="js-select-option" type="button" data-select-value="1-20" aria-label="1-20">
                                                            1-20
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="js-select-option" type="button" data-select-value="21-50" aria-label="21-50">
                                                            21-50
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="js-select-option" type="button" data-select-value="51-100" aria-label="51-100">
                                                            51-100
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="js-select-option" type="button" data-select-value="101-500" aria-label="101-500">
                                                            101-500
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="js-select-option" type="button" data-select-value="501-1,000" aria-label="501-1,000">
                                                            501-1,000
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="js-select-option" type="button" data-select-value="1,001-5,000" aria-label="1,001-5,000">
                                                            1,001-5,000
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="js-select-option" type="button" data-select-value="5,000+" aria-label="5,000+">
                                                            5,000+
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-field auth-page__form-field order-4">
                                        <label for="annual_booking_budget_estimate" class="form-field__title">Annual booking budget estimate</label>
                                        <div class="dropdown js-select auth-page__form-field__select" data-direction="top" data-title="annual_booking_budget_estimate">
                                            <input class="field__input js-select-input" id="annual_booking_budget_estimate" type="hidden" name="annual_booking_budget_estimate" value="" />
                                            <button class="dropdown__trigger js-select-trigger" type="button" aria-label="Select">
                                                <span class="dropdown__trigger-value js-select-trigger-value">
                                                    Select
                                                </span>
                                                <svg class="icon icon-chevron ">
                                                    <use href="/assets/thames/default/icon/icons/icons.svg#chevron" />
                                                </svg>

                                            </button>
                                            <div class="dropdown__item js-select-dropdown">
                                                <ul>
                                                    <li>
                                                        <button class="js-select-option" type="button" data-select-value="$0 - $10,000" aria-label="$0 - $10,000">
                                                            $0 - $10,000
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="js-select-option" type="button" data-select-value="$10,000 - $25,000" aria-label="$10,000 - $25,000">
                                                            $10,000 - $25,000
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="js-select-option" type="button" data-select-value="$25,000 - $50,000" aria-label="$25,000 - $50,000">
                                                            $25,000 - $50,000
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="js-select-option" type="button" data-select-value="$50,000 - $100,000" aria-label="$50,000 - $100,000">
                                                            $50,000 - $100,000
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="js-select-option" type="button" data-select-value="$100,000 - $250,000" aria-label="$100,000 - $250,000">
                                                            $100,000 - $250,000
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="js-select-option" type="button" data-select-value="$250,000 +" aria-label="$250,000 +">
                                                            $250,000 +
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tel-inputs-wrap order-2">

                                        <div class="form-field auth-page__form-field col-6 js-field " data-type="">
                                            <label for="work_phone_number" class="form-field__title">Work phone number, Ext.</label>
                                            <div class="tel-wrap">
                                            <div class="code-section">
                                                <img src="/assets/thames/default/svg/flags/us.svg" alt="phone-btn" class="flag-container">
                                                <span class="dial-code">+1</span>
                                            </div>
                                            <input type="tel" name="work_phone_number" id="work_phone_number" placeholder="" value=""
                                                class="form-field__input js-field-input js-company-input" data-validation="true" />
                                            <div class="tel-input-dropdown">
                                                    <?= $this->include('parts/tel-input-dropdown-list') ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-field auth-page__form-field col-6 js-field " data-type="">
                                            <label for="mobile_phone_number" class="form-field__title">Mobile phone number</label>
                                            <div class="tel-wrap">
                                                <div class="code-section">
                                                    <img src="/assets/thames/default/svg/flags/us.svg" alt="phone-btn" class="flag-container">
                                                    <span class="dial-code">+1</span>
                                                </div>
                                                <input type="tel" name="mobile_phone_number" id="mobile_phone_number" placeholder="" value=""
                                                    class="form-field__input js-field-input js-company-input" data-validation="true" />
                                                <div class="tel-input-dropdown">
                                                    <?= $this->include('parts/tel-input-dropdown-list') ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <button class="auth-page-btn auth-page__form-btn order-5 js-company-btn" type="submit" disabled>Create Account</button>
                                </form>
                            </div>
                        </div>
                        <footer class='auth-page-footer'>
                            © <?=date('Y')?> Travlio. All rights reserved.
                        </footer>
                    </div>
                </div>
                <div class="auth-page__section auth-page__sidebar">

                    <div class="auth-page__sidebar-content">
                        <div class="auth-page__sidebar-title">Get <b>up to 70%</b> savings on corporate stay bookings</div>
                        <div class="auth-page__sidebar-stepper">
                            <div class="auth-page__sidebar-stepper-itembox">
                                <div class="auth-page__sidebar-stepper-item  done-step">
                                <div class="auth-page__sidebar-stepper-item-count">1</div>
                                <div class="auth-page__sidebar-stepper-item-done"> <svg class="icon icon-done-marker ">
                                    <use href="/assets/thames/default/icon/icons/icons.svg#done-marker" />
                                    </svg>
                                </div>
                                </div>
                            </div>
                            <div class="auth-page__sidebar-stepper-itembox">
                                <div class="auth-page__sidebar-stepper-item  done-step">
                                <div class="auth-page__sidebar-stepper-item-count">2</div>
                                <div class="auth-page__sidebar-stepper-item-done"> <svg class="icon icon-done-marker ">
                                    <use href="/assets/thames/default/icon/icons/icons.svg#done-marker" />
                                    </svg>
                                </div>
                                </div>
                            </div>
                            <div class="auth-page__sidebar-stepper-itembox">
                                <div class="auth-page__sidebar-stepper-item step">
                                <div class="auth-page__sidebar-stepper-item-count">3</div>
                                <div class="auth-page__sidebar-stepper-item-done"> <svg class="icon icon-done-marker ">
                                    <use href="/assets/thames/default/icon/icons/icons.svg#done-marker" />
                                    </svg>
                                </div>
                                </div>
                            </div>
                            </div>
                        <div class="auth-page__sidebar-backphoto">
                            <picture class="auth-page__sidebar-group__image">
                                <source srcset="/assets/thames/default/img/content/auth-page/sidebar-group.webp" type="image/webp" class="auth-page__sidebar-group__img" />
                                <img src="/assets/thames/default/img/content/auth-page/sidebar-group.png" alt="img" class="auth-page__sidebar-group__img" width="674" height="587" />
                            </picture>

                        </div>
                        <div class="auth-page__sidebar-benefits">
                            <div class="auth-page__sidebar-benefits-item">
                                <span class="mark"> <svg class="icon icon-done-marker ">
                                        <use href="/assets/thames/default/icon/icons/icons.svg#done-marker" />
                                    </svg>
                                </span>
                                <span class="value">Free to join</span>
                            </div>
                            <div class="auth-page__sidebar-benefits-item">
                                <span class="mark"> <svg class="icon icon-done-marker ">
                                        <use href="/assets/thames/default/icon/icons/icons.svg#done-marker" />
                                    </svg>
                                </span>
                                <span class="value">Top hotel brands</span>
                            </div>
                            <div class="auth-page__sidebar-benefits-item">
                                <span class="mark"> <svg class="icon icon-done-marker ">
                                        <use href="/assets/thames/default/icon/icons/icons.svg#done-marker" />
                                    </svg>
                                </span>
                                <span class="value">No obligations</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>