<?= $this->extend('Account/Account') ?>
<?= $this->section('account-content') ?>
<div class="account-content__notifications js-filter-section">
  <div class="account-content__notifications__title-wrap">
    <h3 class="account-content__main-title account-content__notifications__title">Offices</h3>
    
  </div>
  <?php 
    //d($NewNotifications);
    d($OfficesList);
  //  d($pager);
    ?>
    <div class="account-content__notifications__nav-btns-action">
      <a href="/offices/create/<?=$company_id?>" class="account-content__notifications__nav-btns-action__btn blue js-account__action-btn" type="button">Create new</a>
    </div>

  <div class="account-content__notifications__content">
    

    <div class="account-content__notifications__content-heading">
      <div class="account-content__notifications__content-heading-item select">Select</div>
      <div class="account-content__notifications__content-heading-item message">Office title</div>
      
    </div>
    <div class="account-content__notifications__content-body js-account__list-wrap">
      <?php 
      helper('App\Modules\User\Helpers\users');

      foreach($OfficesList as $OfficeItem):
      ?>
      <div class="account-content__notifications__content-body-item js-account__item-to-filter" 
            data-id="<?=$OfficeItem->id?>" >
        <label class="account-content__notifications__content-body-item__checkbox-wrap">
          <input class="js-notifications-checkbox" type="checkbox" /><span class="rectangle"></span>
        </label>
        <div class="account-content__notifications__content-body-item__logo"> 
            <?php 
            $src = '/assets/themes/default/assets/svg/logo-icon.svg';
            ?>
            <img class="account-content__notifications__content-body-item__logo-img" src="<?=$src?>" alt="logo" />
        </div>
        <div class="account-content__notifications__content-body-item__text">
          <a href="/offices/edit/<?=$OfficeItem->id?>"><?=$OfficeItem->office_title?> (Company: <?=$OfficeItem->company_registered_legal_name?>)</a>
          <span>Users: <?=getTotalUserInOffice($OfficeItem->id)?> <a href="/account/users-list/<?=$OfficeItem->id?>">View users list</a></span>
          <a href="/account/invite-users/<?=$OfficeItem->id?>">Invite Users</a>

        </div>
        
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="global-pagination account-content__notifications__pagination">
    <?= $pager->links();?>
  </div>
</div>

<?= $this->section('extra-js') ?>
<script>

</script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>