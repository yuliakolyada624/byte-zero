<?php
$currentUser = auth()->user();
$domain = $currentUser->getUserCompanyDomain();
?>
<?php if ($offcanvas_wrap): ?>
    <div class="offcanvas edit-user-details__offcanvas offcanvas-end" tabindex="-1" id="offcanvasEditUserDetails"
        aria-labelledby="offcanvasRightLabel">

        <div class="offcanvas-header">
            <h3 class="offcanvas-title" id="offcanvasRightLabel">
                <button type="button" data-bs-dismiss="offcanvas" aria-label="Close">
                    <svg class="icon icon-arrow ">
                        <use href="/assets/themes/default/icon/icons/icons.svg#arrow" />
                    </svg>
                </button>
                Back
            </h3>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
    <?php endif ?>
    <div id="offcanvasEditUserDetailsBody" class="offcanvas-body">
        <h1 class="mb-1">Edit Personal Information</h1>
        <form action="" data-canvas="#user-details-<?= $user->id ?>" data-action="<?= base_url('user-management/user-update') ?>" class="offcanvas__edit-user-from">

            <div class="card bg-main-light border-0 p-4 mb-4 mt-4">
                <div class="row">

                    <div class="form-field col col-6 js__component-of-form  is-required js-field js__textinput " data-type="text">
                        <label for="first_name" class="form-label form-field__title">First Name*</label>
                        <div class="form-field__input-wrap">
                            <input id="userEditOffcanvasUserId" type="hidden" name="user_id" value="<?= $user->id ?>">
                            <input class="form-field__input js-field-input form-control" id="userEditOffcanvasFistName" validateOnBlur="true"
                                type="text" name="first_name" value="<?= $user->first_name ?>" placeholder="" />
                        </div>
                        <span class="form-field__error js-field-error">Valid company name required</span>
                    </div>

                    <div class="form-field col col-6 js__component-of-form  is-required js-field js__textinput " data-type="text">
                        <label for="last_name" class="form-label form-field__title">Last Name*</label>
                        <div class="form-field__input-wrap">
                            <input class="form-field__input js-field-input form-control" id="userEditOffcanvasLastName" validateOnBlur="true"
                                type="text" name="last_name" value="<?= $user->last_name ?>" placeholder="" />
                        </div>
                        <span class="form-field__error js-field-error">Required field</span>
                    </div>

                    <div class="form-field col-12 js__component-of-form  is-required js-field js__textinput" data-type="">
                        <label for="email" class="form-label form-field__title">Work Email*</label>
                        <div class="input-email__wrapper">
                            <input class="form-field__input js-field-input form-control" id="userEditOffcanvasEmail" type="email" name="email"
                                value="<?= str_replace('@' . $domain, '', $user->email)  ?>" placeholder="" data-email="@<?= $domain ?>" />
                            <span class="input-email__holder">@<?= $domain ?></span>
                        </div>

                        <span class="form-field__error js-field-error">Required field</span>

                    </div>

                    <div class="col col-12">


                        <div class="component__dropdown2 col-12 js__component-of-form is-required " data-search="false">
                            <label for="userEditOffcanvasRole" class="form-label">Role*
                            </label>
                            <select id="userEditOffcanvasRole" class="form-select js__select2 w-100" name="service_industry"
                                placeholder="Select" data-placeholder="Select">
                                <option value="">Select</option>
                                <option value="admin" <?= (is_array($user->groups) && !empty($user->groups[0]) && $user->groups[0] == "admin") ? 'selected="selected"' : '' ?>>Administrator</option>
                                <option value="assignee" <?= (is_array($user->groups) && !empty($user->groups[0]) && $user->groups[0] == "assignee") ? 'selected="selected"' : '' ?>>Assignee</option>
                            </select>
                            <div class="invalid-feedback js-field-error">
                                Required field
                            </div>
                        </div>
                    </div>
                    <div class="col col-6">
                        <div class="component__itidropdown col col-6 js__component-of-form is-required" data-type="phone">
                            <label for="userEditOffcanvasPhone" class="form-label">Work Phone Number, Ext.*</label>
                            <input class="form-control component__itidropdown-input js__itidropdown-input" id="userEditOffcanvasPhone"
                                type="phone" name="phone" value="<?= $user->work_phone_number ?>" autocomplete="off" placeholder="000-000-0000"
                                aria-describedby="userEditOffcanvasPhoneFeedback" data-placeholder="000-000-0000" data-country="">
                            <div id="userEditOffcanvasPhoneFeedback"
                                class="invalid-feedback component__itidropdown-error js-field-error">
                                Valid company phone required
                            </div>
                        </div>
                    </div>
                    <div class="col col-6">
                        <div class="component__itidropdown col col-6 js__component-of-form is-required" data-type="phone">
                            <label for="userEditOffcanvasMobilenumber" class="form-label">Mobile Phone Number*</label>
                            <input class="form-control component__itidropdown-input js__itidropdown-input"
                                id="userEditOffcanvasMobilenumber" type="phone" name="phone" value="<?= $user->phone_number ?>" autocomplete="off"
                                placeholder="000-000-0000" aria-describedby="userEditOffcanvasMobilenumberFeedback"
                                data-placeholder="000-000-0000" data-country="">
                            <div id="userEditOffcanvasMobilenumberFeedback"
                                class="invalid-feedback component__itidropdown-error js-field-error">
                                Valid company phone required
                            </div>
                        </div>
                    </div>

                    <div class="form-field col col-6 js__component-of-form   js-field js__textinput " data-type="text">
                        <label for="employee_id" class="form-label form-field__title">Employee ID</label>
                        <div class="form-field__input-wrap">
                            <input class="form-field__input js-field-input form-control" id="userEditOffcanvasEmployeeId" validateOnBlur="true"
                                type="text" name="employee_id" value="<?= $user->employee_id ?>" placeholder="" />
                        </div>
                    </div>
                    <div class="col col-6">


                        <div class="component__dropdown2 js__select-to-custom-add-job-title js__component-of-form is-required "
                            data-search="false">
                            <label for="userEditOffcanvasJobTitle" class="form-label">Job Title*
                                <button type="button" class="btn-link" data-bs-return="#offcanvasEditUserDetails"
                                    data-bs-toggle="offcanvas" data-bs-target="#EditJobTitle" aria-controls="offcanvasRight">
                                    Edit Options
                                </button>
                            </label>
                            <select id="userEditOffcanvasJobTitle" class="form-select js__select2 w-100" name="job_title"
                                placeholder="Select" data-placeholder="Select">
                                <option value="">Select</option>
                                <?php foreach ($select as $job_title): ?>
                                    <option value="<?= $job_title['job_title'] ?>" <?= ($job_title['job_title'] == $user->job_title) ? 'selected="selected"' : '' ?>><?= $job_title['job_title'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback js-field-error">
                                Required field
                            </div>
                        </div>
                    </div>

                    <div class="form-field col col-12 js__component-of-form  is-required js-field js__textinput "
                        data-type="text">
                        <label for="office_name" class="form-label form-field__title">Office Name*</label>
                        <div class="form-field__input-wrap">
                            <input class="form-field__input js-field-input form-control" id="userEditOffcanvasOfficeName" validateOnBlur="true"
                                type="text" name="office_name" value="<?= $user->office_name ?>" placeholder="" />
                        </div>
                        <span class="form-field__error js-field-error">Required field</span>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button class="btn <?=($user->user_status=='Invited' ? 'btn-secondary' : 'btn-primary')?> js-toast-btn js__edit-user-btn-submit" 
                        <?=($user->user_status=='Invited' ? 'disabled="disabled"' : '')?>
                        data-action="<?= base_url('user-management/user-update') ?>" type="button" aria-label="Save">
                    Save
                </button>
            </div>
        </form>
    </div>
    <?php if ($offcanvas_wrap): ?>
    </div>
<?php endif ?>