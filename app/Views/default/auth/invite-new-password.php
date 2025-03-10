<?php
helper('forms');
?>
<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.register') ?> <?= $this->endSection() ?>

<?= $this->section('bobyClass') ?>create-new-password-page<?= $this->endSection() ?>

<?= $this->section('auth-header-btn') ?>
 <?php if($type=='register'): ?>
    <a href="<?= base_url() ?>accounts/login" class="btn btn-primary auth-header-btn">Sing in</a>
  <?php else: ?>
    <a href="<?= base_url() ?>accounts/register" class="btn btn-primary auth-header-btn">Register</a>
  <?php endif; ?>  
<?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="container auth-content">
    <div class="auth-page__section-header">
    <?php if($type=='register'): ?>
        <?php 
        if(getenv('enable2FA')==='true'):
        ?>
        <div class="component__backbtn">
            <div class="component__backbtn-wrap">
                <a href="<?=url_to('add-phone')?>" class="component__backbtn-btn">
                <svg width="14" height="18" viewBox="0 0 14 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.5 4L4.5 9L9.5 14" stroke="#148BDF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Back
                </a>
            </div>
        </div>
        <?php endif; ?>
        <?= $this->setData(['step'=>3])->include('auth/auth-invite-steps') ?>
    <?php endif; ?>
    </div>
    <div class="auth-page__section-content">
        <h2 class="auth-page-title">
            <?=($type=='register' ? 'Create A Password' : 'Create New Password')?>
        </h2>
        <p class="auth-page-subtitle">
            <?=
            ($type=='register' ? 
            'Choose a strong and unique</br>password for enhanced security.' 
            :
            'Enter your new password');
            ?>
        </p>
        <div class="d-flex flex-column justify-content-center align-items-center mx-auto auth-page__form-wrap">
            <form class="form js-form auth-page__form" action="<?= url_to('set-password') ?>" method="POST"
                data-validation="password" data-type="password">
                <?= csrf_field() ?>

                <div class="form-field auth-page__form-field  is-required js-field password js__textinput <?=(form_check_errors_field('password') ? '_invalid' : '')?>" data-type="password">
                    <label for="password" class="form-label form-field__title"><?=($type=='register' ? 'Password' : 'New Password')?></label>
                    <div class="form-field__input-wrap">
                        <input class="form-field__input js-field-input form-control" id="password" type="password"
                            name="password" value="" placeholder="" required />
                        <button type="button" class="show-pass closed js-additional-btn" data-action="toggle"
                            data-classes="showed">

                            <svg class="icon icon-eye ">
                                <use href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#eye" />
                            </svg>


                            <svg class="icon icon-eye-closed ">
                                <use href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#eye-closed" />
                            </svg>

                        </button>
                    </div>
                    <span class="form-field__error js-field-error"><?=form_show_errors_by_field('password');?></span>
                </div>


                <div class="form-field auth-page__form-field  is-required js-field password js__textinput <?=(form_check_errors_field('password_confirm') ? '_invalid' : '')?>"
                    data-type="password_confirm">
                    <label for="password_confirm" class="form-label form-field__title">Re-enter Password</label>
                    <div class="form-field__input-wrap">
                        <input class="form-field__input js-field-input form-control" id="password_confirm"
                            type="password" name="password_confirm" value="" placeholder="" required />
                        <button type="button" class="show-pass closed js-additional-btn" data-action="toggle"
                            data-classes="showed">
                            <svg class="icon icon-eye ">
                                <use href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#eye" />
                            </svg>
                            <svg class="icon icon-eye-closed ">
                                <use href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#eye-closed" />
                            </svg>
                        </button>
                    </div>
                    <span class="form-field__error js-field-error"><?=form_show_errors_by_field('password_confirm');?></span>
                </div>

                <?=form_show_error()?>

                <button class="auth-page-btn auth-page__form-btn" type="submit" aria-label="Continue"><?=($type=='register' ? 'Continue' : 'Change Password')?></button>
            

                <div class="w-100 password-validation_list">
                    <div class="password-validation_item js-validation-item" data-collection="password"
                        data-validation="length">
                        <div class="password-validation_item-icon">

                            <svg class="icon icon-pass-novalid ">
                                <use href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#pass-novalid" />
                            </svg>


                            <svg class="icon icon-pass-valid ">
                                <use href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#pass-valid" />
                            </svg>

                        </div>
                        Be at least 8 characters long
                    </div>
                    <div class="password-validation_item js-validation-item" data-collection="password"
                        data-validation="uppercase">
                        <div class="password-validation_item-icon">

                            <svg class="icon icon-pass-novalid ">
                                <use href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#pass-novalid" />
                            </svg>


                            <svg class="icon icon-pass-valid ">
                                <use href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#pass-valid" />
                            </svg>

                        </div>
                        Contain at least one uppercase letter
                    </div>
                    <div class="password-validation_item js-validation-item" data-collection="password"
                        data-validation="number">
                        <div class="password-validation_item-icon">

                            <svg class="icon icon-pass-novalid ">
                                <use href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#pass-novalid" />
                            </svg>


                            <svg class="icon icon-pass-valid ">
                                <use href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#pass-valid" />
                            </svg>

                        </div>
                        Contain at least 1 number
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>

<?= $this->endSection() ?>