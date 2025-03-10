<ul class="users-searches__user-search-list">

    <?php
    foreach ($users_list as $userItem):
    ?>

        <li class="user-search-item js__users-searches-user-item"
            data-name="<?= $userItem->first_name . ' ' . $userItem->last_name ?>"
            data-id="<?= $userItem->id ?>">
            <div class="user-search-item__button">
                <div class="user-search-item__first-col">
                    <div class="user-search-item__initials">
                        <img class="user-avatar" src="<?= user_avatar($userItem->id, 45, 45); ?>" />
                        <?php strtolower(substr($userItem->first_name, 0, 1)) . strtolower(substr($userItem->last_name, 0, 1)) ?>
                        <!-- TODO -->
                        <!--<picture class="user__image">
                            <source srcset="./img/content/users/user-1.webp" type="image/webp" class="user__img ">
                            <img src="./img/content/users/user-1.png" alt="img" class="user__img " width="44"
                                height="44">
                        </picture>-->
                    </div>
                    <div>
                        <p>
                            <b><?= $userItem->first_name . ' ' . $userItem->last_name ?></b>
                            <?php if (!empty($userItem->employee_id)):  ?><span class="user-search-item__employee">ID: <?= $userItem->employee_id ?></span><?php endif; ?></p>
                        <p><?= $userItem->email ?></p>
                    </div>
                </div>

                <div class="user-search-item__second-col">
                    <p>
                        <b><?= $userItem->job_title ?></b>
                    </p>
                    <p>
                        <?= $userItem->company_name_full ?>
                    </p>
                </div>
            </div>
        </li>

    <?php endforeach; ?>

</ul>