<?= $this->extend('template/layout') ?>
<?= $this->section('content') ?>

<?= $this->section('extra-css') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    /* Add any custom styles specific to the user management page here */
</style>
<?= $this->endSection() ?>

<?php
$user = auth()->user();
?>
<section class="user-management transactions" id="userManagementPage">

    <div class="users-heading">
        <div class="d-flex align-items-center justify-content-between pb-2">
            <h1 class="mb-0">User Management</h1>
            <p class="fw-medium fs-16"><span id="total-results">0</span> Results</p>
        </div>

        <div class="d-flex align-items-center justify-content-between my-3">

            <div class="component__dropdown2 users-filter__status " data-search="false">
                <select
                    id="usersFilterStatus"
                    class="form-select js__select2 w-100"
                    name="status"
                    placeholder="All Users"
                    data-placeholder="All Users">
                    <option value="all">All Users</option>
                    <option data-color="#088C5E" value="registered">Registered</option>
                    <option data-color="#148BDF" value="invited">Invited</option>
                    <option data-color="#8D939F" value="suspended">Suspended</option>
                </select>
            </div>

            <button class="btn filter-btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter">
                <svg class="icon icon-filter-icon ">
                    <use href="/assets/themes/default/icon/icons/icons.svg#filter-icon" />
                </svg>
                Filters
            </button>

            <div class="users-searches">
                <div class="search-field users-searches__user-search">
                    <input class="form-control js__users-searches-user" name="usersSearchesSearchUsers"
                        id="usersSearchesSearchUsers" type="search" placeholder="User Name, ID or Email" />

                    <svg class="icon icon-search ">
                        <use href="/assets/themes/default/assets/icon/icons/icons.svg#search" />
                    </svg>


                </div>
                <input id="usersSearchesSearchUsersByNameEmail" class="js__users-searches-user-input" type="hidden"
                    name="seach user">

                <div data-url="/user-management/search-user"
                    class="users-searches__user-search-list-wrap js__users-searches-user-list _hidden">
                    <div>
                    </div>
                </div>

                <button id="usersSearchSubmit" class="btn btn-primary users-searches__search-btn">
                    <svg class="users-searches__search-btn--default" width="21" height="21" viewBox="0 0 21 21"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M19.0977 19.1875L15.5978 15.6875M18.0977 9.6875C18.0977 14.3819 14.2921 18.1875 9.59766 18.1875C4.90324 18.1875 1.09766 14.3819 1.09766 9.6875C1.09766 4.99308 4.90324 1.1875 9.59766 1.1875C14.2921 1.1875 18.0977 4.99308 18.0977 9.6875Z"
                            stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <svg class="users-searches__search-btn--hover" width="21" height="21" viewBox="0 0 21 21" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M19.0977 19.1875L15.5978 15.6875M18.0977 9.6875C18.0977 14.3819 14.2921 18.1875 9.59766 18.1875C4.90324 18.1875 1.09766 14.3819 1.09766 9.6875C1.09766 4.99308 4.90324 1.1875 9.59766 1.1875C14.2921 1.1875 18.0977 4.99308 18.0977 9.6875Z"
                            stroke="#148BDF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>

            <div class="dropdown ">
                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Actions
                    <svg class="icon icon-arrow-select ">
                        <use href="/assets/themes/default/icon/icons/icons.svg#arrow-select" />
                    </svg>
                </button>
                <ul class="dropdown-menu">
                    <li class="dropdown-item">
                        <a href="#" id="suspend-users">
                            <span class="fw-medium">Suspend Selection</span>
                            <p>Disables a user's access by removing their active status from the list</p>
                        </a>
                    </li>
                    <li class="dropdown-item">
                    <?php // TODO disabled status! ?>
                    <a href="#" class="todo-disabled" id="reactivate-users">
                        <span class="fw-medium">Reactivate Selection</span>
                        <p>Reactivates a user's access by restoring their active status in the list</p>
                    </a>
                    </li>
                </ul>
            </div>

            <button class="btn download-btn users-heading__svg-download jsAddon__tooltip" data-tippy-content="Download table as .csv" type="button">
                <svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M7.16602 14.7917L10.9993 18.625M10.9993 18.625L14.8327 14.7917M10.9993 18.625V10M18.666 14.5452C19.8366 13.5785 20.5827 12.1159 20.5827 10.4792C20.5827 7.56817 18.2228 5.20833 15.3118 5.20833C15.1024 5.20833 14.9065 5.09908 14.8002 4.91867C13.5505 2.79797 11.2432 1.375 8.60352 1.375C4.63397 1.375 1.41602 4.59295 1.41602 8.5625C1.41602 10.5425 2.21665 12.3355 3.51184 13.6355"
                    stroke="#148BDF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>

            <button class="btn btn-primary invite-btn users-heading__user-invite-btn"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#invite_users_sidebar"
                aria-controls="offcanvasRight">
                <svg width="11" height="10" viewBox="0 0 11 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.50065 1.21094V8.79427M1.70898 5.0026H9.29232" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span>Invite Users</span>
            </button>
        </div>

        <div class="collapse" id="collapseFilter">
            <div class="users-filters__tab js__users-filters-tab">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4>Choose filters below to customize table view</h4>
                    <div>
                        <button class="btn-link me-3 js__users-filters__reset">Reset All</button>
                        <button class="btn-close" type="button" data-bs-target="#collapseFilter" data-bs-toggle="collapse"></button>
                    </div>
                </div>

                <?= $this->setData(['filter_data' => $filter_data])->include('UserManagement/filters') ?>

            </div>
        </div>
    </div>

    <div class="list-content" id="ListContent">
        <div>
            <?= $this->setData(['users' => $users, 'pager' => $pager])->include('UserManagement/list_table') ?>
        </div>
    </div>
</section>

<?= $this->section('offcanvas') ?>
<div id="SectionOffcanvas">
    <?= $this->setData(['users' => $users])->include('UserManagement/user_offcanvas') ?>
</div>
<!-- Edit User Details Offcanvas -->
<?= $this->setData(['user' => $new_user, 'select' => $jobTitles, 'offcanvas_wrap' => true])->include('UserManagement/_edit-user-offcanvas') ?>
<!-- Invite User -->
<?= $this->setData(['last_users' => $users,])->include('UserManagement/invite_users') ?>
<!-- job Titles -->
<?= $this->setData(['jobTitles' => $jobTitles])->include('parts/modals/edit-job-title_offcanvas') ?>

<?= $this->endSection() ?>

<?= $this->section('extra-js') ?>
<script>

</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>