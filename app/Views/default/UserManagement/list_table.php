<style>
    span.tip-status {
        width: 10px;
        height: 10px;
        border-radius: 100%;
        background-color: #088c5e;
        display: inline-block;
        border: 1px solid #fff;
        display: block;
        float: left;
        margin: 5px 5px 0 0;
    }
    span.tip-status.invited{
        background-color: #148bdf;
    }
    span.tip-status.suspended{
        background-color: #8d939f;
    }
</style>
<?php
//d($users);
if (!empty($users)): ?>
    <div class="table-responsive users">
        <table class="table">
            <thead>
                <tr>
                    <th>
                        <input name="select-all" id="select-all" class="form-check-input" type="checkbox" value="">
                    </th>
                    <th scope="col">
                        Name/Status
                        <svg class="icon icon-info-circle jsAddon__tooltip" data-tippy-content="
                        <span class='tip-status registered'></span><b>Registered:</b> user granted system access.<br/>
                        <span class='tip-status invited'></span><b>Invited:</b> pending user registration.<br/>
                        <span class='tip-status suspended'></span><b>Suspended:</b> user access blocked, can be reactivated by an Administrator." >
                            <use href="/assets/themes/default/icon/icons/icons.svg#info-circle" />
                        </svg>
                        <button type="button" class="table-btn">
                            <svg class="icon icon-arrows-sort">
                                <use href="/assets/themes/default/icon/icons/icons.svg#arrows-sort" />
                            </svg>
                        </button>
                    </th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">
                        Role
                        <button type="button" class="table-btn">
                            <svg class="icon icon-arrows-sort">
                                <use href="/assets/themes/default/icon/icons/icons.svg#arrows-sort" />
                            </svg>
                        </button>
                    </th>
                    <th scope="col">
                        Job Title
                        <button type="button" class="table-btn">
                            <svg class="icon icon-arrows-sort">
                                <use href="/assets/themes/default/icon/icons/icons.svg#arrows-sort" />
                            </svg>
                        </button>
                    </th>
                    <th scope="col">
                        Last Sign-In
                        <button type="button" class="table-btn">
                            <svg class="icon icon-arrows-sort">
                                <use href="/assets/themes/default/icon/icons/icons.svg#arrows-sort" />
                            </svg>
                        </button>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><input name="user" class="form-check-input user" type="checkbox" value="<?= $user->id ?>" id="user_<?= $user->id ?>"></td>
                        <td data-bs-toggle="offcanvas" data-bs-target="#user-details-<?= $user->id ?>" aria-controls="offcanvasRight">
                            <span class="<?= strtolower($user->user_status) ?>"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="sidebar-tooltip" data-bs-title="<?= $user->user_status ?>"></span>
                            <picture class="user__image">
                                <!-- <source srcset="<?= user_avatar($user->id, 44, 44); ?>" type="image/webp" class="user__img" /> -->
                                <img src="<?= user_avatar($user->id, 44, 44); ?>" alt="user-avatar" 
                                    class="user__img" width="44" height="44" style="border-radius:50%" />
                            </picture>
                            <?= $user->first_name ?> <?= $user->last_name ?>
                        </td>
                        <td data-bs-toggle="offcanvas" data-bs-target="#user-details-<?= $user->id ?>" aria-controls="offcanvasRight">
                            <?= $user->email ?>
                        </td>
                        <td data-bs-toggle="offcanvas" data-bs-target="#user-details-<?= $user->id ?>" aria-controls="offcanvasRight">
                            <?= $user->phone_number ?>
                        </td>
                        <td data-bs-toggle="offcanvas" data-bs-target="#user-details-<?= $user->id ?>" aria-controls="offcanvasRight" class="bordered">
                            <span><?= ucfirst($user->group_name) ?></span>
                        </td>
                        <td data-bs-toggle="offcanvas" data-bs-target="#user-details-<?= $user->id ?>" aria-controls="offcanvasRight">
                            <?= $user->job_title ?? '—' ?>
                        </td>
                        <td data-bs-toggle="offcanvas" data-bs-target="#user-details-<?= $user->id ?>" aria-controls="offcanvasRight">
                            <?= !empty($user->last_login) ? format_date($user->last_login, 'date') : '—' ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <nav aria-label="pagination" class="pagination-wrapper">
        <?= $pager->links() ?>
        <div class="pagination-info">
            <?php
            $total = $pager->getTotal();
            $perPage = $pager->getPerPage();
            $currentPage = $pager->getCurrentPage();
            $start = ($currentPage - 1) * $perPage + 1;
            $end = min($total, $currentPage * $perPage);
            ?>
            Showing <span class="active-items"><?= $start ?> - <?= $end ?></span>
            of <span class="pagination-total"><?= $total ?></span>
        </div>
    </nav>
<?php else: ?>
    <div class="empty-table mt-5">
        <svg class="icon icon-info-circle ">
            <use href="/assets/themes/default/icon/icons/icons.svg#info-circle"></use>
        </svg>
        <h3>
            There are no users at the moment.
        </h3>
    </div>
<?php endif; ?>