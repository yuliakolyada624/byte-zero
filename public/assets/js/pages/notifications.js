
(function ($) {

   // let counter = 0;

    function sse() {
        if(typeof streamer === 'undefined' ){
            console.log("Notifications: Error! streamer is not defined");
            return;
        }
        let eventSource;
        eventSource = new EventSource(streamer);

        eventSource.onopen = function (e) {
            console.log("eventSource: connection opened");
        };

        eventSource.onerror = function (e) {
            console.log("eventSource: enddata or error occurred");
            if (this.readyState == EventSource.CONNECTING) {
                console.log(`eventSource: reconnecting (readyState=${this.readyState})...`);
            } else {
                console.log("eventSource: connection failed");
            }
        };



        const Item = ({ id, title, message, time_ago, from_user_id, status, link, status_class }) => `
                    <div class="notifications-popover-dropdown__message ${status_class} ${status}" 
                        id="notification-item-${id}" data-id="${id}" data-status="${status}"
                        data-href="${link}"
                        >
                        <div class="notifications-popover-dropdown__account">
                            <picture class="notifications-popover-dropdown-account__image">
                                <source class="notifications-popover-dropdown-account__img" srcset="/assets/themes/default/assets/img/content/message-user.webp" type="image/webp" /><img class="notifications-popover-dropdown-account__img" src="/user/profile-avatar/${from_user_id}?width=32&height=32" alt="img" width="45" height="45" />
                            </picture>

                        </div>
                        <div class="notifications-popover-dropdown__info">
                            <button class="notifications-popover-dropdown__remove-message" type="button" aria-label="Message close btn">
                                <svg class="icon icon-close-message ">
                                    <use href="/assets/themes/default/assets/icon/icons/icons.svg#close-message"></use>
                                </svg>
                            </button>
                            <div class="notifications-popover-dropdown__message-text">${message}</div>
                            <div class="notifications-popover-dropdown__message-footer">
                                <div class="notifications-popover-dropdown__message-category">${title}</div>
                                <div class="notifications-popover-dropdown__message-time">${time_ago}</div>
                            </div>
                        </div>
                    </div>
        `;

        eventSource.onmessage = function (e) {
           // console.log(e);
            console.log("eventSource: " + e.data);

            

             //Count only unread status 0 and 1
             let eData = JSON.parse(e.data);
             eData.status_class = '';
             if (eData.status == 1 || eData.status == 0) {
               //  counter++;
                 eData.status_class = 'unread-message';
             }

            $('#notification-list').prepend([
                eData
            ].map(Item).join(''));

            console.log("id: " + e.lastEventId);
            
            //console.log(' counter = ' + counter);
         

            //$("#nCnt").html(counter);
         //   bindNClick();
            if (e.data == 'done') {
                this.close();
                console.log("eventSource: server is done");
            }
        };

        // secure
        /*eventSource.addEventListener('message', function(e) {
            if (e.origin != 'http://example.com') {
            alert('Origin was not http://example.com');
            return;
            }
        }, false);
        */
    }
    /*
    function bindNClick() {
        $('.notification-item').unbind('click');

        $(".notification-item").on('click', function () {
            let nItem = $(this);
            let id = nItem.data("id");
            console.log("id = " + id);

            let vals = "id=" + id + "&status=2";

            $.ajax({
                type: "POST",
                url: notification_update_url,
                data: (vals),
                success: function (r) {
                    if (r.success) {
                        console.log('nItem status = '+nItem.data('status'));
                        if(nItem.data('status')<=1){
                            counter = counter - 1;
                            if (counter < 0) { counter = 0 };
                            $("#nCnt").html(counter);
                            nItem.find('.n-status-'+nItem.data('status')).remove();
                        }
                       // nItem.remove();
                    } else {
                        console.log(r.errors);
                        alert('error while saving data');
                    }
                },
                error: function () {
                    alert('error while saving data');
                }
            });
        });

        $('.notification-delete').unbind('click');

        $(".notification-delete").on('click', function (event) {
            
            let nItem = $(this).closest('a.notification-item');
            nItem.unbind('click');
            let id = nItem.data("id");
            //console.log("delete id = " + id);

            let vals = "id=" + id;

            $.ajax({
                type: "POST",
                url: notification_delete_url,
                data: (vals),
                success: function (r) {
                    if (r.success) {
                        if(nItem.data('status')<=1){
                            counter = counter - 1;
                            if (counter < 0) { counter = 0 };
                            $("#nCnt").html(counter);
                        }
                        nItem.remove();
                    } else {
                        console.log(r.errors);
                        alert('error while deleteting data');
                    }
                },
                error: function () {
                    alert('error while deleteting data');
                }
            });
        });

    }*/


    /* read all */
   /* $("#notify-read-all").on('click', function () {
        $(".notification-item").each(function () {
            let nItem = $(this);
            let id = nItem.data("id");
            //console.log("id = " + id);

            let vals = "id=" + id + "&status=2";

            $.ajax({
                type: "POST",
                url: notification_update_url,
                data: (vals),
                success: function (r) {
                    //console.log(r);
                    if (r.success) {
                        if(nItem.data('status')<=1){
                            counter = counter - 1;
                            if (counter < 0) { counter = 0 };
                            $("#nCnt").html(counter);
                            nItem.find('.n-status-'+nItem.data('status')).remove();
                        }
                    } else {
                        console.log(r.errors);
                        alert('error while saving data');
                    }
                },
                error: function () {
                    alert('error while saving data');
                }
            });
        });
    });*/


    function init() {
        sse();
    }

    init();

})($)
