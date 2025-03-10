        <footer>
          <div class="container-fluid">
            <div class="row justify-content-between align-items-center">
              <div class="col ps-0">
                <div class="footer-links">
                  <a href="#" class="footer-link">Terms & Conditions</a>
                  <a href="#" class="footer-link">Privacy Policy</a>
                  <a href="#" class="footer-link">Cookie Policy</a>
                </div>
              </div>
              <div class="col d-flex justify-content-end pe-0">

                <picture class="footer-hippa__image">
                  <source srcset="/assets/themes/default/img/./content/footer-logo-1.webp" type="image/webp" class="footer-hippa__img " />
                  <img src="/assets/themes/default/img/./content/footer-logo-1.png" alt="img" class="footer-hippa__img " width="175"
                    height="60" />
                </picture>

              </div>
            </div>
          </div>
        </footer>
        
<!-- 
<?php 
    $user = auth()->user(); 
    if ($user): 
    ?>
                <script>
                    var notification_update_url = "<?= route_to("notification/update") ?>";
                    var notification_delete_url = "<?= route_to("notification/delete") ?>";

                    var streamer = "<?= route_to("streamer/get") ?>/?client_id=<?= $user->id ?>";
                </script>
            
                <div class="notifications-popover-dropdown">
                    <div class="notifications-popover-dropdown__header">
                        <div class="notifications-popover-dropdown__title"> <span class="holder">Notifications</span><span
                                class="value">(0)</span></div>
                        <div class="notifications-popover-dropdown__counter"><span class="value">0</span><span class="holder">New</span>
                        </div>
                        <button class="notifications-popover-dropdown__read-btn" type="button" aria-label="Mark all as read">Mark all as
                            read</button>
                    </div>
                    <div class="notifications-popover-dropdown__empty">There are no notifications for you to review</div>
                    <div class="notifications-popover-dropdown__list" data-simplebar data-simplebar-auto-hide="false"
                        data-simplebar-click-on-track="false" data-simplebar id="notification-list">
            
                    </div>
                    <div class="notifications-popover-dropdown__viewall"><a class="notifications-popover-dropdown__viewall-link"
                            href="/account/notifications">View All Notifications</a></div>
                </div>

    <?php
    endif;
    ?> -->