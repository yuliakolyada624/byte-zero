<?php
helper('forms');
?>
<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.register') ?> <?= $this->endSection() ?>

<?= $this->section('bobyClass') ?>create-new-password-page<?= $this->endSection() ?>

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
        <?= $this->setData(['step' => 4])->include('auth/auth-steps') ?>
    </div>
    <div class="auth-page__section-content">

        <h2 class="auth-page-title">Account Holder Details</h2>
        <p class="auth-page-subtitle">Please provide just a few more details.</p>
        <div class="d-flex mx-auto auth-page__form-wrap">

            <form class="form js-form auth-page__form" action="<?= url_to('save-account-details') ?>" method="POST"
                data-validation="phone_number" data-type="phone_number">
                <?= csrf_field() ?>

                <div class="form-field auth-page__form-field  is-required js-field js__textinput <?= (form_check_errors_field('first_name') ? '_invalid' : '') ?>"
                    data-type="name">
                    <label for="first_name" class="form-label form-field__title">First name</label>
                    <div class="form-field__input-wrap">
                        <input class="form-field__input js-field-input form-control" id="first_name" type="text"
                            name="first_name" validateOnBlur="true" value="<?= old('first_name') ?>" placeholder="" />
                    </div>
                    <span class="form-field__error js-field-error"><?= form_show_errors_by_field('first_name'); ?></span>
                </div>


                <div class="form-field auth-page__form-field  is-required js-field js__textinput <?= (form_check_errors_field('last_name') ? '_invalid' : '') ?>"
                    data-type="name">
                    <label for="last_name" class="form-label form-field__title">Last name</label>
                    <div class="form-field__input-wrap">
                        <input class="form-field__input js-field-input form-control" id="last_name" type="text"
                            name="last_name" validateOnBlur="true" value="<?= old('last_name') ?>" placeholder="" />
                    </div>
                    <span class="form-field__error js-field-error"><?= form_show_errors_by_field('last_name'); ?></span>
                </div>


                <div
                    class="component__dropdown2 auth-page__dropdown js__textinput <?= (form_check_errors_field('service_industry') ? '_invalid' : '') ?>">
                    <label for="ddServiceIndustry" class="form-label">Service Industry</label>
                    <select id="ddServiceIndustry" class="form-select w-100" name="service_industry"
                        placeholder="Please select" data-placeholder="Please select">
                        <option></option>
                        <option value="Healthcare Services">Healthcare Services</option>
                        <option value="Insurance Services">Insurance Services</option>
                        <option value="Legal Services">Legal Services</option>
                    </select>
                    <div id="validationServer04Feedback" class="invalid-feedback">

                    </div>
                    <?= form_show_errors_by_field('service_industry'); ?>
                </div>

                <!-- <div class="form-field auth-page__form-field  is-required js-field " data-type="name">
                    <label for="work_phone_number" class="form-label form-field__title">Work Phone Number</label>
                    <div class="form-field__input-wrap">
                        <input class="form-field__input js-field-input form-control" id="work_phone_number" validateOnBlur="true"
                            type="phone" name="work_phone_number" placeholder="000-000-0000" value="<?= old('work_phone_number') ?>" />
                    </div>
                    <span class="form-field__error js-field-error">Required field</span>
                    <?= form_show_errors_field('work_phone_number'); ?>
                </div> -->
                <div class="component__itidropdown auth-page__form-field is-required <?= (form_check_errors_field('work_phone_number') ? '_invalid' : '') ?>"
                    data-type="phone">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input class="form-control component__itidropdown-input js__itidropdown-input"
                        id="work_phone_number" type="phone" name="work_phone_number"
                        value="<?= old('work_phone_number') ?>" data-country="<?= old('country_code') ?>"
                        autocomplete="off" placeholder="000-000-0000" aria-describedby="phoneFeedback"
                        data-placeholder="000-000-0000" data-country="">
                    <div id="phoneFeedback" class="invalid-feedback component__itidropdown-error js-field-error">
                        Valid company phone required
                    </div>
                    <?= form_show_errors_field('work_phone_number'); ?>
                </div>

                <?= form_show_error() ?>

                <button class="btn btn-primary auth-page-btn auth-page__form-btn" type="submit"
                    aria-label="Complete Registration">Complete Registration</button>
            </form>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $('#ddServiceIndustry').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        minimumResultsForSearch: Infinity
    });
</script>

<?= $this->endSection() ?>