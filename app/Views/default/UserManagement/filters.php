<div class="users-filters__body">
    <div class="row users-filters__wrap">

        <div class="col col-4">
            <div class="component__dropdown2 users-filter__select-component " data-search="false">
                <label for="usersFilterRole" class="form-label">Role</label>
                <select id="usersFilterRole" class="form-select js__select2 w-100" name="role" placeholder="Select"
                    data-placeholder="Select">
                    <option value="">Select</option>
                    <option value="clear">Clear Selection</option>
                    <?php
                    $groups = config('AuthGroups')->groups; // invite_groups
                    ?>
                    <?php
                    foreach ($groups as $key => $group):
                    ?>
                        <option value="<?= $key ?>"><?= $group['title'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="col col-4">
            <div class="component__dropdown2 users-filter__select-component " data-search="false">
                <label for="usersFilterJob" class="form-label">Job title</label>
                <select id="usersFilterJob" class="form-select js__select2 w-100" name="job_title" placeholder="Select"
                    data-placeholder="Select">
                    <option value="">Select</option>
                    <option value="clear">Clear Selection</option>
                    <?php #TODO ?>
                    <option value="Attorney">Attorney</option>
                    <option value="Associate Attorney">Associate Attorney</option>
                    <option value="Senior Associate Attorney">Senior Associate Attorney</option>
                    <option value="Of Counsel">Of Counsel</option>
                    <option value="Paralegal">Paralegal</option>
                    <option value="Partner">Partner</option>
                    <option value="Senior Partner">Senior Partner</option>
                    <option value="Managing Partner">Managing Partner</option>
                    
                    <option value="other">Other</option>
                </select>
            </div>
        </div>

        <div class="col col-4">
            <div class="component__dropdown2 users-filter__select-component " data-search="true">
                <label for="usersFilterPlantiffName" class="form-label">Plaintiff Name</label>
                <select id="usersFilterPlantiffName" class="form-select js__select2 w-100" name="plaintiff_name"
                    placeholder="Select" data-placeholder="Select">
                    <option value="">Select</option>
                    <option value="clear">Clear Selection</option>
                    <?php foreach ($filter_data['plantiff_names'] as $plantiff): ?>
                        <option value="<?= $plantiff->id ?>"><?= $plantiff->plaintiff_first_name ?> <?= $plantiff->plaintiff_last_name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
</div>