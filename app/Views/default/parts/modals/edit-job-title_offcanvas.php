<div class="offcanvas job-title offcanvas-end" tabindex="-1" id="EditJobTitle" aria-labelledby="offcanvasRightLabel" style="width: 650px;">
    <div class="offcanvas-header">
        <h3 class="offcanvas-title" id="offcanvasRightLabel">
            <button type="button" data-bs-toggle="offcanvas" data-bs-target="#invite_users_sidebar" aria-controls="offcanvasRight">
                <svg class="icon icon-arrow">
                    <use href="/assets/themes/default/icon/icons/icons.svg#arrow" />
                </svg>
            </button>
            Back
        </h3>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <h1 class="mb-1">Edit Job Titles</h1>
        <p class="fs-16">Refer to the table below to modify options.</p>
        <div class="card bg-main-light border-0 p-4 mb-4 mt-4">
            <form>
                <div class="form-field col-12 js-field js__textinput" data-type="name">
                    <label for="jobTitleInput" class="form-label form-field__title">Enter Job Name</label>
                    <div class="form-field__input-wrap">
                        <input class="form-field__input js-field-input form-control" id="jobTitleInput" type="text" name="job_name" placeholder="Enter job name" />
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-link mt-3" id="addToList" type="button" aria-label="Add to List">
                        <span>Add to List</span>
                    </button>
                </div>
            </form>

            <!-- Job Titles List -->
            <div class="card p-3 mb-2 rounded-3 mt-4">
                <table class="table table-borderless mb-0">
                    <tbody id="jobTitleList">
                        <?php foreach ($jobTitles as $jobTitle): ?>
                            <tr id="job-list-item-<?=$jobTitle['id']?>">
                                <td><?= htmlspecialchars($jobTitle['job_title']) ?></td>
                                <td class="text-end">
                                    <?= $jobTitle['assigned_users'] == 0 ? 'unassigned' : $jobTitle['assigned_users'] . ' users assigned' ?>
                                    <?php if ($jobTitle['locked']): ?>
                                        <button class="ms-2" type="button" data-bs-toggle="tooltip" 
                                                data-bs-placement="top" data-bs-custom-class="sidebar-tooltip" 
                                                data-bs-title="<?=($jobTitle['company_id']==0 ? 'System job title cannot be deleted' : 'Job title cannot be deleted')?>">
                                            <svg class="icon icon-block">
                                                <use href="/assets/themes/default/icon/icons/icons.svg#block" />
                                            </svg>
                                        </button>
                                    <?php else: ?>
                                        <button class="ms-2 delete-job-title" type="button" data-bs-target="#deleteJobTitle" data-bs-toggle="modal" 
                                            data-job-title="<?= htmlspecialchars($jobTitle['job_title']) ?>" 
                                            data-id="<?= $jobTitle['id'] ?>">
                                            <svg class="icon icon-delete">
                                                <use href="/assets/themes/default/icon/icons/icons.svg#delete" />
                                            </svg>
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteJobTitle" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content align-items-center">
            <svg class="icon icon-exclamation-mark ">
                <use href="/assets/themes/default/icon/icons/icons.svg#exclamation-mark" />
            </svg>
            <div class="modal-header">
                <h1 class="modal-title" id="staticBackdropLabel">Delete Job Title</h1>
            </div>
            <div class="modal-body text-center">
                Please verify that you wish to permanently delete <br />
                <span id="jobTitleName">-</span> from your list.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="confirmDelete">Confirm</button>
                <button type="button" class="btn cancel" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
