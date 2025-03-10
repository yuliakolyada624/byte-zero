<?php if (!empty($users)): ?>
    <?php foreach ($users as $user): ?>
        <div class="offcanvas persolnal-info offcanvas-end" tabindex="-1" id="user-details-<?= $user->id ?>" aria-labelledby="offcanvasRightLabel">
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
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h3 class="mb-0">Personal Information</h3>
                    <?php if($user->id != auth()->user()->id): ?>
                        <button class="btn edit js__load-edit-user-offcanvas" type="button" data-bs-toggle="offcanvas" data-bs-return="#user-details-<?= $user->id ?>" data-url="/user-management/edit-user-offcanvas" data-uid="<?= $user->id ?>" data-bs-target="#offcanvasEditUserDetails" aria-controls="offcanvasEditUser">Edit Details</button>
                    <?php else: ?>
                        <a href="<?= base_url('account/profile') ?>" class="btn edit" type="button">Edit Details</a>
                    <?php endif; ?>
                </div>
                <div class="card bg-main-light border-0 p-4 mb-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="me-3 position-relative">
                                <span class="status <?= strtolower($user->user_status) ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="sidebar-tooltip" data-bs-title="<?= $user->user_status ?>"></span>

                                <picture class="photo__image">
                                    <img src="<?= user_avatar($user->id, 52, 52); ?>" alt="Profile Image" class="photo__img " width="52" height="52" />
                                </picture>
                            </div>
                            <div>
                                <h2><?= htmlspecialchars($user->first_name) ?> <?= htmlspecialchars($user->last_name) ?></h2>
                                <span class="email"><?= htmlspecialchars($user->email) ?></span>
                            </div>
                        </div>
                        <div>
                            <span class="role"><?= htmlspecialchars($user->group_name) ?></span>
                        </div>
                    </div>
                    <hr>
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td>Work number, extension:</td>
                                <td class="text-end fw-semibold"><img src="/assets/themes/default/svg/flags/<?= strtolower($user->phone_number_country) ?>.svg" alt="<?= strtolower($user->phone_number_country) ?>" class="phone-icon"> <?= htmlspecialchars($user->phone_number) ?></td>
                            </tr>
                            <tr>
                                <td>Mobile number:</td>
                                <td class="text-end fw-semibold"><img src="/assets/themes/default/svg/flags/<?= strtolower($user->work_phone_number_country) ?>.svg" alt="<?= strtolower($user->work_phone_number_country) ?>" class="phone-icon"> <?= htmlspecialchars($user->work_phone_number) ?></td>
                            </tr>
                            <tr>
                                <td>Employee ID:</td>
                                <td class="text-end fw-semibold"><?= htmlspecialchars($user->employee_id ?? '-') ?></td>
                            </tr>
                            <tr>
                                <td>Job title:</td>
                                <td class="text-end fw-semibold"><?= htmlspecialchars($user->job_title ?? '-') ?></td>
                            </tr>
                            <tr>
                                <td>Office:</td>
                                <td class="text-end fw-semibold"><?= htmlspecialchars($user->office_name ?? '—') ?></td>
                            </tr>
                            <tr>
                                <td>Last password update:</td>
                                <td class="text-end fw-semibold"><?= format_date($user->last_password_update, 'date') ?></td>
                            </tr>
                            <tr>
                                <td>Password change frequency:</td>
                                <td class="text-end fw-semibold"><?= htmlspecialchars($user->password_change_frequency) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <h3 class="mb-3">My Cases</h3>
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td>Bodily Injury:</td>
                            <td class="text-end fw-semibold d-flex align-items-center justify-content-end gap-2">
                                <?php
                                $number_of_cases = $user->getUserCasesCount('bodily_injury');
                                ?>
                                <?= $number_of_cases ?>
                                <span class="separator"> | </span>
                                <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="sidebar-tooltip" data-bs-title="View Case List">
                                    <a href="/orders/cases?ordered_by=<?= $user->id ?>&current_tab=bodyInjury" class="btn btn-link <?= empty($number_of_cases) ? 'disabled empty' : '' ?>" type="button" aria-label="">
                                        <svg class="icon icon-document">
                                            <use href="/assets/themes/default/icon/icons/icons.svg#document"></use>
                                        </svg>
                                    </a>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Disability Claim:</td>
                            <td class="text-end fw-semibold d-flex align-items-center justify-content-end gap-2">
                                <?php
                                $number_of_cases = $user->getUserCasesCount('disability_claim');
                                ?>
                                <?= $number_of_cases ?>
                                <span class="separator"> | </span>
                                <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="sidebar-tooltip" data-bs-title="View Case List">
                                    <a href="/orders/cases?ordered_by=<?= $user->id ?>&current_tab=disabilityClaim" class=" btn btn-link <?= empty($number_of_cases) ? 'disabled empty' : '' ?>" type="button" aria-label="">
                                        <svg class="icon icon-document">
                                            <use href="/assets/themes/default/icon/icons/icons.svg#document"></use>
                                        </svg>
                                    </a>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Medical Malpractice:</td>
                            <td class="text-end fw-semibold d-flex align-items-center justify-content-end gap-2">
                                <?php
                                $number_of_cases = $user->getUserCasesCount('nursing_home_negligence');
                                ?>
                                <?= $number_of_cases ?>
                                <span class="separator"> | </span>
                                <a href="/orders/cases?ordered_by=<?= $user->id ?>&current_tab=medicalMalpractice" class=" btn btn-link <?= empty($number_of_cases) ? 'disabled empty' : '' ?>" type="button" aria-label="">
                                    <svg class="icon icon-document">
                                        <use href="/assets/themes/default/icon/icons/icons.svg#document"></use>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Workers' Compensation:</td>
                            <td class="text-end fw-semibold d-flex align-items-center justify-content-end gap-2">
                                <?php
                                $number_of_cases = $user->getUserCasesCount('workers_compensation');
                                ?>
                                <?= $number_of_cases ?>
                                <span class="separator"> | </span>
                                <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="sidebar-tooltip" data-bs-title="View Case List">
                                    <a href="/orders/cases?ordered_by=<?= $user->id ?>&current_tab=workersCompensation" class=" btn btn-link <?= empty($number_of_cases) ? 'disabled empty' : '' ?>" type="button" aria-label="">
                                        <svg class="icon icon-document">
                                            <use href="/assets/themes/default/icon/icons/icons.svg#document"></use>
                                        </svg>
                                    </a>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <hr class="mt-4 mb-4">
                <h3 class="mb-3">Activities</h3>
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td>Last login:</td>
                            <td class="text-end fw-semibold d-flex align-items-center justify-content-end gap-2">
                                <?= format_date($user->last_login, 'date') ?><span class="separator"> | </span><?= format_date($user->last_login, 'time') ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Last updated:</td>
                            <td class="text-end fw-semibold d-flex align-items-center justify-content-end gap-2">
                                <?= format_date($user->last_updated, 'date') ?><span class="separator"> | </span><?= format_date($user->last_updated, 'time') ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Registered on:</td>
                            <td class="text-end fw-semibold d-flex align-items-center justify-content-end gap-2">
                                <?= format_date($user->registered_on, 'date') ?><span class="separator"> | </span><?= format_date($user->registered_on, 'time') ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
