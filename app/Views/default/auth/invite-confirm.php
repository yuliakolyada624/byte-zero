<?php
helper('forms');
?>
<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.register') ?> <?= $this->endSection() ?>

<?= $this->section('bobyClass') ?>sign-up-invited-registration-page<?= $this->endSection() ?>

<?= $this->section('auth-header-btn') ?>
<a href="<?= base_url() ?>accounts/login" class="btn btn-primary auth-header-btn">Sing in</a>
<?= $this->endSection() ?>

<?= $this->section('main') ?>


<div class="container auth-content">
    <div class="auth-page__section-header">
        <div class="component__backbtn">
            <div class="component__backbtn-wrap">
                <a href="<?= url_to('new-password') ?>" class="component__backbtn-btn">
                    <svg width="14" height="18" viewBox="0 0 14 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.5 4L4.5 9L9.5 14" stroke="#148BDF" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    Back
                </a>
            </div>
        </div>
        <?= $this->setData(['step' => 1])->include('auth/auth-invite-steps') ?>
    </div>
    <div class="auth-page__section-content">

        <h2 class="auth-page-title">Account Registration</h2>
        <p class="auth-page-subtitle">Let’s take a moment to set up your account.</p>
        <div class="d-flex mx-auto auth-page__form-wrap">
        <form class="form js-form auth-page__form" action="<?= url_to('set-onboarding-confirm') ?>" method="POST" data-validation="phone_number" data-type="phone_number">
            <?= csrf_field() ?>
            
            <!-- Firm or Company Email -->
            <div class="form-field auth-page__form-field is-readonly is-required js-field js__textinput <?= (form_check_errors_field('email') ? '_invalid' : '') ?>"
                data-type="email">
                <label for="email" class="form-label form-field__title">Firm or Company Email</label>
                <div class="form-field__input-wrap">
                    <input class="form-field__input js-field-input form-control" id="email" validateOnBlur="true"
                    type="email" name="email" value="<?= $user->email ?>" placeholder="" readonly />
                    <div class="form-field__readonly-symbol">

                    <svg class="icon icon-secure ">
                        <use href="/assets/themes/default/icon/icons/icons.svg#secure" />
                    </svg>

<<<<<<< HEAD
=======
            <form class="form js-form auth-page__form" action="<?= url_to('set-onboarding-confirm') ?>" method="POST"
                data-validation="phone_number" data-type="phone_number">
                <?= csrf_field() ?>


                <div class="form-field auth-page__form-field is-readonly is-required js-field js__textinput <?= (form_check_errors_field('email') ? '_invalid' : '') ?>" data-type="name">
                    <label for="email" class="form-label form-field__title">Firm or Company Email</label>
                    <div class="form-field__input-wrap">
                        <input class="form-field__input js-field-input form-control" id="email" type="text"
                            name="email" validateOnBlur="true" value="<?= $user->email ?>" placeholder="name@yourcompany.com" readonly />
                        <div class="form-field__readonly-symbol">
                            <svg class="icon icon-secure ">
                                <use href="/assets/themes/default/icon/icons/icons.svg#secure" />
                            </svg>

                        </div>
>>>>>>> 2514cecb7fe451eed6af4f0331262d8fbf5640b3
                    </div>
                </div>
                <span class="form-field__error js-field-error"><?= form_show_errors_by_field('email'); ?></span>
            </div>

            <!-- First Name -->
            <div class="form-field col-6 auth-page__form-field is-required js-field js__textinput <?= (form_check_errors_field('first_name') ? '_invalid' : '') ?>" data-type="name">
                <label for="first_name" class="form-label form-field__title">First name</label>
                <div class="form-field__input-wrap">
                    <input class="form-field__input js-field-input form-control" id="first_name" type="text" name="first_name"
                        validateOnBlur="true" value="<?= $user->first_name ?>" placeholder="" />
                </div>
                <span class="form-field__error js-field-error"><?= form_show_errors_by_field('first_name'); ?></span>
            </div>

            <!-- Last Name -->
            <div class="form-field col-6 auth-page__form-field is-required js-field js__textinput <?= (form_check_errors_field('last_name') ? '_invalid' : '') ?>" data-type="name">
                <label for="last_name" class="form-label form-field__title">Last name</label>
                <div class="form-field__input-wrap">
                    <input class="form-field__input js-field-input form-control" id="last_name" type="text" name="last_name"
                        validateOnBlur="true" value="<?= $user->last_name ?>" placeholder="" />
                </div>
                <span class="form-field__error js-field-error"><?= form_show_errors_by_field('last_name'); ?></span>
            </div>

            <!-- Middle Name (Optional) -->
            <!-- <div class="form-field auth-page__form-field col-6 is-required js-field js__textinput <?= (form_check_errors_field('middle_name') ? '_invalid' : '') ?>" data-type="name">
                <label for="middle_name" class="form-label form-field__title">Middle name</label>
                <div class="form-field__input-wrap">
                    <input class="form-field__input js-field-input form-control" id="middle_name" type="text"
                        name="middle_name" validateOnBlur="true" value="<?= $user->middle_name ?>"
                        placeholder="Optional" />
                </div>
                <span class="form-field__error js-field-error"><?= form_show_errors_by_field('middle_name'); ?></span>
            </div> -->

            <!-- Work Phone Number -->
            <div class="component__itidropdown auth-page__form-field is-required" data-type="phone">
                <label for="work_phone_number" class="form-label">Work Phone Number</label>
                <input class="form-control component__itidropdown-input js__itidropdown-input" id="work_phone_number" type="phone" name="work_phone_number" value="" placeholder="000-000-0000" aria-describedby="phoneFeedback" data-placeholder="000-000-0000" data-country="">
                <div id="phoneFeedback" class="invalid-feedback component__itidropdown-error js-field-error">
                    Valid company phone required
                </div>
            </div>
            
            <!-- Terms and Conditions -->
            <div class="form-check form-terms-checkbox form-terms-checkbox-wrap is-required">
                <input class="form-check-input auth-form-terms-checkbox js__terms-checkbox <?= (form_check_errors_field('register_agree') ? 'is-invalid' : '') ?>" 
                        type="checkbox" value="1" id="flexCheckDefault" name="register_agree">
                <label class="form-check-label form-terms" for="flexCheckDefault">
                    By creating an account, I agree to Med-Test.ai’s
                    <a href="#" class="auth-page-link">Terms and Conditions</a> and
                    <a href="#" class="auth-page-link">Privacy Policy.</a>
                </label>
            </div>
            
            <!-- Submit Button -->
            <button class="btn btn-primary auth-page-btn auth-page__form-btn" type="submit" aria-label="Continue">Continue</button>

        </form>

        </div>
    </div>

</div>


<?= $this->endSection() ?>