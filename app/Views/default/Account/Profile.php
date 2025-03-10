<?= $this->extend('template/layout') ?>
<?= $this->section('content') ?>

<?= $this->section('extra-css') ?>
<style>

</style>
<?= $this->endSection() ?>

<?php
$user = auth()->user();

$date = \DateTime::createFromFormat('Y-m-d H:i:s', $user->updated_at);
$date->setTimezone(new DateTimeZone('America/New_York'));


?>
<div class="profile js__profile-form js-form">
    <div class="d-flex justify-content-between profile-heading">
        <div>
            <h1 class="profile-heading__title">My Profile</h1>
        </div>
        <div class="d-flex align-items-center">
            <div class="profile-heading__updated">
                <span>Last updated:</span>
                <span class="profile-heading__updated-date"><?= $date->format('d-m-Y'); ?></span>
                <span class="profile-heading__updated"></span>
                <span class="profile-heading__updated-time"><?= $date->format('h:i A T') ?></span>
            </div>
        </div>
    </div>

    <section class="profile--section profile__personal-info">
        <div class="profile--section-header">
            <h2 class="profile--section-title">Personal Information</h2>
        </div>
        <div class="profile--section-body">
            <div class="d-flex justify-content-between profile--image-line">
                <div class="d-flex justify-content-center align-items-center profile--image-current">
                    <img class="js__profile-current-avatar" src="/user/profile-avatar/<?= $user->id ?>?width=150&height=150" alt="avatar">
                </div>
                <div class="d-flex flex-column justify-content-center align-item-center profile--image-load">
                    <div id="profilePhotoResult" class="mx-auto mb-1"></div>
                    <!--<input class="js__profile-image" type="file" name="avatar" accept="image/*" paramName="avatar" hidden>-->
                    <div class="d-flex flex-column align-items-center justify-content-center">
                        <div class="d-flex justify-content-center align-items-center profile--image-load-icon">
                            <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M6.66797 12.3333L10.0013 9M10.0013 9L13.3346 12.3333M10.0013 9V16.5M16.668 12.9524C17.6859 12.1117 18.3346 10.8399 18.3346 9.41667C18.3346 6.88536 16.2826 4.83333 13.7513 4.83333C13.5692 4.83333 13.3989 4.73833 13.3064 4.58145C12.2197 2.73736 10.2133 1.5 7.91797 1.5C4.46619 1.5 1.66797 4.29822 1.66797 7.75C1.66797 9.47175 2.36417 11.0309 3.49043 12.1613"
                                    stroke="#148BDF" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <div class="profile--image-load-disc">
                            <span>Click to upload</span> or drag and drop your image file<br />
                            to set as your profile picture
                        </div>
                        <div id="dropzoneLoaderProfileAvatar" class="profile--image-load-wrapper"></div>
                    </div>
                </div>
            </div>
            <form action="account/profile" data-action="account/profile" method="POST" class="js__profile-form js--profile-action">
                <div class="row">
                    <div class="form-field col col-4  is-required js-field js__textinput js__component-of-form  " data-type="text">
                        <label for="first_name" class="form-label form-field__title">First Name*</label>
                        <div class="form-field__input-wrap">
                            <input
                                class="form-field__input js-field-input form-control"
                                id="first_name"
                                validateOnBlur="true"
                                type="text"
                                name="first_name"
                                value="<?= $user->first_name ?>"
                                placeholder="" />
                        </div>
                        <span class="form-field__error js-field-error">Valid company name required</span>
                    </div>

                    <div class="form-field col col-4  is-required js-field js__textinput js__component-of-form  " data-type="text">
                        <label for="last_name" class="form-label form-field__title">Last Name*</label>
                        <div class="form-field__input-wrap">
                            <input
                                class="form-field__input js-field-input form-control"
                                id="last_name"
                                validateOnBlur="true"
                                type="text"
                                name="last_name"
                                value="<?= $user->last_name ?>"
                                placeholder="" />
                        </div>
                        <span class="form-field__error js-field-error">Required field</span>
                    </div>

                    <div class="form-field col col-4   js-field js__textinput js__component-of-form  " data-type="text">
                        <label for="employee_id" class="form-label form-field__title">Employee ID</label>
                        <div class="form-field__input-wrap">
                            <input
                                class="form-field__input js-field-input form-control"
                                id="employee_id"
                                validateOnBlur="true"
                                type="text"
                                name="employee_id"
                                value="<?= $user->employee_id ?>"
                                placeholder="" />
                        </div>
                    </div>


                    <div class="form-field col col-4 is-readonly is-required js-field js__textinput" data-type="email">
                        <label for="email" class="form-label form-field__title">Company Email</label>
                        <div class="form-field__input-wrap">
                            <input
                                class="form-field__input js-field-input form-control"
                                id="email"
                                validateOnBlur="true"
                                type="email"
                                name="email"
                                value="<?= $user->email ?>"
                                placeholder=""
                                readonly />
                            <div class="form-field__readonly-symbol">
                                <svg class="icon icon-secure ">
                                    <use href="/assets/themes/default/icon/icons/icons.svg#secure" />
                                </svg>
                            </div>
                        </div>
                        <span class="form-field__error js-field-error">Required field</span>
                    </div>

                    <div class="form-field col col-4 is-readonly is-required js-field js__textinput" data-type="email">
                        <label for="role" class="form-label form-field__title">Role</label>
                        <div class="form-field__input-wrap">
                            <input
                                class="form-field__input js-field-input form-control"
                                id="role"
                                validateOnBlur="true"
                                type="text"
                                name="role"
                                <?php $groups = config('AuthGroups')->groups; ?>
                                value="<?= $groups[$user->groups[0]]['title']; ?>"
                                placeholder=""
                                readonly />
                            <div class="form-field__readonly-symbol">
                                <svg class="icon icon-secure ">
                                    <use href="/assets/themes/default/icon/icons/icons.svg#secure" />
                                </svg>
                            </div>
                        </div>
                        <span class="form-field__error js-field-error">Required field</span>
                    </div>

                    <div class="col col-4">
                        <div class="component__dropdown2 profile__job-title is-required js__select-to-custom-add-job-title js__component-of-form" data-search="false">
                            <label for="profileJobTitle" class="form-label">Job Title*
                                <button type="button" class="btn-link" data-bs-toggle="offcanvas" data-bs-return="close" data-bs-target="#EditJobTitle"
                                    aria-controls="offcanvasRight">
                                    Edit Options
                                </button>
                            </label>
                            <select
                                id="profileJobTitle"
                                class="form-select js__select2 w-100"
                                name="job_title"
                                placeholder="Select"
                                data-placeholder="Select">
                                <option value="">Select</option>
                                <?php foreach ($select['job_titles'] as $job_title): ?>
                                    <option value="<?= $job_title['job_title'] ?>" <?= ($job_title['job_title'] == $user->job_title) ? 'selected="selected"' : '' ?>><?= $job_title['job_title'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback js-field-error">
                                Required field
                            </div>
                        </div>
                    </div>


                    <div class="col col-6">
                        <div class="component__itidropdown col col-6 is-required js__component-of-form" data-type="phone">
                            <label for="phone" class="form-label">Work Phone Number, Ext.*</label>
                            <input class="form-control component__itidropdown-input js__itidropdown-input" id="phone" type="phone"
                                name="phone_number" value="<?= $user->work_phone_number ?>" autocomplete="off" placeholder="000-000-0000" aria-describedby="phoneFeedback"
                                data-placeholder="000-000-0000" data-country="">
                            <div id="phoneFeedback" class="invalid-feedback component__itidropdown-error js-field-error">
                                Valid company phone required
                            </div>
                        </div>
                    </div>

                    <div class="col col-6">
                        <div class="component__itidropdown col col-6 is-required js__component-of-form" data-type="phone">
                            <label for="mobilenumber" class="form-label">Mobile Phone Number*</label>
                            <input class="form-control component__itidropdown-input js__itidropdown-input" id="mobilenumber"
                                type="phone" name="mobile_phone" value="<?= $user->phone_number ?>" autocomplete="off" placeholder="000-000-0000"
                                aria-describedby="mobilenumberFeedback" data-placeholder="000-000-0000" data-country="">
                            <div id="mobilenumberFeedback" class="invalid-feedback component__itidropdown-error js-field-error">
                                Valid company phone required
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </section>

    <section class="profile--section profile__company-address">
        <div class="profile--section-header">
            <h2 class="profile--section-title">Company Address</h2>
        </div>
        <form action="account/profile" data-action="account/profile" method="POST" class="js__profile-form js--profile-action">
            <div class="profile--section-body">
                <div class="row">

                    <div class="form-field col col-6 profile--input  is-required js-field js__textinput js__component-of-form"
                        data-type="text">
                        <label for="office_name" class="form-label form-field__title">Office Name*</label>
                        <div class="form-field__input-wrap">
                            <input class="form-field__input js-field-input form-control" id="office_name"
                                validateOnBlur="true" type="text" name="office_name" value="<?= $user->office_name ?>" placeholder="" />
                        </div>
                        <span class="form-field__error js-field-error">Required field</span>
                    </div>

                    <div class="form-field col col-6 profile--input  is-required js-field js__textinput js__component-of-form"
                        data-type="text">
                        <label for="legal_entity_name" class="form-label form-field__title">Legal Entity Name*</label>
                        <div class="form-field__input-wrap">
                            <input class="form-field__input js-field-input form-control" id="legal_entity_name"
                                validateOnBlur="true" type="text" name="legal_entity_name" value="<?= $company->legal_entity_name ?>" placeholder="" />
                        </div>
                        <span class="form-field__error js-field-error">Required field</span>
                    </div>


                    <div class="form-field col col-6 profile--input  is-required js-field js__textinput js__component-of-form"
                        data-type="text">
                        <label for="address_line_1" class="form-label form-field__title">Address Line 1*</label>
                        <div class="form-field__input-wrap">
                            <input class="form-field__input js-field-input form-control" id="address_line_1"
                                validateOnBlur="true" type="text" name="address_line_1" value="<?= $user->address_line_1 ?>" placeholder="" />
                        </div>
                        <span class="form-field__error js-field-error">Required field</span>
                    </div>

                    <div class="form-field col col-6 profile--input js-field js__textinput js__component-of-form" data-type="text">
                        <label for="address_line_2" class="form-label form-field__title">Address Line 2</label>
                        <div class="form-field__input-wrap">
                            <input class="form-field__input js-field-input form-control" id="address_line_2"
                                validateOnBlur="true" type="text" name="address_line_2" value="<?= $user->address_line_2 ?>" placeholder="" />
                        </div>
                    </div>


                    <div class="form-field col col-6 profile--input is-required js-field js__textinput js__component-of-form"
                        data-type="text">
                        <label for="city" class="form-label form-field__title">City*</label>
                        <div class="form-field__input-wrap">
                            <input class="form-field__input js-field-input form-control" id="city" validateOnBlur="true"
                                type="text" name="city" value="<?= $user->city ?>" placeholder="" />
                        </div>
                        <span class="form-field__error js-field-error">Required field</span>
                    </div>

                    <div class="col col-6">
                        <div class="component__dropdown2 profile__country js__profile-form-country is-required js__component-of-form"
                            data-search="false">
                            <label for="country" class="form-label">Country*
                            </label>
                            <select id="country" class="form-select js__select2 w-100" name="country" placeholder="Select"
                                data-placeholder="Select">
                                <option value="">Select</option>
                                <?php foreach ($select['countries'] as $country): ?>
                                    <?php if ($country->active == "1"): ?>
                                        <option value="<?= $country->alpha2 ?>" <?= ($country->alpha2 == $user->country_a2code) ? 'selected="selected"' : '' ?>><?= $country->name_english ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback js-field-error">
                                Required field
                            </div>
                        </div>
                    </div>


                    <div class="form-field col col-6  is-required js-field js__textinput js__component-of-form" data-type="text">
                        <label for="zip_code" class="form-label form-field__title">ZIP / Postal code*</label>
                        <div class="form-field__input-wrap">
                            <input class="form-field__input js-field-input form-control" id="zip_code" validateOnBlur=""
                                type="text" name="zip_code" value="<?= $user->zip_code ?>" placeholder="" />
                        </div>
                        <span class="form-field__error js-field-error">Required field</span>
                    </div>

                    <div class="col col-6">
                        <div class="component__dropdown2 profile__state js__profile-form-state is-required js__component-of-form"
                            data-search="false">
                            <label for="district" class="form-label">State / Province*
                            </label>
                            <select id="district" class="form-select js__select2 w-100" name="district" placeholder="Select"
                                data-placeholder="Select">
                                <option value="">Select</option>
                                <?php
                                $option_list = [];
                                if ($user->country_a2code == 'US') $option_list = $select['states'];
                                if ($user->country_a2code == 'CA') $option_list = $select['provinces'];

                                foreach ($option_list as $option):
                                ?>
                                    <option value="<?= $option->iso ?>" <?= ($option->iso == $user->district) ? 'selected="selected"' : '' ?>><?= $option->name_en ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback js-field-error">
                                Required field
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </section>

    <section class="profile--section profile__security">
        <div class="profile--section-header">
            <h2 class="profile--section-title">Security</h2>
        </div>
        <form action="account/updatepass" data-action="account/updatepass" method="POST" class="js__profile-form js--updatepass-action">
            <input type="hidden" data-from="password" name="id" id="user_id" value="<?= $user->id ?>" />
            <div class="profile--section-body">
                <div class="row">

                    <div class="form-field col col-4 profile_change-pass  is-required js-field js__textinput password"
                        data-type="password">
                        <label for="current_password" class="form-label form-field__title">Current Password</label>
                        <div class="form-field__input-wrap">
                            <input
                                class="form-field__input js-field-input form-control"
                                id="current_password"
                                type="password"
                                name="current_password"
                                required />

                            <button type="button" class="show-pass closed js-additional-btn" data-action="toggle"
                                data-classes="showed">
                                <svg class="icon icon-eye ">
                                    <use href="/assets/themes/default/icon/icons/icons.svg#eye" />
                                </svg>
                                <svg class="icon icon-eye-closed ">
                                    <use href="/assets/themes/default/icon/icons/icons.svg#eye-closed" />
                                </svg>
                            </button>
                        </div>
                        <span class="form-field__error js-field-error">Required field</span>
                    </div>

                    <div class="form-field col col-4 profile_change-pass  is-required js-field js__textinput password"
                        data-type="confirm_password">
                        <label for="password" class="form-label form-field__title">New Password</label>
                        <div class="form-field__input-wrap">
                            <input
                                class="form-field__input js-field-input form-control"
                                id="password"
                                type="password"
                                name="password"
                                required />

                            <button type="button" class="show-pass closed js-additional-btn" data-action="toggle"
                                data-classes="showed">
                                <svg class="icon icon-eye ">
                                    <use href="/assets/themes/default/icon/icons/icons.svg#eye" />
                                </svg>
                                <svg class="icon icon-eye-closed ">
                                    <use href="/assets/themes/default/icon/icons/icons.svg#eye-closed" />
                                </svg>
                            </button>
                        </div>
                        <span class="form-field__error js-field-error">Required field</span>
                    </div>

                    <div class="form-field col col-4 profile_change-pass  is-required js-field js__textinput password"
                        data-type="confirm_password">
                        <label for="confirm_password" class="form-label form-field__title">Confirm New Password</label>
                        <div class="form-field__input-wrap">
                            <input
                                class="form-field__input js-field-input form-control"
                                id="confirm_password"
                                type="password"
                                name="password_confirm"
                                required />

                            <button type="button" class="show-pass closed js-additional-btn" data-action="toggle"
                                data-classes="showed">
                                <svg class="icon icon-eye ">
                                    <use href="/assets/themes/default/icon/icons/icons.svg#eye" />
                                </svg>
                                <svg class="icon icon-eye-closed ">
                                    <use href="/assets/themes/default/icon/icons/icons.svg#eye-closed" />
                                </svg>
                            </button>
                        </div>
                        <span class="password-field__error js-password-error">Passwords don't match</span>
                        <span class="form-field__error js-field-error">Required field</span>
                    </div>
                </div>

                <div class="w-100 password-validation_list js__password-validation_list d-none">

                    <div class="password-validation_item js-validation-item" data-collection="password" data-validation="length">
                        <div class="password-validation_item-icon">
                            <svg class="icon icon-pass-novalid ">
                                <use href="/assets/themes/default/icon/icons/icons.svg#pass-novalid" />
                            </svg>
                            <svg class="icon icon-pass-valid ">
                                <use href="/assets/themes/default/icon/icons/icons.svg#pass-valid" />
                            </svg>
                        </div>
                        Be at least 8 characters long
                    </div>

                    <div class="password-validation_item js-validation-item" data-collection="password"
                        data-validation="uppercase">
                        <div class="password-validation_item-icon">
                            <svg class="icon icon-pass-novalid ">
                                <use href="/assets/themes/default/icon/icons/icons.svg#pass-novalid" />
                            </svg>
                            <svg class="icon icon-pass-valid ">
                                <use href="/assets/themes/default/icon/icons/icons.svg#pass-valid" />
                            </svg>
                        </div>
                        Contain at least one uppercase letter
                    </div>

                    <div class="password-validation_item js-validation-item" data-collection="password" data-validation="number">
                        <div class="password-validation_item-icon">
                            <svg class="icon icon-pass-novalid ">
                                <use href="/assets/themes/default/icon/icons/icons.svg#pass-novalid" />
                            </svg>
                            <svg class="icon icon-pass-valid ">
                                <use href="/assets/themes/default/icon/icons/icons.svg#pass-valid" />
                            </svg>
                        </div>
                        Contain at least 1 number
                    </div>

                </div>

            </div>
        </form>
    </section>

    <section class="profile--section profile__pass-period">
        <form action="account/profile" data-action="account/profile" method="POST" class="js__profile-form js--profile-action">
            <div class="d-flex justify-content-between align-items-center profile--section-body">
                <div>
                    <div class="form-check form-switch js__profile-form-passperiod-checkbox d-flex align-items-center gap-3">
                        <input class="form-check-input" name="profile_passperiod_enable" type="checkbox" role="switch" id="profile_passperiod-input" <?= !empty($user->password_change_frequency) ? 'checked="checked"' : '' ?>>
                        <label class="form-check-label" for="profile_passperiod-input">Require periodic password changes
                            with reminder emails for security:</label>
                    </div>
                </div>

                <div class="profile__pass-period-select-wrap">
                    <div class="component__dropdown2 profile__country js__profile-form-passperiod is-required <?= !empty($user->password_change_frequency) ? '' : 'disabled' ?>"
                        data-search="false">
                        <select id="passPeriod" class="form-select js__select2 w-100" name="pass_period" placeholder="Select"
                            <?= !empty($user->password_change_frequency) ? '' : 'disabled="disabled"' ?>
                            data-placeholder="Select">
                            <option value="">Select</option>
                            <?php $option_list = [
                                "1 months" => 'Every month',
                                "3 months" => 'Every 3 months',
                                "6 months" => 'Every 6 months',
                                "12 months" => 'Every 12 months',
                            ];
                            foreach ($option_list as $value => $title):
                            ?>
                                <option value="<?= $value ?>" <?= ($value == $user->password_change_frequency) ? 'selected="selected"' : '' ?>><?= $title ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback js-field-error">
                            Required field
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <section class="profile--section profile__my-notifications">
        <div class="profile--section-header">
            <h2 class="profile--section-title">My Notifications</h2>
        </div>
        <form action="account/profile" data-action="account/profile" method="POST" class="js__profile-form js--profile-action">
            <div class="d-flex justify-content-between align-items-center profile--section-body">
                <div>Permanently delete notifications older than:</div>
                <div class="profile__my-notifications-select-wrap">
                    <div class="component__dropdown2 profile__delete-notification is-required " data-search="false">
                        <select id="deleteNotification" class="form-select js__select2 w-100" name="exclude_notifications_from_header" placeholder="Select"
                            data-placeholder="Select">
                            <option value="">Select</option>
                            <?php $option_list = [
                                "1 months" => 'Every month',
                                "3 months" => 'Every 3 months',
                                "6 months" => 'Every 6 months',
                                "12 months" => 'Every 12 months',
                            ];
                            foreach ($option_list as $value => $title):
                            ?>
                                <option value="<?= $value ?>" <?= ($value == $user->permanently_delete_notifications_older_than) ? 'selected="selected"' : '' ?>><?= $title ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback js-field-error">
                            Required field
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <div class="d-flex justify-content-end">
        <button id="jsProfileSendAllForms" type="submit" class="btn btn-primary mt-3">Save</button>
    </div>

</div>

<?= $this->setData(['jobTitles' => $select['job_titles']])->include('parts/modals/edit-job-title_offcanvas') ?>

<style>
    .errors {
        color: #DE5465;
        font-size: 14px;
    }

    .errors p {
        margin-bottom: 0px;
    }

    .savesuccsess {
        color: #2e7200;
        font-size: 14px;
    }

    .dropzone {
        width: 100%;
    }

    .js-account-input-file,
    .dz-preview {
        display: none;
    }
</style>

<!-- dropzone Plugins js -->
<script src="<?= base_url() ?>/assets/libs/dropzone/dropzone.js"></script>

<?= $this->section('extra-js') ?>
<script>
    const statesGlobal = [
        <?php foreach ($select['states'] as $state): ?> {
                id: '<?= $state->iso ?>',
                text: '<?= $state->name_en ?>'
            },
        <?php endforeach; ?>
    ];
    const provincesGlobal = [
        <?php foreach ($select['provinces'] as $province): ?> {
                id: '<?= $province->iso ?>',
                text: '<?= $province->name_en ?>'
            },
        <?php endforeach; ?>
    ];

    let dropzoneLoaderProfileAvatar = new Dropzone("div#dropzoneLoaderProfileAvatar", {
        // Dropzone params
        paramName: 'avatar',
        url: "/account/update-photo",
        headers: {
            'X-CSRF-Token': $('meta[name="csrf_token"]').attr('content')
        },

        // The setting up of the dropzone
        init: function() {
            this.on('error', function(file, response) {
                $("#profilePhotoResult").removeClass('savesuccsess').addClass('errors').text(response);
                console.log('error');
            });
            this.on('complete', function(file) {
                console.log('complete my avatar');
                user_id = $('#user_id').val();
                console.log(file.status);
                if (file.status === 'success') {
                    // Update user photo
                    $(".js__profile-current-avatar").attr('src', '<?= url_to('user_avatar') ?>/' + <?= $user->id ?> + '?width=150&height=150');
                    $(".js__global-header-avatar").attr('src', '<?= url_to('user_avatar') ?>/' + <?= $user->id ?> + '?width=30&height=30');
                    $(".account-sidebar__heading-profile__img").attr('src', '<?= url_to('user_avatar') ?>/' + <?= $user->id ?> + '?width=150&height=150');
                    $("#profilePhotoResult").removeClass('errors').addClass('savesuccsess').text('Photo updated');
                    setTimeout(() => {
                        this.removeFile(file);
                        $("#profilePhotoResult").text('');
                    }, 5000);
                }

            });
        }
    });
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>