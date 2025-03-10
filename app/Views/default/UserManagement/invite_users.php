<?php
$currentUser = auth()->user();
$domain = $currentUser->getUserCompanyDomain();
$groups = config('AuthGroups')->invite_groups;
?>
<div class="offcanvas invite-users offcanvas-end" tabindex="-1" id="invite_users_sidebar" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h3 class="offcanvas-title" id="offcanvasRightLabel">
            <button type="button" data-bs-dismiss="offcanvas" aria-label="Close">
                <svg class="icon icon-arrow">
                    <use href="/assets/themes/default/icon/icons/icons.svg#arrow"></use>
                </svg>
            </button>
            Back
        </h3>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
        <h1 class="mb-1">Invite Users</h1>
        <p class="fs-16">Follow the steps below to invite colleagues.</p>

        <!-- Invite User Form -->
        <form id="inviteUserForm">
            <div class="card bg-main-light border-0 p-4 mb-4 mt-4 userInviteForm" id="userInviteForm_1">
                <div class="row">

                    <!-- First Name Field -->
                    <div class="form-field col-6 is-required">
                        <label for="firstName_1" class="form-label">First Name*</label>
                        <div class="form-field__input-wrap">
                            <input type="text" class="form-field__input form-control" id="firstName_1" name="first_name_1" placeholder="Enter first name" required>
                        </div>
                        <div class="invalid-feedback">
                            Required field
                        </div>
                        <span class="form-field__error">Required field</span>
                    </div>

                    <!-- Last Name Field -->
                    <div class="form-field col-6 is-required">
                        <label for="lastName_1" class="form-label">Last Name*</label>
                        <div class="form-field__input-wrap">
                            <input type="text" class="form-field__input form-control" id="lastName_1" name="last_name_1" placeholder="Enter last name" required>
                        </div>
                        <div class="invalid-feedback">
                            Required field
                        </div>
                        <span class="form-field__error">Required field</span>
                    </div>

                    <!-- Work Email Field -->
                    <div class="form-field col-12 is-required">
                        <label for="email_1" class="form-label">Work Email*</label>
                        <div class="input-email__wrapper">
                            <input type="email" class="form-field__input form-control" id="email_1" name="email_1" placeholder="Enter work email" required>
                            <span class="input-email__holder">@<?= $domain ?></span>
                        </div>
                        <div class="invalid-feedback">
                            Required field
                        </div>
                        <span class="form-field__error">Required field</span>
                    </div>

                    <!-- Role Selection -->
                    <div class="component__dropdown2 col-6 is-required">
                        <label for="role_1" class="form-label">Role*</label>
                        <select id="role_1" class="form-select js__select2 w-100" name="role_1" required>
                            <option value="" selected>Select</option>
                            <?php foreach ($groups as $key => $group): ?>
                                <option value="<?= $key ?>"><?= $group['title'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            Required field
                        </div>
                    </div>

                    <!-- Job Title Selection -->
                    <div class="component__dropdown2 col-6 is-required">
                        <label for="job-title" class="form-label">Job Title*
                            <button type="button" class="btn-link" data-bs-toggle="offcanvas" data-bs-target="#EditJobTitle" data-bs-return="#invite_users_sidebar" aria-controls="offcanvasRight">Edit Options</button>
                        </label>
                        <select id="jobTitleSelect_1" class="form-select js__select2 w-100" name="job_title_1" required>
                            <option value="" selected>Select</option>
                            <?php foreach ($jobTitles as $jobTitle): ?>
                                <option value="<?= $jobTitle['job_title'] ?>"><?= $jobTitle['job_title'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            Required field
                        </div>
                    </div>
                </div>

                <button class="btn btn-link delete d-none" type="button" aria-label="Delete Invitee">
                    <svg class="icon icon-delete ">
                        <use href="/assets/themes/default/icon/icons/icons.svg#delete" />
                    </svg>
                    <span>Delete Invitee</span>
                </button>
            </div>

            <!-- Add Additional User and Submit -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="d-flex align-items-center">
                    <a href="#" id="invite_additional" class="text-primary">+ Invite additional user</a>
                    <p class="ms-2">(Limit of 10 invites at a time)</p>
                </div>
                <button type="submit" class="btn btn-primary" id="inviteUsersBtn">Invite Users</button>
            </div>
        </form>

        <!-- Registered and Invited Users -->
        <div class="card bg-main-light border-0 p-4 mb-4 mt-5">
            <div class="d-flex align-items-center justify-content-between">
                <h3>Last 10 Registered Users</h3>
                <ul class="nav nav-tabs" id="userTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="registered-tab" data-bs-toggle="tab"
                            data-bs-target="#registeredUsers" type="button" role="tab" aria-controls="registeredUsers"
                            aria-selected="true">Registered Users <span class="counter">0</span></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="invited-tab" data-bs-toggle="tab" data-bs-target="#invitedUsers" type="button" role="tab" aria-controls="invitedUsers" aria-selected="false">Invited Users <span class="counter">0</span></button>
                    </li>
                </ul>
            </div>

            <!-- Tab Content -->
            <div class="tab-content" id="userTabContent">
                <!-- Registered Users Tab -->
                <div class="tab-pane fade show active" id="registeredUsers" role="tabpanel" aria-labelledby="registered-tab">
                    <div id="registeredUsersList">
                        <p class="text-muted">No registered users available at the moment.</p>
                    </div>
                </div>

                <!-- Invited Users Tab -->
                <div class="tab-pane fade" id="invitedUsers" role="tabpanel" aria-labelledby="invited-tab">
                    <div id="invitedUsersList">
                        <p class="text-muted">No invited users available at the moment.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?= $this->section('extra-js') ?>
<script>
</script>
<?= $this->endSection() ?>