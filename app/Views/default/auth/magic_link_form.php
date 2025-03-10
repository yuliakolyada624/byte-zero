<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.register') ?> <?= $this->endSection() ?>

<?= $this->section('bobyClass') ?>reset-password-page<?= $this->endSection() ?>

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
                                    <source srcset="/assets/themes/default/img/content/auth-page/auth-logo.webp" type="image/webp" class="auth-page-header__img" />
                                    <img src="/assets/themes/default/img/content/auth-page/auth-logo.png" alt="img" class="auth-page-header__img" width="228" height="28" />
                                </picture>

                            </a>
                        </header>
                        <?php /* if (session('error') !== null) : ?>
                            <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
                        <?php elseif (session('errors') !== null) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?php if (is_array(session('errors'))) : ?>
                                    <?php foreach (session('errors') as $error) : ?>
                                        <?= $error ?>
                                        <br>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <?= session('errors') ?>
                                <?php endif ?>
                            </div>
                        <?php endif */?>
                        <div class="auth-page__section auth-page__contentbox">
                            <div class="auth-page__section-content">
                                <h2 class="auth-page-title">Reset password</h2>
                                <p class="auth-page-subtitle">Enter your email for password reset instructions</p>
                                <!-- <form action="<?= url_to('magic-link') ?>" method="post"> -->
                                <form class="form js-form auth-page__form" action="<?=url_to('post-reset-password') ?>" method="POST">
                                    <?= csrf_field() ?>

                                    <div class="form-field auth-page__form-field  is-required js-field " data-type="email">
                                        <label for="email" class="form-field__title">Company email</label>
                                        <div class="form-field__input-wrap">
                                            <!-- <input class="form-field__input js-field-input" id="email" type="email" name="email" value="" placeholder="" /> -->
                                            <input type="email" class="form-field__input js-field-input" name="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>"
                                                        value="<?= old('email', auth()->user()->email ?? null) ?>" required />
                                        </div>
                                        <span class="form-field__error js-field-error">Valid company email required</span>
                                        <div class="form__col _col-12 form-field _invalid ">
                                            <?php
                                            if (session('error') !== null): ?>
                                            <div class="form-field__error js-field-error">
                                                <?= session('error') ?>
                                            </div>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                    <button class="auth-page-btn auth-page__form-btn" type="submit" aria-label="Reset Password">Reset Password</button>
                                </form>
                            </div>
                        </div>
                        <?= $this->include('auth/auth-pages-footer') ?>
                    </div>
                </div>
                <div class="auth-page__section auth-page__sidebar">

                    <div class="auth-page__sidebar-content">
                        <picture class="auth-page__sidebar-photo__image">
                            <source srcset="/assets/themes/default/img/content/auth-page/sidebar-backphoto.webp" type="image/webp" class="auth-page__sidebar-photo__img" />
                            <img src="/assets/themes/default/img/content/auth-page/sidebar-backphoto.png" alt="img" class="auth-page__sidebar-photo__img" width="670" height="760" />
                        </picture>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>


<?php  /* 
<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.useMagicLink') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="container d-flex justify-content-center p-5">
    <div class="card col-12 col-md-5 shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-5"><?= lang('Auth.useMagicLink') ?></h5>

                <?php if (session('error') !== null) : ?>
                    <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
                <?php elseif (session('errors') !== null) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php if (is_array(session('errors'))) : ?>
                            <?php foreach (session('errors') as $error) : ?>
                                <?= $error ?>
                                <br>
                            <?php endforeach ?>
                        <?php else : ?>
                            <?= session('errors') ?>
                        <?php endif ?>
                    </div>
                <?php endif ?>

            <form action="<?= url_to('magic-link') ?>" method="post">
                <?= csrf_field() ?>

                <!-- Email -->
                <div class="mb-2">
                    <input type="email" class="form-control" name="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>"
                           value="<?= old('email', auth()->user()->email ?? null) ?>" required />
                </div>

                <div class="d-grid col-12 col-md-8 mx-auto m-3">
                    <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.send') ?></button>
                </div>

            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
*/ ?>