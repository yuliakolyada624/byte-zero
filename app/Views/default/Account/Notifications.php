<?= $this->extend('Account/Account') ?>
<?= $this->section('account-content') ?>
<div class="account-content__notifications js-filter-section">
  <div class="account-content__notifications__title-wrap">
    <h3 class="account-content__main-title account-content__notifications__title">Notifications (<?=$pager->getTotal()?>)</h3>
    <div class="account-content__notifications__title-new"><?
    helper('App\Modules\Notifications\Helpers\notifications');
    echo getUnreadNotification();
    ?> New</div>
  </div>
  <?php 
    //d($NotificationsList);
    d($NotificationsList);
  //  d($pager);
    ?>
  <div class="account-content__notifications__nav">
    <div class="account-content__notifications__nav-btns-sort">
      <div class="account-content__notifications__nav-btns-sort__btn-wrap">
        <button class="account-content__dropdown-btn js-account__filter-btn" type="button" data-status="message">Messages (All)
          <svg class="icon icon-arrow-down fill">
            <use href="/assets/themes/default/assets/icon/icons/icons.svg#arrow-down"></use>
          </svg>
        </button>
        <ul class="js-account__filter-list account-content__notifications__nav-btns-sort__dropdown-list" data-from="message">
          <li class="account-content__notifications__nav-btns-sort__dropdown-item">
            <button class="account-content__notifications__nav-btns-sort__dropdown-btn js-account__dropdown-filter-btn" type="button" data-filter="all" data-from="message">All</button>
          </li>
          <li class="account-content__notifications__nav-btns-sort__dropdown-item">
            <button class="account-content__notifications__nav-btns-sort__dropdown-btn js-account__dropdown-filter-btn" type="button" data-filter="unread" data-from="message">New (Unread)</button>
          </li>
          <li class="account-content__notifications__nav-btns-sort__dropdown-item">
            <button class="account-content__notifications__nav-btns-sort__dropdown-btn js-account__dropdown-filter-btn" type="button" data-filter="read" data-from="message">Read</button>
          </li>
          <li class="account-content__notifications__nav-btns-sort__dropdown-item">
            <button class="account-content__notifications__nav-btns-sort__dropdown-btn js-account__dropdown-filter-btn" type="button" data-filter="archived" data-from="message">Archived</button>
          </li>
        </ul>
      </div>
      <div class="account-content__notifications__nav-btns-sort__btn-wrap">
        <button class="account-content__dropdown-btn js-account__filter-btn" type="button" data-status="type">Type (All)
          <svg class="icon icon-arrow-down fill">
            <use href="/assets/themes/default/assets/icon/icons/icons.svg#arrow-down"></use>
          </svg>
        </button>
        <ul class="js-account__filter-list account-content__notifications__nav-btns-sort__dropdown-list" data-from="type">
          <li class="account-content__notifications__nav-btns-sort__dropdown-item">
            <button class="account-content__notifications__nav-btns-sort__dropdown-btn js-account__dropdown-filter-btn" type="button" data-filter="all" data-from="type">All</button>
          </li>
          <li class="account-content__notifications__nav-btns-sort__dropdown-item">
            <button class="account-content__notifications__nav-btns-sort__dropdown-btn js-account__dropdown-filter-btn" type="button" data-filter="System Message" data-from="type">System Messages</button>
          </li>
          <li class="account-content__notifications__nav-btns-sort__dropdown-item">
            <button class="account-content__notifications__nav-btns-sort__dropdown-btn js-account__dropdown-filter-btn" type="button" data-filter="Rewards Update" data-from="type">Rewards Updates</button>
          </li>
          <li class="account-content__notifications__nav-btns-sort__dropdown-item">
            <button class="account-content__notifications__nav-btns-sort__dropdown-btn js-account__dropdown-filter-btn" type="button" data-filter="Confirmed Booking" data-from="type">Confirmed Bookings</button>
          </li>
          <li class="account-content__notifications__nav-btns-sort__dropdown-item">
            <button class="account-content__notifications__nav-btns-sort__dropdown-btn js-account__dropdown-filter-btn" type="button" data-filter="Pending Booking" data-from="type">Pending Bookings</button>
          </li>
          <li class="account-content__notifications__nav-btns-sort__dropdown-item">
            <button class="account-content__notifications__nav-btns-sort__dropdown-btn js-account__dropdown-filter-btn" type="button" data-filter="Cancelled Booking" data-from="type">Cancelled Bookings</button>
          </li>
        </ul>
      </div>
    </div>
    <div class="account-content__notifications__nav-btns-action">
      <button class="account-content__notifications__nav-btns-action__btn blue js-account__action-btn" type="button" data-action="archive">Archive Message</button>
      <button class="account-content__notifications__nav-btns-action__btn red js-account__action-btn" type="button" data-action="delete">Delete Forever</button>
      <button class="account-content__notifications__nav-btns-action__btn blue js-account__action-btn" type="button" data-action="readAll">Mark all as read</button>
    </div>
  </div>
  <div class="account-content__notifications__content">
    <div class="account-content__notifications__content-heading">
      <div class="account-content__notifications__content-heading-item select">Select</div>
      <div class="account-content__notifications__content-heading-item message">Message(s)</div>
      <div class="account-content__notifications__content-heading-item type">Type</div>
      <div class="account-content__notifications__content-heading-item date">Date
        <button class="account-content__notifications__content-heading-item__btn-sort js-account__sort-by__btn" type="button" data-sort="date">
          <svg class="icon icon-account-sort fill">
            <use href="/assets/themes/default/assets/icon/icons/icons.svg#account-sort"></use>
          </svg>
        </button>
      </div>
    </div>
    <div class="account-content__notifications__content-body js-account__list-wrap">
      <?php 
      foreach($NotificationsList as $NotificationItem):
      ?>
      <div class="account-content__notifications__content-body-item js-account__item-to-filter <?=($NotificationItem->status<=1 ? 'no-read' : '')?>" 
            data-id="<?=$NotificationItem->id?>" 
            data-type="<?=$NotificationItem->type?>" 
            data-date="<?=$NotificationItem->created_at?>"
            data-message="<?=($NotificationItem->status<=1 ? 'unread' : 'read' )?>">
        <label class="account-content__notifications__content-body-item__checkbox-wrap">
          <input class="js-notifications-checkbox" type="checkbox" /><span class="rectangle"></span>
        </label>
        <div class="account-content__notifications__content-body-item__logo"> 
            <?php 
            $src = '/assets/themes/default/assets/svg/logo-icon.svg';
            if($NotificationItem->from_user_id!=0){
              $src = '/user/profile-avatar/'.$user->id.'?width=30&height=30';
            }
            ?>
            <img class="account-content__notifications__content-body-item__logo-img" src="<?=$src?>" alt="logo" />
        </div>
        <div class="account-content__notifications__content-body-item__text"><?=$NotificationItem->message?></div>
        <div class="account-content__notifications__content-body-item__type"><?=$NotificationItem->type?></div>
        <div class="account-content__notifications__content-body-item__date"><?=$NotificationItem->time_ago?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="global-pagination account-content__notifications__pagination">
    <?= $pager->links();?>
    <!-- <div class="global-pagination-navbar"><a class="global-pagination-arrow global-pagination-arrow-prev disable" href="#" aria-label="pagination previous link">
        <svg class="icon icon-arrow-left ">
          <use href="/assets/themes/default/assets/icon/icons/icons.svg#arrow-left"></use>
        </svg><span class="holder">Previous</span></a>
      <div class="global-pagination-pages"><a class="global-pagination-page pagination-page-active" href="#" aria-label="pagination page link">1</a><a class="global-pagination-page" href="#" aria-label="pagination page link">2</a><a class="global-pagination-page" href="#" aria-label="pagination page link">3</a>
      </div><a class="global-pagination-arrow global-pagination-arrow-next" href="#" aria-label="pagination next link"><span class="holder">Next</span>
        <svg class="icon icon-arrow-right ">
          <use href="/assets/themes/default/assets/icon/icons/icons.svg#arrow-right"></use>
        </svg></a>
    </div>
    <div class="global-pagination-preview">Showing 1 - 10 of 50</div> -->
  </div>
</div>

<?= $this->section('extra-js') ?>
<script>
  var notificationsFilterUrl = "<?= route_to("account/notifications/filter") ?>";
  var notificationsDeleteForeveUrl = "<?= route_to("notification/delete-forever") ?>";
</script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>